<?php

require_once 'db.php';
$user_id = $_POST['user_id'] ? strtolower($_POST['user_id']) : '';
$password = $_POST['password'] ? strtolower($_POST['password']) : '';
$passwordRe = $_POST['passwordRe'] ? strtolower($_POST['passwordRe']) : '';

if (empty($user_id) || empty($password) || empty($passwordRe)) {
    echo "<script>
    alert('아이디와 비밀번호를 입력해주세요.'); history.back();
    </script>";
    exit(); 
}   elseif (($password) !== ($passwordRe)) {
    echo "<script>
    alert('비밀번호를 확인해주세요.'); history.back();
    </script>";
    exit();
}


$hash = password_hash($password, PASSWORD_DEFAULT);

try {
    $sql = "INSERT INTO users (user_id, password) VALUES (?, ?)";
    $stmt = $pdo->prepare($sql);
    $res = $stmt->execute([$user_id, $hash]); //$res는 true or false

    if ($res) {
        echo "<script>
        alert('회원가입이 완료되었습니다.');
        location.href='index.php?page=login';
        </script>";
    }   else {
        echo "<script>
        alert('회원가입 중 오류가 발생했습니다.');
        history.back();
        </script>";
    }
} catch (PDOException $e) {
        error_log("Login DB error. " . $e->getMessage());
        echo "<script>
        alert('서버 오류가 발생했습니다. 잠시 후 다시 시도하세요.');
        history.back();
        </script>";
}
?>
