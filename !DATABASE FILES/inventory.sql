-- phpMyAdmin SQL Dump
-- version 5.2.1
-- https://www.phpmyadmin.net/
--
-- Host: 127.0.0.1
-- Generation Time: Nov 24, 2023 at 04:17 PM
-- Server version: 10.4.28-MariaDB
-- PHP Version: 8.0.28

SET SQL_MODE = "NO_AUTO_VALUE_ON_ZERO";
START TRANSACTION;
SET time_zone = "+00:00";


/*!40101 SET @OLD_CHARACTER_SET_CLIENT=@@CHARACTER_SET_CLIENT */;
/*!40101 SET @OLD_CHARACTER_SET_RESULTS=@@CHARACTER_SET_RESULTS */;
/*!40101 SET @OLD_COLLATION_CONNECTION=@@COLLATION_CONNECTION */;
/*!40101 SET NAMES utf8mb4 */;

--
-- Database: `inventory`
--

-- --------------------------------------------------------

--
-- Table structure for table `cart`
--

CREATE TABLE `cart` (
  `ID` int(11) NOT NULL,
  `UserID` varchar(255) NOT NULL,
  `Items` text NOT NULL,
  `IsPaid` varchar(15) NOT NULL,
  `IsRemoved` varchar(15) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=latin1 COLLATE=latin1_swedish_ci;

-- --------------------------------------------------------

--
-- Table structure for table `itemseqno`
--

CREATE TABLE `itemseqno` (
  `item` varchar(255) NOT NULL,
  `seqno` int(11) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=latin1 COLLATE=latin1_swedish_ci;

--
-- Dumping data for table `itemseqno`
--

INSERT INTO `itemseqno` (`item`, `seqno`) VALUES
('', 5);

-- --------------------------------------------------------

--
-- Table structure for table `itemtype`
--

CREATE TABLE `itemtype` (
  `ID` int(11) NOT NULL,
  `Description` varchar(255) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=latin1 COLLATE=latin1_swedish_ci;

--
-- Dumping data for table `itemtype`
--

INSERT INTO `itemtype` (`ID`, `Description`) VALUES
(11, 'Boots'),
(12, 'Dress');

-- --------------------------------------------------------

--
-- Table structure for table `logtrail`
--

CREATE TABLE `logtrail` (
  `ID` int(11) NOT NULL,
  `username` varchar(255) NOT NULL,
  `timestamp` timestamp NOT NULL DEFAULT current_timestamp()
) ENGINE=InnoDB DEFAULT CHARSET=latin1 COLLATE=latin1_swedish_ci;

--
-- Dumping data for table `logtrail`
--

INSERT INTO `logtrail` (`ID`, `username`, `timestamp`) VALUES
(95, 'cashier2', '2023-11-19 12:45:35'),
(96, 'admin', '2023-11-19 12:46:24'),
(97, 'cashier2', '2023-11-19 12:47:44'),
(98, 'admin', '2023-11-19 12:52:39'),
(99, 'cashier2', '2023-11-19 12:57:33'),
(100, 'admin', '2023-11-19 12:59:34'),
(101, 'admin', '2023-11-19 14:01:17'),
(102, 'cashier1', '2023-11-19 14:15:52'),
(103, 'admin', '2023-11-19 14:16:03'),
(104, 'admin', '2023-11-19 14:16:51'),
(105, 'cashier1', '2023-11-19 14:17:24'),
(106, 'admin', '2023-11-19 14:25:05'),
(107, 'cashier1', '2023-11-19 14:26:35'),
(108, 'admin', '2023-11-19 14:27:23'),
(109, 'cashier1', '2023-11-19 14:27:38'),
(110, 'admin', '2023-11-19 14:32:00'),
(111, 'cashier1', '2023-11-19 14:32:31'),
(112, 'admin', '2023-11-19 14:39:04'),
(113, 'cashier1', '2023-11-19 14:50:04'),
(114, 'admin', '2023-11-19 14:56:56');

-- --------------------------------------------------------

--
-- Table structure for table `modules`
--

CREATE TABLE `modules` (
  `Module` varchar(11) NOT NULL,
  `MainID` varchar(11) NOT NULL,
  `Description` varchar(255) NOT NULL,
  `Link` varchar(255) NOT NULL,
  `Visible` varchar(11) NOT NULL,
  `path` varchar(255) NOT NULL,
  `icons` varchar(255) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=latin1 COLLATE=latin1_swedish_ci;

--
-- Dumping data for table `modules`
--

INSERT INTO `modules` (`Module`, `MainID`, `Description`, `Link`, `Visible`, `path`, `icons`) VALUES
('1', '0101', 'Dashboard', 'dashboard.php', '1', 'dashboard', 'kanban-fill'),
('1', '0102', 'Item Type Management', 'itemtype.config.php', '1', 'item-type-management', 'folder-fill'),
('1', '0103', 'Stock Management', 'manage.product.php', '1', 'product-management', 'box2-fill'),
('1', '0104', 'Collections', 'dailycollections.php', '1', 'collections', 'collection-fill'),
('1', '0105', 'User Management', 'useracct.php', '1', 'user-management', 'people-fill'),
('1', '0306', 'Sales History', 'sales.history.php', '1', 'sales', 'bag-fill'),
('3', '0301', 'Dashboard', 'dashboard.php', '0', 'dashboard', 'kanban-fill'),
('3', '0302', 'Product List', 'products.php', '0', 'product-list', 'box2-fill'),
('3', '0303', 'Payments', 'cashier.payments.php', '1', 'payment', 'credit-card-fill'),
('3', '0304', 'Return Item', 'return.damage.php', '1', 'return-and-damaged', 'arrow-counterclockwise'),
('3', '0305', 'Sales History', 'sales.history.php', '1', 'sales', 'bag-fill');

-- --------------------------------------------------------

--
-- Table structure for table `paymentstrail`
--

CREATE TABLE `paymentstrail` (
  `ID` int(11) NOT NULL,
  `ItemCode` varchar(255) NOT NULL,
  `Quantity` varchar(11) NOT NULL,
  `AmountPaid` varchar(11) NOT NULL,
  `AmountTendered` varchar(11) NOT NULL,
  `ORNo` varchar(150) NOT NULL,
  `TransID` varchar(15) NOT NULL,
  `isCancelled` varchar(15) DEFAULT NULL,
  `Discount` varchar(15) NOT NULL,
  `TimeStamp` timestamp NOT NULL DEFAULT current_timestamp(),
  `UserID` varchar(150) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=latin1 COLLATE=latin1_swedish_ci;

--
-- Dumping data for table `paymentstrail`
--

INSERT INTO `paymentstrail` (`ID`, `ItemCode`, `Quantity`, `AmountPaid`, `AmountTendered`, `ORNo`, `TransID`, `isCancelled`, `Discount`, `TimeStamp`, `UserID`) VALUES
(39, '20', '', '552.72', '600', '2023111900001', '', NULL, '2', '2023-11-19 12:46:04', 'cashier2'),
(40, '21', '', '626.05', '700', '2023111900002', '', NULL, '5', '2023-11-19 14:23:42', 'cashier1');

-- --------------------------------------------------------

--
-- Table structure for table `products`
--

CREATE TABLE `products` (
  `ID` int(11) NOT NULL,
  `ItemCode` varchar(255) DEFAULT NULL,
  `ItemName` varchar(255) NOT NULL,
  `Description` varchar(255) DEFAULT NULL,
  `Price` varchar(11) DEFAULT NULL,
  `ItemType` varchar(11) DEFAULT NULL,
  `Quantity` varchar(11) DEFAULT NULL,
  `Size` varchar(255) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=latin1 COLLATE=latin1_swedish_ci;

--
-- Dumping data for table `products`
--

INSERT INTO `products` (`ID`, `ItemCode`, `ItemName`, `Description`, `Price`, `ItemType`, `Quantity`, `Size`) VALUES
(20, 'IT00001', 'Red Boots', 'Nice Boots Description', '564', '11', NULL, '40'),
(21, 'IT00002', 'Blue Dress', 'Nice Dress Test', '659', '12', NULL, 'Medium'),
(22, 'IT00003', 'Violet Dress', 'Violet dress Test Description', '123', '12', NULL, 'Large'),
(23, 'IT00004', 'Blue boots', 'Test boots', '1500', '11', NULL, '40');

-- --------------------------------------------------------

--
-- Table structure for table `transactions`
--

CREATE TABLE `transactions` (
  `ID` int(11) NOT NULL,
  `UserID` varchar(255) NOT NULL,
  `ItemCode` varchar(150) NOT NULL,
  `Action` varchar(50) NOT NULL,
  `TimeStamp` timestamp NOT NULL DEFAULT current_timestamp(),
  `CustomerName` varchar(255) NOT NULL,
  `Remarks` text NOT NULL,
  `Quantity` varchar(50) NOT NULL,
  `reason` text NOT NULL,
  `return_date` date DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=latin1 COLLATE=latin1_swedish_ci;

--
-- Dumping data for table `transactions`
--

INSERT INTO `transactions` (`ID`, `UserID`, `ItemCode`, `Action`, `TimeStamp`, `CustomerName`, `Remarks`, `Quantity`, `reason`, `return_date`) VALUES
(16, '', 'IT00003', '1', '2023-11-19 14:28:09', '', '', '', 'Found damage, test reason.', '2023-11-19');

-- --------------------------------------------------------

--
-- Table structure for table `users`
--

CREATE TABLE `users` (
  `id` int(11) UNSIGNED NOT NULL,
  `name` varchar(60) NOT NULL,
  `username` varchar(50) NOT NULL,
  `password` varchar(255) NOT NULL,
  `user_level` int(11) NOT NULL,
  `image` varchar(255) DEFAULT 'no_image.jpg',
  `status` int(1) NOT NULL,
  `last_login` datetime DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=latin1 COLLATE=latin1_swedish_ci;

--
-- Dumping data for table `users`
--

INSERT INTO `users` (`id`, `name`, `username`, `password`, `user_level`, `image`, `status`, `last_login`) VALUES
(1, 'Admin', 'admin', '$2y$10$GHbSSn2wjVtN1Xo7VD5bZejYXLvXIH8CKtFa8WqTjlFj8V5SkMIhq', 1, 'no_image.jpg', 1, NULL);

--
-- Indexes for dumped tables
--

--
-- Indexes for table `cart`
--
ALTER TABLE `cart`
  ADD PRIMARY KEY (`ID`);

--
-- Indexes for table `itemtype`
--
ALTER TABLE `itemtype`
  ADD PRIMARY KEY (`ID`);

--
-- Indexes for table `logtrail`
--
ALTER TABLE `logtrail`
  ADD PRIMARY KEY (`ID`);

--
-- Indexes for table `modules`
--
ALTER TABLE `modules`
  ADD PRIMARY KEY (`Module`,`MainID`);

--
-- Indexes for table `paymentstrail`
--
ALTER TABLE `paymentstrail`
  ADD PRIMARY KEY (`ID`);

--
-- Indexes for table `products`
--
ALTER TABLE `products`
  ADD PRIMARY KEY (`ID`);

--
-- Indexes for table `transactions`
--
ALTER TABLE `transactions`
  ADD PRIMARY KEY (`ID`);

--
-- Indexes for table `users`
--
ALTER TABLE `users`
  ADD PRIMARY KEY (`id`);

--
-- AUTO_INCREMENT for dumped tables
--

--
-- AUTO_INCREMENT for table `cart`
--
ALTER TABLE `cart`
  MODIFY `ID` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=2;

--
-- AUTO_INCREMENT for table `itemtype`
--
ALTER TABLE `itemtype`
  MODIFY `ID` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=13;

--
-- AUTO_INCREMENT for table `logtrail`
--
ALTER TABLE `logtrail`
  MODIFY `ID` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=115;

--
-- AUTO_INCREMENT for table `paymentstrail`
--
ALTER TABLE `paymentstrail`
  MODIFY `ID` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=41;

--
-- AUTO_INCREMENT for table `products`
--
ALTER TABLE `products`
  MODIFY `ID` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=24;

--
-- AUTO_INCREMENT for table `transactions`
--
ALTER TABLE `transactions`
  MODIFY `ID` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=17;

--
-- AUTO_INCREMENT for table `users`
--
ALTER TABLE `users`
  MODIFY `id` int(11) UNSIGNED NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=8;
COMMIT;

/*!40101 SET CHARACTER_SET_CLIENT=@OLD_CHARACTER_SET_CLIENT */;
/*!40101 SET CHARACTER_SET_RESULTS=@OLD_CHARACTER_SET_RESULTS */;
/*!40101 SET COLLATION_CONNECTION=@OLD_COLLATION_CONNECTION */;
