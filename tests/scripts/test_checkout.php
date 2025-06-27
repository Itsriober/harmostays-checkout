<?php

echo "=== PayGate Integration Test ===\n\n";

// Test Data
$data = [
    'booking_id' => 'TEST1751016287',
    'user_id' => 'U4233',
    'user_name' => 'Test User',
    'user_email' => 'test@example.com',
    'amount' => '100.00',
    'currency' => 'USD',
];

// Generate signature
$secret = getenv('CHECKOUT_SECRET') ?: 'your_checkout_secret_here';
$base = "{$data['booking_id']}|{$data['user_id']}|{$data['amount']}|{$data['currency']}";
$signature = hash_hmac('sha256', $base, $secret);

echo "Test Data:\n";
print_r($data);
echo "\nSignature: $signature\n\n";

$query = http_build_query(array_merge($data, ['signature' => $signature]));
$url = "http://localhost:8001/checkout?$query";

echo "Test URL:\n$url\n\n";

echo "Instructions:\n";
echo "1. Make sure your Laravel server is running (php artisan serve)\n";
echo "2. Copy and paste the URL above into your browser\n";
echo "3. You should see the checkout page with the test data\n";
echo "4. The 'Pay with PayGate' button should work if your PAYGATE_USDC_WALLET is set correctly\n";
