<?php

require __DIR__.'/../../vendor/autoload.php';

$dotenv = Dotenv\Dotenv::createImmutable(__DIR__.'/../../');
$dotenv->load();

use App\Helpers\PaygateHelper;

echo "=== PayGate Direct API Test ===\n\n";

// Use the new Polygon USDC wallet address
$paygateWallet = '0x6734be2F7C16de208483453DC64588C3c856ee0D';
echo "✅ NEW POLYGON USDC WALLET: $paygateWallet\n\n";

// Test callback URL
$callbackUrl = 'https://test.harmostays.com/paygate/callback?test_param=123456';
echo "📞 Callback URL: $callbackUrl\n\n";

echo "🔄 Testing PayGate wallet creation...\n";
echo "-----------------------------------\n";

// Test the API call
$result = PaygateHelper::createWallet($callbackUrl, $paygateWallet);

echo "Status Code: " . $result['status'] . "\n";
echo "Success: " . ($result['success'] ? 'YES' : 'NO') . "\n";
echo "Raw Response: " . $result['raw'] . "\n\n";

if ($result['success']) {
    echo "✅ SUCCESS! Wallet created successfully\n\n";
    
    echo "Response Data:\n";
    echo "- address_in: " . ($result['data']['address_in'] ?? 'NOT SET') . "\n";
    echo "- polygon_address_in: " . ($result['data']['polygon_address_in'] ?? 'NOT SET') . "\n";
    echo "- callback_url: " . ($result['data']['callback_url'] ?? 'NOT SET') . "\n";
    echo "- ipn_token: " . ($result['data']['ipn_token'] ?? 'NOT SET') . "\n\n";
    
    // Test payment status check if we have an IPN token
    if (isset($result['data']['ipn_token'])) {
        echo "🔄 Testing payment status check...\n";
        echo "-----------------------------------\n";
        
        $statusResult = PaygateHelper::checkPaymentStatus($result['data']['ipn_token']);
        echo "Status Check Result:\n";
        echo "- Status Code: " . $statusResult['status'] . "\n";
        echo "- Success: " . ($statusResult['success'] ? 'YES' : 'NO') . "\n";
        echo "- Raw Response: " . $statusResult['raw'] . "\n\n";
        
        if ($statusResult['success'] && isset($statusResult['data']['status'])) {
            echo "Payment Status: " . $statusResult['data']['status'] . "\n";
        }
    }
    
    // Generate test payment URL
    echo "🔗 Test Payment URL:\n";
    echo "-----------------------------------\n";
    $testPaymentUrl = 'https://checkout.paygate.to/pay.php?' . http_build_query([
        'amount' => '10.00',
        'provider' => 'moonpay',
        'email' => 'test@harmostays.com',
        'currency' => 'USD',
    ]) . '&address=' . $result['data']['address_in'];
    echo $testPaymentUrl . "\n\n";
    echo "💡 You can copy this URL to test the payment flow manually\n";
    echo "📝 Note: Using pay.php endpoint as recommended by PayGate support for regional compatibility\n";
    
} else {
    echo "❌ FAILED! Error details:\n";
    if (isset($result['error'])) {
        echo "Error: " . $result['error'] . "\n";
    }
    echo "Raw Response: " . $result['raw'] . "\n";
    
    echo "\n🔍 Troubleshooting:\n";
    echo "1. Check if PAYGATE_USDC_WALLET is a valid USDC (Polygon) address\n";
    echo "2. Verify internet connection\n";
    echo "3. Check if PayGate API is accessible\n";
    echo "4. Review the raw response for specific error messages\n";
}

echo "\n=== Test Complete ===\n";
