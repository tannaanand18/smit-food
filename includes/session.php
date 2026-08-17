<?php
if (session_status() === PHP_SESSION_NONE) {
    session_start();
}

function is_logged_in() {
    return isset($_SESSION['user_id']);
}

function redirect_if_not_logged_in($url = '/auth/login.php') {
    if (!is_logged_in()) {
        header("Location: $url");
        exit;
    }
}

function redirect_if_logged_in($url = '/index.php') {
    if (is_logged_in()) {
        header("Location: $url");
        exit;
    }
}

// Generate CSRF token
if (empty($_SESSION['csrf_token'])) {
    $_SESSION['csrf_token'] = bin2hex(random_bytes(32));
}

function check_csrf_token($token) {
    return hash_equals($_SESSION['csrf_token'], $token);
}
?>
