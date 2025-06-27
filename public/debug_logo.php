<?php
// Debug script to check logo accessibility
echo "<h2>Logo Debug Information</h2>";

// Check if file exists
$logoPath = __DIR__ . '/main-logo.png';
echo "<p><strong>File exists:</strong> " . (file_exists($logoPath) ? 'YES' : 'NO') . "</p>";

if (file_exists($logoPath)) {
    echo "<p><strong>File size:</strong> " . filesize($logoPath) . " bytes</p>";
    echo "<p><strong>File permissions:</strong> " . substr(sprintf('%o', fileperms($logoPath)), -4) . "</p>";
    echo "<p><strong>Is readable:</strong> " . (is_readable($logoPath) ? 'YES' : 'NO') . "</p>";
    echo "<p><strong>Owner/Group:</strong> " . posix_getpwuid(fileowner($logoPath))['name'] . ":" . posix_getgrgid(filegroup($logoPath))['name'] . "</p>";
}

// Check different URL paths
$baseUrl = (isset($_SERVER['HTTPS']) && $_SERVER['HTTPS'] === 'on' ? "https" : "http") . "://$_SERVER[HTTP_HOST]";
echo "<p><strong>Base URL:</strong> $baseUrl</p>";

$paths = [
    '/main-logo.png',
    '/public/main-logo.png',
    '/storage/main-logo.png',
    '/assets/main-logo.png'
];

echo "<h3>Testing different URL paths:</h3>";
foreach ($paths as $path) {
    $fullUrl = $baseUrl . $path;
    echo "<div style='margin-bottom: 10px;'>";
    echo "<p><strong>Testing:</strong> $fullUrl</p>";
    echo "<img src='$path' style='height:50px; border: 1px solid #ccc; padding: 5px;' onerror=\"this.style.display='none'; this.nextSibling.style.display='inline';\" />";
    echo "<span style='display:none; color:red;'>❌ Failed to load</span>";
    
    // Try to get headers
    $headers = @get_headers($fullUrl);
    if ($headers) {
        echo "<br><small style='color:gray;'>Status: " . $headers[0] . "</small>";
    }
    echo "</div>";
}

// Show current directory structure
echo "<h3>Current directory contents:</h3>";
echo "<pre style='background:#f5f5f5; padding:10px; border-radius:5px;'>";
echo "Current directory (" . __DIR__ . "):\n";
$files = scandir(__DIR__);
foreach ($files as $file) {
    if ($file !== '.' && $file !== '..') {
        $perms = substr(sprintf('%o', fileperms(__DIR__ . '/' . $file)), -4);
        echo sprintf("%-30s [%s]\n", $file, $perms);
    }
}
echo "</pre>";

// Check Apache/Nginx configuration
echo "<h3>Server Information:</h3>";
echo "<pre style='background:#f5f5f5; padding:10px; border-radius:5px;'>";
echo "Server Software: " . $_SERVER['SERVER_SOFTWARE'] . "\n";
echo "Document Root: " . $_SERVER['DOCUMENT_ROOT'] . "\n";
echo "Script Filename: " . $_SERVER['SCRIPT_FILENAME'] . "\n";
echo "</pre>";
