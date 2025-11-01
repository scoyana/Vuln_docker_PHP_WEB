<?php
require_once 'db.php';

$id = $_GET['id'];
try {
    $sql = "DELETE FROM posts WHERE id = ?";
    $stmt = $pdo->prepare($sql);
    $stmt->execute([$id]);

    echo "<script>
    alert('게시글이 삭제되었습니다.');
    location.href = 'index.php?page=home';
    </script>";
}   catch (PDOException $e) {
        error_log('삭제 오류: ' . $e->getMessage());
        echo "<script>
            alert('게시글 삭제 중 오류가 발생했습니다.');
            history.back();
        </script>";
        exit();
}
?>