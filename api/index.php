<?php

$path = parse_url($_SERVER['REQUEST_URI'], PHP_URL_PATH);
$path = trim($path, '/');

if ($path === '') {
    $page = 'index.php';
} else {
    $page = basename($path);

    if (!str_ends_with($page, '.php')) {
        $page .= '.php';
    }
}

$allowedPages = [
    'index.php',
    'about.php',
    'contact.php',
    'designer.php',
    'mockup.php',
    'portfolio.php',
    'privacy.php',
    'quote.php',
    'subscribe.php'
];

$file = __DIR__ . '/../' . $page;

if (in_array($page, $allowedPages, true) && file_exists($file)) {
    require $file;
} else {
    http_response_code(404);
    echo '404 - Page not found';
}