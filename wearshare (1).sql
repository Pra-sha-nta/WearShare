-- phpMyAdmin SQL Dump
-- version 5.2.1
-- https://www.phpmyadmin.net/
--
-- Host: 127.0.0.1
-- Generation Time: Mar 18, 2025 at 11:36 AM
-- Server version: 10.4.32-MariaDB
-- PHP Version: 8.0.30

SET SQL_MODE = "NO_AUTO_VALUE_ON_ZERO";
START TRANSACTION;
SET time_zone = "+00:00";


/*!40101 SET @OLD_CHARACTER_SET_CLIENT=@@CHARACTER_SET_CLIENT */;
/*!40101 SET @OLD_CHARACTER_SET_RESULTS=@@CHARACTER_SET_RESULTS */;
/*!40101 SET @OLD_COLLATION_CONNECTION=@@COLLATION_CONNECTION */;
/*!40101 SET NAMES utf8mb4 */;

--
-- Database: `wearshare`
--

-- --------------------------------------------------------

--
-- Table structure for table `admin`
--

CREATE TABLE `admin` (
  `id` int(11) NOT NULL,
  `full_name` varchar(100) NOT NULL,
  `email` varchar(50) NOT NULL,
  `password` varchar(100) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

--
-- Dumping data for table `admin`
--

INSERT INTO `admin` (`id`, `full_name`, `email`, `password`) VALUES
(1, 'Prashanta Parajuli', 'admin12@gmail.com', '$2y$10$H/6y4AAIYbLVluE8cR0AaeAo1QqjObKxrjeOPX44xfJV.aF.14d3m'),
(2, 'Prashant Shrestha', 'admin13@gmail.com', '$2y$10$QzfrHKF0Y65NV.MOk2yJzeUBNqymyOi9RNSaO82Iwwpmcr2AfOGBa');

-- --------------------------------------------------------

--
-- Table structure for table `category`
--

CREATE TABLE `category` (
  `id` int(10) NOT NULL,
  `name` varchar(100) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

--
-- Dumping data for table `category`
--

INSERT INTO `category` (`id`, `name`) VALUES
(1, 'Engagement Wear'),
(2, 'Party  Wear'),
(3, 'Wedding Wear'),
(4, 'Tamang Dress'),
(5, 'Gurung Dress'),
(6, 'Newar Dress');

-- --------------------------------------------------------

--
-- Table structure for table `customer`
--

CREATE TABLE `customer` (
  `id` int(100) NOT NULL,
  `full_name` varchar(100) NOT NULL,
  `email` varchar(50) NOT NULL,
  `contact` varchar(10) NOT NULL,
  `address` varchar(255) NOT NULL,
  `password` varchar(100) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

--
-- Dumping data for table `customer`
--

INSERT INTO `customer` (`id`, `full_name`, `email`, `contact`, `address`, `password`) VALUES
(1, 'Prashanta Parajuli', 'sthaprashant0530@gmail.com', '9813978737', 'Srijananagar', '$2y$10$AXJG1TsACVNgV9Nutk.b1OnOCR4639B4dhR0peZ1CxpRZakqprMQe'),
(2, 'Puskar', 'puskar@gmail.com', '9818814274', 'Gatthaghar', '$2y$10$TeTRlJN5MdK.pOMh/xnmF.5PQH2tRGtX3F3AfqDA3n2fmkt3GXFga'),
(3, 'Prashanta Parajuli', 'prashantaparajuli15@gmail.com', '9848092717', '111', '$2y$10$1E.7d7./wzUtiZozMq23pe93YgaV0iriXpdrZ986jQXjL7lr8/Ko2'),
(4, 'Prashanta Parajuli', 'test@test.com', '9813978737', 'Gatthaghar', '$2y$10$AdXt.87QdNb2BhfQBiqOF.c116EYz/Dne5FvsWomo4OuPph2c/SqG');

-- --------------------------------------------------------

--
-- Table structure for table `orders`
--

CREATE TABLE `orders` (
  `id` int(100) NOT NULL,
  `Full_name` varchar(255) NOT NULL,
  `customer_id` int(100) NOT NULL,
  `Contact` varchar(10) NOT NULL,
  `address` varchar(255) NOT NULL,
  `total` float NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

--
-- Dumping data for table `orders`
--

INSERT INTO `orders` (`id`, `Full_name`, `customer_id`, `Contact`, `address`, `total`) VALUES
(1, 'Prashant', 1, '9813978737', 'Srijananagar', 46800),
(2, 'Prashant', 1, '9813978737', 'Srijananagar', 1300),
(3, 'Puskar Nepal', 2, '9818814274', 'Gatthaghar', 63050),
(4, 'Prashanta', 1, '9813978737', 'Srijananagar', 36800),
(5, 'check', 1, '9848092717', '45', 6000),
(6, 'Prashant', 1, '9813978737', 'Gatthaghar', 45000),
(7, 'Prashant', 1, '9848092717', 'Srijananagar', 1300),
(8, 'divesh', 1, '9818814274', '9856565656', 1300);

-- --------------------------------------------------------

--
-- Table structure for table `order_details`
--

CREATE TABLE `order_details` (
  `id` int(50) NOT NULL,
  `order_id` int(100) NOT NULL,
  `product_id` int(10) NOT NULL,
  `quantity` int(10) NOT NULL,
  `days` int(11) DEFAULT NULL,
  `amount` double NOT NULL,
  `issued_date` date NOT NULL DEFAULT current_timestamp(),
  `return_till` date NOT NULL,
  `returned_date` date DEFAULT NULL,
  `return_status` tinyint(1) NOT NULL DEFAULT 0
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

--
-- Dumping data for table `order_details`
--

INSERT INTO `order_details` (`id`, `order_id`, `product_id`, `quantity`, `days`, `amount`, `issued_date`, `return_till`, `returned_date`, `return_status`) VALUES
(1, 1, 8, 2, 12, 46800, '2025-02-25', '2025-03-09', '2025-02-25', 1),
(2, 2, 2, 1, 1, 1300, '2025-02-25', '2025-02-26', NULL, 0),
(3, 3, 1, 3, 12, 54000, '2025-02-27', '2025-03-11', '2025-02-27', 1),
(4, 3, 8, 1, 3, 5850, '2025-02-27', '2025-03-02', '2025-02-27', 1),
(5, 3, 9, 1, 1, 1800, '2025-02-27', '2025-02-28', '2025-02-27', 1),
(6, 3, 28, 1, 1, 1400, '2025-02-27', '2025-02-28', '2025-02-27', 1),
(7, 4, 4, 1, 23, 36800, '2025-02-28', '2025-03-23', '2025-02-28', 1),
(8, 5, 1, 2, 2, 6000, '2025-02-28', '2025-03-02', '2025-02-28', 1),
(9, 6, 1, 2, 15, 45000, '2025-03-05', '2025-03-20', NULL, 0),
(10, 7, 2, 1, 1, 1300, '2025-03-10', '2025-03-11', NULL, 0),
(11, 8, 2, 1, 1, 1300, '2025-03-10', '2025-03-11', NULL, 0);

-- --------------------------------------------------------

--
-- Table structure for table `product`
--

CREATE TABLE `product` (
  `id` int(10) NOT NULL,
  `name` varchar(100) NOT NULL,
  `cat_id` int(10) NOT NULL,
  `subcategory` varchar(100) NOT NULL,
  `rent_price` float NOT NULL,
  `image` varchar(255) NOT NULL,
  `stock` int(10) NOT NULL,
  `description` varchar(255) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

--
-- Dumping data for table `product`
--

INSERT INTO `product` (`id`, `name`, `cat_id`, `subcategory`, `rent_price`, `image`, `stock`, `description`) VALUES
(1, 'Bandi Set', 1, 'gents', 1500, 'Bandi Set.jpg', 0, 'Elegant traditional bandi set for a stylish ethnic look.'),
(2, 'Kurta Paijama Sert', 1, 'gents', 1300, 'Kurta Paijama set.jpg', 2, 'Classic kurta pajama for formal and festive occasions.'),
(3, 'Sherwani Art Silk Purple', 1, 'gents', 1800, 'Sherwani art silk purple.jpg', 7, 'Royal purple sherwani in silk for weddings and grand events.'),
(4, 'Sherwani Art Silk Sky Blue', 1, 'gents', 1600, 'Sherwanui Art Silk.jpg', 9, 'Elegant sherwani with fine art silk fabric.'),
(5, 'White Sherwani', 1, 'gents', 1500, 'white Sherwani.jpg', 11, 'Sophisticated white sherwani for grooms and formal occasions.'),
(6, 'Simple White Lehenga Choli', 1, 'ladies', 1900, 'Simple White Lehenga Choli.jpg', 13, 'Elegant and simple white lehenga choli for a classy look.'),
(7, 'Navaratri ChhaniyaCholi', 1, 'ladies', 1400, 'Navaratri Chhaniya Choli.jpg', 9, 'Festive chaniya choli, perfect for Navaratri celebrations.'),
(8, 'Lehenga Choli', 1, 'ladies', 1950, 'Lehengaa Choli.jpg', 10, 'Beautiful red lehenga choli for weddings and parties.'),
(9, 'Golden Border Saree Type Lehenga', 1, 'ladies', 1800, 'Golden Border Saree Type lehenga.jpg', 10, 'A fusion of saree and lehenga for a graceful appeal.'),
(10, 'Cotton Golden Daura Suruwal', 3, 'gents', 2100, 'Cotton Shining golden daura suruwal with velvet Shawl.jpg', 16, 'Traditional golden daura suruwal with a velvet shawl.'),
(11, 'Designer Saree', 3, 'ladies', 2800, 'Designer Saree.jpg', 15, 'Gorgeous red designer saree for bridal and festive wear.'),
(12, 'Dhaka Daura Suruwal Set', 3, 'gents', 1900, 'Dhaka Daura Suruwal topi Set.jpg', 12, 'Authentic Dhaka fabric daura suruwal for a cultural touch.'),
(13, 'Dupatta Saree', 3, 'ladies', 2900, 'Dupatta Saree.jpg', 18, 'Stunning saree paired with a beautifully embroidered dupatta.'),
(14, 'Golden Sherwani Suruwal', 3, 'gents', 2300, 'goldel sherwani suruwal with velvet coat.jpg', 15, 'Rich golden sherwani with a velvet coat for a royal look.'),
(15, 'Makhamal(velvet)  Saree', 3, 'ladies', 2900, 'Velvet Saree.jpg', 16, 'Luxurious velvet saree with intricate embroidery.'),
(16, 'Bhoto Kachhad Set', 5, 'gents', 1200, 'Bhoto KAcchad set.jpg', 9, 'Traditional grunug bhoto kachhad set for cultural events.'),
(17, 'Bhoto Kachhad Plain', 5, 'gents', 900, 'Bhoto Kacchad Plain.jpg', 8, 'Simple Gurung-style bhoto and kachhad for men.'),
(18, 'Chaubandi Lungi Shawl Set', 5, 'ladies', 1300, 'Chaubandi lungi shawl set.jpg', 9, 'Classic chaubandi cholo with lungi and shawl.'),
(19, 'Chaubandi Cholo', 5, 'ladies', 700, 'Chaubandhi Cholo.jpg', 8, 'Traditional chaubandi cholo for a graceful ethnic look.'),
(20, 'Gurung Saree', 5, 'ladies', 500, 'Gurung Saree.jpg', 4, 'Cultural Gurung saree for traditional ceremonies.'),
(21, 'Daura Suruwal 1', 6, 'gents', 1300, 'Newari Daura Suruwal 1.jpg', 14, 'Traditional black Daura Suruwal, perfect for cultural and festive events.'),
(23, 'Haku Patasi 1', 5, 'ladies', 1200, 'Haku Patasi 1.jpg', 14, 'Elegant black and red Haku Patasi saree, a signature attire of Newar women.'),
(24, 'Haku Patasi 2', 6, 'ladies', 1450, 'Newari Haku Patasi 2.jpg', 11, 'Traditional Haku Patasi set with detailed accessories, ideal for cultural events.'),
(25, 'Khenja Shirt Topi', 4, 'gents', 1400, 'Khenja Shrit With Topi.jpg', 13, 'Stylish blue Khenja shirt with a matching topi, a unique ethnic wear.'),
(26, 'Stoned Ghalek', 4, 'ladies', 2300, 'Stoned Ghalek.jpeg', 8, 'Heavily embroidered Tamang dress with vibrant colors, perfect for weddings.'),
(27, 'Tass Behuli Set', 4, 'ladies', 2200, 'Tass Behuli Set.jpeg', 9, 'Traditional Newari bridal attire with rich details and accessories.'),
(28, 'White Khenja Sleeveless Coat', 4, 'gents', 1400, 'white khenja sleeveless coat.png', 6, 'White Khenja coat with embroidery, a classic statement piece.'),
(29, 'Golden Border Simple Bridal Lehenga', 2, 'ladies', 2900, 'Golden Border simple bridal lehenga.jpg', 12, 'Red bridal lehenga with intricate golden border embroidery.'),
(30, 'Light Lavender Lehenga', 2, 'ladies', 2200, 'Light Lavender Lehenga.jpg', 13, 'Soft lavender lehenga with delicate embellishments, perfect for receptions.'),
(31, 'Light Pink Handmade Lehenga', 2, 'ladies', 2500, 'Light Pink Handmade Lehenga.jpg', 11, 'Gorgeous hand-crafted pink lehenga, ideal for bridal events.'),
(32, 'Maroon Velvet Lehenga', 2, 'ladies', 3000, 'Maroon Velvet Lehenga.jpg', 13, 'Rich velvet maroon lehenga with detailed embroidery for grand occasions.'),
(33, 'Blue 3 Pcs Suit', 2, 'gents', 2800, 'Blue 3 pcs.jpg', 12, 'Elegant three-piece blue suit, perfect for grooms and formal events.'),
(34, 'Maroon Suit 3 PCS', 2, 'gents', 2950, 'Maroon Suit 3pcs.jpg', 11, 'Stylish maroon tuxedo set for weddings and celebrations.'),
(35, 'Purple 3 pcs Suit Set', 2, 'gents', 2900, 'purple 3 pcs suit set.jpg', 10, 'Classic deep purple three-piece suit for a dashing groomâ€™s look.'),
(36, 'Double-Breasted Suit', 2, 'gents', 2450, 'Double Breasted Suit Set.jpg', 12, 'A sophisticated double-breasted suit featuring a sleek black design, gold-tone buttons, and a sharp lapel.'),
(38, 'Purple Shining Lehenga', 2, 'ladies', 1200, 'Purple Shining Lehenga.jpg', 13, 'A stunning traditional outfit featuring a rich purple hue with shimmering embellishments. Designed with intricate embroidery, sequins, or metallic accents, it exudes elegance and luxury.'),
(39, 'Daura Suruwal 2', 6, 'gents', 1200, 'Newari Daura Suruwal 2.jpg', 15, 'Traditional black striped Daura Suruwal, perfect for cultural and festive events for newars.'),
(40, 'Daura Suruwal 3', 6, 'gents', 1200, 'Newari Daura Suruwal 3.jpeg', 12, 'Traditional full black spotted Daura Suruwal, perfect for cultural and festive events.');

-- --------------------------------------------------------

--
-- Table structure for table `purchase`
--

CREATE TABLE `purchase` (
  `purchase_id` int(11) NOT NULL,
  `customer_id` int(11) NOT NULL,
  `req_price` int(11) NOT NULL,
  `description` varchar(100) NOT NULL,
  `image` varchar(100) NOT NULL,
  `product_name` varchar(30) NOT NULL,
  `status` varchar(20) DEFAULT 'Hold'
) ENGINE=InnoDB DEFAULT CHARSET=utf8 COLLATE=utf8_general_ci;

--
-- Dumping data for table `purchase`
--

INSERT INTO `purchase` (`purchase_id`, `customer_id`, `req_price`, `description`, `image`, `product_name`, `status`) VALUES
(3, 1, 1200, 'JACKET', 'admin/images/Screenshot (5).png', 'jacket', 'Hold'),
(4, 1, 1233, 'HELLO SHIRT ', 'admin/images/Character_Map_of_Preeti_Font.jpg', 'SHIRT', 'Hold'),
(5, 4, -500, 'MXNCA', 'admin/images/Light Pink Handmade Lehenga.jpg', 'Test', 'Hold'),
(6, 1, -122, 'efs', 'admin/images/contextdiagram.png', 'dasd', 'Hold'),
(7, 1, -129, 'sad', 'admin/images/Entities and Attributes.png', 'jacket', 'Hold');

--
-- Indexes for dumped tables
--

--
-- Indexes for table `admin`
--
ALTER TABLE `admin`
  ADD PRIMARY KEY (`id`);

--
-- Indexes for table `category`
--
ALTER TABLE `category`
  ADD PRIMARY KEY (`id`);

--
-- Indexes for table `customer`
--
ALTER TABLE `customer`
  ADD PRIMARY KEY (`id`),
  ADD UNIQUE KEY `email` (`email`);

--
-- Indexes for table `orders`
--
ALTER TABLE `orders`
  ADD PRIMARY KEY (`id`),
  ADD KEY `customer_id` (`customer_id`);

--
-- Indexes for table `order_details`
--
ALTER TABLE `order_details`
  ADD PRIMARY KEY (`id`),
  ADD KEY `order_id` (`order_id`),
  ADD KEY `product_id` (`product_id`);

--
-- Indexes for table `product`
--
ALTER TABLE `product`
  ADD PRIMARY KEY (`id`),
  ADD KEY `cat_id` (`cat_id`);

--
-- Indexes for table `purchase`
--
ALTER TABLE `purchase`
  ADD PRIMARY KEY (`purchase_id`),
  ADD KEY `customer_id` (`customer_id`);

--
-- AUTO_INCREMENT for dumped tables
--

--
-- AUTO_INCREMENT for table `admin`
--
ALTER TABLE `admin`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=4;

--
-- AUTO_INCREMENT for table `category`
--
ALTER TABLE `category`
  MODIFY `id` int(10) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=7;

--
-- AUTO_INCREMENT for table `customer`
--
ALTER TABLE `customer`
  MODIFY `id` int(100) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=5;

--
-- AUTO_INCREMENT for table `orders`
--
ALTER TABLE `orders`
  MODIFY `id` int(100) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=9;

--
-- AUTO_INCREMENT for table `order_details`
--
ALTER TABLE `order_details`
  MODIFY `id` int(50) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=12;

--
-- AUTO_INCREMENT for table `product`
--
ALTER TABLE `product`
  MODIFY `id` int(10) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=41;

--
-- AUTO_INCREMENT for table `purchase`
--
ALTER TABLE `purchase`
  MODIFY `purchase_id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=8;

--
-- Constraints for dumped tables
--

--
-- Constraints for table `orders`
--
ALTER TABLE `orders`
  ADD CONSTRAINT `orders_ibfk_1` FOREIGN KEY (`customer_id`) REFERENCES `customer` (`id`);

--
-- Constraints for table `order_details`
--
ALTER TABLE `order_details`
  ADD CONSTRAINT `order_details_ibfk_1` FOREIGN KEY (`order_id`) REFERENCES `orders` (`id`),
  ADD CONSTRAINT `order_details_ibfk_2` FOREIGN KEY (`product_id`) REFERENCES `product` (`id`);

--
-- Constraints for table `product`
--
ALTER TABLE `product`
  ADD CONSTRAINT `product_ibfk_1` FOREIGN KEY (`cat_id`) REFERENCES `category` (`id`);

--
-- Constraints for table `purchase`
--
ALTER TABLE `purchase`
  ADD CONSTRAINT `purchase_ibfk_1` FOREIGN KEY (`customer_id`) REFERENCES `customer` (`id`);
COMMIT;

/*!40101 SET CHARACTER_SET_CLIENT=@OLD_CHARACTER_SET_CLIENT */;
/*!40101 SET CHARACTER_SET_RESULTS=@OLD_CHARACTER_SET_RESULTS */;
/*!40101 SET COLLATION_CONNECTION=@OLD_COLLATION_CONNECTION */;
