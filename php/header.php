<?php
session_start();
require_once 'db.php';
?>
<!DOCTYPE html>
<html lang="ko">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <link rel="stylesheet" href="/css/style.css">
    <title><?= $pageTitle ?? '게시판' ?></title>
</head>
<body>
    <header>
        <div class="nav">
            <h1 id="theBoard"><a href="/index.php?page=home">게시판</a></h1>
            <div id="user_account">
                <?php if (isset($_SESSION['user'])): ?>
                    <!-- 로그인된 상태 -->
                    <?= $_SESSION['user'] ?>님 반갑습니다.
                    <a href="/index.php?page=account"><strong>내정보</strong></a>
                    <a href="/index.php?page=logout"><strong>로그아웃</strong></a>
                <?php else: ?>
                    <!-- 로그인 안 된 상태 -->
                    <a href="/index.php?page=login"><strong>로그인</strong></a>
                    <a href="/index.php?page=register"><strong>회원가입</strong></a>     
                <?php endif; ?>
            </div>
        </div>
        <div class="vir_line"></div>
        <!-- <hr> -->
    </header>
