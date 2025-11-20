<?php
require_once 'db.php';
?>

<div class="top-controls">
    <a href='?page=write' class="write_btn">글쓰기</a>
    <div class="searchPart">
        <form method="GET" action="search.php" class="searchForm">
            <select name="category" id="category">
                <option value="title" <?= (($_GET['category'] ?? '') === 'title') ? 'selected' : '' ?>>제목</option>
                <option value="content" <?= (($_GET['category'] ?? '') === 'content') ? 'selected' : '' ?>>내용</option>
                <option value="all" <?= (($_GET['category'] ?? '') === 'all') ? 'selected' : '' ?>>제목+내용</option>
                <option value="author" <?= (($_GET['category'] ?? '') === 'author') ? 'selected' : '' ?>>작성자</option>
            </select>
            <input type="text" name="keyword" id="keyword" placeholder="검색어를 입력하세요"
                value="<?= htmlspecialchars($_GET['keyword'] ?? '') ?>">
            <button id="searchBtn">검색</button>
        </form>
    </div>
</div>

<?php
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
            echo "<div class='post-left'>";
            echo "<a href='view.php?id=" . $post['id'] . "' class='post-title'>" . ($post['title']) . "</a>";
            if ($post['file_path']) {
                echo "<img src='/img/download.png' alt='첨부파일' class='isFile'>";
            }
            echo "</div>";
            echo "<div class='post-info'>";
            echo "<small>" . $post['author'] . "</small>";
            echo "<small>(" . $post['created_at'] . ")</small>";
            echo "</div>";
            echo "</li>";
        }
        echo "</ul>";
    }
} catch (PDOException $e) {
    error_log("DB error: " . $e->getMessage());
    echo "<script>alert('서버 오류가 발생했습니다. 잠시 후 다시 시도하세요.'); history.back();</script>";
}
?>
