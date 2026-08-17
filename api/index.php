<?php
// Entry point for Vercel Serverless Function

$uri = parse_url($_SERVER['REQUEST_URI'], PHP_URL_PATH);

// Serve static assets directly if requested through here
if (preg_match('/\.(?:png|jpg|jpeg|gif|css|js|ico|svg)$/i', $uri)) {
    return false;
}

// Router to match PHP pages
$file_path = __DIR__ . '/..' . $uri;

if ($uri === '/' || $uri === '') {
    require __DIR__ . '/../index.php';
} elseif (file_exists($file_path) && !is_dir($file_path) && str_ends_with($file_path, '.php')) {
    require $file_path;
} else {
    // Default fallback to index.php
    require __DIR__ . '/../index.php';
}
