<?php
function get_db_env($key, $default = '') {
    if (isset($_ENV[$key]) && $_ENV[$key] !== '') return trim($_ENV[$key]);
    if (isset($_SERVER[$key]) && $_SERVER[$key] !== '') return trim($_SERVER[$key]);
    $val = getenv($key);
    return ($val !== false && $val !== '') ? trim($val) : $default;
}

$raw_host = get_db_env('DB_HOST', 'localhost');
$dbname   = get_db_env('DB_NAME', 'food_order_db');
$user     = get_db_env('DB_USER', 'root');
$password = get_db_env('DB_PASS', 'tanna_anand_1');
$port     = get_db_env('DB_PORT', '');

// Clean host if user included port or protocol
$host = trim(str_replace(['http://', 'https://'], '', $raw_host));

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

if ($port === '40000') {
    $port = '4000';
}

// Build DSN directly specifying assigned database
$dsn = "mysql:host=$host;port=$port;dbname=$dbname;charset=utf8mb4";
$ca_file = __DIR__ . '/cacert.pem';

// Options to try (Standard TCP/IP first for Clever Cloud, then SSL)
$ssl_option_sets = [
    [], // 1. Standard TCP/IP (Clever Cloud default)
    [1012 => $ca_file, 1014 => false], // 2. SSL CA
    [1012 => '/etc/ssl/certs/ca-certificates.crt', 1014 => false], // 3. Linux System CA
    [1009 => '/etc/ssl/certs', 1014 => false] // 4. Linux CAPATH
];

$pdo = null;
$last_error = '';

if ($host === 'localhost' || $host === '127.0.0.1') {
    $pdo = new PDO($dsn, $user, $password, [
        PDO::ATTR_ERRMODE => PDO::ERRMODE_EXCEPTION,
        PDO::ATTR_DEFAULT_FETCH_MODE => PDO::FETCH_ASSOC
    ]);
} else {
    foreach ($ssl_option_sets as $ssl_opts) {
        try {
            $opts = [
                PDO::ATTR_ERRMODE => PDO::ERRMODE_EXCEPTION,
                PDO::ATTR_DEFAULT_FETCH_MODE => PDO::FETCH_ASSOC,
                PDO::ATTR_TIMEOUT => 5
            ] + $ssl_opts;

            $pdo = new PDO($dsn, $user, $password, $opts);
            break; // Connection succeeded!
        } catch (PDOException $e) {
            $last_error = $e->getMessage();
        }
    }
}

if (!$pdo) {
    die("Database connection failed [Host: $host:$port, DB: $dbname, User: $user]: " . $last_error);
}

// Auto-seed tables into assigned database if menu table is not yet created
try {
    $table_check = $pdo->query("SHOW TABLES LIKE 'menu'")->fetch();
    if (!$table_check) {
        // Create tables inside current database without running CREATE DATABASE
        $pdo->exec("
            CREATE TABLE IF NOT EXISTS users (
                id INT AUTO_INCREMENT PRIMARY KEY,
                name VARCHAR(100) NOT NULL,
                email VARCHAR(150) NOT NULL UNIQUE,
                password VARCHAR(255) NOT NULL,
                phone VARCHAR(20),
                address TEXT,
                created_at TIMESTAMP DEFAULT CURRENT_TIMESTAMP
            );
            CREATE TABLE IF NOT EXISTS menu (
                id INT AUTO_INCREMENT PRIMARY KEY,
                name VARCHAR(150) NOT NULL,
                description TEXT,
                price DECIMAL(10,2) NOT NULL,
                category VARCHAR(100) NOT NULL,
                image_url VARCHAR(255),
                is_available TINYINT DEFAULT 1,
                created_at TIMESTAMP DEFAULT CURRENT_TIMESTAMP
            );
            CREATE TABLE IF NOT EXISTS orders (
                id INT AUTO_INCREMENT PRIMARY KEY,
                user_id INT,
                items JSON,
                total_amount DECIMAL(10,2) NOT NULL,
                status ENUM('pending', 'confirmed', 'preparing', 'delivered', 'cancelled') DEFAULT 'pending',
                delivery_address TEXT,
                notes TEXT,
                created_at TIMESTAMP DEFAULT CURRENT_TIMESTAMP,
                FOREIGN KEY (user_id) REFERENCES users(id) ON DELETE CASCADE
            );
        ");
        
        $sql_file = __DIR__ . '/../database.sql';
        if (file_exists($sql_file)) {
            $sql = file_get_contents($sql_file);
            // Remove CREATE DATABASE and USE statements from database.sql
            $sql = preg_replace('/CREATE DATABASE.*?;/i', '', $sql);
            $sql = preg_replace('/USE .*?;/i', '', $sql);
            $pdo->exec($sql);
        }
    }
} catch (PDOException $e) {
    // Tables already populated
}
?>