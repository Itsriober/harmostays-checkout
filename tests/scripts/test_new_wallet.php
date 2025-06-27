<?php

require __DIR__.'/../../vendor/autoload.php';

use App\Helpers\PaygateHelper;

echo "=== Testing New Polygon USDC Wallet ===\n\n";

// Your new Polygon USDC wallet address
$newWallet = '0x6734be2F7C16de208483453DC64588C3c856ee0D';
echo "✅ New Polygon USDC Wallet: $newWallet\n\n";

// Test callback URL
$callbackUrl = 'https://test.harmostays.com/paygate/callback?test_param=123456';
echo "📞 Callback URL: $callbackUrl\n\n";

echo "🔄 Testing PayGate wallet creation with new address...\n";
echo "---------------------------------------------------\n";

// Test the API call with new wallet
$result = PaygateHelper::createWallet($callbackUrl, $newWallet);

echo "Status Code: " . $result['status'] . "\n";
echo "Success: " . ($result['success'] ? 'YES' : 'NO') . "\n";
echo "Raw Response: " . $result['raw'] . "\n\n";

if ($result['success']) {
    echo "✅ SUCCESS! New wallet address is accepted by PayGate!\n\n";
    
    echo "Response Data:\n";
    echo "- address_in: " . ($result['data']['address_in'] ?? 'NOT SET') . "\n";
    echo "- polygon_address_in: " . ($result['data']['polygon_address_in'] ?? 'NOT SET') . "\n";
    echo "- callback_url: " . ($result['data']['callback_url'] ?? 'NOT SET') . "\n";
    echo "- ipn_token: " . ($result['data']['ipn_token'] ?? 'NOT SET') . "\n\n";
    
    // Generate test payment URL
    echo "🔗 Test Payment URL:\n";
    echo "-----------------------------------\n";
    $testPaymentUrl = 'https://checkout.paygate.to/process-payment.php?' . http_build_query([
        'address' => $result['data']['address_in'],
        'amount' => '10.00',
        'provider' => 'moonpay',
        'email' => 'test@harmostays.com',
        'currency' => 'USD',
    ]);
    echo $testPaymentUrl . "\n\n";
    echo "💡 You can copy this URL to test the payment flow manually\n";
    
} else {
    echo "❌ FAILED! Error details:\n";
    if (isset($result['error'])) {
        echo "Error: " . $result['error'] . "\n";
    }
    echo "Raw Response: " . $result['raw'] . "\n";
    
    if (strpos($result['raw'], 'not allowed') !== false) {
        echo "\n🔍 Wallet Address Issue:\n";
        echo "The wallet address might need to be:\n";
        echo "1. A valid USDC contract address on Polygon\n";
        echo "2. Pre-registered with PayGate\n";
        echo "3. Have proper permissions set\n";
    }
}

echo "\n=== Test Complete ===\n";
