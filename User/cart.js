// Function to remove a cart item
function removeCartItem(element) {
    // Get the row element of the item to remove
    const row = element.closest('tr');
    
    // Remove the row from the table
    row.remove();

    // Update the cart summary
    updateCartSummary();
}

// Function to update the cart summary
function updateCartSummary() {
    const rows = document.querySelectorAll('.cart-content-left table tr');
    let totalItems = 0;
    let totalPrice = 0;

    // Iterate over the product rows
    rows.forEach((row, index) => {
        if (index === 0) return; // Skip the header row
        
        const quantityInput = row.querySelector('input[type="number"]');
        const priceText = row.querySelector('td:nth-child(4) p').innerText;
        const price = parseInt(priceText.replace(/\D/g, ''), 10); // Extract number from string
        
        totalItems += parseInt(quantityInput.value, 10);
        totalPrice += price * quantityInput.value;
    });

    // Update total items
    document.querySelector('.cart-content-right table tr:nth-child(2) td:nth-child(2)').innerText = totalItems;

    // Update total price
    const totalPriceElement = document.querySelector('.cart-content-right table tr:nth-child(3) td:nth-child(2) p');
    totalPriceElement.innerText = totalPrice.toLocaleString('vi-VN') + ' VND';

    // Update subtotal
    const subtotalElement = document.querySelector('.cart-content-right table tr:nth-child(4) td:nth-child(2) p');
    subtotalElement.innerText = totalPrice.toLocaleString('vi-VN') + ' VND';
}

// Function to handle quantity change
function handleQuantityChange(element) {
    // Update the cart summary
    updateCartSummary();
}

// Attach event listeners to quantity inputs
document.querySelectorAll('.cart-content-left table input[type="number"]').forEach(input => {
    input.addEventListener('input', function() {
        handleQuantityChange(this);
    });
});

// Initial update of the cart summary
document.addEventListener('DOMContentLoaded', () => {
    updateCartSummary();
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
    const checkoutButton = document.getElementById('checkout-button'); // Checkout button reference

    let loggedInUser = null;
    const users = [];

    // Toggle login form
    loginBtn.addEventListener('click', () => {
        if (loginForm.style.display === 'block') {
            loginForm.style.display = 'none';
        } else {
            loginForm.style.display = 'block';
            registerForm.style.display = 'none';
            shopArea && (shopArea.style.display = 'none');
        }
    });

    // Toggle register form
    registerBtn.addEventListener('click', () => {
        if (registerForm.style.display === 'block') {
            registerForm.style.display = 'none';
        } else {
            registerForm.style.display = 'block';
            loginForm.style.display = 'none';
            shopArea && (shopArea.style.display = 'none');
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

    // Checkout button click event
    checkoutButton.addEventListener('click', (e) => {
        // Always prevent default behavior of the button
        e.preventDefault();

        if (!loggedInUser) {
            alert('Bạn cần đăng nhập trước khi thanh toán.');
            return; // Stop further execution
        }

        // Redirect to the delivery page only if the user is logged in
        alert('Chuyển hướng đến trang thanh toán...');
        window.location.href = "delivery.html";
    });

    // Remove cart item functionality
    function removeCartItem(element) {
        const row = element.closest('tr');
        row.remove();
        updateCartSummary();
    }

    // Update cart summary
    function updateCartSummary() {
        const rows = document.querySelectorAll('.cart-content-left table tr');
        let totalItems = 0;
        let totalPrice = 0;

        rows.forEach((row, index) => {
            if (index === 0) return;

            const quantityInput = row.querySelector('input[type="number"]');
            const priceText = row.querySelector('td:nth-child(4) p').innerText;
            const price = parseInt(priceText.replace(/\D/g, ''), 10);

            totalItems += parseInt(quantityInput.value, 10);
            totalPrice += price;
        });

        document.querySelector('.cart-content-right table tr:nth-child(2) td:nth-child(2)').innerText = totalItems;

        const totalPriceElement = document.querySelector('.cart-content-right table tr:nth-child(3) td:nth-child(2) p');
        totalPriceElement.innerText = totalPrice.toLocaleString('vi-VN') + ' VND';

        const subtotalElement = document.querySelector('.cart-content-right table tr:nth-child(4) td:nth-child(2) p');
        subtotalElement.innerText = totalPrice.toLocaleString('vi-VN') + ' VND';
    }

    // Event listener for removing cart items
    document.querySelectorAll('.remove-item').forEach(item => {
        item.addEventListener('click', (e) => {
            removeCartItem(e.target);
        });
    });
});




