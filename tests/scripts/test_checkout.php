<?php

// Load .env variables for CLI
$dotenvPath = __DIR__ . '/../../.env';
if (file_exists($dotenvPath)) {
    $lines = file($dotenvPath, FILE_IGNORE_NEW_LINES | FILE_SKIP_EMPTY_LINES);
    foreach ($lines as $line) {
        if (strpos(trim($line), '#') === 0) {
            continue;
        }
        list($name, $value) = array_map('trim', explode('=', $line, 2));
        if (!array_key_exists($name, $_SERVER) && !array_key_exists($name, $_ENV)) {
            putenv(sprintf('%s=%s', $name, $value));
            $_ENV[$name] = $value;
            $_SERVER[$name] = $value;
        }
    }
}

echo "=== PayGate Integration Test - Multiple Links Generator ===\n\n";

$secret = getenv('CHECKOUT_SECRET');

if (!$secret) {
    echo "ERROR: CHECKOUT_SECRET environment variable is not set. Please set it to your checkout secret.\n";
    exit(1);
}

function generateRandomAmount($min = 50, $max = 200) {
    return number_format(mt_rand($min * 100, $max * 100) / 100, 2);
}

function generateRandomBookingId() {
    return 'BOOK' . mt_rand(1000000, 9999999);
}

function generateRandomUserId() {
    return 'U' . mt_rand(1000, 9999);
}

function generateRandomUserName() {
    $firstNames = ['John', 'Jane', 'Alice', 'Bob', 'Charlie', 'Diana', 'Eve', 'Frank'];
    $lastNames = ['Doe', 'Smith', 'Johnson', 'Williams', 'Brown', 'Jones', 'Miller', 'Davis'];
    return $firstNames[array_rand($firstNames)] . ' ' . $lastNames[array_rand($lastNames)];
}

function generateRandomUserEmail($name) {
    $domains = ['example.com', 'test.com', 'mail.com', 'demo.com'];
    $emailName = strtolower(str_replace(' ', '.', $name));
    return $emailName . '@' . $domains[array_rand($domains)];
}

$numberOfLinks = 5; // Number of links to generate per run

for ($i = 0; $i < $numberOfLinks; $i++) {
    $userName = generateRandomUserName();
    $data = [
        'booking_id' => generateRandomBookingId(),
        'user_id' => generateRandomUserId(),
        'user_name' => $userName,
        'user_email' => generateRandomUserEmail($userName),
        'amount' => generateRandomAmount(),
        'currency' => 'USD',
    ];

    $base = "{$data['booking_id']}|{$data['user_id']}|{$data['amount']}|{$data['currency']}";
    $signature = hash_hmac('sha256', $base, $secret);

    $query = http_build_query(array_merge($data, ['signature' => $signature]));
    $url = "https://checkout.harmostays.com/checkout?$query";

    echo "Link " . ($i + 1) . ":\n";
    echo "Booking ID: {$data['booking_id']}\n";
    echo "User ID: {$data['user_id']}\n";
    echo "User Name: {$data['user_name']}\n";
    echo "User Email: {$data['user_email']}\n";
    echo "Amount: \${$data['amount']}\n";
    echo "Currency: {$data['currency']}\n";
    echo "Signature: $signature\n";
    echo "Payment URL: $url\n\n";
}
