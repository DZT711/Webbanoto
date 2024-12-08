document.addEventListener("DOMContentLoaded", () => {
    // Dữ liệu các sản phẩm
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

    // Thêm thông tin số lượng bán ra cho mỗi sản phẩm
    products.forEach(product => {
        product.quantitySold = Math.floor(Math.random() * 1000); // Giả lập số lượng bán ra ngẫu nhiên từ 0 đến 999
    });

    // Sắp xếp các sản phẩm theo số lượng bán ra (từ cao đến thấp)
    const sortedProducts = products.sort((a, b) => b.quantitySold - a.quantitySold);

    // Hàm hiển thị các sản phẩm bán chạy nhất
    function displaySortedProducts() {
        const productListTableBody = document.querySelector("#product-list");
        productListTableBody.innerHTML = ""; // Xóa dữ liệu cũ trong bảng

        sortedProducts.forEach(product => {
            const row = document.createElement("tr");
            row.innerHTML = `
                <td>${product.name}</td>
                <td>${product.year}</td>
                <td>${product.price.toLocaleString()} VND</td>
                <td>${product.speed}</td>
                <td>${product.quantitySold}</td>
                <td>${(product.quantitySold * product.price).toLocaleString()} VND</td>
                <td>
                    <button onclick="window.location.href='view-product.html'">View</button>
                </td>
            `;
            productListTableBody.appendChild(row);
        });
    }

    // Hàm hiển thị sản phẩm bán chạy nhất và ế nhất
    function displayBestAndWorstSeller() {
        const bestSeller = sortedProducts[0];
        const worstSeller = sortedProducts[sortedProducts.length - 1];

        const bestSellerElement = document.createElement("p");
        bestSellerElement.innerHTML = `Best Seller: ${bestSeller.name} with ${bestSeller.quantitySold} sold, Revenue: ${(bestSeller.quantitySold * bestSeller.price).toLocaleString()} VND`;

        const worstSellerElement = document.createElement("p");
        worstSellerElement.innerHTML = `Worst Seller: ${worstSeller.name} with ${worstSeller.quantitySold} sold, Revenue: ${(worstSeller.quantitySold * worstSeller.price).toLocaleString()} VND`;

        // Thêm vào phần thông tin
        const statisticsSection = document.querySelector("#staticsforproducts");
        statisticsSection.appendChild(bestSellerElement);
        statisticsSection.appendChild(worstSellerElement);
    }

    // Hiển thị sản phẩm đã sắp xếp và thông tin bán chạy nhất và ế nhất
    displaySortedProducts();
    displayBestAndWorstSeller();
});
function displayBestAndWorstSeller() {
    const bestSeller = sortedProducts[0];
    const worstSeller = sortedProducts[sortedProducts.length - 1];

    const bestSellerElement = document.createElement("p");
    bestSellerElement.innerHTML = `Best Seller: ${bestSeller.name} with ${bestSeller.quantitySold} sold, Revenue: ${(bestSeller.quantitySold * bestSeller.price).toLocaleString()} VND`;
    bestSellerElement.classList.add("best-seller"); // Thêm class cho sản phẩm bán chạy nhất

    const worstSellerElement = document.createElement("p");
    worstSellerElement.innerHTML = `Worst Seller: ${worstSeller.name} with ${worstSeller.quantitySold} sold, Revenue: ${(worstSeller.quantitySold * worstSeller.price).toLocaleString()} VND`;
    worstSellerElement.classList.add("worst-seller"); // Thêm class cho sản phẩm ế nhất

    // Thêm vào phần thông tin
    const statisticsSection = document.querySelector("#staticsforproducts");
    statisticsSection.appendChild(bestSellerElement);
    statisticsSection.appendChild(worstSellerElement);
}

document.addEventListener("DOMContentLoaded", () => {
    // Hàm random revenue cho người mua
    function randomRevenue() {
        return (Math.random() * 1000000000000).toFixed(0); // Tạo doanh thu ngẫu nhiên từ 0 đến 1 tỷ VND
    }

    // Hàm random username cho người mua
    function randomUsername() {
        const names = ["DZT711", "ANH123", "HONGLEE", "JAMES001", "MARYX"];
        return names[Math.floor(Math.random() * names.length)];
    }

    // Mảng Top Buyers
    const topBuyers = [
        { username: "DZT711", email: "nguyensihuynsh7112005@gmail.com", role: "Admin", revenue: randomRevenue() },
        { username: "ANH123", email: "anh123@example.com", role: "User", revenue: randomRevenue() },
        { username: "HONGLEE", email: "honglee@example.com", role: "Moderator", revenue: randomRevenue() },
        { username: "JAMES001", email: "james001@example.com", role: "Admin", revenue: randomRevenue() },
        { username: "MARYX", email: "maryx@example.com", role: "User", revenue: randomRevenue() }
    ];

    // Hàm hiển thị Top Buyers
    function displayTopBuyers() {
        const topBuyersTableBody = document.querySelector("#staticsforcustomers tbody");

        topBuyers.forEach(buyer => {
            const row = document.createElement("tr");
            row.innerHTML = `
                <td>${buyer.username}</td>
                <td>${buyer.email}</td>
                <td>${buyer.role}</td>
                <td>${parseInt(buyer.revenue).toLocaleString()} VND</td>
                <td><button onclick="window.location.href='view-invoice.html'">View all bills</button></td>
            `;
            topBuyersTableBody.appendChild(row);
        });
    }

    // Gọi hàm hiển thị top buyers
    displayTopBuyers();
});
