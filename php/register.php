<h2 id="registerHead">회원가입</h2>
<form id="registerForm" action="register_ok.php" method="POST" class="registerForm">
    <label>
        아이디
        <input type="text" name="user_id" id="user_id">
        <button type="button" id="checkBtn">중복체크</button><br>

        비밀번호
        <input type="password" name="password"><br>

        비밀번호 재확인
        <input type="password" name="passwordRe"><br>
    </label>
    <button type="submit" id="registerBtn">회원가입</button>
</form>

<script src="js/check_id.js"></script>



