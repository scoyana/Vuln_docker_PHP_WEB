<?php

session_start();
require_once 'db.php';

$user_id = $_POST['user_id'] ? strtolower($_POST['user_id']) : '';
$password = $_POST['password'] ? strtolower($_POST['password']) : '';

if (empty($user_id) || empty($password)) {
    echo "<script>
    alert('아이디와 비밀번호를 입력해주세요.'); history.back();
    </script>";
    exit();
}   

try {
    $sql = "SELECT * FROM users WHERE user_id = ? LIMIT 1";
    $stmt = $pdo->prepare($sql);
    $res = $stmt->execute([$user_id]);
    $row = $stmt->fetch(PDO::FETCH_ASSOC);

    if ($row && password_verify($password, $row['password'])) {
        $_SESSION['user'] = $user_id;
        setcookie('user', $user_id, time() + 60 * 60 * 24 * 7);

        echo "<script>
        alert('로그인 성공');
        location.href='index.php?page=home';
        </script>";
    }   else {
        echo "<script>
        alert('아이디 또는 비밀번호가 올바르지 않습니다.');
        history.back();
        </script>";
        exit();
    }
}   catch (PDOException $e) {
        error_log("Login DB error. " . $e->getMessage());
        echo "<script>
        alert('서버 오류가 발생했습니다. 잠시 후 다시 시도하세요.');
        history.back();
        </script>";
}

?>