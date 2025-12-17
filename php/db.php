<?php

$DB_HOST = getenv('DB_HOST') ?: 'db';
$DB_USER = getenv('DB_USER');
$DB_PASSWORD = getenv('DB_PASSWORD');
$DB_DATABASE = getenv('DB_DATABASE');

try {
    $dsn = "mysql:host=$DB_HOST;dbname=$DB_DATABASE;charset=utf8mb4";
    $pdo = new PDO($dsn, $DB_USER, $DB_PASSWORD);

    $pdo->setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION);
    $pdo->setAttribute(PDO::ATTR_DEFAULT_FETCH_MODE, PDO::FETCH_ASSOC);
} catch (PDOException $e) {
    die("DB 연결 실패: " . $e->getMessage());
}

?>

