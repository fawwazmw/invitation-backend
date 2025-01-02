<?php

// public/index.php

// Check for static assets (CSS/JS files)
if (preg_match('/^(css|js)\/(.*)$/', $_SERVER['REQUEST_URI'], $matches)) {
    $assetType = $matches[1]; // 'css' or 'js'
    $assetFile = $matches[2]; // File path (e.g., 'app.css')

    // Define the asset folder based on the type (css or js)
    $assetPath = __DIR__ . "/$assetType/$assetFile";

    // Check if the file exists
    if (file_exists($assetPath)) {
        // Serve the asset with appropriate headers
        $ext = pathinfo($assetFile, PATHINFO_EXTENSION);

        // Set content type based on file extension
        if ($ext === 'css') {
            header('Content-Type: text/css');
        } elseif ($ext === 'js') {
            header('Content-Type: application/javascript');
        }

        // Cache for 1 day
        header('Cache-Control: public, max-age=86400, immutable');

        // Output the file contents
        readfile($assetPath);
        exit; // Ensure no further processing after serving asset
    }
}

// Continue normal handling for API routes
require_once __DIR__ . '/../vendor/autoload.php';
\Core\Kernel\Kernel::web(new \App\Kernel())->run();
