document.addEventListener("DOMContentLoaded", () => {
    // Hàm tạo tên người dùng ngẫu nhiên
    function getRandomUsername() {
        const names = ["john", "jane", "smith", "doe", "charlie", "alice"];
        const suffix = Math.floor(Math.random() * 1000); // Số ngẫu nhiên từ 0-999
        return `${names[Math.floor(Math.random() * names.length)]}_${suffix}`;
    }

    // Hàm tạo email ngẫu nhiên
    function getRandomEmail() {
        const domains = ["example.com", "mail.com", "test.org"];
        return `${getRandomUsername()}@${domains[Math.floor(Math.random() * domains.length)]}`;
    }

    // Hàm tạo vai trò ngẫu nhiên
    function getRandomRole() {
        const roles = ["Admin", "User", "Moderator"];
        return roles[Math.floor(Math.random() * roles.length)];
    }

    // Thêm dữ liệu vào bảng Quản lý người dùng
    const userTableBody = document.querySelector(".admin-table tbody"); // Lấy phần thân của bảng
    for (let i = 0; i < 20*Math.random(); i++) { // Tạo 5 hàng dữ liệu ngẫu nhiên
        const row = document.createElement("tr");
        row.innerHTML = `
            <td>${getRandomUsername()}</td>
            <td>${getRandomEmail()}</td>
            <td>${getRandomRole()}</td>
            <td>
                            <button onclick="banUser(this)" style="background-color: red;">Ban</button>
                            <button onclick="editUser(this)">Edit</button>
                            <button onclick="deleteUser(this)">Delete</button>

            </td>
        `;
        userTableBody.appendChild(row); // Thêm hàng vào bảng
    }
});
function addUser() {
    const userTableBody = document.querySelector(".admin-table tbody");

    // Nhập thông tin người dùng
    const username = prompt("Enter username:");
    const email = prompt("Enter email:");
    const role = prompt("Enter role:");

    if (username && email && role) {
        // Tạo hàng mới
        const row = document.createElement("tr");
        row.innerHTML = `
            <td>${username}</td>
            <td>${email}</td>
            <td>${role}</td>
            <td>
                <button onclick="banUser(this)" style="background-color: red;">Ban</button>
                <button onclick="editUser(this)">Edit</button>
                <button onclick="deleteUser(this)">Delete</button>
            </td>
        `;
        userTableBody.appendChild(row);
    } else {
        alert("All fields are required to add a user!");
    }
}
function editUser(button) {
    const row = button.closest("tr"); // Lấy hàng chứa nút
    const usernameCell = row.children[0];
    const emailCell = row.children[1];
    const roleCell = row.children[2];

    // Nhập thông tin mới
    const newUsername = prompt("Enter new username:", usernameCell.textContent);
    const newEmail = prompt("Enter new email:", emailCell.textContent);
    const newRole = prompt("Enter new role:", roleCell.textContent);

    // Cập nhật thông tin
    if (newUsername) usernameCell.textContent = newUsername;
    if (newEmail) emailCell.textContent = newEmail;
    if (newRole) roleCell.textContent = newRole;
}
function banUser(button) {
    const row = button.closest("tr"); // Lấy hàng chứa nút
    const cells = row.querySelectorAll("td");

    // Gạch ngang thông tin
    cells.forEach((cell) => {
        cell.style.textDecoration = "line-through";
    });

    // Đổi màu nút Ban để thể hiện trạng thái
    button.disabled = true;
    button.textContent = "Banned";
    button.style.backgroundColor = "gray";
}
function deleteUser(button) {
    const row = button.closest("tr"); // Lấy hàng chứa nút
    row.remove(); // Xóa hàng
}
