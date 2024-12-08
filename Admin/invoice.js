document.addEventListener("DOMContentLoaded", () => {
    // Function to generate a random invoice ID
    function getRandomInvoiceID() {
        return Math.floor(1000 + Math.random() * 9000).toString();
    }

    // Function to generate random customer names
    function getRandomCustomerName() {
        const firstNames = ["John", "Jane", "Robert", "Alice", "Charlie", "David"];
        const lastNames = ["Smith", "Johnson", "Brown", "Taylor", "Davis", "Miller"];
        return `${firstNames[Math.floor(Math.random() * firstNames.length)]} ${lastNames[Math.floor(Math.random() * lastNames.length)]}`;
    }

    // Function to generate random order status
    function getRandomStatus() {
        const statuses = ["Pending", "Shipped", "Delivered", "Cancelled"];
        return statuses[Math.floor(Math.random() * statuses.length)];
    }

    // Function to generate random customer address
    function getRandomAddress() {
        const streets = ["123 Elm St", "456 Oak Rd", "789 Maple Ave", "101 Pine Blvd"];
        const cities = ["New York", "Los Angeles", "Chicago", "Houston", "Phoenix"];
        return `${streets[Math.floor(Math.random() * streets.length)]}, ${cities[Math.floor(Math.random() * cities.length)]}`;
    }

    // Function to generate random products from provided product list
    const products = [
        { name: "BMW 320i Sportline", price: 1529000000, year: 2024, speed: "235 km/h", location: "TP.HCM", image: "3-series.jpeg" },
        { name: "BMW 330i M Sport", price: 1629000000, year: 2023, speed: "250 km/h", location: "TP.HCM", image: "trang-alpine-3.webp" },
        { name: "430i Convertible M Sport", price: 2629000000, year: 2021, speed: "250 km/h", location: "TP.HCM", image: "bmw3.png" },
        { name: "BMW 735i M Sport", price: 4499000000, year: 2023, speed: "250 km/h", location: "TP.HCM", image: "bmw4.png" },
        { name: "BMW XM", price: 10990000000, year: 2022, speed: "250 km/h", location: "TP.HCM", image: "bmw5.jpg" },
        { name: "MAZDA 6", price: 899000000, year: 2023, speed: "220 km/h", location: "TP.HCM", image: "mazda1.png" },
        { name: "MAZDA 2", price: 420000000, year: 2021, speed: "220 km/h", location: "TP.HCM", image: "mazda2.jpg" },
        { name: "MAZDA 3", price: 579000000, year: 2022, speed: "187 km/h", location: "TP.HCM", image: "mazda3.png" },
        { name: "MAZDA CX-5", price: 829000000, year: 2023, speed: "220 km/h", location: "TP.HCM", image: "mazda4.png" },
        { name: "MAZDA CX-8", price: 1109000000, year: 2024, speed: "240 km/h", location: "TP.HCM", image: "mazda5.webp" },
        { name: "Lamborghini Aventador SVJ", price: 60000000000, year: 2021, speed: "310 km/h", location: "TP.HCM", image: "lambo1.jpg" },
        { name: "Lamborghini Gallardo", price: 50000000000, year: 2022, speed: "309 km/h", location: "TP.HCM", image: "lambo2.png" },
        { name: "Lamborghini Huracan", price: 7100000000, year: 2023, speed: "325 km/h", location: "TP.HCM", image: "lambo3.jpg" },
        { name: "Lamborghini Aventador LP 770-4 SVJ", price: 12000000000, year: 2024, speed: "350 km/h", location: "TP.HCM", image: "lambo4.jpg" },
        { name: "Lamborghini Huracan Tecnica", price: 17900000000, year: 2024, speed: "325 km/h", location: "TP.HCM", image: "lambo5.jpg" }
    ];

    function getRandomProducts() {
        const numberOfItems = Math.floor(Math.random() * 5) + 1; // Random number of items (1-5)
        let productList = [];
        let totalAmount = 0;
        
        for (let i = 0; i < numberOfItems; i++) {
            const product = products[Math.floor(Math.random() * products.length)];
            productList.push(product);
            totalAmount += product.price;
        }
        
        return { productList, totalAmount };
    }

    // Function to generate a random purchase date
    function getRandomDate() {
        const start = new Date(2023, 0, 1); // January 1, 2023
        const end = new Date();
        const randomDate = new Date(start.getTime() + Math.random() * (end.getTime() - start.getTime()));
        return randomDate.toLocaleDateString();
    }

    // Populate the invoice details with random data
    document.getElementById("invoice-id").textContent = getRandomInvoiceID();
    document.getElementById("customer-name").textContent = getRandomCustomerName();
    document.getElementById("status").textContent = getRandomStatus();
    document.getElementById("address").textContent = getRandomAddress();
    
    const { productList, totalAmount } = getRandomProducts();
    const productListElement = document.getElementById("product-list");
    productList.forEach(product => {
        const productItem = document.createElement("li");
        productItem.textContent = `${product.name} - ${product.price.toLocaleString()} VND`;
        productListElement.appendChild(productItem);
    });

    document.getElementById("total-amount").textContent = totalAmount.toLocaleString();
    document.getElementById("purchase-date").textContent = getRandomDate();

    // Handle the "Trở về" button
    document.getElementById("back-btn").addEventListener("click", () => {
        window.history.back(); // Go back to the previous page
    });
});
