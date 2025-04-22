-- phpMyAdmin SQL Dump
-- version 5.2.1
-- https://www.phpmyadmin.net/
--
-- Máy chủ: 127.0.0.1
-- Thời gian đã tạo: Th4 01, 2025 lúc 03:12 AM
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

-- --------------------------------------------------------

--
-- Cấu trúc bảng cho bảng `cart`
--

CREATE TABLE `cart` (
  `cart_id` int(11) NOT NULL,
  `user_id` int(11) NOT NULL,
  `cart_status` enum('activated','ordered','cancelled') NOT NULL DEFAULT 'activated'
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

--
-- Đang đổ dữ liệu cho bảng `cart`
--

INSERT INTO `cart` (`cart_id`, `user_id`, `cart_status`) VALUES
(1, 1, ''),
(2, 5, ''),
(3, 1, ''),
(4, 1, ''),
(5, 1, ''),
(6, 1, ''),
(7, 1, ''),
(8, 1, ''),
(9, 1, ''),
(10, 1, ''),
(11, 1, ''),
(12, 1, ''),
(13, 1, ''),
(14, 1, ''),
(15, 1, ''),
(16, 1, ''),
(17, 1, ''),
(18, 1, ''),
(19, 1, ''),
(20, 1, ''),
(21, 1, ''),
(22, 1, ''),
(23, 1, ''),
(24, 1, ''),
(25, 1, ''),
(26, 1, ''),
(27, 1, ''),
(28, 5, ''),
(29, 5, ''),
(30, 5, ''),
(31, 5, ''),
(32, 5, ''),
(33, 5, ''),
(34, 5, ''),
(35, 10, ''),
(36, 10, ''),
(37, 10, ''),
(38, 1, 'activated'),
(39, 2, ''),
(40, 2, ''),
(41, 9, ''),
(42, 7, '');

-- --------------------------------------------------------

--
-- Cấu trúc bảng cho bảng `cart_items`
--

CREATE TABLE `cart_items` (
  `cart_item_id` int(11) NOT NULL,
  `cart_id` int(11) NOT NULL,
  `product_id` int(11) NOT NULL,
  `quantity` int(11) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

--
-- Đang đổ dữ liệu cho bảng `cart_items`
--

INSERT INTO `cart_items` (`cart_item_id`, `cart_id`, `product_id`, `quantity`) VALUES
(2, 1, 14, 1),
(3, 1, 19, 1),
(4, 2, 18, 1),
(5, 3, 26, 1),
(6, 4, 19, 1),
(7, 5, 1, 1),
(8, 6, 20, 1),
(9, 7, 22, 1),
(10, 8, 1, 1),
(11, 9, 18, 1),
(12, 10, 16, 1),
(13, 11, 20, 1),
(14, 12, 12, 1),
(15, 13, 11, 10),
(16, 14, 21, 1),
(17, 15, 23, 1),
(18, 15, 7, 2),
(19, 16, 16, 1),
(20, 17, 15, 1),
(21, 18, 28, 1),
(22, 19, 16, 1),
(23, 20, 23, 1),
(24, 21, 15, 1),
(25, 22, 15, 1),
(26, 23, 9, 1),
(27, 24, 27, 1),
(28, 25, 17, 1),
(29, 26, 23, 1),
(30, 27, 26, 1),
(31, 27, 18, 1),
(32, 2, 13, 1),
(33, 28, 9, 1),
(35, 29, 13, 1),
(36, 30, 14, 1),
(37, 31, 10, 1),
(38, 32, 16, 1),
(39, 33, 17, 1),
(40, 34, 21, 1),
(41, 35, 1, 1),
(42, 35, 15, 1),
(43, 36, 25, 30),
(44, 37, 13, 1),
(45, 27, 9, 1),
(46, 39, 1, 1),
(47, 40, 22, 1),
(48, 41, 20, 100),
(49, 42, 21, 3);

-- --------------------------------------------------------

--
-- Cấu trúc bảng cho bảng `car_types`
--

CREATE TABLE `car_types` (
  `type_id` int(11) NOT NULL,
  `type_name` varchar(100) NOT NULL,
  `logo_url` varchar(255) DEFAULT NULL,
  `banner_url` varchar(255) DEFAULT NULL,
  `description` longtext DEFAULT NULL,
  `image_link` int(255) DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

--
-- Đang đổ dữ liệu cho bảng `car_types`
--

INSERT INTO `car_types` (`type_id`, `type_name`, `logo_url`, `banner_url`, `description`, `image_link`) VALUES
(1, 'lamborghini', 'https://img.logo.dev/lamborghini.com', NULL, NULL, NULL),
(2, 'bmw', 'https://img.logo.dev/bmw.com', NULL, NULL, NULL),
(3, 'mazda', 'https://img.logo.dev/mazda.com', NULL, NULL, NULL),
(4, 'tesla', 'https://img.logo.dev/tesla.com', NULL, NULL, NULL),
(5, 'audi', 'https://img.logo.dev/audi.com', NULL, NULL, NULL),
(6, 'ferrari', NULL, NULL, NULL, NULL),
(7, 'bugatti', NULL, NULL, NULL, NULL);

-- --------------------------------------------------------

--
-- Cấu trúc bảng cho bảng `orders`
--

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
  `delivery_duration` int(11) GENERATED ALWAYS AS (timestampdiff(HOUR,`order_date`,`delivered_date`)) STORED
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

--
-- Đang đổ dữ liệu cho bảng `orders`
--

INSERT INTO `orders` (`order_id`, `user_id`, `order_date`, `delivered_date`, `expected_total_amount`, `VAT`, `shipping_address`, `distance`, `shipping_fee`, `total_amount`, `payment_method_id`, `order_status`, `description`, `shipper_info`) VALUES
(1, 1, '2025-03-22 21:38:13', NULL, 9999999999999.99, 99999999.99, '16, thăng long, Quận Tân Bình, Thành phố Hồ Chí Minh', 0, 0.00, NULL, NULL, 'is pending', NULL, NULL),
(2, 1, '2025-03-24 13:08:23', NULL, 7654.00, 0.00, 'Hẻm 37 Đường C1, Quận Tân Bình, Thành phố Hồ Chí Minh', 0, 0.00, NULL, NULL, 'is pending', NULL, NULL),
(3, 1, '2025-03-24 14:18:42', NULL, 8765487.00, 0.00, 'Hẻm 37 Đường C1, Quận Tân Bình, Thành phố Hồ Chí Minh', 0, 0.00, NULL, NULL, 'is pending', NULL, NULL),
(4, 1, '2025-03-24 14:42:17', NULL, 22222.00, 0.00, '52, Phan Đình Giót, Quận Tân Bình, Thành phố Hồ Chí Minh', 0, 0.00, NULL, NULL, 'is confirmed', NULL, NULL),
(5, 1, '2025-03-24 15:39:09', NULL, 7890.00, 0.00, 'Hẻm 37 Đường C1, Quận Tân Bình, Thành phố Hồ Chí Minh', 0, 0.00, NULL, NULL, 'is pending', NULL, NULL),
(12, 1, NULL, NULL, NULL, 0.00, 'Hẻm 37 Đường C1, Quận Tân Bình, Thành phố Hồ Chí Minh', 0, 0.00, NULL, NULL, 'initiated', NULL, NULL),
(16, 1, '2025-03-24 18:22:55', NULL, 6576.00, 0.00, 'Hẻm 37 Đường C1, Quận Tân Bình, Thành phố Hồ Chí Minh', 6.81, 681000.00, NULL, 3, 'is pending', NULL, NULL),
(17, 1, '2025-03-24 18:55:42', NULL, 22222.00, 2222.20, 'Hẻm 37 Đường C1, Quận Tân Bình, Thành phố Hồ Chí Minh', 6.8, 680000.00, 704444.20, 3, 'is pending', NULL, NULL),
(18, 1, '2025-03-24 19:10:43', NULL, 214124.00, 0.00, 'Hẻm 37 Đường C1, Quận Tân Bình, Thành phố Hồ Chí Minh', 0, 0.00, NULL, NULL, 'is pending', NULL, NULL),
(19, 1, '2025-03-24 19:16:58', NULL, 321.00, 0.00, 'Hẻm 37 Đường C1, Quận Tân Bình, Thành phố Hồ Chí Minh', 0, 0.00, NULL, NULL, 'is pending', NULL, NULL),
(20, 1, '2025-03-24 19:17:55', NULL, 7890.00, 789.00, 'Hẻm 37 Đường C1, Quận Tân Bình, Thành phố Hồ Chí Minh', 6.8, 680000.00, 688679.00, 1, 'cancelled', NULL, NULL),
(21, 1, '2025-03-24 19:22:12', NULL, 1323321312.00, 99999999.99, '3, Trà Khúc, Quận Tân Bình, Thành phố Hồ Chí Minh', 4.73, 473001.00, 99999999.99, 1, 'is pending', NULL, NULL),
(22, 1, '2025-03-24 19:40:38', NULL, 1111111110.00, 111111111.00, '52, Phan Đình Giót, Quận Tân Bình, Thành phố Hồ Chí Minh', 4.7, 470000.00, 1222692221.00, 1, 'cancelled', NULL, NULL),
(23, 1, '2025-03-24 19:42:19', NULL, 8765678.00, 876567.80, '52, Phan Đình Giót, Quận Tân Bình, Thành phố Hồ Chí Minh', 4.7, 470000.00, 10112245.80, 1, 'cancelled', NULL, NULL),
(24, 1, '2025-03-24 19:42:56', NULL, 43655555.00, NULL, '52, Phan Đình Giót, Quận Tân Bình, Thành phố Hồ Chí Minh', 0, 0.00, NULL, NULL, 'cancelled', NULL, NULL),
(25, 1, '2025-03-24 20:54:49', NULL, 321.00, 32.10, 'Hẻm 37 Đường C1, Quận Tân Bình, Thành phố Hồ Chí Minh', 6.81, 681000.00, 681353.10, 1, 'cancelled', NULL, NULL),
(26, 1, '2025-03-24 21:08:40', NULL, 876543234567.00, 87654323456.70, 'Hẻm 37 Đường C1, Quận Tân Bình, Thành phố Hồ Chí Minh', 6.81, 681000.00, 964198239023.70, 1, 'is pending', NULL, NULL),
(27, 1, '2025-03-24 21:09:05', NULL, 3213.00, 321.30, 'Hẻm 37 Đường C1, Quận Tân Bình, Thành phố Hồ Chí Minh', 6.81, 681000.00, 684534.30, 1, 'cancelled', NULL, NULL),
(28, 1, '2025-03-24 21:15:47', NULL, 321.00, 32.10, '52, Phan Đình Giót, Quận Tân Bình, Thành phố Hồ Chí Minh', 4.7, 470000.00, 470353.10, 1, 'is pending', NULL, NULL),
(29, 1, '2025-03-24 21:19:29', NULL, 1231313.00, NULL, 'Hẻm 37 Đường C1, Quận Tân Bình, Thành phố Hồ Chí Minh', 0, 0.00, NULL, NULL, 'is pending', NULL, NULL),
(30, 1, '2025-03-24 21:39:49', NULL, 876543234567.00, NULL, 'Hẻm 37 Đường C1, Quận Tân Bình, Thành phố Hồ Chí Minh', 0, 0.00, NULL, NULL, 'is pending', NULL, NULL),
(31, 1, '2025-03-24 21:45:55', NULL, 876543234567.00, NULL, '3, Trà Khúc, Quận Tân Bình, Thành phố Hồ Chí Minh', 0, 0.00, NULL, NULL, 'cancelled', NULL, NULL),
(32, 1, '2025-03-24 21:46:49', NULL, 9999999999999.99, 1000000000000.00, '3, Trà Khúc, Quận Tân Bình, Thành phố Hồ Chí Minh', 4.73, 473001.00, 11000000473000.99, 1, 'cancelled', NULL, NULL),
(33, 1, '2025-03-24 21:47:30', NULL, 21.00, NULL, 'Hẻm 37 Đường C1, Quận Tân Bình, Thành phố Hồ Chí Minh', 0, 0.00, NULL, NULL, 'is pending', NULL, NULL),
(35, 1, '2025-03-25 08:18:33', NULL, 2312331.00, 231233.10, 'Hẻm 37 Đường C1, Quận Tân Bình, Thành phố Hồ Chí Minh', 6.81, 681000.00, 3224564.10, 1, 'is pending', NULL, NULL),
(36, 1, '2025-03-25 08:57:07', NULL, 1231313.00, 123131.30, 'Hẻm 37 Đường C1, Quận Tân Bình, Thành phố Hồ Chí Minh', 6.81, 681000.00, 2035444.30, 1, 'is pending', NULL, NULL),
(37, 5, '2025-03-25 20:53:04', NULL, 10000214123.00, 1000021412.30, 'quảng ngãi', 0, 0.00, 11000235535.30, 1, 'completed', NULL, NULL),
(38, 5, '2025-03-25 21:25:46', NULL, 9999999999999.99, 1000000000000.00, 'quảng ngãi', 0, 0.00, 10999999999999.99, 1, 'is delivering', NULL, NULL),
(39, 5, '2025-03-25 21:34:23', NULL, 9999999999.00, NULL, 'Đường Phạm Văn Đồng, Tỉnh Quảng Ngãi', 0, 0.00, NULL, NULL, 'cancelled', NULL, NULL),
(40, 5, '2025-03-25 21:39:19', NULL, 9999999999999.99, 1000000000000.00, 'Đường Tam Đông 1, Huyện Hóc Môn, Thành phố Hồ Chí Minh', 19.14, 1914000.00, 11000001913999.99, 1, 'is pending', NULL, NULL),
(41, 5, '2025-03-25 21:53:29', NULL, 667898765.00, 66789876.50, '222, Nguyễn Du, Nguyễn Nghiêm, Thành phố Quảng Ngãi, Tỉnh Quảng Ngãi', 0, 0.00, 734688641.50, 1, 'initiated', NULL, NULL),
(42, 5, '2025-03-27 16:07:33', NULL, 321.00, 32.10, 'Đường Trịnh Như Khuê, Xã Bình Chánh, Huyện Bình Chánh, Thành phố Hồ Chí Minh', 20.46, 2046000.00, 2046353.10, 1, 'initiated', NULL, NULL),
(43, 5, '2025-03-28 09:32:01', NULL, 2312331.00, 231233.10, 'tân bình', 5.92, 592000.00, 3135564.10, 1, 'is pending', NULL, NULL),
(44, 5, '2025-03-28 09:32:58', NULL, 8765678.00, 876567.80, 'Quận 1, Thành phố Hồ Chí Minh', 2.26, 226000.00, 9868245.80, 1, 'is pending', NULL, NULL),
(45, 10, '2025-03-28 10:48:06', NULL, 876543256789.00, 87654325678.90, 'Quận 1, Thành phố Hồ Chí Minh', 2.26, 226000.00, 964197808467.90, 1, 'is pending', NULL, NULL),
(46, 10, '2025-03-28 10:49:10', NULL, 2629620.00, 262962.00, 'Quận 1, Thành phố Hồ Chí Minh', 2.26, 226000.00, 3118582.00, 3, 'is pending', NULL, NULL),
(47, 10, '2025-03-28 10:51:33', NULL, 9999999999.00, 999999999.90, 'Quận 1, Thành phố Hồ Chí Minh', 2.26, 226000.00, 11000225998.90, 2, 'is pending', NULL, NULL),
(48, 1, '2025-03-28 10:53:31', NULL, 10000000221777.99, 1000000022177.80, 'Hẻm 37 Đường C1, Quận Tân Bình, Thành phố Hồ Chí Minh', 6.81, 681000.00, 11000000924955.79, 1, 'is pending', NULL, NULL),
(49, 2, '2025-03-29 16:38:53', NULL, 22222.00, NULL, '2132321323', 0, 0.00, NULL, NULL, 'initiated', NULL, NULL),
(50, 2, '2025-03-29 16:39:53', NULL, 6576.00, 657.60, '52, Phan Đình Giót, Quận Tân Bình, Thành phố Hồ Chí Minh', 4.7, 470000.00, 477233.60, 1, 'is pending', NULL, NULL),
(51, 9, '2025-03-29 16:55:22', NULL, 789000.00, 78900.00, 'Hẻm 3 Cao Lỗ, Quận 8, Thành phố Hồ Chí Minh', 5.53, 553000.00, 1420900.00, 1, 'is pending', NULL, NULL),
(52, 7, '2025-03-29 16:59:50', NULL, 26297034.00, 2629703.40, 'Hẻm 3 Cao Lỗ, Quận 8, Thành phố Hồ Chí Minh', 5.53, 553000.00, 29479737.40, 3, 'is pending', NULL, NULL);

-- --------------------------------------------------------

--
-- Cấu trúc bảng cho bảng `order_details`
--

CREATE TABLE `order_details` (
  `detail_id` int(11) NOT NULL,
  `order_id` int(11) NOT NULL,
  `product_id` int(11) NOT NULL,
  `quantity` int(11) NOT NULL,
  `price` decimal(15,2) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

--
-- Đang đổ dữ liệu cho bảng `order_details`
--

INSERT INTO `order_details` (`detail_id`, `order_id`, `product_id`, `quantity`, `price`) VALUES
(1, 1, 14, 1, 9999999999999.99),
(2, 1, 19, 1, 8765487.00),
(3, 2, 26, 1, 7654.00),
(4, 3, 19, 1, 8765487.00),
(5, 4, 1, 1, 22222.00),
(6, 5, 20, 1, 7890.00),
(7, 12, 22, 1, 6576.00),
(8, 16, 22, 1, 6576.00),
(9, 17, 1, 1, 22222.00),
(10, 18, 18, 1, 214124.00),
(11, 19, 16, 1, 321.00),
(12, 20, 20, 1, 7890.00),
(13, 21, 12, 1, 1323321312.00),
(14, 22, 11, 10, 111111111.00),
(15, 23, 21, 1, 8765678.00),
(16, 24, 23, 1, 1231313.00),
(17, 24, 7, 2, 21212121.00),
(18, 25, 16, 1, 321.00),
(19, 26, 15, 1, 876543234567.00),
(20, 27, 28, 1, 3213.00),
(21, 28, 16, 1, 321.00),
(22, 29, 23, 1, 1231313.00),
(23, 30, 15, 1, 876543234567.00),
(24, 31, 15, 1, 876543234567.00),
(25, 32, 9, 1, 9999999999999.99),
(26, 33, 27, 1, 21.00),
(27, 35, 17, 1, 2312331.00),
(28, 36, 23, 1, 1231313.00),
(29, 37, 18, 1, 214124.00),
(30, 37, 13, 1, 9999999999.00),
(31, 38, 9, 1, 9999999999999.99),
(32, 39, 13, 1, 9999999999.00),
(33, 40, 14, 1, 9999999999999.99),
(34, 41, 10, 1, 667898765.00),
(35, 42, 16, 1, 321.00),
(36, 43, 17, 1, 2312331.00),
(37, 44, 21, 1, 8765678.00),
(38, 45, 1, 1, 22222.00),
(39, 45, 15, 1, 876543234567.00),
(40, 46, 25, 30, 87654.00),
(41, 47, 13, 1, 9999999999.00),
(42, 48, 9, 1, 9999999999999.99),
(43, 48, 18, 1, 214124.00),
(44, 48, 26, 1, 7654.00),
(45, 49, 1, 1, 22222.00),
(46, 50, 22, 1, 6576.00),
(47, 51, 20, 100, 7890.00),
(48, 52, 21, 3, 8765678.00);

-- --------------------------------------------------------

--
-- Cấu trúc bảng cho bảng `payment_methods`
--

CREATE TABLE `payment_methods` (
  `payment_method_id` int(11) NOT NULL,
  `method_name` varchar(50) NOT NULL,
  `description` varchar(255) DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

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
  `fuel_capacity` varchar(255) DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

--
-- Đang đổ dữ liệu cho bảng `products`
--

INSERT INTO `products` (`product_id`, `brand_id`, `car_name`, `car_description`, `price`, `image_link`, `status`, `sold_quantity`, `remain_quantity`, `max_speed`, `color`, `engine_name`, `year_manufacture`, `seat_number`, `fuel_name`, `engine_power`, `time_0_100`, `location`, `linkinfor`, `fuel_capacity`) VALUES
(1, 1, 'bnbhgfdzs', 'Công nghệ hiện đại, tích hợp nhiều tính năng an toàn.', 22222.00, 'uploads/1741962426_3-series.jpeg', 'selling', 0, 0, 300.00, 'blue', 'f1', '2009', 2, 'fuel', 999.00, NULL, 'TPHCM', NULL, '91 L'),
(6, 1, 'dwd', 'Xe tiết kiệm nhiên liệu, phù hợp di chuyển trong phố.', 44.00, 'uploads/1742118222_bmw5.jpg', 'soldout', 0, 0, 324.00, 'ewr', 'dfsf', '2003', 2, '324', 999.00, NULL, 'TPHCM', NULL, '50 L'),
(7, 1, 'lllsc', 'Giá cả hợp lý, phù hợp với đa số người dùng.', 21212121.00, 'uploads/1742119139_lambo6.jpg', 'discounting', 0, 0, 211.00, '2121', '2121', '2001', 4, '2', 322.00, NULL, 'TPHCM', NULL, '90 L'),
(8, 1, 'scbabc', 'Công nghệ hiện đại, tích hợp nhiều tính năng an toàn.', 77777777.00, 'uploads/1742119735_lambo3.jpg', 'hidden', 0, 0, 699.00, 'orange', 'hg', '2016', 2, 'diesel', 90.00, NULL, 'TPHCM', NULL, '55 L'),
(9, 2, '7654', 'Công nghệ hiện đại, tích hợp nhiều tính năng an toàn.', 9999999999999.99, 'uploads/1742179586_bmw5.jpg', 'selling', 0, 0, 999.99, 'bac', '99', '2024', 4, 'xang', 999.99, NULL, 'TPHCM', NULL, '46 L'),
(10, 2, 'gggh', 'Giá cả hợp lý, phù hợp với đa số người dùng.', 667898765.00, 'uploads/1742181052_bmw4.png', 'selling', 0, 0, 655.00, 'nd', 'h', '2006', 4, 'xang', 233.00, NULL, 'TPHCM', NULL, '37 L'),
(11, 2, 'lllscw', 'Động cơ mạnh mẽ, tăng tốc nhanh.', 111111111.00, 'uploads/1742181106_imagebwm.png', 'selling', 0, 0, 111.00, 'xasx', '11', '2007', 3, '1', 111.00, NULL, 'TPHCM', NULL, '90 L'),
(12, 2, 'bnbws', 'Xe tiết kiệm nhiên liệu, phù hợp di chuyển trong phố.', 1323321312.00, 'uploads/1742181176_BMW 520I LUXURY 2021.webp', 'discounting', 0, 0, 12.00, '31', '31', '2013', 4, '31', 312.00, NULL, 'TPHCM', NULL, '95 L'),
(13, 2, 'scbabcas', 'Xe tiết kiệm nhiên liệu, phù hợp di chuyển trong phố.', 9999999999.00, 'uploads/1742181257_BMW 320I SPORT LINE 2023.webp', 'discounting', 0, 0, 999.99, '3124', '321', '2022', 4, '31', 236.00, NULL, 'TPHCM', NULL, '35 L'),
(14, 2, 'scsac', 'Thiết kế sang trọng, nội thất cao cấp.', 9999999999999.99, 'uploads/1742181838_3-series.jpeg', 'discounting', 0, 0, 213.00, '3123', '31', '2023', 4, '312', 311.00, NULL, 'TPHCM', NULL, '73 L'),
(15, 1, 'sdadas', 'Xe tiết kiệm nhiên liệu, phù hợp di chuyển trong phố.', 876543234567.00, 'uploads/1742182232_lambo6.jpg', 'selling', 0, 0, 878.00, 'black', '213', '2000', 4, '312', 132.00, NULL, 'TPHCM', NULL, '87 L'),
(16, 1, 'sahdh', 'Động cơ mạnh mẽ, tăng tốc nhanh.', 321.00, 'uploads/1742184440_lambo5.jpg', 'selling', 0, 0, 31.00, '3', '312', '2024', 3, '312', 3.00, NULL, 'TPHCM', NULL, '45 L'),
(17, 1, 'gggjhg', 'Xe tiết kiệm nhiên liệu, phù hợp di chuyển trong phố.', 2312331.00, 'uploads/1742184775_lambo3.jpg', 'selling', 0, 0, 999.99, '32', '321', '2004', 4, '321', 231.00, NULL, 'TPHCM', NULL, '76 L'),
(18, 3, 'hjj', 'Giá cả hợp lý, phù hợp với đa số người dùng.', 214124.00, 'uploads/1742192323_mazda4.png', 'selling', 0, 0, 321.00, '321', '321', '2014', 3, '321', 77.00, NULL, 'TPHCM', NULL, '75 L'),
(19, 3, 'hgfds', 'Giá cả hợp lý, phù hợp với đa số người dùng.', 8765487.00, 'uploads/1742192380_mazda1.png', 'selling', 0, 0, 765.00, '6', '7df', '2015', 4, '76', 32.00, NULL, 'TPHCM', NULL, '46 L'),
(20, 3, 'hsgd', 'Công nghệ hiện đại, tích hợp nhiều tính năng an toàn.', 7890.00, 'uploads/1742192424_mazda2.jpg', 'selling', 0, 0, 999.99, 'u765', '65', '2022', 5, '65', 778.00, NULL, 'TPHCM', NULL, '44 L'),
(21, 3, 'ehgg', 'Giá cả hợp lý, phù hợp với đa số người dùng.', 8765678.00, 'uploads/1742192467_mazda3.png', 'discounting', 0, 0, 77.00, 'ewq', '767', '2022', 4, '7y', 232.00, NULL, 'TPHCM', NULL, '55 L'),
(22, 3, 'czhc', 'Xe tiết kiệm nhiên liệu, phù hợp di chuyển trong phố.', 6576.00, 'uploads/1742192508_mazda5.webp', 'selling', 0, 0, 999.99, '7', '68', '2023', 7, '87', 8.00, NULL, 'TPHCM', NULL, '43 L'),
(23, 1, 'hgfd', 'shiba\r\n', 1231313.00, 'uploads/1742201747_trang-alpine-3.webp', 'selling', 0, 0, 313.00, '312', '31', '2015', 4, '23', 32.00, NULL, 'TPHCM', NULL, '32'),
(24, 5, 'thoántreem', 'ggvvh\r\n', 8765432.00, 'uploads/audi1.webp', 'selling', 0, 0, 766.00, 'red', '87', '2022', 4, '87', 788.00, NULL, 'TPHCM', NULL, '78'),
(25, 5, 'thosantreem', 'jjhjhjj\r\n\r\n\r\n\r\n\r\n\r\n\r\n', 87654.00, 'uploads/audi2.webp', 'discounting', 0, 0, 654.00, '65', '5', '2005', 6, '87', 768.00, NULL, 'TPHCM', NULL, '8765'),
(26, 5, 'cachabac', 'fg\r\n', 7654.00, 'uploads/audi3.webp', 'selling', 0, 0, 999.99, '76', '765', '2000', 4, '876', 55.00, NULL, 'TPHCM', NULL, '45'),
(27, 5, 'conchemchep', '4234\r\n', 21.00, 'uploads/audi4.webp', 'selling', 0, 0, 321.00, '453', '32', '2024', 5, '2313', 999.99, NULL, 'TPHCM', NULL, '234'),
(28, 5, 'tinhyeulagi', '8', 3213.00, 'uploads/audi5.webp', 'selling', 0, 0, 543.00, '657', '54', '2020', 8, '43', 453.00, NULL, 'TPHCM', NULL, '53');

-- --------------------------------------------------------

--
-- Cấu trúc bảng cho bảng `users_acc`
--

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
  `full_name` varchar(255) DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

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
(10, 'ng', 'ng', 'activated', '2025-03-28 09:33:55', '0834234242', 'nguyensihuynsh711@gmail.com', 'user', 'Quận 1, Thành phố Hồ Chí Minh', 'sadads');

--
-- Chỉ mục cho các bảng đã đổ
--

--
-- Chỉ mục cho bảng `cart`
--
ALTER TABLE `cart`
  ADD PRIMARY KEY (`cart_id`),
  ADD KEY `user_id` (`user_id`);

--
-- Chỉ mục cho bảng `cart_items`
--
ALTER TABLE `cart_items`
  ADD PRIMARY KEY (`cart_item_id`),
  ADD KEY `cart_id` (`cart_id`),
  ADD KEY `product_id` (`product_id`);

--
-- Chỉ mục cho bảng `car_types`
--
ALTER TABLE `car_types`
  ADD PRIMARY KEY (`type_id`);

--
-- Chỉ mục cho bảng `orders`
--
ALTER TABLE `orders`
  ADD PRIMARY KEY (`order_id`),
  ADD KEY `fk_payment_method` (`payment_method_id`),
  ADD KEY `fk_orders_users` (`user_id`);

--
-- Chỉ mục cho bảng `order_details`
--
ALTER TABLE `order_details`
  ADD PRIMARY KEY (`detail_id`),
  ADD KEY `order_id` (`order_id`),
  ADD KEY `product_id` (`product_id`);

--
-- Chỉ mục cho bảng `payment_methods`
--
ALTER TABLE `payment_methods`
  ADD PRIMARY KEY (`payment_method_id`);

--
-- Chỉ mục cho bảng `products`
--
ALTER TABLE `products`
  ADD PRIMARY KEY (`product_id`),
  ADD UNIQUE KEY `car_name` (`car_name`),
  ADD KEY `fk_brand` (`brand_id`);

--
-- Chỉ mục cho bảng `users_acc`
--
ALTER TABLE `users_acc`
  ADD PRIMARY KEY (`id`),
  ADD UNIQUE KEY `username` (`username`),
  ADD UNIQUE KEY `uq_username` (`username`);

--
-- AUTO_INCREMENT cho các bảng đã đổ
--

--
-- AUTO_INCREMENT cho bảng `cart`
--
ALTER TABLE `cart`
  MODIFY `cart_id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=43;

--
-- AUTO_INCREMENT cho bảng `cart_items`
--
ALTER TABLE `cart_items`
  MODIFY `cart_item_id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=50;

--
-- AUTO_INCREMENT cho bảng `car_types`
--
ALTER TABLE `car_types`
  MODIFY `type_id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=8;

--
-- AUTO_INCREMENT cho bảng `orders`
--
ALTER TABLE `orders`
  MODIFY `order_id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=53;

--
-- AUTO_INCREMENT cho bảng `order_details`
--
ALTER TABLE `order_details`
  MODIFY `detail_id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=49;

--
-- AUTO_INCREMENT cho bảng `payment_methods`
--
ALTER TABLE `payment_methods`
  MODIFY `payment_method_id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=4;

--
-- AUTO_INCREMENT cho bảng `products`
--
ALTER TABLE `products`
  MODIFY `product_id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=29;

--
-- AUTO_INCREMENT cho bảng `users_acc`
--
ALTER TABLE `users_acc`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=11;

--
-- Các ràng buộc cho các bảng đã đổ
--

--
-- Các ràng buộc cho bảng `cart`
--
ALTER TABLE `cart`
  ADD CONSTRAINT `cart_ibfk_1` FOREIGN KEY (`user_id`) REFERENCES `users_acc` (`id`);

--
-- Các ràng buộc cho bảng `cart_items`
--
ALTER TABLE `cart_items`
  ADD CONSTRAINT `cart_items_ibfk_1` FOREIGN KEY (`cart_id`) REFERENCES `cart` (`cart_id`),
  ADD CONSTRAINT `cart_items_ibfk_2` FOREIGN KEY (`product_id`) REFERENCES `products` (`product_id`);

--
-- Các ràng buộc cho bảng `orders`
--
ALTER TABLE `orders`
  ADD CONSTRAINT `fk_orders_users` FOREIGN KEY (`user_id`) REFERENCES `users_acc` (`id`) ON DELETE CASCADE ON UPDATE CASCADE,
  ADD CONSTRAINT `fk_payment_method` FOREIGN KEY (`payment_method_id`) REFERENCES `payment_methods` (`payment_method_id`),
  ADD CONSTRAINT `orders_ibfk_1` FOREIGN KEY (`payment_method_id`) REFERENCES `payment_methods` (`payment_method_id`);

--
-- Các ràng buộc cho bảng `order_details`
--
ALTER TABLE `order_details`
  ADD CONSTRAINT `order_details_ibfk_1` FOREIGN KEY (`order_id`) REFERENCES `orders` (`order_id`),
  ADD CONSTRAINT `order_details_ibfk_2` FOREIGN KEY (`product_id`) REFERENCES `products` (`product_id`);

-- 1. Sản phẩm (products) tham chiếu đến loại xe (car_types)
ALTER TABLE products
  ADD CONSTRAINT fk_products_brand
  FOREIGN KEY (brand_id)
  REFERENCES car_types(type_id)
  ON DELETE CASCADE
  ON UPDATE CASCADE;

-- 2. Giỏ hàng (cart) tham chiếu đến người dùng (users_acc)
ALTER TABLE cart
  ADD CONSTRAINT fk_cart_user
  FOREIGN KEY (user_id)
  REFERENCES users_acc(id)
  ON DELETE CASCADE
  ON UPDATE CASCADE;

-- 3. Mục giỏ hàng (cart_items) tham chiếu đến giỏ hàng (cart)
ALTER TABLE cart_items
  ADD CONSTRAINT fk_cartitems_cart
  FOREIGN KEY (cart_id)
  REFERENCES cart(cart_id)
  ON DELETE CASCADE
  ON UPDATE CASCADE;

-- 4. Mục giỏ hàng (cart_items) tham chiếu đến sản phẩm (products)
ALTER TABLE cart_items
  ADD CONSTRAINT fk_cartitems_product
  FOREIGN KEY (product_id)
  REFERENCES products(product_id)
  ON DELETE CASCADE
  ON UPDATE CASCADE;

-- 5. Đơn hàng (orders) tham chiếu đến người dùng (users_acc)
ALTER TABLE orders
  ADD CONSTRAINT fk_orders_user
  FOREIGN KEY (user_id)
  REFERENCES users_acc(id)
  ON DELETE CASCADE
  ON UPDATE CASCADE;

-- 6. Đơn hàng (orders) tham chiếu đến phương thức thanh toán (payment_methods)
ALTER TABLE orders
  ADD CONSTRAINT fk_orders_payment
  FOREIGN KEY (payment_method_id)
  REFERENCES payment_methods(payment_method_id)
  ON DELETE RESTRICT
  ON UPDATE CASCADE;

-- 7. Chi tiết đơn hàng (order_details) tham chiếu đến đơn hàng (orders)
ALTER TABLE order_details
  ADD CONSTRAINT fk_orderdetails_order
  FOREIGN KEY (order_id)
  REFERENCES orders(order_id)
  ON DELETE CASCADE
  ON UPDATE CASCADE;

-- 8. Chi tiết đơn hàng (order_details) tham chiếu đến sản phẩm (products)
ALTER TABLE order_details
  ADD CONSTRAINT fk_orderdetails_product
  FOREIGN KEY (product_id)
  REFERENCES products(product_id)
  ON DELETE RESTRICT
  ON UPDATE CASCADE;

-- 9. Hình phụ sản phẩm (product_images) tham chiếu đến sản phẩm (products)
ALTER TABLE product_images
  ADD CONSTRAINT fk_prodimg_product
  FOREIGN KEY (product_id)
  REFERENCES products(product_id)
  ON DELETE CASCADE
  ON UPDATE CASCADE;

--
-- Các ràng buộc cho bảng `products`
--
ALTER TABLE `products`
  ADD CONSTRAINT `fk_brand` FOREIGN KEY (`brand_id`) REFERENCES `car_types` (`type_id`);
CREATE TABLE product_images (
    image_id INT AUTO_INCREMENT PRIMARY KEY,
    product_id INT NOT NULL,
    image_url VARCHAR(255) NOT NULL,   -- Đường dẫn hoặc tên file hình ảnh phụ
    sort_order INT DEFAULT 0,            -- Sắp xếp thứ tự hiển thị (tuỳ chọn)
    created_at DATETIME DEFAULT CURRENT_TIMESTAMP,
    FOREIGN KEY (product_id) REFERENCES products(product_id) ON DELETE CASCADE
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4;
COMMIT;

/*!40101 SET CHARACTER_SET_CLIENT=@OLD_CHARACTER_SET_CLIENT */;
/*!40101 SET CHARACTER_SET_RESULTS=@OLD_CHARACTER_SET_RESULTS */;
/*!40101 SET COLLATION_CONNECTION=@OLD_COLLATION_CONNECTION */;
