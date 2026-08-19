<?php
$raw_host = getenv('DB_HOST') ?: 'localhost';
$dbname = getenv('DB_NAME') ?: 'food_order_db';
$user = getenv('DB_USER') ?: 'root';
$password = getenv('DB_PASS') ?: 'tanna_anand_1';

// Clean host if user included port or protocol
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

if ($port === '40000') {
    $port = '4000';
}

$ca_file = __DIR__ . '/cacert.pem';

// Connect without specifying dbname first so connection won't fail if database is not yet created
$dsn_no_db = "mysql:host=$host;port=$port;charset=utf8mb4";

$attempts = [
    // 1. DSN sslmode=REQUIRED + CA File
    [
        'dsn' => "$dsn_no_db;sslmode=REQUIRED",
        'options' => [1012 => $ca_file, 1014 => false]
    ],
    // 2. DSN sslmode=REQUIRED
    [
        'dsn' => "$dsn_no_db;sslmode=REQUIRED",
        'options' => []
    ],
    // 3. Standard DSN + CA File
    [
        'dsn' => $dsn_no_db,
        'options' => [1012 => $ca_file, 1014 => false]
    ],
    // 4. Standard DSN
    [
        'dsn' => $dsn_no_db,
        'options' => []
    ]
];

$pdo = null;
$last_error = '';

if ($host === 'localhost' || $host === '127.0.0.1') {
    $dsn_local = "mysql:host=$host;port=$port;dbname=$dbname;charset=utf8mb4";
    $pdo = new PDO($dsn_local, $user, $password, [
        PDO::ATTR_ERRMODE => PDO::ERRMODE_EXCEPTION,
        PDO::ATTR_DEFAULT_FETCH_MODE => PDO::FETCH_ASSOC
    ]);
} else {
    foreach ($attempts as $attempt) {
        try {
            $opts = [
                PDO::ATTR_ERRMODE => PDO::ERRMODE_EXCEPTION,
                PDO::ATTR_DEFAULT_FETCH_MODE => PDO::FETCH_ASSOC,
                PDO::ATTR_TIMEOUT => 5
            ] + $attempt['options'];

            $pdo = new PDO($attempt['dsn'], $user, $password, $opts);
            break;
        } catch (PDOException $e) {
            $last_error = $e->getMessage();
        }
    }
}

if (!$pdo) {
    die("Database connection failed [Host: $host:$port]: " . $last_error);
}

// Auto-provision database & tables on remote host if not present
try {
    $pdo->exec("CREATE DATABASE IF NOT EXISTS `$dbname` CHARACTER SET utf8mb4 COLLATE utf8mb4_unicode_ci;");
    $pdo->exec("USE `$dbname`;");

    // Check if menu table exists, if not auto-seed database.sql
    $table_check = $pdo->query("SHOW TABLES LIKE 'menu'")->fetch();
    if (!$table_check) {
        $sql_file = __DIR__ . '/../database.sql';
        if (file_exists($sql_file)) {
            $sql = file_get_contents($sql_file);
            $pdo->exec($sql);
        }
    }
} catch (PDOException $e) {
    // Selected / created safely
}
?>