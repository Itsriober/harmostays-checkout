<?php

require __DIR__ . '/../../vendor/autoload.php';

use App\Helpers\PaygateHelper;

$bookingId = 12345;
$userId = 67890;
$userEmail = 'testuser@example.com';
$amount = 10.00;
$currency = 'USDC';

// Callback URL for IPN (adjust as needed)
$callbackUrl = 'https://checkout.harmostays.com/paygate/callback';

// PayGate wallet address from env or hardcoded for test
$paygateWallet = getenv('PAYGATE_USDC_WALLET') ?: '0x6734be2F7C16de208483453DC64588C3c856ee0D';

echo "Generating PayGate payment link...\n";

$walletResp = PaygateHelper::createWallet($callbackUrl, $paygateWallet);

if ($walletResp['status'] !== 200 || !isset($walletResp['data']['address_in'], $walletResp['data']['ipn_token'])) {
    echo "Error creating wallet: " . $walletResp['raw'] . "\n";
    exit(1);
}

$encryptedAddress = $walletResp['data']['address_in'];
$ipnToken = $walletResp['data']['ipn_token'];

$paygateUrl = 'https://checkout.paygate.to/process-payment.php?' . http_build_query([
    'address' => $encryptedAddress,
    'amount' => $amount,
    'provider' => 'moonpay',
    'email' => $userEmail,
    'currency' => $currency,
]);

echo "PayGate Payment URL:\n$paygateUrl\n";
echo "IPN Token:\n$ipnToken\n";
echo "Use this URL to test the payment flow.\n";
