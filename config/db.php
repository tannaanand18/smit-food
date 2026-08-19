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

$dsn = "mysql:host=$host;port=$port;charset=utf8mb4";
$ca_file = __DIR__ . '/cacert.pem';

// 6 distinct SSL driver option combinations to ensure remote TLS handshake
$ssl_option_sets = [
    [1012 => $ca_file, 1014 => false],
    [1012 => $ca_file, 1014 => true],
    [1012 => $ca_file],
    [1012 => '/etc/ssl/certs/ca-certificates.crt', 1014 => false],
    [1009 => '/etc/ssl/certs', 1014 => false],
    [1012 => $ca_file, 1011 => 'DHE-RSA-AES256-SHA:AES128-SHA', 1014 => false]
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
    foreach ($ssl_option_sets as $idx => $ssl_opts) {
        try {
            $opts = [
                PDO::ATTR_ERRMODE => PDO::ERRMODE_EXCEPTION,
                PDO::ATTR_DEFAULT_FETCH_MODE => PDO::FETCH_ASSOC,
                PDO::ATTR_TIMEOUT => 5
            ] + $ssl_opts;

            $pdo = new PDO($dsn, $user, $password, $opts);
            break; // SSL connection succeeded!
        } catch (PDOException $e) {
            $last_error = "Set #" . ($idx + 1) . ": " . $e->getMessage();
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