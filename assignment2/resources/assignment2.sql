-- phpMyAdmin SQL Dump
-- version 5.2.1deb1
-- https://www.phpmyadmin.net/
--
-- Host: localhost:3306
-- Generation Time: Jan 30, 2025 at 04:47 PM
-- Server version: 10.11.6-MariaDB-0+deb12u1
-- PHP Version: 8.2.26

SET SQL_MODE = "NO_AUTO_VALUE_ON_ZERO";
START TRANSACTION;
SET time_zone = "+00:00";


/*!40101 SET @OLD_CHARACTER_SET_CLIENT=@@CHARACTER_SET_CLIENT */;
/*!40101 SET @OLD_CHARACTER_SET_RESULTS=@@CHARACTER_SET_RESULTS */;
/*!40101 SET @OLD_COLLATION_CONNECTION=@@COLLATION_CONNECTION */;
/*!40101 SET NAMES utf8mb4 */;

--
-- Database: `mbates5`
--

-- --------------------------------------------------------

--
-- Table structure for table `tbl_offers`
--

CREATE TABLE `tbl_offers` (
  `offer_id` int(11) NOT NULL,
  `offer_title` varchar(255) NOT NULL,
  `offer_dec` varchar(255) NOT NULL
) ENGINE=MyISAM DEFAULT CHARSET=latin1 COLLATE=latin1_swedish_ci;

--
-- Dumping data for table `tbl_offers`
--

INSERT INTO `tbl_offers` (`offer_id`, `offer_title`, `offer_dec`) VALUES
(1, 'Jumpers Clearance', 'All jumpers are 25% off. Discount will be applied at checkout (hopefully).'),
(2, 'T-shirts: Buy 1 get 1 half-price.', 'Ready for summer? All T-shirts are buy 1 get 1 half-price. Promotion will be applied during checkout (hopefully).'),
(3, 'Graduation Promo-Code.', 'Graduating this year? Then you are entitled to 25% your total shop. Just add items to your cart and use discount code \'GRAD25\' to apply the discount (hopefully).');

-- --------------------------------------------------------

--
-- Table structure for table `tbl_orders`
--

CREATE TABLE `tbl_orders` (
  `order_id` int(11) NOT NULL,
  `order_date` datetime NOT NULL DEFAULT current_timestamp(),
  `user_id` int(11) NOT NULL,
  `product_ids` text NOT NULL
) ENGINE=MyISAM DEFAULT CHARSET=latin1 COLLATE=latin1_swedish_ci;

-- --------------------------------------------------------

--
-- Table structure for table `tbl_products`
--

CREATE TABLE `tbl_products` (
  `product_id` int(11) NOT NULL,
  `product_title` varchar(255) NOT NULL,
  `product_desc` varchar(255) NOT NULL,
  `product_image` varchar(255) CHARACTER SET latin1 COLLATE latin1_general_ci NOT NULL,
  `product_price` decimal(6,2) NOT NULL,
  `product_type` enum('UCLan Hoodie','UCLan Logo Tshirt','UCLan Logo Jumper') NOT NULL
) ENGINE=MyISAM DEFAULT CHARSET=latin1 COLLATE=latin1_swedish_ci;

--
-- Dumping data for table `tbl_products`
--

INSERT INTO `tbl_products` (`product_id`, `product_title`, `product_desc`, `product_image`, `product_price`, `product_type`) VALUES
(21, 'Red UCLan Hoodie', 'Cotton authentic character and practicality are duly combined in this comfortable attire. Perfect for when the weather just cant decide.', 'images/hoodies/hoodie1.jpg', 39.99, 'UCLan Hoodie'),
(22, 'Blue UCLan Hoodie', 'Cotton authentic character and practicality are duly combined in this comfortable attire. Perfect for when the weather just cant decide.', 'images/hoodies/hoodie2.jpg', 39.99, 'UCLan Hoodie'),
(23, 'Green UCLan Hoodie', 'Cotton authentic character and practicality are duly combined in this comfortable attire. Perfect for when the weather just cant decide.', 'images/hoodies/hoodie3.jpg', 39.99, 'UCLan Hoodie'),
(24, 'Cyan UCLan Hoodie', 'Cotton authentic character and practicality are duly combined in this comfortable attire. Perfect for when the weather just cant decide.', 'images/hoodies/hoodie4.jpg', 39.99, 'UCLan Hoodie'),
(25, 'Salmon UCLan Hoodie', 'Cotton authentic character and practicality are duly combined in this comfortable attire. Perfect for when the weather just cant decide.', 'images/hoodies/hoodie5.jpg', 39.99, 'UCLan Hoodie'),
(26, 'Orange UCLan Hoodie', 'Cotton authentic character and practicality are duly combined in this comfortable attire. Perfect for when the weather just cant decide.', 'images/hoodies/hoodie6.jpg', 39.99, 'UCLan Hoodie'),
(27, 'Black UCLan Hoodie', 'Cotton authentic character and practicality are duly combined in this comfortable attire. Perfect for when the weather just cant decide.', 'images/hoodies/hoodie7.jpg', 39.99, 'UCLan Hoodie'),
(28, 'Light-grey UCLan Hoodie', 'Cotton authentic character and practicality are duly combined in this comfortable attire. Perfect for when the weather just cant decide.', 'images/hoodies/hoodie8.jpg', 39.99, 'UCLan Hoodie'),
(29, 'Dark-grey UCLan Hoodie', 'Cotton authentic character and practicality are duly combined in this comfortable attire. Perfect for when the weather just cant decide.', 'images/hoodies/hoodie9.jpg', 39.99, 'UCLan Hoodie'),
(11, 'Red UCLan Jumper', 'Cotton authentic character and practicality are duly combined in this comfortable attire. Challenge winter weather in \'style\' this year.', 'images/jumpers/jumper1.jpg', 29.99, 'UCLan Logo Jumper'),
(12, 'Green UCLan Jumper', 'Cotton authentic character and practicality are duly combined in this comfortable attire. Challenge winter weather in \'style\' this year.', 'images/jumpers/jumper2.jpg', 29.99, 'UCLan Logo Jumper'),
(13, 'Blue UCLan Jumper', 'Cotton authentic character and practicality are duly combined in this comfortable attire. Challenge winter weather in \'style\' this year.', 'images/jumpers/jumper3.jpg', 29.99, 'UCLan Logo Jumper'),
(30, 'Burgundy UCLan Hoodie', 'Cotton authentic character and practicality are duly combined in this comfortable attire. Perfect for when the weather just cant decide.', 'images/hoodies/hoodie10.jpg', 29.99, 'UCLan Hoodie'),
(14, 'Cyan UCLan Jumper', 'Cotton authentic character and practicality are duly combined in this comfortable attire. Challenge winter weather in \'style\' this year.', 'images/jumpers/jumper4.jpg', 29.99, 'UCLan Logo Jumper'),
(15, 'Magenta UCLan Jumper', 'Cotton authentic character and practicality are duly combined in this comfortable attire. Challenge winter weather in \'style\' this year.', 'images/jumpers/jumper5.jpg', 29.99, 'UCLan Logo Jumper'),
(16, 'Yellow UCLan Jumper', 'Cotton authentic character and practicality are duly combined in this comfortable attire. Challenge winter weather in \'style\' this year.', 'images/jumpers/jumper6.jpg', 29.99, 'UCLan Logo Jumper'),
(17, 'Black UCLan Jumper', 'Cotton authentic character and practicality are duly combined in this comfortable attire. Challenge winter weather in \'style\' this year.', 'images/jumpers/jumper7.jpg', 29.99, 'UCLan Logo Jumper'),
(20, 'Burgundy UCLan Jumper', 'Cotton authentic character and practicality are duly combined in this comfortable attire. Challenge winter weather in \'style\' this year.', 'images/jumpers/jumper10.jpg', 29.99, 'UCLan Logo Jumper'),
(19, 'Dark-grey UCLan Jumper', 'Cotton authentic character and practicality are duly combined in this comfortable attire. Challenge winter weather in \'style\' this year.', 'images/jumpers/jumper9.jpg', 29.99, 'UCLan Logo Jumper'),
(1, 'Red UCLan T-Shirt', 'Cotton authentic character and practicality are duly combined in this comfortable attire. Perfect for when venturing outdoors in summer.', 'images/tshirts/tshirt1.jpg', 19.99, 'UCLan Logo Tshirt'),
(2, 'Green UCLan TShirt', 'Cotton authentic character and practicality are duly combined in this comfortable attire. Perfect for when venturing outdoors in summer.', 'images/tshirts/tshirt2.jpg', 19.99, 'UCLan Logo Tshirt'),
(3, 'Blue UCLan T-Shirt', 'Cotton authentic character and practicality are duly combined in this comfortable attire. Perfect for when venturing outdoors in summer.', 'images/tshirts/tshirt3.jpg', 19.99, 'UCLan Logo Tshirt'),
(4, 'Cyan UCLan T-Shirt', 'Cotton authentic character and practicality are duly combined in this comfortable attire. Perfect for when venturing outdoors in summer.', 'images/tshirts/tshirt4.jpg', 19.99, 'UCLan Logo Tshirt'),
(5, 'Magenta UCLan T-Shirt', 'Cotton authentic character and practicality are duly combined in this comfortable attire. Perfect for when venturing outdoors in summer.', 'images/tshirts/tshirt5.jpg', 19.99, 'UCLan Logo Tshirt'),
(18, 'Light-grey UCLan Jumper', 'Cotton authentic character and practicality are duly combined in this comfortable attire. Challenge winter weather in \'style\' this year.', 'images/jumpers/jumper8.jpg', 29.99, 'UCLan Logo Jumper'),
(6, 'Yellow UCLan T-Shirt', 'Cotton authentic character and practicality are duly combined in this comfortable attire. Perfect for when venturing outdoors in summer.', 'images/tshirts/tshirt6.jpg', 19.99, 'UCLan Logo Tshirt'),
(7, 'Black UCLan T-Shirt', 'Cotton authentic character and practicality are duly combined in this comfortable attire. Perfect for when venturing outdoors in summer.', 'images/tshirts/tshirt7.jpg', 19.99, 'UCLan Logo Tshirt'),
(8, 'Light-grey UCLan T-Shirt', 'Cotton authentic character and practicality are duly combined in this comfortable attire. Perfect for when venturing outdoors in summer.', 'images/tshirts/tshirt8.jpg', 19.99, 'UCLan Logo Tshirt'),
(9, 'Dark-grey UCLan T-Shirt', 'Cotton authentic character and practicality are duly combined in this comfortable attire. Perfect for when venturing outdoors in summer.', 'images/tshirts/tshirt9.jpg', 19.99, 'UCLan Logo Tshirt'),
(10, 'Burgundy UCLan T-Shirt', 'Cotton authentic character and practicality are duly combined in this comfortable attire. Perfect for when venturing outdoors in summer.', 'images/tshirts/tshirt10.jpg', 19.99, 'UCLan Logo Tshirt');

-- --------------------------------------------------------

--
-- Table structure for table `tbl_reviews`
--

CREATE TABLE `tbl_reviews` (
  `review_id` int(11) NOT NULL,
  `user_id` int(11) NOT NULL,
  `product_id` int(11) NOT NULL,
  `review_title` varchar(255) NOT NULL,
  `review_desc` text NOT NULL,
  `review_rating` enum('1','2','3','4','5') NOT NULL,
  `review_timestamp` timestamp NOT NULL DEFAULT current_timestamp()
) ENGINE=MyISAM DEFAULT CHARSET=latin1 COLLATE=latin1_swedish_ci;

-- --------------------------------------------------------

--
-- Table structure for table `tbl_users`
--

CREATE TABLE `tbl_users` (
  `user_id` int(11) NOT NULL,
  `user_full_name` varchar(255) NOT NULL,
  `user_address` varchar(255) NOT NULL,
  `user_email` varchar(255) NOT NULL,
  `user_pass` varchar(255) NOT NULL,
  `user_timestamp` timestamp NOT NULL DEFAULT current_timestamp()
) ENGINE=MyISAM DEFAULT CHARSET=latin1 COLLATE=latin1_swedish_ci;

--
-- Dumping data for table `tbl_users`
--

INSERT INTO `tbl_users` (`user_id`, `user_full_name`, `user_address`, `user_email`, `user_pass`, `user_timestamp`) VALUES
(1, 'Matthew Bates', 'University of Central Lancashire, Preston.', 'mbates5@uclan.ac.uk', '$2y$10$2Ww0EECu2EbCNAJPxeIycO2nEzZANDI3RdhA6Tb8NZHdfQpgNZCnW', '2024-01-01 00:01:00');

--
-- Indexes for dumped tables
--

--
-- Indexes for table `tbl_offers`
--
ALTER TABLE `tbl_offers`
  ADD PRIMARY KEY (`offer_id`);

--
-- Indexes for table `tbl_orders`
--
ALTER TABLE `tbl_orders`
  ADD PRIMARY KEY (`order_id`);

--
-- Indexes for table `tbl_products`
--
ALTER TABLE `tbl_products`
  ADD PRIMARY KEY (`product_id`);

--
-- Indexes for table `tbl_reviews`
--
ALTER TABLE `tbl_reviews`
  ADD PRIMARY KEY (`review_id`);

--
-- Indexes for table `tbl_users`
--
ALTER TABLE `tbl_users`
  ADD PRIMARY KEY (`user_id`);

--
-- AUTO_INCREMENT for dumped tables
--

--
-- AUTO_INCREMENT for table `tbl_offers`
--
ALTER TABLE `tbl_offers`
  MODIFY `offer_id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=4;

--
-- AUTO_INCREMENT for table `tbl_orders`
--
ALTER TABLE `tbl_orders`
  MODIFY `order_id` int(11) NOT NULL AUTO_INCREMENT;

--
-- AUTO_INCREMENT for table `tbl_products`
--
ALTER TABLE `tbl_products`
  MODIFY `product_id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=110;

--
-- AUTO_INCREMENT for table `tbl_reviews`
--
ALTER TABLE `tbl_reviews`
  MODIFY `review_id` int(11) NOT NULL AUTO_INCREMENT;

--
-- AUTO_INCREMENT for table `tbl_users`
--
ALTER TABLE `tbl_users`
  MODIFY `user_id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=2;
COMMIT;

/*!40101 SET CHARACTER_SET_CLIENT=@OLD_CHARACTER_SET_CLIENT */;
/*!40101 SET CHARACTER_SET_RESULTS=@OLD_CHARACTER_SET_RESULTS */;
/*!40101 SET COLLATION_CONNECTION=@OLD_COLLATION_CONNECTION */;
