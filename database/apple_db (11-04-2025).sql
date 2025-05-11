-- phpMyAdmin SQL Dump
-- version 5.2.1
-- https://www.phpmyadmin.net/
--
-- Máy chủ: 127.0.0.1
-- Thời gian đã tạo: Th4 10, 2025 lúc 07:32 PM
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
-- Cơ sở dữ liệu: `apple_db`
--

-- --------------------------------------------------------

--
-- Cấu trúc bảng cho bảng `attributes`
--

CREATE TABLE `attributes` (
  `attributeId` int(11) NOT NULL,
  `attributeName` varchar(255) DEFAULT NULL,
  `attributeStatus` tinyint(4) DEFAULT 1,
  `create_at` datetime DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

--
-- Đang đổ dữ liệu cho bảng `attributes`
--

INSERT INTO `attributes` (`attributeId`, `attributeName`, `attributeStatus`, `create_at`) VALUES
(2, 'Màu', 1, '2025-02-18 09:55:02'),
(3, 'Dung lượng', 1, '2025-02-18 09:55:12'),
(4, 'Giá gốc', 1, '2025-02-18 09:55:33'),
(6, 'Ảnh phụ', 1, '2025-02-18 09:55:46');

-- --------------------------------------------------------

--
-- Cấu trúc bảng cho bảng `blogs`
--

CREATE TABLE `blogs` (
  `blogId` int(11) NOT NULL,
  `blogTitle` varchar(255) DEFAULT NULL,
  `blogSlug` varchar(255) DEFAULT NULL,
  `blogImage` varchar(255) DEFAULT NULL,
  `blogDescription` varchar(255) DEFAULT NULL,
  `blogContent` text DEFAULT NULL,
  `create_at` datetime DEFAULT NULL,
  `blogStatus` tinyint(4) DEFAULT NULL,
  `categoryId` int(11) DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

--
-- Đang đổ dữ liệu cho bảng `blogs`
--

INSERT INTO `blogs` (`blogId`, `blogTitle`, `blogSlug`, `blogImage`, `blogDescription`, `blogContent`, `create_at`, `blogStatus`, `categoryId`) VALUES
(1, 'Chào năm mới', 'chao-nam-moi-72', 'BLOG_18022025041750.jpg', 'Dienjdwroegeatrthrthrth', 'erthrthhhhhhhhhhhhhhhhhhhhhhhhhhhhhhhhhhhhhhhh', '2025-02-18 10:17:50', 1, 1);

-- --------------------------------------------------------

--
-- Cấu trúc bảng cho bảng `categories`
--

CREATE TABLE `categories` (
  `categoryId` int(11) NOT NULL,
  `categoryName` varchar(255) DEFAULT NULL,
  `categorySlug` varchar(255) DEFAULT NULL,
  `categoryDescription` varchar(255) DEFAULT NULL,
  `categoryImage` varchar(255) DEFAULT NULL,
  `categoryStatus` tinyint(4) DEFAULT NULL,
  `create_at` datetime DEFAULT NULL,
  `categoryLogo` varchar(255) DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

--
-- Đang đổ dữ liệu cho bảng `categories`
--

INSERT INTO `categories` (`categoryId`, `categoryName`, `categorySlug`, `categoryDescription`, `categoryImage`, `categoryStatus`, `create_at`, `categoryLogo`) VALUES
(1, 'iPhone', 'iphone-slug-21', 'iPhone Series', 'AMD_17022025200638.png', 1, '2025-02-18 02:06:38', 'LOGO_17022025200638.png'),
(2, 'Mac', 'macbook-slug-73', 'Macbook series', 'AMD_18022025025829.png', 1, '2025-02-18 08:58:29', 'LOGO_18022025025829.png'),
(3, 'iPad', 'ipad-slug-74', 'ipad series', 'AMD_18022025025906.png', 1, '2025-02-18 08:59:06', 'LOGO_18022025025906.png'),
(4, 'Watch', 'watch-slug-16', 'Apple Watch Series', 'AMD_18022025030016.png', 1, '2025-02-18 09:00:16', 'LOGO_18022025030016.png'),
(5, 'Tai nghe, loa', 'headphone-slug-81', 'Headphone series', 'AMD_18022025030059.png', 1, '2025-02-18 09:00:59', 'LOGO_18022025030059.png'),
(6, 'Phụ kiện', 'Accessories -89', 'Accessories - products', 'AMD_18022025030127.png', 1, '2025-02-18 09:01:27', 'LOGO_18022025030127.png');

-- --------------------------------------------------------

--
-- Cấu trúc bảng cho bảng `discounts`
--

CREATE TABLE `discounts` (
  `discountId` int(11) NOT NULL,
  `discountName` varchar(255) NOT NULL,
  `discountPercentage` decimal(5,2) NOT NULL,
  `discountSlug` varchar(255) NOT NULL,
  `discountDescription` varchar(255) NOT NULL,
  `discountStartDate` datetime NOT NULL,
  `discountEndDate` datetime NOT NULL,
  `create_at` datetime DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

--
-- Đang đổ dữ liệu cho bảng `discounts`
--

INSERT INTO `discounts` (`discountId`, `discountName`, `discountPercentage`, `discountSlug`, `discountDescription`, `discountStartDate`, `discountEndDate`, `create_at`) VALUES
(7, 'Giảm giá mùa hè', 20.00, 'giam-gia-mua-he', 'Giảm giá 20% cho tất cả sản phẩm trong mùa hè.', '2025-05-01 00:00:00', '2025-08-31 23:59:59', NULL),
(8, 'Khuyến mãi Tết Nguyên Đán', 15.00, 'khuyen-mai-tet', 'Giảm giá 15% cho sản phẩm thực phẩm trong dịp Tết.', '2025-01-01 00:00:00', '2025-01-31 23:59:59', NULL),
(9, 'Giảm giá sinh nhật', 10.00, 'giam-gia-sinh-nhat', 'Giảm giá 10% cho tất cả đơn hàng trong tháng sinh nhật.', '2025-03-01 00:00:00', '2025-03-31 23:59:59', NULL),
(10, 'Mua 1 tặng 1', 50.00, 'mua-1-tang-1', 'Mua 1 sản phẩm, tặng 1 sản phẩm cùng loại.', '2025-07-01 00:00:00', '2025-07-31 23:59:59', NULL),
(11, 'Giảm giá Black Friday', 50.00, 'giam-gia-black-friday', 'Giảm giá 50% cho tất cả sản phẩm vào ngày Black Friday.', '2025-11-25 00:00:00', '2025-11-26 23:59:59', NULL);

-- --------------------------------------------------------

--
-- Cấu trúc bảng cho bảng `orderdetails`
--

CREATE TABLE `orderdetails` (
  `orderDetailId` int(11) NOT NULL,
  `orderDetailQuantity` int(11) NOT NULL,
  `orderDetailPrice` decimal(12,2) NOT NULL,
  `orderId` int(11) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

--
-- Đang đổ dữ liệu cho bảng `orderdetails`
--



-- --------------------------------------------------------

--
-- Cấu trúc bảng cho bảng `orders`
--

CREATE TABLE `orders` (
  `orderId` int(11) NOT NULL,
  `orderPrice` decimal(12,2) NOT NULL,
  `orderStatus` tinyint(4) NOT NULL DEFAULT 1,
  `orderQuantity` int(11) NOT NULL,
  `orderPaymentStatus` tinyint(4) NOT NULL DEFAULT 1,
  `orderPaymentMethod` tinyint(4) NOT NULL DEFAULT 1,
  `orderCity` int(11) NOT NULL,
  `orderDistrict` int(11) NOT NULL,
  `create_at` datetime NOT NULL,
  `discountId` int(11) DEFAULT NULL,
  `userId` int(11) NOT NULL,
  `orderWard` int(11) NOT NULL,
  `orderAddress` varchar(255) NOT NULL,
  `orderMethod` int(11) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

--
-- Đang đổ dữ liệu cho bảng `orders`
--


-- --------------------------------------------------------

--
-- Cấu trúc bảng cho bảng `productlines`
--

CREATE TABLE `productlines` (
  `productLineId` int(11) NOT NULL,
  `productLineName` varchar(255) DEFAULT NULL,
  `productLineDescription` varchar(255) DEFAULT NULL,
  `productLineStatus` tinyint(4) DEFAULT NULL,
  `create_at` datetime DEFAULT NULL,
  `categoryId` int(11) DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

--
-- Đang đổ dữ liệu cho bảng `productlines`
--

INSERT INTO `productlines` (`productLineId`, `productLineName`, `productLineDescription`, `productLineStatus`, `create_at`, `categoryId`) VALUES
(1, 'iPhone 16', 'Iphone 16 series new ', 1, '2025-02-18 09:48:13', 1),
(2, 'Macbook Pro', 'macbook pro - đãn đầu xu thế', 1, '2025-02-18 09:14:41', 2),
(3, 'iPhone 15', 'Iphone 15 series new ', 1, '2025-02-18 09:36:42', 1),
(4, 'iPhone 14', 'Iphone 14 series new ', 1, '2025-02-18 09:48:28', 1),
(5, 'Macbook Air', 'macbook air- đãn đầu xu thế', 1, '2025-02-18 09:37:12', 2),
(6, 'iMac', 'iMac product', 1, '2025-02-18 09:37:29', 2),
(7, 'iPhone 13', 'Iphone 13 series new ', 1, '2025-02-18 09:48:32', 1),
(8, 'iPhone 12', 'Iphone 12 series new ', 1, '2025-02-18 09:38:01', 1),
(9, 'iPhone 11', 'Iphone 13 series new ', 1, '2025-02-18 09:48:37', 1),
(10, 'Mac mini', 'mac mini product', 1, '2025-02-18 09:38:35', 2),
(11, 'Ipad Pro', 'Ipad pro series new ', 1, '2025-02-18 09:39:04', 3),
(12, 'iPad Air', 'Ipad air series new ', 1, '2025-02-18 09:39:23', 3),
(13, 'iPad Gen', 'Ipad gen series new ', 1, '2025-02-18 09:39:40', 3),
(14, 'Apple Watch Series 10', 'apple watch series 10 product', 1, '2025-02-18 09:40:28', 4),
(15, 'Apple Watch Series 9', 'apple watch series 9 product', 1, '2025-02-18 09:40:48', 4),
(16, 'Apple Watch SE', 'apple watch se product', 1, '2025-02-18 09:41:20', 4),
(17, 'Apple Watch Ultra', 'apple watch ultra product', 1, '2025-02-18 09:41:42', 4),
(18, 'Tai nghe', 'tai nghe apple', 1, '2025-02-18 09:42:00', 5),
(19, 'Loa', 'Loa ', 1, '2025-02-18 09:42:09', 5),
(20, 'Phụ kiện iPhone', ' phụ kiện iphone', 1, '2025-02-18 09:42:59', 6),
(21, 'Phụ kiện iPad', 'phụ kiện ipad', 1, '2025-02-18 09:43:21', 6),
(22, 'Bàn phím', 'bàn phím', 1, '2025-02-18 09:43:33', 6),
(23, 'Chuột', 'mouse', 1, '2025-02-18 09:43:44', 6),
(24, 'AirTag', 'AirTag', 1, '2025-02-18 09:44:01', 6),
(25, 'Ốp lưng iphone', 'Ốp lưng iphone', 1, '2025-02-18 09:44:33', 6),
(26, 'iPad Mini', 'iadvneve', 1, '2025-02-25 02:39:38', 3);

-- --------------------------------------------------------

--
-- Cấu trúc bảng cho bảng `productorders`
--

CREATE TABLE `productorders` (
  `productOrderId` int(11) NOT NULL,
  `productOrderPrice` decimal(12,2) NOT NULL,
  `productOrderImage` varchar(255) NOT NULL,
  `productOrderDescription` varchar(255) NOT NULL,
  `orderDetailId` int(11) NOT NULL,
  `productVariantId` int(11) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

--
-- Đang đổ dữ liệu cho bảng `productorders`
--
-- --------------------------------------------------------

--
-- Cấu trúc bảng cho bảng `products`
--

CREATE TABLE `products` (
  `productId` int(11) NOT NULL,
  `productName` varchar(255) DEFAULT NULL,
  `productLineId` int(11) DEFAULT NULL,
  `categoryId` int(11) DEFAULT NULL,
  `productStatus` tinyint(4) NOT NULL DEFAULT 1,
  `create_at` datetime DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

--
-- Đang đổ dữ liệu cho bảng `products`
--


--
-- Cấu trúc bảng cho bảng `productvariantattributes`
--

CREATE TABLE `productvariantattributes` (
  `productVariantAttributeId` int(11) NOT NULL,
  `productVariantId` int(11) NOT NULL,
  `attributeId` int(11) DEFAULT NULL,
  `attributeValue` varchar(255) DEFAULT NULL,
  `create_at` datetime DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

--
-- Đang đổ dữ liệu cho bảng `productvariantattributes`
--

-- --------------------------------------------------------

--
-- Cấu trúc bảng cho bảng `productvariants`
--

CREATE TABLE `productvariants` (
  `productVariantId` int(11) NOT NULL,
  `productId` int(11) DEFAULT NULL,
  `productVariantImage` varchar(255) CHARACTER SET utf8mb4 COLLATE utf8mb4_unicode_ci DEFAULT NULL,
  `price` decimal(10,2) DEFAULT NULL,
  `create_at` datetime DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

--
-- Đang đổ dữ liệu cho bảng `productvariants`
--


-- --------------------------------------------------------

--
-- Cấu trúc bảng cho bảng `sliders`
--

CREATE TABLE `sliders` (
  `sliderId` int(11) NOT NULL,
  `sliderTitle` varchar(255) NOT NULL,
  `sliderImage` varchar(255) NOT NULL,
  `sliderDescription` varchar(255) DEFAULT NULL,
  `sliderStatus` tinyint(1) DEFAULT 1,
  `createdAt` timestamp NOT NULL DEFAULT current_timestamp(),
  `categoryId` int(11) DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

--
-- Đang đổ dữ liệu cho bảng `sliders`
--

INSERT INTO `sliders` (`sliderId`, `sliderTitle`, `sliderImage`, `sliderDescription`, `sliderStatus`, `createdAt`, `categoryId`) VALUES
(1, 'Khuyến mãi sinh viên', 'SLD_03042025_2c1097cce0b2f265ecd30607d37081db.png', 'Xả kho phụ kiện cho quý khách hàng thân thiết', 1, '2025-04-03 17:05:22', 1),
(2, 'Khuyến mãi sinh viên', 'SLD_03042025_ea317eb4317b0e6b3f9fac9084b78bfb.png', 'Xả kho phụ kiện cho quý khách hàng thân thiết', 1, '2025-04-03 17:05:49', 1),
(3, 'Khuyến mãi sinh viên', 'SLD_03042025_slide4.jpg', 'Khuyến mãi chào năm học mới cho sinh viên ', 1, '2025-04-03 17:06:10', 1),
(4, 'Khuyến mãi sinh viên', 'SLD_03042025_947e8730985abfcf185dfa27282f26af.png', 'Xả kho phụ kiện cho quý khách hàng thân thiết', 1, '2025-04-03 17:06:22', 2),
(5, 'Khuyến mãi điện thoại', 'SLD_03042025_ff45964133097d580e6b28ad6bcff197.png', 'Xả kho phụ kiện cho quý khách hàng thân thiết', 1, '2025-04-03 17:06:39', 2),
(6, 'iPhone 16 mới ra', 'SLD_03042025_21d42d1dd02ec3581bf1d41df6125a2e.png', 'Khuyến mãi chào năm học mới cho sinh viên ', 1, '2025-04-03 17:06:55', 3),
(7, 'Khuyến mãi điện thoại', 'SLD_03042025_62aa321e8c5e81c35bddfdc4197f4e43.png', 'Xả kho phụ kiện cho quý khách hàng thân thiết', 1, '2025-04-03 17:07:10', 3),
(8, 'Khuyến mãi điện thoại', 'SLD_03042025_ffbbda27994bc387e2b1929202e03673.png', 'Xả kho phụ kiện cho quý khách hàng thân thiết', 1, '2025-04-03 17:07:36', 4),
(9, 'Khuyến mãi sinh viêngdgdbngn fng', 'SLD_03042025_slide3.jpg', 'iPhone 16 mới ra mắtgfngfnfsngf', 1, '2025-04-03 17:07:47', 4),
(10, 'Khuyến mãi điện thoại', 'SLD_03042025_fcbc3c481a372481616e5ff3f94d0ba9.png', 'Khuyến mãi chào năm học mới cho sinh viên ', 1, '2025-04-03 17:08:13', 5),
(11, 'Khuyến mãi điện thoại', 'SLD_03042025_f0ac07e4e1019b970bfff7ca6619a542.png', 'Khuyến mãi chào năm học mới cho sinh viên ', 1, '2025-04-03 17:08:26', 5),
(12, 'Khuyến mãi điện thoại', 'SLD_03042025_3b560957877caec3af32001497ca106c.png', 'Xả kho phụ kiện cho quý khách hàng thân thiết', 1, '2025-04-03 17:08:41', 6),
(13, 'iPhone 16 mới ra', 'SLD_03042025_d8b968389198c9ff1a912a45cb126c19.png', 'iPhone 16 mới ra mắtgfngfnfsngf', 1, '2025-04-03 17:08:58', 6);

-- --------------------------------------------------------

--
-- Cấu trúc bảng cho bảng `users`
--

CREATE TABLE `users` (
  `userId` int(11) NOT NULL,
  `userName` varchar(255) DEFAULT NULL,
  `userEmail` varchar(255) DEFAULT NULL,
  `userPhone` varchar(15) DEFAULT NULL,
  `userAddress` varchar(255) DEFAULT NULL,
  `userCity` int(11) DEFAULT NULL,
  `userDistrict` int(11) DEFAULT NULL,
  `userWard` int(11) DEFAULT NULL,
  `userPassword` varchar(255) DEFAULT NULL,
  `userRole` tinyint(4) DEFAULT NULL,
  `create_at` datetime DEFAULT NULL,
  `userImage` varchar(255) DEFAULT NULL,
  `userStatus` tinyint(1) NOT NULL DEFAULT 1
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

--
-- Đang đổ dữ liệu cho bảng `users`
--

INSERT INTO `users` (`userId`, `userName`, `userEmail`, `userPhone`, `userAddress`, `userCity`, `userDistrict`, `userWard`, `userPassword`, `userRole`, `create_at`, `userImage`, `userStatus`) VALUES
(1, 'Hội Người Già', 'admin123@gmail.com', '0123456789', '273 Đ.An Dương Vương', 79, 774, 27307, '$2y$10$e.IEpvj7A7dzyNktWX9CIezqqgZVihkxSOnBNOtlBWrV.J71gij3S', 4, '2025-02-17 19:56:26', 'IMG_20250410191047.jpg', 1),
(2, 'Hoàng Hoàn', 'hoandua@gmail.com', '0123456789', 'Xóm 4', 40, 421, 17155, '$2y$10$UfsC1RMBtkfzMuhzYVbz2uFMO6WXRlRz/RIEJLfWonaT8aj/L/tUG', 1, '2025-02-17 20:01:18', 'IMG_20250410180701.png', 1);

--
-- Chỉ mục cho các bảng đã đổ
--

--
-- Chỉ mục cho bảng `attributes`
--
ALTER TABLE `attributes`
  ADD PRIMARY KEY (`attributeId`);

--
-- Chỉ mục cho bảng `blogs`
--
ALTER TABLE `blogs`
  ADD PRIMARY KEY (`blogId`);

--
-- Chỉ mục cho bảng `categories`
--
ALTER TABLE `categories`
  ADD PRIMARY KEY (`categoryId`);

--
-- Chỉ mục cho bảng `discounts`
--
ALTER TABLE `discounts`
  ADD PRIMARY KEY (`discountId`);

--
-- Chỉ mục cho bảng `orderdetails`
--
ALTER TABLE `orderdetails`
  ADD PRIMARY KEY (`orderDetailId`),
  ADD KEY `orderId` (`orderId`);

--
-- Chỉ mục cho bảng `orders`
--
ALTER TABLE `orders`
  ADD PRIMARY KEY (`orderId`),
  ADD KEY `discountId` (`discountId`),
  ADD KEY `userId` (`userId`);

--
-- Chỉ mục cho bảng `productlines`
--
ALTER TABLE `productlines`
  ADD PRIMARY KEY (`productLineId`);

--
-- Chỉ mục cho bảng `productorders`
--
ALTER TABLE `productorders`
  ADD PRIMARY KEY (`productOrderId`),
  ADD KEY `orderDetailId` (`orderDetailId`),
  ADD KEY `fk_productOrders_productVariants` (`productVariantId`);

--
-- Chỉ mục cho bảng `products`
--
ALTER TABLE `products`
  ADD PRIMARY KEY (`productId`);

--
-- Chỉ mục cho bảng `productvariantattributes`
--
ALTER TABLE `productvariantattributes`
  ADD PRIMARY KEY (`productVariantAttributeId`),
  ADD KEY `fk_productvariantattributes_variant` (`productVariantId`);

--
-- Chỉ mục cho bảng `productvariants`
--
ALTER TABLE `productvariants`
  ADD PRIMARY KEY (`productVariantId`),
  ADD KEY `fk_productvariants_product` (`productId`);

--
-- Chỉ mục cho bảng `sliders`
--
ALTER TABLE `sliders`
  ADD PRIMARY KEY (`sliderId`),
  ADD KEY `fk_slider_category` (`categoryId`);

--
-- Chỉ mục cho bảng `users`
--
ALTER TABLE `users`
  ADD PRIMARY KEY (`userId`);

--
-- AUTO_INCREMENT cho các bảng đã đổ
--

--
-- AUTO_INCREMENT cho bảng `attributes`
--
ALTER TABLE `attributes`
  MODIFY `attributeId` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=10;

--
-- AUTO_INCREMENT cho bảng `blogs`
--
ALTER TABLE `blogs`
  MODIFY `blogId` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=2;

--
-- AUTO_INCREMENT cho bảng `categories`
--
ALTER TABLE `categories`
  MODIFY `categoryId` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=7;

--
-- AUTO_INCREMENT cho bảng `discounts`
--
ALTER TABLE `discounts`
  MODIFY `discountId` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=12;

--
-- AUTO_INCREMENT cho bảng `orderdetails`
--
ALTER TABLE `orderdetails`
  MODIFY `orderDetailId` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=31;

--
-- AUTO_INCREMENT cho bảng `orders`
--
ALTER TABLE `orders`
  MODIFY `orderId` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=51;

--
-- AUTO_INCREMENT cho bảng `productlines`
--
ALTER TABLE `productlines`
  MODIFY `productLineId` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=27;

--
-- AUTO_INCREMENT cho bảng `productorders`
--
ALTER TABLE `productorders`
  MODIFY `productOrderId` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=27;

--
-- AUTO_INCREMENT cho bảng `products`
--
ALTER TABLE `products`
  MODIFY `productId` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=40;

--
-- AUTO_INCREMENT cho bảng `productvariantattributes`
--
ALTER TABLE `productvariantattributes`
  MODIFY `productVariantAttributeId` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=1207;

--
-- AUTO_INCREMENT cho bảng `productvariants`
--
ALTER TABLE `productvariants`
  MODIFY `productVariantId` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=143;

--
-- AUTO_INCREMENT cho bảng `sliders`
--
ALTER TABLE `sliders`
  MODIFY `sliderId` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=15;

--
-- AUTO_INCREMENT cho bảng `users`
--
ALTER TABLE `users`
  MODIFY `userId` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=3;

--
-- Các ràng buộc cho các bảng đã đổ
--

--
-- Các ràng buộc cho bảng `productorders`
--
ALTER TABLE `productorders`
  ADD CONSTRAINT `fk_productOrders_productVariants` FOREIGN KEY (`productVariantId`) REFERENCES `productvariants` (`productVariantId`);
COMMIT;

/*!40101 SET CHARACTER_SET_CLIENT=@OLD_CHARACTER_SET_CLIENT */;
/*!40101 SET CHARACTER_SET_RESULTS=@OLD_CHARACTER_SET_RESULTS */;
/*!40101 SET COLLATION_CONNECTION=@OLD_COLLATION_CONNECTION */;
