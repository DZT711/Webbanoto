<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <link rel="icon" href="dp56vcf7.png" type="image/png">
    <script src="https://kit.fontawesome.com/8341c679e5.js" crossorigin="anonymous"></script>
    <link rel="stylesheet" href="history.css">
    <title>Lịch sử mua hàng</title>
</head>
<body>
    <a href="index.php" class="back-button"> Trở Về</a>

    <h1>Lịch Sử Mua Hàng</h1>
    
    <div id="billHistory"></div>

    <script>
        // Available cars from the previous HTML
        const cars = [
            { name: 'BMW 320i Sportline', price: 1529000000, year: 2024 },
            { name: 'BMW 330i M SPort', price: 1629000000, year: 2023 },
            { name: 'BMW 430i Convertible M Sport', price: 2629000000, year: 2021 },
            { name: 'BMW 735i M sport', price: 4499000000, year: 2023 },
            { name: 'BMW XM', price: 10990000000, year: 2022 },
            { name: 'MAZDA 6', price: 899000000, year: 2023 },
            { name: 'MAZDA 2', price: 420000000, year: 2021 },
            { name: 'MAZDA 3', price: 579000000, year: 2022 },
            { name: 'MAZDA CX-5', price: 829000000, year: 2023 },
            { name: 'MAZDA CX-8', price: 1109000000, year: 2024 },
            { name: 'Lamborghini Aventador SVJ', price: 60000000000, year: 2021 },
            { name: 'Lamborghini Gallardo', price: 5000000000, year: 2022 },
            { name: 'Lamborghini Huracan', price: 7100000000, year: 2023 },
            { name: 'Lamborghini Aventador LP 770-4 SVJ', price: 12000000000, year: 2024 },
            { name: 'Lamborghini Huracan Tecnica', price: 17900000000, year: 2024 }
        ];

        function formatCurrency(amount) {
            return new Intl.NumberFormat('vi-VN', { 
                style: 'currency', 
                currency: 'VND' 
            }).format(amount);
        }

        function generatePurchaseHistory(numBills = 5) {
            const billHistory = document.getElementById('billHistory');
            billHistory.innerHTML = ''; // Clear previous content

            for (let i = 0; i < numBills; i++) {
                // Randomly select cars
                const purchasedCars = [];
                const numCars = Math.floor(Math.random() * 10) + 1; // 1-3 cars per bill
                
                for (let j = 0; j < numCars; j++) {
                    const randomCar = cars[Math.floor(Math.random() * cars.length)];
                    purchasedCars.push(randomCar);
                }

                // Calculate total bill
                const totalBill = purchasedCars.reduce((sum, car) => sum + car.price, 0);

                // Create bill element
                const billElement = document.createElement('div');
                billElement.classList.add('bill-container');
                billElement.innerHTML = `
                    <div class="bill-header">
                        <span>Hóa Đơn #${Math.floor(Math.random() * 1000000)}</span>
                        <span>${new Date().toLocaleDateString()}</span>
                    </div>
                    ${purchasedCars.map(car => `
                        <div class="bill-item">
                            <div class="bill-details">
                                <span>${car.name} (${car.year})</span>
                                <span>${formatCurrency(car.price)}</span>
                            </div>
                        </div>
                    `).join('')}
                    <div class="bill-total">
                        Tổng Cộng: ${formatCurrency(totalBill)}
                    </div>
                `;

                billHistory.appendChild(billElement);
            }
        }

        // Generate bill history on page load
        generatePurchaseHistory();
    </script>
</body>
</html>