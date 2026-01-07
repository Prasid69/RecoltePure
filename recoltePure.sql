-- phpMyAdmin SQL Dump
-- version 5.2.1
-- https://www.phpmyadmin.net/
--
-- Host: 127.0.0.1
-- Generation Time: Jan 07, 2026 at 02:10 PM
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
-- Database: `recoltepure`
--

-- --------------------------------------------------------

--
-- Table structure for table `admins`
--

CREATE TABLE `admins` (
  `id` int(11) NOT NULL,
  `email` varchar(255) NOT NULL,
  `password_hash` varchar(255) NOT NULL,
  `created_at` datetime DEFAULT current_timestamp()
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

--
-- Dumping data for table `admins`
--

INSERT INTO `admins` (`id`, `email`, `password_hash`, `created_at`) VALUES
(1, 'admin@example.com', '$2y$10$LCNHgKQ7y4/0XWieHzEw4udHNcp7PeLrImnJsNCVPMGHx8dEeDnri', '2025-12-17 09:18:18'),
(2, 'admin1@gmail.com', '$2y$10$xoM8dphSMyGMeNGHJW7K0OhagLhhcugwame63KbvklXnmGb8.KGSq', '2025-12-17 13:56:42');

-- --------------------------------------------------------

--
-- Table structure for table `categories`
--

CREATE TABLE `categories` (
  `category_id` int(11) NOT NULL,
  `category_name` varchar(100) DEFAULT NULL,
  `image` varchar(255) DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

--
-- Dumping data for table `categories`
--

INSERT INTO `categories` (`category_id`, `category_name`, `image`) VALUES
(1, 'fruits', NULL),
(2, 'vegetable\r\n', NULL),
(3, 'herbs', NULL),
(4, 'Dairy Product', NULL);

-- --------------------------------------------------------

--
-- Table structure for table `certificate`
--

CREATE TABLE `certificate` (
  `certificate_id` int(11) NOT NULL,
  `certificate_name` varchar(100) DEFAULT NULL,
  `farmer_id` int(11) DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

-- --------------------------------------------------------

--
-- Table structure for table `contact_messages`
--

CREATE TABLE `contact_messages` (
  `id` int(11) NOT NULL,
  `first_name` varchar(100) NOT NULL,
  `last_name` varchar(100) NOT NULL,
  `email` varchar(255) NOT NULL,
  `phone` varchar(20) DEFAULT NULL,
  `subject` varchar(255) NOT NULL,
  `message` text NOT NULL,
  `created_at` timestamp NOT NULL DEFAULT current_timestamp(),
  `status` enum('new','read','replied') DEFAULT 'new'
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

--
-- Dumping data for table `contact_messages`
--

INSERT INTO `contact_messages` (`id`, `first_name`, `last_name`, `email`, `phone`, `subject`, `message`, `created_at`, `status`) VALUES
(1, 'khushi', 'gajjar', 'khushigajjar218@gmail.com', '+917043022473', 'general', 'Where is the store located?', '2025-12-17 15:53:32', 'new'),
(2, 'Khushi', 'gajjar', 'khushigajjar218@gmail.com', '+917043022473', 'products', 'When will my product arrive?', '2025-12-17 15:54:02', 'new'),
(3, 'Khushi', 'Gajjar', 'khushigajjar218@gmail.com', '+917043022473', 'feedback', 'qwergthyjkl', '2025-12-17 15:54:21', 'new'),
(4, 'Khushi', 'Gajjar', 'khushigajjar218@gmail.com', '+917043022473', 'products', 'when product arrive?', '2025-12-17 16:03:26', 'new');

-- --------------------------------------------------------

--
-- Table structure for table `delivery`
--

CREATE TABLE `delivery` (
  `delivery_id` int(11) NOT NULL,
  `order_id` int(11) DEFAULT NULL,
  `delivery_date` date DEFAULT NULL,
  `delivery_status` varchar(45) DEFAULT NULL,
  `delivery_partner` varchar(100) DEFAULT NULL,
  `tracking_number` varchar(45) DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

--
-- Dumping data for table `delivery`
--

INSERT INTO `delivery` (`delivery_id`, `order_id`, `delivery_date`, `delivery_status`, `delivery_partner`, `tracking_number`) VALUES
(1, 1, '2025-11-21', 'Confirmed', 'xyz', '1234hb'),
(101, 500, '2025-12-16', 'Delivered', 'FastShip', 'TRK123456789'),
(1765919776, 1765919776, '2025-12-16', 'Pending', 'Waiting', 'N/A'),
(1765919911, 1765919911, '2025-12-16', 'Pending', 'Waiting', 'N/A'),
(1765919912, NULL, NULL, 'Pending', 'Waiting', 'N/A'),
(1765919913, NULL, NULL, 'Pending', 'Waiting', 'N/A'),
(1765921474, 1765921474, '2025-12-16', 'Pending', 'Waiting', 'N/A'),
(1765922306, 1765922306, '2025-12-16', 'Pending', 'Waiting', 'N/A'),
(1765923517, 1765923517, '2025-12-16', 'Pending', 'Waiting', 'N/A'),
(1765924870, 1765924870, '2025-12-16', 'Pending', 'Waiting', 'N/A'),
(1765925021, 1765925021, '2025-12-16', 'Pending', 'Waiting', 'N/A'),
(1765957906, 1765957906, '2025-12-17', 'Pending', 'Waiting', 'N/A'),
(1765965730, 1765965730, '2025-12-17', 'Pending', 'Waiting', 'N/A'),
(1765973842, 1765973842, '2025-12-17', 'Pending', 'Waiting', 'N/A'),
(1765973869, 1765973869, '2025-12-17', 'Pending', 'Waiting', 'N/A'),
(1765976888, 1765976888, '2025-12-17', 'Pending', 'Waiting', 'N/A'),
(1765978056, 1765978056, '2025-12-17', 'Pending', 'Waiting', 'N/A'),
(1765982449, 1765982449, '2025-12-17', 'Pending', 'Waiting', 'N/A'),
(1765983661, 1765983661, '2025-12-17', 'Pending', 'Waiting', 'N/A');

-- --------------------------------------------------------

--
-- Table structure for table `farmer`
--

CREATE TABLE `farmer` (
  `farmer_id` int(11) NOT NULL,
  `name` varchar(100) DEFAULT NULL,
  `email` varchar(100) DEFAULT NULL,
  `phone_number` varchar(15) DEFAULT NULL,
  `address` varchar(255) DEFAULT NULL,
  `certificate_number` varchar(45) DEFAULT NULL,
  `verification_date` date DEFAULT NULL,
  `registration_date` datetime DEFAULT NULL,
  `password` varchar(255) DEFAULT NULL,
  `account_status` enum('Pending','Verified') DEFAULT 'Pending'
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

--
-- Dumping data for table `farmer`
--

INSERT INTO `farmer` (`farmer_id`, `name`, `email`, `phone_number`, `address`, `certificate_number`, `verification_date`, `registration_date`, `password`, `account_status`) VALUES
(2, 'Max', 'max2@gmail.com', '7896541230', 'Paris, France', '2', '2025-11-06', '2025-11-06 00:00:00', '$2y$10$XncH1lTL8S205ZlRI70wv.l2oa28HP.NZgM2gZ8APtGvPzo6YV0Hq', 'Verified'),
(3, 'John Doe', 'john@gmail.com', '7412589631', '123 Farm Lane, Springfield', '3', '2025-11-04', '2025-11-04 00:00:00', '$2y$10$9ruOL7x2T2Utejl96Mp2MOh2xQB/I2R/R0SMp3G55LokeoWGjpuR2', 'Pending'),
(4, 'Lexi Hensler', 'lexi@gmail.com', '78945613', 'Porte de Vanes', '4', '2025-12-13', '2025-12-12 00:00:00', '$2y$10$HTmsHbOkAKOgOMSgu6D/meBVkp1ET6fE4Th98nmiqWkoRy0ncPc3.', 'Pending'),
(5, 'Jacques Martin', 'martin@gmail.com', '456123879', '12 Bd Rodin', '5', '2025-12-11', '2025-12-18 00:00:00', '$2y$10$XtElQhC.t6AjJ2vsZBHF4.xUjpflr3A8n9kTKbpVyNA7iC2d8aHlC', 'Pending'),
(6, 'Luc Moreau', 'luc@gmail.com', '987654321', 'Paris', '6', '2025-12-11', '2025-12-11 00:00:00', '$2y$10$h841OonWpRU77ext.E//POC51nnTUihw4F70cF8WycohFtSQouZRi', 'Verified'),
(7, 'Henri Lefèvre', 'henri@gmail.com', '6543298712', 'Malakoff', '7', '2025-12-19', '2025-12-20 00:00:00', '$2y$10$lkID89L4d56yk33LJq/MFeCzxbK8m0sDowzVpz4fzEgHleWp6DLeq', 'Verified'),
(8, 'khushi gajjar', 'khushigajjar218@gmail.com', '07043074573', 'Paris', '8', '2025-12-15', '2025-12-17 00:00:00', '$2y$10$a9n5ZMuO4dHyllRZIDWl1.FsMb3dqFw3A3kqrtVPBSDlsfPcfzrBS', 'Verified');

-- --------------------------------------------------------

--
-- Table structure for table `order_or_cart`
--

CREATE TABLE `order_or_cart` (
  `order_cart_id` int(11) NOT NULL,
  `customer_id` int(11) NOT NULL,
  `delivery_id` int(11) NOT NULL,
  `product_id` int(11) NOT NULL,
  `quantity` int(11) NOT NULL DEFAULT 1,
  `total_price` decimal(10,2) NOT NULL,
  `delivery_date` datetime NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

--
-- Dumping data for table `order_or_cart`
--

INSERT INTO `order_or_cart` (`order_cart_id`, `customer_id`, `delivery_id`, `product_id`, `quantity`, `total_price`, `delivery_date`) VALUES
(1, 1, 1765924870, 20, 1, 520.00, '2025-12-16 23:41:10'),
(2, 1, 1765924870, 38, 1, 1890.00, '2025-12-16 23:41:10'),
(3, 1, 1765925021, 41, 1, 500.00, '2025-12-16 23:43:41'),
(4, 1, 1765957906, 37, 1, 60.00, '2025-12-17 08:51:46'),
(5, 1, 1765965730, 17, 1, 180.00, '2025-12-17 11:02:10'),
(6, 1, 1765973842, 30, 1, 1800.00, '2025-12-17 13:17:22'),
(7, 1, 1765973869, 37, 1, 300.00, '2025-12-17 13:17:49'),
(8, 1, 1765973869, 15, 1, 250.00, '2025-12-17 13:17:49'),
(9, 1, 1765976888, 39, 1, 140.00, '2025-12-17 14:08:08'),
(10, 1, 1765976888, 41, 1, 500.00, '2025-12-17 14:08:08'),
(11, 1, 1765978056, 39, 1, 70.00, '2025-12-17 14:27:36'),
(12, 1, 1765982449, 42, 1, 1200.00, '2025-12-17 15:40:49'),
(13, 1, 1765983661, 26, 1, 500.00, '2025-12-17 16:01:01'),
(14, 1, 1765983661, 37, 1, 60.00, '2025-12-17 16:01:01');

-- --------------------------------------------------------

--
-- Table structure for table `products`
--

CREATE TABLE `products` (
  `product_id` int(11) NOT NULL,
  `created_on` datetime(6) NOT NULL DEFAULT current_timestamp(6),
  `farmer_id` int(11) DEFAULT NULL,
  `category_id` int(11) DEFAULT NULL,
  `product_name` varchar(100) DEFAULT NULL,
  `price` decimal(10,2) DEFAULT NULL,
  `old_price` int(11) DEFAULT NULL,
  `stock_quantity` int(11) DEFAULT NULL,
  `product_description` varchar(1000) NOT NULL,
  `image` varchar(255) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

--
-- Dumping data for table `products`
--

INSERT INTO `products` (`product_id`, `created_on`, `farmer_id`, `category_id`, `product_name`, `price`, `old_price`, `stock_quantity`, `product_description`, `image`) VALUES
(5, '2025-12-10 14:59:21.782920', 2, 3, 'Bay Leaf', 50.00, 45, 40, 'BAy Leaf', '1765375161_bayleaf (2).png'),
(6, '2025-12-10 15:42:05.974859', 2, 3, 'oregano', 100.00, 90, 60, 'Oregano is a species of flowering plant in the mint family, Lamiaceae.', '1765377725_oregano.png'),
(7, '2025-12-12 07:52:50.408547', 4, 4, 'Gelato', 60.00, 60, 100, 'Handmade from whole milk, sugar, and other flavourings, typically fruit, chocolate, and nuts', '1765522370_gelato.png'),
(8, '2025-12-12 07:54:37.503439', 4, 4, 'Milk', 80.00, 80, 50, 'Fresh cow milk sourced directly from trusted farms', '1765522477_milk.png'),
(9, '2025-12-12 08:33:13.815503', 7, 4, 'Yogurt', 87.00, 85, 30, 'Fresh 5kg ', '1765524793_yogurt.png'),
(10, '2025-12-12 08:34:50.091555', 7, 4, 'Chesse', 70.00, NULL, 50, 'Fresh Goat Cheese', '1765524890_cheese.png'),
(11, '2025-12-12 08:35:52.033455', 7, 4, 'Custard', 52.00, NULL, 20, 'Custard', '1765524952_custard.png'),
(12, '2025-12-12 08:36:30.741330', 7, 4, 'Milk Creame', 70.00, NULL, 10, 'Fesh Milk Creame', '1765524990_milk creame.png'),
(13, '2025-12-12 08:38:24.172317', 7, 4, 'Milk Creame', 70.00, NULL, 10, 'Fesh Milk Creame', '1765525104_milk creame.png'),
(14, '2025-12-12 09:05:10.132911', 6, 3, 'Clove', 40.00, NULL, 10, '\\r\\nclove', '1765526710_clove.png'),
(15, '2025-12-12 09:05:38.166209', 6, 3, 'Curry Leaf', 50.00, NULL, 20, 'curry leaf', '1765526738_curryleaf.png'),
(16, '2025-12-12 09:06:07.582439', 6, 3, 'Mint', 70.00, 75, 30, 'mint', '1765526767_Mint.png'),
(17, '2025-12-12 09:06:29.151045', 6, 3, 'Basil', 60.00, NULL, 20, 'Basil', '1765526789_basil.png'),
(18, '2025-12-12 09:16:54.065899', 5, 1, 'Peach', 630.00, NULL, 30, 'peach', '1765527414_peach.png'),
(19, '2025-12-12 09:17:19.095698', 5, 1, 'Strawberry', 250.00, NULL, 60, 'strawberry', '1765527439_strawberry.png'),
(20, '2025-12-12 09:17:44.390595', 5, 1, 'Framboise', 520.00, NULL, 40, 'Framboise', '1765527464_f.png'),
(21, '2025-12-12 09:18:14.510817', 5, 1, 'Pineapple', 400.00, NULL, 40, 'Pineapple', '1765527494_p.png'),
(22, '2025-12-12 09:18:45.894599', 5, 1, 'Avocat', 450.00, NULL, 30, 'avocat', '1765527525_a.png'),
(23, '2025-12-12 09:19:10.583216', 5, 1, 'Grapes', 600.00, NULL, 50, 'mix grapes', '1765527550_grapes.png'),
(24, '2025-12-12 09:19:39.204975', 5, 1, 'Bananas', 600.00, NULL, 70, 'Banana', '1765527579_b.png'),
(25, '2025-12-12 09:20:36.124748', 5, 1, 'Mango', 700.00, 750, 60, 'mango', '1765527636_m.png'),
(26, '2025-12-12 09:22:09.093471', 5, 1, 'Apple', 500.00, NULL, 40, 'apple\\r\\n', '1765527729_apple.png'),
(27, '2025-12-12 09:23:22.846051', 5, 1, 'Orange', 400.00, NULL, 10, 'orange', '1765527802_orange.png'),
(28, '2025-12-12 09:26:53.892171', 5, 1, 'Dragon Fruit', 800.00, NULL, 30, 'fruit', '1765528013_dragon fruit.png'),
(29, '2025-12-12 09:27:32.867357', 5, 1, 'Cantaloupe', 900.00, NULL, 40, 'fruit', '1765528052_Cantaloupe.png'),
(30, '2025-12-12 09:28:06.629938', 5, 1, 'BlueBerry', 900.00, NULL, 50, 'Blueberry', '1765528086_blue.png'),
(31, '2025-12-12 09:44:36.235155', 4, 2, 'Beet', 95.00, 90, 25, 'beet', '1765529076_beet.png'),
(32, '2025-12-12 09:44:56.611456', 4, 2, 'Onion', 60.00, NULL, 10, 'onion', '1765529096_onion.jpg'),
(33, '2025-12-12 09:45:51.932828', 4, 2, 'Spinach', 500.00, NULL, 45, 'spinach', '1765529151_spinach.jpg'),
(34, '2025-12-12 09:46:29.449964', 4, 2, 'Peas', 60.00, NULL, 20, 'Peas', '1765529189_peas.jpg'),
(35, '2025-12-12 09:46:53.083542', 4, 2, 'Eggplant', 450.00, NULL, 65, 'eggplant', '1765529213_eggplant.png'),
(36, '2025-12-12 09:48:59.985464', 4, 2, 'Cabbage', 40.00, NULL, 10, 'cabbage', '1765529339_cabbage.png'),
(37, '2025-12-12 09:49:29.793980', 4, 2, 'Pepper', 60.00, NULL, 21, 'pepper', '1765529369_capsicums.png'),
(38, '2025-12-12 09:51:40.364785', 4, 2, 'Tomatoes', 630.00, NULL, 60, 'tomatoes', '1765529500_tomatoes.png'),
(39, '2025-12-12 15:20:19.281357', 6, 3, 'Bay Leaf', 70.00, 50, 20, 'Bay Leaf', '1765549219_1765375076_bayleaf (2).png'),
(41, '2025-12-14 15:15:04.503741', 6, 4, 'Egg', 500.00, NULL, 60, 'egg', '1765721704_egg.png'),
(42, '2025-12-17 11:53:48.164836', 6, 2, 'Pupkin', 400.00, NULL, 40, 'Pumpkin', '1765968828_pumpkin.jpg'),
(43, '2025-12-17 15:45:25.121410', 6, 4, 'Egg', 400.00, NULL, 10, 'egg', '1765982725_egg.png');

-- --------------------------------------------------------

--
-- Table structure for table `product_reviews`
--

CREATE TABLE `product_reviews` (
  `review_id` int(11) NOT NULL,
  `user_id` int(10) UNSIGNED NOT NULL,
  `product_id` int(11) NOT NULL,
  `rating` int(11) NOT NULL,
  `comment` text DEFAULT NULL,
  `created_at` timestamp NOT NULL DEFAULT current_timestamp()
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

--
-- Dumping data for table `product_reviews`
--

INSERT INTO `product_reviews` (`review_id`, `user_id`, `product_id`, `rating`, `comment`, `created_at`) VALUES
(1, 1, 20, 4, 'Good Quality', '2025-12-17 08:03:41'),
(2, 1, 17, 2, 'Bad Product', '2025-12-17 12:03:00'),
(3, 1, 37, 4, 'wergbnm', '2025-12-17 15:03:30');

-- --------------------------------------------------------

--
-- Table structure for table `reviews`
--

CREATE TABLE `reviews` (
  `review_id` int(11) NOT NULL,
  `customer_id` int(11) NOT NULL,
  `order_customer_id` int(11) NOT NULL,
  `order_delivery_id` int(11) NOT NULL,
  `rating` int(11) DEFAULT NULL,
  `comment` varchar(255) DEFAULT NULL,
  `review_date` date DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

--
-- Dumping data for table `reviews`
--

INSERT INTO `reviews` (`review_id`, `customer_id`, `order_customer_id`, `order_delivery_id`, `rating`, `comment`, `review_date`) VALUES
(2, 1, 1, 101, 4, 'Good', '2025-12-16');

-- --------------------------------------------------------

--
-- Table structure for table `users`
--

CREATE TABLE `users` (
  `customer_id` int(11) NOT NULL,
  `name` varchar(100) DEFAULT NULL,
  `email` varchar(100) DEFAULT NULL,
  `phone_number` int(10) NOT NULL,
  `address` varchar(255) DEFAULT NULL,
  `password` varchar(255) DEFAULT NULL,
  `registration_date` datetime DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

--
-- Dumping data for table `users`
--

INSERT INTO `users` (`customer_id`, `name`, `email`, `phone_number`, `address`, `password`, `registration_date`) VALUES
(1, 'Khushi', 'khushigajjar218@gmail.com', 704302247, 'Issy Les Moulineaux', '$2y$10$zW7DswCLG70xGE3JVbbbz.77491DAqNDc3PH5tlUtz0.UhKFR3c0i', '2025-11-14 14:07:03'),
(2, 'Dhara Gajjar', 'd@gmail.com', 741874152, 'Issy Les Moulineaux', '$2y$10$an/MU.aEDr/VlU9w/MVWn.1v5oQw28/H6/doyC0Mkw.PkvQxVXIAy', '2025-12-15 12:39:19'),
(5, 'Emily Cooper', 'e@gmail.com', 741258965, 'Paris', '$2y$10$WNrsSM1IcWa8mcLuTsaHIu144fRkOt.OPt4MovDOV0Kg00G/4skBK', '2026-01-07 11:16:28');

--
-- Indexes for dumped tables
--

--
-- Indexes for table `admins`
--
ALTER TABLE `admins`
  ADD PRIMARY KEY (`id`),
  ADD UNIQUE KEY `email` (`email`);

--
-- Indexes for table `categories`
--
ALTER TABLE `categories`
  ADD PRIMARY KEY (`category_id`);

--
-- Indexes for table `certificate`
--
ALTER TABLE `certificate`
  ADD PRIMARY KEY (`certificate_id`),
  ADD KEY `fk_certificate_farmer_idx` (`farmer_id`);

--
-- Indexes for table `contact_messages`
--
ALTER TABLE `contact_messages`
  ADD PRIMARY KEY (`id`),
  ADD KEY `idx_created_at` (`created_at`),
  ADD KEY `idx_status` (`status`),
  ADD KEY `idx_email` (`email`);

--
-- Indexes for table `delivery`
--
ALTER TABLE `delivery`
  ADD PRIMARY KEY (`delivery_id`);

--
-- Indexes for table `farmer`
--
ALTER TABLE `farmer`
  ADD PRIMARY KEY (`farmer_id`);

--
-- Indexes for table `order_or_cart`
--
ALTER TABLE `order_or_cart`
  ADD PRIMARY KEY (`order_cart_id`),
  ADD KEY `customer_id` (`customer_id`),
  ADD KEY `delivery_id` (`delivery_id`),
  ADD KEY `product_id` (`product_id`);

--
-- Indexes for table `products`
--
ALTER TABLE `products`
  ADD PRIMARY KEY (`product_id`),
  ADD KEY `fk_Product_Categories1_idx` (`category_id`),
  ADD KEY `fk_Product_farmer1` (`farmer_id`);

--
-- Indexes for table `product_reviews`
--
ALTER TABLE `product_reviews`
  ADD PRIMARY KEY (`review_id`),
  ADD KEY `fk_review_product` (`product_id`);

--
-- Indexes for table `reviews`
--
ALTER TABLE `reviews`
  ADD PRIMARY KEY (`review_id`),
  ADD KEY `fk_Reviews_order_idx` (`order_customer_id`,`order_delivery_id`);

--
-- Indexes for table `users`
--
ALTER TABLE `users`
  ADD PRIMARY KEY (`customer_id`);

--
-- AUTO_INCREMENT for dumped tables
--

--
-- AUTO_INCREMENT for table `admins`
--
ALTER TABLE `admins`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=3;

--
-- AUTO_INCREMENT for table `categories`
--
ALTER TABLE `categories`
  MODIFY `category_id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=6;

--
-- AUTO_INCREMENT for table `certificate`
--
ALTER TABLE `certificate`
  MODIFY `certificate_id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=2;

--
-- AUTO_INCREMENT for table `contact_messages`
--
ALTER TABLE `contact_messages`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=5;

--
-- AUTO_INCREMENT for table `delivery`
--
ALTER TABLE `delivery`
  MODIFY `delivery_id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=1765983662;

--
-- AUTO_INCREMENT for table `farmer`
--
ALTER TABLE `farmer`
  MODIFY `farmer_id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=9;

--
-- AUTO_INCREMENT for table `order_or_cart`
--
ALTER TABLE `order_or_cart`
  MODIFY `order_cart_id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=15;

--
-- AUTO_INCREMENT for table `products`
--
ALTER TABLE `products`
  MODIFY `product_id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=44;

--
-- AUTO_INCREMENT for table `product_reviews`
--
ALTER TABLE `product_reviews`
  MODIFY `review_id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=4;

--
-- AUTO_INCREMENT for table `reviews`
--
ALTER TABLE `reviews`
  MODIFY `review_id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=3;

--
-- AUTO_INCREMENT for table `users`
--
ALTER TABLE `users`
  MODIFY `customer_id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=6;

--
-- Constraints for dumped tables
--

--
-- Constraints for table `certificate`
--
ALTER TABLE `certificate`
  ADD CONSTRAINT `fk_certificate_farmer` FOREIGN KEY (`farmer_id`) REFERENCES `farmer` (`farmer_id`) ON DELETE NO ACTION ON UPDATE NO ACTION;

--
-- Constraints for table `order_or_cart`
--
ALTER TABLE `order_or_cart`
  ADD CONSTRAINT `fk_order_customer` FOREIGN KEY (`customer_id`) REFERENCES `users` (`customer_id`) ON DELETE CASCADE,
  ADD CONSTRAINT `fk_order_delivery` FOREIGN KEY (`delivery_id`) REFERENCES `delivery` (`delivery_id`) ON DELETE CASCADE,
  ADD CONSTRAINT `fk_order_product` FOREIGN KEY (`product_id`) REFERENCES `products` (`product_id`);

--
-- Constraints for table `products`
--
ALTER TABLE `products`
  ADD CONSTRAINT `fk_Product_Categories1` FOREIGN KEY (`category_id`) REFERENCES `categories` (`category_id`) ON DELETE NO ACTION ON UPDATE NO ACTION,
  ADD CONSTRAINT `fk_Product_farmer1` FOREIGN KEY (`farmer_id`) REFERENCES `farmer` (`farmer_id`) ON DELETE NO ACTION ON UPDATE NO ACTION;

--
-- Constraints for table `product_reviews`
--
ALTER TABLE `product_reviews`
  ADD CONSTRAINT `fk_review_product` FOREIGN KEY (`product_id`) REFERENCES `products` (`product_id`) ON DELETE CASCADE;
COMMIT;

/*!40101 SET CHARACTER_SET_CLIENT=@OLD_CHARACTER_SET_CLIENT */;
/*!40101 SET CHARACTER_SET_RESULTS=@OLD_CHARACTER_SET_RESULTS */;
/*!40101 SET COLLATION_CONNECTION=@OLD_COLLATION_CONNECTION */;
