<?php
// include 'header.php';
$user_id = $_SESSION['user'];

try {
    $stmt = $pdo->prepare("SELECT id, user_id, created_at FROM users WHERE user_id = ?");
    $stmt->execute([$user_id]);
    $user = $stmt->fetch(PDO::FETCH_ASSOC);

    if (!$user) {
        echo "<script>alert('사용자 정보를 불러올 수 없습니다.'); location.href='index.php';</script>";
        exit;
    }
} catch (PDOException $e) {
    error_log("DB Error: " . $e->getMessage());
    echo "<script>alert('서버 오류가 발생했습니다.'); history.back();</script>";
    exit;
}
?>
<div class="account_container">
    <h2>내 정보</h2>
    <table class="account_table">
        <tr>
            <th>아이디</th>
            <td><?= htmlspecialchars($user['user_id']) ?></td>
        </tr>
        <tr>
            <th>회원번호</th>
            <td><?= $user['id'] ?></td>
        </tr>
        <tr>
            <th>가입일</th>
            <td><?= $user['created_at'] ?></td>
        </tr>
    </table>

    <div class="account_actions">
        <a href="change_password.php" class="account_btn" id="change_btn">비밀번호 변경</a>
        <a href="delete_account.php" class="account_btn" id="delete_btn" onclick="return confirm('정말 회원탈퇴 하시겠습니까?');">회원탈퇴</a>
    </div>
</div>

