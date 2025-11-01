<div><a href='?page=write' class="write_btn">글쓰기</a><br></div>

<?php
require_once 'db.php';

try {
    $sql = "SELECT p.id, p.title, p.file_path, p.created_at, u.user_id AS author
            FROM posts p
            JOIN users u ON p.user_id = u.id
            ORDER BY p.created_at DESC";
    $stmt = $pdo->query($sql);
    $posts = $stmt->fetchAll(PDO::FETCH_ASSOC);

    if (!$posts) {
        echo "<p>게시글이 없습니다.</p>";
    } else {
        echo "<ul class='post_list'>";
        foreach ($posts as $post) {
            
            echo "<li>";
            echo "<a href='view.php?id=" . $post['id'] . "'>" . htmlspecialchars($post['title']) . "</a>";
            if ($post['file_path']) {
                echo "<img src='/img/download.png' alt='첨부파일'>";
            }
            echo " <small>작성자 : " . $post['author'] . "</small>";
            echo " <small>(". $post['created_at'] . ")</small>";
            echo "</li>";
        }
        echo "</ul>";
    }
} catch (PDOException $e) {
    error_log("Login DB error. " . $e->getMessage());
        echo "<script>
        alert('서버 오류가 발생했습니다. 잠시 후 다시 시도하세요.');
        history.back();
        </script>";
}
?>