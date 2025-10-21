<?php
$page = $_GET['page'] ?? 'home';

$whitelist = ['home', 'about'];
if (in_array($page, $whitelist)) {
    
    switch ($page) {
        case 'home';
            $pageTitle = '게시판';
            break;
        case 'about';
            $pageTitle = '소개';
            break;
        default;
            $pageTitle = '게시판';
            break;
}

    $content_view = "$page.php";
    include 'layout.php';
}   else {
    echo "허용되지 않은 페이지입니다.";
}
?>