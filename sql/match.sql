-- phpMyAdmin SQL Dump
-- version 4.9.2
-- https://www.phpmyadmin.net/
--
-- Host: 127.0.0.1:3308
-- Generation Time: May 18, 2021 at 02:48 AM
-- Server version: 8.0.18
-- PHP Version: 7.4.0

SET FOREIGN_KEY_CHECKS = 0;
SET SQL_MODE = "NO_AUTO_VALUE_ON_ZERO";
SET AUTOCOMMIT = 0;
START TRANSACTION;
SET time_zone = "+00:00";



/*!40101 SET @OLD_CHARACTER_SET_CLIENT=@@CHARACTER_SET_CLIENT */;
/*!40101 SET @OLD_CHARACTER_SET_RESULTS=@@CHARACTER_SET_RESULTS */;
/*!40101 SET @OLD_COLLATION_CONNECTION=@@COLLATION_CONNECTION */;
/*!40101 SET NAMES utf8mb4 */;

--
-- Database: `match`
--

-- --------------------------------------------------------

--
-- Table structure for table `cart`
--

DROP TABLE IF EXISTS `cart`;
CREATE TABLE `cart` (
  `cartID` int(10) NOT NULL AUTO_INCREMENT,
  `userID` int(10) UNSIGNED NOT NULL,
   PRIMARY KEY (`cartID`),
  KEY `userID`(`userID`)
);

-- --------------------------------------------------------

--
-- Table structure for table `cartproduct`
--

DROP TABLE IF EXISTS `cartproduct`;
CREATE TABLE `cartproduct` (
  `cartproductID` int(10) NOT NULL AUTO_INCREMENT,
  `cartID` int(10) NOT NULL,
  `productID` int(10) NOT NULL,
  `quantity` smallint(6) NOT NULL,
  PRIMARY KEY (`cartproductID`),
  KEY  `cartID` ( `cartID`)
);

-- --------------------------------------------------------

--
-- Table structure for table `category`
--

DROP TABLE IF EXISTS `category`;
CREATE TABLE `category` (
  `categoryID` int(10) NOT NULL AUTO_INCREMENT,
  `categoryName` varchar(50) NOT NULL,
   PRIMARY KEY (`categoryID`)
);

--
-- Dumping data for table `category`
--

INSERT INTO `category` (`categoryID`, `categoryName`) VALUES
(1, 'Cheerful'),
(2, 'Calm'),
(3, 'Mysterious'),
(4, 'Energestic'),
(5, 'Peaceful'),
(6, 'Aggressive'),
(7, 'Confident'),
(8, 'Thankful');

-- --------------------------------------------------------

--
-- Table structure for table `orderdata`
--

DROP TABLE IF EXISTS `orderdata`;
CREATE TABLE `orderdata` (
  `OrderNumber` int(10) NOT NULL AUTO_INCREMENT,
  `orderDate` datetime DEFAULT CURRENT_TIMESTAMP,
  `deliverDate` varchar(10) NOT NULL,
  `userID` int(10) UNSIGNED NOT NULL,
   PRIMARY KEY (`OrderNumber`),
   KEY `userID` (`userID`)
);

-- --------------------------------------------------------

--
-- Table structure for table `order_product`
--

DROP TABLE IF EXISTS `order_product`;
CREATE TABLE `order_product` (
  `order_productID` int(10) NOT NULL AUTO_INCREMENT,
  `OrderNumber` int(10) NOT NULL,
  `productID` int(10) NOT NULL,
  `quantity` smallint(6) NOT NULL,
   PRIMARY KEY (`order_productID`),
   KEY `productID` (`productID`)
);

-- --------------------------------------------------------

--
-- Table structure for table `product`
--

DROP TABLE IF EXISTS `product`;
CREATE TABLE `product` (
  `productID` int(10) NOT NULL AUTO_INCREMENT,
  `productName` varchar(50) NOT NULL,
  `productPrice` decimal(10,2) NOT NULL,
  `categoryID` int(10) NOT NULL,
  `productImg` varchar(30) DEFAULT NULL,
  PRIMARY KEY (`productID`),
   KEY `categoryID` (`categoryID`)
);

--
-- Dumping data for table `product`
--

INSERT INTO `product` (`productID`, `productName`, `productPrice`, `categoryID`, `productImg`) VALUES
(1, 'dress', '130.00', 1, 'image/dress.jpg'),
(2, 'tablelight', '25.00', 2, 'image/tablelight.jpg'),
(3, 'shirt', '18.00', 3, 'image/shirt.jpg'),
(4, 'hat', '36.00', 4, 'image/hat.jpg'),
(5, 'phonecase', '20.00', 5, 'image/phonecase.jpg'),
(6, 'bag', '58.00', 6, 'image/bag.jpg'),
(7, 'watch', '120.00', 7, 'image/watch.jpg'),
(8, 'mirror', '10.00', 8, 'image/mirror.jpg');

-- --------------------------------------------------------

--
-- Table structure for table `user`
--

DROP TABLE IF EXISTS `user`;
CREATE TABLE `user` (
  `userID` int(10) UNSIGNED NOT NULL AUTO_INCREMENT,
  `username` varchar(20) NOT NULL,
  `password` varchar(255) NOT NULL,
  `role` varchar(10) DEFAULT NULL,
   PRIMARY KEY (`userID`)
);

--
-- Dumping data for table `user`
--

INSERT INTO `user` (`userID`, `username`, `password`, `role`) VALUES
(1, 'user1', '123123', 'admin'),
(2, 'user2', '123123', NULL),
(3, 'user3', '123123', NULL),
(7, 'user4', '123123', NULL),
(8, 'user55', '123123', NULL),
(9, 'user6', '123123', NULL);

-- --------------------------------------------------------

--
-- Table structure for table `usercategory`
--

DROP TABLE IF EXISTS `usercategory`;
CREATE TABLE `usercategory` (
  `usercatgoryID` int(10) NOT NULL AUTO_INCREMENT,
  `categoryID` int(10) DEFAULT NULL,
  `userID` int(10) UNSIGNED DEFAULT NULL,
  PRIMARY KEY (`usercatgoryID`),
  KEY `categoryID` (`categoryID`),
  KEY `userID` (`userID`)
);

--
-- Dumping data for table `usercategory`
--

INSERT INTO `usercategory` (`usercatgoryID`, `categoryID`, `userID`) VALUES
(24, 5, 2),
(25, 6, 2),
(26, 7, 2),
(27, 8, 2),
(28, 1, 3),
(29, 7, 3),
(30, 8, 3),
(43, 1, 7),
(44, 2, 7),
(45, 3, 7),
(46, 1, 1),
(47, 2, 1),
(48, 1, 9),
(49, 2, 9);

--
-- Indexes for dumped tables
--

--
-- Indexes for table `cart`
--
ALTER TABLE `cart`
 ADD CONSTRAINT `cart_ibfk_1` FOREIGN KEY (`userID`) REFERENCES `user` (`userID`) ON DELETE CASCADE ON UPDATE CASCADE;

--
-- Indexes for table `cartproduct`
--
ALTER TABLE `cartproduct`
 ADD CONSTRAINT `cartproduct_ibfk_1` FOREIGN KEY (`cartID`) REFERENCES `cart` (`cartID`) ON DELETE CASCADE ON UPDATE CASCADE,
 ADD CONSTRAINT `cartproduct_ibfk_2` FOREIGN KEY (`productID`) REFERENCES `product` (`productID`) ON DELETE CASCADE ON UPDATE CASCADE;


--
-- Indexes for table `orderdata`
--
ALTER TABLE `orderdata`
ADD CONSTRAINT `orderdata_ibfk_1` FOREIGN KEY (`userID`) REFERENCES `user` (`userID`) ON DELETE CASCADE ON UPDATE CASCADE;

--
-- Indexes for table `order_product`
--
ALTER TABLE `order_product`
 ADD CONSTRAINT `order_product_ibfk_1` FOREIGN KEY (`OrderNumber`) REFERENCES `orderdata` (`OrderNumber`) ON DELETE CASCADE ON UPDATE CASCADE,
 ADD CONSTRAINT `order_product_ibfk_2` FOREIGN KEY (`productID`) REFERENCES `product` (`productID`) ON DELETE CASCADE ON UPDATE CASCADE;

--
-- Indexes for table `product`
--
ALTER TABLE `product`
ADD CONSTRAINT `product_ibfk_1` FOREIGN KEY (`categoryID`) REFERENCES `category` (`categoryID`) ON DELETE CASCADE ON UPDATE CASCADE;


--
-- Indexes for table `usercategory`
--
ALTER TABLE `usercategory`
 ADD CONSTRAINT `usercategory_ibfk_1` FOREIGN KEY (`categoryID`) REFERENCES `category` (`categoryID`) ON DELETE CASCADE ON UPDATE CASCADE,
 ADD CONSTRAINT `usercategory_ibfk_2` FOREIGN KEY (`userID`) REFERENCES `user` (`userID`) ON DELETE CASCADE ON UPDATE CASCADE;

--
-- AUTO_INCREMENT for dumped tables
--

COMMIT;



SET FOREIGN_KEY_CHECKS = 1;
/*!40101 SET CHARACTER_SET_CLIENT=@OLD_CHARACTER_SET_CLIENT */;
/*!40101 SET CHARACTER_SET_RESULTS=@OLD_CHARACTER_SET_RESULTS */;
/*!40101 SET COLLATION_CONNECTION=@OLD_COLLATION_CONNECTION */;
