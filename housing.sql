-- phpMyAdmin SQL Dump
-- version 4.0.4.1
-- http://www.phpmyadmin.net
--
-- Host: 127.0.0.1
-- Generation Time: Dec 15, 2014 at 11:11 AM
-- Server version: 5.5.32
-- PHP Version: 5.4.19

SET SQL_MODE = "NO_AUTO_VALUE_ON_ZERO";
SET time_zone = "+00:00";


/*!40101 SET @OLD_CHARACTER_SET_CLIENT=@@CHARACTER_SET_CLIENT */;
/*!40101 SET @OLD_CHARACTER_SET_RESULTS=@@CHARACTER_SET_RESULTS */;
/*!40101 SET @OLD_COLLATION_CONNECTION=@@COLLATION_CONNECTION */;
/*!40101 SET NAMES utf8 */;

--
-- Database: `housing`
--
CREATE DATABASE IF NOT EXISTS `housing` DEFAULT CHARACTER SET latin1 COLLATE latin1_swedish_ci;
USE `housing`;

-- --------------------------------------------------------

--
-- Table structure for table `accesslevel`
--

CREATE TABLE IF NOT EXISTS `accesslevel` (
  `id` int(11) NOT NULL AUTO_INCREMENT,
  `name` varchar(255) NOT NULL,
  PRIMARY KEY (`id`),
  UNIQUE KEY `name` (`name`)
) ENGINE=InnoDB  DEFAULT CHARSET=latin1 AUTO_INCREMENT=4 ;

--
-- Dumping data for table `accesslevel`
--

INSERT INTO `accesslevel` (`id`, `name`) VALUES
(1, 'admin'),
(2, 'Operator'),
(3, 'User');

-- --------------------------------------------------------

--
-- Table structure for table `amenity`
--

CREATE TABLE IF NOT EXISTS `amenity` (
  `id` int(11) NOT NULL AUTO_INCREMENT,
  `name` varchar(255) NOT NULL,
  `image` varchar(255) NOT NULL,
  PRIMARY KEY (`id`)
) ENGINE=InnoDB  DEFAULT CHARSET=latin1 AUTO_INCREMENT=3 ;

--
-- Dumping data for table `amenity`
--

INSERT INTO `amenity` (`id`, `name`, `image`) VALUES
(1, 'AC', ''),
(2, 'TV', '');

-- --------------------------------------------------------

--
-- Table structure for table `builder`
--

CREATE TABLE IF NOT EXISTS `builder` (
  `id` int(11) NOT NULL AUTO_INCREMENT,
  `name` varchar(255) NOT NULL,
  `email` varchar(255) NOT NULL,
  `contact` varchar(255) NOT NULL,
  `address` text NOT NULL,
  PRIMARY KEY (`id`)
) ENGINE=InnoDB  DEFAULT CHARSET=latin1 AUTO_INCREMENT=2 ;

--
-- Dumping data for table `builder`
--

INSERT INTO `builder` (`id`, `name`, `email`, `contact`, `address`) VALUES
(1, 'Builder', 'builder@gmail.com', '8989898989', 'Builder Apt. Thane');

-- --------------------------------------------------------

--
-- Table structure for table `category`
--

CREATE TABLE IF NOT EXISTS `category` (
  `id` int(11) NOT NULL AUTO_INCREMENT,
  `name` varchar(255) NOT NULL,
  PRIMARY KEY (`id`)
) ENGINE=InnoDB  DEFAULT CHARSET=latin1 AUTO_INCREMENT=5 ;

--
-- Dumping data for table `category`
--

INSERT INTO `category` (`id`, `name`) VALUES
(1, 'Rent'),
(2, 'Buy'),
(3, 'New Property'),
(4, 'Land');

-- --------------------------------------------------------

--
-- Table structure for table `furnishing`
--

CREATE TABLE IF NOT EXISTS `furnishing` (
  `id` int(11) NOT NULL AUTO_INCREMENT,
  `name` varchar(255) NOT NULL,
  PRIMARY KEY (`id`)
) ENGINE=InnoDB  DEFAULT CHARSET=latin1 AUTO_INCREMENT=4 ;

--
-- Dumping data for table `furnishing`
--

INSERT INTO `furnishing` (`id`, `name`) VALUES
(1, 'Fully Furnished'),
(2, 'Semi Furnished'),
(3, 'Unfurnished');

-- --------------------------------------------------------

--
-- Table structure for table `leasetype`
--

CREATE TABLE IF NOT EXISTS `leasetype` (
  `id` int(11) NOT NULL AUTO_INCREMENT,
  `name` varchar(255) NOT NULL,
  PRIMARY KEY (`id`)
) ENGINE=InnoDB  DEFAULT CHARSET=latin1 AUTO_INCREMENT=3 ;

--
-- Dumping data for table `leasetype`
--

INSERT INTO `leasetype` (`id`, `name`) VALUES
(1, 'Family Only'),
(2, 'Family and Company');

-- --------------------------------------------------------

--
-- Table structure for table `listedby`
--

CREATE TABLE IF NOT EXISTS `listedby` (
  `id` int(11) NOT NULL AUTO_INCREMENT,
  `name` varchar(255) NOT NULL,
  PRIMARY KEY (`id`)
) ENGINE=InnoDB  DEFAULT CHARSET=latin1 AUTO_INCREMENT=3 ;

--
-- Dumping data for table `listedby`
--

INSERT INTO `listedby` (`id`, `name`) VALUES
(1, 'Broker'),
(2, 'Landlord');

-- --------------------------------------------------------

--
-- Table structure for table `logintype`
--

CREATE TABLE IF NOT EXISTS `logintype` (
  `id` int(11) NOT NULL AUTO_INCREMENT,
  `name` varchar(255) NOT NULL,
  PRIMARY KEY (`id`)
) ENGINE=InnoDB  DEFAULT CHARSET=latin1 AUTO_INCREMENT=5 ;

--
-- Dumping data for table `logintype`
--

INSERT INTO `logintype` (`id`, `name`) VALUES
(1, 'Facebook'),
(2, 'Twitter'),
(3, 'Email'),
(4, 'Google');

-- --------------------------------------------------------

--
-- Table structure for table `menu`
--

CREATE TABLE IF NOT EXISTS `menu` (
  `id` int(11) NOT NULL AUTO_INCREMENT,
  `name` varchar(255) NOT NULL,
  `description` varchar(255) NOT NULL,
  `keyword` varchar(255) NOT NULL,
  `url` text NOT NULL,
  `linktype` int(11) NOT NULL,
  `parent` int(11) NOT NULL,
  `isactive` int(11) NOT NULL,
  `order` int(11) NOT NULL,
  `icon` varchar(255) NOT NULL,
  PRIMARY KEY (`id`)
) ENGINE=InnoDB  DEFAULT CHARSET=latin1 AUTO_INCREMENT=10 ;

--
-- Dumping data for table `menu`
--

INSERT INTO `menu` (`id`, `name`, `description`, `keyword`, `url`, `linktype`, `parent`, `isactive`, `order`, `icon`) VALUES
(1, 'Users', '', '', 'site/viewusers', 1, 0, 1, 1, 'icon-user'),
(4, 'Dashboard', '', '', 'site/index', 1, 0, 1, 0, 'icon-dashboard'),
(5, 'Property', '', '', 'site/viewproperty', 1, 0, 1, 2, 'icon-dashboard'),
(6, 'Society Facility', '', '', 'site/viewsocietyfacility', 1, 0, 1, 3, 'icon-dashboard'),
(7, 'Amenities', '', '', 'site/viewamenity', 1, 0, 1, 4, 'icon-dashboard'),
(8, 'Builder', '', '', 'site/viewbuilder', 1, 0, 1, 5, 'icon-dashboard'),
(9, 'Lease Types', '', '', 'site/viewleasetype', 1, 0, 1, 6, 'icon-dashboard');

-- --------------------------------------------------------

--
-- Table structure for table `menuaccess`
--

CREATE TABLE IF NOT EXISTS `menuaccess` (
  `menu` int(11) NOT NULL,
  `access` int(11) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=latin1;

--
-- Dumping data for table `menuaccess`
--

INSERT INTO `menuaccess` (`menu`, `access`) VALUES
(1, 1),
(4, 1),
(2, 1),
(3, 1),
(5, 1),
(6, 1),
(7, 1),
(7, 3),
(8, 1),
(9, 1),
(10, 1),
(11, 1),
(12, 1);

-- --------------------------------------------------------

--
-- Table structure for table `property`
--

CREATE TABLE IF NOT EXISTS `property` (
  `id` int(11) NOT NULL AUTO_INCREMENT,
  `name` varchar(255) NOT NULL,
  `email` varchar(255) NOT NULL,
  `category` int(11) NOT NULL,
  `builder` int(11) NOT NULL,
  `listingowner` int(11) NOT NULL,
  `price` varchar(255) NOT NULL,
  `leasetype` int(11) NOT NULL,
  `listedby` int(11) NOT NULL,
  `furnishing` int(11) NOT NULL,
  `propertytype` int(11) NOT NULL,
  `timestamp` timestamp NOT NULL DEFAULT CURRENT_TIMESTAMP ON UPDATE CURRENT_TIMESTAMP,
  `bathroom` varchar(255) NOT NULL,
  `negotiable` varchar(255) NOT NULL,
  `securitydeposite` varchar(255) NOT NULL,
  `bhk` varchar(255) NOT NULL,
  `address1` text NOT NULL,
  `address2` text NOT NULL,
  `locality` varchar(255) NOT NULL,
  `city` varchar(255) NOT NULL,
  `pincode` varchar(255) NOT NULL,
  `builduparea` varchar(255) NOT NULL,
  `carpetarea` varchar(255) NOT NULL,
  `facing` varchar(255) NOT NULL,
  `powerbackup` varchar(255) NOT NULL,
  `verified` varchar(255) NOT NULL,
  `status` int(11) NOT NULL,
  `reportmessage` text NOT NULL,
  `commitescore` varchar(255) NOT NULL,
  `localityscore` varchar(255) NOT NULL,
  `societyscore` varchar(255) NOT NULL,
  `possesion` int(11) NOT NULL,
  `aerialview` varchar(255) NOT NULL,
  `insights` varchar(255) NOT NULL,
  `pricetrends` varchar(255) NOT NULL,
  `yearofestablishment` varchar(255) NOT NULL,
  `totalprojects` varchar(255) NOT NULL,
  `associatemembership` varchar(255) NOT NULL,
  `interior` text NOT NULL,
  `floorplan3d` varchar(255) NOT NULL,
  `floorplan2d` varchar(255) NOT NULL,
  `iscommercial` varchar(255) NOT NULL,
  PRIMARY KEY (`id`)
) ENGINE=InnoDB  DEFAULT CHARSET=latin1 AUTO_INCREMENT=5 ;

--
-- Dumping data for table `property`
--

INSERT INTO `property` (`id`, `name`, `email`, `category`, `builder`, `listingowner`, `price`, `leasetype`, `listedby`, `furnishing`, `propertytype`, `timestamp`, `bathroom`, `negotiable`, `securitydeposite`, `bhk`, `address1`, `address2`, `locality`, `city`, `pincode`, `builduparea`, `carpetarea`, `facing`, `powerbackup`, `verified`, `status`, `reportmessage`, `commitescore`, `localityscore`, `societyscore`, `possesion`, `aerialview`, `insights`, `pricetrends`, `yearofestablishment`, `totalprojects`, `associatemembership`, `interior`, `floorplan3d`, `floorplan2d`, `iscommercial`) VALUES
(1, '1', '1988.kalpesh@gmail.com', 3, 1, 1, '1', 1, 1, 1, 1, '2014-12-14 01:24:00', 'Any', 'True', '1', '1RK', '1', '1', '1', '1', '1', '1', '1', '1', '1', 'Yes', 1, '1', '1', '1', '1', 1, '1', '1', '1', '1', '1', '1', '1', '1', 'Logo_(1)10.png', 'False'),
(3, '3', '3@3.com', 1, 1, 1, '3', 1, 1, 1, 1, '2014-12-13 21:52:17', '3+', 'True', '3', '3BHK', '3', '3', '3', '3', '3', '3', '3', '3', '33', 'Yes', 1, '3', '3', '3', '3', 3, '3', '3', '3', '3', '3', '3', '3', '3', 'Logo_(1)8.png', 'True'),
(4, 'test', 'test@email.com', 3, 1, 5, '400000', 2, 2, 2, 1, '2014-12-14 04:21:41', '1+', 'False', '1', '1BHK', 'karjat', '1', '2', '2', '2', '2', '2', '2', '2', 'Yes', 1, '2', '2', '2', '2', 2, '2', '2', '2', '2', '2', '2', '2', '2', '', 'False');

-- --------------------------------------------------------

--
-- Table structure for table `propertyamenity`
--

CREATE TABLE IF NOT EXISTS `propertyamenity` (
  `id` int(11) NOT NULL AUTO_INCREMENT,
  `property` int(11) NOT NULL,
  `amenity` int(11) NOT NULL,
  PRIMARY KEY (`id`)
) ENGINE=InnoDB  DEFAULT CHARSET=latin1 AUTO_INCREMENT=6 ;

--
-- Dumping data for table `propertyamenity`
--

INSERT INTO `propertyamenity` (`id`, `property`, `amenity`) VALUES
(4, 4, 1),
(5, 4, 2);

-- --------------------------------------------------------

--
-- Table structure for table `propertyenquiry`
--

CREATE TABLE IF NOT EXISTS `propertyenquiry` (
  `id` int(11) NOT NULL AUTO_INCREMENT,
  `message` text NOT NULL,
  `user` int(11) NOT NULL,
  `contact` varchar(255) NOT NULL,
  `email` varchar(255) NOT NULL,
  `property` int(11) NOT NULL,
  `timestamp` timestamp NOT NULL DEFAULT CURRENT_TIMESTAMP ON UPDATE CURRENT_TIMESTAMP,
  PRIMARY KEY (`id`)
) ENGINE=InnoDB  DEFAULT CHARSET=latin1 AUTO_INCREMENT=2 ;

--
-- Dumping data for table `propertyenquiry`
--

INSERT INTO `propertyenquiry` (`id`, `message`, `user`, `contact`, `email`, `property`, `timestamp`) VALUES
(1, 'Nice Block1', 14, '876544444', 'a@email.com', 4, '2014-12-14 10:34:54');

-- --------------------------------------------------------

--
-- Table structure for table `propertygeolocation`
--

CREATE TABLE IF NOT EXISTS `propertygeolocation` (
  `id` int(11) NOT NULL AUTO_INCREMENT,
  `property` int(11) NOT NULL,
  `lat` varchar(255) NOT NULL,
  `long` varchar(255) NOT NULL,
  PRIMARY KEY (`id`)
) ENGINE=InnoDB  DEFAULT CHARSET=latin1 AUTO_INCREMENT=2 ;

--
-- Dumping data for table `propertygeolocation`
--

INSERT INTO `propertygeolocation` (`id`, `property`, `lat`, `long`) VALUES
(1, 4, '20.03423', '30.13123');

-- --------------------------------------------------------

--
-- Table structure for table `propertyimage`
--

CREATE TABLE IF NOT EXISTS `propertyimage` (
  `id` int(11) NOT NULL AUTO_INCREMENT,
  `property` int(11) NOT NULL,
  `image` varchar(255) NOT NULL,
  PRIMARY KEY (`id`)
) ENGINE=InnoDB  DEFAULT CHARSET=latin1 AUTO_INCREMENT=6 ;

--
-- Dumping data for table `propertyimage`
--

INSERT INTO `propertyimage` (`id`, `property`, `image`) VALUES
(1, 1, 'logo.png'),
(5, 4, 'logo_(2)5.png');

-- --------------------------------------------------------

--
-- Table structure for table `propertysocietyfacility`
--

CREATE TABLE IF NOT EXISTS `propertysocietyfacility` (
  `id` int(11) NOT NULL AUTO_INCREMENT,
  `property` int(11) NOT NULL,
  `societyfacility` int(11) NOT NULL,
  PRIMARY KEY (`id`)
) ENGINE=InnoDB  DEFAULT CHARSET=latin1 AUTO_INCREMENT=4 ;

--
-- Dumping data for table `propertysocietyfacility`
--

INSERT INTO `propertysocietyfacility` (`id`, `property`, `societyfacility`) VALUES
(3, 4, 2);

-- --------------------------------------------------------

--
-- Table structure for table `propertytype`
--

CREATE TABLE IF NOT EXISTS `propertytype` (
  `id` int(11) NOT NULL AUTO_INCREMENT,
  `name` varchar(255) NOT NULL,
  PRIMARY KEY (`id`)
) ENGINE=InnoDB  DEFAULT CHARSET=latin1 AUTO_INCREMENT=2 ;

--
-- Dumping data for table `propertytype`
--

INSERT INTO `propertytype` (`id`, `name`) VALUES
(1, 'Apartment');

-- --------------------------------------------------------

--
-- Table structure for table `societyfacility`
--

CREATE TABLE IF NOT EXISTS `societyfacility` (
  `id` int(11) NOT NULL AUTO_INCREMENT,
  `name` varchar(255) NOT NULL,
  PRIMARY KEY (`id`)
) ENGINE=InnoDB  DEFAULT CHARSET=latin1 AUTO_INCREMENT=3 ;

--
-- Dumping data for table `societyfacility`
--

INSERT INTO `societyfacility` (`id`, `name`) VALUES
(2, 'Gym');

-- --------------------------------------------------------

--
-- Table structure for table `statuses`
--

CREATE TABLE IF NOT EXISTS `statuses` (
  `id` int(11) NOT NULL AUTO_INCREMENT,
  `name` varchar(255) NOT NULL,
  PRIMARY KEY (`id`)
) ENGINE=InnoDB  DEFAULT CHARSET=latin1 AUTO_INCREMENT=6 ;

--
-- Dumping data for table `statuses`
--

INSERT INTO `statuses` (`id`, `name`) VALUES
(1, 'inactive'),
(2, 'Active'),
(3, 'Waiting'),
(4, 'Active Waiting'),
(5, 'Blocked');

-- --------------------------------------------------------

--
-- Table structure for table `user`
--

CREATE TABLE IF NOT EXISTS `user` (
  `id` int(11) NOT NULL AUTO_INCREMENT,
  `name` varchar(255) DEFAULT NULL,
  `password` varchar(255) NOT NULL,
  `email` varchar(255) NOT NULL,
  `accesslevel` int(11) DEFAULT NULL,
  `timestamp` timestamp NULL DEFAULT CURRENT_TIMESTAMP,
  `status` int(11) DEFAULT NULL,
  `contact` varchar(255) NOT NULL,
  `address` text NOT NULL,
  PRIMARY KEY (`id`)
) ENGINE=InnoDB  DEFAULT CHARSET=latin1 AUTO_INCREMENT=15 ;

--
-- Dumping data for table `user`
--

INSERT INTO `user` (`id`, `name`, `password`, `email`, `accesslevel`, `timestamp`, `status`, `contact`, `address`) VALUES
(1, 'wohlig', 'a63526467438df9566c508027d9cb06b', 'wohlig@wohlig.com', 1, '0000-00-00 00:00:00', 1, '', ''),
(4, 'pratik', '0cb2b62754dfd12b6ed0161d4b447df7', 'pratik@wohlig.com', 1, '2014-05-12 06:52:44', 1, '', ''),
(5, 'wohlig123', 'wohlig123', 'wohlig1@wohlig.com', 1, '2014-05-12 06:52:44', 1, '', ''),
(6, 'wohlig1', 'a63526467438df9566c508027d9cb06b', 'wohlig2@wohlig.com', 1, '2014-05-12 06:52:44', 1, '', ''),
(7, 'Avinash', '7b0a80efe0d324e937bbfc7716fb15d3', 'avinash@wohlig.com', 1, '2014-10-17 06:22:29', 1, '', ''),
(9, 'avinash', 'a208e5837519309129fa466b0c68396b', 'a@email.com', 2, '2014-12-03 11:06:19', 3, '', ''),
(13, 'aaa', 'a208e5837519309129fa466b0c68396b', 'aaa3@email.com', 3, '2014-12-04 06:55:42', 3, '', ''),
(14, 'avinash4', '0808e83ce0612e2a843dc420151d6d1a', 'avi4@email.com', 0, '2014-12-13 17:20:07', NULL, '9876543211', 'karjat,East');

-- --------------------------------------------------------

--
-- Table structure for table `userlog`
--

CREATE TABLE IF NOT EXISTS `userlog` (
  `id` int(11) NOT NULL AUTO_INCREMENT,
  `onuser` int(11) NOT NULL,
  `status` int(11) NOT NULL,
  `description` varchar(255) NOT NULL,
  `timestamp` timestamp NOT NULL DEFAULT CURRENT_TIMESTAMP,
  PRIMARY KEY (`id`)
) ENGINE=InnoDB  DEFAULT CHARSET=latin1 AUTO_INCREMENT=33 ;

--
-- Dumping data for table `userlog`
--

INSERT INTO `userlog` (`id`, `onuser`, `status`, `description`, `timestamp`) VALUES
(1, 1, 1, 'User Address Edited', '2014-05-12 06:50:21'),
(2, 1, 1, 'User Details Edited', '2014-05-12 06:51:43'),
(3, 1, 1, 'User Details Edited', '2014-05-12 06:51:53'),
(4, 4, 1, 'User Created', '2014-05-12 06:52:44'),
(5, 4, 1, 'User Address Edited', '2014-05-12 12:31:48'),
(6, 23, 2, 'User Created', '2014-10-07 06:46:55'),
(7, 24, 2, 'User Created', '2014-10-07 06:48:25'),
(8, 25, 2, 'User Created', '2014-10-07 06:49:04'),
(9, 26, 2, 'User Created', '2014-10-07 06:49:16'),
(10, 27, 2, 'User Created', '2014-10-07 06:52:18'),
(11, 28, 2, 'User Created', '2014-10-07 06:52:45'),
(12, 29, 2, 'User Created', '2014-10-07 06:53:10'),
(13, 30, 2, 'User Created', '2014-10-07 06:53:33'),
(14, 31, 2, 'User Created', '2014-10-07 06:55:03'),
(15, 32, 2, 'User Created', '2014-10-07 06:55:33'),
(16, 33, 2, 'User Created', '2014-10-07 06:59:32'),
(17, 34, 2, 'User Created', '2014-10-07 07:01:18'),
(18, 35, 2, 'User Created', '2014-10-07 07:01:50'),
(19, 34, 2, 'User Details Edited', '2014-10-07 07:04:34'),
(20, 18, 2, 'User Details Edited', '2014-10-07 07:05:11'),
(21, 18, 2, 'User Details Edited', '2014-10-07 07:05:45'),
(22, 18, 2, 'User Details Edited', '2014-10-07 07:06:03'),
(23, 7, 6, 'User Created', '2014-10-17 06:22:29'),
(24, 7, 6, 'User Details Edited', '2014-10-17 06:32:22'),
(25, 7, 6, 'User Details Edited', '2014-10-17 06:32:37'),
(26, 8, 6, 'User Created', '2014-11-15 12:05:52'),
(27, 9, 6, 'User Created', '2014-12-02 10:46:36'),
(28, 9, 6, 'User Details Edited', '2014-12-02 10:47:34'),
(29, 4, 6, 'User Details Edited', '2014-12-03 10:34:49'),
(30, 4, 6, 'User Details Edited', '2014-12-03 10:36:34'),
(31, 4, 6, 'User Details Edited', '2014-12-03 10:36:49'),
(32, 8, 6, 'User Details Edited', '2014-12-03 10:47:16');

/*!40101 SET CHARACTER_SET_CLIENT=@OLD_CHARACTER_SET_CLIENT */;
/*!40101 SET CHARACTER_SET_RESULTS=@OLD_CHARACTER_SET_RESULTS */;
/*!40101 SET COLLATION_CONNECTION=@OLD_COLLATION_CONNECTION */;
