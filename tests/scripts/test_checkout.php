<?php

require __DIR__.'/../../vendor/autoload.php';

$dotenv = Dotenv\Dotenv::createImmutable(__DIR__.'/../../');
$dotenv->load();

// Test data
$testData = [
    'booking_id' => 'TEST' . time(),
    'user_id' => 'U' . rand(1000, 9999),
    'user_name' => 'Test User',
    'user_email' => 'test@example.com',
    'amount' => '100.00',
    'currency' => 'USD'
];

// Generate signature
$secret = $_ENV['CHECKOUT_SECRET'];
$base = "{$testData['booking_id']}|{$testData['user_id']}|{$testData['amount']}|{$testData['currency']}";
$signature = hash_hmac('sha256', $base, $secret);

// Build test URL
$params = array_merge($testData, ['signature' => $signature]);
$url = 'http://localhost:8001/checkout?' . http_build_query($params);

echo "=== PayGate Integration Test ===\n\n";
echo "Test Data:\n";
print_r($testData);
echo "\nSignature: $signature\n\n";
echo "Test URL:\n$url\n\n";
echo "Instructions:\n";
echo "1. Make sure your Laravel server is running (php artisan serve)\n";
echo "2. Copy and paste the URL above into your browser\n";
echo "3. You should see the checkout page with the test data\n";
echo "4. The 'Pay with PayGate' button should work if your PAYGATE_USDC_WALLET is set correctly\n\n";
