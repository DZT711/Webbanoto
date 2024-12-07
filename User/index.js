document.addEventListener('DOMContentLoaded', () => {
    let currentIndex = 0; // Track the current slide index
    let direction = 1; // 1 for forward, -1 for backward
    const totalSlides = document.querySelectorAll('.btn-hld .btn').length;
    const animationDuration = 30000; // 30 seconds for the full animation
    const slideDuration = animationDuration / totalSlides;

    // Function to update the active button based on the animation progress
    function updateActiveButton() {
        const buttons = document.querySelectorAll('.btn-hld .btn');
        // Update the button styles
        buttons.forEach((btn, index) => {
            if (index === currentIndex) {
                btn.style.backgroundColor = 'cyan'; // Active button color
                btn.style.boxShadow = '0px 0px 7px 4px rgba(0, 255, 255, 0.6)';
            } else {
                btn.style.backgroundColor = 'rgb(131, 117, 117)'; // Inactive button color
                btn.style.boxShadow = 'none';
            }
        });
    }

    // Function to move to the next or previous slide
    function moveToNextSlide() {
        // Update the current index based on the direction
        currentIndex += direction;
        // Reverse direction if we reach the last or first slide
        if (currentIndex >= totalSlides) {
            currentIndex = totalSlides - 1;
            direction = -1; // Reverse direction to backward
        } else if (currentIndex < 0) {
            currentIndex = 0;
            direction = 1; // Reverse direction to forward
        }
        // Update the active button
        updateActiveButton();
    }

    // Update active button based on the calculated index every slide duration
    setInterval(moveToNextSlide, slideDuration);
});
document.addEventListener("DOMContentLoaded", () => {
    // DOM Elements
    const loginBtn = document.getElementById("login-btn");
    const registerBtn = document.getElementById("register-btn");
    const logoutBtn = document.getElementById("logout-btn");
    const loginForm = document.getElementById("login-form");
    const registerForm = document.getElementById("register-form");
    const usernameDisplay = document.getElementById("username-display");
    const userInfo = document.getElementById("user-info");
    const priceFilter = document.getElementById("priceFilter");
    const yearFilter = document.getElementById("yearFilter");
    const carItems = document.querySelectorAll(".nc-item");

    // Toggle Login Form
    loginBtn.addEventListener("click", () => {
        loginForm.style.display = loginForm.style.display === "none" ? "block" : "none";
        registerForm.style.display = "none"; // Hide register form if open
    });

    // Toggle Register Form
    registerBtn.addEventListener("click", () => {
        registerForm.style.display = registerForm.style.display === "none" ? "block" : "none";
        loginForm.style.display = "none"; // Hide login form if open
    });

    // Login Handling (Example only)
    loginForm.querySelector("form").addEventListener("submit", (e) => {
        e.preventDefault();
        const username = document.getElementById("username").value;
        const password = document.getElementById("password").value;

        // Simple validation (can be replaced with API call)
        if (username === "user" && password === "password") {
            alert("Đăng nhập thành công!");
            loginForm.style.display = "none";
            loginBtn.style.display = "none";
            registerBtn.style.display = "none";
            logoutBtn.style.display = "inline";
            userInfo.style.display = "inline";
            usernameDisplay.textContent = username;
        } else {
            alert("Tên đăng nhập hoặc mật khẩu không đúng!");
        }
    });

    // Logout Handling
    logoutBtn.addEventListener("click", () => {
        alert("Đăng xuất thành công!");
        loginBtn.style.display = "inline";
        registerBtn.style.display = "inline";
        logoutBtn.style.display = "none";
        userInfo.style.display = "none";
        usernameDisplay.textContent = "";
    });

    // Register Handling (Example only)
    registerForm.querySelector("form").addEventListener("submit", (e) => {
        e.preventDefault();
        const newUsername = document.getElementById("new-username").value;
        const newPassword = document.getElementById("new-password").value;
        const confirmPassword = document.getElementById("confirm-password").value;

        if (newPassword !== confirmPassword) {
            alert("Mật khẩu xác nhận không khớp!");
        } else {
            alert(`Đăng ký thành công! Xin chào, ${newUsername}`);
            registerForm.style.display = "none";
        }
    });
})


