<?php
session_start();

unset($_SESSION['user']);
session_destroy();

if (isset($_COOKIE['user'])) {
    setcookie('user', '', time() - 3600);
}

echo "<script>
alert('로그아웃 되었습니다.');
location.href='index.php?page=home';
</script>";
?>