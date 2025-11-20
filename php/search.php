<?php include_once 'header.php'; ?>
<?php

$category = $_GET['category'] ?? '';
$keyword = $_GET['keyword'] ?? '';

try {
    $sql = "SELECT p.id, p.title, p.content, p.file_path, p.created_at, u.user_id AS author
            FROM posts p
            JOIN users u ON p.user_id = u.id";

    $params = [];
    if ($keyword) {
        switch ($category) {
            case 'title':
                $sql .= " WHERE p.title LIKE ?";
                $params[] = "%$keyword%";
                break;
            case 'content':
                $sql .= " WHERE p.content LIKE ?";
                $params[] = "%$keyword%";
                break;
            case 'all':
                $sql .= " WHERE p.title LIKE ? OR p.content LIKE ?";
                $params[] = "%$keyword%";
                $params[] = "%$keyword%";
                break;
            case 'author':
                $sql .= " WHERE u.user_id LIKE ?";
                $params[] = "%$keyword%";
                break;
        }
    }

    $sql .= " ORDER BY p.created_at DESC";

    $stmt = $pdo->prepare($sql);
    $stmt->execute($params);
    $posts = $stmt->fetchAll(PDO::FETCH_ASSOC);

    if (!$posts) {
        echo "<p>검색 결과가 없습니다.</p>";
    } else {
        echo "<ul class='post_list'>";
        foreach ($posts as $post) {
            echo "<li>";
            echo "<a href='view.php?id=" . $post['id'] . "'>" . ($post['title']) . "</a>";
            if ($post['file_path']) {
                echo "<img src='/img/download.png' alt='첨부파일'>";
            }
            echo " <small>작성자 : " . ($post['author']) . "</small>";
            echo " <small>(" . $post['created_at'] . ")</small>";
            echo "</li>";
        }
        echo "</ul>";
    }
} catch (PDOException $e) {
    error_log("DB error: " . $e->getMessage());
    echo "<script>alert('서버 오류가 발생했습니다.'); history.back();</script>";
}
?>

<?php include_once 'footer.php'; ?>