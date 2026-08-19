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

$dsn = "mysql:host=$host;port=$port;dbname=$dbname;charset=utf8mb4";
$ca_file = __DIR__ . '/cacert.pem';

// Strategies to establish TLS/SSL with TiDB Cloud
$ssl_attempts = [];

// Strategy 1: Bundled cacert.pem
if (file_exists($ca_file)) {
    $ssl_attempts[] = [1012 => $ca_file, 1014 => false];
}

// Strategy 2: Linux system CA file
if (file_exists('/etc/ssl/certs/ca-certificates.crt')) {
    $ssl_attempts[] = [1012 => '/etc/ssl/certs/ca-certificates.crt', 1014 => false];
}

// Strategy 3: Linux system CA directory (1009 = MYSQL_ATTR_SSL_CAPATH)
if (is_dir('/etc/ssl/certs')) {
    $ssl_attempts[] = [1009 => '/etc/ssl/certs', 1014 => false];
}

// Strategy 4: Fallback SSL boolean
$ssl_attempts[] = [1012 => true];

$pdo = null;
$last_error = '';

if ($host === 'localhost' || $host === '127.0.0.1') {
    $pdo = new PDO($dsn, $user, $password, [
        PDO::ATTR_ERRMODE => PDO::ERRMODE_EXCEPTION,
        PDO::ATTR_DEFAULT_FETCH_MODE => PDO::FETCH_ASSOC
    ]);
} else {
    foreach ($ssl_attempts as $ssl_opts) {
        try {
            $opts = [
                PDO::ATTR_ERRMODE => PDO::ERRMODE_EXCEPTION,
                PDO::ATTR_DEFAULT_FETCH_MODE => PDO::FETCH_ASSOC,
                PDO::ATTR_TIMEOUT => 5
            ] + $ssl_opts;

            $pdo = new PDO($dsn, $user, $password, $opts);
            break;
        } catch (PDOException $e) {
            $last_error = $e->getMessage();
        }
    }
}

if (!$pdo) {
    die("Database connection failed [Host: $host:$port, User: $user, CA_File_Exists: " . (file_exists($ca_file) ? 'YES' : 'NO') . "]: " . $last_error);
}
?>