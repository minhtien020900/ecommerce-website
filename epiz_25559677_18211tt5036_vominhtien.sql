-- phpMyAdmin SQL Dump
-- version 4.9.0.1
-- https://www.phpmyadmin.net/
--
-- Host: sql103.byetcluster.com
-- Generation Time: May 28, 2020 at 06:06 AM
-- Server version: 5.6.47-87.0
-- PHP Version: 7.2.22

SET SQL_MODE = "NO_AUTO_VALUE_ON_ZERO";
SET AUTOCOMMIT = 0;
START TRANSACTION;
SET time_zone = "+00:00";


/*!40101 SET @OLD_CHARACTER_SET_CLIENT=@@CHARACTER_SET_CLIENT */;
/*!40101 SET @OLD_CHARACTER_SET_RESULTS=@@CHARACTER_SET_RESULTS */;
/*!40101 SET @OLD_COLLATION_CONNECTION=@@COLLATION_CONNECTION */;
/*!40101 SET NAMES utf8mb4 */;

--
-- Database: `epiz_25559677_18211tt5036_vominhtien`
--

-- --------------------------------------------------------

--
-- Table structure for table `brand`
--

CREATE TABLE `brand` (
  `brand_id` int(11) NOT NULL,
  `brand_name` varchar(255) COLLATE utf8mb4_unicode_ci NOT NULL,
  `brand_image` varchar(255) COLLATE utf8mb4_unicode_ci NOT NULL
) ENGINE=MyISAM DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

--
-- Dumping data for table `brand`
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
(15, 'Genius', 'tải xuống.png');

-- --------------------------------------------------------

--
-- Table structure for table `brand_category`
--

CREATE TABLE `brand_category` (
  `category_id` int(11) NOT NULL,
  `brand_id` varchar(100) COLLATE utf8mb4_unicode_ci NOT NULL
) ENGINE=MyISAM DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

--
-- Dumping data for table `brand_category`
--

INSERT INTO `brand_category` (`category_id`, `brand_id`) VALUES
(1, '2/3/4/5/6/7/8'),
(2, '2/9/10/11/12/13'),
(3, '2/3'),
(4, '2'),
(5, '14/15/16');

-- --------------------------------------------------------

--
-- Table structure for table `carts`
--

CREATE TABLE `carts` (
  `cart_id` int(11) NOT NULL,
  `user_id` int(11) NOT NULL,
  `product_id` int(11) NOT NULL,
  `product_name` varchar(255) COLLATE utf8mb4_unicode_ci NOT NULL,
  `product_quanlity` int(11) NOT NULL,
  `product_price` decimal(10,2) NOT NULL,
  `cart_image` varchar(255) COLLATE utf8mb4_unicode_ci NOT NULL
) ENGINE=MyISAM DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

--
-- Dumping data for table `carts`
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
-- Table structure for table `cart_item`
--

CREATE TABLE `cart_item` (
  `cart_id` int(11) NOT NULL,
  `product_id` int(11) NOT NULL,
  `product_quanlity` int(11) NOT NULL
) ENGINE=MyISAM DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

-- --------------------------------------------------------

--
-- Table structure for table `category`
--

CREATE TABLE `category` (
  `category_id` int(11) NOT NULL,
  `category_name` varchar(255) COLLATE utf8mb4_unicode_ci NOT NULL
) ENGINE=MyISAM DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

--
-- Dumping data for table `category`
--

INSERT INTO `category` (`category_id`, `category_name`) VALUES
(1, 'Smart Phone'),
(2, 'Laptop'),
(3, 'Tablet'),
(4, 'Watch'),
(5, 'Accessories');

-- --------------------------------------------------------

--
-- Table structure for table `products`
--

CREATE TABLE `products` (
  `product_id` int(11) NOT NULL,
  `product_name` varchar(255) COLLATE utf8mb4_unicode_ci NOT NULL,
  `product_desc` text COLLATE utf8mb4_unicode_ci NOT NULL,
  `product_price` decimal(10,2) NOT NULL,
  `product_image` varchar(255) COLLATE utf8mb4_unicode_ci NOT NULL,
  `product_featured` int(11) NOT NULL DEFAULT '0',
  `product_soluong` int(11) NOT NULL,
  `product_image_other` varchar(1000) COLLATE utf8mb4_unicode_ci NOT NULL
) ENGINE=MyISAM DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

--
-- Dumping data for table `products`
--

INSERT INTO `products` (`product_id`, `product_name`, `product_desc`, `product_price`, `product_image`, `product_featured`, `product_soluong`, `product_image_other`) VALUES
(1, 'Điện thoại iPhone 11 Pro Max 256GB', '<p>iPhone 11 Pro Max 2 sim màu Midnight green là phiên bản được giới nghệ sĩ ưa chuộng nhất trong bộ ba iPhone 11 mới tại thị trường Việt Nam.</p><p>Ghi nhận tại hệ thống Di Động Việt, 80% lượng iPhone mới bán ra là iPhone 11 Pro Max 256GB 2 sim màu Midnight green. Không chỉ các nghệ sĩ trong showbiz mà rất nhiều khách hàng cũng phải lòng model này.</p>', '21900000.00', '637037687765081535_11-pro-max-vang.png', 1, 15, '637037687763107876_11-pro-max-trang.png/637037687764284663_11-pro-max-den.png/637037687765081535_11-pro-max-vang.png'),
(2, 'Điện thoại iPhone 7 Plus 32GB', '<p>Mặc dù giữ nguyên vẻ bề ngoài so với dòng điện thoại iPhone đời trước, bù lại iPhone 7 Plus 32GB lại được trang bị nhiều nâng cấp đáng giá như camera kép đầu tiên cũng như cấu hình mạnh mẽ.</p><p>Chiếc điện thoại sở hữu camera kép đầu tiên của Apple</p><p>iPhone 7 Plus là chiếc iPhone đầu tiên được trang bị camera kép có cùng độ phân giải 12 MP, đem lại khả năng chụp ảnh ở hai tiêu cự khác nhau.</p>', '12490000.00', 'apple-iphone-7-plus-1-400x460.png', 1, 15, 'iphone-7-plus-vangdong-2-180x125.jpg'),
(3, 'Laptop Apple MacBook Air 2018 i5/8GB/256GB (MREF2SA/A)', '<p>Đặc điểm nổi bật của iPad Wifi 32GB (2018)</p><p>Bộ sản phẩm chuẩn: Adapter, Sách hướng dẫn, Cáp Lightning, Hộp máy</p><p>iPad 6th Wifi 32GB với nhiều nâng cấp về phần cứng, đặc biệt hơn giá của sản phẩm này được định hình ở phân khúc giá rẻ, sinh viên sẽ là sự lựa chọn “không quá xa tầm tay” người dùng.</p>', '12490000.00', 'apple-macbook-air-2019-i5-16ghz-8gb-128gb-mvfm2sa-13-32-600x600.jpg', 1, 15, ''),
(4, 'Điện thoại iPhone Xs Max 256GB', '<p>Đặc điểm nổi bật của iPhone Xs Max 256GB</p><p>Tìm hiểu thêm</p><p>Bộ sản phẩm chuẩn: Hộp, Sạc, Tai nghe, Sách hướng dẫn, Cáp, Cây lấy sim</p><p>Sau 1 năm mong chờ, chiếc smartphone cao cấp nhất của Apple đã chính thức ra mắt mang tên iPhone Xs Max. Máy các trang bị các tính năng cao cấp nhất từ chip A12 Bionic, dàn loa đa chiều cho tới camera kép tích hợp trí tuệ nhân tạo.</p><p><span style=\"font-size: 1rem;\">Hiệu năng đỉnh cao cùng chip Apple A12</span></p><p>iPhone Xs Max được Apple trang bị cho con chip mới toanh hàng đầu của hãng mang tên Apple A12.</p><p>Chip A12 Bionic được xây dựng trên tiến trình 7nm đầu tiên mà hãng sản xuất với 6 nhân đáp ứng vượt trội trong việc xử lý các tác vụ và khả năng tiết kiệm năng lượng tối ưu.</p>', '32990000.00', 'iphone-xs-max-gold-400x460.png', 1, 10, '637037687763107876_11-pro-max-trang.png/637037687764284663_11-pro-max-den.png/637037687765081535_11-pro-max-vang.png/apple-iphone-7-plus-1-400x460.png/iphone-11-pro-max-512gb-gold-400x460.png/iphone-xs-max-gold-400x460.png');

-- --------------------------------------------------------

--
-- Table structure for table `product_brand`
--

CREATE TABLE `product_brand` (
  `product_id` int(11) NOT NULL,
  `brand_id` int(11) NOT NULL
) ENGINE=MyISAM DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

--
-- Dumping data for table `product_brand`
--

INSERT INTO `product_brand` (`product_id`, `brand_id`) VALUES
(1, 1),
(2, 1);

-- --------------------------------------------------------

--
-- Table structure for table `product_category`
--

CREATE TABLE `product_category` (
  `product_id` int(11) NOT NULL,
  `category_id` int(11) NOT NULL
) ENGINE=MyISAM DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

-- --------------------------------------------------------

--
-- Table structure for table `product_category_brand`
--

CREATE TABLE `product_category_brand` (
  `product_id` int(11) NOT NULL,
  `category_id` int(11) NOT NULL,
  `brand_id` int(11) NOT NULL
) ENGINE=MyISAM DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

--
-- Dumping data for table `product_category_brand`
--

INSERT INTO `product_category_brand` (`product_id`, `category_id`, `brand_id`) VALUES
(1, 1, 2),
(2, 1, 2),
(3, 2, 2),
(4, 1, 2);

-- --------------------------------------------------------

--
-- Table structure for table `role`
--

CREATE TABLE `role` (
  `role_id` int(11) NOT NULL,
  `role_name` varchar(255) COLLATE utf8mb4_unicode_ci NOT NULL
) ENGINE=MyISAM DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

--
-- Dumping data for table `role`
--

INSERT INTO `role` (`role_id`, `role_name`) VALUES
(1, 'Khách hàng'),
(2, 'Nhân viên'),
(3, 'Quản lý');

-- --------------------------------------------------------

--
-- Table structure for table `status`
--

CREATE TABLE `status` (
  `status_id` int(11) NOT NULL,
  `status_name` varchar(255) COLLATE utf8mb4_unicode_ci NOT NULL
) ENGINE=MyISAM DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

--
-- Dumping data for table `status`
--

INSERT INTO `status` (`status_id`, `status_name`) VALUES
(1, 'Kích hoạt'),
(2, 'Block');

-- --------------------------------------------------------

--
-- Table structure for table `users`
--

CREATE TABLE `users` (
  `user_id` int(11) NOT NULL,
  `user_name` varchar(255) COLLATE utf8mb4_unicode_ci NOT NULL,
  `user_email` varchar(200) COLLATE utf8mb4_unicode_ci NOT NULL,
  `user_phone` varchar(200) COLLATE utf8mb4_unicode_ci NOT NULL,
  `user_pass` varchar(255) COLLATE utf8mb4_unicode_ci NOT NULL,
  `user_image` varchar(255) COLLATE utf8mb4_unicode_ci NOT NULL,
  `user_role` int(11) NOT NULL DEFAULT '0',
  `user_date_create` varchar(255) COLLATE utf8mb4_unicode_ci NOT NULL,
  `user_last_update` varchar(255) COLLATE utf8mb4_unicode_ci NOT NULL,
  `user_status` int(11) NOT NULL DEFAULT '0'
) ENGINE=MyISAM DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

--
-- Dumping data for table `users`
--

INSERT INTO `users` (`user_id`, `user_name`, `user_email`, `user_phone`, `user_pass`, `user_image`, `user_role`, `user_date_create`, `user_last_update`, `user_status`) VALUES
(1, 'Nguyễn Minh Hào', '123@gmail.com', '0987380249', 'e10adc3949ba59abbe56e057f20f883e', '26047360_2087629618132796_4032693926236616078_n.jpg', 3, '20-11-2019 14:14:38', '29-04-2020 21:52:43', 1),
(6, 'Võ Minh Tiến', 'x12@gmail.com', '09873802492', '827ccb0eea8a706c4c34a16891f84e7b', '', 1, '20-11-2019 18:45:09', '', 1),
(7, 'Tiến Xinh Trai', 'tientxt@gmail.com', '09873802495', '827ccb0eea8a706c4c34a16891f84e7b', '', 1, '22-11-2019 10:42:19', '24-11-2019 19:59:21', 1),
(8, 'Võ Minh Tiến', 'x123@gmail.com', '0987380242', '827ccb0eea8a706c4c34a16891f84e7b', '', 1, '22-11-2019 11:04:42', '', 1),
(9, 'Cao Thị Tú Như', 'nhuxinhdep@gmail.com', '01284627370', '827ccb0eea8a706c4c34a16891f84e7b', '', 1, '24-11-2019 17:50:48', '', 1),
(10, 'Nguyễn Minh Hào', '122@gmail.com', '0987380248', 'e10adc3949ba59abbe56e057f20f883e', '20180605_174559.jpg', 2, '25-04-2020 21:03:01', '25-04-2020 21:04:50', 1);

--
-- Indexes for dumped tables
--

--
-- Indexes for table `brand`
--
ALTER TABLE `brand`
  ADD PRIMARY KEY (`brand_id`);

--
-- Indexes for table `brand_category`
--
ALTER TABLE `brand_category`
  ADD PRIMARY KEY (`category_id`,`brand_id`);

--
-- Indexes for table `carts`
--
ALTER TABLE `carts`
  ADD PRIMARY KEY (`cart_id`);

--
-- Indexes for table `cart_item`
--
ALTER TABLE `cart_item`
  ADD PRIMARY KEY (`cart_id`);

--
-- Indexes for table `category`
--
ALTER TABLE `category`
  ADD PRIMARY KEY (`category_id`);

--
-- Indexes for table `products`
--
ALTER TABLE `products`
  ADD PRIMARY KEY (`product_id`);

--
-- Indexes for table `product_brand`
--
ALTER TABLE `product_brand`
  ADD PRIMARY KEY (`product_id`,`brand_id`);

--
-- Indexes for table `product_category`
--
ALTER TABLE `product_category`
  ADD PRIMARY KEY (`product_id`,`category_id`);

--
-- Indexes for table `product_category_brand`
--
ALTER TABLE `product_category_brand`
  ADD PRIMARY KEY (`product_id`,`category_id`,`brand_id`);

--
-- Indexes for table `role`
--
ALTER TABLE `role`
  ADD PRIMARY KEY (`role_id`);

--
-- Indexes for table `status`
--
ALTER TABLE `status`
  ADD PRIMARY KEY (`status_id`);

--
-- Indexes for table `users`
--
ALTER TABLE `users`
  ADD PRIMARY KEY (`user_id`),
  ADD UNIQUE KEY `user_email` (`user_email`),
  ADD UNIQUE KEY `user_phone` (`user_phone`);

--
-- AUTO_INCREMENT for dumped tables
--

--
-- AUTO_INCREMENT for table `brand`
--
ALTER TABLE `brand`
  MODIFY `brand_id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=17;

--
-- AUTO_INCREMENT for table `carts`
--
ALTER TABLE `carts`
  MODIFY `cart_id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=28;

--
-- AUTO_INCREMENT for table `cart_item`
--
ALTER TABLE `cart_item`
  MODIFY `cart_id` int(11) NOT NULL AUTO_INCREMENT;

--
-- AUTO_INCREMENT for table `category`
--
ALTER TABLE `category`
  MODIFY `category_id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=9;

--
-- AUTO_INCREMENT for table `products`
--
ALTER TABLE `products`
  MODIFY `product_id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=5;

--
-- AUTO_INCREMENT for table `product_category_brand`
--
ALTER TABLE `product_category_brand`
  MODIFY `product_id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=5;

--
-- AUTO_INCREMENT for table `role`
--
ALTER TABLE `role`
  MODIFY `role_id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=4;

--
-- AUTO_INCREMENT for table `status`
--
ALTER TABLE `status`
  MODIFY `status_id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=3;

--
-- AUTO_INCREMENT for table `users`
--
ALTER TABLE `users`
  MODIFY `user_id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=11;
COMMIT;

/*!40101 SET CHARACTER_SET_CLIENT=@OLD_CHARACTER_SET_CLIENT */;
/*!40101 SET CHARACTER_SET_RESULTS=@OLD_CHARACTER_SET_RESULTS */;
/*!40101 SET COLLATION_CONNECTION=@OLD_COLLATION_CONNECTION */;
