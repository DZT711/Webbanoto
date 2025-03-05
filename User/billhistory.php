<?php
include 'header.php';
include 'connect.php';
?>
<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <link rel="icon" href="dp56vcf7.png" type="image/png">
    <script src="https://kit.fontawesome.com/8341c679e5.js" crossorigin="anonymous"></script>
    <!-- <link rel="stylesheet" href="history.css"> -->
         <script src="https://kit.fontawesome.com/8341c679e5.js" crossorigin="anonymous"></script>
    <title>Lịch sử mua hàng</title>
</head>
<style>
        /* Main container styles */
    body {
        font-family: Arial, sans-serif;
        background-color: #f4f4f4;
        margin: 0;
        padding: 20px;
    }
    
    /* Back button styles */
    .back-button {
        display: inline-flex;
        align-items: center;
        gap: 0.5rem;
        background-color: #007bff;
        color: white;
        padding: 0.8rem 1.5rem;
        text-decoration: none;
        border-radius: 6px;
        transition: all 0.3s ease;
        margin: 20px;
        box-shadow: 0 2px 4px rgba(0, 123, 255, 0.2);
    }
    
    .back-button:hover {
        background-color: #0056b3;
        transform: translateY(-2px);
        box-shadow: 0 4px 8px rgba(0, 123, 255, 0.3);
    }
    
    /* Page title */
    h1 {
        text-align: center;
        color: #2c3e50;
        margin: 2rem 0;
        font-size: 2rem;
        font-weight: 600;
        text-transform: uppercase;
    }
    
    /* Bill history container */
    #billHistory {
        max-width: 800px;
        margin: 0 auto;
        padding: 20px;
    }
    
    /* Individual bill styles */
    .bill-container {
        background-color: white;
        border-radius: 12px;
        box-shadow: 0 4px 6px rgba(0,0,0,0.1);
        margin-bottom: 25px;
        padding: 25px;
        transition: all 0.3s ease;
        animation: slideIn 0.5s ease;
    }
    
    .bill-container:hover {
        transform: translateY(-5px);
        box-shadow: 0 8px 15px rgba(0,0,0,0.1);
    }
    
    /* Bill header */
    .bill-header {
        display: flex;
        justify-content: space-between;
        align-items: center;
        border-bottom: 2px solid #e0e0e0;
        padding-bottom: 15px;
        margin-bottom: 20px;
    }
    
    .bill-header span {
        font-size: 1.1rem;
        color: #2c3e50;
        font-weight: 500;
    }
    
    /* Bill items */
    .bill-item {
        margin-bottom: 15px;
        padding: 10px 0;
        border-bottom: 1px solid #f0f0f0;
    }
    
    .bill-details {
        display: flex;
        justify-content: space-between;
        align-items: center;
        padding: 8px 0;
    }
    
    .bill-details span:first-child {
        color: #2c3e50;
        font-weight: 500;
    }
    
    .bill-details span:last-child {
        color: #007bff;
        font-weight: 600;
    }
    
    /* Bill total */
    .bill-total {
        text-align: right;
        margin-top: 20px;
        padding-top: 15px;
        border-top: 2px solid #e0e0e0;
        font-size: 1.2rem;
        color: #2c3e50;
        font-weight: 700;
    }
    
    /* Animations */
    @keyframes slideIn {
        from {
            opacity: 0;
            transform: translateY(20px);
        }
        to {
            opacity: 1;
            transform: translateY(0);
        }
    }
    
    /* Responsive design */
    @media (max-width: 768px) {
        body {
            padding: 10px;
        }
    
        .back-button {
            margin: 10px;
            padding: 0.6rem 1.2rem;
        }
    
        h1 {
            font-size: 1.5rem;
            margin: 1.5rem 0;
        }
    
        #billHistory {
            padding: 10px;
        }
    
        .bill-container {
            padding: 15px;
            margin-bottom: 15px;
        }
    
        .bill-header {
            flex-direction: column;
            gap: 10px;
            align-items: flex-start;
        }
    
        .bill-details {
            flex-direction: column;
            align-items: flex-start;
            gap: 5px;
        }
    }
    
    /* Keep header.php important styles */
    .header-container {
        --header-bg: #f8f9fa;
        --header-text: #495057;
    }
    
    .header-container .navbar,
    .header-container .login-register-ctn {
        background-color: var(--header-bg);
    }
    
    /* Keep footer.php important styles */
    footer {
        background-color: #F7F7F7;
        margin-top: 50px;
    }
</style>
<style>
        /* Add to your existing styles */
    .bill-header span i,
    .bill-details span i,
    .bill-total i {
        margin-right: 8px;
        color: #007bff;
    }
    
    h1 i {
        margin-right: 12px;
        color: #007bff;
    }
    
    .bill-header span {
        display: flex;
        align-items: center;
        gap: 8px;
    }
    
    .bill-details span {
        display: flex;
        align-items: center;
        gap: 8px;
    }
    
    .bill-total {
        display: flex;
        align-items: center;
        justify-content: flex-end;
        gap: 8px;
    }
    
    /* Icon hover effects */
    .bill-container:hover i {
        transform: scale(1.1);
        transition: transform 0.3s ease;
    }
    
    /* Responsive adjustments */
    @media (max-width: 768px) {
        .bill-header span i,
        .bill-details span i,
        .bill-total i {
            font-size: 0.9rem;
        }
        
        h1 i {
            font-size: 1.3rem;
        }
    }
</style>
<body>
    
    <a href="index.php" class="back-button">
        <i class="fas fa-arrow-left"></i>
        Trở Về
    </a>
    
    <h1>
        <i class="fas fa-history"></i>
        Lịch Sử Mua Hàng
    </h1>
    
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
                // Update the bill generation code
        billElement.innerHTML = `
            <div class="bill-header">
                <span>
                    <i class="fas fa-receipt"></i>
                    Hóa Đơn #${Math.floor(Math.random() * 1000000)}
                </span>
                <span>
                    <i class="far fa-calendar-alt"></i>
                    ${new Date().toLocaleDateString()}
                </span>
            </div>
            ${purchasedCars.map(car => `
                <div class="bill-item">
                    <div class="bill-details">
                        <span>
                            <i class="fas fa-car"></i>
                            ${car.name} (${car.year})
                        </span>
                        <span>
                            <i class="fas fa-tag"></i>
                            ${formatCurrency(car.price)}
                        </span>
                    </div>
                </div>
            `).join('')}
            <div class="bill-total">
                <i class="fas fa-money-bill-wave"></i>
                Tổng Cộng: ${formatCurrency(totalBill)}
            </div>
        `;
    </script>
</body>
</html>
<?php
include 'footer.php';
?>