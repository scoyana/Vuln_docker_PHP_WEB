<?php
session_start();
require_once 'db.php';


$id = $_POST['id'] ?? null;
$title = ($_POST['subject'] ?? '');
$content = ($_POST['content'] ?? '');

if (!$id || !$title || !$content) {
    echo "<script>alert('필수 입력 항목이 누락되었습니다.'); history.back();</script>";
    exit;
}

try {
    // 기존 게시글 확인
    $stmt = $pdo->prepare("SELECT p.*, u.user_id FROM posts p JOIN users u ON p.user_id = u.id WHERE p.id = ?");
    $stmt->execute([$id]);
    $post = $stmt->fetch(PDO::FETCH_ASSOC);

    if (!$post) {
        echo "<script>alert('존재하지 않는 게시글입니다.'); history.back();</script>";
        exit;
    }

    if ($post['user_id'] !== $_SESSION['user']) {
        echo "<script>alert('수정 권한이 없습니다.'); history.back();</script>";
        exit;
    }

    // 파일 업로드 처리
    $filePath = $post['file_path'];
    if (!empty($_FILES['file']['name'])) {
        $uploadDir = 'uploads/';
        if (!is_dir($uploadDir)) mkdir($uploadDir);

        $fileName = time() . '_' . basename($_FILES['file']['name']);
        $targetPath = $uploadDir . $fileName;

        if (move_uploaded_file($_FILES['file']['tmp_name'], $targetPath)) {
            $filePath = $targetPath;
        } else {
            echo "<script>alert('파일 업로드 실패'); history.back();</script>";
            exit;
        }
    }

    // DB 업데이트
    $sql = "UPDATE posts 
            SET title = ?, content = ?, file_path = ?, updated_at = NOW() 
            WHERE id = ?";
    $stmt = $pdo->prepare($sql);
    $stmt->execute([$title, $content, $filePath, $id]);

    echo "<script>
    alert('게시글이 수정되었습니다.');
    location.href = 'view.php?id={$id}';
    </script>";

} catch (PDOException $e) {
    error_log('수정 오류: ' . $e->getMessage());
    echo "<script>alert('게시글 수정 중 오류가 발생했습니다.'); history.back();</script>";
}
?>
