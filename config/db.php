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

// Construct DSN
$dsn = "mysql:host=$host;port=$port;dbname=$dbname;charset=utf8mb4";

$options = [
    PDO::ATTR_ERRMODE => PDO::ERRMODE_EXCEPTION,
    PDO::ATTR_DEFAULT_FETCH_MODE => PDO::FETCH_ASSOC,
    PDO::ATTR_TIMEOUT => 10
];

// Enforce SSL using driver integer keys (1012 = SSL_CA, 1014 = VERIFY_SERVER_CERT)
if ($host !== 'localhost' && $host !== '127.0.0.1') {
    $ca_file = __DIR__ . '/cacert.pem';
    if (file_exists($ca_file)) {
        $options[1012] = $ca_file;
    } elseif (file_exists('/etc/ssl/certs/ca-certificates.crt')) {
        $options[1012] = '/etc/ssl/certs/ca-certificates.crt';
    }
    $options[1014] = false;
}

try {
    $pdo = new PDO($dsn, $user, $password, $options);
} catch (PDOException $e) {
    die("Database connection failed [Connecting to $host:$port as $user]: " . $e->getMessage());
}
?>