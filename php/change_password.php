<?php
include 'header.php';

$user_id = $_SESSION['user'];

if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    $current_pw = $_POST['current_password'] ?? '';
    $new_pw = $_POST['new_password'] ?? '';
    $confirm_pw = $_POST['confirm_password'] ?? '';

    // 새 비밀번호 확인
    if ($new_pw !== $confirm_pw) {
        $error = "새 비밀번호와 확인이 일치하지 않습니다.";
    } else {
        try {
            // 현재 비밀번호 확인
            $stmt = $pdo->prepare("SELECT password FROM users WHERE user_id = ?");
            $stmt->execute([$user_id]);
            $user = $stmt->fetch(PDO::FETCH_ASSOC);

            if (!$user || !password_verify($current_pw, $user['password'])) {
                $error = "현재 비밀번호가 올바르지 않습니다.";
            } else {
                // 새 비밀번호로 업데이트
                $hashed_pw = password_hash($new_pw, PASSWORD_DEFAULT);
                $update = $pdo->prepare("UPDATE users SET password = ? WHERE user_id = ?");
                $update->execute([$hashed_pw, $user_id]);
                echo "<script>alert('비밀u번호가 변경되었습니다.'); location.href='account.php';</script>";
                exit;
            }
        } catch (PDOException $e) {
            error_log("DB Error: " . $e->getMessage());
            $error = "서버 오류가 발생했습니다.";
        }
    }
}
?>



<div class="account-container">
    <h2>비밀번호 변경</h2>
    <?php if (!empty($error)) echo "<p style='color:red;'>$error</p>"; ?>
    <form method="POST">
        <label>현재 비밀번호</label>
        <input type="password" name="current_password" required>
        <label>새 비밀번호</label>
        <input type="password" name="new_password" required>
        <label>새 비밀번호 확인</label>
        <input type="password" name="confirm_password" required>
        <button type="submit">비밀번호 변경</button>
    </form>
</div>

<?php include 'footer.php'; ?>
