-- Cleaned SQL Dump for webbanoto: data removed for all tables except car_types, payment_methods, users_acc

CREATE DATABASE IF NOT EXISTS `webbanoto`;
USE `webbanoto`;

-- Table structure for table `cart`
CREATE TABLE `cart` (
  `cart_id` int(11) NOT NULL,
  `user_id` int(11) NOT NULL,
  `cart_status` enum('activated','ordered','cancelled') NOT NULL DEFAULT 'activated'
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

-- Table structure for table `cart_items`
CREATE TABLE `cart_items` (
  `cart_item_id` int(11) NOT NULL,
  `cart_id` int(11) NOT NULL,
  `product_id` int(11) NOT NULL,
  `quantity` int(11) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

-- Table structure for table `car_types`
CREATE TABLE `car_types` (
  `type_id` int(11) NOT NULL,
  `type_name` varchar(100) NOT NULL,
  `logo_url` varchar(255) DEFAULT NULL,
  `banner_url` varchar(255) DEFAULT NULL,
  `description` longtext DEFAULT NULL,
  `image_link` int(255) DEFAULT NULL,
  PRIMARY KEY (`type_id`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

-- Table structure for table `orders`
CREATE TABLE `orders` (
  `order_id` int(11) NOT NULL,
  `user_id` int(11) NOT NULL,
  `order_date` datetime DEFAULT NULL,
  `delivered_date` datetime DEFAULT NULL,
  `expected_total_amount` decimal(20,2) DEFAULT NULL,
  `VAT` decimal(20,2) DEFAULT NULL,
  `shipping_address` varchar(255) DEFAULT NULL,
  `distance` float NOT NULL DEFAULT 0,
  `shipping_fee` decimal(10,2) NOT NULL DEFAULT 0.00,
  `total_amount` decimal(20,2) DEFAULT NULL,
  `payment_method_id` int(11) DEFAULT NULL,
  `order_status` enum('is pending','is confirmed','delivered','is delivering','cancelled','initiated','completed') DEFAULT 'initiated',
  `description` longtext DEFAULT NULL,
  `shipper_info` varchar(255) DEFAULT NULL,
  `delivery_duration` int(11) GENERATED ALWAYS AS (timestampdiff(HOUR,`order_date`,`delivered_date`)) STORED,
  PRIMARY KEY (`order_id`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

-- Table structure for table `order_details`
CREATE TABLE `order_details` (
  `detail_id` int(11) NOT NULL,
  `order_id` int(11) NOT NULL,
  `product_id` int(11) NOT NULL,
  `quantity` int(11) NOT NULL,
  `price` decimal(15,2) NOT NULL,
  PRIMARY KEY (`detail_id`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

-- Table structure for table `payment_methods`
CREATE TABLE `payment_methods` (
  `payment_method_id` int(11) NOT NULL,
  `method_name` varchar(50) NOT NULL,
  `description` varchar(255) DEFAULT NULL,
  PRIMARY KEY (`payment_method_id`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

-- Table structure for table `products`
CREATE TABLE `products` (
  `product_id` int(11) NOT NULL,
  `brand_id` int(11) NOT NULL,
  `car_name` varchar(255) NOT NULL,
  `car_description` text DEFAULT NULL,
  `price` decimal(15,2) NOT NULL,
  `image_link` varchar(255) DEFAULT NULL,
  `status` enum('selling','soldout','discounting','hidden') DEFAULT 'selling',
  `sold_quantity` int(11) DEFAULT 0,
  `remain_quantity` int(11) DEFAULT 0,
  `max_speed` decimal(5,2) DEFAULT NULL,
  `color` varchar(50) DEFAULT NULL,
  `engine_name` varchar(100) NOT NULL,
  `year_manufacture` year(4) NOT NULL,
  `seat_number` tinyint(4) NOT NULL,
  `fuel_name` varchar(50) NOT NULL,
  `engine_power` decimal(5,2) NOT NULL,
  `time_0_100` decimal(4,2) DEFAULT NULL,
  `location` varchar(255) NOT NULL DEFAULT 'TPHCM',
  `linkinfor` varchar(255) DEFAULT NULL,
  `fuel_capacity` varchar(255) DEFAULT NULL,
  PRIMARY KEY (`product_id`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

-- Table structure for table `product_images`
CREATE TABLE `product_images` (
  `image_id` INT AUTO_INCREMENT PRIMARY KEY,
  `product_id` INT NOT NULL,
  `image_url` VARCHAR(255) NOT NULL,
  `sort_order` INT DEFAULT 0,
  `created_at` DATETIME DEFAULT CURRENT_TIMESTAMP
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4;

-- Table structure for table `users_acc`
CREATE TABLE `users_acc` (
  `id` int(11) NOT NULL,
  `username` varchar(100) NOT NULL,
  `password` char(255) NOT NULL,
  `status` enum('activated','disabled','banned') NOT NULL,
  `register_date` datetime NOT NULL DEFAULT current_timestamp(),
  `phone_num` varchar(20) NOT NULL,
  `email` varchar(255) NOT NULL,
  `role` enum('user','admin') NOT NULL DEFAULT 'user',
  `address` varchar(255) DEFAULT NULL,
  `full_name` varchar(255) DEFAULT NULL,
  PRIMARY KEY (`id`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

-- Preserve data only for car_types, payment_methods, users_acc

INSERT INTO `car_types` (`type_id`, `type_name`, `logo_url`, `banner_url`, `description`, `image_link`) VALUES
(1, 'lamborghini', 'https://img.logo.dev/lamborghini.com', NULL, NULL, NULL),
(2, 'bmw', 'https://img.logo.dev/bmw.com', NULL, NULL, NULL),
(3, 'mazda', 'https://img.logo.dev/mazda.com', NULL, NULL, NULL),
(4, 'tesla', 'https://img.logo.dev/tesla.com', NULL, NULL, NULL),
(5, 'audi', 'https://img.logo.dev/audi.com', NULL, NULL, NULL),
(6, 'ferrari', NULL, NULL, NULL, NULL),
(7, 'bugatti', NULL, NULL, NULL, NULL);

INSERT INTO `payment_methods` (`payment_method_id`, `method_name`, `description`) VALUES
(1, 'cash', 'Thanh toán tiền mặt'),
(2, 'VISA', 'Thẻ tín dụng'),
(3, 'ATM', 'Thẻ ATM');

INSERT INTO `users_acc` (`id`, `username`, `password`, `status`, `register_date`, `phone_num`, `email`, `role`, `address`, `full_name`) VALUES
(1, 'huy', 'huy', 'activated', '2025-03-02 15:10:59', '0989987678', 'huy702069@gmail.com', 'admin', 'Hẻm 37 Đường C1, Quận Tân Bình, Thành phố Hồ Chí Minh', 'Nguyễn Sĩ Huy'),
(2, 'd', '11111', 'activated', '2025-03-10 14:09:16', '0987653234', 'd@sgu.edu.vn', 'user', '52, Phan Đình Giót, Quận Tân Bình, Thành phố Hồ Chí Minh', 'dsdasds'),
(3, 'nguyen', '$2y$10$Nj9Iczysfc3I.fyfPHE9mO0GzdIgliugI6xErXyNHjVrBh1jwtRWa', 'banned', '2025-03-12 10:50:59', '908786', 'nguyensihuynsh711@gmail.com', 'user', 'vvbb', 'nhghgh'),
(4, 'g', '$2y$10$R8ilPnnU8H4X5t9v8SsdVuIGSaE/Ex6cgTzuvZKTFQzwgcBXtsFkW', 'disabled', '2025-03-12 10:57:53', '3234324534', 'f@gmail.com', 'admin', 'g', 'g'),
(5, 'fd', 'fd', 'activated', '2025-03-12 11:03:44', '0987698732', 'fd@concek', 'user', 'Quận 1, Thành phố Hồ Chí Minh', 'huy'),
(7, '2312', '3213', 'activated', '2025-03-12 11:09:09', '0913313556', '32131@23123', 'user', 'Hẻm 3 Cao Lỗ, Quận 8, Thành phố Hồ Chí Minh', '3123'),
(8, '123213', '2323', 'activated', '2025-03-12 11:17:38', '3213232131232', '1232@12', 'user', '12321', '123321'),
(9, 'nguy', 'nguy', 'activated', '2025-03-21 11:46:45', '0987214453', 'nguyensihuynsh711@gmail.com', 'user', 'Hẻm 3 Cao Lỗ, Quận 8, Thành phố Hồ Chí Minh', 'gfg'),
(10, 'ng', 'ng', 'activated', '2025-03-28 09:33:55', '0834234242', 'nguyensihuynsh711@gmail.com', 'user', 'Quận 1, Thành phố Hồ Chí Minh', 'sadads');

COMMIT;

