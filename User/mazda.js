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

    // Toggle login form
    loginBtn.addEventListener('click', () => {
        if (loginForm.style.display === 'block') {
            loginForm.style.display = 'none'; // Hide form if it's already visible
        } else {
            loginForm.style.display = 'block';
            registerForm.style.display = 'none'; // Ensure register form is hidden
            shopArea && (shopArea.style.display = 'none'); // Hide shop area if exists
        }
    });

    // Toggle register form
    registerBtn.addEventListener('click', () => {
        if (registerForm.style.display === 'block') {
            registerForm.style.display = 'none'; // Hide form if it's already visible
        } else {
            registerForm.style.display = 'block';
            loginForm.style.display = 'none'; // Ensure login form is hidden
            shopArea && (shopArea.style.display = 'none'); // Hide shop area if exists
        }
    });

    // Logout functionality
    logoutBtn.addEventListener('click', () => {
        alert('Đã đăng xuất!');
        loggedInUser = null;
        logoutBtn.style.display = 'none';
        userInfo.style.display = 'none';
        loginBtn.style.display = 'inline';
        registerBtn.style.display = 'inline';
        shopArea && (shopArea.style.display = 'none');
    });

    // Handle login form submission
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
                shopArea && (shopArea.style.display = 'block');
            } else {
                alert('Sai mật khẩu hoặc tên đăng nhập. Vui lòng thử lại.');
            }
        } else {
            alert('Tên đăng nhập không tồn tại. Vui lòng đăng ký.');
        }
    });

    // Handle register form submission
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
            shopArea && (shopArea.style.display = 'block');
        } else {
            alert('Mật khẩu xác nhận không khớp.');
        }
    });
});

    document.getElementById('priceFilter').addEventListener('change', filterProducts);
    document.getElementById('yearFilter').addEventListener('change', filterProducts);
    
    function filterProducts() {
        const priceFilterValue = document.getElementById('priceFilter').value;
        const yearFilterValue = document.getElementById('yearFilter').value;
        const products = document.querySelectorAll('.nc-item');
    
        products.forEach(function(product) {
            const price = parseInt(product.getAttribute('data-price'));
            const year = product.getAttribute('data-year');
    
            let displayByPrice = false;
            const displayByYear = (yearFilterValue === 'all' || year === yearFilterValue);
    
            if (priceFilterValue === 'all') {
                displayByPrice = true;
            } else if (priceFilterValue === 'below10b' && price < 500000000) {
                displayByPrice = true;
            } else if (priceFilterValue === '10to20b' && price >= 500000000 && price <= 1000000000) {
                displayByPrice = true;
            } else if (priceFilterValue === 'above20b' && price > 1000000000) {
                displayByPrice = true;
            }
    
            if (displayByPrice && displayByYear) {
                product.style.display = 'block';
            } else {
                product.style.display = 'none';
            }
        });
    }
    