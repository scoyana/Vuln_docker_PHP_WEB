<?php
session_start();
require_once 'db.php';



$id = $_POST['id'] ?? '';
$title = ($_POST['subject'] ?? '');
$content = ($_POST['content'] ?? '');

try {
    // 기존 게시글 불러오기 (기존 파일 유지용)
    $stmt = $pdo->prepare("SELECT * FROM posts WHERE id = ?");
    $stmt->execute([$id]);
    $post = $stmt->fetch(PDO::FETCH_ASSOC);

    if (!$post) {
        echo "<script>alert('존재하지 않는 게시글입니다.'); history.back();</script>";
        exit;
    }

    $filePath = $post['file_path']; // 기존 파일 경로 유지

    // 새 파일이 업로드되었을 경우
    if (!empty($_FILES['file']['name'])) {
        $uploadDir = 'uploads/';
        if (!is_dir($uploadDir)) mkdir($uploadDir);

        $fileName = time() . '_' . basename($_FILES['file']['name']);
        $targetPath = $uploadDir . $fileName;

        if (move_uploaded_file($_FILES['file']['tmp_name'], $targetPath)) {
            // 기존 파일이 있으면 삭제 (선택)
            if (!empty($filePath) && file_exists($filePath)) {
                unlink($filePath);
            }

            $filePath = $targetPath; // 새 파일 경로로 업데이트
        } else {
            echo "<script>alert('파일 업로드 실패'); history.back();</script>";
            exit;
        }
    }

 
    $sql = "UPDATE posts 
            SET title = ?, content = ?, file_path = ?
            WHERE id = ?";
    $stmt = $pdo->prepare($sql);
    $stmt->execute([$title, $content, $filePath, $id]);

    echo "<script>
    alert('게시글이 수정되었습니다.');
    location.href = 'view.php?id={$id}';
    </script>";

}   catch (PDOException $e) {
    error_log('수정 오류: ' . $e->getMessage());
    echo "<script>
    alert('게시글 수정 중 오류가 발생했습니다.');
    history.back();</script>";
}
?>