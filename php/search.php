<?php
include_once 'header.php';
require_once 'db.php';

$category = $_GET['category'] ?? '';
$keyword  = $_GET['keyword'] ?? '';

$posts_per_page = 10;
$current_page = $_GET['pageNum'] ?? 1;

$sql = "SELECT COUNT(*) FROM posts p JOIN users u ON p.user_id = u.id ";
$where = "";
$params = [];

if ($keyword) {
    switch ($category) {
        case 'title':
            $where = " WHERE p.title LIKE ?";
            $params[] = "%$keyword%";
            break;
        case 'content':
            $where = " WHERE p.content LIKE ?";
            $params[] = "%$keyword%";
            break;
        case 'all':
            $where = " WHERE p.title LIKE ? OR p.content LIKE ?";
            $params[] = "%$keyword%";
            $params[] = "%$keyword%";
            break;
        case 'author':
            $where = " WHERE u.user_id LIKE ?";
            $params[] = "%$keyword%";
            break;
    }
}

$count_stmt = $pdo->prepare($sql . $where);
$count_stmt->execute($params);
$total_posts = $count_stmt->fetchColumn();

$total_pages = ceil($total_posts / $posts_per_page);
$offset = ($current_page - 1) * $posts_per_page;

$limit = (int)$posts_per_page;
$offset = (int)$offset;

$stmt = $pdo->prepare("
    SELECT p.id, p.title, p.file_path, p.created_at, u.user_id AS author
    FROM posts p
    JOIN users u ON p.user_id = u.id
    $where
    ORDER BY p.created_at DESC
    LIMIT $limit OFFSET $offset
");
$stmt->execute($params);
$posts = $stmt->fetchAll();

if (!$posts) {
    echo "<script>
            alert('검색 결과가 없습니다.');
            window.location.href = 'index.php?page=home';
          </script>";
    exit;
}

$base_url = "search.php?category=$category&keyword=" . urlencode($keyword);
?>

<?php include 'post_list.php'; ?>
<?php include 'pagination.php'; ?>
<?php include_once 'footer.php'; ?>