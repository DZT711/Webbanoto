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

});

    document.getElementById('priceFilter').addEventListener('change', filterProducts);
    document.getElementById('yearFilter').addEventListener('change', filterProducts);
    
    function filterProducts() {
        var priceFilterValue = document.getElementById('priceFilter').value;
        var yearFilterValue = document.getElementById('yearFilter').value;
        var products = document.querySelectorAll('.nc-item');
    
        products.forEach(function(product) {
            var price = parseInt(product.getAttribute('data-price'));
            var year = product.getAttribute('data-year');
    
            var displayByPrice = false;
            var displayByYear = (yearFilterValue === 'all' || year === yearFilterValue);
    
            if (priceFilterValue === 'all') {
                displayByPrice = true;
            } else if (priceFilterValue === 'below10b' && price < 10000000000) {
                displayByPrice = true;
            } else if (priceFilterValue === '10to20b' && price >= 10000000000 && price <= 20000000000) {
                displayByPrice = true;
            } else if (priceFilterValue === 'above20b' && price > 20000000000) {
                displayByPrice = true;
            }
    
            if (displayByPrice && displayByYear) {
                product.style.display = '';
            } else {
                product.style.display = 'none';
            }
        });
    }
    
    