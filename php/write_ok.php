<?php
session_start();
require_once 'db.php';

// 세션에서 user_id 가져오기 (문자열)
$user_session = $_SESSION['user'] ?? null;
if (!$user_session) {
    echo "<script>alert('로그인 후 글을 작성해주세요.'); location.href='index.php?page=login';</script>";
    exit();
}

// DB에서 INT id 조회
$stmt = $pdo->prepare("SELECT id FROM users WHERE user_id = ?");
$stmt->execute([$user_session]);
$row = $stmt->fetch(PDO::FETCH_ASSOC);
if (!$row) {
    echo "<script>alert('유효하지 않은 사용자입니다.'); location.href='index.php?page=login';</script>";
    exit();
}
$user_id_int = $row['id']; // DB INSERT용 INT user_id

// POST 데이터
$subject = $_POST['subject'] ?? '';
$content = $_POST['content'] ?? '';
$write_time = date("Y-m-d H:i:s");

if (empty($subject) || empty($content)) {
    echo "<script>alert('게시글을 완성해주세요.'); history.back();</script>";
    exit();
}

// 파일 업로드 처리
$file_path = null;
if (isset($_FILES['file']) && $_FILES['file']['error'] === UPLOAD_ERR_OK) {
    $file = $_FILES['file'];

    // 확장자 체크
    $ext = strtolower(pathinfo($file['name'], PATHINFO_EXTENSION));
    $allowed = ['jpg', 'jpeg', 'png', 'gif', 'txt', 'pdf'];
    if (!in_array($ext, $allowed)) {
        die("<script>alert('허용되지 않은 파일 형식입니다.'); history.back();</script>");
    }

    // 파일 크기 제한 (2MB)
    $max_size = 2 * 1024 * 1024;
    if ($file['size'] > $max_size) {
        die("<script>alert('파일 크기가 너무 큽니다.'); history.back();</script>");
    }

    // 업로드 폴더 생성
    $upload_dir = __DIR__ . '/uploads/';
    if (!is_dir($upload_dir)) mkdir($upload_dir, 0755, true);

    // 저장 파일명 생성
    $filename = uniqid() . '.' . $ext;
    $targetFile = $upload_dir . $filename;

    if (move_uploaded_file($file['tmp_name'], $targetFile)) {
        $file_path = 'uploads/' . $filename;
    } else {
        die("<script>alert('파일 업로드 실패'); history.back();</script>");
    }
}

try {
    $sql = "INSERT INTO posts (user_id, title, content, file_path, created_at) VALUES (?, ?, ?, ?, ?)";
    $stmt = $pdo->prepare($sql);
    $stmt->execute([$user_id_int, $subject, $content, $file_path, $write_time]);

    echo "<script>alert('게시글이 등록되었습니다.'); location.href='index.php?page=home';</script>";
    exit();
} catch (PDOException $e) {
    error_log("Login DB error. " . $e->getMessage());
        echo "<script>
        alert('서버 오류가 발생했습니다. 잠시 후 다시 시도하세요.');
        history.back();
        </script>";
}
