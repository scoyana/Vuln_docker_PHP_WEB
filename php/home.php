<?php
require_once 'db.php';

// 페이지네이션 관련
$posts_per_page = 10;
$current_page = $_GET['pageNum'] ?? 1;

// 전체 게시글 수
$total_posts = $pdo->query("SELECT COUNT(*) FROM posts")->fetchColumn();
$total_pages = ceil($total_posts / $posts_per_page);
$offset = ($current_page - 1) * $posts_per_page;

// 게시글 가져오기
$stmt = $pdo->prepare("
    SELECT p.id, p.title, p.file_path, p.created_at, u.user_id AS author
    FROM posts p
    JOIN users u ON p.user_id = u.id
    ORDER BY p.created_at DESC
    LIMIT :limit OFFSET :offset
");
$stmt->bindValue(':limit', $posts_per_page, PDO::PARAM_INT);
$stmt->bindValue(':offset', $offset, PDO::PARAM_INT);
$stmt->execute();
$posts = $stmt->fetchAll();

// 페이지네이션 링크를 위한 base URL
$base_url = "index.php?page=home";
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
include 'post_list.php';
include 'pagination.php';
?>
