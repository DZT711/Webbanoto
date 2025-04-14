-- phpMyAdmin SQL Dump
-- version 5.2.1
-- https://www.phpmyadmin.net/
--
-- Máy chủ: 127.0.0.1
-- Thời gian đã tạo: Th4 12, 2025 lúc 06:42 AM
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
(43, 11, '');

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
(50, 43, 47, 1);

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
(53, 11, '2025-04-12 11:34:54', NULL, 7452000000.00, NULL, 'Kiệt 580 Hoàng Diệu, Quận Hải Châu, Thành phố Đà Nẵng', 0, 0.00, NULL, NULL, 'initiated', NULL, NULL);

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
(49, 53, 47, 1, 7452000000.00);

-- --------------------------------------------------------

--
-- Cấu trúc bảng cho bảng `payment_methods`
--

CREATE TABLE `payment_methods` (
  `payment_method_id` int(11) NOT NULL,
  `method_name` varchar(50) NOT NULL,
  `description` varchar(255) DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

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
(29, 5, 'e-tron GT', 'The e-tron GT has a typical Audi design but with a futuristic feel, similar in style to its sibling, the A7 Sportback. The 20-inch wheels have aerodynamic spokes. The car is developed based on the Volkswagen Group\'s high-performance J1 Performance platform designed by Porsche, shared from its sibling, the Taycan. Right at the first world introduction, Audi emphasized the two elements of the e-tron GT: luxury and sporty driving experience.', 3950000000.00, 'uploads/1743663490_Audi1.PNG', 'selling', 0, 0, 245.00, 'Kemora Gray, Tactical Green, Mythos Black, Ibis Wh', 'Electric Engines', '2021', 4, 'Electric', 476.00, NULL, 'TPHCM', NULL, '93,4 kWh'),
(30, 2, 'BMW i4', 'i4 is one of two new electric car models besides iX3, distributed by BMW Truong Hai (Thaco) in Vietnam since August. BMW i4 is imported from Germany with a single version eDrive40 priced at 3.759 billion VND. In international markets, i4 also has options such as eDrive35 (rear-wheel drive like eDrive40), and xDrive40, M50 (4-wheel drive).\r\n\r\ni4 is developed based on the current generation Series 4 Gran Coupe or Series 3 platform. The company uses even numbers to name coupe lines, the symbol i to refer to electrified car models.', 3799000000.00, 'uploads/1743664146_BMW i4.jpg', 'selling', 0, 0, 190.00, 'Alpine White, Black Sapphire, Mineral White, Brook', 'Electric Engines', '2021', 5, 'Electric', 340.00, NULL, 'TPHCM', NULL, '83,9 kWh'),
(31, 5, 'Q6 e-tron', 'Audi Q6 e-tron là một trong những chiếc xe có thiết kế tương lai, điểm nhấn đặc biệt từ khoang nội thất mang đến ấn tượng khó phai cho người dùng.\r\n\r\nĐối với những gia đình cần một chiếc xe rộng rãi, di chuyển êm ái, nhẹ nhàng và theo xu hướng tương lai thì xe điện Audi Q6 e-tron 2025 là lựa chọn tuyệt vời thời điểm này. Không chỉ đáp ứng những nhu cầu trên, Audi Q6 e-tron còn sở hữu thiết kế khiến nhiều người “mê mẩn”.\r\n', 2300000000.00, 'uploads/1743825024_Q6.PNG', 'hidden', 0, 0, 210.00, 'Glacier White, Magnetic Grey, Solid Red, Mythos Bl', 'Electric Engines', '2024', 5, 'Electric', 382.00, NULL, 'TPHCM', NULL, '100 kWh'),
(32, 5, 'A4 Sedan', 'Mẫu sedan nhỏ nhất nhà Audi ra mắt lần đầu hồi 1994, cạnh tranh với các đối thủ như Mercedes C-class, BMW Series 3.', 1650000000.00, 'uploads/1743825523_Sedan.PNG', 'discounting', 0, 0, 250.00, 'Arkona White​, Brilliant Black​, Navarra Blue Meta', '2.0L Turbocharged Petrol', '2025', 5, 'Petrol', 245.00, NULL, 'TPHCM', NULL, '58L'),
(33, 5, 'Q3 Sportback', 'ự xuất hiện của Audi Q3 Sportback 2024 như một luồng gió mới giữa phân khúc SUV Coupe hạng sang vốn kén khách tại Việt Nam, được kì vọng sẽ cạnh tranh tốt hơn với các đối thủ sừng sỏ như Mercedes-Benz GLC Coupe, BMW X2, Lexus NX hay Jaguar E-Pace. Hiện nay, Audi Q3 Sportback 2024 mang đến cho người dùng 11 màu sắc ngoại thất, 4 kiểu ốp nội thất cùng gói tùy chọn S-line thể thao.', 2000000000.00, 'uploads/1743825895_Q3.PNG', 'soldout', 0, 0, 222.00, 'Turbo Blue, Glacier White Metallic, Chronos Grey M', '2.0L Turbocharged Petrol', '2023', 5, 'Petrol', 188.00, NULL, 'TPHCM', NULL, '50L'),
(34, 5, 'Q8 SUV', 'Audi Q8 là một mẫu xe SUV hạng sang cỡ lớn của thương hiệu Audi, thuộc tập đoàn Volkswagen. Nó được giới thiệu lần đầu tiên vào năm 2017, đánh dấu sự gia nhập của Audi vào phân khúc SUV coupe cao cấp, đối đầu trực tiếp với các mẫu xe như BMW X6 và Mercedes-Benz GLE Coupe. Mẫu xe này được thiết kế để kết hợp sự sang trọng và thể thao của một chiếc sedan với sự tiện nghi và khả năng vận hành của một chiếc SUV.\r\n\r\nAudi Q8 được xây dựng trên nền tảng MLB Evo, nền tảng chung mà các mẫu xe hạng sang của Volkswagen Group sử dụng, bao gồm Audi Q7, Porsche Cayenne, và Volkswagen Touareg. Nền tảng này giúp Audi Q8 có thể cung cấp không gian nội thất rộng rãi và khả năng vận hành linh hoạt.', 4200000000.00, 'uploads/1743826578_Q8.PNG', 'selling', 0, 0, 245.00, 'Chili Red Metallic​, Orca Black Metallic​, Carrara', '3.0L V6 TFSI', '2024', 5, 'Petrol', 340.00, NULL, 'TPHCM', NULL, '85L'),
(35, 2, 'BMW XM', 'BMW XM mới kết hợp vẻ ngoài ấn tượng với hiệu suất cao của BMW M và công nghệ plug-in hybrid mạnh mẽ của thế hệ mới nhất.', 11000000000.00, 'uploads/1743826913_XM.PNG', 'discounting', 0, 0, 250.00, 'Urban Green​, Anglesey Green Metallic​, Petrol Mic', 'Hybrid V8 4.4L​', '2024', 5, 'Petrol', 644.00, NULL, 'TPHCM', NULL, '80L'),
(36, 2, 'Z4 Roadster', 'Đắm mình trong sức hút khó cưỡng từ mẫu xe mui trần đến từ thương hiệu BMW. Ngôi sao đường phố BMW Z4 sở hữu vẻ đẹp nội - ngoại thất nổi bật và đầy lôi cuốn. BMW Z4 - giúp bạn tận hưởng cảm giác lái ở một đẳng cấp hoàn toàn khác biệt.\r\n\r\nBMW Z4 mang đến sự cuốn hút khó cưỡng từ sự kết hợp của một chiếc xe thể thao năng động cùng một mẫu mui trần tự do, phóng khoáng. Thiết kế lưới tản nhiệt hình quả thận đặc trưng của BMW Z4 kết hợp đèn sương mù và hốc gió táo bạo; mui mềm thời thượng; mâm xe hợp kim kết hợp cùng phanh thể thao M Sport, cụm đèn hậu thanh mảnh và ống xả mạ chrome... từng chi tiết kết hợp để tạo nên một tổng thể lôi cuốn, sẵn sàng trở thành người đồng hành cùng bạn tỏa sáng trên mọi hành trình.​\r\n', 3139000000.00, 'uploads/1743827265_Z4.PNG', 'soldout', 0, 0, 250.00, 'San Francisco Red​, Misano Blue​, Black Sapphire​,', 'Hybrid V8 4.4L', '2024', 5, 'Petrol', 644.00, NULL, 'TPHCM', NULL, '80L'),
(37, 2, 'BMW 740i Pure Excellence', 'BMW 740i Pure Excellence là phiên bản cao cấp trong dòng sedan hạng sang BMW 7 Series, kết hợp giữa thiết kế sang trọng và công nghệ tiên tiến.', 5849000000.00, 'uploads/1743827779_740i.PNG', 'selling', 0, 0, 250.00, 'Alpine White​, Black Sapphire, Mineral Grey​, Crim', 'I6 3.0L TwinPower Turbo & Mild Hybrid​', '2024', 5, 'Petrol', 286.00, NULL, 'TPHCM', NULL, '70L'),
(38, 2, 'BMW iX3', 'Vượt xa định nghĩa đơn thuần của một chiếc xe thân thiện môi trường, BMW iX3 mới không chỉ là mẫu xe SAV thuần điện đầu tiên sở hữu những đột phá công nghệ tiên tiến hàng đầu, mà còn có khả năng vận hành đa địa hình, thể thao, khoẻ khoắn, nhưng vẫn giữ được “thần thái” của sự sang trọng, đây cũng là sự đánh dấu bước chuyển mình mạnh mẽ cho giai đoạn phát triển mới của BMW', 3539000000.00, 'uploads/1743828220_i3.PNG', 'selling', 0, 0, 180.00, 'Alpine White, Oxide Grey, Mineral White, Sophisto ', 'Electric Engines', '2024', 5, 'Electric', 286.00, NULL, 'TPHCM', NULL, '80 kWh'),
(39, 7, 'Bugatti Veyron', 'Siêu xe Bugatti Veyron là mẫu xe tiêu biểu của hãng, mẫu xe được yêu thích nhờ vào thiết kế đẹp mắt, công suất hoạt động trên cả tuyệt vời, nếu là một người yêu thích tốc độ thì Bugatti Veyron là một trong những cái tên đáng cân nhắc nhất trong phân khúc siêu xe. \r\nMẫu xe này được đặt theo tên của tay đua người Pháp Pierre Veyron, người đã giành chiến thắng tại cuộc đua 24 Hours of Le Mans năm 1939.​', 32200000000.00, 'uploads/1743834172_veron.PNG', 'soldout', 0, 0, 407.00, 'Beige and Brown, White and Black, Silver and Blue,', '8.0L W16 with 4 turbochargers', '2005', 2, 'Petrol', 999.99, NULL, 'TPHCM', NULL, '100L'),
(40, 7, 'Bugatti Chiron', 'Bugatti Chiron là một siêu xe huyền thoại được sản xuất bởi hãng xe Pháp Bugatti từ năm 2016 đến 2023. Mẫu xe này được đặt theo tên của tay đua người Pháp Louis Chiron, người đã thi đấu cho Bugatti từ năm 1928 đến 1958.​', 68954000000.00, 'uploads/1743834394_Chiron.PNG', 'soldout', 0, 0, 420.00, 'While, Blue, Gray, Black,', '8.0L W16 with four turbochargers', '2016', 2, 'Premium gasoline', 999.99, NULL, 'TPHCM', NULL, '100L'),
(41, 7, 'Bugatti Chiron Divo', 'Bugatti Chiron Divo là mẫu xe được nâng cấp từ đàn anh Bugatti Chiron. Theo hãng xe, Chiron Divo được phát triển dựa trên Chiron và nâng cao hiệu năng làm việc của xe. Đồng thời xây dựng thiết kế dựa trên ngôn ngữ mới của hãng đánh dấu sự trở lại của hãng xe siêu sang. ', 133400000000.00, 'uploads/1743834603_Divo.PNG', 'soldout', 0, 0, 380.00, 'While, Blue, Gray, Black,', '8.0L quad-turbocharged W16', '2018', 2, 'Premium gasoline', 999.99, NULL, 'TPHCM', NULL, '100L'),
(42, 7, 'Bugatti La Voiture Noire', 'Bugatti Chiron Divo là mẫu xe được nâng cấp từ đàn anh Bugatti Chiron. Theo hãng xe, Chiron Divo được phát triển dựa trên Chiron và nâng cao hiệu năng làm việc của xe. Đồng thời xây dựng thiết kế dựa trên ngôn ngữ mới của hãng đánh dấu sự trở lại của hãng xe siêu sang. ', 429640000000.00, 'uploads/1743834845_1.PNG', 'selling', 0, 0, 418.00, 'Black Carbon Glossy', '8.0L W16 quad-turbocharged', '2021', 2, 'Premium gasoline', 999.99, NULL, 'TPHCM', NULL, '100L'),
(43, 7, 'Bugatti Cento Dieci', 'Bugatti Centodieci là một siêu xe phiên bản giới hạn, được sản xuất để kỷ niệm 110 năm thành lập thương hiệu Bugatti và tri ân mẫu xe EB110 huyền thoại. Chỉ có 10 chiếc được chế tạo, mỗi chiếc có giá khoảng 9 triệu USD.', 207000000000.00, 'uploads/1743835075_2.PNG', 'hidden', 0, 0, 380.00, 'Blue, While', '8.0L W16 with twin-turbochargers', '2021', 2, 'Premium gasoline', 999.99, NULL, 'TPHCM', NULL, '100L'),
(44, 6, 'Ferrari LaFerrari', 'Ferrari LaFerrari thuộc nhóm những mẫu siêu xe “không phải có tiền là có thể sở hữu”. Bởi chỉ có khoảng 500 chiếc trên thế giới và LaFerrari chỉ dành riêng cho giới siêu giàu.\r\nFerrari LaFerrari là siêu xe hybrid sản xuất giới hạn, đánh dấu bước đầu tiên của Ferrari trong công nghệ hybrid. Ra mắt tại Triển lãm ô tô Geneva 2013, chỉ có 499 chiếc được sản xuất từ ​​năm 2013 đến năm 2016.', 32660000000.00, 'uploads/1743953428_ferarii.PNG', 'soldout', 0, 0, 350.00, 'Rosso Corsa, Giallo Modena, Bianco Avus', '6.3L V12 paired with a 120 kW electric motor', '2013', 2, 'Petrol', 963.00, NULL, 'TPHCM', NULL, '85L'),
(45, 6, 'Ferrari Roma', 'Ferrari Roma là một mẫu GT (Grand Touring) coupe 2 + 2 động cơ đặt giữa ra mắt vào năm 2019. Tên gọi của mẫu xe thể thao này được đặt nhằm tôn vinh thủ đô Rome của Ý.\r\n\r\nFerrari Roma sở hữu diện mạo dễ làm người ta liên tưởng với “huyền thoại” Ferrari Maranello thu hút với form dáng thon dài uyển chuyển của những năm 1990.', 5175000000.00, 'uploads/1743954158_ferarii1.PNG', 'discounting', 0, 0, 320.00, 'While, Blue, Gray, Black', '3.9L V8 twin-turbocharged', '2019', 2, 'Petrol', 620.00, NULL, 'TPHCM', NULL, '80L'),
(46, 6, 'Ferrari Portofino', 'Ferrari Portofino là một mẫu GT (Grand Touring) mui trần 2 + 2, kế thừa Ferrari T California, ra mắt vào năm 2017.\r\n\r\nSo với “người tiền nhiệm”, Ferrari Portofino sở hữu diện mạo hoàn toàn mới, sắc sảo và góc cạnh hơn. Từ lưới tản nhiệt đến cụm đèn pha LED đều phảng phất bóng dáng GTC4Lusso. Cũng như các mẫu xe mui trần khác của Ferrari, Portofino sử dụng mui cứng có thể đóng/mở chỉ trong 14 giây ở dải vận tốc dưới 45 km/h.', 4922000000.00, 'uploads/1743954372_ferarii3.PNG', 'selling', 0, 0, 320.00, 'While, Blue, Gray, Black,', '3.9L twin-turbocharged V8', '2017', 2, 'Petrol', 592.00, NULL, 'TPHCM', NULL, '80L'),
(47, 6, 'Ferrari F12 Berlinetta', 'Ferrari F12 Berlinetta tạo ấn tượng với giới đam mê siêu xe bởi lần bỏ xa Lamborghini Aventador trong một cuộc thử nghiệm. Siêu xe F12 Berlinetta sử dụng động cơ V12, 6.3L cho công suất tối đa 730 mã lực tại 8.250 vòng/phút, mô men xoắn tối đa 690 Nm tại 6.000 vòng/phút. Hộp số sử dụng loại hộp số 7 cấp ly hợp kép DCT.\r\n\r\nXe cho khả năng tăng tốc từ 0 đến 100 Km/h trong 3,1 giây. Vận tốc tối đa Ferrari F12 Berlinetta đạt được là 340 Km/h. F12 Berlinetta bám đường cực tốt khi di chuyển vào cua.', 7452000000.00, 'uploads/1743954824_ferarii4.PNG', 'selling', 0, 0, 340.00, 'Beige and Brown, White and Black, Silver and Blue,', '6.3L V12 naturally aspirated', '2012', 2, 'Petrol', 740.00, NULL, 'TPHCM', NULL, '92L'),
(48, 6, 'Ferrari 812 Superfast', 'Ferrari 812 Superfast chính thức ra mắt vào năm 2017, đây là một mẫu siêu xe được xem là sự kế thừa của F12 Berlinetta. Thiết kế của 812 Superfast lấy nhiều cảm hứng từ F12 Berlinetta. Đèn pha LED dấu mốc đẹp mắt, bên cạnh còn có thêm hốc hút gió nhỏ. Lưới tản nhiệt dạng lưới 1 khoan mở rộng. Hông xe sử dụng đường dập gân kiểu mới.\r\n\r\nĐuôi xe Ferrari 812 Superfast cũng có nhiều chi tiết mới mẻ. Cụm đèn hậu kiểu đôi tối màu thay cho đèn tròn đơn. Phần viền cùng cánh gió trên nhô cao hơn. Bộ cản sau và cụm ống xả đôi thiết kế hầm hố hơn.', 7245000000.00, 'uploads/1743955088_ferarii5.PNG', 'selling', 0, 0, 340.00, 'While, Blue, Gray, Black', '6.5L V12 naturally aspirated', '2017', 2, 'Petrol', 800.00, NULL, 'TPHCM', NULL, '92L'),
(49, 1, 'Lamborghini Huracan Tecnica', 'Trong tiếng Tây Ban Nha, Huracan còn mang ý nghĩa là “cơn bão”. Mẫu siêu xe này không làm thất vọng nhà sản xuất khi đạt doanh số 14.022 chiếc chỉ trong 5 năm đầu tiên sau khi ra mắt. \r\nĐược sản xuất dựa trên chiếc Evo RWD, nhưng bổ sung loạt trang bị thường thấy trên những chiếc Huracan cao cấp', 19000000000.00, 'uploads/1744095049_Lambor.PNG', 'hidden', 0, 0, 325.00, 'While, Blue, Gray, Black', '5.2L naturally aspirated V10', '2022', 2, 'Petrol', 631.00, NULL, 'TPHCM', NULL, '80L'),
(50, 1, 'Lamborghini Urus', 'Lamborghini Urus 2025 có đầy đủ những phẩm chất ưu việt của một chiếc siêu xe hàng đầu. Nhưng nhiều người vẫn cho rằng các mẫu siêu SUV không phải là thế mạnh của Lamborghini và Urus 2025 sẽ bị lép vế trước những mẫu xe gầm thấp đã làm nên tên tuổi của thương hiệu. Câu trả lời cho điều này có lẽ phụ thuộc vào mỗi người. Lamborghini Urus 2025 được đánh giá là đối thủ phải khiến cho Bentley Bentayga, Porsche Cayenne hay Rolls-Royce Cullinan phải e sợ. ', 13000000000.00, 'uploads/1744095902_Urus.PNG', 'selling', 0, 0, 305.00, 'Beige and Brown, White and Black, Silver and Blue,', '4.0L twin-turbocharged V8', '2018', 5, 'Petrol', 641.00, NULL, 'TPHCM', NULL, '85L'),
(51, 1, 'Lamborghini Huracan EVO', 'Lamborghini Huracan Evo 2025 không hề lép vế so với 2 người anh em chung nhà là Lamborghini Aventador SVJ và Lamborghini Urus. Ngay từ khi xuất hiện tại triển lãm Bangkok Motor Show 2019. Lamborghini Huracan Evo 2025 đã thu hút rất nhiều những nhân vật đại gia mê xe. Chiếc siêu xe này hứa hẹn sẽ là đối thủ đáng gờm của những tên tuổi như Ferrari 488 Pista, McLaren 720S và Porsche GT2 RS.', 18000000000.00, 'uploads/1744096764_Capture.PNG', 'selling', 0, 0, 325.00, ' Rosso Mars, Arancio Borealis, Rosso Cadens Matt, ', '5.2L naturally aspirated V10', '2019', 2, 'Petrol', 631.00, NULL, 'TPHCM', NULL, '80L'),
(52, 1, 'Lamborghini Huracan STO', 'Một siêu xe thể thao được tạo ra với mục đích duy nhất, Huracán STO mang đến tất cả cảm giác và công nghệ của một chiếc xe đua thực thụ trong một mẫu xe hợp pháp trên đường phố.\r\nKiến thức chuyên môn về xe đua thể thao nhiều năm của Lamborghini, được tăng cường bởi di sản chiến thắng, được tập trung vào Huracán STO mới. Khí động học cực đỉnh, động lực xử lý được mài giũa trên đường đua, nội dung nhẹ và động cơ V10 hiệu suất cao nhất cho đến nay kết hợp với nhau, sẵn sàng khơi dậy mọi cảm xúc của đường đua trong cuộc sống hàng ngày của bạn.', 29000000000.00, 'uploads/1744098005_Capture1.PNG', 'selling', 0, 0, 310.00, 'Blue and Orrange', '5.2L naturally aspirated V10', '2021', 2, 'Petrol', 631.00, NULL, 'TPHCM', NULL, '80L'),
(53, 1, 'Lamborghini Huracan Performante', 'Huracán Performante đã làm lại khái niệm về siêu xe thể thao và đưa khái niệm về hiệu suất lên một tầm cao chưa từng thấy trước đây. Chiếc xe đã được thiết kế lại toàn bộ, về trọng lượng, công suất động cơ, khung gầm và trên hết là bằng cách giới thiệu một hệ thống khí động học chủ động tiên tiến: ALA. Việc sử dụng Forged Composites® đã được trao giải thưởng, một vật liệu sợi carbon rèn có thể định hình được cấp bằng sáng chế của Automobili Lamborghini, là một điểm nhấn thực sự tuyệt vời và góp phần làm cho chiếc xe thậm chí còn nhẹ hơn về trọng lượng. Bên cạnh các đặc tính công nghệ phi thường của nó, nó còn truyền tải một ý tưởng mới về vẻ đẹp.', 22000000000.00, 'uploads/1744098499_Capture12.PNG', 'selling', 0, 0, 310.00, 'Rosso Corsa, Giallo Modena, Bianco Avus', '5.2L naturally aspirated V10', '2021', 2, 'Petrol', 631.00, NULL, 'TPHCM', NULL, '80L'),
(54, 3, 'MAZDA CX-3', 'MAZDA CX-3 – Lựa chọn mới trong phân khúc SUV đô thị. Mẫu xe là sự kết hợp cân bằng giữa phong cách thiết năng động của mẫu xe SUV và trải nghiệm lái thú vị, linh hoạt của một chiếc Sedan. Sự kết hợp thú vị này sẽ mang đến nét riêng đặc trưng thể hiện cá tính và phong cách tự tin của người sở hữu.\r\n\r\n', 654000000.00, 'uploads/1744100278_Mazda.PNG', 'discounting', 0, 0, 190.00, 'Snowflake White Pearl Mica, Jet Black Mica, Machin', '2.0L SkyActiv-G inline-4 petrol engine​', '2015', 5, 'Petrol', 146.00, NULL, 'TPHCM', NULL, '48L'),
(55, 3, 'Mazda3', 'Mazda3 lấy cảm hứng từ mẫu concept nổi tiếng Vision Coupe – Mẫu xe Concept đẹp nhất thế giới năm 2018. Mazda3 được thiết kế Phong cách & Quyến rũ với các đường nét thanh thoát và sang trọng, khẳng định vẻ đẹp chuẩn mực vượt thời gian.', 669000000.00, 'uploads/1744101865_Mazda3.PNG', 'selling', 0, 0, 210.00, 'Arctic White​, Jet Black, Polymetal Grey​, Ceramic', '2.0L SkyActiv-G inline-4 petrol engine​', '2003', 5, 'Petrol', 155.00, NULL, 'TPHCM', NULL, '50L'),
(56, 3, 'Mazda6', 'MAZDA6 - PHONG CÁCH VÀ LỊCH LÃM\r\nVẻ đẹp thực thụ trong thiết kế không đơn thuần là việc thoả mãn yếu tố thẩm mỹ mà còn khơi gợi hứng khởi hành động trong mỗi người.', 1140000000.00, 'uploads/1744102168_Capture.PNG', 'selling', 0, 0, 210.00, 'Snowflake White Pearl Mica​, Jet Black Mica​, Alum', '2.5L SkyActiv-G inline-4 petrol engine​', '2002', 5, 'Petrol', 184.00, NULL, 'TPHCM', NULL, '62L'),
(57, 3, 'MAZDA CX-30', 'Hãy tận hưởng trải nghiệm lái hoàn hảo từ triết lý \"Jinba Ittai\" - Nhân Mã Hợp Nhất. Với Mazda CX-30, mỗi chuyến đi đều trở thành kỷ niệm khó quên.\r\nKhông gian nội thất hiện đại, rộng rãi. Mọi chi tiết được hoàn thiện bởi các bậc thầy nghệ nhân thủ công Takumi, trên nền tảng triết lý Human Centric - lấy con người làm trung tâm; để bạn luôn thư giãn và tận hưởng niềm vui lái xe, từ vị trí chân ga, tựa đầu và lưng cho đến các nút điều khiển được bố trí dễ dàng thao tác.​\r\n\r\nNgôn ngữ thiết kế Kodo thế hệ 7G thổi hồn vào những chiếc xe tạo cảm giác sống động. Mazda CX-30 - mẫu crossover linh hoạt và năng động, chinh phục mọi ánh nhìn với thiết kế đậm chất Âu sang trọng.​\r\n\r\n', 749000000.00, 'uploads/1744102450_Capture.PNG', 'selling', 0, 0, 190.00, 'Arctic White​, Jet Black, Polymetal Grey​, Ceramic', '2.0L SkyActiv-G inline-4 petrol engine', '2019', 5, 'Petrol', 153.00, NULL, 'TPHCM', NULL, '51L'),
(58, 3, 'Mazda2 Sport', 'Chậm rãi \"Nhìn\",\"Chạm\" và \"Cảm nhận\"hơi thở sành điệu, tự tin trong thiết kế KODO của mẫu xe thế hệ mới. Mẫu xe hướng bạn đến hình mẫu mà bạn khao khát.', 619000000.00, 'uploads/1744102763_.PNG', 'selling', 0, 0, 190.00, 'Snowflake White Pearl Mica, Jet Black Mica, Machin', '1.5L SkyActiv-G inline-4 petrol engine​', '2014', 5, 'Petrol', 110.00, NULL, 'TPHCM', NULL, '44L'),
(59, 4, 'Tesla Cybertruck', '\r\n140 / 5.000\r\nTesla Cybertruck là xe bán tải chạy hoàn toàn bằng điện được Tesla, Inc. giới thiệu vào tháng 11 năm 2019, sản xuất bắt đầu vào tháng 11 năm 2023', 2555000000.00, 'uploads/1744170467_truck.PNG', 'soldout', 0, 0, 290.00, 'While, Blue, Gray, Black', 'Electric Monitor', '2023', 5, 'Electric', 845.00, NULL, 'TPHCM', NULL, '100 kWh'),
(60, 4, 'Tesla Semi', 'The Tesla Semi is an all-electric Class 8 truck developed by Tesla, Inc., designed to revolutionize the freight and logistics industry with zero emissions and cutting-edge technology.\r\n372 / 5.000\r\nTesla Semi là xe tải chạy hoàn toàn bằng điện Class 8 do Tesla, Inc. phát triển, được thiết kế để cách mạng hóa ngành vận tải hàng hóa và hậu cần với công nghệ tiên tiến và không phát thải. Lần đầu tiên ra mắt vào năm 2017 và đi vào sản xuất vào năm 2022, Tesla Semi kết hợp hiệu suất cao với tính bền vững, cung cấp phạm vi hoạt động ấn tượng, khả năng tăng tốc nhanh và chi phí vận hành thấp.', 10375000000.00, 'uploads/1744171841_truck.PNG', 'hidden', 0, 0, 190.00, 'While, Blue, Gray, Black', 'Three independent electric motors', '2022', 1, 'Electric', 999.00, NULL, 'TPHCM', NULL, '100 kWh'),
(61, 4, 'Tesla Model X', 'Tesla Model X là một chiếc SUV chạy hoàn toàn bằng điện hạng sang kết hợp hiệu suất cao, công nghệ tiên tiến và thiết kế mang tính tương lai. Ra mắt lần đầu tiên vào năm 2015, xe được biết đến với cửa sau cánh chim ưng đặc trưng, ​​nội thất rộng rãi và các tính năng hỗ trợ người lái tiên tiến.', 2540000000.00, 'uploads/1744172650_truck.PNG', 'selling', 0, 0, 262.00, 'Pearl White Multi-Coat, Solid Black, Midnight Silv', 'Dual or Tri-motor all-wheel-drive electric powertrain', '2015', 6, 'Electric', 999.00, NULL, 'TPHCM', NULL, '100 kWh'),
(62, 4, 'Tesla Model S', 'Tesla Model S là một chiếc xe sang trọng chạy hoàn toàn bằng điện hiệu suất cao đã định nghĩa lại những gì xe điện có thể làm. Ra mắt vào năm 2012, mẫu xe này kết hợp thiết kế đẹp mắt, công nghệ tiên tiến và phạm vi hoạt động ấn tượng, khiến nó trở thành một trong những chiếc xe điện tiên tiến nhất trên thị trường.', 2415000000.00, 'uploads/1744173067_truck.PNG', 'selling', 0, 0, 322.00, 'Pearl White Multi-Coat, Solid Black, Midnight Silv', 'Dual or tri-motor all-wheel-drive electric powertrain', '2012', 5, 'Electric', 999.00, NULL, 'TPHCM', NULL, '100 kWh'),
(63, 4, 'Tesla Model Y', 'Tesla Model Y là một chiếc SUV cỡ trung chạy hoàn toàn bằng điện kết hợp hiệu suất, an toàn và tiện ích. Ra mắt vào năm 2020, xe có không gian lưu trữ rộng rãi, chỗ ngồi cho tối đa năm hành khách và các tính năng an toàn tiên tiến.​', 1334500000.00, 'uploads/1744173371_truck.PNG', 'selling', 0, 0, 250.00, 'Pearl White Multi-Coat, Solid Black, Midnight Silv', 'Dual Motor All-Wheel Drive', '2020', 5, 'Electric', 455.00, NULL, 'TPHCM', NULL, '83,9 kWh');

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
(11, '123', '123', 'activated', '2025-04-01 21:47:06', '0909220501', '123@gmail.com', 'admin', 'Kiệt 580 Hoàng Diệu, Quận Hải Châu, Thành phố Đà Nẵng', 'Đỗ Vĩ Ngạn');

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
  MODIFY `cart_id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=44;

--
-- AUTO_INCREMENT cho bảng `cart_items`
--
ALTER TABLE `cart_items`
  MODIFY `cart_item_id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=51;

--
-- AUTO_INCREMENT cho bảng `car_types`
--
ALTER TABLE `car_types`
  MODIFY `type_id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=8;

--
-- AUTO_INCREMENT cho bảng `orders`
--
ALTER TABLE `orders`
  MODIFY `order_id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=54;

--
-- AUTO_INCREMENT cho bảng `order_details`
--
ALTER TABLE `order_details`
  MODIFY `detail_id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=50;

--
-- AUTO_INCREMENT cho bảng `payment_methods`
--
ALTER TABLE `payment_methods`
  MODIFY `payment_method_id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=4;

--
-- AUTO_INCREMENT cho bảng `products`
--
ALTER TABLE `products`
  MODIFY `product_id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=64;

--
-- AUTO_INCREMENT cho bảng `users_acc`
--
ALTER TABLE `users_acc`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=12;

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

--
-- Các ràng buộc cho bảng `products`
--
ALTER TABLE `products`
  ADD CONSTRAINT `fk_brand` FOREIGN KEY (`brand_id`) REFERENCES `car_types` (`type_id`);
COMMIT;

/*!40101 SET CHARACTER_SET_CLIENT=@OLD_CHARACTER_SET_CLIENT */;
/*!40101 SET CHARACTER_SET_RESULTS=@OLD_CHARACTER_SET_RESULTS */;
/*!40101 SET COLLATION_CONNECTION=@OLD_COLLATION_CONNECTION */;
