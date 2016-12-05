-- phpMyAdmin SQL Dump
-- version 3.5.2
-- http://www.phpmyadmin.net
--
-- Host: localhost
-- Generation Time: Dec 05, 2016 at 12:39 AM
-- Server version: 5.5.25a
-- PHP Version: 5.4.4

SET SQL_MODE="NO_AUTO_VALUE_ON_ZERO";
SET time_zone = "+00:00";


/*!40101 SET @OLD_CHARACTER_SET_CLIENT=@@CHARACTER_SET_CLIENT */;
/*!40101 SET @OLD_CHARACTER_SET_RESULTS=@@CHARACTER_SET_RESULTS */;
/*!40101 SET @OLD_COLLATION_CONNECTION=@@COLLATION_CONNECTION */;
/*!40101 SET NAMES utf8 */;

--
-- Database: `activity_sniper`
--

-- --------------------------------------------------------

--
-- Table structure for table `tbl_conversation`
--

CREATE TABLE IF NOT EXISTS tbl_conversation (
  id int(11) NOT NULL AUTO_INCREMENT,
  user1 int(11) NOT NULL,
  user2 int(11) NOT NULL,
  delete_by_user1 int(11) NOT NULL DEFAULT '0',
  update_time datetime NOT NULL,
  PRIMARY KEY (`id`),

	foreign key (user1) references users (id) on delete cascade,
	foreign key (user2) references users (id) on delete cascade

) ENGINE=InnoDB DEFAULT CHARSET=latin1 AUTO_INCREMENT=1 ;

/*!40101 SET CHARACTER_SET_CLIENT=@OLD_CHARACTER_SET_CLIENT */;
/*!40101 SET CHARACTER_SET_RESULTS=@OLD_CHARACTER_SET_RESULTS */;
/*!40101 SET COLLATION_CONNECTION=@OLD_COLLATION_CONNECTION */;
