<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\Payment;
use Illuminate\Support\Facades\Http;

class PaymentController extends Controller
{
    /**
     * Show the form to generate a new payment/booking.
     */
    public function create()
    {
        return view('payments.create');
    }

    /**
     * Handle the form submission and create the payment/booking.
     */
    public function store(Request $request)
    {
        $validated = $request->validate([
            'property_name' => 'required|string|max:255',
            'customer_name' => 'required|string|max:255',
            'customer_email' => 'required|email|max:255',
            'booking_details' => 'required|string',
            'price' => 'required|numeric|min:0',
            'currency' => 'required|in:USD,KES,USDC',
        ]);

        $bookingId = strtoupper(uniqid('BOOK'));

        $bookingId = strtoupper(uniqid('BOOK'));

        // 1. Create Wallet via PayGate API
        $publicUrl = env('APP_PUBLIC_URL', env('APP_URL'));
        $callbackUrl = $publicUrl . '/paygate/callback/' . $bookingId;

        $walletResponse = Http::get('https://api.paygate.to/control/wallet.php', [
            'address' => env('PAYGATE_USDC_WALLET'), // Your payout wallet
            'callback' => $callbackUrl,
        ]);

        if ($walletResponse->failed()) {
            return back()->withErrors('Failed to create a payment wallet. Please try again.');
        }

        $walletData = $walletResponse->json();
        $tempAddress = $walletData['address_in'];
        $ipnToken = $walletData['ipn_token'];

        // 2. Create the Payment Record
        $payment = Payment::create([
            'booking_id' => $bookingId,
            'user_id' => auth()->id(),
            'property_name' => $validated['property_name'],
            'customer_name' => $validated['customer_name'],
            'customer_email' => $validated['customer_email'],
            'booking_details' => $validated['booking_details'],
            'amount' => $validated['price'],
            'currency' => $validated['currency'],
            'status' => 'pending',
            'ipn_token' => $ipnToken,
        ]);

        // 3. Redirect to PayGate Checkout
        $checkoutUrl = 'https://checkout.paygate.to/pay.php';
        
        // Manually build the query string to prevent double-encoding the address
        $queryString = http_build_query([
            'amount' => $validated['price'],
            'email' => $validated['customer_email'],
            'currency' => $validated['currency'],
        ]);

        return redirect($checkoutUrl . '?address=' . $tempAddress . '&' . $queryString);
    }

    /**
     * Handle the payment callback from PayGate.
     */
    public function callback(Request $request, $booking_id)
    {
        $payment = Payment::where('booking_id', $booking_id)->firstOrFail();

        // Security Check: Verify the IPN token
        if ($request->ipn_token !== $payment->ipn_token) {
            return response('Invalid IPN token.', 400);
        }

        if ($request->status === 'paid') {
            $payment->status = 'paid';
            $payment->paid_at = now();
            $payment->payment_transaction_id = $request->txid_in; // Or txid_out, as needed
            $payment->save();
            return view('payments.success', compact('payment'));
        } else {
            $payment->status = 'failed';
            $payment->save();
            return view('payments.failed', compact('payment'));
        }
    }

    /**
     * Show the user's payment/booking history.
     */
    public function index()
    {
        $payments = Payment::where('user_id', auth()->id())
            ->orderByDesc('created_at')
            ->get();
        return view('payments.index', compact('payments'));
    }

    /**
     * Show the simulated payment page.
     */
    public function simulate($booking_id)
    {
        $payment = Payment::where('booking_id', $booking_id)
            ->where('user_id', auth()->id())
            ->firstOrFail();
        return view('payments.simulate', compact('payment'));
    }

    /**
     * Simulate a successful payment.
     */
    public function simulatePay($booking_id)
    {
        $payment = Payment::where('booking_id', $booking_id)
            ->where('user_id', auth()->id())
            ->firstOrFail();

        if ($payment->status === 'pending') {
            $payment->status = 'paid';
            $payment->paid_at = now();
            $payment->payment_transaction_id = strtoupper(uniqid('TXN'));
            $payment->save();
        }

        return view('payments.success', compact('payment'));
    }

    /**
     * Simulate a failed payment.
     */
    public function simulateFail($booking_id)
    {
        $payment = Payment::where('booking_id', $booking_id)
            ->where('user_id', auth()->id())
            ->firstOrFail();

        if ($payment->status === 'pending') {
            $payment->status = 'failed';
            $payment->save();
        }

        return view('payments.failed', compact('payment'));
    }

    /**
     * Show the payment receipt.
     */
    public function receipt($booking_id)
    {
        $payment = Payment::where('booking_id', $booking_id)
            ->where('status', 'paid')
            ->firstOrFail();

        // Authorize: only the user who made the payment or an admin can view it
        $this->authorize('view', $payment);

        return view('payments.receipt', compact('payment'));
    }
}
