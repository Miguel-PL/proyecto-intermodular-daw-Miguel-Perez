<?php

// Application main configuration values
define('APP_NAME', 'Club Pádel Verde');
define('APP_URL', 'http://localhost/padel-verde/public/');

// Database connection configuration
if ($_SERVER['HTTP_HOST'] === 'localhost') {
    define('DB_HOST', 'localhost');
    define('DB_NAME', 'padel_verde');
    define('DB_USER', 'root');
    define('DB_PASS', '');
} else {
    define('DB_HOST', 'sql201.infinityfree.com');
    define('DB_NAME', 'if0_40996108_padel_verde');
    define('DB_USER', '	if0_40996108');
    define('DB_PASS', 'vDicN17z6W');
}

// Stores a flash message in session to be shown once
function setFlash(string $type, string $message): void
{
    $_SESSION['flash'] = [
        'type' => $type,       // Message type (success, error, warning, info)
        'message' => $message // Message text
    ];
}

// Retrieves and removes the flash message from session
function getFlash(): ?array
{
    // If no flash message exists, return null
    if (!isset($_SESSION['flash'])) {
        return null;
    }

    // Get flash message and remove it from session
    $flash = $_SESSION['flash'];
    unset($_SESSION['flash']);
    return $flash;
}


