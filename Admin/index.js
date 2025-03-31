
document.addEventListener("DOMContentLoaded", () => {
    // Function to generate random usernames
    function getRandomUsername() {
        const names = ["john", "jane", "smith", "doe", "charlie", "alice"];
        const suffix = Math.floor(Math.random() * 1000);
        return `${names[Math.floor(Math.random() * names.length)]}_${suffix}`;
    }

    // Function to generate random emails
    function getRandomEmail() {
        const domains = ["example.com", "mail.com", "test.org"];
        return `${getRandomUsername()}@${domains[Math.floor(Math.random() * domains.length)]}`;
    }

    // Function to generate random roles
    function getRandomRole() {
        const roles = ["Admin", "User", "Moderator"];
        return roles[Math.floor(Math.random() * roles.length)];
    }

    // Function to generate random orders
    function getRandomOrderID() {
        return Math.floor(10000 + Math.random() * 90000).toString();
    }

    function getRandomCustomerName() {
        const firstNames = ["Emily", "Chris", "Pat", "Taylor", "Jordan"];
        const lastNames = ["Smith", "Johnson", "Brown", "Williams", "Jones"];
        return `${firstNames[Math.floor(Math.random() * firstNames.length)]} ${lastNames[Math.floor(Math.random() * lastNames.length)]}`;
    }

    function getRandomStatus() {
        const statuses = ["Pending", "Shipped","Confirmed", "Delivered", "Cancelled"];
        return statuses[Math.floor(Math.random() * statuses.length)];
    }

    // Populate the User Management table
    const userTableBody = document.querySelector(".admin-table tbody");
    for (let i = 0; i < 20*Math.random(); i++) {
        const row = document.createElement("tr");
        row.innerHTML = `
            <td>${getRandomUsername()}</td>
            <td>${getRandomEmail()}</td>
            <td>${getRandomRole()}</td>
            <td>
                <button onclick="window.location.href='manage-users.html'" style="background-color: red;">Ban</button>
                <button onclick="window.location.href='manage-users.html'">Edit</button>
                <button onclick="window.location.href='manage-users.html'">Delete</button>
            </td>
        `;
        userTableBody.appendChild(row);
    }

    // Populate the Order Management table
    const orderTableBody = document.querySelector("section:nth-child(3) .admin-table tbody");
    for (let i = 0; i < 100*Math.random(); i++) {
        const row = document.createElement("tr");
        row.innerHTML = `
            <td>${getRandomOrderID()}</td>
            <td>${getRandomCustomerName()}</td>
            <td>${getRandomStatus()}</td>
            <td>
                <button onclick="window.location.href='manage-orders.html'">View</button>
                <button onclick="window.location.href='manage-orders.html'">Update</button>
            </td>
        `;
        orderTableBody.appendChild(row);
    }
});
// document.addEventListener("DOMContentLoaded", () => {
//     // Thêm sự kiện cho các nút "Ban"
//     document.querySelectorAll("button[style*='background-color: red;']").forEach((banButton) => {
//         banButton.addEventListener("click", () => {
//             const username = banButton.closest("tr").querySelector("td").textContent;
//             if (confirm(`Are you sure you want to ban the user ${username}?`)) {
//                 alert(`User "${username}" has been banned.`);
//                 banButton.closest("tr").remove(); // Xóa dòng tương ứng
//             }
//         });
//     });

//     // Thêm sự kiện cho các nút "Edit"
//     document.querySelectorAll(".admin-table button:contains('Edit')").forEach((editButton) => {
//         editButton.addEventListener("click", () => {
//             const username = editButton.closest("tr").querySelector("td").textContent;
//             alert(`Edit functionality for user "${username}" is under development.`);
//         });
//     });

//     // Thêm sự kiện cho các nút "Delete"
//     document.querySelectorAll(".admin-table button:contains('Delete')").forEach((deleteButton) => {
//         deleteButton.addEventListener("click", () => {
//             const username = deleteButton.closest("tr").querySelector("td").textContent;
//             if (confirm(`Are you sure you want to delete the user ${username}?`)) {
//                 alert(`User "${username}" has been deleted.`);
//                 deleteButton.closest("tr").remove(); // Xóa dòng tương ứng
//             }
//         });
//     });

//     // Thêm sự kiện cho các nút "View" trong bảng đơn hàng
//     document.querySelectorAll(".admin-table button:contains('View')").forEach((viewButton) => {
//         viewButton.addEventListener("click", () => {
//             const orderID = viewButton.closest("tr").querySelector("td").textContent;
//             alert(`Order details for Order ID: ${orderID} will be shown soon.`);
//         });
//     });

//     // Thêm sự kiện cho các nút "Update" trong bảng đơn hàng
//     document.querySelectorAll(".admin-table button:contains('Update')").forEach((updateButton) => {
//         updateButton.addEventListener("click", () => {
//             const orderID = updateButton.closest("tr").querySelector("td").textContent;
//             alert(`Update functionality for Order ID: ${orderID} is under development.`);
//         });
//     });
// });

document.addEventListener("DOMContentLoaded", () => {
    // Randomize Total Users, Orders Today, and Revenue
    const totalUsers = Math.floor(Math.random() * 1000) + 100; // Random from 100 to 1099
    const ordersToday = Math.floor(Math.random() * 50) + 1; // Random from 1 to 50
    const revenue = Math.floor(Math.random() * 10000000) + 1000000; // Random from 1M to 10M

    // Update the stats on the page
    document.querySelector(".stat-box:nth-child(1) p").textContent = totalUsers;
    document.querySelector(".stat-box:nth-child(2) p").textContent = ordersToday;
    document.querySelector(".stat-box:nth-child(3) p").textContent = `${revenue.toLocaleString()} đ`;

    // Ensure other admin functionalities work
    const adminUser = localStorage.getItem("adminUser");
    if (!adminUser) {
        window.location.href = "login.html";
    } else {
        document.getElementById("admin-name").textContent = adminUser;
    }

    // Button functionalities for "Ban", "Edit", "Delete", "View", "Update"
    // document.querySelectorAll("button[style*='background-color: red;']").forEach((banButton) => {
    //     banButton.addEventListener("click", () => {
    //         const username = banButton.closest("tr").querySelector("td").textContent;
    //         if (confirm(`Are you sure you want to ban the user ${username}?`)) {
    //             alert(`User "${username}" has been banned.`);
    //             banButton.closest("tr").remove();
    //         }
    //     });
    // });

    // document.querySelectorAll(".admin-table button:contains('Edit')").forEach((editButton) => {
    //     editButton.addEventListener("click", () => {
    //         const username = editButton.closest("tr").querySelector("td").textContent;
    //         alert(`Edit functionality for user "${username}" is under development.`);
    //     });
    // });

    // document.querySelectorAll(".admin-table button:contains('Delete')").forEach((deleteButton) => {
    //     deleteButton.addEventListener("click", () => {
    //         const username = deleteButton.closest("tr").querySelector("td").textContent;
    //         if (confirm(`Are you sure you want to delete the user ${username}?`)) {
    //             alert(`User "${username}" has been deleted.`);
    //             deleteButton.closest("tr").remove();
    //         }
    //     });
    // });

    // document.querySelectorAll(".admin-table button:contains('View')").forEach((viewButton) => {
    //     viewButton.addEventListener("click", () => {
    //         const orderID = viewButton.closest("tr").querySelector("td").textContent;
    //         alert(`Order details for Order ID: ${orderID} will be shown soon.`);
    //     });
    // });

    // document.querySelectorAll(".admin-table button:contains('Update')").forEach((updateButton) => {
    //     updateButton.addEventListener("click", () => {
    //         const orderID = updateButton.closest("tr").querySelector("td").textContent;
    //         alert(`Update functionality for Order ID: ${orderID} is under development.`);
    //     });
    // });

    document.getElementById("logout-btn").addEventListener("click", () => {
        localStorage.removeItem("adminUser"); // Clear the stored username
        window.location.href = "login.html"; // Redirect to login page
    });
});
