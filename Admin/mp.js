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

let currentEditIndex = null;

function renderProducts() {
    const productList = document.getElementById('product-list');
    productList.innerHTML = '';  // Clear any existing rows

    products.forEach((product, index) => {
        const row = document.createElement('tr');
        row.innerHTML = `
            <td>${product.name}</td>
            <td>${product.year}</td>
            <td>${product.price.toLocaleString()} VND</td>
            <td>${product.speed}</td>
            <td>
                <button onclick="showEditProductForm(${index})">Edit</button>
                <button onclick="deleteProduct(${index})">Delete</button>
            </td>
        `;
        productList.appendChild(row);
    });
}

function showAddProductForm() {
    document.getElementById('addProductModal').style.display = 'block';
    document.getElementById('modalOverlay').style.display = 'block';
}

function closeAddProductForm() {
    document.getElementById('addProductModal').style.display = 'none';
    document.getElementById('modalOverlay').style.display = 'none';
}

function addProduct(event) {
    event.preventDefault();
    const name = document.getElementById('productName').value;
    const year = document.getElementById('productYear').value;
    const price = document.getElementById('productPrice').value;
    const speed = document.getElementById('productSpeed').value;
    const image = document.getElementById('productImage').files[0] ? document.getElementById('productImage').files[0].name : '';

    products.push({ name, year, price, speed, image });
    renderProducts();
    closeAddProductForm();
}

function showEditProductForm(index) {
    const product = products[index];
    currentEditIndex = index;

    document.getElementById('editProductName').value = product.name;
    document.getElementById('editProductYear').value = product.year;
    document.getElementById('editProductPrice').value = product.price;
    document.getElementById('editProductSpeed').value = product.speed;
    document.getElementById('editProductImage').value = ''; // reset image

    document.getElementById('editProductModal').style.display = 'block';
    document.getElementById('modalOverlay').style.display = 'block';
}

function closeEditProductForm() {
    document.getElementById('editProductModal').style.display = 'none';
    document.getElementById('modalOverlay').style.display = 'none';
}

function editProduct(event) {
    event.preventDefault();
    const name = document.getElementById('editProductName').value;
    const year = document.getElementById('editProductYear').value;
    const price = document.getElementById('editProductPrice').value;
    const speed = document.getElementById('editProductSpeed').value;
    const image = document.getElementById('editProductImage').files[0] ? document.getElementById('editProductImage').files[0].name : '';

    products[currentEditIndex] = { name, year, price, speed, image };
    renderProducts();
    closeEditProductForm();
}

function deleteProduct(index) {
    const confirmDelete = confirm("Are you sure you want to delete this product?");
    if (confirmDelete) {
        products.splice(index, 1);
        renderProducts();
    }
}

window.onload = renderProducts;
