-- phpMyAdmin SQL Dump
-- version 4.7.4
-- https://www.phpmyadmin.net/
--
-- Host: 127.0.0.1:3306
-- Generation Time: Mar 14, 2018 at 04:01 PM
-- Server version: 5.7.19
-- PHP Version: 7.1.9

SET SQL_MODE = "NO_AUTO_VALUE_ON_ZERO";
SET AUTOCOMMIT = 0;
START TRANSACTION;
SET time_zone = "+00:00";


/*!40101 SET @OLD_CHARACTER_SET_CLIENT=@@CHARACTER_SET_CLIENT */;
/*!40101 SET @OLD_CHARACTER_SET_RESULTS=@@CHARACTER_SET_RESULTS */;
/*!40101 SET @OLD_COLLATION_CONNECTION=@@COLLATION_CONNECTION */;
/*!40101 SET NAMES utf8mb4 */;

--
-- Database: `ebankingproject`
--

-- --------------------------------------------------------

--
-- Table structure for table `accounts`
--

DROP TABLE IF EXISTS `accounts`;
CREATE TABLE IF NOT EXISTS `accounts` (
  `id` int(100) NOT NULL AUTO_INCREMENT,
  `accountNumber` varchar(50) NOT NULL,
  `bankCode` varchar(50) NOT NULL,
  `dateCreated` datetime(5) NOT NULL,
  `userId` int(50) NOT NULL,
  PRIMARY KEY (`id`)
) ENGINE=MyISAM AUTO_INCREMENT=5 DEFAULT CHARSET=latin1;

--
-- Dumping data for table `accounts`
--

INSERT INTO `accounts` (`id`, `accountNumber`, `bankCode`, `dateCreated`, `userId`) VALUES
(1, '2005594449', '003', '2018-03-12 00:00:00.00000', 1),
(2, '1457903578', '001', '2018-03-12 00:00:00.00000', 2),
(3, '1001533529', '004', '2018-03-14 00:00:00.00000', 3),
(4, '9446276402', '006', '2018-03-14 00:00:00.00000', 4);

-- --------------------------------------------------------

--
-- Table structure for table `bankftpsettings`
--

DROP TABLE IF EXISTS `bankftpsettings`;
CREATE TABLE IF NOT EXISTS `bankftpsettings` (
  `id` int(11) NOT NULL AUTO_INCREMENT,
  `bankCode` varchar(100) NOT NULL,
  `transitAccount` varchar(100) NOT NULL,
  PRIMARY KEY (`id`)
) ENGINE=MyISAM AUTO_INCREMENT=7 DEFAULT CHARSET=latin1;

--
-- Dumping data for table `bankftpsettings`
--

INSERT INTO `bankftpsettings` (`id`, `bankCode`, `transitAccount`) VALUES
(1, '001', '7393635464'),
(2, '002', '353836647484'),
(3, '003', '43736445433'),
(4, '004', '37393535474'),
(5, '005', '48560244565'),
(6, '006', '67046053455');

-- --------------------------------------------------------

--
-- Table structure for table `banks`
--

DROP TABLE IF EXISTS `banks`;
CREATE TABLE IF NOT EXISTS `banks` (
  `1` int(11) NOT NULL AUTO_INCREMENT,
  `bankCode` varchar(100) NOT NULL,
  `bankName` varchar(100) NOT NULL,
  PRIMARY KEY (`1`)
) ENGINE=MyISAM AUTO_INCREMENT=7 DEFAULT CHARSET=latin1;

--
-- Dumping data for table `banks`
--

INSERT INTO `banks` (`1`, `bankCode`, `bankName`) VALUES
(1, '001', 'First Bank'),
(2, '002', 'Access Bank'),
(3, '003', 'Zenith Bank'),
(4, '004', 'Fidelity Bank'),
(5, '005', 'Eco Bank'),
(6, '006', 'Diamond Bank');

-- --------------------------------------------------------

--
-- Table structure for table `instanttransactiontlog`
--

DROP TABLE IF EXISTS `instanttransactiontlog`;
CREATE TABLE IF NOT EXISTS `instanttransactiontlog` (
  `id` int(100) NOT NULL AUTO_INCREMENT,
  `transactionRef` varchar(200) NOT NULL,
  `toAccount` varchar(100) NOT NULL,
  `toBank` varchar(100) NOT NULL,
  `amount` varchar(100) NOT NULL,
  `fromAccount` varchar(100) NOT NULL,
  `fromBank` varchar(100) NOT NULL,
  `responseCode` varchar(50) NOT NULL,
  `transactionDate` datetime(6) NOT NULL,
  `DRCR` varchar(100) NOT NULL,
  `narration` varchar(100) NOT NULL,
  PRIMARY KEY (`id`)
) ENGINE=MyISAM AUTO_INCREMENT=5 DEFAULT CHARSET=latin1;

--
-- Dumping data for table `instanttransactiontlog`
--

INSERT INTO `instanttransactiontlog` (`id`, `transactionRef`, `toAccount`, `toBank`, `amount`, `fromAccount`, `fromBank`, `responseCode`, `transactionDate`, `DRCR`, `narration`) VALUES
(1, '594653739363', '67046053455', '006', '100000', '9446276402', '006', '00', '2018-03-12 00:00:00.000000', 'DR', ''),
(2, '594653739363', '2005594449', '003', '100000', '43736445433', '003', '00', '2018-03-12 00:00:00.000000', 'CR', 'Cash Deposit by Mike Oshadami'),
(3, '375575644123', '43736445433', '003', '20000', '2005594449', '003', '00', '2018-03-14 00:00:00.000000', 'DR', 'Transfer to Ife Ibidun'),
(4, '375575644123', '1001533529', '004', '20000', '37393535474', '004', '00', '2018-03-14 00:00:00.000000', 'CR', 'NIP - Mike Oshadami');

-- --------------------------------------------------------

--
-- Table structure for table `tellertillaccount`
--

DROP TABLE IF EXISTS `tellertillaccount`;
CREATE TABLE IF NOT EXISTS `tellertillaccount` (
  `id` int(11) NOT NULL AUTO_INCREMENT,
  `user_id` int(50) NOT NULL,
  `balance` varchar(100) NOT NULL,
  `dateCreated` datetime(5) NOT NULL,
  `lastUpdated` datetime(5) NOT NULL,
  PRIMARY KEY (`id`)
) ENGINE=MyISAM AUTO_INCREMENT=2 DEFAULT CHARSET=latin1;

--
-- Dumping data for table `tellertillaccount`
--

INSERT INTO `tellertillaccount` (`id`, `user_id`, `balance`, `dateCreated`, `lastUpdated`) VALUES
(1, 4, '1000000', '2018-03-14 00:00:00.00000', '2018-03-14 00:00:00.00000');

-- --------------------------------------------------------

--
-- Table structure for table `users`
--

DROP TABLE IF EXISTS `users`;
CREATE TABLE IF NOT EXISTS `users` (
  `user_id` int(11) NOT NULL AUTO_INCREMENT,
  `user_name` varchar(25) NOT NULL,
  `account_number` varchar(60) NOT NULL,
  `user_password` varchar(255) NOT NULL,
  `role` varchar(100) NOT NULL DEFAULT 'CUSTOMER',
  `joining_date` datetime NOT NULL,
  PRIMARY KEY (`user_id`)
) ENGINE=InnoDB AUTO_INCREMENT=5 DEFAULT CHARSET=latin1;

--
-- Dumping data for table `users`
--

INSERT INTO `users` (`user_id`, `user_name`, `account_number`, `user_password`, `role`, `joining_date`) VALUES
(1, 'Mike Oshadami', '2005594449', '098f6bcd4621d373cade4e832627b4f6', 'CUSTOMER', '2015-11-08 17:25:19'),
(2, 'Joe Doe', '2005594433', '1bbd886460827015e5d605ed44252251', 'CUSTOMER', '2015-11-14 13:37:19'),
(3, 'Ife Ibidun', '1001533529', '098f6bcd4621d373cade4e832627b4f6', 'CUSTOMER', '2018-03-14 00:00:00'),
(4, 'Ometere Lawal', '9446276402', '098f6bcd4621d373cade4e832627b4f6 	', 'TELLER', '2018-03-14 00:00:00');
COMMIT;

/*!40101 SET CHARACTER_SET_CLIENT=@OLD_CHARACTER_SET_CLIENT */;
/*!40101 SET CHARACTER_SET_RESULTS=@OLD_CHARACTER_SET_RESULTS */;
/*!40101 SET COLLATION_CONNECTION=@OLD_COLLATION_CONNECTION */;
