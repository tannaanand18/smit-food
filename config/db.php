<?php
$raw_host = getenv('DB_HOST') ?: 'localhost';
$dbname = getenv('DB_NAME') ?: 'food_order_db';
$user = getenv('DB_USER') ?: 'root';
$password = getenv('DB_PASS') ?: 'tanna_anand_1';

// Clean host if user included port or protocol (e.g. gateway...com:4000)
$host = trim(str_replace(['http://', 'https://'], '', $raw_host));
$port = getenv('DB_PORT');

if (strpos($host, ':') !== false) {
    $parts = explode(':', $host);
    $host = trim($parts[0]);
    if (empty($port) && isset($parts[1])) {
        $port = trim($parts[1]);
    }
}

if (empty($port)) {
    $port = (strpos($host, 'tidbcloud.com') !== false) ? '4000' : '3306';
}

// Fix common typo where 40000 (extra zero) is entered instead of 4000
if ($port === '40000') {
    $port = '4000';
}

// Construct DSN
$dsn = "mysql:host=$host;port=$port;dbname=$dbname;charset=utf8mb4";

try {
    // Attempt 1: Standard connection
    $pdo = new PDO($dsn, $user, $password, [
        PDO::ATTR_ERRMODE => PDO::ERRMODE_EXCEPTION,
        PDO::ATTR_DEFAULT_FETCH_MODE => PDO::FETCH_ASSOC,
        PDO::ATTR_TIMEOUT => 5
    ]);
} catch (PDOException $e1) {
    try {
        // Attempt 2: Connection with SSL disabled verification for serverless
        $options = [
            PDO::ATTR_ERRMODE => PDO::ERRMODE_EXCEPTION,
            PDO::ATTR_DEFAULT_FETCH_MODE => PDO::FETCH_ASSOC,
            PDO::ATTR_TIMEOUT => 5
        ];
        if (defined('PDO::MYSQL_ATTR_SSL_VERIFY_SERVER_CERT')) {
            @$options[PDO::MYSQL_ATTR_SSL_VERIFY_SERVER_CERT] = false;
        }
        $pdo = new PDO($dsn, $user, $password, $options);
    } catch (PDOException $e2) {
        die("Database connection failed [Connecting to $host:$port as $user]: " . $e2->getMessage());
    }
}
?>