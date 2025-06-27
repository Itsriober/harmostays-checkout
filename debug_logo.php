<?php
// Debug script to check logo accessibility
echo "<h2>Logo Debug Information</h2>";

// Check if file exists
$logoPath = __DIR__ . '/public/main-logo.png';
echo "<p><strong>File exists:</strong> " . (file_exists($logoPath) ? 'YES' : 'NO') . "</p>";

if (file_exists($logoPath)) {
    echo "<p><strong>File size:</strong> " . filesize($logoPath) . " bytes</p>";
    echo "<p><strong>File permissions:</strong> " . substr(sprintf('%o', fileperms($logoPath)), -4) . "</p>";
    echo "<p><strong>Is readable:</strong> " . (is_readable($logoPath) ? 'YES' : 'NO') . "</p>";
}

// Check different URL paths
$baseUrl = (isset($_SERVER['HTTPS']) && $_SERVER['HTTPS'] === 'on' ? "https" : "http") . "://$_SERVER[HTTP_HOST]";
$paths = [
    $baseUrl . '/main-logo.png',
    $baseUrl . '/public/main-logo.png',
    './main-logo.png',
    './public/main-logo.png'
];

echo "<h3>Testing different URL paths:</h3>";
foreach ($paths as $path) {
    echo "<p><strong>$path:</strong> ";
    echo "<img src='$path' style='height:50px;' onerror=\"this.style.display='none'; this.nextSibling.style.display='inline';\" />";
    echo "<span style='display:none; color:red;'>❌ Failed to load</span>";
    echo "</p>";
}

// Show current directory structure
echo "<h3>Current directory contents:</h3>";
echo "<pre>";
if (is_dir('./public')) {
    echo "public/ directory contents:\n";
    $files = scandir('./public');
    foreach ($files as $file) {
        if ($file !== '.' && $file !== '..') {
            echo "  $file\n";
        }
    }
} else {
    echo "public/ directory not found\n";
}
echo "</pre>";
?>
