<?php
include 'header.php';

$user_id_str = $_SESSION['user']; // 문자열 user_id
try {
    // users 테이블에서 id와 password 가져오기
    $stmt = $pdo->prepare("SELECT id, password FROM users WHERE user_id = ?");
    $stmt->execute([$user_id_str]);
    $user = $stmt->fetch(PDO::FETCH_ASSOC);

    if (!$user) {
        $error = "사용자를 찾을 수 없습니다.";
    } else {
        if ($_SERVER['REQUEST_METHOD'] === 'POST') {
            $password = $_POST['password'] ?? '';

            if (!password_verify($password, $user['password'])) {
                $error = "비밀번호가 올바르지 않습니다.";
            } else {
                $user_id_int = $user['id']; // posts.user_id와 맞추기 위해 int 사용

                // 사용자의 게시글 삭제
                $pdo->prepare("DELETE FROM posts WHERE user_id = ?")->execute([$user_id_int]);

                // 사용자 삭제
                $pdo->prepare("DELETE FROM users WHERE id = ?")->execute([$user_id_int]);

                // 세션 종료
                session_unset();
                session_destroy();

                echo "<script>alert('회원탈퇴가 완료되었습니다.'); location.href='index.php';</script>";
                exit;
            }
        }
    }
} catch (PDOException $e) {
    error_log("DB Error: " . $e->getMessage());
    $error = "서버 오류가 발생했습니다.";
}
?>

<div class="account-container">
    <h2>회원탈퇴</h2>
    <?php if (!empty($error)) echo "<p style='color:red;'>$error</p>"; ?>
    <p>회원탈퇴 시 게시글을 포함한 모든 정보가 삭제됩니다. 진행하시겠습니까?</p>
    <form method="POST">
        <label>비밀번호 확인</label>
        <input type="password" name="password" required>
        <button type="submit" style="background-color:red;color:white;">회원탈퇴</button>
    </form>
</div>

<?php include 'footer.php'; ?>
