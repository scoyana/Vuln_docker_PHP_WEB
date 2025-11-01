document.getElementById("checkBtn").addEventListener("click", async function () {
    const userId = document.getElementById("user_id").value.trim();

    if (!userId) {
        alert("아이디를 입력해주세요.");
        return;
    }

    try {
        const response = await fetch("check_user.php", {
            method: "POST",
            headers: {
                "Content-Type": "application/x-www-form-urlencoded"
            },
            body: `user_id=${encodeURIComponent(userId)}`
        });

        if (!response.ok) {
            alert("서버 통신 오류: " + response.status);
            return;
        }

        const data = await response.json();

        if (data.exists) {
            alert("중복된 아이디입니다.");
        } else if (data.exists === false) {
            alert("사용 가능한 아이디입니다!");
        } else if (data.error) {
            alert("서버 오류: " + data.error);
        }
    } catch (error) {
        alert("서버 응답을 처리할 수 없습니다.");
        console.error("Fetch 에러:", error);
    }
});
