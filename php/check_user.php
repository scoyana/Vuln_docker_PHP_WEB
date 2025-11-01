<?php
header('Content-Type: application/json; charset=utf-8');
require_once 'db.php';


$user_id = $_POST['user_id'] ?? '';

if (empty($user_id)) {
    echo json_encode(['error' => '아이디가 전달되지 않았습니다.']);
    exit;
}

try {
    $sql = "SELECT COUNT(*) FROM users WHERE user_id = ?";
    $stmt = $pdo->prepare($sql);
    $stmt->execute([$user_id]);
    $count = $stmt->fetchColumn();

    echo json_encode(['exists' => $count > 0]);
} catch (PDOException $e) {
    error_log("DB Error: " . $e->getMessage());
    echo json_encode(['error' => 'DB 연결 오류 발생']);
}
?>