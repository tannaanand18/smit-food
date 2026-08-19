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

// Comprehensive list of SSL DSN and driver options for mysqlnd & TiDB Cloud
$dsn_attempts = [
    // 1. DSN with sslmode=REQUIRED + MYSQL_ATTR_SSL_CA
    [
        'dsn' => "mysql:host=$host;port=$port;dbname=$dbname;charset=utf8mb4;sslmode=REQUIRED",
        'options' => [1012 => $ca_file, 1014 => false]
    ],
    // 2. DSN with sslmode=REQUIRED
    [
        'dsn' => "mysql:host=$host;port=$port;dbname=$dbname;charset=utf8mb4;sslmode=REQUIRED",
        'options' => []
    ],
    // 3. DSN with sslmode=REQUIRED & sslrootcert
    [
        'dsn' => "mysql:host=$host;port=$port;dbname=$dbname;charset=utf8mb4;sslmode=REQUIRED;sslrootcert=$ca_file",
        'options' => []
    ],
    // 4. DSN with ssl-mode=REQUIRED
    [
        'dsn' => "mysql:host=$host;port=$port;dbname=$dbname;charset=utf8mb4;ssl-mode=REQUIRED",
        'options' => []
    ],
    // 5. Driver MYSQL_ATTR_SSL_CAPATH
    [
        'dsn' => "mysql:host=$host;port=$port;dbname=$dbname;charset=utf8mb4",
        'options' => [1009 => __DIR__, 1014 => false]
    ]
];

$pdo = null;
$last_error = '';

if ($host === 'localhost' || $host === '127.0.0.1') {
    $pdo = new PDO("mysql:host=$host;port=$port;dbname=$dbname;charset=utf8mb4", $user, $password, [
        PDO::ATTR_ERRMODE => PDO::ERRMODE_EXCEPTION,
        PDO::ATTR_DEFAULT_FETCH_MODE => PDO::FETCH_ASSOC
    ]);
} else {
    foreach ($dsn_attempts as $attempt) {
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
    die("Database connection failed [Host: $host:$port, User: $user]: " . $last_error);
}
?>