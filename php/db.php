<?php

$DB_HOST = getenv('MYSQL_HOST') ?: 'db';
$DB_USER = getenv('MYSQL_USER');
$DB_PASSWORD = getenv('MYSQL_PASSWORD');
$DB_DATABASE = getenv('MYSQL_DATABASE');

try {
    $dsn = "mysql:host=$DB_HOST;dbname=$DB_DATABASE;charset=utf8mb4";
    $pdo = new PDO($dsn, $DB_USER, $DB_PASSWORD);

    $pdo->setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION);
    $pdo->setAttribute(PDO::ATTR_DEFAULT_FETCH_MODE, PDO::FETCH_ASSOC);
} catch (PDOException $e) {
    die("DB 연결 실패: " . $e->getMessage());
}

?>

