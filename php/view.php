<?php
include_once 'header.php';

$id = $_GET['id'] ?? null;
// if (!$id) {
//     echo "<p>유효하지 않은 글입니다.</p>";
//     exit();
// }

try {
    $sql = "SELECT p.*, u.user_id FROM posts p JOIN users u ON p.user_id = u.id WHERE p.id = ?"; 
    $stmt = $pdo->prepare($sql);
    $stmt->execute([$id]);
    $post = $stmt->fetch(PDO::FETCH_ASSOC);

    if (!$post) {
        echo "<p>게시글을 찾을 수 없습니다.</p>";
        exit();
    }
} catch (PDOException $e) {
    echo "<p>게시글 조회 중 오류가 발생했습니다.</p>";
    error_log($e->getMessage());
    exit();
}
?>
<main>
    <div class=viewClass>
        <h2 id="viewHead"><?= htmlspecialchars($post['title']) ?></h2>
        <p>작성자: <?= htmlspecialchars($post['user_id']) ?> | 작성일: <?= $post['created_at'] ?></p>
        <p id="viewContent"><?= nl2br(htmlspecialchars($post['content'])) ?></p>

        <?php if ($post['file_path']): ?>
            <p>첨부 파일: <a href="<?= htmlspecialchars($post['file_path']) ?>" download="<?= basename($post['file_path']) ?>?>">다운로드</a></p>
        <?php endif; ?>

    <a href="index.php?page=home" id="viewBack">목록으로 돌아가기</a>
    </div>

    <?php

    if ($post['user_id'] === $_SESSION['user']) {
        echo "<a href='edit.php?id=" . $post['id'] . "' id='viewEdit'>수정</a>";
        echo "<a href='delete.php?id=" . $post['id'] . "' id='viewDelete'>삭제</a>";
    }

    ?>
</main>
<?php include_once 'footer.php'; ?>