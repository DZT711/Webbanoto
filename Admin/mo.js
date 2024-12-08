document.addEventListener("DOMContentLoaded", () => {
    // Function to generate random order IDs
    function getRandomOrderID() {
        return Math.floor(10000 + Math.random() * 90000).toString();
    }

    // Function to generate random customer names
    function getRandomCustomerName() {
        const firstNames = ["Emily", "Chris", "Pat", "Taylor", "Jordan"];
        const lastNames = ["Smith", "Johnson", "Brown", "Williams", "Jones"];
        return `${firstNames[Math.floor(Math.random() * firstNames.length)]} ${lastNames[Math.floor(Math.random() * lastNames.length)]}`;
    }

    // Function to generate random order status
    function getRandomStatus() {
        const statuses = ["Pending", "Shipped", "Confirmed", "Delivered", "Cancelled"];
        return statuses[Math.floor(Math.random() * statuses.length)];
    }

    // Function to generate random date in dd/mm/yyyy format
    function getRandomDate() {
        const start = new Date(2023, 0, 1); // Start date: January 1, 2023
        const end = new Date(); // Current date
        const randomDate = new Date(start.getTime() + Math.random() * (end.getTime() - start.getTime()));
        const day = ("0" + randomDate.getDate()).slice(-2);
        const month = ("0" + (randomDate.getMonth() + 1)).slice(-2);
        const year = randomDate.getFullYear();
        return `${day}/${month}/${year}`;
    }

    // Function to generate random locations
    function getRandomLocation() {
        const locations = ["Tân Bình District", "District 1", "Bình Thạnh", "Phú Nhuận", "Go Vap", "Hóc Môn"];
        return locations[Math.floor(Math.random() * locations.length)];
    }

    // Populate the Order Management table with random data
    const orderTableBody = document.querySelector(".admin-table tbody");

    // Store all orders to enable filtering and sorting
    const allOrders = [];
    for (let i = 0; i < 50; i++) {
        const order = {
            id: getRandomOrderID(),
            customer: getRandomCustomerName(),
            status: getRandomStatus(),
            date: getRandomDate(),
            location: getRandomLocation(),
        };
        allOrders.push(order);
    }

    function displayOrders(orders) {
        orderTableBody.innerHTML = "";
        orders.forEach(order => {
            const row = document.createElement("tr");
            row.innerHTML = `
                <td>${order.id}</td>
                <td>${order.customer}</td>
                <td>${order.status}</td>
                <td>${order.date}</td>
                <td>${order.location}</td>
                <td>
                    <button onclick="window.location.href ='view-invoice.html'">View</button>
                </td>
            `;
            orderTableBody.appendChild(row);
        });
    }

    // Display all orders initially
    displayOrders(allOrders);

    // Filter by date range
    document.getElementById("start-date").addEventListener("change", filterOrders);
    document.getElementById("end-date").addEventListener("change", filterOrders);

    // Filter by status
    document.getElementById("status-filter").addEventListener("change", filterOrders);

    // Sort orders by location
    document.getElementById("sort-location").addEventListener("click", sortOrdersByLocation);

    // Filter orders based on selected date range and status
    function filterOrders() {
        const startDate = new Date(document.getElementById("start-date").value);
        const endDate = new Date(document.getElementById("end-date").value);
        const statusFilter = document.getElementById("status-filter").value;

        const filteredOrders = allOrders.filter(order => {
            const orderDate = new Date(order.date.split("/").reverse().join("-"));
            const isInDateRange = (!startDate || orderDate >= startDate) && (!endDate || orderDate <= endDate);
            const isStatusMatch = !statusFilter || order.status === statusFilter;

            return isInDateRange && isStatusMatch;
        });

        displayOrders(filteredOrders);
    }

    // Sort orders by location (alphabetically)
    function sortOrdersByLocation() {
        const sortedOrders = [...allOrders].sort((a, b) => a.location.localeCompare(b.location));
        displayOrders(sortedOrders);
    }
});
