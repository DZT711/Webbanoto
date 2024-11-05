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
document.addEventListener('DOMContentLoaded', () => {
    const loginBtn = document.getElementById('login-btn');
    const registerBtn = document.getElementById('register-btn');
    const logoutBtn = document.getElementById('logout-btn');
    const loginForm = document.getElementById('login-form');
    const registerForm = document.getElementById('register-form');
    const shopArea = document.getElementById('shop-area');
    const userInfo = document.getElementById('user-info');
    const usernameDisplay = document.getElementById('username-display');

    let loggedInUser = null;
    const users = [];

    loginBtn.addEventListener('click', () => {
        loginForm.style.display = 'block';
        registerForm.style.display = 'none';
        shopArea.style.display = 'none';
    });

    registerBtn.addEventListener('click', () => {
        registerForm.style.display = 'block';
        loginForm.style.display = 'none';
        shopArea.style.display = 'none';
    });

    logoutBtn.addEventListener('click', () => {
        alert('Đã đăng xuất!');
        loggedInUser = null;
        logoutBtn.style.display = 'none';
        userInfo.style.display = 'none';
        loginBtn.style.display = 'inline';
        registerBtn.style.display = 'inline';
        shopArea.style.display = 'none';
    });

    loginForm.querySelector('form').addEventListener('submit', (e) => {
        e.preventDefault();
        const username = document.getElementById('username').value;
        const password = document.getElementById('password').value;

        const user = users.find(user => user.username === username);
        if (user) {
            if (user.password === password) {
                loggedInUser = username;
                alert('Đăng nhập thành công!');
                loginForm.style.display = 'none';
                logoutBtn.style.display = 'inline';
                userInfo.style.display = 'inline';
                usernameDisplay.textContent = loggedInUser;
                loginBtn.style.display = 'none';
                registerBtn.style.display = 'none';
                shopArea.style.display = 'block';
            } else {
                alert('Sai mật khẩu hoặc tên đăng nhập. Vui lòng thử lại.');
            }
        } else {
            alert('Tên đăng nhập không tồn tại. Vui lòng đăng ký.');
        }
    });

    registerForm.querySelector('form').addEventListener('submit', (e) => {
        e.preventDefault();
        const newUsername = document.getElementById('new-username').value;
        const newPassword = document.getElementById('new-password').value;
        const confirmPassword = document.getElementById('confirm-password').value;

        if (newPassword === confirmPassword) {
            users.push({ username: newUsername, password: newPassword });
            loggedInUser = newUsername;
            alert('Đăng ký thành công!');
            registerForm.style.display = 'none';
            logoutBtn.style.display = 'inline';
            userInfo.style.display = 'inline';
            usernameDisplay.textContent = loggedInUser;
            loginBtn.style.display = 'none';
            registerBtn.style.display = 'none';
            shopArea.style.display = 'block';
        } else {
            alert('Mật khẩu xác nhận không khớp.');
        }
    });
});
