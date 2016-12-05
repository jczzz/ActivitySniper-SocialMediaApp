-- phpMyAdmin SQL Dump
-- version 3.5.2
-- http://www.phpmyadmin.net
--
-- Host: localhost
-- Generation Time: Dec 05, 2016 at 12:38 AM
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
-- Table structure for table `private_messages`
--

CREATE TABLE IF NOT EXISTS private_messages (
  message_id int(11) NOT NULL AUTO_INCREMENT,
  conversation_id int(11) NOT NULL,
  sender_id bigint(20) NOT NULL,
  receiver_id bigint(20) NOT NULL,
  message text NOT NULL,
  message_read int(11) NOT NULL DEFAULT '0',
  mark_as_inappropriate enum('0','1') NOT NULL DEFAULT '0',
  created datetime NOT NULL,
  PRIMARY KEY (message_id),

	foreign key (conversation_id) references tbl_conversation (id) on delete cascade
	

) ENGINE=InnoDB DEFAULT CHARSET=latin1 AUTO_INCREMENT=1 ;

/*foreign key (sender_id) references users (id) on delete cascade,
	foreign key (receiver_id) references users (id) on delete cascade*/
	
/*!40101 SET CHARACTER_SET_CLIENT=@OLD_CHARACTER_SET_CLIENT */;
/*!40101 SET CHARACTER_SET_RESULTS=@OLD_CHARACTER_SET_RESULTS */;
/*!40101 SET COLLATION_CONNECTION=@OLD_COLLATION_CONNECTION */;
