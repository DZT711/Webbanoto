<!DOCTYPE html>
<html lang="vi">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <link rel="stylesheet" href="result.css">
    <script src="https://kit.fontawesome.com/8341c679e5.js" crossorigin="anonymous"></script>
    <link rel="icon" href="dp56vcf7.png" type="image/png">

    <title>Kết quả tìm kiếm</title>
    <style>
        /* Style đơn giản cho kết quả */
        .results { margin: 20px; font-family: Arial, sans-serif; }
        .result-item { border: 1px solid #ccc; padding: 10px; margin: 10px 0; }
    </style>
</head>
<body>

    <div id="searchbar">
        <a href="index.php" class="home" >
            <i class="fa-solid fa-house">
    
            </i>
        </a>
        <p>&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;</p>
        <form action="search-results.php" method="GET" style="display: flex; align-items: center;">
            <input type="text" class="search" id="search" name="query" placeholder="Nhập hãng xe vd: Lamborghini,...." style="flex: 1; padding: 10px; font-size: 16px;">
            <button type="submit" style="padding: 10px 20px; font-size: 16px; margin-left: 5px; cursor: pointer;">
                <i class="fa fa-search"></i>
            </button>
        </form>
    </div>
    <h1>Kết quả tìm kiếm:</h1>
    <div class="results" id="results"></div>
    






    <script>
        // Lấy từ khóa tìm kiếm từ URL
        const urlParams = new URLSearchParams(window.location.search);
        const query = urlParams.get('query')?.toLowerCase() || '';

        // Dữ liệu mẫu (cần thay bằng API hoặc nguồn dữ liệu thực)
        const products = [
// Mảng chứa danh sách xe

    {
        name: "BMW 320i Sportline",
        price: 1529000000,
        year: 2024,
        speed: "235 km/h",
        location: "TP.HCM",
        image: "3-series.jpeg"
    },
    {
        name: "BMW 330i M Sport",
        price: 1629000000,
        year: 2023,
        speed: "250 km/h",
        location: "TP.HCM",
        image: "trang-alpine-3.webp"
    },
    {
        name: "430i Convertible M Sport",
        price: 2629000000,
        year: 2021,
        speed: "250 km/h",
        location: "TP.HCM",
        image: "bmw3.png"
    },
    {
        name: "BMW 735i M Sport",
        price: 4499000000,
        year: 2023,
        speed: "250 km/h",
        location: "TP.HCM",
        image: "bmw4.png"
    },
    {
        name: "BMW XM",
        price: 10990000000,
        year: 2022,
        speed: "250 km/h",
        location: "TP.HCM",
        image: "bmw5.jpg"
    },
    {
        name: "MAZDA 6",
        price: 899000000,
        year: 2023,
        speed: "220 km/h",
        location: "TP.HCM",
        image: "mazda1.png"
    },
    {
        name: "MAZDA 2",
        price: 420000000,
        year: 2021,
        speed: "220 km/h",
        location: "TP.HCM",
        image: "mazda2.jpg"
    },
    {
        name: "MAZDA 3",
        price: 579000000,
        year: 2022,
        speed: "187 km/h",
        location: "TP.HCM",
        image: "mazda3.png"
    },
    {
        name: "MAZDA CX-5",
        price: 829000000,
        year: 2023,
        speed: "220 km/h",
        location: "TP.HCM",
        image: "mazda4.png"
    },
    {
        name: "MAZDA CX-8",
        price: 1109000000,
        year: 2024,
        speed: "240 km/h",
        location: "TP.HCM",
        image: "mazda5.webp"
    },
    {
        name: "Lamborghini Aventador SVJ",
        price: 60000000000,
        year: 2021,
        speed: "310 km/h",
        location: "TP.HCM",
        image: "lambo1.jpg"
    },
    {
        name: "Lamborghini Gallardo",
        price: 50000000000,
        year: 2022,
        speed: "309 km/h",
        location: "TP.HCM",
        image: "lambo2.png"
    },
    {
        name: "Lamborghini Huracan",
        price: 7100000000,
        year: 2023,
        speed: "325 km/h",
        location: "TP.HCM",
        image: "lambo3.jpg"
    },
    {
        name: "Lamborghini Aventador LP 770-4 SVJ",
        price: 12000000000,
        year: 2024,
        speed: "350 km/h",
        location: "TP.HCM",
        image: "lambo4.jpg"
    },
    {
        name: "Lamborghini Huracan Tecnica",
        price: 17900000000,
        year: 2024,
        speed: "325 km/h",
        location: "TP.HCM",
        image: "lambo5.jpg"
    }


];

        // Tìm kiếm sản phẩm
        const results = products.filter(product => product.name.toLowerCase().includes(query));

        // Hiển thị kết quả
        const resultsDiv = document.getElementById('results');
        if (results.length > 0) {
            results.forEach(product => {
                resultsDiv.innerHTML += `
                    <div class="result-item">
                        <img src="${product.image}" alt="${product.name}" style="width: 150px; height: auto;">
                        <h2>${product.name}</h2>
                        <p>Giá: ${product.price}</p>
                        <p>Năm sản xuất: ${product.year}</p>
                        <p>Địa điểm: ${product.location}</p>
                    </div>
                `;
            });
        } else {
            resultsDiv.innerHTML = '<p>Không tìm thấy sản phẩm nào phù hợp.</p>';
        }
    </script>
</body>
</html>
