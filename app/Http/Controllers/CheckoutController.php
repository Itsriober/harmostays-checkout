<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Log;
use App\Models\Transaction;
use App\Helpers\PaygateHelper;

class CheckoutController extends Controller
{
    public function show(Request $request)
    {
        $data = $request->only(['booking_id', 'user_id', 'user_name', 'user_email', 'amount', 'currency', 'signature']);
        if (!$this->verifySignature($data)) {
            Log::warning('Invalid signature', $data);
            abort(403, 'Invalid signature');
        }
        return view('checkout', $data);
    }

    public function startPayment(Request $request)
    {
        $validated = $request->validate([
            'booking_id' => 'required',
            'user_id' => 'required',
            'user_name' => 'required',
            'user_email' => 'required|email',
            'amount' => 'required|numeric|min:1',
            'currency' => 'required',
            'signature' => 'required',
        ]);
        if (!$this->verifySignature($validated)) {
            Log::warning('Invalid signature on start-payment', $validated);
            abort(403, 'Invalid signature');
        }

        $transaction = Transaction::create([
            'booking_id' => $validated['booking_id'],
            'user_id' => $validated['user_id'],
            'amount' => $validated['amount'],
            'currency' => $validated['currency'],
            'status' => 'pending',
        ]);

        $callbackUrl = route('checkout.paygateCallback', [], true);
        $paygateWallet = '0x6734be2F7C16de208483453DC64588C3c856ee0D'; // Your new Polygon USDC wallet
        
        Log::info('Starting PayGate wallet creation', [
            'callback_url' => $callbackUrl,
            'wallet_address' => $paygateWallet,
            'transaction_id' => $transaction->id
        ]);
        
        $walletResp = PaygateHelper::createWallet($callbackUrl, $paygateWallet);
        
        if (!$walletResp['success'] || $walletResp['status'] !== 200) {
            Log::error('PayGate wallet API error', [
                'response' => $walletResp,
                'transaction_id' => $transaction->id
            ]);
            
            $errorMsg = 'Payment gateway error: ';
            if (isset($walletResp['error'])) {
                $errorMsg .= $walletResp['error'];
            } else {
                $errorMsg .= $walletResp['raw'] ?? 'Unknown error';
            }
            
            return view('redirecting', [
                'paygateUrl' => null, 
                'errorMsg' => $errorMsg,
                'debugInfo' => [
                    'status' => $walletResp['status'],
                    'raw_response' => $walletResp['raw']
                ]
            ]);
        }
        
        if (!isset($walletResp['data']['address_in'], $walletResp['data']['ipn_token'])) {
            Log::error('PayGate wallet API missing required fields', [
                'response' => $walletResp,
                'transaction_id' => $transaction->id
            ]);
            
            $errorMsg = 'Payment gateway error: Missing required fields in response (address_in or ipn_token)';
            return view('redirecting', [
                'paygateUrl' => null, 
                'errorMsg' => $errorMsg,
                'debugInfo' => [
                    'available_fields' => array_keys($walletResp['data'] ?? []),
                    'raw_response' => $walletResp['raw']
                ]
            ]);
        }
        $encryptedAddress = $walletResp['data']['address_in'];
        $ipnToken = $walletResp['data']['ipn_token'];

        $transaction->ipn_token = $ipnToken;
        $transaction->save();

        // The address_in from PayGate is already URL-encoded, so we need to handle it carefully
        // to avoid double encoding
        // Using pay.php instead of process-payment.php as recommended by PayGate support
        $paygateUrl = 'https://checkout.paygate.to/pay.php?' . http_build_query([
            'amount' => $validated['amount'],
            'provider' => 'moonpay',
            'email' => $validated['user_email'],
            'currency' => $validated['currency'],
        ]) . '&address=' . $encryptedAddress; // Add address separately to avoid double encoding

        return view('redirecting', ['paygateUrl' => $paygateUrl]);
    }

    public function paygateCallback(Request $request)
    {
        Log::info('PayGate callback received', $request->all());
        
        // Extract callback parameters according to PayGate documentation
        $ipnToken = $request->query('ipn_token');
        $txidIn = $request->query('txid_in');
        $txidOut = $request->query('txid_out');
        $addressIn = $request->query('address_in');
        $valueCoin = $request->query('value_coin');
        $coin = $request->query('coin'); // Added according to documentation
        
        // Validate required parameters
        if (!$ipnToken) {
            Log::error('PayGate callback: missing ipn_token', $request->all());
            abort(400, 'Missing ipn_token parameter');
        }

        $transaction = Transaction::where('ipn_token', $ipnToken)->first();
        if (!$transaction) {
            Log::error('PayGate callback: transaction not found', [
                'ipn_token' => $ipnToken,
                'all_params' => $request->all()
            ]);
            abort(404, 'Transaction not found');
        }

        // Update transaction with payment details
        $transaction->status = 'paid';
        $transaction->txid_in = $txidIn;
        $transaction->txid_out = $txidOut;
        
        // Store additional payment information
        if ($valueCoin) {
            $transaction->amount_paid = $valueCoin;
        }
        if ($coin) {
            $transaction->payment_coin = $coin;
        }
        if ($addressIn) {
            $transaction->payment_address = $addressIn;
        }
        
        $transaction->save();

        Log::info('PayGate callback processed successfully', [
            'transaction_id' => $transaction->id,
            'booking_id' => $transaction->booking_id,
            'amount_paid' => $valueCoin,
            'coin' => $coin
        ]);

        $redirectUrl = 'https://test.harmostays.com/checkout-callback?' . http_build_query([
            'status' => 'success',
            'booking_id' => $transaction->booking_id,
            'amount_paid' => $valueCoin,
            'transaction_id' => $transaction->id,
        ]);
        
        return redirect($redirectUrl);
    }

    private function verifySignature($data)
    {
        $secret = env('CHECKOUT_SECRET');
        $base = "{$data['booking_id']}|{$data['user_id']}|{$data['amount']}|{$data['currency']}";
        $expected = hash_hmac('sha256', $base, $secret);
        return hash_equals($expected, $data['signature'] ?? '');
    }
}
