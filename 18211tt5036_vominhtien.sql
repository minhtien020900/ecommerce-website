-- phpMyAdmin SQL Dump
-- version 4.8.5
-- https://www.phpmyadmin.net/
--
-- Máy chủ: 127.0.0.1:3306
-- Thời gian đã tạo: Th10 24, 2019 lúc 04:36 PM
-- Phiên bản máy phục vụ: 5.7.26
-- Phiên bản PHP: 7.2.18

SET SQL_MODE = "NO_AUTO_VALUE_ON_ZERO";
SET AUTOCOMMIT = 0;
START TRANSACTION;
SET time_zone = "+00:00";


/*!40101 SET @OLD_CHARACTER_SET_CLIENT=@@CHARACTER_SET_CLIENT */;
/*!40101 SET @OLD_CHARACTER_SET_RESULTS=@@CHARACTER_SET_RESULTS */;
/*!40101 SET @OLD_COLLATION_CONNECTION=@@COLLATION_CONNECTION */;
/*!40101 SET NAMES utf8mb4 */;

--
-- Cơ sở dữ liệu: `18211tt5036_vominhtien`
--

-- --------------------------------------------------------

--
-- Cấu trúc bảng cho bảng `brand`
--

DROP TABLE IF EXISTS `brand`;
CREATE TABLE IF NOT EXISTS `brand` (
  `brand_id` int(11) NOT NULL AUTO_INCREMENT,
  `brand_name` varchar(255) COLLATE utf8mb4_unicode_ci NOT NULL,
  `brand_image` varchar(255) COLLATE utf8mb4_unicode_ci NOT NULL,
  PRIMARY KEY (`brand_id`)
) ENGINE=MyISAM AUTO_INCREMENT=17 DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

--
-- Đang đổ dữ liệu cho bảng `brand`
--

INSERT INTO `brand` (`brand_id`, `brand_name`, `brand_image`) VALUES
(2, 'Apple', 'logo-apple-hien-tai.jpg'),
(3, 'Samsung', 'samsunglogo-1.jpg'),
(4, 'Huawei', '1008px-Huawei_Standard_logo.svg.png'),
(5, 'Realme', 'GO (77)-kjmB--621x414@LiveMint.png'),
(6, 'Oppo', 'oppo-logo-old_600x277.jpg'),
(7, 'Sony', 'thiet-ke-logo-sony.jpg'),
(8, 'Nokia', '63caa317adda8ddd239957630c38247e.png'),
(9, 'Asus', '1_NwfoiV9f96_MhpmJwdinPA.png'),
(10, 'Acer', 'logo-acer.png'),
(11, 'HP', 'HP-Logo.jpg'),
(12, 'MSI', 'flat,800x800,070,f.u1.jpg'),
(13, 'Dell', '1-dell-logo-webjpg.jpg'),
(14, 'Logitech', 'y8Ng5ej.png'),
(15, 'Genius', 'tải xuống.png'),
(16, 'Zadez', 'zadez_logo.png');

-- --------------------------------------------------------

--
-- Cấu trúc bảng cho bảng `brand_category`
--

DROP TABLE IF EXISTS `brand_category`;
CREATE TABLE IF NOT EXISTS `brand_category` (
  `category_id` int(11) NOT NULL,
  `brand_id` varchar(100) COLLATE utf8mb4_unicode_ci NOT NULL,
  PRIMARY KEY (`category_id`,`brand_id`)
) ENGINE=MyISAM DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

--
-- Đang đổ dữ liệu cho bảng `brand_category`
--

INSERT INTO `brand_category` (`category_id`, `brand_id`) VALUES
(1, '2/3/4/5/6/7/8'),
(2, '2/9/10/11/12/13'),
(3, '2/3'),
(4, '2'),
(5, '14/15/16');

-- --------------------------------------------------------

--
-- Cấu trúc bảng cho bảng `carts`
--

DROP TABLE IF EXISTS `carts`;
CREATE TABLE IF NOT EXISTS `carts` (
  `cart_id` int(11) NOT NULL AUTO_INCREMENT,
  `user_id` int(11) NOT NULL,
  `product_id` int(11) NOT NULL,
  `product_name` varchar(255) COLLATE utf8mb4_unicode_ci NOT NULL,
  `product_quanlity` int(11) NOT NULL,
  `product_price` decimal(10,2) NOT NULL,
  `cart_image` varchar(255) COLLATE utf8mb4_unicode_ci NOT NULL,
  PRIMARY KEY (`cart_id`)
) ENGINE=MyISAM AUTO_INCREMENT=28 DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

--
-- Đang đổ dữ liệu cho bảng `carts`
--

INSERT INTO `carts` (`cart_id`, `user_id`, `product_id`, `product_name`, `product_quanlity`, `product_price`, `cart_image`) VALUES
(24, 0, 1, 'Điện thoại iPhone 11 Pro Max 256GB', 1, '21900000.00', '637037687765081535_11-pro-max-vang.png'),
(15, 7, 2, 'Điện thoại iPhone 7 Plus 32GB', 1, '12490000.00', 'apple-iphone-7-plus-1-400x460.png'),
(22, 7, 1, 'Điện thoại iPhone 11 Pro Max 256GB', 6, '21900000.00', '637037687765081535_11-pro-max-vang.png'),
(23, 0, 1, 'Điện thoại iPhone 11 Pro Max 256GB', 1, '21900000.00', '637037687765081535_11-pro-max-vang.png'),
(18, 7, 4, 'Điện thoại iPhone Xs Max 256GB', 2, '32990000.00', 'iphone-xs-max-gold-400x460.png'),
(21, 9, 1, 'Điện thoại iPhone 11 Pro Max 256GB', 5, '21900000.00', '637037687765081535_11-pro-max-vang.png'),
(25, 0, 1, 'Điện thoại iPhone 11 Pro Max 256GB', 1, '21900000.00', '637037687765081535_11-pro-max-vang.png'),
(26, 0, 1, 'Điện thoại iPhone 11 Pro Max 256GB', 1, '21900000.00', '637037687765081535_11-pro-max-vang.png'),
(27, 0, 1, 'Điện thoại iPhone 11 Pro Max 256GB', 1, '21900000.00', '637037687765081535_11-pro-max-vang.png');

-- --------------------------------------------------------

--
-- Cấu trúc bảng cho bảng `cart_item`
--

DROP TABLE IF EXISTS `cart_item`;
CREATE TABLE IF NOT EXISTS `cart_item` (
  `cart_id` int(11) NOT NULL AUTO_INCREMENT,
  `product_id` int(11) NOT NULL,
  `product_quanlity` int(11) NOT NULL,
  PRIMARY KEY (`cart_id`)
) ENGINE=MyISAM DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

-- --------------------------------------------------------

--
-- Cấu trúc bảng cho bảng `category`
--

DROP TABLE IF EXISTS `category`;
CREATE TABLE IF NOT EXISTS `category` (
  `category_id` int(11) NOT NULL AUTO_INCREMENT,
  `category_name` varchar(255) COLLATE utf8mb4_unicode_ci NOT NULL,
  PRIMARY KEY (`category_id`)
) ENGINE=MyISAM AUTO_INCREMENT=6 DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

--
-- Đang đổ dữ liệu cho bảng `category`
--

INSERT INTO `category` (`category_id`, `category_name`) VALUES
(1, 'Smart Phone'),
(2, 'Laptop'),
(3, 'Tablet'),
(4, 'Watch'),
(5, 'Accessories');

-- --------------------------------------------------------

--
-- Cấu trúc bảng cho bảng `products`
--

DROP TABLE IF EXISTS `products`;
CREATE TABLE IF NOT EXISTS `products` (
  `product_id` int(11) NOT NULL AUTO_INCREMENT,
  `product_name` varchar(255) COLLATE utf8mb4_unicode_ci NOT NULL,
  `product_desc` text COLLATE utf8mb4_unicode_ci NOT NULL,
  `product_price` decimal(10,2) NOT NULL,
  `product_image` varchar(255) COLLATE utf8mb4_unicode_ci NOT NULL,
  `product_featured` int(11) NOT NULL DEFAULT '0',
  `product_soluong` int(11) NOT NULL,
  `product_image_other` varchar(1000) COLLATE utf8mb4_unicode_ci NOT NULL,
  PRIMARY KEY (`product_id`)
) ENGINE=MyISAM AUTO_INCREMENT=5 DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

--
-- Đang đổ dữ liệu cho bảng `products`
--

INSERT INTO `products` (`product_id`, `product_name`, `product_desc`, `product_price`, `product_image`, `product_featured`, `product_soluong`, `product_image_other`) VALUES
(1, 'Điện thoại iPhone 11 Pro Max 256GB', '<p>iPhone 11 Pro Max 2 sim màu Midnight green là phiên bản được giới nghệ sĩ ưa chuộng nhất trong bộ ba iPhone 11 mới tại thị trường Việt Nam.</p><p>Ghi nhận tại hệ thống Di Động Việt, 80% lượng iPhone mới bán ra là iPhone 11 Pro Max 256GB 2 sim màu Midnight green. Không chỉ các nghệ sĩ trong showbiz mà rất nhiều khách hàng cũng phải lòng model này.</p>', '21900000.00', '637037687765081535_11-pro-max-vang.png', 1, 15, '637037687763107876_11-pro-max-trang.png/637037687764284663_11-pro-max-den.png/637037687765081535_11-pro-max-vang.png'),
(2, 'Điện thoại iPhone 7 Plus 32GB', '<p>Mặc dù giữ nguyên vẻ bề ngoài so với dòng điện thoại iPhone đời trước, bù lại iPhone 7 Plus 32GB lại được trang bị nhiều nâng cấp đáng giá như camera kép đầu tiên cũng như cấu hình mạnh mẽ.</p><p>Chiếc điện thoại sở hữu camera kép đầu tiên của Apple</p><p>iPhone 7 Plus là chiếc iPhone đầu tiên được trang bị camera kép có cùng độ phân giải 12 MP, đem lại khả năng chụp ảnh ở hai tiêu cự khác nhau.</p>', '12490000.00', 'apple-iphone-7-plus-1-400x460.png', 1, 15, 'iphone-7-plus-vangdong-2-180x125.jpg'),
(3, 'Laptop Apple MacBook Air 2018 i5/8GB/256GB (MREF2SA/A)', '<p>Đặc điểm nổi bật của iPad Wifi 32GB (2018)</p><p>Bộ sản phẩm chuẩn: Adapter, Sách hướng dẫn, Cáp Lightning, Hộp máy</p><p>iPad 6th Wifi 32GB với nhiều nâng cấp về phần cứng, đặc biệt hơn giá của sản phẩm này được định hình ở phân khúc giá rẻ, sinh viên sẽ là sự lựa chọn “không quá xa tầm tay” người dùng.</p>', '12490000.00', 'apple-macbook-air-2019-i5-16ghz-8gb-128gb-mvfm2sa-13-32-600x600.jpg', 1, 15, ''),
(4, 'Điện thoại iPhone Xs Max 256GB', '<p>Đặc điểm nổi bật của iPhone Xs Max 256GB</p><p>Tìm hiểu thêm</p><p>Bộ sản phẩm chuẩn: Hộp, Sạc, Tai nghe, Sách hướng dẫn, Cáp, Cây lấy sim</p><p>Sau 1 năm mong chờ, chiếc smartphone cao cấp nhất của Apple đã chính thức ra mắt mang tên iPhone Xs Max. Máy các trang bị các tính năng cao cấp nhất từ chip A12 Bionic, dàn loa đa chiều cho tới camera kép tích hợp trí tuệ nhân tạo.</p><p><span style=\"font-size: 1rem;\">Hiệu năng đỉnh cao cùng chip Apple A12</span></p><p>iPhone Xs Max được Apple trang bị cho con chip mới toanh hàng đầu của hãng mang tên Apple A12.</p><p>Chip A12 Bionic được xây dựng trên tiến trình 7nm đầu tiên mà hãng sản xuất với 6 nhân đáp ứng vượt trội trong việc xử lý các tác vụ và khả năng tiết kiệm năng lượng tối ưu.</p>', '32990000.00', 'iphone-xs-max-gold-400x460.png', 1, 10, '637037687763107876_11-pro-max-trang.png/637037687764284663_11-pro-max-den.png/637037687765081535_11-pro-max-vang.png/apple-iphone-7-plus-1-400x460.png/iphone-11-pro-max-512gb-gold-400x460.png/iphone-xs-max-gold-400x460.png');

-- --------------------------------------------------------

--
-- Cấu trúc bảng cho bảng `product_brand`
--

DROP TABLE IF EXISTS `product_brand`;
CREATE TABLE IF NOT EXISTS `product_brand` (
  `product_id` int(11) NOT NULL,
  `brand_id` int(11) NOT NULL,
  PRIMARY KEY (`product_id`,`brand_id`)
) ENGINE=MyISAM DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

--
-- Đang đổ dữ liệu cho bảng `product_brand`
--

INSERT INTO `product_brand` (`product_id`, `brand_id`) VALUES
(1, 1),
(2, 1);

-- --------------------------------------------------------

--
-- Cấu trúc bảng cho bảng `product_category`
--

DROP TABLE IF EXISTS `product_category`;
CREATE TABLE IF NOT EXISTS `product_category` (
  `product_id` int(11) NOT NULL,
  `category_id` int(11) NOT NULL,
  PRIMARY KEY (`product_id`,`category_id`)
) ENGINE=MyISAM DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

-- --------------------------------------------------------

--
-- Cấu trúc bảng cho bảng `product_category_brand`
--

DROP TABLE IF EXISTS `product_category_brand`;
CREATE TABLE IF NOT EXISTS `product_category_brand` (
  `product_id` int(11) NOT NULL AUTO_INCREMENT,
  `category_id` int(11) NOT NULL,
  `brand_id` int(11) NOT NULL,
  PRIMARY KEY (`product_id`,`category_id`,`brand_id`)
) ENGINE=MyISAM AUTO_INCREMENT=5 DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

--
-- Đang đổ dữ liệu cho bảng `product_category_brand`
--

INSERT INTO `product_category_brand` (`product_id`, `category_id`, `brand_id`) VALUES
(1, 1, 2),
(2, 1, 2),
(3, 2, 2),
(4, 1, 2);

-- --------------------------------------------------------

--
-- Cấu trúc bảng cho bảng `role`
--

DROP TABLE IF EXISTS `role`;
CREATE TABLE IF NOT EXISTS `role` (
  `role_id` int(11) NOT NULL AUTO_INCREMENT,
  `role_name` varchar(255) COLLATE utf8mb4_unicode_ci NOT NULL,
  PRIMARY KEY (`role_id`)
) ENGINE=MyISAM AUTO_INCREMENT=4 DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

--
-- Đang đổ dữ liệu cho bảng `role`
--

INSERT INTO `role` (`role_id`, `role_name`) VALUES
(1, 'Khách hàng'),
(2, 'Nhân viên'),
(3, 'Quản lý');

-- --------------------------------------------------------

--
-- Cấu trúc bảng cho bảng `status`
--

DROP TABLE IF EXISTS `status`;
CREATE TABLE IF NOT EXISTS `status` (
  `status_id` int(11) NOT NULL AUTO_INCREMENT,
  `status_name` varchar(255) COLLATE utf8mb4_unicode_ci NOT NULL,
  PRIMARY KEY (`status_id`)
) ENGINE=MyISAM AUTO_INCREMENT=3 DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

--
-- Đang đổ dữ liệu cho bảng `status`
--

INSERT INTO `status` (`status_id`, `status_name`) VALUES
(1, 'Kích hoạt'),
(2, 'Block');

-- --------------------------------------------------------

--
-- Cấu trúc bảng cho bảng `users`
--

DROP TABLE IF EXISTS `users`;
CREATE TABLE IF NOT EXISTS `users` (
  `user_id` int(11) NOT NULL AUTO_INCREMENT,
  `user_name` varchar(255) COLLATE utf8mb4_unicode_ci NOT NULL,
  `user_email` varchar(200) COLLATE utf8mb4_unicode_ci NOT NULL,
  `user_phone` varchar(200) COLLATE utf8mb4_unicode_ci NOT NULL,
  `user_pass` varchar(255) COLLATE utf8mb4_unicode_ci NOT NULL,
  `user_image` varchar(255) COLLATE utf8mb4_unicode_ci NOT NULL,
  `user_role` int(11) NOT NULL DEFAULT '0',
  `user_date_create` varchar(255) COLLATE utf8mb4_unicode_ci NOT NULL,
  `user_last_update` varchar(255) COLLATE utf8mb4_unicode_ci NOT NULL,
  `user_status` int(11) NOT NULL DEFAULT '0',
  PRIMARY KEY (`user_id`),
  UNIQUE KEY `user_email` (`user_email`),
  UNIQUE KEY `user_phone` (`user_phone`)
) ENGINE=MyISAM AUTO_INCREMENT=10 DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

--
-- Đang đổ dữ liệu cho bảng `users`
--

INSERT INTO `users` (`user_id`, `user_name`, `user_email`, `user_phone`, `user_pass`, `user_image`, `user_role`, `user_date_create`, `user_last_update`, `user_status`) VALUES
(1, 'Võ Minh Tiến', '123@gmail.com', '0987380249', '827ccb0eea8a706c4c34a16891f84e7b', '1024px-Xiaomi_logo.svg.png', 3, '20-11-2019 14:14:38', '20-11-2019 14:17:02', 1),
(6, 'Võ Minh Tiến', 'x12@gmail.com', '09873802492', '827ccb0eea8a706c4c34a16891f84e7b', '', 1, '20-11-2019 18:45:09', '', 1),
(7, 'Tiến Xinh Trai', 'tientxt@gmail.com', '09873802495', '827ccb0eea8a706c4c34a16891f84e7b', '', 1, '22-11-2019 10:42:19', '24-11-2019 19:59:21', 1),
(8, 'Võ Minh Tiến', 'x123@gmail.com', '0987380242', '827ccb0eea8a706c4c34a16891f84e7b', '', 1, '22-11-2019 11:04:42', '', 1),
(9, 'Cao Thị Tú Như', 'nhuxinhdep@gmail.com', '01284627370', '827ccb0eea8a706c4c34a16891f84e7b', '', 1, '24-11-2019 17:50:48', '', 1);
COMMIT;

/*!40101 SET CHARACTER_SET_CLIENT=@OLD_CHARACTER_SET_CLIENT */;
/*!40101 SET CHARACTER_SET_RESULTS=@OLD_CHARACTER_SET_RESULTS */;
/*!40101 SET COLLATION_CONNECTION=@OLD_COLLATION_CONNECTION */;
