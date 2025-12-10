-- phpMyAdmin SQL Dump
-- version 5.2.1
-- https://www.phpmyadmin.net/
--
-- Host: 127.0.0.1
-- Generation Time: Dec 10, 2025 at 04:51 PM
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
-- Table structure for table `announcement`
--

CREATE TABLE `announcement` (
  `announce_id` int(11) NOT NULL,
  `product_id` int(11) NOT NULL,
  `farmer_id` int(11) NOT NULL,
  `announcement_date` date DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

-- --------------------------------------------------------

--
-- Table structure for table `categories`
--

CREATE TABLE `categories` (
  `category_id` int(11) NOT NULL,
  `category_name` varchar(100) DEFAULT NULL,
  `category_description` varchar(255) DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

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
(1, 'DUGGEMPUDI RAHUL', 'REDDY', 'duggempudirahul56@gmail.com', '+919550519272', 'products', 'regfdv', '2025-12-10 13:54:07', 'new'),
(2, 'vdfkjvb', 'fiusadjfij', 'duggempudirahul56@gmail.com', '+33758933493', 'feedback', 'nknjskdav blsafdnlv', '2025-12-10 14:27:54', 'new'),
(3, 'efdf', 'asdasda', 'radsf45@gmail.com', '+33758933444', 'general', 'bsdfdfbdgd', '2025-12-10 15:28:27', 'new');

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
  `password_hash` varchar(255) DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

-- --------------------------------------------------------

--
-- Table structure for table `order_items`
--

CREATE TABLE `order_items` (
  `announcement_id` int(11) NOT NULL,
  `order_customer_id` int(11) NOT NULL,
  `order_delivery_id` int(11) NOT NULL,
  `quantity` int(11) DEFAULT 1
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

-- --------------------------------------------------------

--
-- Table structure for table `order_or_cart`
--

CREATE TABLE `order_or_cart` (
  `customer_id` int(11) NOT NULL,
  `delivery_id` int(11) NOT NULL,
  `announce_id` int(11) DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

-- --------------------------------------------------------

--
-- Table structure for table `payment`
--

CREATE TABLE `payment` (
  `payment_id` int(11) NOT NULL,
  `order_id` int(11) DEFAULT NULL,
  `payment_date` date DEFAULT NULL,
  `payment_method` varchar(45) DEFAULT NULL,
  `payment_status` varchar(45) DEFAULT NULL,
  `transaction_reference_id` varchar(45) DEFAULT NULL,
  `order_customer_id` int(11) NOT NULL,
  `order_delivery_id` int(11) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

-- --------------------------------------------------------

--
-- Table structure for table `product`
--

CREATE TABLE `product` (
  `product_id` int(11) NOT NULL,
  `farmer_id` int(11) DEFAULT NULL,
  `category_id` int(11) DEFAULT NULL,
  `product_name` varchar(100) DEFAULT NULL,
  `price` decimal(10,2) DEFAULT NULL,
  `stock_quantity` int(11) DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

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

-- --------------------------------------------------------

--
-- Table structure for table `users`
--

CREATE TABLE `users` (
  `customer_id` int(11) NOT NULL,
  `name` varchar(100) DEFAULT NULL,
  `email` varchar(100) DEFAULT NULL,
  `address` varchar(255) DEFAULT NULL,
  `password` varchar(255) DEFAULT NULL,
  `registration_date` datetime DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

--
-- Indexes for dumped tables
--

--
-- Indexes for table `announcement`
--
ALTER TABLE `announcement`
  ADD PRIMARY KEY (`announce_id`),
  ADD KEY `fk_Announcement_Product_idx` (`product_id`),
  ADD KEY `fk_Announcement_farmer_idx` (`farmer_id`);

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
-- Indexes for table `order_items`
--
ALTER TABLE `order_items`
  ADD PRIMARY KEY (`announcement_id`,`order_customer_id`,`order_delivery_id`),
  ADD KEY `fk_orderitems_order_idx` (`order_customer_id`,`order_delivery_id`);

--
-- Indexes for table `order_or_cart`
--
ALTER TABLE `order_or_cart`
  ADD PRIMARY KEY (`customer_id`,`delivery_id`),
  ADD KEY `fk_order_delivery1_idx` (`delivery_id`);

--
-- Indexes for table `payment`
--
ALTER TABLE `payment`
  ADD PRIMARY KEY (`payment_id`),
  ADD KEY `fk_payment_order1_idx` (`order_customer_id`,`order_delivery_id`);

--
-- Indexes for table `product`
--
ALTER TABLE `product`
  ADD PRIMARY KEY (`product_id`),
  ADD KEY `fk_Product_Categories1_idx` (`category_id`),
  ADD KEY `fk_Product_farmer1` (`farmer_id`);

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
-- AUTO_INCREMENT for table `announcement`
--
ALTER TABLE `announcement`
  MODIFY `announce_id` int(11) NOT NULL AUTO_INCREMENT;

--
-- AUTO_INCREMENT for table `categories`
--
ALTER TABLE `categories`
  MODIFY `category_id` int(11) NOT NULL AUTO_INCREMENT;

--
-- AUTO_INCREMENT for table `certificate`
--
ALTER TABLE `certificate`
  MODIFY `certificate_id` int(11) NOT NULL AUTO_INCREMENT;

--
-- AUTO_INCREMENT for table `contact_messages`
--
ALTER TABLE `contact_messages`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=4;

--
-- AUTO_INCREMENT for table `delivery`
--
ALTER TABLE `delivery`
  MODIFY `delivery_id` int(11) NOT NULL AUTO_INCREMENT;

--
-- AUTO_INCREMENT for table `farmer`
--
ALTER TABLE `farmer`
  MODIFY `farmer_id` int(11) NOT NULL AUTO_INCREMENT;

--
-- AUTO_INCREMENT for table `payment`
--
ALTER TABLE `payment`
  MODIFY `payment_id` int(11) NOT NULL AUTO_INCREMENT;

--
-- AUTO_INCREMENT for table `product`
--
ALTER TABLE `product`
  MODIFY `product_id` int(11) NOT NULL AUTO_INCREMENT;

--
-- AUTO_INCREMENT for table `reviews`
--
ALTER TABLE `reviews`
  MODIFY `review_id` int(11) NOT NULL AUTO_INCREMENT;

--
-- AUTO_INCREMENT for table `users`
--
ALTER TABLE `users`
  MODIFY `customer_id` int(11) NOT NULL AUTO_INCREMENT;

--
-- Constraints for dumped tables
--

--
-- Constraints for table `announcement`
--
ALTER TABLE `announcement`
  ADD CONSTRAINT `fk_Announcement_Product` FOREIGN KEY (`product_id`) REFERENCES `product` (`product_id`) ON DELETE NO ACTION ON UPDATE NO ACTION,
  ADD CONSTRAINT `fk_Announcement_farmer` FOREIGN KEY (`farmer_id`) REFERENCES `farmer` (`farmer_id`) ON DELETE NO ACTION ON UPDATE NO ACTION;

--
-- Constraints for table `certificate`
--
ALTER TABLE `certificate`
  ADD CONSTRAINT `fk_certificate_farmer` FOREIGN KEY (`farmer_id`) REFERENCES `farmer` (`farmer_id`) ON DELETE NO ACTION ON UPDATE NO ACTION;

--
-- Constraints for table `order_items`
--
ALTER TABLE `order_items`
  ADD CONSTRAINT `fk_orderitems_announcement` FOREIGN KEY (`announcement_id`) REFERENCES `announcement` (`announce_id`) ON DELETE NO ACTION ON UPDATE NO ACTION,
  ADD CONSTRAINT `fk_orderitems_order` FOREIGN KEY (`order_customer_id`,`order_delivery_id`) REFERENCES `order_or_cart` (`customer_id`, `delivery_id`) ON DELETE NO ACTION ON UPDATE NO ACTION;

--
-- Constraints for table `order_or_cart`
--
ALTER TABLE `order_or_cart`
  ADD CONSTRAINT `fk_order_delivery1` FOREIGN KEY (`delivery_id`) REFERENCES `delivery` (`delivery_id`) ON DELETE NO ACTION ON UPDATE NO ACTION;

--
-- Constraints for table `payment`
--
ALTER TABLE `payment`
  ADD CONSTRAINT `fk_payment_order1` FOREIGN KEY (`order_customer_id`,`order_delivery_id`) REFERENCES `order_or_cart` (`customer_id`, `delivery_id`) ON DELETE NO ACTION ON UPDATE NO ACTION;

--
-- Constraints for table `product`
--
ALTER TABLE `product`
  ADD CONSTRAINT `fk_Product_Categories1` FOREIGN KEY (`category_id`) REFERENCES `categories` (`category_id`) ON DELETE NO ACTION ON UPDATE NO ACTION,
  ADD CONSTRAINT `fk_Product_farmer1` FOREIGN KEY (`farmer_id`) REFERENCES `farmer` (`farmer_id`) ON DELETE NO ACTION ON UPDATE NO ACTION;

--
-- Constraints for table `reviews`
--
ALTER TABLE `reviews`
  ADD CONSTRAINT `fk_Reviews_order` FOREIGN KEY (`order_customer_id`,`order_delivery_id`) REFERENCES `order_or_cart` (`customer_id`, `delivery_id`) ON DELETE NO ACTION ON UPDATE NO ACTION;
COMMIT;

/*!40101 SET CHARACTER_SET_CLIENT=@OLD_CHARACTER_SET_CLIENT */;
/*!40101 SET CHARACTER_SET_RESULTS=@OLD_CHARACTER_SET_RESULTS */;
/*!40101 SET COLLATION_CONNECTION=@OLD_COLLATION_CONNECTION */;
