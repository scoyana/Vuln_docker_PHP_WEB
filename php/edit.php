<?php
include_once 'header.php';

// GET으로 전달된 글 ID 받기
$id = $_GET['id'] ?? null;

try {
    // 게시글 + 작성자 정보 불러오기
    $sql = "SELECT p.*, u.user_id 
            FROM posts p 
            JOIN users u ON p.user_id = u.id 
            WHERE p.id = ?";
    $stmt = $pdo->prepare($sql);
    $stmt->execute([$id]);
    $post = $stmt->fetch(PDO::FETCH_ASSOC);
} catch (PDOException $e) {
    error_log("글 불러오기 오류: " . $e->getMessage());
    echo "<script>alert('게시글 조회 중 오류가 발생했습니다.'); history.back();</script>";
    exit;
}
?>

<form method="POST" action="edit_ok.php" enctype="multipart/form-data" class="write_form">
    <!-- 글 ID 전달 -->
    <input type="hidden" name="id" value="<?= ($post['id']) ?>">

    제목 :
    <input type="text" name="subject" id="subject" value="<?= ($post['title']) ?>" required> <br>

    내용 :
    <textarea name="content" id="content" required><?= ($post['content']) ?></textarea> <br>

    <?php if ($post['file_path']): ?>
        <p>첨부 파일:
            <a href="<?= ($post['file_path']) ?>" target="_blank">다운로드</a>
        </p>
    <?php endif; ?>

    첨부 파일 :
    <input type="file" name="file"><br>

    <button type="submit" id="write">수정 완료</button>
</form>


<?php include_once 'footer.php'; ?>
