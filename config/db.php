<?php
$host = getenv('DB_HOST') ?: 'localhost';
$dbname = getenv('DB_NAME') ?: 'food_order_db';
$user = getenv('DB_USER') ?: 'root';
$password = getenv('DB_PASS') ?: 'tanna_anand_1';
$port = getenv('DB_PORT') ?: '3306';

try {
    $dsn = "mysql:host=$host;port=$port;dbname=$dbname;charset=utf8mb4";
    $options = [
        PDO::ATTR_ERRMODE => PDO::ERRMODE_EXCEPTION,
        PDO::ATTR_DEFAULT_FETCH_MODE => PDO::FETCH_ASSOC,
        PDO::ATTR_TIMEOUT => 5
    ];

    // Handle PHP version compatibility for SSL constant without deprecation warnings
    if (class_exists('Pdo\Mysql') && defined('Pdo\Mysql::ATTR_SSL_CA')) {
        $options[Pdo\Mysql::ATTR_SSL_CA] = true;
    } elseif (defined('PDO::MYSQL_ATTR_SSL_CA')) {
        @$options[PDO::MYSQL_ATTR_SSL_CA] = true;
    }

    $pdo = new PDO($dsn, $user, $password, $options);
} catch (PDOException $e) {
    try {
        $pdo = new PDO($dsn, $user, $password, [
            PDO::ATTR_ERRMODE => PDO::ERRMODE_EXCEPTION,
            PDO::ATTR_DEFAULT_FETCH_MODE => PDO::FETCH_ASSOC
        ]);
    } catch (PDOException $ex) {
        die("Database connection failed: " . $ex->getMessage());
    }
}
?>