-- phpMyAdmin SQL Dump
-- version 4.6.6deb5
-- https://www.phpmyadmin.net/
--
-- Host: localhost:3306
-- Generation Time: Nov 04, 2019 at 07:29 PM
-- Server version: 5.7.27-0ubuntu0.18.04.1
-- PHP Version: 7.2.24-0ubuntu0.18.04.1

SET SQL_MODE = "NO_AUTO_VALUE_ON_ZERO";
SET time_zone = "+00:00";


/*!40101 SET @OLD_CHARACTER_SET_CLIENT=@@CHARACTER_SET_CLIENT */;
/*!40101 SET @OLD_CHARACTER_SET_RESULTS=@@CHARACTER_SET_RESULTS */;
/*!40101 SET @OLD_COLLATION_CONNECTION=@@COLLATION_CONNECTION */;
/*!40101 SET NAMES utf8mb4 */;

--
-- Database: `bookworm`
--

-- --------------------------------------------------------

--
-- Table structure for table `address`
--

CREATE TABLE `address` (
  `id` int(8) UNSIGNED NOT NULL,
  `user_id` int(10) UNSIGNED DEFAULT NULL,
  `name` varchar(30) COLLATE utf8mb4_bin NOT NULL,
  `contact` bigint(15) UNSIGNED NOT NULL,
  `addr1` varchar(50) COLLATE utf8mb4_bin NOT NULL,
  `addr2` varchar(50) COLLATE utf8mb4_bin NOT NULL,
  `addr3` varchar(50) COLLATE utf8mb4_bin NOT NULL,
  `pin` int(10) UNSIGNED NOT NULL,
  `created_at` date DEFAULT NULL,
  `updated_at` date DEFAULT NULL,
  `deleted_at` date DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_bin;

--
-- Dumping data for table `address`
--

INSERT INTO `address` (`id`, `user_id`, `name`, `contact`, `addr1`, `addr2`, `addr3`, `pin`, `created_at`, `updated_at`, `deleted_at`) VALUES
(7, 1, 'Animesh Kr', 8986722466, 'q3515', 'g542', 'sec 9', 827009, '2019-10-29', NULL, NULL),
(8, 1, 'Chotu', 7753020484, 'a34', '66yui', 'sec 8', 822101, '2019-10-29', NULL, NULL),
(9, 49, 'Hypstar', 8935850328, 'house 43', 'Lane 33', 'Aashna complex, kjkj', 400001, '2019-11-04', NULL, NULL);

-- --------------------------------------------------------

--
-- Table structure for table `author`
--

CREATE TABLE `author` (
  `id` int(10) UNSIGNED NOT NULL,
  `name` varchar(30) COLLATE utf8mb4_bin NOT NULL,
  `popularity` int(9) UNSIGNED NOT NULL DEFAULT '0',
  `created_at` date DEFAULT NULL,
  `updated_at` date DEFAULT NULL,
  `deleted_at` date DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_bin;

--
-- Dumping data for table `author`
--

INSERT INTO `author` (`id`, `name`, `popularity`, `created_at`, `updated_at`, `deleted_at`) VALUES
(109, 'v b bhandari', 0, '2019-10-17', NULL, NULL),
(110, 'b k pal', 0, '2019-10-17', NULL, NULL),
(111, 'k das', 0, '2019-10-17', NULL, NULL),
(112, 'p k nag', 0, '2019-10-17', NULL, NULL),
(113, 'john f douglas', 0, '2019-10-17', NULL, NULL),
(114, 'janusz m gasiorek', 0, '2019-10-17', NULL, NULL),
(115, 'john a swaffield', 0, '2019-10-17', NULL, NULL),
(116, 'lynne b jack', 0, '2019-10-17', NULL, NULL),
(117, 'v ganesan', 0, '2019-10-17', NULL, NULL),
(118, 'chetan bhagat', 0, '2019-10-17', NULL, NULL),
(119, 's s rattan', 0, '2019-10-17', NULL, NULL),
(120, 'mark lutz', 0, '2019-10-17', NULL, NULL),
(121, ' david ascher', 0, '2019-10-17', NULL, NULL),
(125, ' v b bhandari', 0, '2019-10-17', NULL, NULL),
(126, 'ani', 0, '2019-10-17', NULL, NULL),
(127, ' mesh', 0, '2019-10-17', NULL, NULL),
(128, ' sharma', 0, '2019-10-17', NULL, NULL),
(132, ' p k nag', 0, '2019-10-17', NULL, NULL);

-- --------------------------------------------------------

--
-- Table structure for table `book`
--

CREATE TABLE `book` (
  `id` int(10) UNSIGNED NOT NULL,
  `book_isbn` varchar(20) COLLATE utf8mb4_bin NOT NULL,
  `title` varchar(30) COLLATE utf8mb4_bin NOT NULL,
  `pic` varchar(100) COLLATE utf8mb4_bin DEFAULT NULL,
  `popularity` int(9) UNSIGNED NOT NULL DEFAULT '0',
  `created_at` date DEFAULT NULL,
  `updated_at` date DEFAULT NULL,
  `deleted_at` date DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_bin;

--
-- Dumping data for table `book`
--

INSERT INTO `book` (`id`, `book_isbn`, `title`, `pic`, `popularity`, `created_at`, `updated_at`, `deleted_at`) VALUES
(60, '123456', 'engineering thermodynamics', '5d78dccdcbc8a-engineering-thermodynamics-original-imaehwanf7xmvcht.jpeg', 40, '2019-09-11', NULL, NULL),
(61, '234rdd', 'design of machine elements', '5d78e4a9c64f0-designof.jpeg', 62, '2019-09-11', NULL, NULL),
(62, 'kjih68', 'i c engines', '5d78e4ed11f39-ice.jpg', 7, '2019-09-11', NULL, NULL),
(63, 'asxxxc', 'theory of machines', '5d78e56c91a1e-ssr.jpg', 9, '2019-09-11', NULL, NULL),
(64, 'lkoiijh', 'power plant engineering', '5d78e5ae53d79-ppe.jpg', 8, '2019-09-11', NULL, NULL),
(65, 'trtgd', 'engineering mathematics', '5d80a9241abd9-daspal.jpg', 28, '2019-09-17', NULL, NULL),
(66, 'rev2355', 'revolution 2020', '5d823142b16c2-rev2020.jpeg', 8, '2019-09-18', NULL, NULL),
(67, 'fl1232', 'fluid mechanics', '5d89fcb4709f7-fluidmech.jpg', 26, '2019-09-24', NULL, NULL),
(72, 'py3453', 'learning python', '5da860e256171-pyth.jpg', 16, '2019-10-17', NULL, NULL);

-- --------------------------------------------------------

--
-- Table structure for table `book_author`
--

CREATE TABLE `book_author` (
  `id` int(10) UNSIGNED NOT NULL,
  `author_id` int(10) UNSIGNED DEFAULT NULL,
  `book_id` int(10) UNSIGNED DEFAULT NULL,
  `created_at` date DEFAULT NULL,
  `updated_at` date DEFAULT NULL,
  `deleted_at` date DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_bin;

--
-- Dumping data for table `book_author`
--

INSERT INTO `book_author` (`id`, `author_id`, `book_id`, `created_at`, `updated_at`, `deleted_at`) VALUES
(10, 112, 60, '2019-10-17', NULL, NULL),
(11, 109, 61, '2019-10-17', NULL, NULL),
(12, 117, 62, '2019-10-17', NULL, NULL),
(13, 119, 63, '2019-10-17', NULL, NULL),
(14, 112, 64, NULL, NULL, NULL),
(15, 110, 65, '2019-10-17', NULL, NULL),
(16, 111, 65, '2019-10-17', NULL, NULL),
(17, 118, 66, '2019-10-17', NULL, NULL),
(18, 113, 67, NULL, NULL, NULL),
(19, 114, 67, '2019-10-17', NULL, NULL),
(20, 115, 67, '2019-10-17', NULL, NULL),
(21, 116, 67, '2019-10-17', NULL, NULL),
(22, 120, 72, '2019-10-17', NULL, NULL),
(23, 121, 72, '2019-10-17', NULL, NULL);

-- --------------------------------------------------------

--
-- Table structure for table `book_genre`
--

CREATE TABLE `book_genre` (
  `id` int(10) UNSIGNED NOT NULL,
  `genre_id` int(10) UNSIGNED DEFAULT NULL,
  `book_id` int(10) UNSIGNED DEFAULT NULL,
  `created_at` date DEFAULT NULL,
  `updated_at` date DEFAULT NULL,
  `deleted_at` date DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_bin;

--
-- Dumping data for table `book_genre`
--

INSERT INTO `book_genre` (`id`, `genre_id`, `book_id`, `created_at`, `updated_at`, `deleted_at`) VALUES
(11, 11, 60, '2019-10-17', NULL, NULL),
(12, 11, 61, '2019-10-17', NULL, NULL),
(13, 11, 62, '2019-10-17', NULL, NULL),
(14, 11, 63, '2019-10-17', NULL, NULL),
(15, 11, 64, '2019-10-17', NULL, NULL),
(16, 11, 65, '2019-10-17', NULL, NULL),
(17, 12, 66, '2019-10-17', NULL, NULL),
(18, 11, 67, '2019-10-17', NULL, NULL),
(19, 11, 72, '2019-10-17', NULL, NULL);

-- --------------------------------------------------------

--
-- Table structure for table `book_seller`
--

CREATE TABLE `book_seller` (
  `id` int(10) UNSIGNED NOT NULL,
  `user_id` int(10) UNSIGNED DEFAULT NULL,
  `book_id` int(10) UNSIGNED DEFAULT NULL,
  `quantity` int(10) UNSIGNED DEFAULT NULL,
  `price` int(10) UNSIGNED DEFAULT NULL,
  `created_at` date DEFAULT NULL,
  `updated_at` date DEFAULT NULL,
  `deleted_at` date DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_bin;

--
-- Dumping data for table `book_seller`
--

INSERT INTO `book_seller` (`id`, `user_id`, `book_id`, `quantity`, `price`, `created_at`, `updated_at`, `deleted_at`) VALUES
(35, 49, 60, 256, 550, '2019-09-11', '2019-10-14', NULL),
(36, 51, 61, 1000, 600, '2019-09-11', NULL, NULL),
(37, 51, 62, 300, 460, '2019-09-11', NULL, NULL),
(38, 50, 63, 400, 550, '2019-09-11', NULL, NULL),
(39, 50, 64, 300, 470, '2019-09-11', NULL, NULL),
(40, 49, 64, 500, 510, '2019-09-18', NULL, NULL),
(41, 51, 65, 400, 357, '2019-09-17', NULL, NULL),
(42, 50, 66, 2000, 195, '2019-09-18', NULL, NULL),
(43, 49, 66, 144, 545, '2019-09-23', NULL, NULL),
(44, 49, 67, 400, 459, '2019-09-24', NULL, NULL),
(45, 49, 60, 36, 559, '2019-10-17', '2019-10-17', NULL),
(49, 49, 72, 450, 390, '2019-10-17', NULL, NULL);

-- --------------------------------------------------------

--
-- Table structure for table `book_tag`
--

CREATE TABLE `book_tag` (
  `id` int(10) UNSIGNED NOT NULL,
  `tag_id` int(10) UNSIGNED DEFAULT NULL,
  `book_id` int(10) UNSIGNED DEFAULT NULL,
  `created_at` date DEFAULT NULL,
  `updated_at` date DEFAULT NULL,
  `deleted_at` date DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_bin;

--
-- Dumping data for table `book_tag`
--

INSERT INTO `book_tag` (`id`, `tag_id`, `book_id`, `created_at`, `updated_at`, `deleted_at`) VALUES
(3, 3, 66, '2019-10-17', NULL, NULL),
(4, 4, 66, '2019-10-17', NULL, NULL),
(5, 5, 60, '2019-10-17', NULL, NULL),
(6, 5, 61, '2019-10-17', NULL, NULL),
(7, 5, 62, '2019-10-17', NULL, NULL),
(8, 5, 63, '2019-10-17', NULL, NULL),
(9, 5, 64, '2019-10-17', NULL, NULL),
(10, 5, 65, '2019-10-17', NULL, NULL),
(11, 5, 67, '2019-10-17', NULL, NULL),
(12, 5, 72, '2019-10-17', NULL, NULL),
(13, 3, 60, '2019-10-17', NULL, NULL),
(14, 4, 61, '2019-10-17', NULL, NULL),
(15, 3, 62, '2019-10-17', NULL, NULL),
(16, 4, 63, '2019-10-17', NULL, NULL),
(17, 3, 64, '2019-10-17', NULL, NULL),
(18, 4, 65, '2019-10-17', NULL, NULL),
(19, 3, 67, '2019-10-17', NULL, NULL),
(20, 4, 72, '2019-10-17', NULL, NULL);

-- --------------------------------------------------------

--
-- Table structure for table `cart`
--

CREATE TABLE `cart` (
  `id` int(10) UNSIGNED NOT NULL,
  `user_id` int(10) UNSIGNED NOT NULL,
  `book_seller_id` int(10) UNSIGNED NOT NULL,
  `quantity` int(5) DEFAULT '1',
  `order_uid` varchar(40) COLLATE utf8mb4_bin DEFAULT NULL,
  `tracking_id` varchar(30) COLLATE utf8mb4_bin DEFAULT 'Not Shipped',
  `created_at` date DEFAULT NULL,
  `updated_at` date DEFAULT NULL,
  `deleted_at` date DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_bin;

--
-- Dumping data for table `cart`
--

INSERT INTO `cart` (`id`, `user_id`, `book_seller_id`, `quantity`, `order_uid`, `tracking_id`, `created_at`, `updated_at`, `deleted_at`) VALUES
(46, 1, 35, 2, 'OD-2019-11-01-5dbbf678716e5', 'hjgjhggvfAjkddss', '2019-11-01', '2019-11-01', NULL),
(47, 1, 41, 1, 'OD-2019-11-01-5dbbf678716e5', 'Not Shipped', '2019-11-01', '2019-11-01', NULL),
(48, 1, 44, 2, 'OD-2019-11-01-5dbbf6a215611', 'Not Shipped', '2019-11-01', '2019-11-01', NULL),
(49, 1, 37, 1, 'OD-2019-11-01-5dbbf6a215611', 'Not Shipped', '2019-11-01', '2019-11-01', NULL),
(50, 1, 49, 1, 'OD-2019-11-01-5dbbf6a215611', 'Not Shipped', '2019-11-01', '2019-11-01', NULL),
(51, 1, 35, 2, 'OD-2019-11-02-5dbd36e1e13dd', 'Not Shipped', '2019-11-01', '2019-11-02', NULL),
(52, 1, 35, 2, 'OD-2019-11-02-5dbd3e5233afd', 'Not Shipped', '2019-11-02', '2019-11-02', NULL);

-- --------------------------------------------------------

--
-- Table structure for table `genre`
--

CREATE TABLE `genre` (
  `id` int(10) UNSIGNED NOT NULL,
  `name` varchar(30) COLLATE utf8mb4_bin DEFAULT NULL,
  `created_at` date DEFAULT NULL,
  `updated_at` date DEFAULT NULL,
  `deleted_at` date DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_bin;

--
-- Dumping data for table `genre`
--

INSERT INTO `genre` (`id`, `name`, `created_at`, `updated_at`, `deleted_at`) VALUES
(11, 'engineering', '2019-10-17', NULL, NULL),
(12, 'fiction', '2019-10-17', NULL, NULL);

-- --------------------------------------------------------

--
-- Table structure for table `orders`
--

CREATE TABLE `orders` (
  `id` int(8) UNSIGNED NOT NULL,
  `order_uid` varchar(40) COLLATE utf8mb4_bin NOT NULL,
  `user_id` int(9) UNSIGNED NOT NULL,
  `transaction_id` varchar(20) COLLATE utf8mb4_bin DEFAULT NULL,
  `address_id` int(8) UNSIGNED NOT NULL,
  `amount` int(9) DEFAULT NULL,
  `order_date` timestamp NOT NULL DEFAULT CURRENT_TIMESTAMP
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_bin;

--
-- Dumping data for table `orders`
--

INSERT INTO `orders` (`id`, `order_uid`, `user_id`, `transaction_id`, `address_id`, `amount`, `order_date`) VALUES
(47, 'OD-2019-11-01-5dbbf678716e5', 1, NULL, 7, NULL, '2019-11-01 09:10:16'),
(48, 'OD-2019-11-01-5dbbf6a215611', 1, NULL, 8, NULL, '2019-11-01 09:10:58'),
(49, 'OD-2019-11-02-5dbd36e1e13dd', 1, NULL, 7, NULL, '2019-11-02 07:57:21'),
(50, 'OD-2019-11-02-5dbd3e5233afd', 1, NULL, 7, NULL, '2019-11-02 08:29:06');

-- --------------------------------------------------------

--
-- Table structure for table `payment_mode`
--

CREATE TABLE `payment_mode` (
  `id` int(11) NOT NULL,
  `name` varchar(20) COLLATE utf8mb4_bin DEFAULT NULL,
  `created_at` date DEFAULT NULL,
  `updated_at` date DEFAULT NULL,
  `deleted_at` date DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_bin;

-- --------------------------------------------------------

--
-- Table structure for table `pincode`
--

CREATE TABLE `pincode` (
  `pin` int(7) UNSIGNED NOT NULL,
  `city` varchar(20) COLLATE utf8mb4_bin NOT NULL,
  `district` varchar(20) COLLATE utf8mb4_bin NOT NULL,
  `state` varchar(20) COLLATE utf8mb4_bin NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_bin;

--
-- Dumping data for table `pincode`
--

INSERT INTO `pincode` (`pin`, `city`, `district`, `state`) VALUES
(100034, '', '', ''),
(180001, 'Jammu', 'Jammu', 'Jammu & Kashmir'),
(180005, '', '', ''),
(400001, 'Mumbai', 'Mumbai', 'Maharashtra'),
(700036, 'Kolkata', 'Kolkata', 'West Bengal'),
(700107, 'Kolkata', 'Kolkata', 'West Bengal'),
(751024, 'Bhubaneswar', 'Khorda', 'Odisha'),
(767766, '', '', ''),
(767767, '', '', ''),
(822101, 'Daltonganj', 'Palamau', 'Jharkhand'),
(827001, 'Chas', 'Bokaro', 'Jharkhand'),
(827004, 'Chas', 'Bokaro', 'Jharkhand'),
(827009, 'Bokaro', 'Bokaro', 'Jharkhand'),
(827013, 'Bokaro', 'Bokaro', 'Jharkhand');

-- --------------------------------------------------------

--
-- Table structure for table `searches`
--

CREATE TABLE `searches` (
  `id` int(9) UNSIGNED NOT NULL,
  `user_id` int(9) UNSIGNED NOT NULL,
  `search` varchar(20) COLLATE utf8mb4_bin NOT NULL,
  `date` timestamp NOT NULL DEFAULT CURRENT_TIMESTAMP
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_bin;

--
-- Dumping data for table `searches`
--

INSERT INTO `searches` (`id`, `user_id`, `search`, `date`) VALUES
(1, 1, 'dd', '2019-10-23 13:30:19'),
(4, 1, 'a', '2019-10-23 13:32:48'),
(6, 1, 'bb', '2019-10-23 13:34:34'),
(7, 1, 'v b', '2019-10-23 13:34:56'),
(8, 1, 'fluid', '2019-10-23 13:35:09'),
(9, 1, 'a', '2019-10-25 07:00:29'),
(10, 1, 'py', '2019-10-25 07:21:23'),
(11, 1, 'a', '2019-10-25 09:44:55'),
(12, 1, 'inside edge', '2019-10-28 15:33:29'),
(13, 1, 'f', '2019-10-29 10:44:41'),
(14, 1, 'fl', '2019-10-29 10:48:51'),
(15, 1, 'c', '2019-10-29 12:34:33'),
(16, 1, 's', '2019-10-29 12:34:42'),
(17, 1, 'a', '2019-10-31 10:42:49'),
(18, 1, 'b', '2019-11-01 10:27:17'),
(19, 1, 'b', '2019-11-01 10:29:09'),
(20, 1, 'b', '2019-11-01 10:29:29'),
(21, 1, 'b', '2019-11-01 10:29:41'),
(22, 1, 'b', '2019-11-01 10:29:42'),
(23, 1, 'b', '2019-11-01 10:29:58'),
(24, 1, '&amp;#8377', '2019-11-01 10:44:22'),
(25, 1, '&amp;#8377', '2019-11-01 10:46:39'),
(26, 1, '&amp;#8377', '2019-11-01 10:46:40'),
(27, 1, 'a', '2019-11-02 07:54:27'),
(28, 1, 'a', '2019-11-02 07:54:27'),
(29, 49, 'a', '2019-11-02 08:01:22'),
(30, 49, 'des', '2019-11-02 08:01:30'),
(31, 49, 'nag', '2019-11-02 08:02:03'),
(32, 49, 'fluid', '2019-11-02 08:02:17'),
(33, 1, 'bh', '2019-11-02 08:25:29'),
(34, 1, 'fluid', '2019-11-02 10:45:23'),
(35, 1, 'fl', '2019-11-02 10:47:24'),
(36, 1, 'john', '2019-11-02 10:53:12'),
(37, 49, 'a', '2019-11-04 13:30:57'),
(38, 49, 'eng', '2019-11-04 13:31:02'),
(39, 49, 'eng', '2019-11-04 13:31:34'),
(40, 49, 'eng', '2019-11-04 13:32:13'),
(41, 49, 'eng', '2019-11-04 13:32:51'),
(42, 49, 'eng', '2019-11-04 13:33:03'),
(43, 49, 'eng', '2019-11-04 13:33:04'),
(44, 49, 'eng', '2019-11-04 13:33:05'),
(45, 49, 'eng', '2019-11-04 13:33:05'),
(46, 49, 'eng', '2019-11-04 13:33:30'),
(47, 49, 'eng', '2019-11-04 13:34:37'),
(48, 49, 'eng', '2019-11-04 13:35:58'),
(49, 49, 'eng', '2019-11-04 13:36:22'),
(50, 49, 'eng', '2019-11-04 13:38:37'),
(51, 49, 'eng', '2019-11-04 13:42:08'),
(52, 49, 'eng', '2019-11-04 13:42:09'),
(53, 49, 'eng', '2019-11-04 13:42:09'),
(54, 49, 'eng', '2019-11-04 13:42:10'),
(55, 49, 'eng', '2019-11-04 13:42:24'),
(56, 49, 'a', '2019-11-04 13:43:34');

-- --------------------------------------------------------

--
-- Table structure for table `tag`
--

CREATE TABLE `tag` (
  `id` int(10) UNSIGNED NOT NULL,
  `name` varchar(30) COLLATE utf8mb4_bin DEFAULT NULL,
  `created_at` date DEFAULT NULL,
  `updated_at` date DEFAULT NULL,
  `deleted_at` date DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_bin;

--
-- Dumping data for table `tag`
--

INSERT INTO `tag` (`id`, `name`, `created_at`, `updated_at`, `deleted_at`) VALUES
(3, 'best seller', '2019-10-17', NULL, NULL),
(4, 'new arrival', '2019-10-17', NULL, NULL),
(5, 'textbook', '2019-10-17', NULL, NULL);

-- --------------------------------------------------------

--
-- Table structure for table `user`
--

CREATE TABLE `user` (
  `id` int(10) UNSIGNED NOT NULL,
  `unique_id` varchar(20) COLLATE utf8mb4_bin NOT NULL,
  `name` varchar(80) COLLATE utf8mb4_bin NOT NULL,
  `email` varchar(300) COLLATE utf8mb4_bin NOT NULL,
  `phone` bigint(15) UNSIGNED NOT NULL,
  `pass` varchar(100) COLLATE utf8mb4_bin NOT NULL,
  `user_type_id` int(1) NOT NULL,
  `created_at` date DEFAULT NULL,
  `updated_at` date DEFAULT NULL,
  `deleted_at` date DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_bin;

--
-- Dumping data for table `user`
--

INSERT INTO `user` (`id`, `unique_id`, `name`, `email`, `phone`, `pass`, `user_type_id`, `created_at`, `updated_at`, `deleted_at`) VALUES
(1, '5d6e34a32736f', 'Animesh', 'animesh1@live.com', 8986722466, 'qwerty', 2, '2019-09-01', '2019-11-02', NULL),
(49, '5d70dc842387e', 'HYPSTAR', 'hypstar124@gmail.com', 8935850328, 'qwerty', 3, '2019-09-05', '2019-11-04', NULL),
(50, '5d70fd74cb1ef', 'sellerxyz', 'sellerxyz@seller.com', 123456, 'qwerty', 3, '2019-09-05', NULL, NULL),
(51, '5d710babb7635', 'sellerqwe', 'seller2@seller.com', 56775, 'qwerty', 3, '2019-09-05', NULL, NULL),
(52, '5d7276a345b28', 'sevii', 'hgcgnjcvj@aaaqq.com', 1234511, '1111', 3, '2019-09-06', NULL, NULL),
(53, '5d84c4feb9ce2', 'aniemsh', 'dfs@jhjh.com', 1221212121, 'qwerty', 2, '2019-09-20', NULL, NULL),
(54, '5d84c5b547ca2', 'animehss', 'sevi@sevi.com', 8986722466, '12345', 2, '2019-09-20', '2019-10-15', NULL),
(65, '5da5a6fcc8142', 'animesh', 'seller@saeller.com', 8986722466, 'qqqqq', 2, '2019-10-15', NULL, NULL),
(66, '5da5a76541c5a', 'animesh', 'sellaaaaaer@seller.com', 8986722466, 'qqq', 2, '2019-10-15', NULL, NULL),
(67, '5da5a832a28a8', 'animesh', 'sellaaaaaer@seller.comz', 8986722466, 'aaaaa', 2, '2019-10-15', NULL, NULL),
(68, '5da5ae625879c', 'dcd', 'dds@fvsv.v', 9999876565, 'qqqq', 3, '2019-10-15', NULL, NULL),
(70, '5da6fbc005679', 'Anni', 'beingannni@gmail.com', 8935850328, '11111', 2, '2019-10-16', NULL, NULL),
(71, '5da6fcc42c3e7', 'Surabhi Sharma', 'sevi2202@gmail.com', 8249544810, '12345', 2, '2019-10-16', '2019-10-16', NULL);

-- --------------------------------------------------------

--
-- Table structure for table `user_type`
--

CREATE TABLE `user_type` (
  `id` int(11) NOT NULL,
  `name` varchar(10) COLLATE utf8mb4_bin DEFAULT NULL,
  `created_at` date DEFAULT NULL,
  `updated_at` date DEFAULT NULL,
  `deleted_at` date DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_bin;

--
-- Dumping data for table `user_type`
--

INSERT INTO `user_type` (`id`, `name`, `created_at`, `updated_at`, `deleted_at`) VALUES
(1, 'admin', NULL, NULL, NULL),
(2, 'customer', NULL, NULL, NULL),
(3, 'seller', NULL, NULL, NULL);

--
-- Indexes for dumped tables
--

--
-- Indexes for table `address`
--
ALTER TABLE `address`
  ADD PRIMARY KEY (`id`),
  ADD KEY `fkuser` (`user_id`),
  ADD KEY `fkpin` (`pin`);

--
-- Indexes for table `author`
--
ALTER TABLE `author`
  ADD PRIMARY KEY (`id`),
  ADD UNIQUE KEY `name` (`name`);

--
-- Indexes for table `book`
--
ALTER TABLE `book`
  ADD PRIMARY KEY (`id`),
  ADD UNIQUE KEY `book_isbn` (`book_isbn`),
  ADD UNIQUE KEY `pic` (`pic`);

--
-- Indexes for table `book_author`
--
ALTER TABLE `book_author`
  ADD PRIMARY KEY (`id`),
  ADD UNIQUE KEY `author_id` (`author_id`,`book_id`),
  ADD KEY `fkbook3` (`book_id`);

--
-- Indexes for table `book_genre`
--
ALTER TABLE `book_genre`
  ADD PRIMARY KEY (`id`),
  ADD UNIQUE KEY `genre_id` (`genre_id`,`book_id`),
  ADD KEY `fkbook4` (`book_id`);

--
-- Indexes for table `book_seller`
--
ALTER TABLE `book_seller`
  ADD PRIMARY KEY (`id`),
  ADD UNIQUE KEY `user_id` (`user_id`,`book_id`,`price`),
  ADD KEY `fkbook5` (`book_id`);

--
-- Indexes for table `book_tag`
--
ALTER TABLE `book_tag`
  ADD PRIMARY KEY (`id`),
  ADD UNIQUE KEY `tag_id` (`tag_id`,`book_id`),
  ADD KEY `fkbook2` (`book_id`);

--
-- Indexes for table `cart`
--
ALTER TABLE `cart`
  ADD PRIMARY KEY (`id`),
  ADD UNIQUE KEY `user_id` (`user_id`,`book_seller_id`,`order_uid`),
  ADD KEY `fkbookseller` (`book_seller_id`),
  ADD KEY `fkorderuid1` (`order_uid`);

--
-- Indexes for table `genre`
--
ALTER TABLE `genre`
  ADD PRIMARY KEY (`id`),
  ADD UNIQUE KEY `name` (`name`);

--
-- Indexes for table `orders`
--
ALTER TABLE `orders`
  ADD PRIMARY KEY (`id`),
  ADD UNIQUE KEY `order_uid` (`order_uid`),
  ADD KEY `fkuser13` (`user_id`),
  ADD KEY `fkaddre` (`address_id`);

--
-- Indexes for table `payment_mode`
--
ALTER TABLE `payment_mode`
  ADD PRIMARY KEY (`id`);

--
-- Indexes for table `pincode`
--
ALTER TABLE `pincode`
  ADD PRIMARY KEY (`pin`);

--
-- Indexes for table `searches`
--
ALTER TABLE `searches`
  ADD PRIMARY KEY (`id`),
  ADD KEY `fkuser9` (`user_id`);

--
-- Indexes for table `tag`
--
ALTER TABLE `tag`
  ADD PRIMARY KEY (`id`),
  ADD UNIQUE KEY `name` (`name`);

--
-- Indexes for table `user`
--
ALTER TABLE `user`
  ADD PRIMARY KEY (`id`),
  ADD UNIQUE KEY `unique_id` (`unique_id`),
  ADD UNIQUE KEY `email` (`email`),
  ADD KEY `fkuser_type` (`user_type_id`);

--
-- Indexes for table `user_type`
--
ALTER TABLE `user_type`
  ADD PRIMARY KEY (`id`);

--
-- AUTO_INCREMENT for dumped tables
--

--
-- AUTO_INCREMENT for table `address`
--
ALTER TABLE `address`
  MODIFY `id` int(8) UNSIGNED NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=10;
--
-- AUTO_INCREMENT for table `author`
--
ALTER TABLE `author`
  MODIFY `id` int(10) UNSIGNED NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=133;
--
-- AUTO_INCREMENT for table `book`
--
ALTER TABLE `book`
  MODIFY `id` int(10) UNSIGNED NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=73;
--
-- AUTO_INCREMENT for table `book_author`
--
ALTER TABLE `book_author`
  MODIFY `id` int(10) UNSIGNED NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=24;
--
-- AUTO_INCREMENT for table `book_genre`
--
ALTER TABLE `book_genre`
  MODIFY `id` int(10) UNSIGNED NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=20;
--
-- AUTO_INCREMENT for table `book_seller`
--
ALTER TABLE `book_seller`
  MODIFY `id` int(10) UNSIGNED NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=50;
--
-- AUTO_INCREMENT for table `book_tag`
--
ALTER TABLE `book_tag`
  MODIFY `id` int(10) UNSIGNED NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=21;
--
-- AUTO_INCREMENT for table `cart`
--
ALTER TABLE `cart`
  MODIFY `id` int(10) UNSIGNED NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=55;
--
-- AUTO_INCREMENT for table `genre`
--
ALTER TABLE `genre`
  MODIFY `id` int(10) UNSIGNED NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=13;
--
-- AUTO_INCREMENT for table `orders`
--
ALTER TABLE `orders`
  MODIFY `id` int(8) UNSIGNED NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=51;
--
-- AUTO_INCREMENT for table `searches`
--
ALTER TABLE `searches`
  MODIFY `id` int(9) UNSIGNED NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=57;
--
-- AUTO_INCREMENT for table `tag`
--
ALTER TABLE `tag`
  MODIFY `id` int(10) UNSIGNED NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=6;
--
-- AUTO_INCREMENT for table `user`
--
ALTER TABLE `user`
  MODIFY `id` int(10) UNSIGNED NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=72;
--
-- Constraints for dumped tables
--

--
-- Constraints for table `address`
--
ALTER TABLE `address`
  ADD CONSTRAINT `fkpin` FOREIGN KEY (`pin`) REFERENCES `pincode` (`pin`),
  ADD CONSTRAINT `fkuser` FOREIGN KEY (`user_id`) REFERENCES `user` (`id`);

--
-- Constraints for table `book_author`
--
ALTER TABLE `book_author`
  ADD CONSTRAINT `fkauthor` FOREIGN KEY (`author_id`) REFERENCES `author` (`id`),
  ADD CONSTRAINT `fkbook3` FOREIGN KEY (`book_id`) REFERENCES `book` (`id`);

--
-- Constraints for table `book_genre`
--
ALTER TABLE `book_genre`
  ADD CONSTRAINT `fkbook4` FOREIGN KEY (`book_id`) REFERENCES `book` (`id`),
  ADD CONSTRAINT `fkgenre` FOREIGN KEY (`genre_id`) REFERENCES `genre` (`id`);

--
-- Constraints for table `book_seller`
--
ALTER TABLE `book_seller`
  ADD CONSTRAINT `fkbook5` FOREIGN KEY (`book_id`) REFERENCES `book` (`id`),
  ADD CONSTRAINT `fkuser4` FOREIGN KEY (`user_id`) REFERENCES `user` (`id`);

--
-- Constraints for table `book_tag`
--
ALTER TABLE `book_tag`
  ADD CONSTRAINT `fkbook2` FOREIGN KEY (`book_id`) REFERENCES `book` (`id`),
  ADD CONSTRAINT `fktag` FOREIGN KEY (`tag_id`) REFERENCES `tag` (`id`);

--
-- Constraints for table `cart`
--
ALTER TABLE `cart`
  ADD CONSTRAINT `fkbookseller` FOREIGN KEY (`book_seller_id`) REFERENCES `book_seller` (`id`),
  ADD CONSTRAINT `fkorderuid1` FOREIGN KEY (`order_uid`) REFERENCES `orders` (`order_uid`),
  ADD CONSTRAINT `fkuser2` FOREIGN KEY (`user_id`) REFERENCES `user` (`id`);

--
-- Constraints for table `orders`
--
ALTER TABLE `orders`
  ADD CONSTRAINT `fkaddre` FOREIGN KEY (`address_id`) REFERENCES `address` (`id`),
  ADD CONSTRAINT `fkuser13` FOREIGN KEY (`user_id`) REFERENCES `user` (`id`);

--
-- Constraints for table `searches`
--
ALTER TABLE `searches`
  ADD CONSTRAINT `fkuser9` FOREIGN KEY (`user_id`) REFERENCES `user` (`id`);

--
-- Constraints for table `user`
--
ALTER TABLE `user`
  ADD CONSTRAINT `fkuser_type` FOREIGN KEY (`user_type_id`) REFERENCES `user_type` (`id`);

/*!40101 SET CHARACTER_SET_CLIENT=@OLD_CHARACTER_SET_CLIENT */;
/*!40101 SET CHARACTER_SET_RESULTS=@OLD_CHARACTER_SET_RESULTS */;
/*!40101 SET COLLATION_CONNECTION=@OLD_COLLATION_CONNECTION */;
