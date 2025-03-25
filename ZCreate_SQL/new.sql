CREATE DATABASE webbanoto;
USE webbanoto;

-- Bảng users_acc (Người dùng)
CREATE TABLE users_acc (
    id INT AUTO_INCREMENT PRIMARY KEY,
    username VARCHAR(100) NOT NULL,
    password CHAR(255) NOT NULL,
    status ENUM('activated', 'disabled', 'banned') NOT NULL DEFAULT 'activated',
    register_date DATETIME DEFAULT CURRENT_TIMESTAMP,
    phone_num VARCHAR(20),
    email VARCHAR(255),
    role ENUM('user', 'admin') NOT NULL DEFAULT 'user',
    address VARCHAR(255),
    full_name VARCHAR(255)
);

-- Bảng car_types (Loại xe)
CREATE TABLE car_types (
    type_id INT AUTO_INCREMENT PRIMARY KEY,
    type_name VARCHAR(100) NOT NULL,
    logo_url VARCHAR(255),
    banner_url VARCHAR(255),
    description LONGTEXT,
    image_link VARCHAR(255)
);

-- Bảng products (Sản phẩm)
CREATE TABLE products (
    product_id INT AUTO_INCREMENT PRIMARY KEY,
    brand_id INT NOT NULL,
    car_name VARCHAR(255) NOT NULL,
    car_description TEXT,
    price DECIMAL(15,2) NOT NULL,
    image_link VARCHAR(255),
    status ENUM('selling', 'soldout', 'discounting', 'hidden') NOT NULL DEFAULT 'selling',
    sold_quantity INT DEFAULT 0,
    remain_quantity INT DEFAULT 0,
    max_speed DECIMAL(5,2),
    color VARCHAR(50),
    year_manufacture YEAR,
    engine_name VARCHAR(100),
    seat_number TINYINT,
    fuel_name VARCHAR(50),
    engine_power DECIMAL(5,2),
    time_0_100 DECIMAL(4,2),
    location VARCHAR(255),
    linkinfor VARCHAR(255),
    fuel_capacity VARCHAR(255),
    FOREIGN KEY (brand_id) REFERENCES car_types(type_id) ON DELETE CASCADE
);

-- Bảng cart (Giỏ hàng)
CREATE TABLE cart (
    cart_id INT AUTO_INCREMENT PRIMARY KEY,
    user_id INT NOT NULL,
    cart_status ENUM('activated', 'ordered', 'cancelled') NOT NULL DEFAULT 'activated',
    FOREIGN KEY (user_id) REFERENCES users_acc(id) ON DELETE CASCADE
);

-- Bảng cart_items (Mục trong giỏ hàng)
CREATE TABLE cart_items (
    cart_item_id INT AUTO_INCREMENT PRIMARY KEY,
    cart_id INT NOT NULL,
    product_id INT NOT NULL,
    quantity INT NOT NULL DEFAULT 1,
    FOREIGN KEY (cart_id) REFERENCES cart(cart_id) ON DELETE CASCADE,
    FOREIGN KEY (product_id) REFERENCES products(product_id) ON DELETE CASCADE
);

-- Bảng orders (Đơn hàng)
CREATE TABLE orders (
    order_id INT AUTO_INCREMENT PRIMARY KEY,
    user_id INT NOT NULL,
    order_date DATETIME DEFAULT CURRENT_TIMESTAMP,
    delivered_date DATETIME,
    expected_total_amount DECIMAL(20,2),
    VAT DECIMAL(20,2),
    shipping_address VARCHAR(255),
    distance FLOAT,
    shipping_fee DECIMAL(10,2),
    total_amount DECIMAL(20,2),
    payment_method_id INT NOT NULL,
    order_status ENUM('is pending', 'is confirmed', 'delivered', 'is delivering', 'cancelled', 'initiated', 'completed') DEFAULT 'initiated',
    description LONGTEXT,
    shipper_info VARCHAR(255),
    delivery_duration INT,
    FOREIGN KEY (user_id) REFERENCES users_acc(id) ON DELETE CASCADE,
    FOREIGN KEY (payment_method_id) REFERENCES payment_methods(payment_method_id) ON DELETE CASCADE
);

-- Bảng order_details (Chi tiết đơn hàng)
CREATE TABLE order_details (
    id INT AUTO_INCREMENT PRIMARY KEY,
    order_id INT NOT NULL,
    product_id INT NOT NULL,
    quantity INT NOT NULL,
    price DECIMAL(15,2) NOT NULL,
    FOREIGN KEY (order_id) REFERENCES orders(order_id) ON DELETE CASCADE,
    FOREIGN KEY (product_id) REFERENCES products(product_id) ON DELETE CASCADE
);

-- Bảng payment_methods (Phương thức thanh toán)
CREATE TABLE payment_methods (
    payment_method_id INT AUTO_INCREMENT PRIMARY KEY,
    method_name VARCHAR(50) NOT NULL,
    description VARCHAR(255)
);
