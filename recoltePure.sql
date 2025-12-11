-- phpMyAdmin SQL Dump
-- version 5.2.1
-- https://www.phpmyadmin.net/
--
-- Host: 127.0.0.1
-- Generation Time: Dec 11, 2025 at 03:05 PM
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

--
-- Dumping data for table `announcement`
--

INSERT INTO `announcement` (`announce_id`, `product_id`, `farmer_id`, `announcement_date`) VALUES
(1, 1, 1, '2025-11-12'),
(2, 2, 3, '2025-11-15');

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
(4, 'milk', NULL);

-- --------------------------------------------------------

--
-- Table structure for table `certificate`
--

CREATE TABLE `certificate` (
  `certificate_id` int(11) NOT NULL,
  `certificate_name` varchar(100) DEFAULT NULL,
  `farmer_id` int(11) DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

--
-- Dumping data for table `certificate`
--

INSERT INTO `certificate` (`certificate_id`, `certificate_name`, `farmer_id`) VALUES
(1, 'farmer_certificate', 1);

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
(1, 1, '2025-11-21', 'Confirmed', 'xyz', '1234hb');

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
  `password` varchar(255) DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

--
-- Dumping data for table `farmer`
--

INSERT INTO `farmer` (`farmer_id`, `name`, `email`, `phone_number`, `address`, `certificate_number`, `verification_date`, `registration_date`, `password`) VALUES
(1, 'John', 'john@example.com', '7043022473', 'Paris', '1', '2025-11-04', '2025-11-04 00:00:00', 'xyz'),
(2, 'Max', 'max2@gmail.com', '7896541230', 'Paris, France', '2', '2025-11-06', '2025-11-06 00:00:00', 'asd'),
(3, 'John Doe', 'johndoe@gmail.com', '7412589631', '123 Farm Lane, Springfield', '3', '2025-11-04', '2025-11-04 00:00:00', 'hashed_password_123');

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
-- Table structure for table `products`
--

CREATE TABLE `products` (
  `product_id` int(11) NOT NULL,
  `created_on` datetime(6) NOT NULL DEFAULT current_timestamp(6),
  `farmer_id` int(11) DEFAULT NULL,
  `category_id` int(11) DEFAULT NULL,
  `product_name` varchar(100) DEFAULT NULL,
  `price` decimal(10,2) DEFAULT NULL,
  `old_price` int(11) NOT NULL,
  `stock_quantity` int(11) DEFAULT NULL,
  `product_description` varchar(1000) NOT NULL,
  `image` varchar(255) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

--
-- Dumping data for table `products`
--

INSERT INTO `products` (`product_id`, `created_on`, `farmer_id`, `category_id`, `product_name`, `price`, `old_price`, `stock_quantity`, `product_description`, `image`) VALUES
(1, '2025-12-07 11:07:37.359518', 1, 1, 'Apple', 5.00, 3, 10, '', ''),
(2, '2025-12-07 11:07:37.359518', 1, 2, 'Mango', 8.00, 8, 5, '', ''),
(3, '2025-12-07 11:07:37.359518', 1, 2, 'tomatoes', 25.00, 25, 5, 'Red tomatoes', ''),
(4, '2025-12-07 11:07:37.359518', 1, 2, 'cabbage ', 40.00, 35, 10, 'Fresh Cabbage', ''),
(5, '2025-12-10 14:59:21.782920', 2, 3, 'Bay Leaf', 50.00, 45, 40, 'BAy Leaf', '1765375161_bayleaf (2).png'),
(6, '2025-12-10 15:42:05.974859', 2, 3, 'oregano', 100.00, 90, 60, 'Oregano is a species of flowering plant in the mint family, Lamiaceae.', '1765377725_oregano.png');

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
-- Dumping data for table `users`
--

INSERT INTO `users` (`customer_id`, `name`, `email`, `address`, `password`, `registration_date`) VALUES
(1, 'Khushi', 'khushigajjar218@gmail.com', 'qwer', '1234', '2025-11-14 14:07:03');

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
-- Indexes for table `products`
--
ALTER TABLE `products`
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
  MODIFY `announce_id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=3;

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
-- AUTO_INCREMENT for table `delivery`
--
ALTER TABLE `delivery`
  MODIFY `delivery_id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=2;

--
-- AUTO_INCREMENT for table `farmer`
--
ALTER TABLE `farmer`
  MODIFY `farmer_id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=4;

--
-- AUTO_INCREMENT for table `payment`
--
ALTER TABLE `payment`
  MODIFY `payment_id` int(11) NOT NULL AUTO_INCREMENT;

--
-- AUTO_INCREMENT for table `products`
--
ALTER TABLE `products`
  MODIFY `product_id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=7;

--
-- AUTO_INCREMENT for table `reviews`
--
ALTER TABLE `reviews`
  MODIFY `review_id` int(11) NOT NULL AUTO_INCREMENT;

--
-- AUTO_INCREMENT for table `users`
--
ALTER TABLE `users`
  MODIFY `customer_id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=2;

--
-- Constraints for dumped tables
--

--
-- Constraints for table `announcement`
--
ALTER TABLE `announcement`
  ADD CONSTRAINT `fk_Announcement_Product` FOREIGN KEY (`product_id`) REFERENCES `products` (`product_id`) ON DELETE NO ACTION ON UPDATE NO ACTION,
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
  ADD CONSTRAINT `fk_order_delivery1` FOREIGN KEY (`delivery_id`) REFERENCES `delivery` (`delivery_id`) ON DELETE NO ACTION ON UPDATE NO ACTION,
  ADD CONSTRAINT `fk_order_user` FOREIGN KEY (`customer_id`) REFERENCES `users` (`customer_id`) ON DELETE NO ACTION ON UPDATE NO ACTION;

--
-- Constraints for table `payment`
--
ALTER TABLE `payment`
  ADD CONSTRAINT `fk_payment_order1` FOREIGN KEY (`order_customer_id`,`order_delivery_id`) REFERENCES `order_or_cart` (`customer_id`, `delivery_id`) ON DELETE NO ACTION ON UPDATE NO ACTION;

--
-- Constraints for table `products`
--
ALTER TABLE `products`
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
