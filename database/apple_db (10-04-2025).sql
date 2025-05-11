-- phpMyAdmin SQL Dump
-- version 5.2.1
-- https://www.phpmyadmin.net/
--
-- Host: 127.0.0.1
-- Generation Time: Apr 10, 2025 at 06:52 AM
-- Server version: 10.4.32-MariaDB
-- PHP Version: 8.2.12

SET SQL_MODE = "NO_AUTO_VALUE_ON_ZERO";
START TRANSACTION;
SET time_zone = "+00:00";


/*!40101 SET @OLD_CHARACTER_SET_CLIENT=@@CHARACTER_SET_CLIENT */;
/*!40101 SET @OLD_CHARACTER_SET_RESULTS=@@CHARACTER_SET_RESULTS */;
/*!40101 SET @OLD_COLLATION_CONNECTION=@@COLLATION_CONNECTION */;
/*!40101 SET NAMES utf8mb4 */;

--
-- Database: `apple_db`
--

-- --------------------------------------------------------

--
-- Table structure for table `attributes`
--

CREATE TABLE `attributes` (
  `attributeId` int(11) NOT NULL,
  `attributeName` varchar(255) DEFAULT NULL,
  `attributeStatus` tinyint(4) DEFAULT 1,
  `create_at` datetime DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

--
-- Dumping data for table `attributes`
--

INSERT INTO `attributes` (`attributeId`, `attributeName`, `attributeStatus`, `create_at`) VALUES
(2, 'Màu', 1, '2025-02-18 09:55:02'),
(3, 'Dung lượng', 1, '2025-02-18 09:55:12'),
(4, 'Giá gốc', 1, '2025-02-18 09:55:33'),
(6, 'Ảnh phụ', 1, '2025-02-18 09:55:46');

-- --------------------------------------------------------

--
-- Table structure for table `blogs`
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
-- Dumping data for table `blogs`
--

INSERT INTO `blogs` (`blogId`, `blogTitle`, `blogSlug`, `blogImage`, `blogDescription`, `blogContent`, `create_at`, `blogStatus`, `categoryId`) VALUES
(1, 'Chào năm mới', 'chao-nam-moi-72', 'BLOG_18022025041750.jpg', 'Dienjdwroegeatrthrthrth', 'erthrthhhhhhhhhhhhhhhhhhhhhhhhhhhhhhhhhhhhhhhh', '2025-02-18 10:17:50', 1, 1);

-- --------------------------------------------------------

--
-- Table structure for table `categories`
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
-- Dumping data for table `categories`
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
-- Table structure for table `discounts`
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
-- Dumping data for table `discounts`
--

INSERT INTO `discounts` (`discountId`, `discountName`, `discountPercentage`, `discountSlug`, `discountDescription`, `discountStartDate`, `discountEndDate`, `create_at`) VALUES
(7, 'Giảm giá mùa hè', 20.00, 'giam-gia-mua-he', 'Giảm giá 20% cho tất cả sản phẩm trong mùa hè.', '2025-05-01 00:00:00', '2025-08-31 23:59:59', NULL),
(8, 'Khuyến mãi Tết Nguyên Đán', 15.00, 'khuyen-mai-tet', 'Giảm giá 15% cho sản phẩm thực phẩm trong dịp Tết.', '2025-01-01 00:00:00', '2025-01-31 23:59:59', NULL),
(9, 'Giảm giá sinh nhật', 10.00, 'giam-gia-sinh-nhat', 'Giảm giá 10% cho tất cả đơn hàng trong tháng sinh nhật.', '2025-03-01 00:00:00', '2025-03-31 23:59:59', NULL),
(10, 'Mua 1 tặng 1', 50.00, 'mua-1-tang-1', 'Mua 1 sản phẩm, tặng 1 sản phẩm cùng loại.', '2025-07-01 00:00:00', '2025-07-31 23:59:59', NULL),
(11, 'Giảm giá Black Friday', 50.00, 'giam-gia-black-friday', 'Giảm giá 50% cho tất cả sản phẩm vào ngày Black Friday.', '2025-11-25 00:00:00', '2025-11-26 23:59:59', NULL);

-- --------------------------------------------------------

--
-- Table structure for table `orderdetails`
--

CREATE TABLE `orderdetails` (
  `orderDetailId` int(11) NOT NULL,
  `orderDetailQuantity` int(11) NOT NULL,
  `orderDetailPrice` decimal(12,2) NOT NULL,
  `orderId` int(11) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

--
-- Dumping data for table `orderdetails`
--

INSERT INTO `orderdetails` (`orderDetailId`, `orderDetailQuantity`, `orderDetailPrice`, `orderId`) VALUES
(14, 1, 17880000.00, 43),
(15, 1, 28990000.00, 43),
(16, 1, 28990000.00, 44),
(17, 1, 17880000.00, 44),
(18, 1, 23990000.00, 44),
(19, 1, 23990000.00, 45),
(20, 1, 28990000.00, 45),
(21, 1, 17880000.00, 46),
(22, 3, 17880000.00, 47),
(23, 4, 28990000.00, 47),
(24, 1, 17880000.00, 48),
(25, 1, 32320000.00, 48),
(26, 1, 17880000.00, 49),
(27, 1, 28990000.00, 49),
(28, 1, 12345123.00, 49),
(29, 2, 23990000.00, 50),
(30, 1, 28990000.00, 50);

-- --------------------------------------------------------

--
-- Table structure for table `orders`
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
-- Dumping data for table `orders`
--

INSERT INTO `orders` (`orderId`, `orderPrice`, `orderStatus`, `orderQuantity`, `orderPaymentStatus`, `orderPaymentMethod`, `orderCity`, `orderDistrict`, `create_at`, `discountId`, `userId`, `orderWard`, `orderAddress`, `orderMethod`) VALUES
(43, 46870000.00, 0, 2, 0, 1, 0, 0, '2025-04-07 17:48:33', 8, 2, 0, '0', 1),
(44, 70860000.00, 1, 3, 2, 2, 0, 0, '2025-04-08 06:47:54', 9, 2, 0, '0', 1),
(45, 52980000.00, 1, 2, 2, 3, 0, 0, '2025-04-08 06:51:02', 10, 2, 0, '0', 1),
(46, 17880000.00, 1, 1, 2, 2, 17, 157, '2025-04-08 13:20:07', 10, 2, 5305, '13 đường 25 A', 1),
(47, 169600000.00, 1, 7, 2, 2, 17, 155, '2025-04-08 13:32:37', 8, 2, 5176, '13 đường Âu Cơ', 1),
(48, 50200000.00, 1, 2, 2, 2, 17, 155, '2025-04-09 19:14:55', 10, 2, 5176, '13 đường Âu Cơ', 1),
(49, 59215123.00, 1, 3, 2, 3, 17, 155, '2025-04-10 06:27:06', 8, 2, 5176, '13 đường Âu Cơ', 1),
(50, 76970000.00, 1, 3, 1, 1, 20, 188, '2025-04-10 06:28:01', 8, 2, 6595, 'Cửa hàng 7 - 23 Lê Thánh Tôn', 2);

-- --------------------------------------------------------

--
-- Table structure for table `productlines`
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
-- Dumping data for table `productlines`
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
-- Table structure for table `productorders`
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
-- Dumping data for table `productorders`
--

INSERT INTO `productorders` (`productOrderId`, `productOrderPrice`, `productOrderImage`, `productOrderDescription`, `orderDetailId`, `productVariantId`) VALUES
(10, 17880000.00, './images/iPhone/iPhone16/iphone-16-plus-pink-1t-18980000.png', 'no note', 14, 8),
(11, 28990000.00, './images/iPhone/iPhone16/iphone-16-plus-blue-128gb-34990000.png', 'no note', 15, 8),
(12, 28990000.00, './images/iPhone/iPhone16/iphone-16-plus-blue-128gb-34990000.png', 'no note', 16, 8),
(13, 17880000.00, './images/iPhone/iPhone16/iphone-16-plus-pink-1t-18980000.png', 'no note', 17, 8),
(14, 23990000.00, './images/iPhone/iPhone16/iphone-16-plus-black-64gb-24990000.png', 'no note', 18, 8),
(15, 23990000.00, './images/iPhone/iPhone16/iphone-16-plus-black-64gb-24990000.png', 'no note', 19, 8),
(16, 28990000.00, './images/iPhone/iPhone16/iphone-16-plus-blue-128gb-34990000.png', 'no note', 20, 8),
(17, 17880000.00, './images/iPhone/iPhone16/iphone-16-plus-pink-1t-18980000.png', 'no note', 21, 8),
(18, 17880000.00, './images/iPhone/iPhone16/iphone-16-plus-pink-1t-18980000.png', 'no note', 22, 8),
(19, 28990000.00, './images/iPhone/iPhone16/iphone-16-plus-blue-128gb-34990000.png', 'no note', 23, 8),
(20, 17880000.00, './images/iPhone/iPhone16/iphone-16-plus-pink-1t-18980000.png', 'no note', 24, 65),
(21, 32320000.00, './images/iPhone/iPhone16/iphone-16-pro-white-1t-33330000.png', 'no note', 25, 71),
(22, 17880000.00, './images/iPhone/iPhone16/iphone-16-plus-pink-1t-18980000.png', 'no note', 26, 65),
(23, 28990000.00, './images/iPhone/iPhone16/iphone-16-plus-blue-128gb-34990000.png', 'no note', 27, 61),
(24, 12345123.00, './images/iPhone/iPhone14/iphone-14-pro-max-purple-256gb-13423234.png', 'no note', 28, 136),
(25, 23990000.00, './images/iPhone/iPhone16/iphone-16-plus-black-64gb-24990000.png', 'no note', 29, 58),
(26, 28990000.00, './images/iPhone/iPhone16/iphone-16-plus-blue-128gb-34990000.png', 'no note', 30, 61);

-- --------------------------------------------------------

--
-- Table structure for table `products`
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
-- Dumping data for table `products`
--

INSERT INTO `products` (`productId`, `productName`, `productLineId`, `categoryId`, `productStatus`, `create_at`) VALUES
(9, 'Iphone 14 ', 4, 1, 1, '2025-02-25 02:09:57'),
(11, 'Iphone 14 Pro Max', 4, 1, 1, '2025-02-25 02:25:42'),
(12, 'Iphone 14 Plus', 4, 1, 1, '2025-02-25 02:26:28'),
(13, 'Iphone 15 ', 3, 1, 1, '2025-02-25 02:27:03'),
(14, 'Iphone 15 Pro', 3, 1, 1, '2025-02-25 02:27:12'),
(15, 'Iphone 15 Pro Max', 3, 1, 1, '2025-02-25 02:27:19'),
(16, 'Iphone 15 Plus', 3, 1, 1, '2025-02-25 02:27:31'),
(17, 'Iphone 16 Pro Max', 1, 1, 1, '2025-02-25 02:27:46'),
(18, 'Iphone 16', 1, 1, 1, '2025-02-25 02:27:56'),
(19, 'Iphone 16 Plus', 1, 1, 1, '2025-02-25 02:28:13'),
(20, 'Iphone 16 Pro ', 1, 1, 1, '2025-02-25 02:28:29'),
(21, 'Macbook Pro 14 inch M4', 2, 2, 1, '2025-02-25 02:29:27'),
(22, 'Macbook Pro 16 inch M4', 2, 2, 1, '2025-02-25 02:29:48'),
(23, 'Macbook Air 13 inch M1', 5, 2, 1, '2025-02-25 02:30:40'),
(24, 'Macbook Air 13 inch M2', 5, 2, 1, '2025-02-25 02:31:03'),
(25, 'Macbook Air 13 inch M3', 5, 2, 1, '2025-02-25 02:31:16'),
(26, 'Macbook Air 15 inch M3', 5, 2, 1, '2025-02-25 02:31:42'),
(27, 'iMac 24 inch M4', 6, 2, 1, '2025-02-25 02:32:37'),
(28, 'Mac mini M4 Pro', 10, 2, 1, '2025-02-25 02:33:16'),
(29, 'Mac mini M4', 10, 2, 1, '2025-02-25 02:33:34'),
(30, 'Ipad Pro M4 11 inch', 11, 3, 1, '2025-02-25 02:34:35'),
(31, 'Ipad Pro M4 13 inch', 11, 3, 1, '2025-02-25 02:34:58'),
(32, 'Ipad Air M2 11 inch', 12, 3, 1, '2025-02-25 02:35:46'),
(33, 'Ipad Air M2 13 inch', 12, 3, 1, '2025-02-25 02:36:08'),
(34, 'Ipad 10', 13, 3, 1, '2025-02-25 02:37:57'),
(35, 'Ipad Mini 7', 26, 3, 1, '2025-02-25 02:38:56'),
(36, 'Apple Watch SE 2', 16, 4, 1, '2025-04-03 14:13:09'),
(37, 'Apple Watch Series 10 GPS', 14, 4, 1, '2025-04-03 14:19:11'),
(38, 'Apple Watch Ultra 2 GPS', 17, 4, 1, '2025-04-03 14:22:34'),
(39, 'Apple Watch Series 9 GPS', 15, 4, 1, '2025-04-03 22:39:49');

-- --------------------------------------------------------

--
-- Table structure for table `productvariantattributes`
--

CREATE TABLE `productvariantattributes` (
  `productVariantAttributeId` int(11) NOT NULL,
  `productVariantId` int(11) NOT NULL,
  `attributeId` int(11) DEFAULT NULL,
  `attributeValue` varchar(255) DEFAULT NULL,
  `create_at` datetime DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

--
-- Dumping data for table `productvariantattributes`
--

INSERT INTO `productvariantattributes` (`productVariantAttributeId`, `productVariantId`, `attributeId`, `attributeValue`, `create_at`) VALUES
(1, 0, 2, 'White', '2025-04-04 15:58:08'),
(24, 8, 2, 'White', '2025-02-25 02:13:18'),
(25, 8, 3, '128GB', '2025-02-25 02:13:18'),
(26, 8, 4, '14798000', '2025-02-25 02:13:18'),
(27, 8, 6, 'iPhone/iPhone14/iphone14-iphone-20250405-053051-sub0.jpg', '2025-02-25 02:13:18'),
(28, 8, 6, 'iPhone/iPhone14/iphone14-iphone-20250405-053051-sub1.jpg', '2025-02-25 02:13:18'),
(29, 8, 6, 'iPhone/iPhone14/iphone14-iphone-20250405-053051-sub2.jpg', '2025-02-25 02:13:18'),
(30, 8, 6, 'iPhone/iPhone14/iphone14-iphone-20250405-053051-sub3.jpg', '2025-02-25 02:13:18'),
(31, 8, 6, 'iPhone/iPhone14/iphone14-iphone-20250405-053051-sub4.jpg', '2025-02-25 02:13:18'),
(32, 8, 6, 'iPhone/iPhone14/iphone14-iphone-20250405-053051-sub5.jpg', '2025-02-25 02:13:18'),
(33, 8, 6, 'iPhone/iPhone14/iphone14-iphone-20250405-053051-sub6.jpg', '2025-02-25 02:13:18'),
(34, 9, 2, 'White', '2025-02-25 02:15:33'),
(35, 9, 3, '256GB', '2025-02-25 02:15:33'),
(36, 9, 4, '2124214214', '2025-02-25 02:15:33'),
(37, 9, 6, 'iPhone/iPhone14/iphone 14 -1.jpg', '2025-02-25 02:15:33'),
(38, 9, 6, 'iPhone/iPhone14/iphone 14 -2.jpg', '2025-02-25 02:15:33'),
(39, 9, 6, 'iPhone/iPhone14/iphone 14 -3.jpg', '2025-02-25 02:15:33'),
(40, 9, 6, 'iPhone/iPhone14/iphone 14 -4.jpg', '2025-02-25 02:15:33'),
(41, 9, 6, 'iPhone/iPhone14/iphone 14 -5.jpg', '2025-02-25 02:15:33'),
(42, 9, 6, 'iPhone/iPhone14/iphone 14 -6.jpg', '2025-02-25 02:15:33'),
(43, 9, 6, 'iPhone/iPhone14/iphone 14 -7.jpg', '2025-02-25 02:15:33'),
(44, 10, 2, 'White', '2025-02-25 02:18:25'),
(45, 10, 3, '512GB', '2025-02-25 02:18:25'),
(46, 10, 4, '214241211', '2025-02-25 02:18:25'),
(47, 10, 6, 'iPhone/iPhone14/iphone 14 -1.jpg', '2025-02-25 02:18:25'),
(48, 10, 6, 'iPhone/iPhone14/iphone 14 -2.jpg', '2025-02-25 02:18:25'),
(49, 10, 6, 'iPhone/iPhone14/iphone 14 -3.jpg', '2025-02-25 02:18:25'),
(50, 10, 6, 'iPhone/iPhone14/iphone 14 -4.jpg', '2025-02-25 02:18:25'),
(51, 10, 6, 'iPhone/iPhone14/iphone 14 -5.jpg', '2025-02-25 02:18:25'),
(52, 10, 6, 'iPhone/iPhone14/iphone 14 -6.jpg', '2025-02-25 02:18:25'),
(53, 10, 6, 'iPhone/iPhone14/iphone 14 -7.jpg', '2025-02-25 02:18:25'),
(54, 11, 2, 'purple', '2025-02-25 02:19:55'),
(55, 11, 3, '512GB', '2025-02-25 02:19:55'),
(56, 11, 4, '17290000', '2025-02-25 02:19:55'),
(57, 11, 6, 'iPhone/iPhone14/iphone-14-purple-512gb-17290000-1.jpg', '2025-02-25 02:19:55'),
(58, 11, 6, 'iPhone/iPhone14/iphone-14-purple-512gb-17290000-2.jpg', '2025-02-25 02:19:55'),
(59, 11, 6, 'iPhone/iPhone14/iphone-14-purple-512gb-17290000-3.jpg', '2025-02-25 02:19:55'),
(60, 11, 6, 'iPhone/iPhone14/iphone-14-purple-512gb-17290000-4.jpg', '2025-02-25 02:19:55'),
(61, 11, 6, 'iPhone/iPhone14/iphone-14-purple-512gb-17290000-5.jpg', '2025-02-25 02:19:55'),
(62, 11, 6, 'iPhone/iPhone14/iphone-14-purple-512gb-17290000-6.jpg', '2025-02-25 02:19:55'),
(63, 11, 6, 'iPhone/iPhone14/iphone-14-purple-512gb-17290000-7.jpg', '2025-02-25 02:19:55'),
(64, 12, 2, 'Trắng', '2025-02-25 02:23:53'),
(65, 12, 3, '128GB', '2025-02-25 02:23:53'),
(66, 12, 4, '17290000', '2025-02-25 02:23:53'),
(67, 12, 6, 'iPhone/iPhone14/iphone-14-trng-128gb-17290000-1.jpg', '2025-02-25 02:23:53'),
(68, 12, 6, 'iPhone/iPhone14/iphone-14-trng-128gb-17290000-2.jpg', '2025-02-25 02:23:53'),
(69, 12, 6, 'iPhone/iPhone14/iphone-14-trng-128gb-17290000-3.jpg', '2025-02-25 02:23:53'),
(70, 12, 6, 'iPhone/iPhone14/iphone-14-trng-128gb-17290000-4.jpg', '2025-02-25 02:23:53'),
(71, 12, 6, 'iPhone/iPhone14/iphone-14-trng-128gb-17290000-5.jpg', '2025-02-25 02:23:53'),
(72, 12, 6, 'iPhone/iPhone14/iphone-14-trng-128gb-17290000-6.jpg', '2025-02-25 02:23:53'),
(73, 12, 6, 'iPhone/iPhone14/iphone-14-trng-128gb-17290000-7.jpg', '2025-02-25 02:23:53'),
(74, 13, 2, 'Black', '2025-02-25 02:25:10'),
(75, 13, 3, '512GB', '2025-02-25 02:25:10'),
(76, 13, 4, '23990000', '2025-02-25 02:25:10'),
(77, 13, 6, 'iPhone/iPhone14/iphone-14-trng-256gb-17290000-1.jpg', '2025-02-25 02:25:10'),
(78, 13, 6, 'iPhone/iPhone14/iphone-14-trng-256gb-17290000-2.jpg', '2025-02-25 02:25:10'),
(79, 13, 6, 'iPhone/iPhone14/iphone-14-trng-256gb-17290000-3.jpg', '2025-02-25 02:25:10'),
(80, 13, 6, 'iPhone/iPhone14/iphone-14-trng-256gb-17290000-4.jpg', '2025-02-25 02:25:10'),
(81, 13, 6, 'iPhone/iPhone14/iphone-14-trng-256gb-17290000-5.jpg', '2025-02-25 02:25:10'),
(82, 13, 6, 'iPhone/iPhone14/iphone-14-trng-256gb-17290000-6.jpg', '2025-02-25 02:25:10'),
(83, 13, 6, 'iPhone/iPhone14/iphone-14-trng-256gb-17290000-7.jpg', '2025-02-25 02:25:10'),
(84, 14, 2, 'Purple', '2025-04-01 22:29:06'),
(85, 14, 3, '128GB', '2025-04-01 22:29:06'),
(86, 14, 4, '30990000', '2025-04-01 22:29:06'),
(87, 14, 6, 'iPhone/iPhone14/iphone-14-pro-max-purple-128gb-30990000-1.jpg', '2025-04-01 22:29:06'),
(88, 14, 6, 'iPhone/iPhone14/iphone-14-pro-max-purple-128gb-30990000-2.jpg', '2025-04-01 22:29:06'),
(89, 14, 6, 'iPhone/iPhone14/iphone-14-pro-max-purple-128gb-30990000-3.jpg', '2025-04-01 22:29:06'),
(90, 15, 2, 'Black', '2025-04-01 22:39:50'),
(91, 15, 3, '256GB', '2025-04-01 22:39:50'),
(92, 15, 4, '47000000', '2025-04-01 22:39:50'),
(93, 15, 6, 'iPhone/iPhone14/iphone-14-pro-max-black-256gb-47000000-1.jpg', '2025-04-01 22:39:50'),
(94, 15, 6, 'iPhone/iPhone14/iphone-14-pro-max-black-256gb-47000000-2.jpg', '2025-04-01 22:39:50'),
(95, 16, 2, 'White', '2025-04-01 22:56:06'),
(96, 16, 3, '128GB', '2025-04-01 22:56:06'),
(97, 16, 4, '19990000', '2025-04-01 22:56:06'),
(98, 16, 6, 'iPhone/iPhone14/iphone-14-plus-white-128gb-19990000-1.jpg', '2025-04-01 22:56:06'),
(99, 16, 6, 'iPhone/iPhone14/iphone-14-plus-white-128gb-19990000-2.jpg', '2025-04-01 22:56:06'),
(100, 16, 6, 'iPhone/iPhone14/iphone-14-plus-white-128gb-19990000-3.jpg', '2025-04-01 22:56:06'),
(101, 16, 6, 'iPhone/iPhone14/iphone-14-plus-white-128gb-19990000-4.jpg', '2025-04-01 22:56:06'),
(102, 16, 6, 'iPhone/iPhone14/iphone-14-plus-white-128gb-19990000-5.jpg', '2025-04-01 22:56:06'),
(103, 16, 6, 'iPhone/iPhone14/iphone-14-plus-white-128gb-19990000-6.jpg', '2025-04-01 22:56:06'),
(104, 16, 6, 'iPhone/iPhone14/iphone-14-plus-white-128gb-19990000-7.jpg', '2025-04-01 22:56:06'),
(105, 17, 2, 'Yellow', '2025-04-01 22:58:47'),
(106, 17, 3, '256GB', '2025-04-01 22:58:47'),
(107, 17, 4, '20990000', '2025-04-01 22:58:47'),
(108, 17, 6, 'iPhone/iPhone14/iphone-14-plus-yellow-256gb-20990000-1.jpeg', '2025-04-01 22:58:47'),
(109, 17, 6, 'iPhone/iPhone14/iphone-14-plus-yellow-256gb-20990000-2.jpeg', '2025-04-01 22:58:47'),
(110, 17, 6, 'iPhone/iPhone14/iphone-14-plus-yellow-256gb-20990000-3.jpeg', '2025-04-01 22:58:47'),
(111, 17, 6, 'iPhone/iPhone14/iphone-14-plus-yellow-256gb-20990000-4.jpeg', '2025-04-01 22:58:47'),
(112, 17, 6, 'iPhone/iPhone14/iphone-14-plus-yellow-256gb-20990000-5.jpeg', '2025-04-01 22:58:47'),
(113, 17, 6, 'iPhone/iPhone14/iphone-14-plus-yellow-256gb-20990000-6.jpeg', '2025-04-01 22:58:47'),
(114, 17, 6, 'iPhone/iPhone14/iphone-14-plus-yellow-256gb-20990000-7.jpeg', '2025-04-01 22:58:47'),
(115, 18, 2, 'iPhone/iPhone15/iphone-15--lack-256-213414124-1.jpg', '2025-04-05 00:55:14'),
(116, 18, 3, 'iPhone/iPhone15/iphone-15--lack-256-213414124-2.jpg', '2025-04-05 00:55:14'),
(117, 18, 4, 'iPhone/iPhone15/iphone-15--lack-256-213414124-3.jpg', '2025-04-05 00:55:14'),
(118, 18, 6, 'iPhone/iPhone15/iphone-15--lack-256-213414124-4.jpg', '2025-04-05 00:55:14'),
(119, 18, 6, 'iPhone/iPhone15/iphone-15--lack-256-213414124-5.jpg', '2025-04-05 00:55:14'),
(120, 18, 6, 'iPhone/iPhone15/iphone-15--lack-256-213414124-6.jpg', '2025-04-05 00:55:14'),
(121, 18, 6, 'iPhone/iPhone15/iphone-15--lack-256-213414124-7.jpg', '2025-04-05 00:55:14'),
(122, 18, 6, '', '2025-04-05 00:55:14'),
(123, 18, 6, '', '2025-04-05 00:55:14'),
(124, 18, 6, '', '2025-04-05 00:55:14'),
(125, 19, 2, 'iphone-15-black-1-650x650.jpg', '2025-04-01 23:02:48'),
(126, 19, 3, 'iphone-15-black-2-650x650.jpg', '2025-04-01 23:02:48'),
(127, 19, 4, 'iphone-15-black-3-650x650.jpg', '2025-04-01 23:02:48'),
(128, 19, 6, 'iphone-15-black-4-650x650.jpg', '2025-04-01 23:02:48'),
(129, 19, 6, 'iphone-15-black-5-650x650.jpg', '2025-04-01 23:02:48'),
(130, 19, 6, 'iphone-15-black-6-650x650.jpg', '2025-04-01 23:02:48'),
(131, 19, 6, 'iphone-15-black-5-650x650.jpg', '2025-04-01 23:02:48'),
(132, 19, 6, 'iphone-15-black-9-650x650.jpg', '2025-04-01 23:02:48'),
(133, 19, 6, NULL, '2025-04-01 23:02:48'),
(134, 19, 6, NULL, '2025-04-01 23:02:48'),
(135, 19, 6, NULL, '2025-04-01 23:02:48'),
(136, 20, 2, 'Blue', '2025-04-01 23:04:47'),
(137, 20, 3, '32GB', '2025-04-01 23:04:47'),
(138, 20, 4, '20990000', '2025-04-01 23:04:47'),
(139, 20, 6, 'iPhone/iPhone15/iphone-15-blue-32gb-20990000-1.jpg', '2025-04-01 23:04:47'),
(140, 20, 6, 'iPhone/iPhone15/iphone-15-blue-32gb-20990000-2.jpg', '2025-04-01 23:04:47'),
(141, 20, 6, 'iPhone/iPhone15/iphone-15-blue-32gb-20990000-3.jpg', '2025-04-01 23:04:47'),
(142, 20, 6, 'iPhone/iPhone15/iphone-15-blue-32gb-20990000-4.jpg', '2025-04-01 23:04:47'),
(143, 20, 6, 'iPhone/iPhone15/iphone-15-blue-32gb-20990000-5.jpg', '2025-04-01 23:04:47'),
(144, 20, 6, 'iPhone/iPhone15/iphone-15-blue-32gb-20990000-6.jpg', '2025-04-01 23:04:47'),
(145, 20, 6, 'iPhone/iPhone15/iphone-15-blue-32gb-20990000-7.jpg', '2025-04-01 23:04:47'),
(146, 21, 2, 'Blue', '2025-04-01 23:06:44'),
(147, 21, 3, '512GB', '2025-04-01 23:06:44'),
(148, 21, 4, '23990000', '2025-04-01 23:06:44'),
(149, 21, 6, 'iPhone/iPhone15/iphone-15-blue-512gb-23990000-1.jpg', '2025-04-01 23:06:44'),
(150, 21, 6, 'iPhone/iPhone15/iphone-15-blue-512gb-23990000-2.jpg', '2025-04-01 23:06:44'),
(151, 21, 6, 'iPhone/iPhone15/iphone-15-blue-512gb-23990000-3.jpg', '2025-04-01 23:06:44'),
(152, 21, 6, 'iPhone/iPhone15/iphone-15-blue-512gb-23990000-4.jpg', '2025-04-01 23:06:44'),
(153, 21, 6, 'iPhone/iPhone15/iphone-15-blue-512gb-23990000-5.jpg', '2025-04-01 23:06:44'),
(154, 21, 6, 'iPhone/iPhone15/iphone-15-blue-512gb-23990000-6.jpg', '2025-04-01 23:06:44'),
(155, 21, 6, 'iPhone/iPhone15/iphone-15-blue-512gb-23990000-7.jpg', '2025-04-01 23:06:44'),
(156, 21, 6, 'iPhone/iPhone15/iphone-15-blue-512gb-23990000-8.jpg', '2025-04-01 23:06:44'),
(157, 22, 2, 'Blue', '2025-04-02 22:31:05'),
(158, 22, 3, '128GB', '2025-04-02 22:31:05'),
(159, 22, 4, '23990000', '2025-04-02 22:31:05'),
(160, 22, 6, 'iPhone/iPhone15/iphone-15-pro-blue-128gb-23990000-1.jpg', '2025-04-02 22:31:05'),
(161, 22, 6, 'iPhone/iPhone15/iphone-15-pro-blue-128gb-23990000-2.jpg', '2025-04-02 22:31:05'),
(162, 22, 6, 'iPhone/iPhone15/iphone-15-pro-blue-128gb-23990000-3.jpg', '2025-04-02 22:31:05'),
(163, 22, 6, 'iPhone/iPhone15/iphone-15-pro-blue-128gb-23990000-4.jpg', '2025-04-02 22:31:05'),
(164, 22, 6, 'iPhone/iPhone15/iphone-15-pro-blue-128gb-23990000-5.jpg', '2025-04-02 22:31:05'),
(165, 22, 6, 'iPhone/iPhone15/iphone-15-pro-blue-128gb-23990000-6.jpg', '2025-04-02 22:31:05'),
(166, 22, 6, 'iPhone/iPhone15/iphone-15-pro-blue-128gb-23990000-7.png', '2025-04-02 22:31:05'),
(167, 23, 2, 'Blue', '2025-04-02 22:33:14'),
(168, 23, 3, '256GB', '2025-04-02 22:33:14'),
(169, 23, 4, '38990000', '2025-04-02 22:33:14'),
(170, 23, 6, 'iPhone/iPhone15/iphone-15-pro-blue-256gb-38990000-1.jpg', '2025-04-02 22:33:14'),
(171, 23, 6, 'iPhone/iPhone15/iphone-15-pro-blue-256gb-38990000-2.png', '2025-04-02 22:33:14'),
(172, 23, 6, 'iPhone/iPhone15/iphone-15-pro-blue-256gb-38990000-3.jpg', '2025-04-02 22:33:14'),
(173, 23, 6, 'iPhone/iPhone15/iphone-15-pro-blue-256gb-38990000-4.jpg', '2025-04-02 22:33:14'),
(174, 23, 6, 'iPhone/iPhone15/iphone-15-pro-blue-256gb-38990000-5.jpg', '2025-04-02 22:33:14'),
(175, 23, 6, 'iPhone/iPhone15/iphone-15-pro-blue-256gb-38990000-6.jpg', '2025-04-02 22:33:14'),
(176, 23, 6, 'iPhone/iPhone15/iphone-15-pro-blue-256gb-38990000-7.jpg', '2025-04-02 22:33:14'),
(177, 24, 2, 'Nature', '2025-04-02 22:35:10'),
(178, 24, 3, '128GB', '2025-04-02 22:35:10'),
(179, 24, 4, '27790000', '2025-04-02 22:35:10'),
(180, 24, 6, 'iPhone/iPhone15/iphone-15-pro-nature-128gb-27790000-1.jpg', '2025-04-02 22:35:10'),
(181, 24, 6, 'iPhone/iPhone15/iphone-15-pro-nature-128gb-27790000-2.jpg', '2025-04-02 22:35:10'),
(182, 24, 6, 'iPhone/iPhone15/iphone-15-pro-nature-128gb-27790000-3.jpg', '2025-04-02 22:35:10'),
(183, 24, 6, 'iPhone/iPhone15/iphone-15-pro-nature-128gb-27790000-4.jpg', '2025-04-02 22:35:10'),
(184, 24, 6, 'iPhone/iPhone15/iphone-15-pro-nature-128gb-27790000-5.jpg', '2025-04-02 22:35:10'),
(185, 24, 6, 'iPhone/iPhone15/iphone-15-pro-nature-128gb-27790000-6.jpg', '2025-04-02 22:35:10'),
(186, 24, 6, 'iPhone/iPhone15/iphone-15-pro-nature-128gb-27790000-7.jpg', '2025-04-02 22:35:10'),
(187, 25, 2, 'Nature', '2025-04-02 22:37:29'),
(188, 25, 3, '256GB', '2025-04-02 22:37:29'),
(189, 25, 4, '32890000', '2025-04-02 22:37:29'),
(190, 25, 6, 'iPhone/iPhone15/iphone-15-pro-nature-256gb-32890000-1.jpg', '2025-04-02 22:37:29'),
(191, 25, 6, 'iPhone/iPhone15/iphone-15-pro-nature-256gb-32890000-2.jpg', '2025-04-02 22:37:29'),
(192, 25, 6, 'iPhone/iPhone15/iphone-15-pro-nature-256gb-32890000-3.jpg', '2025-04-02 22:37:29'),
(193, 25, 6, 'iPhone/iPhone15/iphone-15-pro-nature-256gb-32890000-4.jpg', '2025-04-02 22:37:29'),
(194, 25, 6, 'iPhone/iPhone15/iphone-15-pro-nature-256gb-32890000-5.jpg', '2025-04-02 22:37:29'),
(195, 25, 6, 'iPhone/iPhone15/iphone-15-pro-nature-256gb-32890000-6.jpg', '2025-04-02 22:37:29'),
(196, 26, 2, 'White', '2025-04-03 01:57:19'),
(197, 26, 3, '1T', '2025-04-03 01:57:19'),
(198, 26, 4, '27790000', '2025-04-03 01:57:19'),
(199, 26, 6, 'iPhone/iPhone15/iphone-15-pro-white-1t-27790000-1.jpg', '2025-04-03 01:57:19'),
(200, 26, 6, 'iPhone/iPhone15/iphone-15-pro-white-1t-27790000-2.jpg', '2025-04-03 01:57:19'),
(201, 26, 6, 'iPhone/iPhone15/iphone-15-pro-white-1t-27790000-3.jpg', '2025-04-03 01:57:19'),
(202, 26, 6, 'iPhone/iPhone15/iphone-15-pro-white-1t-27790000-4.jpg', '2025-04-03 01:57:19'),
(203, 26, 6, 'iPhone/iPhone15/iphone-15-pro-white-1t-27790000-5.jpg', '2025-04-03 01:57:19'),
(204, 26, 6, 'iPhone/iPhone15/iphone-15-pro-white-1t-27790000-6.jpg', '2025-04-03 01:57:19'),
(205, 26, 6, 'iPhone/iPhone15/iphone-15-pro-white-1t-27790000-7.png', '2025-04-03 01:57:19'),
(206, 27, 2, 'White', '2025-04-03 02:02:13'),
(207, 27, 3, '256GB', '2025-04-03 02:02:13'),
(208, 27, 4, '27790000', '2025-04-03 02:02:13'),
(209, 27, 6, 'iPhone/iPhone15/iphone-15-pro-white-256gb-27790000-1.jpg', '2025-04-03 02:02:13'),
(210, 27, 6, 'iPhone/iPhone15/iphone-15-pro-white-256gb-27790000-2.jpg', '2025-04-03 02:02:13'),
(211, 27, 6, 'iPhone/iPhone15/iphone-15-pro-white-256gb-27790000-3.jpg', '2025-04-03 02:02:13'),
(212, 27, 6, 'iPhone/iPhone15/iphone-15-pro-white-256gb-27790000-4.jpg', '2025-04-03 02:02:13'),
(213, 27, 6, 'iPhone/iPhone15/iphone-15-pro-white-256gb-27790000-5.png', '2025-04-03 02:02:13'),
(214, 28, 2, 'Black', '2025-04-03 02:12:23'),
(215, 28, 3, '64GB', '2025-04-03 02:12:23'),
(216, 28, 4, '21990000', '2025-04-03 02:12:23'),
(217, 28, 6, 'iPhone/iPhone15/iphone-15-pro-max-black-64gb-21990000-1.jpg', '2025-04-03 02:12:23'),
(218, 28, 6, 'iPhone/iPhone15/iphone-15-pro-max-black-64gb-21990000-2.jpg', '2025-04-03 02:12:23'),
(219, 28, 6, 'iPhone/iPhone15/iphone-15-pro-max-black-64gb-21990000-3.jpg', '2025-04-03 02:12:23'),
(220, 28, 6, 'iPhone/iPhone15/iphone-15-pro-max-black-64gb-21990000-4.jpg', '2025-04-03 02:12:23'),
(221, 28, 6, 'iPhone/iPhone15/iphone-15-pro-max-black-64gb-21990000-5.jpg', '2025-04-03 02:12:23'),
(222, 28, 6, 'iPhone/iPhone15/iphone-15-pro-max-black-64gb-21990000-6.jpg', '2025-04-03 02:12:23'),
(223, 28, 6, 'iPhone/iPhone15/iphone-15-pro-max-black-64gb-21990000-7.jpg', '2025-04-03 02:12:23'),
(224, 29, 2, 'Black', '2025-04-03 03:01:50'),
(225, 29, 3, '128GB', '2025-04-03 03:01:50'),
(226, 29, 4, '21990000', '2025-04-03 03:01:50'),
(227, 29, 6, 'iPhone/iPhone15/iphone-15-pro-max-black-128gb-21990000-1.jpg', '2025-04-03 03:01:50'),
(228, 29, 6, 'iPhone/iPhone15/iphone-15-pro-max-black-128gb-21990000-2.jpg', '2025-04-03 03:01:50'),
(229, 29, 6, 'iPhone/iPhone15/iphone-15-pro-max-black-128gb-21990000-3.jpg', '2025-04-03 03:01:50'),
(230, 29, 6, 'iPhone/iPhone15/iphone-15-pro-max-black-128gb-21990000-4.jpg', '2025-04-03 03:01:50'),
(231, 29, 6, 'iPhone/iPhone15/iphone-15-pro-max-black-128gb-21990000-5.jpg', '2025-04-03 03:01:50'),
(232, 29, 6, 'iPhone/iPhone15/iphone-15-pro-max-black-128gb-21990000-6.jpg', '2025-04-03 03:01:50'),
(233, 29, 6, 'iPhone/iPhone15/iphone-15-pro-max-black-128gb-21990000-7.jpg', '2025-04-03 03:01:50'),
(234, 30, 2, 'Blue', '2025-04-03 03:03:25'),
(235, 30, 3, '64GB', '2025-04-03 03:03:25'),
(236, 30, 4, '21990000', '2025-04-03 03:03:25'),
(237, 30, 6, 'iPhone/iPhone15/iphone-15-pro-max-blue-64gb-21990000-1.jpg', '2025-04-03 03:03:25'),
(238, 30, 6, 'iPhone/iPhone15/iphone-15-pro-max-blue-64gb-21990000-2.jpg', '2025-04-03 03:03:25'),
(239, 30, 6, 'iPhone/iPhone15/iphone-15-pro-max-blue-64gb-21990000-3.jpg', '2025-04-03 03:03:25'),
(240, 30, 6, 'iPhone/iPhone15/iphone-15-pro-max-blue-64gb-21990000-4.jpg', '2025-04-03 03:03:25'),
(241, 30, 6, 'iPhone/iPhone15/iphone-15-pro-max-blue-64gb-21990000-5.jpg', '2025-04-03 03:03:25'),
(242, 30, 6, 'iPhone/iPhone15/iphone-15-pro-max-blue-64gb-21990000-6.jpg', '2025-04-03 03:03:25'),
(243, 30, 6, 'iPhone/iPhone15/iphone-15-pro-max-blue-64gb-21990000-7.jpg', '2025-04-03 03:03:25'),
(244, 31, 2, 'Blue', '2025-04-03 03:04:45'),
(245, 31, 3, '128GB', '2025-04-03 03:04:45'),
(246, 31, 4, '21990000', '2025-04-03 03:04:45'),
(247, 31, 6, 'iPhone/iPhone15/iphone-15-pro-max-blue-128gb-21990000-1.jpg', '2025-04-03 03:04:45'),
(248, 31, 6, 'iPhone/iPhone15/iphone-15-pro-max-blue-128gb-21990000-2.jpg', '2025-04-03 03:04:45'),
(249, 31, 6, 'iPhone/iPhone15/iphone-15-pro-max-blue-128gb-21990000-3.jpg', '2025-04-03 03:04:45'),
(250, 31, 6, 'iPhone/iPhone15/iphone-15-pro-max-blue-128gb-21990000-4.jpg', '2025-04-03 03:04:45'),
(251, 31, 6, 'iPhone/iPhone15/iphone-15-pro-max-blue-128gb-21990000-5.jpg', '2025-04-03 03:04:45'),
(252, 31, 6, 'iPhone/iPhone15/iphone-15-pro-max-blue-128gb-21990000-6.jpg', '2025-04-03 03:04:45'),
(253, 31, 6, 'iPhone/iPhone15/iphone-15-pro-max-blue-128gb-21990000-7.jpg', '2025-04-03 03:04:45'),
(254, 32, 2, 'Nature', '2025-04-03 03:06:22'),
(255, 32, 3, '64GB', '2025-04-03 03:06:22'),
(256, 32, 4, '21990000', '2025-04-03 03:06:22'),
(257, 32, 6, 'iPhone/iPhone15/iphone-15-pro-max-nature-64gb-21990000-1.jpg', '2025-04-03 03:06:22'),
(258, 32, 6, 'iPhone/iPhone15/iphone-15-pro-max-nature-64gb-21990000-2.jpg', '2025-04-03 03:06:22'),
(259, 32, 6, 'iPhone/iPhone15/iphone-15-pro-max-nature-64gb-21990000-3.jpg', '2025-04-03 03:06:22'),
(260, 32, 6, 'iPhone/iPhone15/iphone-15-pro-max-nature-64gb-21990000-4.jpg', '2025-04-03 03:06:22'),
(261, 32, 6, 'iPhone/iPhone15/iphone-15-pro-max-nature-64gb-21990000-5.jpg', '2025-04-03 03:06:22'),
(262, 32, 6, 'iPhone/iPhone15/iphone-15-pro-max-nature-64gb-21990000-6.jpg', '2025-04-03 03:06:22'),
(263, 32, 6, 'iPhone/iPhone15/iphone-15-pro-max-nature-64gb-21990000-7.jpg', '2025-04-03 03:06:22'),
(264, 33, 2, 'Nature', '2025-04-03 03:08:14'),
(265, 33, 3, '128GB', '2025-04-03 03:08:14'),
(266, 33, 4, '21990000', '2025-04-03 03:08:14'),
(267, 33, 6, 'iPhone/iPhone15/iphone-15-pro-max-nature-128gb-21990000-1.jpg', '2025-04-03 03:08:14'),
(268, 33, 6, 'iPhone/iPhone15/iphone-15-pro-max-nature-128gb-21990000-2.jpg', '2025-04-03 03:08:14'),
(269, 33, 6, 'iPhone/iPhone15/iphone-15-pro-max-nature-128gb-21990000-3.jpg', '2025-04-03 03:08:14'),
(270, 33, 6, 'iPhone/iPhone15/iphone-15-pro-max-nature-128gb-21990000-4.jpg', '2025-04-03 03:08:14'),
(271, 33, 6, 'iPhone/iPhone15/iphone-15-pro-max-nature-128gb-21990000-5.jpg', '2025-04-03 03:08:14'),
(272, 33, 6, 'iPhone/iPhone15/iphone-15-pro-max-nature-128gb-21990000-6.jpg', '2025-04-03 03:08:14'),
(273, 33, 6, 'iPhone/iPhone15/iphone-15-pro-max-nature-128gb-21990000-7.jpg', '2025-04-03 03:08:14'),
(274, 34, 2, 'White', '2025-04-03 03:09:39'),
(275, 34, 3, '64GB', '2025-04-03 03:09:39'),
(276, 34, 4, '21990000', '2025-04-03 03:09:39'),
(277, 34, 6, 'iPhone/iPhone15/iphone-15-pro-max-white-64gb-21990000-1.jpg', '2025-04-03 03:09:39'),
(278, 34, 6, 'iPhone/iPhone15/iphone-15-pro-max-white-64gb-21990000-2.jpg', '2025-04-03 03:09:39'),
(279, 34, 6, 'iPhone/iPhone15/iphone-15-pro-max-white-64gb-21990000-3.jpg', '2025-04-03 03:09:39'),
(280, 34, 6, 'iPhone/iPhone15/iphone-15-pro-max-white-64gb-21990000-4.jpg', '2025-04-03 03:09:39'),
(281, 34, 6, 'iPhone/iPhone15/iphone-15-pro-max-white-64gb-21990000-5.jpg', '2025-04-03 03:09:39'),
(282, 34, 6, 'iPhone/iPhone15/iphone-15-pro-max-white-64gb-21990000-6.jpg', '2025-04-03 03:09:39'),
(283, 34, 6, 'iPhone/iPhone15/iphone-15-pro-max-white-64gb-21990000-7.jpg', '2025-04-03 03:09:39'),
(284, 34, 6, 'iPhone/iPhone15/iphone-15-pro-max-white-64gb-21990000-8.jpg', '2025-04-03 03:09:39'),
(285, 35, 2, 'White', '2025-04-03 03:11:09'),
(286, 35, 3, '128GB', '2025-04-03 03:11:09'),
(287, 35, 4, '21990000', '2025-04-03 03:11:09'),
(288, 35, 6, 'iPhone/iPhone15/iphone-15-pro-max-white-128gb-21990000-1.jpg', '2025-04-03 03:11:09'),
(289, 35, 6, 'iPhone/iPhone15/iphone-15-pro-max-white-128gb-21990000-2.jpg', '2025-04-03 03:11:09'),
(290, 35, 6, 'iPhone/iPhone15/iphone-15-pro-max-white-128gb-21990000-3.jpg', '2025-04-03 03:11:09'),
(291, 35, 6, 'iPhone/iPhone15/iphone-15-pro-max-white-128gb-21990000-4.jpg', '2025-04-03 03:11:09'),
(292, 35, 6, 'iPhone/iPhone15/iphone-15-pro-max-white-128gb-21990000-5.jpg', '2025-04-03 03:11:09'),
(293, 35, 6, 'iPhone/iPhone15/iphone-15-pro-max-white-128gb-21990000-6.jpg', '2025-04-03 03:11:09'),
(294, 35, 6, 'iPhone/iPhone15/iphone-15-pro-max-white-128gb-21990000-7.jpg', '2025-04-03 03:11:09'),
(295, 36, 2, 'Black', '2025-04-03 03:13:08'),
(296, 36, 3, '256GB', '2025-04-03 03:13:08'),
(297, 36, 4, '22990000', '2025-04-03 03:13:08'),
(298, 36, 6, 'iPhone/iPhone15/iphone-15-plus-black-256gb-22990000-1.jpg', '2025-04-03 03:13:08'),
(299, 36, 6, 'iPhone/iPhone15/iphone-15-plus-black-256gb-22990000-2.jpg', '2025-04-03 03:13:08'),
(300, 36, 6, 'iPhone/iPhone15/iphone-15-plus-black-256gb-22990000-3.jpg', '2025-04-03 03:13:08'),
(301, 36, 6, 'iPhone/iPhone15/iphone-15-plus-black-256gb-22990000-4.jpg', '2025-04-03 03:13:08'),
(302, 36, 6, 'iPhone/iPhone15/iphone-15-plus-black-256gb-22990000-5.jpg', '2025-04-03 03:13:08'),
(303, 36, 6, 'iPhone/iPhone15/iphone-15-plus-black-256gb-22990000-6.jpg', '2025-04-03 03:13:08'),
(304, 36, 6, 'iPhone/iPhone15/iphone-15-plus-black-256gb-22990000-7.jpg', '2025-04-03 03:13:08'),
(305, 37, 2, 'Black', '2025-04-03 03:14:33'),
(306, 37, 3, '512GB', '2025-04-03 03:14:33'),
(307, 37, 4, '22990000', '2025-04-03 03:14:33'),
(308, 37, 6, 'iPhone/iPhone15/iphone-15-plus-black-512gb-22990000-1.jpg', '2025-04-03 03:14:33'),
(309, 37, 6, 'iPhone/iPhone15/iphone-15-plus-black-512gb-22990000-2.jpg', '2025-04-03 03:14:33'),
(310, 37, 6, 'iPhone/iPhone15/iphone-15-plus-black-512gb-22990000-3.jpg', '2025-04-03 03:14:33'),
(311, 37, 6, 'iPhone/iPhone15/iphone-15-plus-black-512gb-22990000-4.jpg', '2025-04-03 03:14:33'),
(312, 37, 6, 'iPhone/iPhone15/iphone-15-plus-black-512gb-22990000-5.jpg', '2025-04-03 03:14:33'),
(313, 37, 6, 'iPhone/iPhone15/iphone-15-plus-black-512gb-22990000-6.jpg', '2025-04-03 03:14:33'),
(314, 37, 6, 'iPhone/iPhone15/iphone-15-plus-black-512gb-22990000-7.jpg', '2025-04-03 03:14:33'),
(315, 37, 6, 'iPhone/iPhone15/iphone-15-plus-black-512gb-22990000-8.jpg', '2025-04-03 03:14:33'),
(316, 38, 2, 'Blue', '2025-04-03 03:15:59'),
(317, 38, 3, '256GB', '2025-04-03 03:15:59'),
(318, 38, 4, '22990000', '2025-04-03 03:15:59'),
(319, 38, 6, 'iPhone/iPhone15/iphone-15-plus-blue-256gb-22990000-1.jpg', '2025-04-03 03:15:59'),
(320, 38, 6, 'iPhone/iPhone15/iphone-15-plus-blue-256gb-22990000-2.jpg', '2025-04-03 03:15:59'),
(321, 38, 6, 'iPhone/iPhone15/iphone-15-plus-blue-256gb-22990000-3.jpg', '2025-04-03 03:15:59'),
(322, 38, 6, 'iPhone/iPhone15/iphone-15-plus-blue-256gb-22990000-4.jpg', '2025-04-03 03:15:59'),
(323, 38, 6, 'iPhone/iPhone15/iphone-15-plus-blue-256gb-22990000-5.jpg', '2025-04-03 03:15:59'),
(324, 38, 6, 'iPhone/iPhone15/iphone-15-plus-blue-256gb-22990000-6.jpg', '2025-04-03 03:15:59'),
(325, 38, 6, 'iPhone/iPhone15/iphone-15-plus-blue-256gb-22990000-7.jpg', '2025-04-03 03:15:59'),
(326, 39, 2, 'Blue', '2025-04-03 03:17:18'),
(327, 39, 3, '512GB', '2025-04-03 03:17:18'),
(328, 39, 4, '22990000', '2025-04-03 03:17:18'),
(329, 39, 6, 'iPhone/iPhone15/iphone-15-plus-blue-512gb-22990000-1.jpg', '2025-04-03 03:17:18'),
(330, 39, 6, 'iPhone/iPhone15/iphone-15-plus-blue-512gb-22990000-2.jpg', '2025-04-03 03:17:18'),
(331, 39, 6, 'iPhone/iPhone15/iphone-15-plus-blue-512gb-22990000-3.jpg', '2025-04-03 03:17:18'),
(332, 39, 6, 'iPhone/iPhone15/iphone-15-plus-blue-512gb-22990000-4.jpg', '2025-04-03 03:17:18'),
(333, 39, 6, 'iPhone/iPhone15/iphone-15-plus-blue-512gb-22990000-5.jpg', '2025-04-03 03:17:18'),
(334, 39, 6, 'iPhone/iPhone15/iphone-15-plus-blue-512gb-22990000-6.jpg', '2025-04-03 03:17:18'),
(335, 39, 6, 'iPhone/iPhone15/iphone-15-plus-blue-512gb-22990000-7.jpg', '2025-04-03 03:17:18'),
(336, 40, 2, 'Green', '2025-04-03 03:19:05'),
(337, 40, 3, '1T', '2025-04-03 03:19:05'),
(338, 40, 4, '23990000', '2025-04-03 03:19:05'),
(339, 40, 6, 'iPhone/iPhone15/iphone-15-plus-green-1t-23990000-1.jpg', '2025-04-03 03:19:05'),
(340, 40, 6, 'iPhone/iPhone15/iphone-15-plus-green-1t-23990000-2.jpg', '2025-04-03 03:19:05'),
(341, 40, 6, 'iPhone/iPhone15/iphone-15-plus-green-1t-23990000-3.jpg', '2025-04-03 03:19:05'),
(342, 40, 6, 'iPhone/iPhone15/iphone-15-plus-green-1t-23990000-4.jpg', '2025-04-03 03:19:05'),
(343, 40, 6, 'iPhone/iPhone15/iphone-15-plus-green-1t-23990000-5.jpg', '2025-04-03 03:19:05'),
(344, 40, 6, 'iPhone/iPhone15/iphone-15-plus-green-1t-23990000-6.jpg', '2025-04-03 03:19:05'),
(345, 40, 6, 'iPhone/iPhone15/iphone-15-plus-green-1t-23990000-7.jpg', '2025-04-03 03:19:05'),
(346, 40, 6, 'iPhone/iPhone15/iphone-15-plus-green-1t-23990000-8.jpg', '2025-04-03 03:19:05'),
(347, 41, 2, 'Green', '2025-04-03 03:20:50'),
(348, 41, 3, '2T', '2025-04-03 03:20:50'),
(349, 41, 4, '23990000', '2025-04-03 03:20:50'),
(350, 41, 6, 'iPhone/iPhone15/iphone-15-plus-green-2t-23990000-1.jpg', '2025-04-03 03:20:50'),
(351, 41, 6, 'iPhone/iPhone15/iphone-15-plus-green-2t-23990000-2.jpg', '2025-04-03 03:20:50'),
(352, 41, 6, 'iPhone/iPhone15/iphone-15-plus-green-2t-23990000-3.jpg', '2025-04-03 03:20:50'),
(353, 41, 6, 'iPhone/iPhone15/iphone-15-plus-green-2t-23990000-4.jpg', '2025-04-03 03:20:50'),
(354, 41, 6, 'iPhone/iPhone15/iphone-15-plus-green-2t-23990000-5.jpg', '2025-04-03 03:20:50'),
(355, 41, 6, 'iPhone/iPhone15/iphone-15-plus-green-2t-23990000-6.jpg', '2025-04-03 03:20:50'),
(356, 41, 6, 'iPhone/iPhone15/iphone-15-plus-green-2t-23990000-7.jpg', '2025-04-03 03:20:50'),
(357, 42, 2, 'Pink', '2025-04-03 03:22:48'),
(358, 42, 3, '64GB', '2025-04-03 03:22:48'),
(359, 42, 4, '22990000', '2025-04-03 03:22:48'),
(360, 42, 6, 'iPhone/iPhone15/iphone-15-plus-pink-64gb-22990000-1.jpg', '2025-04-03 03:22:48'),
(361, 42, 6, 'iPhone/iPhone15/iphone-15-plus-pink-64gb-22990000-2.jpg', '2025-04-03 03:22:48'),
(362, 42, 6, 'iPhone/iPhone15/iphone-15-plus-pink-64gb-22990000-3.jpg', '2025-04-03 03:22:48'),
(363, 42, 6, 'iPhone/iPhone15/iphone-15-plus-pink-64gb-22990000-4.jpg', '2025-04-03 03:22:48'),
(364, 42, 6, 'iPhone/iPhone15/iphone-15-plus-pink-64gb-22990000-5.jpg', '2025-04-03 03:22:48'),
(365, 42, 6, 'iPhone/iPhone15/iphone-15-plus-pink-64gb-22990000-6.jpg', '2025-04-03 03:22:48'),
(366, 42, 6, 'iPhone/iPhone15/iphone-15-plus-pink-64gb-22990000-7.jpg', '2025-04-03 03:22:48'),
(367, 43, 2, 'Pink', '2025-04-03 03:24:13'),
(368, 43, 3, '128GB', '2025-04-03 03:24:14'),
(369, 43, 4, '22990000', '2025-04-03 03:24:14'),
(370, 43, 6, 'iPhone/iPhone15/iphone-15-plus-pink-128gb-22990000-1.jpg', '2025-04-03 03:24:14'),
(371, 43, 6, 'iPhone/iPhone15/iphone-15-plus-pink-128gb-22990000-2.jpg', '2025-04-03 03:24:14'),
(372, 43, 6, 'iPhone/iPhone15/iphone-15-plus-pink-128gb-22990000-3.jpg', '2025-04-03 03:24:14'),
(373, 43, 6, 'iPhone/iPhone15/iphone-15-plus-pink-128gb-22990000-4.jpg', '2025-04-03 03:24:14'),
(374, 43, 6, 'iPhone/iPhone15/iphone-15-plus-pink-128gb-22990000-5.jpg', '2025-04-03 03:24:14'),
(375, 43, 6, 'iPhone/iPhone15/iphone-15-plus-pink-128gb-22990000-6.jpg', '2025-04-03 03:24:14'),
(376, 43, 6, 'iPhone/iPhone15/iphone-15-plus-pink-128gb-22990000-7.jpg', '2025-04-03 03:24:14'),
(377, 43, 6, 'iPhone/iPhone15/iphone-15-plus-pink-128gb-22990000-8.jpg', '2025-04-03 03:24:14'),
(378, 44, 2, 'Yellow', '2025-04-03 03:25:45'),
(379, 44, 3, '64GB', '2025-04-03 03:25:45'),
(380, 44, 4, '32990000', '2025-04-03 03:25:45'),
(381, 44, 6, 'iPhone/iPhone15/iphone-15-plus-yellow-64gb-32990000-1.jpg', '2025-04-03 03:25:45'),
(382, 44, 6, 'iPhone/iPhone15/iphone-15-plus-yellow-64gb-32990000-2.jpg', '2025-04-03 03:25:45'),
(383, 44, 6, 'iPhone/iPhone15/iphone-15-plus-yellow-64gb-32990000-3.jpg', '2025-04-03 03:25:45'),
(384, 44, 6, 'iPhone/iPhone15/iphone-15-plus-yellow-64gb-32990000-4.jpg', '2025-04-03 03:25:45'),
(385, 44, 6, 'iPhone/iPhone15/iphone-15-plus-yellow-64gb-32990000-5.jpg', '2025-04-03 03:25:45'),
(386, 44, 6, 'iPhone/iPhone15/iphone-15-plus-yellow-64gb-32990000-6.jpg', '2025-04-03 03:25:45'),
(387, 44, 6, 'iPhone/iPhone15/iphone-15-plus-yellow-64gb-32990000-7.jpg', '2025-04-03 03:25:45'),
(388, 45, 2, 'Yellow', '2025-04-03 03:27:16'),
(389, 45, 3, '512GB', '2025-04-03 03:27:16'),
(390, 45, 4, '32990000', '2025-04-03 03:27:16'),
(391, 45, 6, 'iPhone/iPhone15/iphone-15-plus-yellow-512gb-32990000-1.jpg', '2025-04-03 03:27:16'),
(392, 45, 6, 'iPhone/iPhone15/iphone-15-plus-yellow-512gb-32990000-2.jpg', '2025-04-03 03:27:16'),
(393, 45, 6, 'iPhone/iPhone15/iphone-15-plus-yellow-512gb-32990000-3.jpg', '2025-04-03 03:27:16'),
(394, 45, 6, 'iPhone/iPhone15/iphone-15-plus-yellow-512gb-32990000-4.jpg', '2025-04-03 03:27:16'),
(395, 45, 6, 'iPhone/iPhone15/iphone-15-plus-yellow-512gb-32990000-5.jpg', '2025-04-03 03:27:16'),
(396, 45, 6, 'iPhone/iPhone15/iphone-15-plus-yellow-512gb-32990000-6.jpg', '2025-04-03 03:27:16'),
(397, 45, 6, 'iPhone/iPhone15/iphone-15-plus-yellow-512gb-32990000-7.jpg', '2025-04-03 03:27:16'),
(398, 46, 2, 'Black', '2025-04-03 03:28:54'),
(399, 46, 3, '64GB', '2025-04-03 03:28:54'),
(400, 46, 4, '31990000', '2025-04-03 03:28:54'),
(401, 46, 6, 'iPhone/iPhone16/iphone-16-pro-max-black-64gb-31990000-1.jpg', '2025-04-03 03:28:54'),
(402, 46, 6, 'iPhone/iPhone16/iphone-16-pro-max-black-64gb-31990000-2.jpg', '2025-04-03 03:28:54'),
(403, 46, 6, 'iPhone/iPhone16/iphone-16-pro-max-black-64gb-31990000-3.jpg', '2025-04-03 03:28:54'),
(404, 46, 6, 'iPhone/iPhone16/iphone-16-pro-max-black-64gb-31990000-4.jpg', '2025-04-03 03:28:54'),
(405, 46, 6, 'iPhone/iPhone16/iphone-16-pro-max-black-64gb-31990000-5.jpg', '2025-04-03 03:28:54'),
(406, 46, 6, 'iPhone/iPhone16/iphone-16-pro-max-black-64gb-31990000-6.jpg', '2025-04-03 03:28:54'),
(407, 46, 6, 'iPhone/iPhone16/iphone-16-pro-max-black-64gb-31990000-7.jpg', '2025-04-03 03:28:54'),
(408, 47, 2, 'Black', '2025-04-03 03:30:07'),
(409, 47, 3, '128GB', '2025-04-03 03:30:07'),
(410, 47, 4, '31990000', '2025-04-03 03:30:07'),
(411, 47, 6, 'iPhone/iPhone16/iphone-16-pro-max-black-128gb-31990000-1.jpg', '2025-04-03 03:30:07'),
(412, 47, 6, 'iPhone/iPhone16/iphone-16-pro-max-black-128gb-31990000-2.jpg', '2025-04-03 03:30:07'),
(413, 47, 6, 'iPhone/iPhone16/iphone-16-pro-max-black-128gb-31990000-3.jpg', '2025-04-03 03:30:07'),
(414, 47, 6, 'iPhone/iPhone16/iphone-16-pro-max-black-128gb-31990000-4.jpg', '2025-04-03 03:30:07'),
(415, 47, 6, 'iPhone/iPhone16/iphone-16-pro-max-black-128gb-31990000-5.jpg', '2025-04-03 03:30:07'),
(416, 47, 6, 'iPhone/iPhone16/iphone-16-pro-max-black-128gb-31990000-6.jpg', '2025-04-03 03:30:07'),
(417, 47, 6, 'iPhone/iPhone16/iphone-16-pro-max-black-128gb-31990000-7.jpg', '2025-04-03 03:30:07'),
(418, 48, 2, 'Gold', '2025-04-03 03:31:30'),
(419, 48, 3, '64GB', '2025-04-03 03:31:30'),
(420, 48, 4, '31990000', '2025-04-03 03:31:30'),
(421, 48, 6, 'iPhone/iPhone16/iphone-16-pro-max-gold-64gb-31990000-1.jpg', '2025-04-03 03:31:30'),
(422, 48, 6, 'iPhone/iPhone16/iphone-16-pro-max-gold-64gb-31990000-2.jpg', '2025-04-03 03:31:30'),
(423, 48, 6, 'iPhone/iPhone16/iphone-16-pro-max-gold-64gb-31990000-3.jpg', '2025-04-03 03:31:30'),
(424, 48, 6, 'iPhone/iPhone16/iphone-16-pro-max-gold-64gb-31990000-4.jpg', '2025-04-03 03:31:30'),
(425, 48, 6, 'iPhone/iPhone16/iphone-16-pro-max-gold-64gb-31990000-5.jpg', '2025-04-03 03:31:30'),
(426, 48, 6, 'iPhone/iPhone16/iphone-16-pro-max-gold-64gb-31990000-6.jpg', '2025-04-03 03:31:30'),
(427, 48, 6, 'iPhone/iPhone16/iphone-16-pro-max-gold-64gb-31990000-7.jpg', '2025-04-03 03:31:30'),
(428, 49, 2, 'Gold', '2025-04-03 03:32:50'),
(429, 49, 3, '128GB', '2025-04-03 03:32:50'),
(430, 49, 4, '31990000', '2025-04-03 03:32:50'),
(431, 49, 6, 'iPhone/iPhone16/iphone-16-pro-max-gold-128gb-31990000-1.jpg', '2025-04-03 03:32:50'),
(432, 49, 6, 'iPhone/iPhone16/iphone-16-pro-max-gold-128gb-31990000-2.jpg', '2025-04-03 03:32:50'),
(433, 49, 6, 'iPhone/iPhone16/iphone-16-pro-max-gold-128gb-31990000-3.jpg', '2025-04-03 03:32:50'),
(434, 49, 6, 'iPhone/iPhone16/iphone-16-pro-max-gold-128gb-31990000-4.jpg', '2025-04-03 03:32:50'),
(435, 49, 6, 'iPhone/iPhone16/iphone-16-pro-max-gold-128gb-31990000-5.jpg', '2025-04-03 03:32:50'),
(436, 49, 6, 'iPhone/iPhone16/iphone-16-pro-max-gold-128gb-31990000-6.jpg', '2025-04-03 03:32:50'),
(437, 49, 6, 'iPhone/iPhone16/iphone-16-pro-max-gold-128gb-31990000-7.jpg', '2025-04-03 03:32:50'),
(438, 50, 2, 'Nature', '2025-04-03 03:34:28'),
(439, 50, 3, '64GB', '2025-04-03 03:34:28'),
(440, 50, 4, '31990000', '2025-04-03 03:34:28'),
(441, 50, 6, 'iPhone/iPhone16/iphone-16-pro-max-nature-64gb-31990000-1.png', '2025-04-03 03:34:28'),
(442, 50, 6, 'iPhone/iPhone16/iphone-16-pro-max-nature-64gb-31990000-2.jpg', '2025-04-03 03:34:28'),
(443, 50, 6, 'iPhone/iPhone16/iphone-16-pro-max-nature-64gb-31990000-3.jpg', '2025-04-03 03:34:28'),
(444, 50, 6, 'iPhone/iPhone16/iphone-16-pro-max-nature-64gb-31990000-4.jpg', '2025-04-03 03:34:28'),
(445, 50, 6, 'iPhone/iPhone16/iphone-16-pro-max-nature-64gb-31990000-5.jpg', '2025-04-03 03:34:28'),
(446, 50, 6, 'iPhone/iPhone16/iphone-16-pro-max-nature-64gb-31990000-6.jpg', '2025-04-03 03:34:28'),
(447, 50, 6, 'iPhone/iPhone16/iphone-16-pro-max-nature-64gb-31990000-7.jpg', '2025-04-03 03:34:28'),
(448, 51, 2, 'Nature', '2025-04-03 03:35:37'),
(449, 51, 3, '128GB', '2025-04-03 03:35:37'),
(450, 51, 4, '31990000', '2025-04-03 03:35:37'),
(451, 51, 6, 'iPhone/iPhone16/iphone-16-pro-max-nature-128gb-31990000-1.jpg', '2025-04-03 03:35:37'),
(452, 51, 6, 'iPhone/iPhone16/iphone-16-pro-max-nature-128gb-31990000-2.jpg', '2025-04-03 03:35:37'),
(453, 51, 6, 'iPhone/iPhone16/iphone-16-pro-max-nature-128gb-31990000-3.jpg', '2025-04-03 03:35:37'),
(454, 51, 6, 'iPhone/iPhone16/iphone-16-pro-max-nature-128gb-31990000-4.jpg', '2025-04-03 03:35:37'),
(455, 51, 6, 'iPhone/iPhone16/iphone-16-pro-max-nature-128gb-31990000-5.jpg', '2025-04-03 03:35:37'),
(456, 51, 6, 'iPhone/iPhone16/iphone-16-pro-max-nature-128gb-31990000-6.jpg', '2025-04-03 03:35:37'),
(457, 52, 2, 'iPhone/iPhone16/iphone-16-pro-max-hite-128-123213213-1.jpeg', '2025-04-03 04:21:27'),
(458, 52, 3, 'iPhone/iPhone16/iphone-16-pro-max-hite-128-123213213-2.jpeg', '2025-04-03 04:21:27'),
(459, 52, 4, 'iPhone/iPhone16/iphone-16-pro-max-hite-128-123213213-3.jpeg', '2025-04-03 04:21:27'),
(460, 52, 6, 'iPhone/iPhone16/iphone-16-pro-max-hite-128-123213213-4.jpeg', '2025-04-03 04:21:27'),
(461, 52, 6, 'iPhone/iPhone16/iphone-16-pro-max-hite-128-123213213-5.jpeg', '2025-04-03 04:21:27'),
(462, 52, 6, 'iPhone/iPhone16/iphone-16-pro-max-hite-128-123213213-6.jpeg', '2025-04-03 04:21:27'),
(463, 52, 6, 'iPhone/iPhone16/iphone-16-pro-max-hite-128-123213213-7.jpeg', '2025-04-03 04:21:27'),
(464, 52, 6, 'iPhone/iPhone16/iphone-16-pro-max-hite-128-123213213-8.jpeg', '2025-04-03 04:21:27'),
(465, 52, 6, '', '2025-04-03 04:21:27'),
(466, 52, 6, '', '2025-04-03 04:21:27'),
(467, 52, 6, '', '2025-04-03 04:21:27'),
(468, 53, 2, 'Black', '2025-04-03 04:23:55'),
(469, 53, 3, '128GB', '2025-04-03 04:23:55'),
(470, 53, 4, '34990000', '2025-04-03 04:23:55'),
(471, 53, 6, 'iPhone/iPhone16/iphone-16-black-128gb-34990000-1.jpg', '2025-04-03 04:23:55'),
(472, 53, 6, 'iPhone/iPhone16/iphone-16-black-128gb-34990000-2.jpg', '2025-04-03 04:23:55'),
(473, 53, 6, 'iPhone/iPhone16/iphone-16-black-128gb-34990000-3.jpg', '2025-04-03 04:23:55'),
(474, 53, 6, 'iPhone/iPhone16/iphone-16-black-128gb-34990000-4.jpg', '2025-04-03 04:23:55'),
(475, 53, 6, 'iPhone/iPhone16/iphone-16-black-128gb-34990000-5.jpg', '2025-04-03 04:23:55'),
(476, 53, 6, 'iPhone/iPhone16/iphone-16-black-128gb-34990000-6.jpg', '2025-04-03 04:23:55'),
(477, 53, 6, 'iPhone/iPhone16/iphone-16-black-128gb-34990000-7.jpg', '2025-04-03 04:23:55'),
(478, 54, 2, 'Blue', '2025-04-03 04:39:37'),
(479, 54, 3, '1T', '2025-04-03 04:39:37'),
(480, 54, 4, '35670000', '2025-04-03 04:39:37'),
(481, 54, 6, 'iPhone/iPhone16/iphone-16-blue-1t-35670000-1.jpg', '2025-04-03 04:39:37'),
(482, 54, 6, 'iPhone/iPhone16/iphone-16-blue-1t-35670000-2.jpg', '2025-04-03 04:39:37'),
(483, 54, 6, 'iPhone/iPhone16/iphone-16-blue-1t-35670000-3.jpg', '2025-04-03 04:39:37'),
(484, 54, 6, 'iPhone/iPhone16/iphone-16-blue-1t-35670000-4.jpg', '2025-04-03 04:39:37'),
(485, 54, 6, 'iPhone/iPhone16/iphone-16-blue-1t-35670000-5.jpg', '2025-04-03 04:39:37'),
(486, 54, 6, 'iPhone/iPhone16/iphone-16-blue-1t-35670000-6.jpg', '2025-04-03 04:39:37'),
(487, 54, 6, 'iPhone/iPhone16/iphone-16-blue-1t-35670000-7.jpg', '2025-04-03 04:39:37'),
(488, 55, 2, 'Green', '2025-04-03 04:41:24'),
(489, 55, 3, '512GB', '2025-04-03 04:41:24'),
(490, 55, 4, '2789000', '2025-04-03 04:41:24'),
(491, 55, 6, 'iPhone/iPhone16/iphone-16-green-512gb-2789000-1.jpg', '2025-04-03 04:41:24'),
(492, 55, 6, 'iPhone/iPhone16/iphone-16-green-512gb-2789000-2.jpg', '2025-04-03 04:41:24'),
(493, 55, 6, 'iPhone/iPhone16/iphone-16-green-512gb-2789000-3.jpg', '2025-04-03 04:41:24'),
(494, 55, 6, 'iPhone/iPhone16/iphone-16-green-512gb-2789000-4.jpg', '2025-04-03 04:41:24'),
(495, 55, 6, 'iPhone/iPhone16/iphone-16-green-512gb-2789000-5.jpg', '2025-04-03 04:41:24'),
(496, 55, 6, 'iPhone/iPhone16/iphone-16-green-512gb-2789000-6.jpg', '2025-04-03 04:41:24'),
(497, 55, 6, 'iPhone/iPhone16/iphone-16-green-512gb-2789000-7.jpg', '2025-04-03 04:41:24'),
(498, 56, 2, 'Pink', '2025-04-03 04:42:40'),
(499, 56, 3, '256GB', '2025-04-03 04:42:40'),
(500, 56, 4, '23590000', '2025-04-03 04:42:40'),
(501, 56, 6, 'iPhone/iPhone16/iphone-16-pink-256gb-23590000-1.png', '2025-04-03 04:42:40'),
(502, 56, 6, 'iPhone/iPhone16/iphone-16-pink-256gb-23590000-2.jpg', '2025-04-03 04:42:40'),
(503, 56, 6, 'iPhone/iPhone16/iphone-16-pink-256gb-23590000-3.jpg', '2025-04-03 04:42:40'),
(504, 56, 6, 'iPhone/iPhone16/iphone-16-pink-256gb-23590000-4.jpg', '2025-04-03 04:42:40'),
(505, 56, 6, 'iPhone/iPhone16/iphone-16-pink-256gb-23590000-5.jpg', '2025-04-03 04:42:40'),
(506, 56, 6, 'iPhone/iPhone16/iphone-16-pink-256gb-23590000-6.jpg', '2025-04-03 04:42:40'),
(507, 56, 6, 'iPhone/iPhone16/iphone-16-pink-256gb-23590000-7.jpg', '2025-04-03 04:42:40'),
(508, 57, 2, 'White', '2025-04-03 04:58:47'),
(509, 57, 3, '256GB', '2025-04-03 04:58:47'),
(510, 57, 4, '24990000', '2025-04-03 04:58:47'),
(511, 57, 6, 'iPhone/iPhone16/iphone-16-white-256gb-24990000-1.jpg', '2025-04-03 04:58:47'),
(512, 57, 6, 'iPhone/iPhone16/iphone-16-white-256gb-24990000-2.jpg', '2025-04-03 04:58:47'),
(513, 57, 6, 'iPhone/iPhone16/iphone-16-white-256gb-24990000-3.jpg', '2025-04-03 04:58:47'),
(514, 57, 6, 'iPhone/iPhone16/iphone-16-white-256gb-24990000-4.jpg', '2025-04-03 04:58:47'),
(515, 57, 6, 'iPhone/iPhone16/iphone-16-white-256gb-24990000-5.jpg', '2025-04-03 04:58:47'),
(516, 57, 6, 'iPhone/iPhone16/iphone-16-white-256gb-24990000-6.jpg', '2025-04-03 04:58:47'),
(517, 58, 2, 'Black', '2025-04-03 05:37:17'),
(518, 58, 3, '64GB', '2025-04-03 05:37:17'),
(519, 58, 4, '24990000', '2025-04-03 05:37:17'),
(520, 58, 6, 'iPhone/iPhone16/iphone-16-plus-black-64gb-24990000-1.png', '2025-04-03 05:37:17'),
(521, 58, 6, 'iPhone/iPhone16/iphone-16-plus-black-64gb-24990000-2.jpg', '2025-04-03 05:37:17'),
(522, 58, 6, 'iPhone/iPhone16/iphone-16-plus-black-64gb-24990000-3.jpg', '2025-04-03 05:37:17'),
(523, 58, 6, 'iPhone/iPhone16/iphone-16-plus-black-64gb-24990000-4.jpg', '2025-04-03 05:37:17'),
(524, 58, 6, 'iPhone/iPhone16/iphone-16-plus-black-64gb-24990000-5.jpg', '2025-04-03 05:37:17'),
(525, 58, 6, 'iPhone/iPhone16/iphone-16-plus-black-64gb-24990000-6.jpg', '2025-04-03 05:37:17'),
(526, 58, 6, 'iPhone/iPhone16/iphone-16-plus-black-64gb-24990000-7.jpg', '2025-04-03 05:37:17'),
(527, 58, 6, 'iPhone/iPhone16/iphone-16-plus-black-64gb-24990000-8.jpg', '2025-04-03 05:37:17'),
(528, 59, 2, 'Black', '2025-04-03 05:38:32'),
(529, 59, 3, '32GB', '2025-04-03 05:38:32'),
(530, 59, 4, '24990000', '2025-04-03 05:38:32'),
(531, 59, 6, 'iPhone/iPhone16/iphone-16-plus-black-32gb-24990000-1.jpg', '2025-04-03 05:38:32'),
(532, 59, 6, 'iPhone/iPhone16/iphone-16-plus-black-32gb-24990000-2.jpg', '2025-04-03 05:38:32'),
(533, 59, 6, 'iPhone/iPhone16/iphone-16-plus-black-32gb-24990000-3.jpg', '2025-04-03 05:38:32'),
(534, 59, 6, 'iPhone/iPhone16/iphone-16-plus-black-32gb-24990000-4.jpg', '2025-04-03 05:38:32'),
(535, 59, 6, 'iPhone/iPhone16/iphone-16-plus-black-32gb-24990000-5.jpg', '2025-04-03 05:38:32'),
(536, 59, 6, 'iPhone/iPhone16/iphone-16-plus-black-32gb-24990000-6.jpg', '2025-04-03 05:38:32'),
(537, 59, 6, 'iPhone/iPhone16/iphone-16-plus-black-32gb-24990000-7.jpg', '2025-04-03 05:38:32'),
(538, 60, 2, 'Blue', '2025-04-03 05:39:58'),
(539, 60, 3, '64GB', '2025-04-03 05:39:58'),
(540, 60, 4, '29990000', '2025-04-03 05:39:58'),
(541, 60, 6, 'iPhone/iPhone16/iphone-16-plus-blue-64gb-29990000-1.jpg', '2025-04-03 05:39:58'),
(542, 60, 6, 'iPhone/iPhone16/iphone-16-plus-blue-64gb-29990000-2.jpg', '2025-04-03 05:39:58'),
(543, 60, 6, 'iPhone/iPhone16/iphone-16-plus-blue-64gb-29990000-3.jpg', '2025-04-03 05:39:58'),
(544, 60, 6, 'iPhone/iPhone16/iphone-16-plus-blue-64gb-29990000-4.jpg', '2025-04-03 05:39:58'),
(545, 60, 6, 'iPhone/iPhone16/iphone-16-plus-blue-64gb-29990000-5.jpg', '2025-04-03 05:39:58'),
(546, 60, 6, 'iPhone/iPhone16/iphone-16-plus-blue-64gb-29990000-6.jpg', '2025-04-03 05:39:58'),
(547, 60, 6, 'iPhone/iPhone16/iphone-16-plus-blue-64gb-29990000-7.jpg', '2025-04-03 05:39:58'),
(548, 61, 2, 'Blue', '2025-04-03 05:41:11'),
(549, 61, 3, '128GB', '2025-04-03 05:41:11'),
(550, 61, 4, '34990000', '2025-04-03 05:41:11'),
(551, 61, 6, 'iPhone/iPhone16/iphone-16-plus-blue-128gb-34990000-1.jpg', '2025-04-03 05:41:11'),
(552, 61, 6, 'iPhone/iPhone16/iphone-16-plus-blue-128gb-34990000-2.jpg', '2025-04-03 05:41:11'),
(553, 61, 6, 'iPhone/iPhone16/iphone-16-plus-blue-128gb-34990000-3.jpg', '2025-04-03 05:41:11'),
(554, 61, 6, 'iPhone/iPhone16/iphone-16-plus-blue-128gb-34990000-4.jpg', '2025-04-03 05:41:11'),
(555, 61, 6, 'iPhone/iPhone16/iphone-16-plus-blue-128gb-34990000-5.jpg', '2025-04-03 05:41:11'),
(556, 61, 6, 'iPhone/iPhone16/iphone-16-plus-blue-128gb-34990000-6.jpg', '2025-04-03 05:41:11'),
(557, 61, 6, 'iPhone/iPhone16/iphone-16-plus-blue-128gb-34990000-7.jpg', '2025-04-03 05:41:11'),
(558, 62, 2, 'Green', '2025-04-03 05:42:26'),
(559, 62, 3, '32GB', '2025-04-03 05:42:26'),
(560, 62, 4, '45690000', '2025-04-03 05:42:26'),
(561, 62, 6, 'iPhone/iPhone16/iphone-16-plus-green-32gb-45690000-1.jpg', '2025-04-03 05:42:26'),
(562, 62, 6, 'iPhone/iPhone16/iphone-16-plus-green-32gb-45690000-2.jpg', '2025-04-03 05:42:26'),
(563, 62, 6, 'iPhone/iPhone16/iphone-16-plus-green-32gb-45690000-3.jpg', '2025-04-03 05:42:26'),
(564, 62, 6, 'iPhone/iPhone16/iphone-16-plus-green-32gb-45690000-4.jpg', '2025-04-03 05:42:26'),
(565, 62, 6, 'iPhone/iPhone16/iphone-16-plus-green-32gb-45690000-5.jpg', '2025-04-03 05:42:26'),
(566, 62, 6, 'iPhone/iPhone16/iphone-16-plus-green-32gb-45690000-6.png', '2025-04-03 05:42:26'),
(567, 63, 2, 'Green', '2025-04-03 05:43:43'),
(568, 63, 3, '512GB', '2025-04-03 05:43:43'),
(569, 63, 4, '25770000', '2025-04-03 05:43:43'),
(570, 63, 6, 'iPhone/iPhone16/iphone-16-plus-green-512gb-25770000-1.jpg', '2025-04-03 05:43:43'),
(571, 63, 6, 'iPhone/iPhone16/iphone-16-plus-green-512gb-25770000-2.jpg', '2025-04-03 05:43:43'),
(572, 63, 6, 'iPhone/iPhone16/iphone-16-plus-green-512gb-25770000-3.jpg', '2025-04-03 05:43:43'),
(573, 63, 6, 'iPhone/iPhone16/iphone-16-plus-green-512gb-25770000-4.jpg', '2025-04-03 05:43:43'),
(574, 63, 6, 'iPhone/iPhone16/iphone-16-plus-green-512gb-25770000-5.jpg', '2025-04-03 05:43:43'),
(575, 63, 6, 'iPhone/iPhone16/iphone-16-plus-green-512gb-25770000-6.png', '2025-04-03 05:43:43'),
(576, 64, 2, 'Pink', '2025-04-03 05:45:02'),
(577, 64, 3, '256GB', '2025-04-03 05:45:02'),
(578, 64, 4, '39990000', '2025-04-03 05:45:02'),
(579, 64, 6, 'iPhone/iPhone16/iphone-16-plus-pink-256gb-39990000-1.jpg', '2025-04-03 05:45:02'),
(580, 64, 6, 'iPhone/iPhone16/iphone-16-plus-pink-256gb-39990000-2.jpg', '2025-04-03 05:45:02'),
(581, 64, 6, 'iPhone/iPhone16/iphone-16-plus-pink-256gb-39990000-3.jpg', '2025-04-03 05:45:02'),
(582, 64, 6, 'iPhone/iPhone16/iphone-16-plus-pink-256gb-39990000-4.jpg', '2025-04-03 05:45:02'),
(583, 64, 6, 'iPhone/iPhone16/iphone-16-plus-pink-256gb-39990000-5.jpg', '2025-04-03 05:45:02'),
(584, 64, 6, 'iPhone/iPhone16/iphone-16-plus-pink-256gb-39990000-6.jpg', '2025-04-03 05:45:02'),
(585, 65, 2, 'Pink', '2025-04-03 05:46:17'),
(586, 65, 3, '1T', '2025-04-03 05:46:17'),
(587, 65, 4, '18980000', '2025-04-03 05:46:17'),
(588, 65, 6, 'iPhone/iPhone16/iphone-16-plus-pink-1t-18980000-1.jpg', '2025-04-03 05:46:17'),
(589, 65, 6, 'iPhone/iPhone16/iphone-16-plus-pink-1t-18980000-2.jpg', '2025-04-03 05:46:17'),
(590, 65, 6, 'iPhone/iPhone16/iphone-16-plus-pink-1t-18980000-3.jpg', '2025-04-03 05:46:17'),
(591, 65, 6, 'iPhone/iPhone16/iphone-16-plus-pink-1t-18980000-4.jpg', '2025-04-03 05:46:17'),
(592, 65, 6, 'iPhone/iPhone16/iphone-16-plus-pink-1t-18980000-5.jpg', '2025-04-03 05:46:17'),
(593, 66, 2, 'White', '2025-04-03 05:47:42'),
(594, 66, 3, '128GB', '2025-04-03 05:47:42'),
(595, 66, 4, '34990000', '2025-04-03 05:47:42'),
(596, 66, 6, 'iPhone/iPhone16/iphone-16-plus-white-128gb-34990000-1.jpg', '2025-04-03 05:47:42'),
(597, 66, 6, 'iPhone/iPhone16/iphone-16-plus-white-128gb-34990000-2.jpg', '2025-04-03 05:47:42'),
(598, 66, 6, 'iPhone/iPhone16/iphone-16-plus-white-128gb-34990000-3.jpg', '2025-04-03 05:47:42'),
(599, 66, 6, 'iPhone/iPhone16/iphone-16-plus-white-128gb-34990000-4.jpg', '2025-04-03 05:47:42'),
(600, 66, 6, 'iPhone/iPhone16/iphone-16-plus-white-128gb-34990000-5.jpg', '2025-04-03 05:47:42'),
(601, 67, 2, 'White', '2025-04-03 05:48:47'),
(602, 67, 3, '2T', '2025-04-03 05:48:47'),
(603, 67, 4, '34990000', '2025-04-03 05:48:47'),
(604, 67, 6, 'iPhone/iPhone16/iphone-16-plus-white-2t-34990000-1.jpg', '2025-04-03 05:48:47'),
(605, 67, 6, 'iPhone/iPhone16/iphone-16-plus-white-2t-34990000-2.jpg', '2025-04-03 05:48:47'),
(606, 67, 6, 'iPhone/iPhone16/iphone-16-plus-white-2t-34990000-3.jpg', '2025-04-03 05:48:47'),
(607, 67, 6, 'iPhone/iPhone16/iphone-16-plus-white-2t-34990000-4.jpg', '2025-04-03 05:48:47'),
(608, 67, 6, 'iPhone/iPhone16/iphone-16-plus-white-2t-34990000-5.jpg', '2025-04-03 05:48:47'),
(609, 68, 2, 'Black', '2025-04-03 05:50:20'),
(610, 68, 3, '64GB', '2025-04-03 05:50:20'),
(611, 68, 4, '21990000', '2025-04-03 05:50:20'),
(612, 68, 6, 'iPhone/iPhone16/iphone-16-pro-black-64gb-21990000-1.jpg', '2025-04-03 05:50:20'),
(613, 68, 6, 'iPhone/iPhone16/iphone-16-pro-black-64gb-21990000-2.jpg', '2025-04-03 05:50:20'),
(614, 68, 6, 'iPhone/iPhone16/iphone-16-pro-black-64gb-21990000-3.jpg', '2025-04-03 05:50:20'),
(615, 68, 6, 'iPhone/iPhone16/iphone-16-pro-black-64gb-21990000-4.jpg', '2025-04-03 05:50:20'),
(616, 68, 6, 'iPhone/iPhone16/iphone-16-pro-black-64gb-21990000-5.jpg', '2025-04-03 05:50:20'),
(617, 68, 6, 'iPhone/iPhone16/iphone-16-pro-black-64gb-21990000-6.jpg', '2025-04-03 05:50:21'),
(618, 68, 6, 'iPhone/iPhone16/iphone-16-pro-black-64gb-21990000-7.jpg', '2025-04-03 05:50:21'),
(619, 69, 2, 'Gold', '2025-04-03 05:51:33'),
(620, 69, 3, '512GB', '2025-04-03 05:51:33'),
(621, 69, 4, '37890000', '2025-04-03 05:51:33'),
(622, 69, 6, 'iPhone/iPhone16/iphone-16-pro-gold-512gb-37890000-1.jpg', '2025-04-03 05:51:33'),
(623, 69, 6, 'iPhone/iPhone16/iphone-16-pro-gold-512gb-37890000-2.jpg', '2025-04-03 05:51:33'),
(624, 69, 6, 'iPhone/iPhone16/iphone-16-pro-gold-512gb-37890000-3.jpg', '2025-04-03 05:51:33'),
(625, 69, 6, 'iPhone/iPhone16/iphone-16-pro-gold-512gb-37890000-4.jpg', '2025-04-03 05:51:33'),
(626, 69, 6, 'iPhone/iPhone16/iphone-16-pro-gold-512gb-37890000-5.jpg', '2025-04-03 05:51:33'),
(627, 70, 2, 'Nature', '2025-04-03 05:52:42'),
(628, 70, 3, '128GB', '2025-04-03 05:52:42'),
(629, 70, 4, '31880000', '2025-04-03 05:52:42'),
(630, 70, 6, 'iPhone/iPhone16/iphone-16-pro-nature-128gb-31880000-1.jpg', '2025-04-03 05:52:42'),
(631, 70, 6, 'iPhone/iPhone16/iphone-16-pro-nature-128gb-31880000-2.jpg', '2025-04-03 05:52:42'),
(632, 70, 6, 'iPhone/iPhone16/iphone-16-pro-nature-128gb-31880000-3.jpg', '2025-04-03 05:52:42'),
(633, 70, 6, 'iPhone/iPhone16/iphone-16-pro-nature-128gb-31880000-4.jpg', '2025-04-03 05:52:42'),
(634, 70, 6, 'iPhone/iPhone16/iphone-16-pro-nature-128gb-31880000-5.jpg', '2025-04-03 05:52:42'),
(635, 70, 6, 'iPhone/iPhone16/iphone-16-pro-nature-128gb-31880000-6.jpg', '2025-04-03 05:52:42'),
(636, 70, 6, 'iPhone/iPhone16/iphone-16-pro-nature-128gb-31880000-7.png', '2025-04-03 05:52:42'),
(637, 71, 2, 'White', '2025-04-03 05:53:46'),
(638, 71, 3, '1T', '2025-04-03 05:53:46'),
(639, 71, 4, '33330000', '2025-04-03 05:53:46'),
(640, 71, 6, 'iPhone/iPhone16/iphone-16-pro-white-1t-33330000-1.jpg', '2025-04-03 05:53:46'),
(641, 71, 6, 'iPhone/iPhone16/iphone-16-pro-white-1t-33330000-2.jpg', '2025-04-03 05:53:46'),
(642, 71, 6, 'iPhone/iPhone16/iphone-16-pro-white-1t-33330000-3.jpg', '2025-04-03 05:53:46'),
(643, 71, 6, 'iPhone/iPhone16/iphone-16-pro-white-1t-33330000-4.jpg', '2025-04-03 05:53:46'),
(644, 71, 6, 'iPhone/iPhone16/iphone-16-pro-white-1t-33330000-5.jpg', '2025-04-03 05:53:46'),
(645, 71, 6, 'iPhone/iPhone16/iphone-16-pro-white-1t-33330000-6.jpg', '2025-04-03 05:53:46'),
(646, 72, 2, 'Black', '2025-04-03 06:12:28'),
(647, 72, 3, '16GGB', '2025-04-03 06:12:28'),
(648, 72, 4, '41990000', '2025-04-03 06:12:28'),
(649, 72, 6, 'Mac/Mac14/macbook-pro-14-inch-m4-black-16ggb-41990000-1.jpg', '2025-04-03 06:12:28'),
(650, 72, 6, 'Mac/Mac14/macbook-pro-14-inch-m4-black-16ggb-41990000-2.jpg', '2025-04-03 06:12:28'),
(651, 72, 6, 'Mac/Mac14/macbook-pro-14-inch-m4-black-16ggb-41990000-3.jpg', '2025-04-03 06:12:28'),
(652, 72, 6, 'Mac/Mac14/macbook-pro-14-inch-m4-black-16ggb-41990000-4.jpg', '2025-04-03 06:12:28'),
(653, 73, 2, 'Black', '2025-04-03 06:13:39'),
(654, 73, 3, '512GB', '2025-04-03 06:13:39'),
(655, 73, 4, '40000000', '2025-04-03 06:13:39'),
(656, 73, 6, 'Mac/Mac14/macbook-pro-14-inch-m4-black-512gb-40000000-1.jpg', '2025-04-03 06:13:39'),
(657, 73, 6, 'Mac/Mac14/macbook-pro-14-inch-m4-black-512gb-40000000-2.jpg', '2025-04-03 06:13:39'),
(658, 73, 6, 'Mac/Mac14/macbook-pro-14-inch-m4-black-512gb-40000000-3.jpg', '2025-04-03 06:13:39'),
(659, 73, 6, 'Mac/Mac14/macbook-pro-14-inch-m4-black-512gb-40000000-4.jpg', '2025-04-03 06:13:39');
INSERT INTO `productvariantattributes` (`productVariantAttributeId`, `productVariantId`, `attributeId`, `attributeValue`, `create_at`) VALUES
(660, 73, 6, 'Mac/Mac14/macbook-pro-14-inch-m4-black-512gb-40000000-5.jpg', '2025-04-03 06:13:39'),
(661, 73, 6, 'Mac/Mac14/macbook-pro-14-inch-m4-black-512gb-40000000-6.jpg', '2025-04-03 06:13:39'),
(662, 74, 2, 'Black', '2025-04-03 06:15:44'),
(663, 74, 3, '24GB', '2025-04-03 06:15:44'),
(664, 74, 4, '68790000', '2025-04-03 06:15:44'),
(665, 74, 6, 'Mac/Mac16/macbook-pro-16-inch-m4-black-24gb-68790000-1.jpg', '2025-04-03 06:15:44'),
(666, 74, 6, 'Mac/Mac16/macbook-pro-16-inch-m4-black-24gb-68790000-2.jpg', '2025-04-03 06:15:44'),
(667, 74, 6, 'Mac/Mac16/macbook-pro-16-inch-m4-black-24gb-68790000-3.jpg', '2025-04-03 06:15:44'),
(668, 74, 6, 'Mac/Mac16/macbook-pro-16-inch-m4-black-24gb-68790000-4.jpg', '2025-04-03 06:15:44'),
(669, 74, 6, 'Mac/Mac16/macbook-pro-16-inch-m4-black-24gb-68790000-5.jpg', '2025-04-03 06:15:44'),
(670, 74, 6, 'Mac/Mac16/macbook-pro-16-inch-m4-black-24gb-68790000-6.jpg', '2025-04-03 06:15:44'),
(671, 75, 2, 'Black', '2025-04-03 06:16:55'),
(672, 75, 3, '512GB', '2025-04-03 06:16:55'),
(673, 75, 4, '68990000', '2025-04-03 06:16:55'),
(674, 75, 6, 'Mac/Mac16/macbook-pro-16-inch-m4-black-512gb-68990000-1.jpg', '2025-04-03 06:16:55'),
(675, 75, 6, 'Mac/Mac16/macbook-pro-16-inch-m4-black-512gb-68990000-2.jpg', '2025-04-03 06:16:55'),
(676, 75, 6, 'Mac/Mac16/macbook-pro-16-inch-m4-black-512gb-68990000-3.jpg', '2025-04-03 06:16:55'),
(677, 75, 6, 'Mac/Mac16/macbook-pro-16-inch-m4-black-512gb-68990000-4.jpg', '2025-04-03 06:16:55'),
(678, 75, 6, 'Mac/Mac16/macbook-pro-16-inch-m4-black-512gb-68990000-5.jpg', '2025-04-03 06:16:55'),
(679, 75, 6, 'Mac/Mac16/macbook-pro-16-inch-m4-black-512gb-68990000-6.jpg', '2025-04-03 06:16:55'),
(680, 76, 2, 'Black', '2025-04-03 06:18:20'),
(681, 76, 3, '8GB', '2025-04-03 06:18:20'),
(682, 76, 4, '19990000', '2025-04-03 06:18:20'),
(683, 76, 6, 'Mac/Mac13/macbook-air-13-inch-m1-black-8gb-19990000-1.jpg', '2025-04-03 06:18:20'),
(684, 76, 6, 'Mac/Mac13/macbook-air-13-inch-m1-black-8gb-19990000-2.jpg', '2025-04-03 06:18:20'),
(685, 76, 6, 'Mac/Mac13/macbook-air-13-inch-m1-black-8gb-19990000-3.jpg', '2025-04-03 06:18:20'),
(686, 76, 6, 'Mac/Mac13/macbook-air-13-inch-m1-black-8gb-19990000-4.jpg', '2025-04-03 06:18:20'),
(687, 77, 2, 'White', '2025-04-03 06:19:29'),
(688, 77, 3, '256GB', '2025-04-03 06:19:29'),
(689, 77, 4, '19990000', '2025-04-03 06:19:29'),
(690, 77, 6, 'Mac/Mac13/macbook-air-13-inch-m1-white-256gb-19990000-1.jpg', '2025-04-03 06:19:29'),
(691, 77, 6, 'Mac/Mac13/macbook-air-13-inch-m1-white-256gb-19990000-2.jpg', '2025-04-03 06:19:29'),
(692, 77, 6, 'Mac/Mac13/macbook-air-13-inch-m1-white-256gb-19990000-3.jpg', '2025-04-03 06:19:29'),
(693, 77, 6, 'Mac/Mac13/macbook-air-13-inch-m1-white-256gb-19990000-4.jpg', '2025-04-03 06:19:29'),
(694, 78, 2, 'Navy', '2025-04-03 06:21:13'),
(695, 78, 3, '16GB', '2025-04-03 06:21:13'),
(696, 78, 4, '24990000', '2025-04-03 06:21:13'),
(697, 78, 6, 'Mac/Mac13/macbook-air-13-inch-m2-navy-16gb-24990000-1.jpg', '2025-04-03 06:21:13'),
(698, 78, 6, 'Mac/Mac13/macbook-air-13-inch-m2-navy-16gb-24990000-2.jpg', '2025-04-03 06:21:13'),
(699, 78, 6, 'Mac/Mac13/macbook-air-13-inch-m2-navy-16gb-24990000-3.jpg', '2025-04-03 06:21:13'),
(700, 78, 6, 'Mac/Mac13/macbook-air-13-inch-m2-navy-16gb-24990000-4.jpg', '2025-04-03 06:21:13'),
(701, 79, 2, 'Navy', '2025-04-03 06:22:12'),
(702, 79, 3, '256GB', '2025-04-03 06:22:12'),
(703, 79, 4, '24990000', '2025-04-03 06:22:12'),
(704, 79, 6, 'Mac/Mac13/macbook-air-13-inch-m2-navy-256gb-24990000-1.jpg', '2025-04-03 06:22:12'),
(705, 79, 6, 'Mac/Mac13/macbook-air-13-inch-m2-navy-256gb-24990000-2.jpg', '2025-04-03 06:22:12'),
(706, 79, 6, 'Mac/Mac13/macbook-air-13-inch-m2-navy-256gb-24990000-3.jpg', '2025-04-03 06:22:12'),
(707, 79, 6, 'Mac/Mac13/macbook-air-13-inch-m2-navy-256gb-24990000-4.jpg', '2025-04-03 06:22:12'),
(708, 79, 6, 'Mac/Mac13/macbook-air-13-inch-m2-navy-256gb-24990000-5.jpg', '2025-04-03 06:22:12'),
(709, 80, 2, 'Sliver', '2025-04-03 06:23:50'),
(710, 80, 3, '16GB', '2025-04-03 06:23:50'),
(711, 80, 4, '32990000', '2025-04-03 06:23:50'),
(712, 80, 6, 'Mac/Mac13/macbook-air-13-inch-m2-sliver-16gb-32990000-1.jpg', '2025-04-03 06:23:50'),
(713, 80, 6, 'Mac/Mac13/macbook-air-13-inch-m2-sliver-16gb-32990000-2.jpg', '2025-04-03 06:23:50'),
(714, 80, 6, 'Mac/Mac13/macbook-air-13-inch-m2-sliver-16gb-32990000-3.jpg', '2025-04-03 06:23:50'),
(715, 80, 6, 'Mac/Mac13/macbook-air-13-inch-m2-sliver-16gb-32990000-4.jpg', '2025-04-03 06:23:50'),
(716, 80, 6, 'Mac/Mac13/macbook-air-13-inch-m2-sliver-16gb-32990000-5.jpg', '2025-04-03 06:23:50'),
(717, 80, 6, 'Mac/Mac13/macbook-air-13-inch-m2-sliver-16gb-32990000-6.jpg', '2025-04-03 06:23:50'),
(718, 81, 2, 'Sliver', '2025-04-03 06:24:39'),
(719, 81, 3, '256GB', '2025-04-03 06:24:39'),
(720, 81, 4, '29990000', '2025-04-03 06:24:39'),
(721, 81, 6, 'Mac/Mac13/macbook-air-13-inch-m2-sliver-256gb-29990000-1.jpg', '2025-04-03 06:24:39'),
(722, 81, 6, 'Mac/Mac13/macbook-air-13-inch-m2-sliver-256gb-29990000-2.jpg', '2025-04-03 06:24:39'),
(723, 81, 6, 'Mac/Mac13/macbook-air-13-inch-m2-sliver-256gb-29990000-3.jpg', '2025-04-03 06:24:39'),
(724, 81, 6, 'Mac/Mac13/macbook-air-13-inch-m2-sliver-256gb-29990000-4.jpg', '2025-04-03 06:24:39'),
(725, 82, 2, 'White', '2025-04-03 06:25:41'),
(726, 82, 3, '16GB', '2025-04-03 06:25:41'),
(727, 82, 4, '27880000', '2025-04-03 06:25:41'),
(728, 82, 6, 'Mac/Mac13/macbook-air-13-inch-m2-white-16gb-27880000-1.jpg', '2025-04-03 06:25:41'),
(729, 82, 6, 'Mac/Mac13/macbook-air-13-inch-m2-white-16gb-27880000-2.jpg', '2025-04-03 06:25:41'),
(730, 82, 6, 'Mac/Mac13/macbook-air-13-inch-m2-white-16gb-27880000-3.jpg', '2025-04-03 06:25:41'),
(731, 82, 6, 'Mac/Mac13/macbook-air-13-inch-m2-white-16gb-27880000-4.jpg', '2025-04-03 06:25:41'),
(732, 82, 6, 'Mac/Mac13/macbook-air-13-inch-m2-white-16gb-27880000-5.jpg', '2025-04-03 06:25:41'),
(733, 83, 2, 'White', '2025-04-03 06:26:33'),
(734, 83, 3, '256GB', '2025-04-03 06:26:33'),
(735, 83, 4, '28990000', '2025-04-03 06:26:33'),
(736, 83, 6, 'Mac/Mac13/macbook-air-13-inch-m2-white-256gb-28990000-1.jpg', '2025-04-03 06:26:33'),
(737, 83, 6, 'Mac/Mac13/macbook-air-13-inch-m2-white-256gb-28990000-2.jpg', '2025-04-03 06:26:33'),
(738, 83, 6, 'Mac/Mac13/macbook-air-13-inch-m2-white-256gb-28990000-3.jpg', '2025-04-03 06:26:33'),
(739, 83, 6, 'Mac/Mac13/macbook-air-13-inch-m2-white-256gb-28990000-4.jpg', '2025-04-03 06:26:33'),
(740, 84, 2, 'Green', '2025-04-03 13:25:18'),
(741, 84, 3, '128GB', '2025-04-03 13:25:18'),
(742, 84, 4, '28980000', '2025-04-03 13:25:18'),
(743, 84, 6, 'Mac/Mac13/macbook-air-13-inch-m3-green-128gb-28980000-1.jpg', '2025-04-03 13:25:18'),
(744, 84, 6, 'Mac/Mac13/macbook-air-13-inch-m3-green-128gb-28980000-2.jpg', '2025-04-03 13:25:18'),
(745, 84, 6, 'Mac/Mac13/macbook-air-13-inch-m3-green-128gb-28980000-3.jpg', '2025-04-03 13:25:18'),
(746, 84, 6, 'Mac/Mac13/macbook-air-13-inch-m3-green-128gb-28980000-4.jpg', '2025-04-03 13:25:18'),
(747, 84, 6, 'Mac/Mac13/macbook-air-13-inch-m3-green-128gb-28980000-5.jpg', '2025-04-03 13:25:18'),
(748, 84, 6, 'Mac/Mac13/macbook-air-13-inch-m3-green-128gb-28980000-6.jpg', '2025-04-03 13:25:18'),
(749, 85, 2, 'Black', '2025-04-03 13:26:59'),
(750, 85, 3, '512GB', '2025-04-03 13:26:59'),
(751, 85, 4, '32660000', '2025-04-03 13:26:59'),
(752, 85, 6, 'Mac/Mac13/macbook-air-13-inch-m3-black-512gb-32660000-1.jpg', '2025-04-03 13:26:59'),
(753, 85, 6, 'Mac/Mac13/macbook-air-13-inch-m3-black-512gb-32660000-2.jpg', '2025-04-03 13:26:59'),
(754, 85, 6, 'Mac/Mac13/macbook-air-13-inch-m3-black-512gb-32660000-3.jpg', '2025-04-03 13:26:59'),
(755, 85, 6, 'Mac/Mac13/macbook-air-13-inch-m3-black-512gb-32660000-4.jpg', '2025-04-03 13:26:59'),
(756, 85, 6, 'Mac/Mac13/macbook-air-13-inch-m3-black-512gb-32660000-5.jpg', '2025-04-03 13:26:59'),
(757, 85, 6, 'Mac/Mac13/macbook-air-13-inch-m3-black-512gb-32660000-6.jpg', '2025-04-03 13:26:59'),
(758, 86, 2, 'Gold', '2025-04-03 13:28:46'),
(759, 86, 3, '32GB', '2025-04-03 13:28:46'),
(760, 86, 4, '59990000', '2025-04-03 13:28:46'),
(761, 86, 6, 'Mac/Mac15/macbook-air-15-inch-m3-gold-32gb-59990000-1.jpg', '2025-04-03 13:28:46'),
(762, 86, 6, 'Mac/Mac15/macbook-air-15-inch-m3-gold-32gb-59990000-2.jpg', '2025-04-03 13:28:46'),
(763, 86, 6, 'Mac/Mac15/macbook-air-15-inch-m3-gold-32gb-59990000-3.jpg', '2025-04-03 13:28:46'),
(764, 87, 2, 'Gold', '2025-04-03 13:29:51'),
(765, 87, 3, '512GB', '2025-04-03 13:29:51'),
(766, 87, 4, '79880000', '2025-04-03 13:29:51'),
(767, 87, 6, 'Mac/Mac15/macbook-air-15-inch-m3-gold-512gb-79880000-1.jpg', '2025-04-03 13:29:51'),
(768, 87, 6, 'Mac/Mac15/macbook-air-15-inch-m3-gold-512gb-79880000-2.jpg', '2025-04-03 13:29:51'),
(769, 87, 6, 'Mac/Mac15/macbook-air-15-inch-m3-gold-512gb-79880000-3.jpg', '2025-04-03 13:29:51'),
(770, 87, 6, 'Mac/Mac15/macbook-air-15-inch-m3-gold-512gb-79880000-4.jpg', '2025-04-03 13:29:51'),
(771, 87, 6, 'Mac/Mac15/macbook-air-15-inch-m3-gold-512gb-79880000-5.jpg', '2025-04-03 13:29:51'),
(772, 88, 2, 'Navy', '2025-04-03 13:30:52'),
(773, 88, 3, '32GB', '2025-04-03 13:30:52'),
(774, 88, 4, '47770000', '2025-04-03 13:30:52'),
(775, 88, 6, 'Mac/Mac15/macbook-air-15-inch-m3-navy-32gb-47770000-1.jpg', '2025-04-03 13:30:52'),
(776, 88, 6, 'Mac/Mac15/macbook-air-15-inch-m3-navy-32gb-47770000-2.jpg', '2025-04-03 13:30:52'),
(777, 88, 6, 'Mac/Mac15/macbook-air-15-inch-m3-navy-32gb-47770000-3.jpg', '2025-04-03 13:30:52'),
(778, 89, 2, 'Navy', '2025-04-03 13:32:20'),
(779, 89, 3, '512GB', '2025-04-03 13:32:20'),
(780, 89, 4, '67670000', '2025-04-03 13:32:20'),
(781, 89, 6, 'Mac/Mac15/macbook-air-15-inch-m3-navy-512gb-67670000-1.jpg', '2025-04-03 13:32:20'),
(782, 89, 6, 'Mac/Mac15/macbook-air-15-inch-m3-navy-512gb-67670000-2.jpg', '2025-04-03 13:32:20'),
(783, 89, 6, 'Mac/Mac15/macbook-air-15-inch-m3-navy-512gb-67670000-3.jpg', '2025-04-03 13:32:20'),
(784, 89, 6, 'Mac/Mac15/macbook-air-15-inch-m3-navy-512gb-67670000-4.jpg', '2025-04-03 13:32:20'),
(785, 90, 2, 'Sliver', '2025-04-03 13:33:36'),
(786, 90, 3, '32GB', '2025-04-03 13:33:36'),
(787, 90, 4, '66990000', '2025-04-03 13:33:36'),
(788, 90, 6, 'Mac/Mac15/macbook-air-15-inch-m3-sliver-32gb-66990000-1.jpg', '2025-04-03 13:33:36'),
(789, 90, 6, 'Mac/Mac15/macbook-air-15-inch-m3-sliver-32gb-66990000-2.jpg', '2025-04-03 13:33:36'),
(790, 90, 6, 'Mac/Mac15/macbook-air-15-inch-m3-sliver-32gb-66990000-3.jpg', '2025-04-03 13:33:36'),
(791, 90, 6, 'Mac/Mac15/macbook-air-15-inch-m3-sliver-32gb-66990000-4.jpg', '2025-04-03 13:33:36'),
(792, 91, 2, 'Blue', '2025-04-03 13:35:35'),
(793, 91, 3, '256GB', '2025-04-03 13:35:35'),
(794, 91, 4, '39990000', '2025-04-03 13:35:35'),
(795, 91, 6, 'Mac/Mac24/imac-24-inch-m4-blue-256gb-39990000-1.jpg', '2025-04-03 13:35:35'),
(796, 91, 6, 'Mac/Mac24/imac-24-inch-m4-blue-256gb-39990000-2.jpg', '2025-04-03 13:35:35'),
(797, 91, 6, 'Mac/Mac24/imac-24-inch-m4-blue-256gb-39990000-3.jpg', '2025-04-03 13:35:35'),
(798, 91, 6, 'Mac/Mac24/imac-24-inch-m4-blue-256gb-39990000-4.jpg', '2025-04-03 13:35:35'),
(799, 91, 6, 'Mac/Mac24/imac-24-inch-m4-blue-256gb-39990000-5.jpg', '2025-04-03 13:35:35'),
(800, 91, 6, 'Mac/Mac24/imac-24-inch-m4-blue-256gb-39990000-6.jpg', '2025-04-03 13:35:35'),
(801, 92, 2, 'Green', '2025-04-03 13:36:36'),
(802, 92, 3, '512GB', '2025-04-03 13:36:36'),
(803, 92, 4, '65560000', '2025-04-03 13:36:36'),
(804, 92, 6, 'Mac/Mac24/imac-24-inch-m4-green-512gb-65560000-1.jpg', '2025-04-03 13:36:36'),
(805, 92, 6, 'Mac/Mac24/imac-24-inch-m4-green-512gb-65560000-2.jpg', '2025-04-03 13:36:36'),
(806, 92, 6, 'Mac/Mac24/imac-24-inch-m4-green-512gb-65560000-3.jpg', '2025-04-03 13:36:36'),
(807, 92, 6, 'Mac/Mac24/imac-24-inch-m4-green-512gb-65560000-4.jpg', '2025-04-03 13:36:36'),
(808, 93, 2, 'Pink', '2025-04-03 13:37:37'),
(809, 93, 3, '512GB', '2025-04-03 13:37:37'),
(810, 93, 4, '31990000', '2025-04-03 13:37:37'),
(811, 93, 6, 'Mac/Mac24/imac-24-inch-m4-pink-512gb-31990000-1.jpg', '2025-04-03 13:37:37'),
(812, 93, 6, 'Mac/Mac24/imac-24-inch-m4-pink-512gb-31990000-2.jpg', '2025-04-03 13:37:37'),
(813, 93, 6, 'Mac/Mac24/imac-24-inch-m4-pink-512gb-31990000-3.jpg', '2025-04-03 13:37:37'),
(814, 93, 6, 'Mac/Mac24/imac-24-inch-m4-pink-512gb-31990000-4.jpg', '2025-04-03 13:37:37'),
(815, 94, 2, 'White', '2025-04-03 13:39:25'),
(816, 94, 3, '48GB', '2025-04-03 13:39:25'),
(817, 94, 4, '51990000', '2025-04-03 13:39:25'),
(818, 94, 6, 'Mac/Mac4/mac-mini-m4-pro-white-48gb-51990000-1.jpg', '2025-04-03 13:39:25'),
(819, 94, 6, 'Mac/Mac4/mac-mini-m4-pro-white-48gb-51990000-2.jpg', '2025-04-03 13:39:25'),
(820, 94, 6, 'Mac/Mac4/mac-mini-m4-pro-white-48gb-51990000-3.jpg', '2025-04-03 13:39:25'),
(821, 95, 2, 'Green', '2025-04-03 13:40:35'),
(822, 95, 3, '1TB', '2025-04-03 13:40:35'),
(823, 95, 4, '66000000', '2025-04-03 13:40:35'),
(824, 95, 6, 'Mac/Mac4/mac-mini-m4-pro-green-1tb-66000000-1.jpg', '2025-04-03 13:40:35'),
(825, 95, 6, 'Mac/Mac4/mac-mini-m4-pro-green-1tb-66000000-2.jpg', '2025-04-03 13:40:35'),
(826, 95, 6, 'Mac/Mac4/mac-mini-m4-pro-green-1tb-66000000-3.jpg', '2025-04-03 13:40:35'),
(827, 95, 6, 'Mac/Mac4/mac-mini-m4-pro-green-1tb-66000000-4.jpg', '2025-04-03 13:40:35'),
(828, 96, 2, 'White', '2025-04-03 13:41:57'),
(829, 96, 3, '24GB', '2025-04-03 13:41:57'),
(830, 96, 4, '27790000', '2025-04-03 13:41:57'),
(831, 96, 6, 'Mac/Mac4/mac-mini-m4-white-24gb-27790000-1.jpg', '2025-04-03 13:41:57'),
(832, 96, 6, 'Mac/Mac4/mac-mini-m4-white-24gb-27790000-2.jpg', '2025-04-03 13:41:57'),
(833, 96, 6, 'Mac/Mac4/mac-mini-m4-white-24gb-27790000-3.jpg', '2025-04-03 13:41:57'),
(834, 97, 2, 'Nature', '2025-04-03 13:43:11'),
(835, 97, 3, '256GB', '2025-04-03 13:43:11'),
(836, 97, 4, '21210000', '2025-04-03 13:43:11'),
(837, 97, 6, 'Mac/Mac4/mac-mini-m4-nature-256gb-21210000-1.jpg', '2025-04-03 13:43:11'),
(838, 97, 6, 'Mac/Mac4/mac-mini-m4-nature-256gb-21210000-2.jpg', '2025-04-03 13:43:11'),
(839, 97, 6, 'Mac/Mac4/mac-mini-m4-nature-256gb-21210000-3.jpg', '2025-04-03 13:43:11'),
(840, 97, 6, 'Mac/Mac4/mac-mini-m4-nature-256gb-21210000-4.jpg', '2025-04-03 13:43:11'),
(841, 97, 6, 'Mac/Mac4/mac-mini-m4-nature-256gb-21210000-5.jpg', '2025-04-03 13:43:11'),
(842, 98, 2, 'Black', '2025-04-03 13:45:14'),
(843, 98, 3, '256GB', '2025-04-03 13:45:14'),
(844, 98, 4, '28990000', '2025-04-03 13:45:14'),
(845, 98, 6, 'iPad/iPad4/ipad-pro-m4-11-inch-black-256gb-28990000-1.jpg', '2025-04-03 13:45:14'),
(846, 98, 6, 'iPad/iPad4/ipad-pro-m4-11-inch-black-256gb-28990000-2.jpg', '2025-04-03 13:45:14'),
(847, 98, 6, 'iPad/iPad4/ipad-pro-m4-11-inch-black-256gb-28990000-3.jpg', '2025-04-03 13:45:14'),
(848, 98, 6, 'iPad/iPad4/ipad-pro-m4-11-inch-black-256gb-28990000-4.jpg', '2025-04-03 13:45:14'),
(849, 98, 6, 'iPad/iPad4/ipad-pro-m4-11-inch-black-256gb-28990000-5.jpg', '2025-04-03 13:45:14'),
(850, 99, 2, 'White', '2025-04-03 13:46:26'),
(851, 99, 3, '256GB', '2025-04-03 13:46:26'),
(852, 99, 4, '29990000', '2025-04-03 13:46:26'),
(853, 99, 6, 'iPad/iPad4/ipad-pro-m4-11-inch-white-256gb-29990000-1.jpg', '2025-04-03 13:46:26'),
(854, 99, 6, 'iPad/iPad4/ipad-pro-m4-11-inch-white-256gb-29990000-2.jpg', '2025-04-03 13:46:26'),
(855, 99, 6, 'iPad/iPad4/ipad-pro-m4-11-inch-white-256gb-29990000-3.jpg', '2025-04-03 13:46:26'),
(856, 99, 6, 'iPad/iPad4/ipad-pro-m4-11-inch-white-256gb-29990000-4.jpg', '2025-04-03 13:46:26'),
(857, 99, 6, 'iPad/iPad4/ipad-pro-m4-11-inch-white-256gb-29990000-5.jpg', '2025-04-03 13:46:26'),
(858, 99, 6, 'iPad/iPad4/ipad-pro-m4-11-inch-white-256gb-29990000-6.jpg', '2025-04-03 13:46:26'),
(859, 100, 2, 'Black', '2025-04-03 13:48:30'),
(860, 100, 3, '512GB', '2025-04-03 13:48:30'),
(861, 100, 4, '32990000', '2025-04-03 13:48:30'),
(862, 100, 6, 'iPad/iPad4/ipad-pro-m4-13-inch-black-512gb-32990000-1.jpg', '2025-04-03 13:48:30'),
(863, 100, 6, 'iPad/iPad4/ipad-pro-m4-13-inch-black-512gb-32990000-2.jpg', '2025-04-03 13:48:30'),
(864, 100, 6, 'iPad/iPad4/ipad-pro-m4-13-inch-black-512gb-32990000-3.jpg', '2025-04-03 13:48:30'),
(865, 100, 6, 'iPad/iPad4/ipad-pro-m4-13-inch-black-512gb-32990000-4.jpg', '2025-04-03 13:48:30'),
(866, 100, 6, 'iPad/iPad4/ipad-pro-m4-13-inch-black-512gb-32990000-5.jpg', '2025-04-03 13:48:30'),
(867, 100, 6, 'iPad/iPad4/ipad-pro-m4-13-inch-black-512gb-32990000-6.jpg', '2025-04-03 13:48:30'),
(868, 100, 6, 'iPad/iPad4/ipad-pro-m4-13-inch-black-512gb-32990000-7.jpg', '2025-04-03 13:48:30'),
(869, 100, 6, 'iPad/iPad4/ipad-pro-m4-13-inch-black-512gb-32990000-8.jpg', '2025-04-03 13:48:30'),
(870, 101, 2, 'White', '2025-04-03 13:49:36'),
(871, 101, 3, '1TB', '2025-04-03 13:49:36'),
(872, 101, 4, '44990000', '2025-04-03 13:49:36'),
(873, 101, 6, 'iPad/iPad4/ipad-pro-m4-13-inch-white-1tb-44990000-1.jpg', '2025-04-03 13:49:36'),
(874, 101, 6, 'iPad/iPad4/ipad-pro-m4-13-inch-white-1tb-44990000-2.jpg', '2025-04-03 13:49:36'),
(875, 101, 6, 'iPad/iPad4/ipad-pro-m4-13-inch-white-1tb-44990000-3.jpg', '2025-04-03 13:49:36'),
(876, 101, 6, 'iPad/iPad4/ipad-pro-m4-13-inch-white-1tb-44990000-4.jpg', '2025-04-03 13:49:36'),
(877, 101, 6, 'iPad/iPad4/ipad-pro-m4-13-inch-white-1tb-44990000-5.jpg', '2025-04-03 13:49:36'),
(878, 101, 6, 'iPad/iPad4/ipad-pro-m4-13-inch-white-1tb-44990000-6.jpg', '2025-04-03 13:49:36'),
(879, 102, 2, 'Blue', '2025-04-03 13:51:42'),
(880, 102, 3, '128GB', '2025-04-03 13:51:42'),
(881, 102, 4, '17990000', '2025-04-03 13:51:42'),
(882, 102, 6, 'iPad/iPad2/ipad-air-m2-11-inch-blue-128gb-17990000-1.jpg', '2025-04-03 13:51:42'),
(883, 102, 6, 'iPad/iPad2/ipad-air-m2-11-inch-blue-128gb-17990000-2.jpg', '2025-04-03 13:51:42'),
(884, 102, 6, 'iPad/iPad2/ipad-air-m2-11-inch-blue-128gb-17990000-3.jpg', '2025-04-03 13:51:42'),
(885, 102, 6, 'iPad/iPad2/ipad-air-m2-11-inch-blue-128gb-17990000-4.jpg', '2025-04-03 13:51:42'),
(886, 102, 6, 'iPad/iPad2/ipad-air-m2-11-inch-blue-128gb-17990000-5.jpg', '2025-04-03 13:51:42'),
(887, 103, 2, 'Sliver', '2025-04-03 13:52:49'),
(888, 103, 3, '128GB', '2025-04-03 13:52:49'),
(889, 103, 4, '32990900', '2025-04-03 13:52:49'),
(890, 103, 6, 'iPad/iPad2/ipad-air-m2-11-inch-sliver-128gb-32990900-1.jpg', '2025-04-03 13:52:49'),
(891, 103, 6, 'iPad/iPad2/ipad-air-m2-11-inch-sliver-128gb-32990900-2.jpg', '2025-04-03 13:52:49'),
(892, 103, 6, 'iPad/iPad2/ipad-air-m2-11-inch-sliver-128gb-32990900-3.jpg', '2025-04-03 13:52:49'),
(893, 103, 6, 'iPad/iPad2/ipad-air-m2-11-inch-sliver-128gb-32990900-4.jpg', '2025-04-03 13:52:49'),
(894, 103, 6, 'iPad/iPad2/ipad-air-m2-11-inch-sliver-128gb-32990900-5.jpg', '2025-04-03 13:52:49'),
(895, 104, 2, 'Yellow', '2025-04-03 13:54:04'),
(896, 104, 3, '256GB', '2025-04-03 13:54:04'),
(897, 104, 4, '21000000', '2025-04-03 13:54:04'),
(898, 104, 6, 'iPad/iPad2/ipad-air-m2-11-inch-yellow-256gb-21000000-1.jpg', '2025-04-03 13:54:04'),
(899, 104, 6, 'iPad/iPad2/ipad-air-m2-11-inch-yellow-256gb-21000000-2.jpg', '2025-04-03 13:54:04'),
(900, 104, 6, 'iPad/iPad2/ipad-air-m2-11-inch-yellow-256gb-21000000-3.jpg', '2025-04-03 13:54:04'),
(901, 104, 6, 'iPad/iPad2/ipad-air-m2-11-inch-yellow-256gb-21000000-4.jpg', '2025-04-03 13:54:04'),
(902, 104, 6, 'iPad/iPad2/ipad-air-m2-11-inch-yellow-256gb-21000000-5.jpg', '2025-04-03 13:54:04'),
(903, 104, 6, 'iPad/iPad2/ipad-air-m2-11-inch-yellow-256gb-21000000-6.jpg', '2025-04-03 13:54:04'),
(904, 105, 2, 'Blue', '2025-04-03 13:55:48'),
(905, 105, 3, '256GB', '2025-04-03 13:55:48'),
(906, 105, 4, '31770000', '2025-04-03 13:55:48'),
(907, 105, 6, 'iPad/iPad2/ipad-air-m2-13-inch-blue-256gb-31770000-1.jpg', '2025-04-03 13:55:48'),
(908, 105, 6, 'iPad/iPad2/ipad-air-m2-13-inch-blue-256gb-31770000-2.jpg', '2025-04-03 13:55:48'),
(909, 105, 6, 'iPad/iPad2/ipad-air-m2-13-inch-blue-256gb-31770000-3.jpg', '2025-04-03 13:55:48'),
(910, 105, 6, 'iPad/iPad2/ipad-air-m2-13-inch-blue-256gb-31770000-4.jpg', '2025-04-03 13:55:48'),
(911, 106, 2, 'Sliver', '2025-04-03 13:56:48'),
(912, 106, 3, '512GB', '2025-04-03 13:56:48'),
(913, 106, 4, '42330000', '2025-04-03 13:56:48'),
(914, 106, 6, 'iPad/iPad2/ipad-air-m2-13-inch-sliver-512gb-42330000-1.jpg', '2025-04-03 13:56:48'),
(915, 106, 6, 'iPad/iPad2/ipad-air-m2-13-inch-sliver-512gb-42330000-2.jpg', '2025-04-03 13:56:48'),
(916, 106, 6, 'iPad/iPad2/ipad-air-m2-13-inch-sliver-512gb-42330000-3.jpg', '2025-04-03 13:56:48'),
(917, 106, 6, 'iPad/iPad2/ipad-air-m2-13-inch-sliver-512gb-42330000-4.jpg', '2025-04-03 13:56:48'),
(918, 106, 6, 'iPad/iPad2/ipad-air-m2-13-inch-sliver-512gb-42330000-5.jpg', '2025-04-03 13:56:48'),
(919, 107, 2, 'White', '2025-04-03 13:58:02'),
(920, 107, 3, '128GB', '2025-04-03 13:58:02'),
(921, 107, 4, '25990000', '2025-04-03 13:58:02'),
(922, 107, 6, 'iPad/iPad2/ipad-air-m2-13-inch-white-128gb-25990000-1.jpg', '2025-04-03 13:58:02'),
(923, 107, 6, 'iPad/iPad2/ipad-air-m2-13-inch-white-128gb-25990000-2.jpg', '2025-04-03 13:58:02'),
(924, 107, 6, 'iPad/iPad2/ipad-air-m2-13-inch-white-128gb-25990000-3.jpg', '2025-04-03 13:58:02'),
(925, 107, 6, 'iPad/iPad2/ipad-air-m2-13-inch-white-128gb-25990000-4.jpg', '2025-04-03 13:58:02'),
(926, 107, 6, 'iPad/iPad2/ipad-air-m2-13-inch-white-128gb-25990000-5.jpg', '2025-04-03 13:58:02'),
(927, 108, 2, 'Blue', '2025-04-03 14:00:00'),
(928, 108, 3, '64GB', '2025-04-03 14:00:00'),
(929, 108, 4, '11490000', '2025-04-03 14:00:00'),
(930, 108, 6, 'iPad/iPad10/ipad-10-blue-64gb-11490000-1.jpg', '2025-04-03 14:00:00'),
(931, 108, 6, 'iPad/iPad10/ipad-10-blue-64gb-11490000-2.jpg', '2025-04-03 14:00:00'),
(932, 108, 6, 'iPad/iPad10/ipad-10-blue-64gb-11490000-3.jpg', '2025-04-03 14:00:00'),
(933, 108, 6, 'iPad/iPad10/ipad-10-blue-64gb-11490000-4.jpg', '2025-04-03 14:00:00'),
(934, 108, 6, 'iPad/iPad10/ipad-10-blue-64gb-11490000-5.jpg', '2025-04-03 14:00:00'),
(935, 109, 2, 'Red', '2025-04-03 14:01:33'),
(936, 109, 3, '32GB', '2025-04-03 14:01:33'),
(937, 109, 4, '11220000', '2025-04-03 14:01:33'),
(938, 109, 6, 'iPad/iPad10/ipad-10-red-32gb-11220000-1.jpg', '2025-04-03 14:01:33'),
(939, 109, 6, 'iPad/iPad10/ipad-10-red-32gb-11220000-2.jpg', '2025-04-03 14:01:33'),
(940, 109, 6, 'iPad/iPad10/ipad-10-red-32gb-11220000-3.jpg', '2025-04-03 14:01:33'),
(941, 109, 6, 'iPad/iPad10/ipad-10-red-32gb-11220000-4.jpg', '2025-04-03 14:01:33'),
(942, 109, 6, 'iPad/iPad10/ipad-10-red-32gb-11220000-5.jpg', '2025-04-03 14:01:33'),
(943, 110, 2, 'Sliver', '2025-04-03 14:02:43'),
(944, 110, 3, '1TB', '2025-04-03 14:02:43'),
(945, 110, 4, '12990000', '2025-04-03 14:02:43'),
(946, 110, 6, 'iPad/iPad10/ipad-10-sliver-1tb-12990000-1.jpg', '2025-04-03 14:02:43'),
(947, 110, 6, 'iPad/iPad10/ipad-10-sliver-1tb-12990000-2.jpg', '2025-04-03 14:02:43'),
(948, 110, 6, 'iPad/iPad10/ipad-10-sliver-1tb-12990000-3.jpg', '2025-04-03 14:02:43'),
(949, 110, 6, 'iPad/iPad10/ipad-10-sliver-1tb-12990000-4.jpg', '2025-04-03 14:02:43'),
(950, 110, 6, 'iPad/iPad10/ipad-10-sliver-1tb-12990000-5.jpg', '2025-04-03 14:02:43'),
(951, 111, 2, 'Yellow', '2025-04-03 14:04:01'),
(952, 111, 3, '256GB', '2025-04-03 14:04:01'),
(953, 111, 4, '12990000', '2025-04-03 14:04:01'),
(954, 111, 6, 'iPad/iPad10/ipad-10-yellow-256gb-12990000-1.jpg', '2025-04-03 14:04:01'),
(955, 111, 6, 'iPad/iPad10/ipad-10-yellow-256gb-12990000-2.jpg', '2025-04-03 14:04:01'),
(956, 111, 6, 'iPad/iPad10/ipad-10-yellow-256gb-12990000-3.jpg', '2025-04-03 14:04:01'),
(957, 111, 6, 'iPad/iPad10/ipad-10-yellow-256gb-12990000-4.jpg', '2025-04-03 14:04:01'),
(958, 111, 6, 'iPad/iPad10/ipad-10-yellow-256gb-12990000-5.jpg', '2025-04-03 14:04:01'),
(959, 111, 6, 'iPad/iPad10/ipad-10-yellow-256gb-12990000-6.jpg', '2025-04-03 14:04:01'),
(960, 112, 2, 'White', '2025-04-03 14:05:30'),
(961, 112, 3, '64GB', '2025-04-03 14:05:30'),
(962, 112, 4, '13990000', '2025-04-03 14:05:30'),
(963, 112, 6, 'iPad/iPad7/ipad-mini-7-white-64gb-13990000-1.jpg', '2025-04-03 14:05:30'),
(964, 112, 6, 'iPad/iPad7/ipad-mini-7-white-64gb-13990000-2.jpg', '2025-04-03 14:05:30'),
(965, 112, 6, 'iPad/iPad7/ipad-mini-7-white-64gb-13990000-3.jpg', '2025-04-03 14:05:30'),
(966, 112, 6, 'iPad/iPad7/ipad-mini-7-white-64gb-13990000-4.jpg', '2025-04-03 14:05:30'),
(967, 112, 6, 'iPad/iPad7/ipad-mini-7-white-64gb-13990000-5.jpg', '2025-04-03 14:05:30'),
(968, 113, 2, 'Nature', '2025-04-03 14:06:47'),
(969, 113, 3, '1TB', '2025-04-03 14:06:47'),
(970, 113, 4, '16990000', '2025-04-03 14:06:47'),
(971, 113, 6, 'iPad/iPad7/ipad-mini-7-nature-1tb-16990000-1.jpg', '2025-04-03 14:06:47'),
(972, 113, 6, 'iPad/iPad7/ipad-mini-7-nature-1tb-16990000-2.png', '2025-04-03 14:06:47'),
(973, 113, 6, 'iPad/iPad7/ipad-mini-7-nature-1tb-16990000-3.jpg', '2025-04-03 14:06:47'),
(974, 113, 6, 'iPad/iPad7/ipad-mini-7-nature-1tb-16990000-4.jpg', '2025-04-03 14:06:47'),
(975, 113, 6, 'iPad/iPad7/ipad-mini-7-nature-1tb-16990000-5.jpg', '2025-04-03 14:06:47'),
(976, 113, 6, 'iPad/iPad7/ipad-mini-7-nature-1tb-16990000-6.jpg', '2025-04-03 14:06:47'),
(977, 113, 6, 'iPad/iPad7/ipad-mini-7-nature-1tb-16990000-7.jpg', '2025-04-03 14:06:47'),
(978, 114, 2, 'White', '2025-04-03 14:08:07'),
(979, 114, 3, '512GB', '2025-04-03 14:08:07'),
(980, 114, 4, '17990000', '2025-04-03 14:08:07'),
(981, 114, 6, 'iPad/iPad7/ipad-mini-7-white-512gb-17990000-1.png', '2025-04-03 14:08:07'),
(982, 114, 6, 'iPad/iPad7/ipad-mini-7-white-512gb-17990000-2.jpg', '2025-04-03 14:08:07'),
(983, 114, 6, 'iPad/iPad7/ipad-mini-7-white-512gb-17990000-3.jpg', '2025-04-03 14:08:07'),
(984, 114, 6, 'iPad/iPad7/ipad-mini-7-white-512gb-17990000-4.jpg', '2025-04-03 14:08:07'),
(985, 114, 6, 'iPad/iPad7/ipad-mini-7-white-512gb-17990000-5.jpg', '2025-04-03 14:08:07'),
(986, 114, 6, 'iPad/iPad7/ipad-mini-7-white-512gb-17990000-6.jpg', '2025-04-03 14:08:07'),
(987, 115, 2, 'White', '2025-04-03 14:09:20'),
(988, 115, 3, '128GB', '2025-04-03 14:09:20'),
(989, 115, 4, '17890000', '2025-04-03 14:09:20'),
(990, 115, 6, 'iPad/iPad7/ipad-mini-7-white-128gb-17890000-1.png', '2025-04-03 14:09:20'),
(991, 115, 6, 'iPad/iPad7/ipad-mini-7-white-128gb-17890000-2.jpg', '2025-04-03 14:09:20'),
(992, 115, 6, 'iPad/iPad7/ipad-mini-7-white-128gb-17890000-3.jpg', '2025-04-03 14:09:20'),
(993, 115, 6, 'iPad/iPad7/ipad-mini-7-white-128gb-17890000-4.jpg', '2025-04-03 14:09:20'),
(994, 115, 6, 'iPad/iPad7/ipad-mini-7-white-128gb-17890000-5.jpg', '2025-04-03 14:09:20'),
(995, 115, 6, 'iPad/iPad7/ipad-mini-7-white-128gb-17890000-6.jpg', '2025-04-03 14:09:20'),
(996, 116, 2, 'Green', '2025-04-03 14:15:50'),
(997, 116, 3, '40mm', '2025-04-03 14:15:50'),
(998, 116, 4, '5990000', '2025-04-03 14:15:50'),
(999, 116, 6, 'Watch/Watch2/apple-watch-se-2-green-40mm-5990000-1.png', '2025-04-03 14:15:50'),
(1000, 116, 6, 'Watch/Watch2/apple-watch-se-2-green-40mm-5990000-2.png', '2025-04-03 14:15:50'),
(1001, 117, 2, 'Green', '2025-04-03 14:18:20'),
(1002, 117, 3, '44mm', '2025-04-03 14:18:20'),
(1003, 117, 4, '6990000', '2025-04-03 14:18:20'),
(1004, 117, 6, 'Watch/Watch2/apple-watch-se-2-green-44mm-6990000-1.png', '2025-04-03 14:18:20'),
(1005, 118, 2, 'Pink', '2025-04-03 14:20:30'),
(1006, 118, 3, '42mm', '2025-04-03 14:20:30'),
(1007, 118, 4, '13590000', '2025-04-03 14:20:30'),
(1008, 118, 6, 'Watch/Watch10/apple-watch-series-10-gps-pink-42mm-13590000-1.jpg', '2025-04-03 14:20:30'),
(1009, 118, 6, 'Watch/Watch10/apple-watch-series-10-gps-pink-42mm-13590000-2.jpg', '2025-04-03 14:20:30'),
(1010, 118, 6, 'Watch/Watch10/apple-watch-series-10-gps-pink-42mm-13590000-3.jpg', '2025-04-03 14:20:30'),
(1011, 119, 2, 'Blue', '2025-04-03 14:21:31'),
(1012, 119, 3, '46mm', '2025-04-03 14:21:31'),
(1013, 119, 4, '13990000', '2025-04-03 14:21:31'),
(1014, 119, 6, 'Watch/Watch10/apple-watch-series-10-gps-blue-46mm-13990000-1.jpg', '2025-04-03 14:21:31'),
(1015, 119, 6, 'Watch/Watch10/apple-watch-series-10-gps-blue-46mm-13990000-2.jpg', '2025-04-03 14:21:31'),
(1016, 119, 6, 'Watch/Watch10/apple-watch-series-10-gps-blue-46mm-13990000-3.jpg', '2025-04-03 14:21:31'),
(1017, 120, 2, 'Dây Apline', '2025-04-03 14:24:32'),
(1018, 120, 3, '49mm', '2025-04-03 14:24:32'),
(1019, 120, 4, '22990000', '2025-04-03 14:24:32'),
(1020, 120, 6, 'Watch/Watch2/apple-watch-ultra-2-gps-dy-apline-49mm-22990000-1.jpg', '2025-04-03 14:24:32'),
(1021, 120, 6, 'Watch/Watch2/apple-watch-ultra-2-gps-dy-apline-49mm-22990000-2.jpg', '2025-04-03 14:24:32'),
(1022, 120, 6, 'Watch/Watch2/apple-watch-ultra-2-gps-dy-apline-49mm-22990000-3.jpg', '2025-04-03 14:24:32'),
(1023, 120, 6, 'Watch/Watch2/apple-watch-ultra-2-gps-dy-apline-49mm-22990000-4.jpg', '2025-04-03 14:24:32'),
(1024, 121, 2, 'Dây Ocean', '2025-04-03 14:58:57'),
(1025, 121, 3, '49mm', '2025-04-03 14:58:57'),
(1026, 121, 4, '23990000', '2025-04-03 14:58:57'),
(1027, 121, 6, 'Watch/Watch2/apple-watch-ultra-2-gps-dy-ocean-49mm-23990000-1.jpg', '2025-04-03 14:58:57'),
(1028, 121, 6, 'Watch/Watch2/apple-watch-ultra-2-gps-dy-ocean-49mm-23990000-2.png', '2025-04-03 14:58:57'),
(1029, 121, 6, 'Watch/Watch2/apple-watch-ultra-2-gps-dy-ocean-49mm-23990000-3.jpg', '2025-04-03 14:58:57'),
(1030, 122, 2, 'Black', '2025-04-03 22:41:33'),
(1031, 122, 3, '41mm', '2025-04-03 22:41:33'),
(1032, 122, 4, '10490000', '2025-04-03 22:41:33'),
(1033, 122, 6, 'Watch/Watch9/apple-watch-series-9-gps-black-41mm-10490000-1.jpg', '2025-04-03 22:41:33'),
(1034, 122, 6, 'Watch/Watch9/apple-watch-series-9-gps-black-41mm-10490000-2.jpg', '2025-04-03 22:41:33'),
(1035, 122, 6, 'Watch/Watch9/apple-watch-series-9-gps-black-41mm-10490000-3.jpg', '2025-04-03 22:41:33'),
(1036, 122, 6, 'Watch/Watch9/apple-watch-series-9-gps-black-41mm-10490000-4.jpg', '2025-04-03 22:41:33'),
(1037, 123, 2, 'Blue', '2025-04-03 22:42:53'),
(1038, 123, 3, '45mm', '2025-04-03 22:42:53'),
(1039, 123, 4, '11290000', '2025-04-03 22:42:53'),
(1040, 123, 6, 'Watch/Watch9/apple-watch-series-9-gps-blue-45mm-11290000-1.jpg', '2025-04-03 22:42:53'),
(1041, 123, 6, 'Watch/Watch9/apple-watch-series-9-gps-blue-45mm-11290000-2.jpg', '2025-04-03 22:42:53'),
(1042, 123, 6, 'Watch/Watch9/apple-watch-series-9-gps-blue-45mm-11290000-3.jpg', '2025-04-03 22:42:53'),
(1043, 123, 6, 'Watch/Watch9/apple-watch-series-9-gps-blue-45mm-11290000-4.jpg', '2025-04-03 22:42:53'),
(1044, 124, 2, 'White', '2025-04-03 22:48:12'),
(1045, 124, 4, '4490000', '2025-04-03 22:48:12'),
(1046, 124, 6, 'Tai nghe, loa/Tai nghe, loa4/airpods-4-white-4490000-1.jpg', '2025-04-03 22:48:12'),
(1047, 124, 6, 'Tai nghe, loa/Tai nghe, loa4/airpods-4-white-4490000-2.jpg', '2025-04-03 22:48:12'),
(1048, 124, 6, 'Tai nghe, loa/Tai nghe, loa4/airpods-4-white-4490000-3.jpg', '2025-04-03 22:48:12'),
(1049, 124, 6, 'Tai nghe, loa/Tai nghe, loa4/airpods-4-white-4490000-4.jpg', '2025-04-03 22:48:12'),
(1050, 124, 6, 'Tai nghe, loa/Tai nghe, loa4/airpods-4-white-4490000-5.jpg', '2025-04-03 22:48:12'),
(1051, 125, 2, 'White', '2025-04-03 22:53:01'),
(1052, 125, 4, '5780000', '2025-04-03 22:53:01'),
(1053, 125, 6, 'Tai nghe, loa/Tai nghe, loa3/airpods-3-white-5780000-1.jpeg', '2025-04-03 22:53:01'),
(1054, 125, 6, 'Tai nghe, loa/Tai nghe, loa3/airpods-3-white-5780000-2.jpeg', '2025-04-03 22:53:01'),
(1055, 125, 6, 'Tai nghe, loa/Tai nghe, loa3/airpods-3-white-5780000-3.jpeg', '2025-04-03 22:53:01'),
(1056, 125, 6, 'Tai nghe, loa/Tai nghe, loa3/airpods-3-white-5780000-4.jpeg', '2025-04-03 22:53:01'),
(1057, 125, 6, 'Tai nghe, loa/Tai nghe, loa3/airpods-3-white-5780000-5.jpeg', '2025-04-03 22:53:01'),
(1058, 126, 2, 'White', '2025-04-03 22:55:02'),
(1059, 126, 4, '4790000', '2025-04-03 22:55:02'),
(1060, 126, 6, 'Tai nghe, loa/Tai nghe, loa/airpods-pro-white-4790000-1.jpg', '2025-04-03 22:55:02'),
(1061, 126, 6, 'Tai nghe, loa/Tai nghe, loa/airpods-pro-white-4790000-2.jpg', '2025-04-03 22:55:02'),
(1062, 126, 6, 'Tai nghe, loa/Tai nghe, loa/airpods-pro-white-4790000-3.jpg', '2025-04-03 22:55:02'),
(1063, 126, 6, 'Tai nghe, loa/Tai nghe, loa/airpods-pro-white-4790000-4.jpg', '2025-04-03 22:55:02'),
(1064, 126, 6, 'Tai nghe, loa/Tai nghe, loa/airpods-pro-white-4790000-5.jpg', '2025-04-03 22:55:02'),
(1065, 127, 2, 'Black', '2025-04-03 22:56:52'),
(1066, 127, 4, '7990000', '2025-04-03 22:56:52'),
(1067, 127, 6, 'Tai nghe, loa/Tai nghe, loa/airpods-max-black-7990000-1.jpg', '2025-04-03 22:56:52'),
(1068, 127, 6, 'Tai nghe, loa/Tai nghe, loa/airpods-max-black-7990000-2.jpg', '2025-04-03 22:56:52'),
(1069, 127, 6, 'Tai nghe, loa/Tai nghe, loa/airpods-max-black-7990000-3.jpg', '2025-04-03 22:56:52'),
(1070, 128, 2, 'Pink', '2025-04-03 22:57:36'),
(1071, 128, 4, '7990000', '2025-04-03 22:57:36'),
(1072, 128, 6, 'Tai nghe, loa/Tai nghe, loa/airpods-max-pink-7990000-1.jpg', '2025-04-03 22:57:36'),
(1073, 128, 6, 'Tai nghe, loa/Tai nghe, loa/airpods-max-pink-7990000-2.jpg', '2025-04-03 22:57:36'),
(1074, 128, 6, 'Tai nghe, loa/Tai nghe, loa/airpods-max-pink-7990000-3.jpg', '2025-04-03 22:57:36'),
(1075, 129, 2, 'White', '2025-04-03 22:58:35'),
(1076, 129, 4, '7890000', '2025-04-03 22:58:35'),
(1077, 129, 6, 'Tai nghe, loa/Tai nghe, loa/airpods-max-white-7890000-1.jpg', '2025-04-03 22:58:35'),
(1078, 129, 6, 'Tai nghe, loa/Tai nghe, loa/airpods-max-white-7890000-2.jpg', '2025-04-03 22:58:35'),
(1079, 129, 6, 'Tai nghe, loa/Tai nghe, loa/airpods-max-white-7890000-3.jpg', '2025-04-03 22:58:35'),
(1080, 130, 2, 'White', '2025-04-03 23:04:53'),
(1081, 130, 3, '20W', '2025-04-03 23:04:53'),
(1082, 130, 4, '600000', '2025-04-03 23:04:53'),
(1083, 130, 6, 'Phụ kiện/Phụ kiện/adapter-sc-apple-usb-c-white-20w-600000-1.png', '2025-04-03 23:04:53'),
(1084, 130, 6, 'Phụ kiện/Phụ kiện/adapter-sc-apple-usb-c-white-20w-600000-2.jpg', '2025-04-03 23:04:53'),
(1085, 130, 6, 'Phụ kiện/Phụ kiện/adapter-sc-apple-usb-c-white-20w-600000-3.jpg', '2025-04-03 23:04:53'),
(1086, 131, 2, 'White', '2025-04-03 23:07:33'),
(1087, 131, 4, '2290000', '2025-04-03 23:07:33'),
(1088, 131, 6, 'Phụ kiện/Phụ kiện/magic-keyboard-white-2290000-1.jpg', '2025-04-03 23:07:33'),
(1089, 131, 6, 'Phụ kiện/Phụ kiện/magic-keyboard-white-2290000-2.jpg', '2025-04-03 23:07:33'),
(1090, 131, 6, 'Phụ kiện/Phụ kiện/magic-keyboard-white-2290000-3.jpg', '2025-04-03 23:07:33'),
(1091, 132, 2, 'White', '2025-04-03 23:11:24'),
(1092, 132, 4, '1990000', '2025-04-03 23:11:24'),
(1093, 132, 6, 'Phụ kiện/Phụ kiện/chut-apple-magic-mouse-usb-c-white-1990000-1.jpg', '2025-04-03 23:11:24'),
(1094, 132, 6, 'Phụ kiện/Phụ kiện/chut-apple-magic-mouse-usb-c-white-1990000-2.jpg', '2025-04-03 23:11:24'),
(1095, 132, 6, 'Phụ kiện/Phụ kiện/chut-apple-magic-mouse-usb-c-white-1990000-3.jpg', '2025-04-03 23:11:24'),
(1096, 132, 6, 'Phụ kiện/Phụ kiện/chut-apple-magic-mouse-usb-c-white-1990000-4.jpg', '2025-04-03 23:11:24'),
(1097, 133, 2, 'White', '2025-04-04 16:06:11'),
(1098, 133, 3, '128GB', '2025-04-04 16:06:11'),
(1099, 133, 4, '12345678', '2025-04-04 16:06:11'),
(1100, 133, 6, 'iPhone/iPhone14/iphone-14-white-128gb-12345678-1.jpg', '2025-04-04 16:06:11'),
(1101, 133, 6, 'iPhone/iPhone14/iphone-14-white-128gb-12345678-2.jpg', '2025-04-04 16:06:11'),
(1102, 133, 6, 'iPhone/iPhone14/iphone-14-white-128gb-12345678-3.jpg', '2025-04-04 16:06:11'),
(1103, 133, 6, 'iPhone/iPhone14/iphone-14-white-128gb-12345678-4.jpg', '2025-04-04 16:06:11'),
(1104, 133, 6, 'iPhone/iPhone14/iphone-14-white-128gb-12345678-5.jpg', '2025-04-04 16:06:11'),
(1105, 133, 6, 'iPhone/iPhone14/iphone-14-white-128gb-12345678-6.jpg', '2025-04-04 16:06:11'),
(1106, 133, 6, 'iPhone/iPhone14/iphone-14-white-128gb-12345678-7.jpg', '2025-04-04 16:06:11'),
(1107, 134, 2, 'White', '2025-04-04 16:10:02'),
(1108, 134, 3, '256GB', '2025-04-04 16:10:02'),
(1109, 134, 4, '12121222', '2025-04-04 16:10:02'),
(1110, 134, 6, 'iPhone/iPhone14/iphone-14-white-256gb-12121222-1.jpg', '2025-04-04 16:10:02'),
(1111, 134, 6, 'iPhone/iPhone14/iphone-14-white-256gb-12121222-2.jpg', '2025-04-04 16:10:02'),
(1112, 134, 6, 'iPhone/iPhone14/iphone-14-white-256gb-12121222-3.jpg', '2025-04-04 16:10:02'),
(1113, 134, 6, 'iPhone/iPhone14/iphone-14-white-256gb-12121222-4.jpg', '2025-04-04 16:10:02'),
(1114, 134, 6, 'iPhone/iPhone14/iphone-14-white-256gb-12121222-5.jpg', '2025-04-04 16:10:02'),
(1115, 134, 6, 'iPhone/iPhone14/iphone-14-white-256gb-12121222-6.jpg', '2025-04-04 16:10:02'),
(1116, 134, 6, 'iPhone/iPhone14/iphone-14-white-256gb-12121222-7.jpg', '2025-04-04 16:10:02'),
(1117, 135, 2, 'Purple', '2025-04-04 16:12:05'),
(1118, 135, 3, '256GB', '2025-04-04 16:12:05'),
(1119, 135, 4, '12312312', '2025-04-04 16:12:05'),
(1120, 135, 6, 'iPhone/iPhone14/iphone-14-purple-256gb-12312312-1.jpg', '2025-04-04 16:12:05'),
(1121, 135, 6, 'iPhone/iPhone14/iphone-14-purple-256gb-12312312-2.jpg', '2025-04-04 16:12:05'),
(1122, 135, 6, 'iPhone/iPhone14/iphone-14-purple-256gb-12312312-3.jpg', '2025-04-04 16:12:05'),
(1123, 135, 6, 'iPhone/iPhone14/iphone-14-purple-256gb-12312312-4.jpg', '2025-04-04 16:12:05'),
(1124, 135, 6, 'iPhone/iPhone14/iphone-14-purple-256gb-12312312-5.jpg', '2025-04-04 16:12:05'),
(1125, 135, 6, 'iPhone/iPhone14/iphone-14-purple-256gb-12312312-6.jpg', '2025-04-04 16:12:05'),
(1126, 135, 6, 'iPhone/iPhone14/iphone-14-purple-256gb-12312312-7.jpg', '2025-04-04 16:12:05'),
(1127, 136, 2, 'Purple', '2025-04-04 16:15:01'),
(1128, 136, 3, '256GB', '2025-04-04 16:15:01'),
(1129, 136, 4, '13423234', '2025-04-04 16:15:01'),
(1130, 136, 6, 'iPhone/iPhone14/iphone-14-pro-max-purple-256gb-13423234-1.jpg', '2025-04-04 16:15:01'),
(1131, 136, 6, 'iPhone/iPhone14/iphone-14-pro-max-purple-256gb-13423234-2.jpg', '2025-04-04 16:15:01'),
(1132, 137, 2, 'Purple', '2025-04-04 16:15:56'),
(1133, 137, 3, '512GB', '2025-04-04 16:15:56'),
(1134, 137, 4, '34534512', '2025-04-04 16:15:56'),
(1135, 137, 6, 'iPhone/iPhone14/iphone-14-pro-max-purple-512gb-34534512-1.jpg', '2025-04-04 16:15:56'),
(1136, 137, 6, 'iPhone/iPhone14/iphone-14-pro-max-purple-512gb-34534512-2.jpg', '2025-04-04 16:15:56'),
(1137, 138, 2, 'White', '2025-04-04 21:41:37'),
(1138, 138, 3, '256GB', '2025-04-04 21:41:37'),
(1139, 138, 4, '24342353', '2025-04-04 21:41:37'),
(1140, 138, 6, 'iPhone/iPhone14/iphone-14-plus-white-256gb-24342353-1.jpg', '2025-04-04 21:41:37'),
(1141, 138, 6, 'iPhone/iPhone14/iphone-14-plus-white-256gb-24342353-2.jpg', '2025-04-04 21:41:37'),
(1142, 138, 6, 'iPhone/iPhone14/iphone-14-plus-white-256gb-24342353-3.jpg', '2025-04-04 21:41:37'),
(1143, 138, 6, 'iPhone/iPhone14/iphone-14-plus-white-256gb-24342353-4.jpg', '2025-04-04 21:41:37'),
(1144, 138, 6, 'iPhone/iPhone14/iphone-14-plus-white-256gb-24342353-5.jpg', '2025-04-04 21:41:37'),
(1145, 138, 6, 'iPhone/iPhone14/iphone-14-plus-white-256gb-24342353-6.jpg', '2025-04-04 21:41:37'),
(1146, 138, 6, 'iPhone/iPhone14/iphone-14-plus-white-256gb-24342353-7.jpg', '2025-04-04 21:41:37'),
(1147, 139, 2, 'White', '2025-04-04 21:43:08'),
(1148, 139, 3, '512GB', '2025-04-04 21:43:08'),
(1149, 139, 4, '42344400', '2025-04-04 21:43:08'),
(1150, 139, 6, 'iPhone/iPhone14/iphone-14-plus-white-512gb-42344400-1.jpg', '2025-04-04 21:43:08'),
(1151, 139, 6, 'iPhone/iPhone14/iphone-14-plus-white-512gb-42344400-2.jpg', '2025-04-04 21:43:08'),
(1152, 139, 6, 'iPhone/iPhone14/iphone-14-plus-white-512gb-42344400-3.jpg', '2025-04-04 21:43:08'),
(1153, 139, 6, 'iPhone/iPhone14/iphone-14-plus-white-512gb-42344400-4.jpg', '2025-04-04 21:43:08'),
(1154, 139, 6, 'iPhone/iPhone14/iphone-14-plus-white-512gb-42344400-5.jpg', '2025-04-04 21:43:08'),
(1155, 139, 6, 'iPhone/iPhone14/iphone-14-plus-white-512gb-42344400-6.jpg', '2025-04-04 21:43:08'),
(1156, 139, 6, 'iPhone/iPhone14/iphone-14-plus-white-512gb-42344400-7.jpg', '2025-04-04 21:43:08'),
(1157, 140, 2, 'Yellow', '2025-04-04 21:44:45'),
(1158, 140, 3, '128GB', '2025-04-04 21:44:45'),
(1159, 140, 4, '12312312', '2025-04-04 21:44:45'),
(1160, 140, 6, 'iPhone/iPhone14/iphone-14-plus-yellow-128gb-12312312-1.jpeg', '2025-04-04 21:44:45'),
(1161, 140, 6, 'iPhone/iPhone14/iphone-14-plus-yellow-128gb-12312312-2.jpeg', '2025-04-04 21:44:45'),
(1162, 140, 6, 'iPhone/iPhone14/iphone-14-plus-yellow-128gb-12312312-3.jpeg', '2025-04-04 21:44:45'),
(1163, 140, 6, 'iPhone/iPhone14/iphone-14-plus-yellow-128gb-12312312-4.jpeg', '2025-04-04 21:44:45'),
(1164, 140, 6, 'iPhone/iPhone14/iphone-14-plus-yellow-128gb-12312312-5.jpeg', '2025-04-04 21:44:45'),
(1165, 140, 6, 'iPhone/iPhone14/iphone-14-plus-yellow-128gb-12312312-6.jpeg', '2025-04-04 21:44:45'),
(1166, 140, 6, 'iPhone/iPhone14/iphone-14-plus-yellow-128gb-12312312-7.jpeg', '2025-04-04 21:44:45'),
(1167, 141, 2, 'Yellow', '2025-04-04 21:46:11'),
(1168, 141, 3, '512GB', '2025-04-04 21:46:11'),
(1169, 141, 4, '32132423', '2025-04-04 21:46:11'),
(1170, 141, 6, 'iPhone/iPhone14/iphone-14-plus-yellow-512gb-32132423-1.jpeg', '2025-04-04 21:46:11'),
(1171, 141, 6, 'iPhone/iPhone14/iphone-14-plus-yellow-512gb-32132423-2.jpeg', '2025-04-04 21:46:11'),
(1172, 141, 6, 'iPhone/iPhone14/iphone-14-plus-yellow-512gb-32132423-3.jpeg', '2025-04-04 21:46:11'),
(1173, 141, 6, 'iPhone/iPhone14/iphone-14-plus-yellow-512gb-32132423-4.jpeg', '2025-04-04 21:46:11'),
(1174, 141, 6, 'iPhone/iPhone14/iphone-14-plus-yellow-512gb-32132423-5.jpeg', '2025-04-04 21:46:11'),
(1175, 141, 6, 'iPhone/iPhone14/iphone-14-plus-yellow-512gb-32132423-6.jpeg', '2025-04-04 21:46:11'),
(1176, 141, 6, 'iPhone/iPhone14/iphone-14-plus-yellow-512gb-32132423-7.jpeg', '2025-04-04 21:46:11'),
(1177, 0, 2, 'Black', '2025-04-05 01:51:10'),
(1178, 0, 3, '128GB', '2025-04-05 01:51:10'),
(1179, 0, 4, '19990000', '2025-04-05 01:51:10'),
(1180, 0, 6, '', '2025-04-05 01:51:10'),
(1181, 0, 6, '', '2025-04-05 01:51:10'),
(1182, 0, 6, '', '2025-04-05 01:51:10'),
(1183, 0, 6, '', '2025-04-05 01:51:10'),
(1184, 0, 6, '', '2025-04-05 01:51:10'),
(1185, 0, 6, '', '2025-04-05 01:51:10'),
(1186, 0, 6, '', '2025-04-05 01:51:10'),
(1187, 0, 2, 'Black', '2025-04-05 01:54:27'),
(1188, 0, 3, '128GB', '2025-04-05 01:54:27'),
(1189, 0, 4, '19990000', '2025-04-05 01:54:27'),
(1190, 0, 6, '', '2025-04-05 01:54:27'),
(1191, 0, 6, '', '2025-04-05 01:54:27'),
(1192, 0, 6, '', '2025-04-05 01:54:27'),
(1193, 0, 6, '', '2025-04-05 01:54:27'),
(1194, 0, 6, '', '2025-04-05 01:54:27'),
(1195, 0, 6, '', '2025-04-05 01:54:27'),
(1196, 0, 6, '', '2025-04-05 01:54:27'),
(1197, 142, 2, 'Black', '2025-04-05 02:43:48'),
(1198, 142, 3, '512GB', '2025-04-05 02:43:48'),
(1199, 142, 4, '213454564', '2025-04-05 02:43:48'),
(1200, 142, 6, 'iphone-15-black-2-650x650.jpg', '2025-04-05 02:43:48'),
(1201, 142, 6, 'iphone-15-black-9-650x650.jpg', '2025-04-05 02:43:48'),
(1202, 142, 6, 'iphone-15-black-3-650x650.jpg', '2025-04-05 02:43:48'),
(1203, 142, 6, 'iphone-15-black-1-650x650.jpg', '2025-04-05 02:43:48'),
(1204, 142, 6, NULL, '2025-04-05 02:43:48'),
(1205, 142, 6, NULL, '2025-04-05 02:43:48'),
(1206, 142, 6, NULL, '2025-04-05 02:43:48');

-- --------------------------------------------------------

--
-- Table structure for table `productvariants`
--

CREATE TABLE `productvariants` (
  `productVariantId` int(11) NOT NULL,
  `productId` int(11) DEFAULT NULL,
  `productVariantImage` varchar(255) CHARACTER SET utf8mb4 COLLATE utf8mb4_unicode_ci DEFAULT NULL,
  `price` decimal(10,2) DEFAULT NULL,
  `create_at` datetime DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

--
-- Dumping data for table `productvariants`
--

INSERT INTO `productvariants` (`productVariantId`, `productId`, `productVariantImage`, `price`, `create_at`) VALUES
(8, 9, 'iPhone/iPhone14/iphone14-iphone-20250405-053051.png', 17290000.00, '2025-02-25 02:13:18'),
(9, 9, 'iPhone/iPhone14/iphone 14 .png', 17290000.00, '2025-02-25 02:15:33'),
(10, 9, 'iPhone/iPhone14/iphone 14 .png', 15599000.00, '2025-02-25 02:18:25'),
(14, 11, 'iPhone/iPhone14/iphone-14-pro-max-purple-128gb-30990000.png', 26980000.00, '2025-04-01 22:29:06'),
(16, 12, 'iPhone/iPhone14/iphone-14-plus-white-128gb-19990000.png', 18990000.00, '2025-04-01 22:56:06'),
(17, 12, 'iPhone/iPhone14/iphone-14-plus-yellow-256gb-20990000.png', 16590000.00, '2025-04-01 22:58:47'),
(18, 13, 'iPhone/iPhone15/iphone-15--lack-256-213414124.png', 99999999.99, '2025-04-05 00:55:14'),
(19, 13, 'iphone-15-black-1-2-650x650.png', 99999999.99, '2025-04-01 23:02:48'),
(28, 15, 'iPhone/iPhone15/iphone-15-pro-max-black-64gb-21990000.png', 17790000.00, '2025-04-03 02:12:23'),
(29, 15, 'iPhone/iPhone15/iphone-15-pro-max-black-128gb-21990000.png', 17790000.00, '2025-04-03 03:01:50'),
(30, 15, 'iPhone/iPhone15/iphone-15-pro-max-blue-64gb-21990000.png', 17790000.00, '2025-04-03 03:03:25'),
(31, 15, 'iPhone/iPhone15/iphone-15-pro-max-blue-128gb-21990000.png', 17790000.00, '2025-04-03 03:04:45'),
(34, 15, 'iPhone/iPhone15/iphone-15-pro-max-white-64gb-21990000.png', 17790000.00, '2025-04-03 03:09:39'),
(35, 15, 'iPhone/iPhone15/iphone-15-pro-max-white-128gb-21990000.png', 17790000.00, '2025-04-03 03:11:09'),
(36, 16, 'iPhone/iPhone15/iphone-15-plus-black-256gb-22990000.png', 18990000.00, '2025-04-03 03:13:08'),
(37, 16, 'iPhone/iPhone15/iphone-15-plus-black-512gb-22990000.png', 18990000.00, '2025-04-03 03:14:33'),
(38, 16, 'iPhone/iPhone15/iphone-15-plus-blue-256gb-22990000.png', 18990000.00, '2025-04-03 03:15:59'),
(39, 16, 'iPhone/iPhone15/iphone-15-plus-blue-512gb-22990000.png', 18990000.00, '2025-04-03 03:17:18'),
(40, 16, 'iPhone/iPhone15/iphone-15-plus-green-1t-23990000.png', 19990000.00, '2025-04-03 03:19:05'),
(42, 16, 'iPhone/iPhone15/iphone-15-plus-pink-64gb-22990000.png', 21990000.00, '2025-04-03 03:22:48'),
(43, 16, 'iPhone/iPhone15/iphone-15-plus-pink-128gb-22990000.png', 21990000.00, '2025-04-03 03:24:13'),
(44, 16, 'iPhone/iPhone15/iphone-15-plus-yellow-64gb-32990000.png', 24990000.00, '2025-04-03 03:25:45'),
(45, 16, 'iPhone/iPhone15/iphone-15-plus-yellow-512gb-32990000.png', 23990000.00, '2025-04-03 03:27:16'),
(46, 17, 'iPhone/iPhone16/iphone-16-pro-max-black-64gb-31990000.png', 26690000.00, '2025-04-03 03:28:54'),
(47, 17, 'iPhone/iPhone16/iphone-16-pro-max-black-128gb-31990000.png', 26690000.00, '2025-04-03 03:30:07'),
(48, 17, 'iPhone/iPhone16/iphone-16-pro-max-gold-64gb-31990000.png', 26690000.00, '2025-04-03 03:31:30'),
(49, 17, 'iPhone/iPhone16/iphone-16-pro-max-gold-128gb-31990000.png', 2669000.00, '2025-04-03 03:32:50'),
(50, 17, 'iPhone/iPhone16/iphone-16-pro-max-nature-64gb-31990000.png', 26690000.00, '2025-04-03 03:34:28'),
(51, 17, 'iPhone/iPhone16/iphone-16-pro-max-nature-128gb-31990000.png', 26690000.00, '2025-04-03 03:35:37'),
(52, 17, 'iPhone/iPhone16/iphone-16-pro-max-hite-128-123213213.png', 26690000.00, '2025-04-03 04:21:27'),
(53, 18, 'iPhone/iPhone16/iphone-16-black-128gb-34990000.png', 24890000.00, '2025-04-03 04:23:55'),
(54, 18, 'iPhone/iPhone16/iphone-16-blue-1t-35670000.png', 28890000.00, '2025-04-03 04:39:37'),
(55, 18, 'iPhone/iPhone16/iphone-16-green-512gb-2789000.png', 25670000.00, '2025-04-03 04:41:24'),
(56, 18, 'iPhone/iPhone16/iphone-16-pink-256gb-23590000.png', 16790000.00, '2025-04-03 04:42:40'),
(57, 18, 'iPhone/iPhone16/iphone-16-white-256gb-24990000.png', 23560000.00, '2025-04-03 04:58:47'),
(58, 19, 'iPhone/iPhone16/iphone-16-plus-black-64gb-24990000.png', 23990000.00, '2025-04-03 05:37:17'),
(60, 19, 'iPhone/iPhone16/iphone-16-plus-blue-64gb-29990000.png', 17990000.00, '2025-04-03 05:39:58'),
(61, 19, 'iPhone/iPhone16/iphone-16-plus-blue-128gb-34990000.png', 28990000.00, '2025-04-03 05:41:11'),
(63, 19, 'iPhone/iPhone16/iphone-16-plus-green-512gb-25770000.jpg', 23450000.00, '2025-04-03 05:43:43'),
(64, 19, 'iPhone/iPhone16/iphone-16-plus-pink-256gb-39990000.png', 23230000.00, '2025-04-03 05:45:02'),
(65, 19, 'iPhone/iPhone16/iphone-16-plus-pink-1t-18980000.png', 17880000.00, '2025-04-03 05:46:17'),
(66, 19, 'iPhone/iPhone16/iphone-16-plus-white-128gb-34990000.png', 27770000.00, '2025-04-03 05:47:42'),
(68, 20, 'iPhone/iPhone16/iphone-16-pro-black-64gb-21990000.png', 17990000.00, '2025-04-03 05:50:20'),
(69, 20, 'iPhone/iPhone16/iphone-16-pro-gold-512gb-37890000.png', 23880000.00, '2025-04-03 05:51:33'),
(70, 20, 'iPhone/iPhone16/iphone-16-pro-nature-128gb-31880000.png', 24690000.00, '2025-04-03 05:52:42'),
(71, 20, 'iPhone/iPhone16/iphone-16-pro-white-1t-33330000.png', 32320000.00, '2025-04-03 05:53:46'),
(72, 21, 'Mac/Mac14/macbook-pro-14-inch-m4-black-16ggb-41990000.png', 39990000.00, '2025-04-03 06:12:28'),
(73, 21, 'Mac/Mac14/macbook-pro-14-inch-m4-black-512gb-40000000.png', 39990000.00, '2025-04-03 06:13:39'),
(74, 22, 'Mac/Mac16/macbook-pro-16-inch-m4-black-24gb-68790000.png', 68490000.00, '2025-04-03 06:15:44'),
(75, 22, 'Mac/Mac16/macbook-pro-16-inch-m4-black-512gb-68990000.png', 68490000.00, '2025-04-03 06:16:55'),
(76, 23, 'Mac/Mac13/macbook-air-13-inch-m1-black-8gb-19990000.png', 17490000.00, '2025-04-03 06:18:20'),
(77, 23, 'Mac/Mac13/macbook-air-13-inch-m1-white-256gb-19990000.png', 17490000.00, '2025-04-03 06:19:29'),
(78, 24, 'Mac/Mac13/macbook-air-13-inch-m2-navy-16gb-24990000.jpg', 21990000.00, '2025-04-03 06:21:13'),
(79, 24, 'Mac/Mac13/macbook-air-13-inch-m2-navy-256gb-24990000.jpg', 21990000.00, '2025-04-03 06:22:12'),
(80, 24, 'Mac/Mac13/macbook-air-13-inch-m2-sliver-16gb-32990000.jpg', 31000000.00, '2025-04-03 06:23:50'),
(81, 24, 'Mac/Mac13/macbook-air-13-inch-m2-sliver-256gb-29990000.jpg', 27990000.00, '2025-04-03 06:24:39'),
(82, 24, 'Mac/Mac13/macbook-air-13-inch-m2-white-16gb-27880000.jpg', 26980000.00, '2025-04-03 06:25:41'),
(83, 24, 'Mac/Mac13/macbook-air-13-inch-m2-white-256gb-28990000.jpg', 25690000.00, '2025-04-03 06:26:33'),
(84, 25, 'Mac/Mac13/macbook-air-13-inch-m3-green-128gb-28980000.png', 24770000.00, '2025-04-03 13:25:18'),
(85, 25, 'Mac/Mac13/macbook-air-13-inch-m3-black-512gb-32660000.png', 18690000.00, '2025-04-03 13:26:59'),
(86, 26, 'Mac/Mac15/macbook-air-15-inch-m3-gold-32gb-59990000.jpg', 46990000.00, '2025-04-03 13:28:46'),
(87, 26, 'Mac/Mac15/macbook-air-15-inch-m3-gold-512gb-79880000.jpg', 46990000.00, '2025-04-03 13:29:51'),
(88, 26, 'Mac/Mac15/macbook-air-15-inch-m3-navy-32gb-47770000.jpg', 46990000.00, '2025-04-03 13:30:52'),
(89, 26, 'Mac/Mac15/macbook-air-15-inch-m3-navy-512gb-67670000.jpg', 46990000.00, '2025-04-03 13:32:20'),
(90, 26, 'Mac/Mac15/macbook-air-15-inch-m3-sliver-32gb-66990000.jpg', 29870000.00, '2025-04-03 13:33:36'),
(91, 27, 'Mac/Mac24/imac-24-inch-m4-blue-256gb-39990000.png', 39490000.00, '2025-04-03 13:35:35'),
(92, 27, 'Mac/Mac24/imac-24-inch-m4-green-512gb-65560000.png', 36690000.00, '2025-04-03 13:36:36'),
(93, 27, 'Mac/Mac24/imac-24-inch-m4-pink-512gb-31990000.png', 31190000.00, '2025-04-03 13:37:37'),
(94, 28, 'Mac/Mac4/mac-mini-m4-pro-white-48gb-51990000.png', 49990000.00, '2025-04-03 13:39:25'),
(95, 28, 'Mac/Mac4/mac-mini-m4-pro-green-1tb-66000000.png', 49090000.00, '2025-04-03 13:40:35'),
(96, 29, 'Mac/Mac4/mac-mini-m4-white-24gb-27790000.png', 31130000.00, '2025-04-03 13:41:57'),
(97, 29, 'Mac/Mac4/mac-mini-m4-nature-256gb-21210000.png', 19900000.00, '2025-04-03 13:43:11'),
(98, 30, 'iPad/iPad4/ipad-pro-m4-11-inch-black-256gb-28990000.png', 27890000.00, '2025-04-03 13:45:14'),
(99, 30, 'iPad/iPad4/ipad-pro-m4-11-inch-white-256gb-29990000.png', 27890000.00, '2025-04-03 13:46:26'),
(100, 31, 'iPad/iPad4/ipad-pro-m4-13-inch-black-512gb-32990000.png', 36590000.00, '2025-04-03 13:48:30'),
(101, 31, 'iPad/iPad4/ipad-pro-m4-13-inch-white-1tb-44990000.png', 21880000.00, '2025-04-03 13:49:36'),
(102, 32, 'iPad/iPad2/ipad-air-m2-11-inch-blue-128gb-17990000.png', 16990000.00, '2025-04-03 13:51:42'),
(103, 32, 'iPad/iPad2/ipad-air-m2-11-inch-sliver-128gb-32990900.png', 16990000.00, '2025-04-03 13:52:49'),
(104, 32, 'iPad/iPad2/ipad-air-m2-11-inch-yellow-256gb-21000000.png', 18990000.00, '2025-04-03 13:54:04'),
(105, 33, 'iPad/iPad2/ipad-air-m2-13-inch-blue-256gb-31770000.png', 24990000.00, '2025-04-03 13:55:48'),
(106, 33, 'iPad/iPad2/ipad-air-m2-13-inch-sliver-512gb-42330000.png', 31990000.00, '2025-04-03 13:56:48'),
(107, 33, 'iPad/iPad2/ipad-air-m2-13-inch-white-128gb-25990000.png', 24990000.00, '2025-04-03 13:58:02'),
(108, 34, 'iPad/iPad10/ipad-10-blue-64gb-11490000.png', 8690000.00, '2025-04-03 14:00:00'),
(109, 34, 'iPad/iPad10/ipad-10-red-32gb-11220000.png', 8990000.00, '2025-04-03 14:01:33'),
(110, 34, 'iPad/iPad10/ipad-10-sliver-1tb-12990000.png', 6990000.00, '2025-04-03 14:02:43'),
(111, 34, 'iPad/iPad10/ipad-10-yellow-256gb-12990000.png', 8990000.00, '2025-04-03 14:04:01'),
(118, 37, 'Watch/Watch10/apple-watch-series-10-gps-pink-42mm-13590000.png', 12690000.00, '2025-04-03 14:20:30'),
(121, 38, 'Watch/Watch2/apple-watch-ultra-2-gps-dy-ocean-49mm-23990000.png', 22090000.00, '2025-04-03 14:58:57'),
(122, 39, 'Watch/Watch9/apple-watch-series-9-gps-black-41mm-10490000.png', 7290000.00, '2025-04-03 22:41:33'),
(123, 39, 'Watch/Watch9/apple-watch-series-9-gps-blue-45mm-11290000.png', 7790000.00, '2025-04-03 22:42:53'),
(124, 40, 'Tai nghe, loa/Tai nghe, loa4/airpods-4-white-4490000.png', 3990000.00, '2025-04-03 22:48:12'),
(125, 41, 'Tai nghe, loa/Tai nghe, loa3/airpods-3-white-5780000.png', 4980000.00, '2025-04-03 22:53:01'),
(126, 42, 'Tai nghe, loa/Tai nghe, loa/airpods-pro-white-4790000.png', 4490000.00, '2025-04-03 22:55:02'),
(127, 43, 'Tai nghe, loa/Tai nghe, loa/airpods-max-black-7990000.png', 4890000.00, '2025-04-03 22:56:52'),
(128, 43, 'Tai nghe, loa/Tai nghe, loa/airpods-max-pink-7990000.png', 4990000.00, '2025-04-03 22:57:36'),
(129, 43, 'Tai nghe, loa/Tai nghe, loa/airpods-max-white-7890000.png', 4990000.00, '2025-04-03 22:58:35'),
(130, 44, 'Phụ kiện/Phụ kiện/adapter-sc-apple-usb-c-white-20w-600000.png', 550000.00, '2025-04-03 23:04:53'),
(131, 45, 'Phụ kiện/Phụ kiện/magic-keyboard-white-2290000.png', 1990000.00, '2025-04-03 23:07:33'),
(132, 46, 'Phụ kiện/Phụ kiện/chut-apple-magic-mouse-usb-c-white-1990000.png', 1790000.00, '2025-04-03 23:11:24'),
(135, 9, 'iPhone/iPhone14/iphone-14-purple-256gb-12312312.png', 12312311.00, '2025-04-04 16:12:05'),
(136, 11, 'iPhone/iPhone14/iphone-14-pro-max-purple-256gb-13423234.png', 12345123.00, '2025-04-04 16:15:01'),
(137, 11, 'iPhone/iPhone14/iphone-14-pro-max-purple-512gb-34534512.png', 12122131.00, '2025-04-04 16:15:56'),
(138, 12, 'iPhone/iPhone14/iphone-14-plus-white-256gb-24342353.png', 52452111.00, '2025-04-04 21:41:37'),
(139, 12, 'iPhone/iPhone14/iphone-14-plus-white-512gb-42344400.png', 44343243.00, '2025-04-04 21:43:08'),
(140, 12, 'iPhone/iPhone14/iphone-14-plus-yellow-128gb-12312312.png', 18960000.00, '2025-04-04 21:44:45'),
(141, 12, 'iPhone/iPhone14/iphone-14-plus-yellow-512gb-32132423.png', 12122130.00, '2025-04-04 21:46:11'),
(142, 13, 'iPhone/iPhone15/iphone-15-black-512gb-213454564.png', 99999999.99, '2025-04-05 02:43:48');

-- --------------------------------------------------------

--
-- Table structure for table `sliders`
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
-- Dumping data for table `sliders`
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
-- Table structure for table `users`
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
-- Dumping data for table `users`
--

INSERT INTO `users` (`userId`, `userName`, `userEmail`, `userPhone`, `userAddress`, `userCity`, `userDistrict`, `userWard`, `userPassword`, `userRole`, `create_at`, `userImage`, `userStatus`) VALUES
(1, 'Hội Người Già', 'admin123@gmail.com', '0123456789', NULL, NULL, NULL, NULL, '$2y$10$e.IEpvj7A7dzyNktWX9CIezqqgZVihkxSOnBNOtlBWrV.J71gij3S', 4, '2025-02-17 19:56:26', NULL, 1),
(2, 'Hoanghoan', 'admin@gmail.com', '12312312312', '13 đường Âu Cơ', 17, 155, 5176, '$2y$10$UfsC1RMBtkfzMuhzYVbz2uFMO6WXRlRz/RIEJLfWonaT8aj/L/tUG', 1, '2025-02-17 20:01:18', NULL, 1);

--
-- Indexes for dumped tables
--

--
-- Indexes for table `attributes`
--
ALTER TABLE `attributes`
  ADD PRIMARY KEY (`attributeId`);

--
-- Indexes for table `blogs`
--
ALTER TABLE `blogs`
  ADD PRIMARY KEY (`blogId`);

--
-- Indexes for table `categories`
--
ALTER TABLE `categories`
  ADD PRIMARY KEY (`categoryId`);

--
-- Indexes for table `discounts`
--
ALTER TABLE `discounts`
  ADD PRIMARY KEY (`discountId`);

--
-- Indexes for table `orderdetails`
--
ALTER TABLE `orderdetails`
  ADD PRIMARY KEY (`orderDetailId`),
  ADD KEY `orderId` (`orderId`);

--
-- Indexes for table `orders`
--
ALTER TABLE `orders`
  ADD PRIMARY KEY (`orderId`),
  ADD KEY `discountId` (`discountId`),
  ADD KEY `userId` (`userId`);

--
-- Indexes for table `productlines`
--
ALTER TABLE `productlines`
  ADD PRIMARY KEY (`productLineId`);

--
-- Indexes for table `productorders`
--
ALTER TABLE `productorders`
  ADD PRIMARY KEY (`productOrderId`),
  ADD KEY `orderDetailId` (`orderDetailId`),
  ADD KEY `fk_productOrders_productVariants` (`productVariantId`);

--
-- Indexes for table `products`
--
ALTER TABLE `products`
  ADD PRIMARY KEY (`productId`);

--
-- Indexes for table `productvariantattributes`
--
ALTER TABLE `productvariantattributes`
  ADD PRIMARY KEY (`productVariantAttributeId`),
  ADD KEY `fk_productvariantattributes_variant` (`productVariantId`);

--
-- Indexes for table `productvariants`
--
ALTER TABLE `productvariants`
  ADD PRIMARY KEY (`productVariantId`),
  ADD KEY `fk_productvariants_product` (`productId`);

--
-- Indexes for table `sliders`
--
ALTER TABLE `sliders`
  ADD PRIMARY KEY (`sliderId`),
  ADD KEY `fk_slider_category` (`categoryId`);

--
-- Indexes for table `users`
--
ALTER TABLE `users`
  ADD PRIMARY KEY (`userId`);

--
-- AUTO_INCREMENT for dumped tables
--

--
-- AUTO_INCREMENT for table `attributes`
--
ALTER TABLE `attributes`
  MODIFY `attributeId` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=10;

--
-- AUTO_INCREMENT for table `blogs`
--
ALTER TABLE `blogs`
  MODIFY `blogId` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=2;

--
-- AUTO_INCREMENT for table `categories`
--
ALTER TABLE `categories`
  MODIFY `categoryId` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=7;

--
-- AUTO_INCREMENT for table `discounts`
--
ALTER TABLE `discounts`
  MODIFY `discountId` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=12;

--
-- AUTO_INCREMENT for table `orderdetails`
--
ALTER TABLE `orderdetails`
  MODIFY `orderDetailId` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=31;

--
-- AUTO_INCREMENT for table `orders`
--
ALTER TABLE `orders`
  MODIFY `orderId` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=51;

--
-- AUTO_INCREMENT for table `productlines`
--
ALTER TABLE `productlines`
  MODIFY `productLineId` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=27;

--
-- AUTO_INCREMENT for table `productorders`
--
ALTER TABLE `productorders`
  MODIFY `productOrderId` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=27;

--
-- AUTO_INCREMENT for table `products`
--
ALTER TABLE `products`
  MODIFY `productId` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=40;

--
-- AUTO_INCREMENT for table `productvariantattributes`
--
ALTER TABLE `productvariantattributes`
  MODIFY `productVariantAttributeId` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=1207;

--
-- AUTO_INCREMENT for table `productvariants`
--
ALTER TABLE `productvariants`
  MODIFY `productVariantId` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=143;

--
-- AUTO_INCREMENT for table `sliders`
--
ALTER TABLE `sliders`
  MODIFY `sliderId` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=15;

--
-- AUTO_INCREMENT for table `users`
--
ALTER TABLE `users`
  MODIFY `userId` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=3;

--
-- Constraints for dumped tables
--

--
-- Constraints for table `productorders`
--
ALTER TABLE `productorders`
  ADD CONSTRAINT `fk_productOrders_productVariants` FOREIGN KEY (`productVariantId`) REFERENCES `productvariants` (`productVariantId`);
COMMIT;

/*!40101 SET CHARACTER_SET_CLIENT=@OLD_CHARACTER_SET_CLIENT */;
/*!40101 SET CHARACTER_SET_RESULTS=@OLD_CHARACTER_SET_RESULTS */;
/*!40101 SET COLLATION_CONNECTION=@OLD_COLLATION_CONNECTION */;
