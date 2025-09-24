<?php
/**
 * PHP Built-in Server Router for Rhymix
 */

// Handle static files - MOST IMPORTANT
$uri = urldecode($_SERVER['REQUEST_URI']);
$path = __DIR__ . $uri;

// Remove query string for file check
if (strpos($uri, '?') !== false) {
    $path = __DIR__ . substr($uri, 0, strpos($uri, '?'));
}

// If it's a real file, serve it directly (but not PHP files)
if (file_exists($path) && is_file($path)) {
    // Never serve PHP files directly
    $ext = pathinfo($path, PATHINFO_EXTENSION);
    if ($ext === 'php') {
        // PHP files should be executed, not served as static files
        require_once __DIR__ . '/index.php';
        return;
    }
    
    // Set proper MIME types for static files
    switch($ext) {
        case 'css':
            header('Content-Type: text/css');
            break;
        case 'js':
            header('Content-Type: application/javascript');
            break;
        case 'jpg':
        case 'jpeg':
            header('Content-Type: image/jpeg');
            break;
        case 'png':
            header('Content-Type: image/png');
            break;
        case 'gif':
            header('Content-Type: image/gif');
            break;
        case 'svg':
            header('Content-Type: image/svg+xml');
            break;
        case 'ico':
            header('Content-Type: image/x-icon');
            break;
        case 'apk':
            header('Content-Type: application/vnd.android.package-archive');
            header('Content-Disposition: attachment; filename="' . basename($path) . '"');
            break;
    }
    readfile($path);
    return;
}

// Route everything else through index.php
require_once __DIR__ . '/index.php';
