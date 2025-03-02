<!DOCTYPE html>
<html lang="vi">
<head>
    <meta charset="UTF-8">
    <title>Xem lại đơn hàng - Auto Car</title>
    <link href="https://cdn.jsdelivr.net/npm/tailwindcss@2.2.19/dist/tailwind.min.css" rel="stylesheet">
    
    <script src="review.js"></script>
    <link rel="stylesheet" href="review.css">
    <link rel="icon" href="dp56vcf7.png" type="image/png">
    <script src="https://kit.fontawesome.com/8341c679e5.js" crossorigin="anonymous"></script>
    
</head>
<body class="bg-gray-100">
    <div class="container mx-auto px-4 py-8">
        <div class="bg-white shadow-md rounded-lg overflow-hidden">
            <div class="bg-blue-600 text-white p-4">
                <h1 class="text-2xl font-bold text-center">XÁC NHẬN THÔNG TIN ĐƠN HÀNG</h1>
            </div>

            <div class="p-6">
                <div class="mb-6">
                    <h2 class="text-xl font-semibold mb-4">1. CHI TIẾT SẢN PHẨM</h2>
                    <div id="product-details" class="grid grid-cols-1 md:grid-cols-2 gap-4">
                        <!-- Product details will be dynamically populated by JavaScript -->
                    </div>
                </div>

                <div class="mb-6">
                    <h2 class="text-xl font-semibold mb-4">2. THÔNG TIN GIAO HÀNG</h2>
                    <div id="delivery-details" class="bg-gray-50 p-4 rounded-lg">
                        <p class="text-gray-600">Đang tải thông tin giao hàng...</p>
                    </div>
                </div>

                <div class="mb-6">
                    <h2 class="text-xl font-semibold mb-4">3. PHƯƠNG THỨC THANH TOÁN</h2>
                    <div class="grid grid-cols-1 md:grid-cols-2 gap-4">
                        <div class="bg-gray-50 p-4 rounded-lg">
                            <h3 class="font-medium mb-2">Thẻ tín dụng</h3>
                            <p id="credit-card-method" class="text-gray-600">Chưa chọn phương thức</p>
                        </div>
                        <div class="bg-gray-50 p-4 rounded-lg">
                            <h3 class="font-medium mb-2">Thẻ ATM / Tiền mặt</h3>
                            <p id="atm-method" class="text-gray-600">Chưa chọn phương thức</p>
                        </div>
                    </div>
                </div>

                <div class="flex justify-between mt-8">
                    <a href="delivery.php" class="bg-gray-300 text-gray-700 px-6 py-2 rounded hover:bg-gray-400">
                        Quay Lại
                    </a>
                    <a href="payment.php" class="bg-blue-600 text-white px-6 py-2 rounded hover:bg-blue-700">
                        Tiếp Tục Thanh Toán
                    </a>
                </div>
            </div>
        </div>

        <div class="text-center mt-6 text-gray-600">
            AUTO CAR - Chỉ Xe Chất - Giá Tốt Nhất!
        </div>
    </div>

    <script>document.addEventListener('DOMContentLoaded', () => {
    class RandomOrderGenerator {
        constructor() {
            this.products  = [
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

            this.provinces = ['Hà Nội', 'TP. Hồ Chí Minh', 'Đà Nẵng', 'Hải Phòng', 'Cần Thơ', 'Đồng Nai', 'Bình Dương'];
            this.districts = ['Quận 1', 'Quận 2', 'Quận 3', 'Quận 5', 'Quận 7', 'Quận 10', 'Bình Thạnh', 'Gò Vấp'];
        }

        generateRandomProducts(count = 2) {
            return Array.from({ length: count }, () => {
                const randomProduct = this.products[Math.floor(Math.random() * this.products.length)];
                return randomProduct;
            });
        }

        generateDeliveryInfo() {
            return {
                fullName: this.generateRandomName(),
                phone: this.generateRandomPhone(),
                province: this.getRandomItem(this.provinces),
                district: this.getRandomItem(this.districts),
                address: this.generateRandomAddress()
            };
        }

        generatePaymentMethod() {
            const methods = [
                { 
                    creditCard: this.generateCreditCardNumber(),
                    atmMethod: this.getRandomItem(['cash', 'bank_transfer', 'atm'])
                }
            ];
            return methods[0];
        }

        getRandomItem(array) {
            return array[Math.floor(Math.random() * array.length)];
        }

        generateRandomName() {
            const firstNames = ['Nguyễn', 'Trần', 'Lê', 'Phạm', 'Hoàng', 'Vũ'];
            const lastNames = ['Văn', 'Thị', 'Đức', 'Minh', 'Hùng', 'Mai'];
            const middleNames = ['Anh', 'Tuấn', 'Hương', 'Lan', 'Quốc', 'Thành'];

            return `${this.getRandomItem(firstNames)} ${this.getRandomItem(middleNames)} ${this.getRandomItem(lastNames)}`;
        }

        generateRandomPhone() {
            const prefixes = ['090', '091', '092', '088', '086', '089'];
            return `${this.getRandomItem(prefixes)} ${Math.floor(Math.random() * 9000000) + 1000000}`;
        }

        generateRandomAddress() {
            const streetTypes = ['Đường', 'Phố', 'Đại lộ', 'Ngõ'];
            const streetNames = ['Bà Huyện Thanh Quan', 'Trần Hưng Đạo', 'Lê Lợi', 'Nguyễn Trãi', 'Lý Thái Tổ'];

            return `Số ${Math.floor(Math.random() * 200) + 1} ${this.getRandomItem(streetTypes)} ${this.getRandomItem(streetNames)}`;
        }

        generateCreditCardNumber() {
            return Array.from({ length: 4 }, () => 
                Math.floor(Math.random() * 9000) + 1000
            ).join(' ');
        }

        displayReviewDetails() {
            const products = this.generateRandomProducts();
            const deliveryInfo = this.generateDeliveryInfo();
            const paymentMethod = this.generatePaymentMethod();

            // Hiển thị thông tin sản phẩm
            const productContainer = document.getElementById('product-details');
            if (productContainer) {
                let totalPrice = 0;
                const productList = products.map(item => {
                    totalPrice += item.price;
                    return `
                        <div class="bg-gray-50 p-4 rounded-lg">
                            <div class="flex justify-between">
                                <span class="font-medium">${item.name} (${item.year})</span>
                                <span class="text-blue-600">${item.price.toLocaleString()} VND</span>
                            </div>
                            <div class="text-sm text-gray-500 mt-2">
                                <p>Vận tốc: ${item.speed}</p>
                                <p>Địa điểm: ${item.location}</p>
                            </div>
                        </div>
                    `;
                }).join('');

                productContainer.innerHTML = productList + `
                    <div class="bg-white border-t p-4">
                        <div class="flex justify-between">
                            <span class="font-semibold">Tổng số lượng:</span>
                            <span>${products.length} xe</span>
                        </div>
                        <div class="flex justify-between">
                            <span class="font-semibold">Tổng tiền:</span>
                            <span class="text-blue-600 font-bold">${totalPrice.toLocaleString()} VND</span>
                        </div>
                        <div class="flex justify-between">
                            <span>Thuế VAT (10%):</span>
                            <span>${(totalPrice * 0.1).toLocaleString()} VND</span>
                        </div>
                        <div class="flex justify-between font-bold">
                            <span>Tổng cộng:</span>
                            <span class="text-red-600">${(totalPrice * 1.1).toLocaleString()} VND</span>
                        </div>
                    </div>
                `;
            }

            // Hiển thị thông tin giao hàng
            const deliveryContainer = document.getElementById('delivery-details');
            if (deliveryContainer) {
                deliveryContainer.innerHTML = `
                    <div class="grid grid-cols-2 gap-4">
                        <div>
                            <p class="font-semibold text-gray-700">Thông Tin Người Nhận</p>
                            <p><strong>Họ và Tên:</strong> ${deliveryInfo.fullName}</p>
                            <p><strong>Số Điện Thoại:</strong> ${deliveryInfo.phone}</p>
                        </div>
                        <div>
                            <p class="font-semibold text-gray-700">Địa Chỉ Giao Hàng</p>
                            <p>${deliveryInfo.address}, ${deliveryInfo.district}, ${deliveryInfo.province}</p>
                        </div>
                    </div>
                `;
            }

            // Hiển thị thông tin thanh toán
            const creditCardMethod = document.getElementById('credit-card-method');
            const atmMethod = document.getElementById('atm-method');

            if (paymentMethod.creditCard) {
                const cardType = this.getRandomItem(['Visa', 'MasterCard', 'American Express']);
                creditCardMethod.innerHTML = `${cardType}: **** **** **** ${paymentMethod.creditCard.slice(-4)}`;
                creditCardMethod.classList.remove('text-gray-600');
                creditCardMethod.classList.add('text-green-600');
            }

            if (paymentMethod.atmMethod) {
                const methodLabels = {
                    'cash': 'Thanh toán tiền mặt',
                    'bank_transfer': 'Chuyển khoản ngân hàng',
                    'atm': 'Thanh toán qua thẻ ATM'
                };
                atmMethod.innerHTML = methodLabels[paymentMethod.atmMethod];
                atmMethod.classList.remove('text-gray-600');
                atmMethod.classList.add('text-green-600');
            }
        }
    }

    const reviewManager = new RandomOrderGenerator();
    reviewManager.displayReviewDetails();
});

    
    
    </script>


</body>
</html>