-- phpMyAdmin SQL Dump
-- version 5.2.1
-- https://www.phpmyadmin.net/
--
-- Máy chủ: 127.0.0.1
-- Thời gian đã tạo: Th4 29, 2025 lúc 10:26 AM
-- Phiên bản máy phục vụ: 10.4.32-MariaDB
-- Phiên bản PHP: 8.2.12

SET SQL_MODE = "NO_AUTO_VALUE_ON_ZERO";
START TRANSACTION;
SET time_zone = "+00:00";


/*!40101 SET @OLD_CHARACTER_SET_CLIENT=@@CHARACTER_SET_CLIENT */;
/*!40101 SET @OLD_CHARACTER_SET_RESULTS=@@CHARACTER_SET_RESULTS */;
/*!40101 SET @OLD_COLLATION_CONNECTION=@@COLLATION_CONNECTION */;
/*!40101 SET NAMES utf8mb4 */;

--
-- Cơ sở dữ liệu: `webbanoto`
--
CREATE DATABASE IF NOT EXISTS `webbanoto` DEFAULT CHARACTER SET utf8mb4 COLLATE utf8mb4_general_ci;
USE `webbanoto`;

-- --------------------------------------------------------

--
-- Cấu trúc bảng cho bảng `cart`
--

CREATE TABLE IF NOT EXISTS `cart` (
  `cart_id` int(11) NOT NULL AUTO_INCREMENT,
  `user_id` int(11) NOT NULL,
  `cart_status` enum('activated','ordered','cancelled') NOT NULL DEFAULT 'activated',
  PRIMARY KEY (`cart_id`),
  KEY `fk_cart_user` (`user_id`)
) ENGINE=InnoDB AUTO_INCREMENT=12 DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

--
-- Cắt ngắn bảng trước khi chèn `cart`
--

TRUNCATE TABLE `cart`;
--
-- Đang đổ dữ liệu cho bảng `cart`
--

INSERT INTO `cart` (`cart_id`, `user_id`, `cart_status`) VALUES
(11, 1, '');

-- --------------------------------------------------------

--
-- Cấu trúc bảng cho bảng `cart_items`
--

CREATE TABLE IF NOT EXISTS `cart_items` (
  `cart_item_id` int(11) NOT NULL AUTO_INCREMENT,
  `cart_id` int(11) NOT NULL,
  `product_id` int(11) NOT NULL,
  `quantity` int(11) NOT NULL,
  PRIMARY KEY (`cart_item_id`),
  KEY `cart_id` (`cart_id`),
  KEY `product_id` (`product_id`)
) ENGINE=InnoDB AUTO_INCREMENT=21 DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

--
-- Cắt ngắn bảng trước khi chèn `cart_items`
--

TRUNCATE TABLE `cart_items`;
--
-- Đang đổ dữ liệu cho bảng `cart_items`
--

INSERT INTO `cart_items` (`cart_item_id`, `cart_id`, `product_id`, `quantity`) VALUES
(20, 11, 38, 14);

-- --------------------------------------------------------

--
-- Cấu trúc bảng cho bảng `car_types`
--

CREATE TABLE IF NOT EXISTS `car_types` (
  `type_id` int(11) NOT NULL AUTO_INCREMENT,
  `type_name` varchar(100) NOT NULL,
  `logo_url` varchar(255) DEFAULT NULL,
  `banner_url` varchar(255) DEFAULT NULL,
  `description` longtext DEFAULT NULL,
  `image_link` int(255) DEFAULT NULL,
  PRIMARY KEY (`type_id`)
) ENGINE=InnoDB AUTO_INCREMENT=9 DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

--
-- Cắt ngắn bảng trước khi chèn `car_types`
--

TRUNCATE TABLE `car_types`;
--
-- Đang đổ dữ liệu cho bảng `car_types`
--

INSERT INTO `car_types` (`type_id`, `type_name`, `logo_url`, `banner_url`, `description`, `image_link`) VALUES
(1, 'lamborghini', 'https://img.logo.dev/lamborghini.com', NULL, NULL, NULL),
(2, 'bmw', 'https://img.logo.dev/bmw.com', NULL, NULL, NULL),
(3, 'mazda', 'https://img.logo.dev/mazda.com', NULL, NULL, NULL),
(4, 'tesla', 'https://img.logo.dev/tesla.com', NULL, NULL, NULL),
(5, 'audi', 'https://img.logo.dev/audi.com', NULL, NULL, NULL),
(6, 'ferrari', 'https://img.logo.dev/ferrari.com', NULL, NULL, NULL),
(7, 'bugatti', 'https://img.logo.dev/bugatti.com', NULL, NULL, NULL),
(8, 'rolls-royce', NULL, NULL, NULL, NULL);

-- --------------------------------------------------------

--
-- Cấu trúc bảng cho bảng `orders`
--

CREATE TABLE IF NOT EXISTS `orders` (
  `order_id` int(11) NOT NULL AUTO_INCREMENT,
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
  PRIMARY KEY (`order_id`),
  KEY `user_id` (`user_id`),
  KEY `payment_method_id` (`payment_method_id`)
) ENGINE=InnoDB AUTO_INCREMENT=5 DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

--
-- Cắt ngắn bảng trước khi chèn `orders`
--

TRUNCATE TABLE `orders`;
--
-- Đang đổ dữ liệu cho bảng `orders`
--

INSERT INTO `orders` (`order_id`, `user_id`, `order_date`, `delivered_date`, `expected_total_amount`, `VAT`, `shipping_address`, `distance`, `shipping_fee`, `total_amount`, `payment_method_id`, `order_status`, `description`, `shipper_info`) VALUES
(1, 1, '2025-04-23 09:06:31', NULL, 1718560000000.00, 171856000000.00, 'Hẻm 37 Đường C1, Quận Tân Bình, Thành phố Hồ Chí Minh', 6.8, 680000.00, 1890416680000.00, 1, 'is confirmed', NULL, NULL),
(2, 1, '2025-04-26 09:44:59', NULL, 1650000000.00, 165000000.00, 'Hẻm 37 Đường C1, Quận Tân Bình, Thành phố Hồ Chí Minh', 6.81, 681000.00, 1815681000.00, 1, 'is pending', NULL, NULL),
(3, 1, '2025-04-28 12:47:35', NULL, 5232000000.00, 523200000.00, 'Hẻm 37 Đường C1, Quận Tân Bình, Thành phố Hồ Chí Minh', 0, 0.00, 5755200000.00, 1, 'is pending', NULL, NULL),
(4, 1, '2025-04-28 16:39:59', NULL, 49546000000.00, 4954600000.00, 'Hẻm 37 Đường C1, Quận Tân Bình, Thành phố Hồ Chí Minh', 6.8, 680000.00, 54501280000.00, 1, 'is pending', NULL, NULL);

-- --------------------------------------------------------

--
-- Cấu trúc bảng cho bảng `order_details`
--

CREATE TABLE IF NOT EXISTS `order_details` (
  `detail_id` int(11) NOT NULL AUTO_INCREMENT,
  `order_id` int(11) NOT NULL,
  `product_id` int(11) NOT NULL,
  `quantity` int(11) NOT NULL,
  `price` decimal(15,2) NOT NULL,
  PRIMARY KEY (`detail_id`),
  KEY `order_id` (`order_id`),
  KEY `product_id` (`product_id`)
) ENGINE=InnoDB AUTO_INCREMENT=5 DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

--
-- Cắt ngắn bảng trước khi chèn `order_details`
--

TRUNCATE TABLE `order_details`;
--
-- Đang đổ dữ liệu cho bảng `order_details`
--

INSERT INTO `order_details` (`detail_id`, `order_id`, `product_id`, `quantity`, `price`) VALUES
(1, 1, 42, 4, 429640000000.00),
(2, 2, 32, 1, 1650000000.00),
(3, 3, 54, 8, 654000000.00),
(4, 4, 38, 14, 3539000000.00);

-- --------------------------------------------------------

--
-- Cấu trúc bảng cho bảng `payment_methods`
--

CREATE TABLE IF NOT EXISTS `payment_methods` (
  `payment_method_id` int(11) NOT NULL AUTO_INCREMENT,
  `method_name` varchar(50) NOT NULL,
  `description` varchar(255) DEFAULT NULL,
  PRIMARY KEY (`payment_method_id`)
) ENGINE=InnoDB AUTO_INCREMENT=4 DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

--
-- Cắt ngắn bảng trước khi chèn `payment_methods`
--

TRUNCATE TABLE `payment_methods`;
--
-- Đang đổ dữ liệu cho bảng `payment_methods`
--

INSERT INTO `payment_methods` (`payment_method_id`, `method_name`, `description`) VALUES
(1, 'cash', 'Thanh toán tiền mặt'),
(2, 'VISA', 'Thẻ tín dụng'),
(3, 'ATM', 'Thẻ ATM');

-- --------------------------------------------------------

--
-- Cấu trúc bảng cho bảng `products`
--

CREATE TABLE IF NOT EXISTS `products` (
  `product_id` int(11) NOT NULL AUTO_INCREMENT,
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
  `engine_power` decimal(10,2) DEFAULT NULL,
  `time_0_100` decimal(4,2) DEFAULT NULL,
  `location` varchar(255) NOT NULL DEFAULT 'TPHCM',
  `linkinfor` varchar(255) DEFAULT NULL,
  `fuel_capacity` varchar(255) DEFAULT NULL,
  PRIMARY KEY (`product_id`),
  KEY `fk_products_brand` (`brand_id`)
) ENGINE=InnoDB AUTO_INCREMENT=69 DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

--
-- Cắt ngắn bảng trước khi chèn `products`
--

TRUNCATE TABLE `products`;
--
-- Đang đổ dữ liệu cho bảng `products`
--

INSERT INTO `products` (`product_id`, `brand_id`, `car_name`, `car_description`, `price`, `image_link`, `status`, `sold_quantity`, `remain_quantity`, `max_speed`, `color`, `engine_name`, `year_manufacture`, `seat_number`, `fuel_name`, `engine_power`, `time_0_100`, `location`, `linkinfor`, `fuel_capacity`) VALUES
(1, 8, 'Rolls-Royce Phantom VII 2025', 'Rolls-Royce Phantom 2025 không chỉ là một phương tiện di chuyển mà còn là biểu tượng của sự xa hoa và đẳng cấp, dành cho những ai tìm kiếm trải nghiệm lái xe đỉnh cao và sự tinh tế trong từng chi tiết.', 46183000000.00, 'uploads/1745340040_phantom-scintilla-private-collection-0-1-66b50a5eddd44.avif', 'selling', 0, 0, 250.00, 'Xám tungsten đậm nhất, Xanh sapphire nửa đêm, X', 'Động cơ V12 tăng áp kép 6.75L', '2025', 5, 'Xăng cao cấp', 562.00, NULL, 'TPHCM', NULL, '100L'),
(29, 5, 'e-tron GT', 'Audi e-tron GT mang thiết kế đặc trưng của Audi nhưng với phong cách tương lai, tương tự như người anh em A7 Sportback. \r\nBộ mâm 20 inch có thiết kế chấu khí động học. \r\nXe được phát triển dựa trên nền tảng hiệu suất cao J1 Performance của Tập đoàn Volkswagen do Porsche thiết kế, chia sẻ từ người anh em Taycan.\r\n Ngay trong buổi giới thiệu ra thế giới lần đầu tiên, Audi nhấn mạnh vào hai yếu tố của e-tron GT: sự sang trọng và trải nghiệm lái thể thao.', 3950000000.00, 'uploads/1745321314_Picture1.jpg', 'selling', 0, 0, 245.00, 'Xám Kemora, Xanh Tactical, Đen Mythos, Trắng Ibis', 'Động cơ điện', '2021', 4, 'Điện', 476.00, NULL, 'TPHCM', NULL, '93,4 kWh'),
(30, 2, 'BMW i4', 'BMW i4 là một trong hai mẫu ô tô điện mới được BMW Trường Hải (Thaco) phân phối tại Việt Nam từ tháng 8, bên cạnh mẫu iX3. Phiên bản duy nhất eDrive40 được nhập khẩu từ Đức có giá 3,759 tỷ đồng. Trên thị trường quốc tế, i4 còn có phiên bản eDrive35 (dẫn động cầu sau giống eDrive40), xDrive40 và M50 (dẫn động bốn bánh). Mẫu i4 được phát triển dựa trên nền tảng Series 4 Gran Coupé thế hệ hiện tại hoặc nền tảng Series 3. BMW sử dụng số chẵn để đặt tên cho các dòng coupe, ký hiệu \"i\" chỉ các mẫu xe điện hóa.', 3799000000.00, 'uploads/1745323785_Picture6.png', 'selling', 0, 0, 190.00, 'Trắng Alpine, Đen Sapphire, Trắng Khoáng, Brook', 'Động cơ điện', '2021', 5, 'Điện', 340.00, NULL, 'TPHCM', NULL, '83,9 kWh'),
(31, 5, 'Q6 e-tron', 'Audi Q6 e-tron là một trong những chiếc xe có thiết kế tương lai, điểm nhấn đặc biệt từ khoang nội thất mang đến ấn tượng khó phai cho người dùng.\r\n\r\nĐối với những gia đình cần một chiếc xe rộng rãi, di chuyển êm ái, nhẹ nhàng và theo xu hướng tương lai thì xe điện Audi Q6 e-tron 2025 là lựa chọn tuyệt vời thời điểm này. Không chỉ đáp ứng những nhu cầu trên, Audi Q6 e-tron còn sở hữu thiết kế khiến nhiều người “mê mẩn”.', 2300000000.00, 'uploads/1745323676_Picture2.png', 'selling', 0, 0, 210.00, 'Trắng Glacier, Xám Magnetic, Đỏ Solid, Mythos Bl', 'Động cơ điện', '2024', 5, 'Điện', 382.00, NULL, 'TPHCM', NULL, '100 kWh'),
(32, 5, 'A4 Sedan', 'Mẫu sedan nhỏ nhất nhà Audi ra mắt lần đầu hồi 1994, cạnh tranh với các đối thủ như Mercedes C-class, BMW Series 3.', 1650000000.00, 'uploads/1745323709_Picture3.png', 'discounting', 0, 0, 250.00, 'Trắng Arkona, Đen Lấp Lánh, Xanh Navarra Meta', 'Động cơ xăng tăng áp 2.0L', '2025', 5, 'Xăng', 245.00, NULL, 'TPHCM', NULL, '58L'),
(33, 5, 'Q3 Sportback', 'Sự xuất hiện của Audi Q3 Sportback 2024 như một luồng gió mới giữa phân khúc SUV Coupe hạng sang vốn kén khách tại Việt Nam, được kỳ vọng sẽ cạnh tranh tốt hơn với các đối thủ sừng sỏ như Mercedes-Benz GLC Coupe, BMW X2, Lexus NX hay Jaguar E-Pace. Hiện nay, Audi Q3 Sportback 2024 mang đến cho người dùng 11 màu sắc ngoại thất, 4 kiểu ốp nội thất cùng gói tùy chọn S-line thể thao.', 2000000000.00, 'uploads/1745323740_Picture4.png', 'selling', 0, 0, 222.00, 'Xanh Turbo, Trắng Glacier Metallic, Xám Chronos M', 'Động cơ xăng tăng áp 2.0L', '2023', 5, 'Xăng', 188.00, NULL, 'TPHCM', NULL, '50L'),
(34, 5, 'Q8 SUV', 'Audi Q8 là một mẫu xe SUV hạng sang cỡ lớn của thương hiệu Audi, thuộc tập đoàn Volkswagen. Nó được giới thiệu lần đầu tiên vào năm 2017, đánh dấu sự gia nhập của Audi vào phân khúc SUV coupe cao cấp, đối đầu trực tiếp với các mẫu xe như BMW X6 và Mercedes-Benz GLE Coupe. Mẫu xe này được thiết kế để kết hợp sự sang trọng và thể thao của một chiếc sedan với sự tiện nghi và khả năng vận hành của một chiếc SUV.\r\n\r\nAudi Q8 được xây dựng trên nền tảng MLB Evo, nền tảng chung mà các mẫu xe hạng sang của Volkswagen Group sử dụng, bao gồm Audi Q7, Porsche Cayenne, và Volkswagen Touareg. Nền tảng này giúp Audi Q8 có thể cung cấp không gian nội thất rộng rãi và khả năng vận hành linh hoạt.', 4200000000.00, 'uploads/1745323764_Picture5.png', 'selling', 0, 0, 245.00, 'Đỏ Chili Metallic, Đen Orca Metallic, Carrara', 'Động cơ 3.0L V6 TFSI', '2024', 5, 'Xăng', 340.00, NULL, 'TPHCM', NULL, '85L'),
(35, 2, 'BMW XM', 'BMW XM mới kết hợp vẻ ngoài ấn tượng với hiệu suất cao của BMW M và công nghệ plug-in hybrid mạnh mẽ của thế hệ mới nhất.', 11000000000.00, 'uploads/1745323814_Picture7.png', 'discounting', 0, 0, 250.00, 'Xanh Urban, Xanh Anglesey Metallic, Petrol Mic', 'Động cơ V8 hybrid 4.4L', '2024', 5, 'Xăng', 644.00, NULL, 'TPHCM', NULL, '80L'),
(36, 2, 'Z4 Roadster', 'Đắm mình trong sức hút khó cưỡng từ mẫu xe mui trần đến từ thương hiệu BMW. Ngôi sao đường phố BMW Z4 sở hữu vẻ đẹp nội - ngoại thất nổi bật và đầy lôi cuốn. BMW Z4 giúp bạn tận hưởng cảm giác lái ở một đẳng cấp hoàn toàn khác biệt.\r\n\r\nBMW Z4 mang đến sự cuốn hút khó cưỡng từ sự kết hợp của một chiếc xe thể thao năng động cùng một mẫu mui trần tự do, phóng khoáng. Thiết kế lưới tản nhiệt hình quả thận đặc trưng của BMW Z4 kết hợp đèn sương mù và hốc gió táo bạo; mui mềm thời thượng; mâm xe hợp kim kết hợp cùng phanh thể thao M Sport, cụm đèn hậu thanh mảnh và ống xả mạ chrome... từng chi tiết kết hợp để tạo nên một tổng thể lôi cuốn, sẵn sàng trở thành người đồng hành cùng bạn tỏa sáng trên mọi hành trình.', 3139000000.00, 'uploads/1745323841_Picture8.png', 'selling', 0, 0, 250.00, 'Đỏ San Francisco, Xanh Misano, Đen Sapphire', 'Động cơ V8 hybrid 4.4L', '2024', 5, 'Xăng', 644.00, NULL, 'TPHCM', NULL, '80L'),
(37, 2, 'BMW 740i Pure Excellence', 'BMW 740i Pure Excellence là phiên bản cao cấp trong dòng sedan hạng sang BMW 7 Series, kết hợp giữa thiết kế sang trọng và công nghệ tiên tiến.', 5849000000.00, 'uploads/1745323862_Picture9.png', 'selling', 0, 0, 250.00, 'Trắng Alpine, Đen Sapphire, Xám Khoáng, Crim', 'Động cơ I6 3.0L TwinPower Turbo & hybrid nhẹ', '2024', 5, 'Xăng', 286.00, NULL, 'TPHCM', NULL, '70L'),
(38, 2, 'BMW iX3', 'Vượt xa định nghĩa đơn thuần của một chiếc xe thân thiện môi trường, BMW iX3 mới không chỉ là mẫu xe SAV thuần điện đầu tiên sở hữu những đột phá công nghệ tiên tiến hàng đầu, mà còn có khả năng vận hành đa địa hình, thể thao, khỏe khoắn, nhưng vẫn giữ được “thần thái” của sự sang trọng, đây cũng là sự đánh dấu bước chuyển mình mạnh mẽ cho giai đoạn phát triển mới của BMW', 3539000000.00, 'uploads/1745323884_Picture10.png', 'selling', 0, 0, 180.00, 'Trắng Alpine, Xám Oxide, Trắng Khoáng, Sophisto', 'Động cơ điện', '2024', 5, 'Điện', 286.00, NULL, 'TPHCM', NULL, '80 kWh'),
(39, 7, 'Bugatti Veyron', 'Siêu xe Bugatti Veyron là mẫu xe tiêu biểu của hãng, mẫu xe được yêu thích nhờ vào thiết kế đẹp mắt, công suất hoạt động trên cả tuyệt vời, nếu là một người yêu thích tốc độ thì Bugatti Veyron là một trong những cái tên đáng cân nhắc nhất trong phân khúc siêu xe. Mẫu xe này được đặt theo tên của tay đua người Pháp Pierre Veyron, người đã giành chiến thắng tại cuộc đua 24 Hours of Le Mans năm 1939.', 32200000000.00, 'uploads/1745324663_Picture1.jpg', 'selling', 0, 0, 407.00, 'Màu be và nâu, trắng và đen, bạc và xanh', 'Động cơ W16 8.0L với 4 tăng áp', '2005', 2, 'Xăng', 1001.00, NULL, 'TPHCM', NULL, '100L'),
(40, 7, 'Bugatti Chiron', 'Bugatti Chiron là một siêu xe huyền thoại được sản xuất bởi hãng xe Pháp Bugatti từ năm 2016 đến 2023. Mẫu xe này được đặt theo tên của tay đua người Pháp Louis Chiron, người đã thi đấu cho Bugatti từ năm 1928 đến 1958.', 68954000000.00, 'uploads/1745325350_Picture11.png', 'selling', 0, 0, 420.00, 'Trắng, xanh, xám, đen', 'Động cơ W16 8.0L với 4 tăng áp', '2016', 2, 'Xăng cao cấp', 1500.00, NULL, 'TPHCM', NULL, '100L'),
(41, 7, 'Bugatti Chiron Divo', 'Bugatti Chiron Divo là mẫu xe được nâng cấp từ đàn anh Bugatti Chiron. Theo hãng xe, Chiron Divo được phát triển dựa trên Chiron và nâng cao hiệu năng làm việc của xe. Đồng thời xây dựng thiết kế dựa trên ngôn ngữ mới của hãng đánh dấu sự trở lại của hãng xe siêu sang.', 133400000000.00, 'uploads/1745325489_Picture12.png', 'soldout', 0, 0, 380.00, 'Trắng, xanh, xám, đen', 'Động cơ W16 8.0L quad-tăng áp', '2018', 2, 'Xăng cao cấp', 1479.00, NULL, 'TPHCM', NULL, '100L'),
(42, 7, 'Bugatti La Voiture Noire', 'Bugatti La Voiture Noire là mẫu xe được nâng cấp từ đàn anh Bugatti Chiron. Theo hãng xe, Chiron Divo được phát triển dựa trên Chiron và nâng cao hiệu năng làm việc của xe. Đồng thời xây dựng thiết kế dựa trên ngôn ngữ mới của hãng đánh dấu sự trở lại của hãng xe siêu sang.', 429640000000.00, 'uploads/1745325599_Picture9.png', 'selling', 0, 0, 418.00, 'Đen carbon bóng', 'Động cơ W16 8.0L quad-tăng áp', '2021', 2, 'Xăng cao cấp', 1500.00, NULL, 'TPHCM', NULL, '100L'),
(43, 7, 'Bugatti Centodieci', 'Bugatti Centodieci là một siêu xe phiên bản giới hạn, được sản xuất để kỷ niệm 110 năm thành lập thương hiệu Bugatti và tri ân mẫu xe EB110 huyền thoại. Chỉ có 10 chiếc được chế tạo, mỗi chiếc có giá khoảng 9 triệu USD.', 207000000000.00, 'uploads/1745325713_Picture10.png', 'selling', 0, 0, 380.00, 'Xanh, trắng', 'Động cơ W16 8.0L twin-tăng áp', '2021', 2, 'Xăng cao cấp', 1578.00, NULL, 'TPHCM', NULL, '100L'),
(44, 6, 'Ferrari LaFerrari', 'Ferrari LaFerrari thuộc nhóm những mẫu siêu xe “không phải có tiền là có thể sở hữu”. Bởi chỉ có khoảng 500 chiếc trên thế giới và LaFerrari chỉ dành riêng cho giới siêu giàu.\r\nFerrari LaFerrari là siêu xe hybrid sản xuất giới hạn, đánh dấu bước đầu tiên của Ferrari trong công nghệ hybrid. Ra mắt tại Triển lãm ô tô Geneva 2013, chỉ có 499 chiếc được sản xuất từ năm 2013 đến năm 2016.', 32660000000.00, 'uploads/1745325889_Picture11.png', 'selling', 0, 0, 350.00, 'Đỏ Corsa, Vàng Modena, Trắng Avus', 'Động cơ V12 6.3L kết hợp với động cơ điện 120 kW', '2013', 2, 'Xăng', 963.00, NULL, 'TPHCM', NULL, '85L'),
(45, 6, 'Ferrari Roma', 'Ferrari Roma là một mẫu GT (Grand Touring) coupe 2+2 động cơ đặt giữa ra mắt vào năm 2019. Tên gọi của mẫu xe thể thao này được đặt nhằm tôn vinh thủ đô Rome của Ý.\r\n\r\nFerrari Roma sở hữu diện mạo dễ làm người ta liên tưởng với “huyền thoại” Ferrari Maranello thu hút với form dáng thon dài uyển chuyển của những năm 1990.', 5175000000.00, 'uploads/1745325925_Picture12.png', 'discounting', 0, 0, 320.00, 'Trắng, xanh, xám, đen', 'Động cơ V8 3.9L twin-tăng áp', '2019', 2, 'Xăng', 620.00, NULL, 'TPHCM', NULL, '80L'),
(46, 6, 'Ferrari Portofino', 'Ferrari Portofino là một mẫu GT mui trần 2+2, kế thừa Ferrari California, ra mắt vào năm 2017.\r\n\r\nSo với “người tiền nhiệm”, Ferrari Portofino sở hữu diện mạo hoàn toàn mới, sắc sảo và góc cạnh hơn. Từ lưới tản nhiệt đến cụm đèn pha LED đều phảng phất bóng dáng GTC4Lusso. Cũng như các mẫu xe mui trần khác của Ferrari, Portofino sử dụng mui cứng có thể đóng/mở chỉ trong 14 giây ở dải vận tốc dưới 45 km/h.', 4922000000.00, 'uploads/1745325963_Picture14.png', 'selling', 0, 0, 320.00, 'Trắng, xanh, xám, đen', 'Động cơ V8 3.9L twin-tăng áp', '2017', 2, 'Xăng', 592.00, NULL, 'TPHCM', NULL, '80L'),
(47, 6, 'Ferrari F12 Berlinetta', 'Ferrari F12 Berlinetta tạo ấn tượng với giới đam mê siêu xe bởi lần bỏ xa Lamborghini Aventador trong một cuộc thử nghiệm. Siêu xe F12 Berlinetta sử dụng động cơ V12, 6.3L cho công suất tối đa 730 mã lực tại 8.250 vòng/phút, mô men xoắn tối đa 690 Nm tại 6.000 vòng/phút. Hộp số sử dụng loại hộp số 7 cấp ly hợp kép DCT.\r\n\r\nXe cho khả năng tăng tốc từ 0 đến 100 Km/h trong 3,1 giây. Vận tốc tối đa Ferrari F12 Berlinetta đạt được là 340 Km/h. F12 Berlinetta bám đường cực tốt khi di chuyển vào cua.', 7452000000.00, 'uploads/1745325987_Picture15.png', 'selling', 0, 0, 340.00, 'Màu be và nâu, trắng và đen, bạc và xanh', 'Động cơ V12 6.3L hút khí tự nhiên', '2012', 2, 'Xăng', 740.00, NULL, 'TPHCM', NULL, '92L'),
(48, 6, 'Ferrari 812 Superfast', 'Ferrari 812 Superfast chính thức ra mắt vào năm 2017, đây là một mẫu siêu xe được xem là sự kế thừa của F12 Berlinetta. Thiết kế của 812 Superfast lấy nhiều cảm hứng từ F12 Berlinetta. Đèn pha LED dấu mốc đẹp mắt, bên cạnh còn có thêm hốc hút gió nhỏ. Lưới tản nhiệt dạng lưới một khoang mở rộng. Hông xe sử dụng đường dập gân kiểu mới.\r\n\r\nĐuôi xe Ferrari 812 Superfast cũng có nhiều chi tiết mới mẻ. Cụm đèn hậu kiểu đôi tối màu thay cho đèn tròn đơn. Phần viền cùng cánh gió trên nhô cao hơn. Bộ cản sau và cụm ống xả đôi thiết kế hầm hố hơn.', 7245000000.00, 'uploads/1745326047_Picture16.png', 'selling', 0, 0, 340.00, 'Trắng, xanh, xám, đen', 'Động cơ V12 6.5L hút khí tự nhiên', '2017', 2, 'Xăng', 800.00, NULL, 'TPHCM', NULL, '92L'),
(49, 1, 'Lamborghini Huracan Tecnica', 'Trong tiếng Tây Ban Nha, Huracan còn mang ý nghĩa là “cơn bão”. Mẫu siêu xe này không làm thất vọng nhà sản xuất khi đạt doanh số 14.022 chiếc chỉ trong 5 năm đầu tiên sau khi ra mắt. Được sản xuất dựa trên chiếc Evo RWD, nhưng bổ sung loạt trang bị thường thấy trên những chiếc Huracan cao cấp.', 19000000000.00, 'uploads/1745326360_download.jfif', 'selling', 0, 0, 325.00, 'Trắng, xanh, xám, đen', 'Động cơ V10 5.2L hút khí tự nhiên', '2022', 2, 'Xăng', 631.00, NULL, 'TPHCM', NULL, '80L'),
(50, 1, 'Lamborghini Urus', 'Lamborghini Urus 2025 có đầy đủ những phẩm chất ưu việt của một chiếc siêu xe hàng đầu. Nhưng nhiều người vẫn cho rằng các mẫu siêu SUV không phải là thế mạnh của Lamborghini và Urus 2025 sẽ bị lép vế trước những mẫu xe gầm thấp đã làm nên tên tuổi của thương hiệu. Câu trả lời cho điều này có lẽ phụ thuộc vào mỗi người. Lamborghini Urus 2025 được đánh giá là đối thủ phải khiến cho Bentley Bentayga, Porsche Cayenne hay Rolls-Royce Cullinan phải e sợ.', 13000000000.00, 'uploads/1745326414_download (1).jfif', 'selling', 0, 0, 305.00, 'Màu be và nâu, trắng và đen, bạc và xanh', 'Động cơ V8 4.0L twin-tăng áp', '2018', 5, 'Xăng', 641.00, NULL, 'TPHCM', NULL, '85L'),
(51, 1, 'Lamborghini Huracan EVO', 'Lamborghini Huracan Evo 2025 không hề lép vế so với hai người anh em chung nhà là Lamborghini Aventador SVJ và Lamborghini Urus. Ngay từ khi xuất hiện tại triển lãm Bangkok Motor Show 2019, Lamborghini Huracan Evo 2025 đã thu hút rất nhiều những nhân vật đại gia mê xe. Chiếc siêu xe này hứa hẹn sẽ là đối thủ đáng gờm của những tên tuổi như Ferrari 488 Pista, McLaren 720S và Porsche GT2 RS.', 18000000000.00, 'uploads/1745326464_download (2).jfif', 'selling', 0, 0, 325.00, 'Đỏ Mars, Cam Borealis, Đỏ Cadens Matt', 'Động cơ V10 5.2L hút khí tự nhiên', '2019', 2, 'Xăng', 631.00, NULL, 'TPHCM', NULL, '80L'),
(52, 1, 'Lamborghini Huracan STO', 'Một siêu xe thể thao được tạo ra với mục đích duy nhất, Huracán STO mang đến tất cả cảm giác và công nghệ của một chiếc xe đua thực thụ trong một mẫu xe hợp pháp trên đường phố.\r\n\r\nKiến thức chuyên môn về xe đua thể thao nhiều năm của Lamborghini, được tăng cường bởi di sản chiến thắng, được tập trung vào Huracán STO mới. Khí động học cực đỉnh, động lực xử lý được mài giũa trên đường đua, nội dung nhẹ và động cơ V10 hiệu suất cao nhất cho đến nay kết hợp với nhau, sẵn sàng khơi dậy mọi cảm xúc của đường đua trong cuộc sống hàng ngày của bạn.', 29000000000.00, 'uploads/1745326505_download.jfif', 'selling', 0, 0, 310.00, 'Xanh và cam', 'Động cơ V10 5.2L hút khí tự nhiên', '2021', 2, 'Xăng', 631.00, NULL, 'TPHCM', NULL, '80L'),
(53, 1, 'Lamborghini Huracan Performante', 'Huracán Performante đã làm lại khái niệm về siêu xe thể thao và đưa khái niệm về hiệu suất lên một tầm cao chưa từng thấy trước đây. Chiếc xe đã được thiết kế lại toàn bộ, về trọng lượng, công suất động cơ, khung gầm và trên hết là bằng cách giới thiệu một hệ thống khí động học chủ động tiên tiến: ALA. Việc sử dụng Forged Composites® đã được trao giải thưởng, một vật liệu sợi carbon rèn có thể định hình được cấp bằng sáng chế của Automobili Lamborghini, là một điểm nhấn thực sự tuyệt vời và góp phần làm cho chiếc xe thậm chí còn nhẹ hơn về trọng lượng. Bên cạnh các đặc tính công nghệ phi thường của nó, nó còn truyền tải một ý tưởng mới về vẻ đẹp.', 22000000000.00, 'uploads/1745326542_images.jfif', 'selling', 0, 0, 310.00, 'Đỏ Corsa, Vàng Modena, Trắng Avus', 'Động cơ V10 5.2L hút khí tự nhiên', '2021', 2, 'Xăng', 631.00, NULL, 'TPHCM', NULL, '80L'),
(54, 3, 'MAZDA CX-3', 'MAZDA CX-3 – Lựa chọn mới trong phân khúc SUV đô thị. Mẫu xe là sự kết hợp cân bằng giữa phong cách thiết năng động của mẫu xe SUV và trải nghiệm lái thú vị, linh hoạt của một chiếc Sedan. Sự kết hợp thú vị này sẽ mang đến nét riêng đặc trưng thể hiện cá tính và phong cách tự tin của người sở hữu.', 654000000.00, 'uploads/1745326574_download (1).jfif', 'discounting', 0, 0, 190.00, 'Trắng Snowflake Pearl Mica, Đen Jet Mica, Machin', 'Động cơ xăng thẳng hàng 4 xi-lanh SkyActiv-G 2.0L', '2015', 5, 'Xăng', 146.00, NULL, 'TPHCM', NULL, '48L'),
(55, 3, 'Mazda3', 'Mazda3 lấy cảm hứng từ mẫu concept nổi tiếng Vision Coupe – Mẫu xe Concept đẹp nhất thế giới năm 2018. Mazda3 được thiết kế phong cách & quyến rũ với các đường nét thanh thoát và sang trọng, khẳng định vẻ đẹp chuẩn mực vượt thời gian.', 669000000.00, 'uploads/1745326604_download (2).jfif', 'selling', 0, 0, 210.00, 'Trắng Arctic, Đen Jet, Xám Polymetal, Ceramic', 'Động cơ xăng thẳng hàng 4 xi-lanh SkyActiv-G 2.0L', '2003', 5, 'Xăng', 155.00, NULL, 'TPHCM', NULL, '50L'),
(56, 3, 'Mazda6', 'MAZDA6 – PHONG CÁCH VÀ LỊCH LÃM; Vẻ đẹp thực thụ trong thiết kế không đơn thuần là việc thoả mãn yếu tố thẩm mỹ mà còn khơi gợi hứng khởi hành động trong mỗi người.', 1140000000.00, 'uploads/1745801060_download (4).jfif', 'selling', 0, 0, 210.00, 'Trắng Snowflake Pearl Mica, Đen Jet Mica, Alum', '2.5L SkyActiv-G inline-4 động cơ xăng', '2002', 5, 'Petrol', 184.00, NULL, 'TPHCM', NULL, '62L'),
(57, 3, 'MAZDA CX-30', 'Hãy tận hưởng trải nghiệm lái hoàn hảo từ triết lý \"Jinba Ittai\" – Nhân Mã Hợp Nhất. Với Mazda CX-30, mỗi chuyến đi đều trở thành kỷ niệm khó quên.\r\n\r\nKhông gian nội thất hiện đại, rộng rãi. Mọi chi tiết được hoàn thiện bởi các bậc thầy nghệ nhân thủ công Takumi, trên nền tảng triết lý Human Centric – lấy con người làm trung tâm; để bạn luôn thư giãn và tận hưởng niềm vui lái xe, từ vị trí chân ga, tựa đầu và lưng cho đến các nút điều khiển được bố trí dễ dàng thao tác.\r\n\r\nNgôn ngữ thiết kế Kodo thế hệ 7G thổi hồn vào những chiếc xe tạo cảm giác sống động. Mazda CX-30 – mẫu crossover linh hoạt và năng động, chinh phục mọi ánh nhìn với thiết kế đậm chất Âu sang trọng.', 749000000.00, 'uploads/1745326658_download (4).jfif', 'selling', 0, 0, 190.00, 'Trắng Arctic, Đen Jet, Xám Polymetal, Ceramic', 'Động cơ xăng thẳng hàng 4 xi-lanh SkyActiv-G 2.0L', '2019', 5, 'Xăng', 153.00, NULL, 'TPHCM', NULL, '51L'),
(58, 3, 'Mazda2 Sport', 'Chậm rãi \"Nhìn\", \"Chạm\" và \"Cảm nhận\" hơi thở sành điệu, tự tin trong thiết kế KODO của mẫu xe thế hệ mới. Mẫu xe hướng bạn đến hình mẫu mà bạn khao khát.', 619000000.00, 'uploads/1745326688_download (5).jfif', 'selling', 0, 0, 190.00, 'Trắng Snowflake Pearl Mica, Đen Jet Mica, Machin', 'Động cơ xăng thẳng hàng 4 xi-lanh SkyActiv-G 1.5L', '2014', 5, 'Xăng', 110.00, NULL, 'TPHCM', NULL, '44L'),
(59, 4, 'Tesla Cybertruck', '\r\n\r\n140 / 5.000\r\n\r\nTesla Cybertruck là xe bán tải chạy hoàn toàn bằng điện được Tesla, Inc. giới thiệu vào tháng 11 năm 2019, sản xuất bắt đầu vào tháng 11 năm 2023', 2555000000.00, 'uploads/1745326726_download (6).jfif', 'hidden', 0, 0, 290.00, 'Trắng, xanh, xám, đen', 'Động cơ điện Monitor', '2023', 5, 'Điện', 845.00, NULL, 'TPHCM', NULL, '100 kWh'),
(60, 4, 'Tesla Semi', 'Tesla Semi là xe tải chạy hoàn toàn bằng điện Class 8 do Tesla, Inc. phát triển, được thiết kế để cách mạng hóa ngành vận tải hàng hóa và hậu cần với công nghệ tiên tiến và không phát thải. Lần đầu ra mắt vào năm 2017 và bắt đầu sản xuất năm 2022, Tesla Semi kết hợp hiệu suất cao với tính bền vững, cung cấp phạm vi hoạt động ấn tượng, khả năng tăng tốc nhanh và chi phí vận hành thấp.', 10375000000.00, 'uploads/1745326784_download (7).jfif', 'selling', 0, 0, 190.00, 'Trắng, xanh, xám, đen', 'Ba động cơ điện độc lập', '2022', 1, 'Điện', 999.00, NULL, 'TPHCM', NULL, '100 kWh'),
(61, 4, 'Tesla Model X', 'Tesla Model X là một chiếc SUV chạy hoàn toàn bằng điện hạng sang kết hợp hiệu suất cao, công nghệ tiên tiến và thiết kế mang tính tương lai. Ra mắt lần đầu tiên vào năm 2015, xe được biết đến với cửa sau cánh chim ưng đặc trưng, nội thất rộng rãi và các tính năng hỗ trợ người lái tiên tiến.', 2540000000.00, 'uploads/1745326816_download (8).jfif', 'selling', 0, 0, 262.00, 'Trắng ngọc trai đa lớp, đen trơn, bạc Midnight', 'Hệ truyền động điện 2 hoặc 3 mô-tơ dẫn động bốn bánh', '2015', 6, 'Điện', 999.00, NULL, 'TPHCM', NULL, '100 kWh'),
(62, 4, 'Tesla Model S', 'Tesla Model S là một chiếc xe sang chạy hoàn toàn bằng điện hiệu suất cao đã định nghĩa lại những gì xe điện có thể làm. Ra mắt vào năm 2012, mẫu xe này kết hợp thiết kế đẹp mắt, công nghệ tiên tiến và phạm vi hoạt động ấn tượng, khiến nó trở thành một trong những chiếc xe điện tiên tiến nhất trên thị trường.', 2415000000.00, 'uploads/1745326851_download (9).jfif', 'selling', 0, 0, 322.00, 'Trắng ngọc trai đa lớp, đen trơn, bạc Midnight', 'Hệ truyền động điện 2 hoặc 3 mô-tơ dẫn động bốn bánh', '2012', 5, 'Điện', 999.00, NULL, 'TPHCM', NULL, '100 kWh'),
(63, 4, 'Tesla Model Y', 'Tesla Model Y là một chiếc SUV cỡ trung chạy hoàn toàn bằng điện kết hợp hiệu suất, an toàn và tiện ích. Ra mắt vào năm 2020, xe có không gian lưu trữ rộng rãi, chỗ ngồi cho tối đa năm hành khách và các tính năng an toàn tiên tiến.', 1334500000.00, 'uploads/1745326888_download (10).jfif', 'selling', 0, 0, 250.00, 'Trắng ngọc trai đa lớp, đen trơn, bạc Midnight', 'Hệ dẫn động bốn bánh 2 mô-tơ', '2020', 5, 'Điện', 455.00, NULL, 'TPHCM', NULL, '83,9 кWh'),
(64, 8, 'Rolls-Royce Cullinan 2025', 'Rolls-Royce Cullinan 2025: SUV siêu sang đầu tiên của Rolls-Royce, kết hợp đỉnh cao tiện nghi và khả năng off-road nhẹ nhàng.', 53000000000.00, 'uploads/1745375391_download.jfif', 'selling', 0, 0, 250.00, 'Đen Black Badge, Bạc Silvershade', 'Động cơ V12 tăng áp kép 6.75L', '2025', 5, 'Xăng cao cấp', 571.00, 5.00, 'TPHCM', NULL, '100L'),
(65, 5, 'Audi A6 55 TFSI quattro 2025', 'Audi A6 2025 phiên bản 55 TFSI quattro – sedan hạng E với công nghệ mild-hybrid và hệ dẫn động bốn bánh toàn thời gian.', 5000000000.00, 'uploads/1745375436_download (1).jfif', 'selling', 0, 0, 250.00, 'Trắng Glacier White, Đen Mythos', 'Động cơ xăng tăng áp 3.0L V6 TFSI', '2025', 5, 'Xăng', 340.00, 5.10, 'TPHCM', NULL, '58L'),
(66, 2, 'BMW X5 xDrive40i 2025', 'BMW X5 2025 bản xDrive40i – SUV cỡ trung hạng sang, động cơ I6 tăng áp, nội thất rộng rãi, nhiều công nghệ hỗ trợ lái.', 4500000000.00, 'uploads/1745375490_download (2).jfif', 'selling', 0, 0, 250.00, 'Trắng Alpine White, Đen Sapphire', 'Động cơ I6 3.0L TwinPower Turbo', '2025', 5, 'Xăng', 340.00, 5.50, 'TPHCM', NULL, '83L'),
(67, 6, 'Ferrari SF90 Stradale', 'Ferrari SF90 Stradale – siêu xe hybrid sạc ngoài đầu tiên của Ferrari, động cơ V8 kết hợp 3 mô-tơ điện, tổng công suất 1.000+ mã lực.', 35000000000.00, 'uploads/1745375549_download (3).jfif', 'selling', 0, 0, 340.00, 'Đỏ Corsa, Đen Carbon', 'Động cơ V8 4.0L hybrid plug-in', '2021', 2, 'Xăng cao cấp', 1000.00, 2.50, 'TPHCM', NULL, '60L'),
(68, 4, 'Tesla Model 3 2025', 'Tesla Model 3 facelift 2025 – sedan điện cỡ nhỏ phổ thông, cập nhật thiết kế, phạm vi lên đến 580 km cho phiên bản Long Range.', 1400000000.00, 'uploads/1745375641_images.jfif', 'selling', 0, 0, 261.00, 'Trắng Pearl White, Đen Midnight', 'Dual Motor điện', '2025', 5, 'Điện', 450.00, 5.30, 'TPHCM', NULL, '75 kWh');

-- --------------------------------------------------------

--
-- Cấu trúc bảng cho bảng `product_images`
--

CREATE TABLE IF NOT EXISTS `product_images` (
  `image_id` int(11) NOT NULL AUTO_INCREMENT,
  `product_id` int(11) NOT NULL,
  `image_url` varchar(255) NOT NULL,
  `sort_order` int(11) DEFAULT 0,
  `created_at` datetime DEFAULT current_timestamp(),
  PRIMARY KEY (`image_id`),
  KEY `product_id` (`product_id`)
) ENGINE=InnoDB AUTO_INCREMENT=5 DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

--
-- Cắt ngắn bảng trước khi chèn `product_images`
--

TRUNCATE TABLE `product_images`;
--
-- Đang đổ dữ liệu cho bảng `product_images`
--

INSERT INTO `product_images` (`image_id`, `product_id`, `image_url`, `sort_order`, `created_at`) VALUES
(1, 29, 'uploads/1745836581_29_0_Picture1.png', 0, '2025-04-28 17:36:21'),
(2, 29, 'uploads/1745836581_29_1_Picture2.png', 1, '2025-04-28 17:36:21'),
(3, 29, 'uploads/1745836581_29_2_Picture3.png', 2, '2025-04-28 17:36:21'),
(4, 29, 'uploads/1745837212_29_0_Picture4.png', 0, '2025-04-28 17:46:52');

-- --------------------------------------------------------

--
-- Cấu trúc bảng cho bảng `users_acc`
--

CREATE TABLE IF NOT EXISTS `users_acc` (
  `id` int(11) NOT NULL AUTO_INCREMENT,
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
) ENGINE=InnoDB AUTO_INCREMENT=14 DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

--
-- Cắt ngắn bảng trước khi chèn `users_acc`
--

TRUNCATE TABLE `users_acc`;
--
-- Đang đổ dữ liệu cho bảng `users_acc`
--

INSERT INTO `users_acc` (`id`, `username`, `password`, `status`, `register_date`, `phone_num`, `email`, `role`, `address`, `full_name`) VALUES
(1, 'huy', 'huy', 'activated', '2025-03-02 15:10:59', '0989987678', 'huy702069@gmail.com', 'admin', 'Hẻm 37 Đường C1, Quận Tân Bình, Thành phố Hồ Chí Minh', 'Nguyễn Sĩ Huy'),
(2, 'd', '11111', 'activated', '2025-03-10 14:09:16', '0987653234', 'd@sgu.edu.vn', 'user', '52, Phan Đình Giót, Quận Tân Bình, Thành phố Hồ Chí Minh', 'dsdasds'),
(3, 'nguyen', '$2y$10$Nj9Iczysfc3I.fyfPHE9mO0GzdIgliugI6xErXyNHjVrBh1jwtRWa', 'banned', '2025-03-12 10:50:59', '908786', 'nguyensihuynsh711@gmail.com', 'user', 'vvbb', 'nhghgh'),
(4, 'g', '$2y$10$R8ilPnnU8H4X5t9v8SsdVuIGSaE/Ex6cgTzuvZKTFQzwgcBXtsFkW', 'disabled', '2025-03-12 10:57:53', '3234324534', 'f@gmail.com', 'admin', 'g', 'g'),
(5, 'fd', 'fd', 'activated', '2025-03-12 11:03:44', '0987698732', 'fd@concek', 'user', 'Quận 1, Thành phố Hồ Chí Minh', 'huy'),
(7, '2312', '3213', 'activated', '2025-03-12 11:09:09', '0913313556', '32131@23123', 'user', 'Hẻm 3 Cao Lỗ, Quận 8, Thành phố Hồ Chí Minh', '3123'),
(8, '123213', '2323', 'activated', '2025-03-12 11:17:38', '3213232131232', '1232@12', 'user', '12321', '123321'),
(9, 'nguy', 'nguy', 'activated', '2025-03-21 11:46:45', '0987214453', 'nguyensihuynsh711@gmail.com', 'user', 'Hẻm 3 Cao Lỗ, Quận 8, Thành phố Hồ Chí Minh', 'gfg'),
(10, 'ng', 'ng', 'activated', '2025-03-28 09:33:55', '0834234242', 'nguyensihuynsh711@gmail.com', 'user', 'Quận 1, Thành phố Hồ Chí Min', 'sadads'),
(13, 'Nguyễn Sĩ Huy', '111', 'activated', '2025-04-29 10:45:32', '0987698732', 'huy702069@gmail.com', 'admin', 'quảng ngãi', 'Nguyễn Sĩ Huy');

--
-- Các ràng buộc cho các bảng đã đổ
--

--
-- Các ràng buộc cho bảng `cart`
--
ALTER TABLE `cart`
  ADD CONSTRAINT `fk_cart_user` FOREIGN KEY (`user_id`) REFERENCES `users_acc` (`id`) ON DELETE CASCADE ON UPDATE CASCADE;

--
-- Các ràng buộc cho bảng `cart_items`
--
ALTER TABLE `cart_items`
  ADD CONSTRAINT `cart_items_ibfk_1` FOREIGN KEY (`cart_id`) REFERENCES `cart` (`cart_id`) ON DELETE CASCADE ON UPDATE CASCADE,
  ADD CONSTRAINT `cart_items_ibfk_2` FOREIGN KEY (`product_id`) REFERENCES `products` (`product_id`) ON DELETE CASCADE ON UPDATE CASCADE;

--
-- Các ràng buộc cho bảng `orders`
--
ALTER TABLE `orders`
  ADD CONSTRAINT `orders_ibfk_1` FOREIGN KEY (`user_id`) REFERENCES `users_acc` (`id`) ON DELETE CASCADE ON UPDATE CASCADE,
  ADD CONSTRAINT `orders_ibfk_2` FOREIGN KEY (`payment_method_id`) REFERENCES `payment_methods` (`payment_method_id`) ON DELETE CASCADE ON UPDATE CASCADE;

--
-- Các ràng buộc cho bảng `order_details`
--
ALTER TABLE `order_details`
  ADD CONSTRAINT `order_details_ibfk_1` FOREIGN KEY (`order_id`) REFERENCES `orders` (`order_id`) ON DELETE CASCADE ON UPDATE CASCADE,
  ADD CONSTRAINT `order_details_ibfk_2` FOREIGN KEY (`product_id`) REFERENCES `products` (`product_id`) ON DELETE CASCADE ON UPDATE CASCADE;

--
-- Các ràng buộc cho bảng `products`
--
ALTER TABLE `products`
  ADD CONSTRAINT `fk_products_brand` FOREIGN KEY (`brand_id`) REFERENCES `car_types` (`type_id`) ON DELETE CASCADE ON UPDATE CASCADE;

--
-- Các ràng buộc cho bảng `product_images`
--
ALTER TABLE `product_images`
  ADD CONSTRAINT `product_images_ibfk_1` FOREIGN KEY (`product_id`) REFERENCES `products` (`product_id`) ON DELETE CASCADE ON UPDATE CASCADE;
  
INSERT INTO `product_images` (`image_id`, `product_id`, `image_url`, `sort_order`, `created_at`) VALUES
(5, 49, 'uploads/1745917197_49_0_Picture1.png', 0, '2025-04-29 15:59:57'),
(6, 49, 'uploads/1745917197_49_1_Picture2.png', 1, '2025-04-29 15:59:57'),
(7, 49, 'uploads/1745917197_49_2_Picture3.png', 2, '2025-04-29 15:59:57'),
(8, 49, 'uploads/1745917198_49_3_Picture4.png', 3, '2025-04-29 15:59:58'),
(9, 49, 'uploads/1745917198_49_4_Picture5.png', 4, '2025-04-29 15:59:58'),
(10, 50, 'uploads/1745917537_50_0_Picture6.png', 0, '2025-04-29 16:05:37'),
(11, 50, 'uploads/1745917537_50_1_Picture7.png', 1, '2025-04-29 16:05:37'),
(12, 50, 'uploads/1745917537_50_2_Picture8.png', 2, '2025-04-29 16:05:37'),
(13, 50, 'uploads/1745917537_50_3_Picture9.png', 3, '2025-04-29 16:05:37'),
(14, 50, 'uploads/1745917537_50_4_Picture10.png', 4, '2025-04-29 16:05:37'),
(15, 51, 'uploads/1745917723_51_0_Picture11.png', 0, '2025-04-29 16:08:43'),
(16, 51, 'uploads/1745917723_51_1_Picture12.png', 1, '2025-04-29 16:08:43'),
(17, 51, 'uploads/1745917723_51_2_Picture13.png', 2, '2025-04-29 16:08:43'),
(18, 51, 'uploads/1745917723_51_3_Picture14.png', 3, '2025-04-29 16:08:43'),
(19, 51, 'uploads/1745917723_51_4_Picture15.png', 4, '2025-04-29 16:08:43'),
(20, 52, 'uploads/1745917822_52_0_Picture16.png', 0, '2025-04-29 16:10:22'),
(21, 52, 'uploads/1745917822_52_1_Picture17.png', 1, '2025-04-29 16:10:22'),
(22, 52, 'uploads/1745917822_52_2_Picture18.png', 2, '2025-04-29 16:10:22'),
(23, 52, 'uploads/1745917822_52_3_Picture19.png', 3, '2025-04-29 16:10:22'),
(24, 52, 'uploads/1745917822_52_4_Picture20.png', 4, '2025-04-29 16:10:22'),
(25, 53, 'uploads/1745918029_53_0_Picture21.png', 0, '2025-04-29 16:13:49'),
(26, 53, 'uploads/1745918029_53_1_Picture22.png', 1, '2025-04-29 16:13:49'),
(27, 53, 'uploads/1745918029_53_2_Picture23.png', 2, '2025-04-29 16:13:49'),
(28, 53, 'uploads/1745918029_53_3_Picture24.png', 3, '2025-04-29 16:13:49'),
(29, 53, 'uploads/1745918029_53_4_Picture25.png', 4, '2025-04-29 16:13:49'),
(30, 54, 'uploads/1745918165_54_0_Picture26.png', 0, '2025-04-29 16:16:05'),
(31, 54, 'uploads/1745918165_54_1_Picture27.png', 1, '2025-04-29 16:16:05'),
(32, 54, 'uploads/1745918165_54_2_Picture28.png', 2, '2025-04-29 16:16:05'),
(33, 54, 'uploads/1745918165_54_3_Picture29.png', 3, '2025-04-29 16:16:05'),
(34, 54, 'uploads/1745918165_54_4_Picture30.png', 4, '2025-04-29 16:16:05'),
(35, 56, 'uploads/1745918287_56_0_Picture31.png', 0, '2025-04-29 16:18:07'),
(36, 56, 'uploads/1745918287_56_1_Picture32.png', 1, '2025-04-29 16:18:07'),
(37, 56, 'uploads/1745918287_56_2_Picture33.png', 2, '2025-04-29 16:18:08'),
(38, 56, 'uploads/1745918288_56_3_Picture34.png', 3, '2025-04-29 16:18:08'),
(39, 56, 'uploads/1745918288_56_4_Picture35.png', 4, '2025-04-29 16:18:08'),
(40, 57, 'uploads/1745918395_57_0_Picture36.png', 0, '2025-04-29 16:19:55'),
(41, 57, 'uploads/1745918395_57_1_Picture37.png', 1, '2025-04-29 16:19:55'),
(42, 57, 'uploads/1745918395_57_2_Picture38.png', 2, '2025-04-29 16:19:55'),
(43, 57, 'uploads/1745918395_57_3_Picture39.png', 3, '2025-04-29 16:19:55'),
(44, 57, 'uploads/1745918395_57_4_Picture40.png', 4, '2025-04-29 16:19:55'),
(45, 58, 'uploads/1745918665_58_0_md2-sp-e1721975867804.webp', 0, '2025-04-29 16:24:25'),
(46, 58, 'uploads/1745918665_58_1_Picture41.png', 1, '2025-04-29 16:24:25'),
(47, 58, 'uploads/1745918665_58_2_Picture42.png', 2, '2025-04-29 16:24:25'),
(48, 58, 'uploads/1745918665_58_3_Picture43.png', 3, '2025-04-29 16:24:25'),
(49, 58, 'uploads/1745918665_58_4_Picture44.png', 4, '2025-04-29 16:24:25'),
(50, 59, 'uploads/1745918812_59_0_Picture46.png', 0, '2025-04-29 16:26:52'),
(51, 59, 'uploads/1745918812_59_1_Picture47.png', 1, '2025-04-29 16:26:52'),
(52, 59, 'uploads/1745918812_59_2_Picture48.png', 2, '2025-04-29 16:26:52'),
(53, 59, 'uploads/1745918812_59_3_Picture49.png', 3, '2025-04-29 16:26:52'),
(54, 59, 'uploads/1745918812_59_4_Picture50.png', 4, '2025-04-29 16:26:52'),
(55, 60, 'uploads/1745919296_60_0_Picture50.png', 0, '2025-04-29 16:34:56'),
(56, 60, 'uploads/1745919296_60_1_Picture51.png', 1, '2025-04-29 16:34:56'),
(57, 60, 'uploads/1745919296_60_2_Picture52.png', 2, '2025-04-29 16:34:56'),
(58, 60, 'uploads/1745919296_60_3_Picture53.png', 3, '2025-04-29 16:34:56'),
(59, 60, 'uploads/1745919296_60_4_Picture54.png', 4, '2025-04-29 16:34:56'),
(60, 61, 'uploads/1745919438_61_0_Picture55.png', 0, '2025-04-29 16:37:18'),
(61, 61, 'uploads/1745919438_61_1_Picture56.png', 1, '2025-04-29 16:37:18'),
(62, 61, 'uploads/1745919438_61_2_Picture57.png', 2, '2025-04-29 16:37:18'),
(63, 61, 'uploads/1745919438_61_3_Picture58.png', 3, '2025-04-29 16:37:18'),
(64, 61, 'uploads/1745919438_61_4_Picture59.png', 4, '2025-04-29 16:37:18'),
(65, 62, 'uploads/1745919515_62_0_Picture60.png', 0, '2025-04-29 16:38:35'),
(66, 62, 'uploads/1745919515_62_1_Picture61.png', 1, '2025-04-29 16:38:35'),
(67, 62, 'uploads/1745919515_62_2_Picture62.png', 2, '2025-04-29 16:38:35'),
(68, 62, 'uploads/1745919515_62_3_Picture63.png', 3, '2025-04-29 16:38:35'),
(69, 62, 'uploads/1745919515_62_4_Picture64.png', 4, '2025-04-29 16:38:35'),
(70, 63, 'uploads/1745919584_63_0_Picture65.png', 0, '2025-04-29 16:39:44'),
(71, 63, 'uploads/1745919584_63_1_Picture66.png', 1, '2025-04-29 16:39:44'),
(72, 63, 'uploads/1745919584_63_2_Picture67.png', 2, '2025-04-29 16:39:44'),
(73, 63, 'uploads/1745919584_63_3_Picture68.png', 3, '2025-04-29 16:39:44'),
(74, 63, 'uploads/1745919584_63_4_Picture69.png', 4, '2025-04-29 16:39:44'),
(76, 29, 'uploads/1745993463_29_1_Picture2.png', 1, '2025-04-30 13:11:03'),
(77, 29, 'uploads/1745993463_29_2_Picture3.png', 2, '2025-04-30 13:11:03'),
(78, 29, 'uploads/1745993463_29_3_Picture4.png', 3, '2025-04-30 13:11:03'),
(79, 29, 'uploads/1745993463_29_4_Picture5.png', 4, '2025-04-30 13:11:03'),
(81, 31, 'uploads/1745993738_31_1_Picture7.png', 1, '2025-04-30 13:15:38'),
(82, 31, 'uploads/1745993738_31_2_Picture8.png', 2, '2025-04-30 13:15:38'),
(83, 31, 'uploads/1745993738_31_3_Picture9.png', 3, '2025-04-30 13:15:38'),
(84, 31, 'uploads/1745993738_31_4_Picture10.png', 4, '2025-04-30 13:15:38'),
(85, 32, 'uploads/1745993852_32_0_Picture12.png', 0, '2025-04-30 13:17:32'),
(86, 32, 'uploads/1745993852_32_1_Picture13.png', 1, '2025-04-30 13:17:32'),
(87, 32, 'uploads/1745993852_32_2_Picture14.png', 2, '2025-04-30 13:17:32'),
(88, 32, 'uploads/1745993852_32_3_Picture15.png', 3, '2025-04-30 13:17:32'),
(89, 33, 'uploads/1745993914_33_0_Picture17.png', 0, '2025-04-30 13:18:34'),
(90, 33, 'uploads/1745993914_33_1_Picture18.png', 1, '2025-04-30 13:18:34'),
(91, 33, 'uploads/1745993914_33_2_Picture19.png', 2, '2025-04-30 13:18:34'),
(92, 33, 'uploads/1745993914_33_3_Picture20.png', 3, '2025-04-30 13:18:34'),
(93, 34, 'uploads/1745994066_34_0_Picture22.png', 0, '2025-04-30 13:21:06'),
(94, 34, 'uploads/1745994066_34_1_Picture23.png', 1, '2025-04-30 13:21:06'),
(95, 34, 'uploads/1745994066_34_2_Picture24.png', 2, '2025-04-30 13:21:06'),
(96, 34, 'uploads/1745994066_34_3_Picture25.png', 3, '2025-04-30 13:21:06'),
(97, 30, 'uploads/1745994128_30_0_Picture27.png', 0, '2025-04-30 13:22:08'),
(98, 30, 'uploads/1745994128_30_1_Picture28.png', 1, '2025-04-30 13:22:08'),
(99, 30, 'uploads/1745994128_30_2_Picture29.png', 2, '2025-04-30 13:22:08'),
(100, 30, 'uploads/1745994128_30_3_Picture30.png', 3, '2025-04-30 13:22:08'),
(101, 35, 'uploads/1745994179_35_0_Picture32.png', 0, '2025-04-30 13:22:59'),
(102, 35, 'uploads/1745994179_35_1_Picture33.png', 1, '2025-04-30 13:22:59'),
(103, 35, 'uploads/1745994179_35_2_Picture34.png', 2, '2025-04-30 13:22:59'),
(104, 35, 'uploads/1745994179_35_3_Picture35.png', 3, '2025-04-30 13:22:59'),
(105, 36, 'uploads/1745994253_36_0_Picture37.png', 0, '2025-04-30 13:24:13'),
(106, 36, 'uploads/1745994253_36_1_Picture38.png', 1, '2025-04-30 13:24:13'),
(107, 36, 'uploads/1745994253_36_2_Picture39.png', 2, '2025-04-30 13:24:13'),
(108, 36, 'uploads/1745994253_36_3_Picture40.png', 3, '2025-04-30 13:24:13'),
(109, 37, 'uploads/1745994295_37_0_Picture42.png', 0, '2025-04-30 13:24:55'),
(110, 37, 'uploads/1745994295_37_1_Picture43.png', 1, '2025-04-30 13:24:55'),
(111, 37, 'uploads/1745994295_37_2_Picture44.png', 2, '2025-04-30 13:24:55'),
(112, 37, 'uploads/1745994295_37_3_Picture45.png', 3, '2025-04-30 13:24:55'),
(113, 38, 'uploads/1745994354_38_0_Picture47.png', 0, '2025-04-30 13:25:54'),
(114, 38, 'uploads/1745994354_38_1_Picture48.png', 1, '2025-04-30 13:25:54'),
(115, 38, 'uploads/1745994354_38_2_Picture49.png', 2, '2025-04-30 13:25:54'),
(116, 38, 'uploads/1745994354_38_3_Picture50.png', 3, '2025-04-30 13:25:54'),
(117, 39, 'uploads/1745995001_39_0_Picture1.png', 0, '2025-04-30 13:36:41'),
(118, 39, 'uploads/1745995001_39_1_Picture2.png', 1, '2025-04-30 13:36:41'),
(119, 39, 'uploads/1745995001_39_2_Picture3.png', 2, '2025-04-30 13:36:41'),
(120, 39, 'uploads/1745995001_39_3_Picture4.png', 3, '2025-04-30 13:36:41'),
(121, 39, 'uploads/1745995001_39_4_Picture5.png', 4, '2025-04-30 13:36:41'),
(122, 40, 'uploads/1745995097_40_0_Picture7.png', 0, '2025-04-30 13:38:17'),
(123, 40, 'uploads/1745995097_40_1_Picture8.png', 1, '2025-04-30 13:38:17'),
(124, 40, 'uploads/1745995097_40_2_Picture9.png', 2, '2025-04-30 13:38:17'),
(125, 40, 'uploads/1745995097_40_3_Picture10.png', 3, '2025-04-30 13:38:17'),
(126, 40, 'uploads/1745995242_40_0_Picture11.png', 0, '2025-04-30 13:40:42'),
(127, 41, 'uploads/1745995315_41_0_Picture12.png', 0, '2025-04-30 13:41:55'),
(128, 41, 'uploads/1745995315_41_1_Picture13.png', 1, '2025-04-30 13:41:55'),
(129, 41, 'uploads/1745995315_41_2_Picture14.png', 2, '2025-04-30 13:41:55'),
(130, 41, 'uploads/1745995315_41_3_Picture15.png', 3, '2025-04-30 13:41:55'),
(131, 42, 'uploads/1745995377_42_0_Picture17.png', 0, '2025-04-30 13:42:57'),
(132, 42, 'uploads/1745995377_42_1_Picture18.png', 1, '2025-04-30 13:42:57'),
(133, 42, 'uploads/1745995377_42_2_Picture19.png', 2, '2025-04-30 13:42:57'),
(134, 42, 'uploads/1745995377_42_3_Picture20.png', 3, '2025-04-30 13:42:57'),
(135, 43, 'uploads/1745995487_43_0_Picture21.png', 0, '2025-04-30 13:44:47'),
(136, 43, 'uploads/1745995487_43_1_Picture22.png', 1, '2025-04-30 13:44:47'),
(137, 43, 'uploads/1745995487_43_2_Picture23.png', 2, '2025-04-30 13:44:47'),
(138, 43, 'uploads/1745995487_43_3_Picture24.png', 3, '2025-04-30 13:44:47'),
(139, 44, 'uploads/1745995523_44_0_Picture25.png', 0, '2025-04-30 13:45:23'),
(140, 44, 'uploads/1745995523_44_1_Picture26.png', 1, '2025-04-30 13:45:23'),
(141, 44, 'uploads/1745995523_44_2_Picture27.png', 2, '2025-04-30 13:45:23'),
(142, 44, 'uploads/1745995523_44_3_Picture28.png', 3, '2025-04-30 13:45:23'),
(143, 45, 'uploads/1745995564_45_0_Picture29.png', 0, '2025-04-30 13:46:04'),
(144, 45, 'uploads/1745995564_45_1_Picture30.png', 1, '2025-04-30 13:46:04'),
(145, 45, 'uploads/1745995564_45_2_Picture31.png', 2, '2025-04-30 13:46:04'),
(146, 45, 'uploads/1745995565_45_3_Picture32.png', 3, '2025-04-30 13:46:05'),
(147, 46, 'uploads/1745995665_46_0_Picture33.png', 0, '2025-04-30 13:47:45'),
(148, 46, 'uploads/1745995665_46_1_Picture34.png', 1, '2025-04-30 13:47:45'),
(149, 46, 'uploads/1745995665_46_2_Picture35.png', 2, '2025-04-30 13:47:45'),
(150, 46, 'uploads/1745995665_46_3_Picture36.png', 3, '2025-04-30 13:47:45'),
(151, 47, 'uploads/1745995745_47_0_Picture37.png', 0, '2025-04-30 13:49:05'),
(152, 47, 'uploads/1745995745_47_1_Picture38.png', 1, '2025-04-30 13:49:05'),
(153, 47, 'uploads/1745995745_47_2_Picture39.png', 2, '2025-04-30 13:49:05'),
(154, 47, 'uploads/1745995745_47_3_Picture40.png', 3, '2025-04-30 13:49:05'),
(155, 48, 'uploads/1745995813_48_0_Picture41.png', 0, '2025-04-30 13:50:13'),
(156, 48, 'uploads/1745995813_48_1_Picture42.png', 1, '2025-04-30 13:50:13'),
(157, 48, 'uploads/1745995813_48_2_Picture43.png', 2, '2025-04-30 13:50:14'),
(158, 48, 'uploads/1745995814_48_3_Picture44.png', 3, '2025-04-30 13:50:14'),
(159, 55, 'uploads/1745996076_55_0_download (1).jpg', 0, '2025-04-30 13:54:36'),
(160, 55, 'uploads/1745996076_55_1_download (3).jpg', 1, '2025-04-30 13:54:36'),
(161, 55, 'uploads/1745996076_55_2_images (1).jpg', 2, '2025-04-30 13:54:36'),
(162, 55, 'uploads/1745996076_55_3_images.jpg', 3, '2025-04-30 13:54:36'),
(163, 55, 'uploads/1745996076_55_4_Mazda32020VnE993047211573621051jpg-1631963909.webp', 4, '2025-04-30 13:54:36');

COMMIT;

/*!40101 SET CHARACTER_SET_CLIENT=@OLD_CHARACTER_SET_CLIENT */;
/*!40101 SET CHARACTER_SET_RESULTS=@OLD_CHARACTER_SET_RESULTS */;
/*!40101 SET COLLATION_CONNECTION=@OLD_COLLATION_CONNECTION */;
