<?php

$page = $_GET['page'] ?? 'home';

$whitelist = ['home', 'about', 'write', 'register', 'login', 'logout', 'account'];
if (in_array($page, $whitelist)) {
    
    switch ($page) {
        case 'home':
            $pageTitle = '게시판';
            break;
        case 'about':
            $pageTitle = '소개';
            break;
        case 'register':
            $pageTitle = '회원가입';
            break;
        case 'login':
            $pageTitle = '로그인';
            break;
        case 'logout';
            $pageTitle = '로그아웃';
            break;
        case 'account';
            $pageTitle = '내정보';
            break;
        case 'write':
            $pageTitle = '글쓰기';
            break;
        default:
            $pageTitle = '게시판';
            break;
}

    $content_view = "$page.php";
    include_once 'layout.php';
}   else {
    echo "허용되지 않은 페이지입니다.";
}
?>