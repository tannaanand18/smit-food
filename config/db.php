<?php
$host = getenv('DB_HOST') ?: 'localhost';
$dbname = getenv('DB_NAME') ?: 'food_order_db';
$user = getenv('DB_USER') ?: 'root';
$password = getenv('DB_PASS') ?: 'tanna_anand_1';

// Automatically detect TiDB Cloud host and default to port 4000 instead of 3306
$default_port = (strpos($host, 'tidbcloud.com') !== false) ? '4000' : '3306';
$port = getenv('DB_PORT') ?: $default_port;

try {
    $dsn = "mysql:host=$host;port=$port;dbname=$dbname;charset=utf8mb4";
    $options = [
        PDO::ATTR_ERRMODE => PDO::ERRMODE_EXCEPTION,
        PDO::ATTR_DEFAULT_FETCH_MODE => PDO::FETCH_ASSOC,
        PDO::ATTR_TIMEOUT => 10
    ];

    // Enable SSL for remote connections (like TiDB)
    if ($host !== 'localhost' && $host !== '127.0.0.1') {
        if (class_exists('Pdo\Mysql') && defined('Pdo\Mysql::ATTR_SSL_CA')) {
            $options[Pdo\Mysql::ATTR_SSL_CA] = true;
        } elseif (defined('PDO::MYSQL_ATTR_SSL_CA')) {
            @$options[PDO::MYSQL_ATTR_SSL_CA] = true;
        }
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