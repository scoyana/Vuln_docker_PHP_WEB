(function() {
    const checkBtn = document.getElementById("checkBtn");
    const registerBtn = document.getElementById("registerBtn");
    const userIdInput = document.getElementById("user_id");

    if (!checkBtn || !registerBtn || !userIdInput) return; // 요소 없으면 종료

    // 처음에 버튼 비활성화
    registerBtn.disabled = true;

    checkBtn.addEventListener("click", async function() {
        const userId = userIdInput.value.trim();

        if (!userId) {
            alert("아이디를 입력해주세요.");
            return;
        }

        try {
            const response = await fetch("check_user.php", {
                method: "POST",
                headers: { "Content-Type": "application/x-www-form-urlencoded" },
                body: `user_id=${encodeURIComponent(userId)}`
            });

            const data = await response.json();

            if (data.exists) {
                alert("중복된 아이디입니다.");
                registerBtn.disabled = true;
            } else {
                alert("사용 가능한 아이디입니다!");
                registerBtn.disabled = false;
            }

        } catch (error) {
            alert("서버 통신 오류");
            console.error(error);
            registerBtn.disabled = true;
        }
    });
})();

// window.addEventListener('load', () => {
//     const footer = document.querySelector('.footer');
//     const bodyHeight = document.body.scrollHeight;
//     const windowHeight = window.innerHeight;

//     if (bodyHeight < windowHeight) {
//         footer.style.position = 'absolute';
//         footer.style.bottom = '0';
//         footer.style.width = '100%';
//     } else {
//         footer.style.position = 'relative';
//     }
// });

