<?php

header('Content-Type: text/plain; charset=utf-8');
http_response_code(200);
echo "PHP " . PHP_VERSION . " OK\n";

foreach (['DB_HOST', 'DB_PORT', 'DB_NAME', 'DB_USER', 'DB_PASS'] as $k) {
    $v = getenv($k);
    echo $k . ': ' . (($v === false || $v === '') ? 'KOSONG' : 'terisi (' . strlen($v) . ' karakter)') . "\n";
}

$c = require __DIR__ . '/includes/config.php';
try {
    $dsn = "pgsql:host={$c['db_host']};port={$c['db_port']};dbname={$c['db_name']};sslmode=" . (getenv('DB_SSLMODE') ?: 'require');
    new PDO($dsn, $c['db_user'], $c['db_pass'], [
        PDO::ATTR_ERRMODE => PDO::ERRMODE_EXCEPTION,
        PDO::ATTR_TIMEOUT => 5,
    ]);
    echo "DB: TERHUBUNG\n";
} catch (Throwable $e) {
    echo "DB: GAGAL - " . $e->getMessage() . "\n";
}