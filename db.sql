-- phpMyAdmin SQL Dump
-- version 4.1.14
-- http://www.phpmyadmin.net
--
-- Host: 127.0.0.1
-- Generation Time: Jul 03, 2015 at 01:52 PM
-- Server version: 5.6.17
-- PHP Version: 5.5.12

SET SQL_MODE = "NO_AUTO_VALUE_ON_ZERO";
SET time_zone = "+00:00";


/*!40101 SET @OLD_CHARACTER_SET_CLIENT=@@CHARACTER_SET_CLIENT */;
/*!40101 SET @OLD_CHARACTER_SET_RESULTS=@@CHARACTER_SET_RESULTS */;
/*!40101 SET @OLD_COLLATION_CONNECTION=@@COLLATION_CONNECTION */;
/*!40101 SET NAMES utf8 */;

--
-- Database: `kitalepo_ktti`
--

-- --------------------------------------------------------

--
-- Table structure for table `events`
--

CREATE TABLE IF NOT EXISTS `events` (
  `event_id` int(12) NOT NULL AUTO_INCREMENT,
  `event_date` date NOT NULL,
  `event_title` text NOT NULL,
  `event_desc` varchar(23) NOT NULL,
  `event_venue` varchar(200) NOT NULL,
  PRIMARY KEY (`event_id`)
) ENGINE=MyISAM  DEFAULT CHARSET=latin1 AUTO_INCREMENT=5 ;

--
-- Dumping data for table `events`
--

INSERT INTO `events` (`event_id`, `event_date`, `event_title`, `event_desc`, `event_venue`) VALUES
(1, '2015-06-29', 'The national KATT games will be held at kisumu polytechnic as from 27th July 2015.', '', 'Games master');

-- --------------------------------------------------------

--
-- Table structure for table `news`
--

CREATE TABLE IF NOT EXISTS `news` (
  `news_id` int(12) NOT NULL AUTO_INCREMENT,
  `news_date` date NOT NULL,
  `news_subj` varchar(155) NOT NULL,
  `news_message` text NOT NULL,
  `news_author` varchar(23) NOT NULL,
  PRIMARY KEY (`news_id`),
  FULLTEXT KEY `news_subj` (`news_subj`)
) ENGINE=MyISAM  DEFAULT CHARSET=latin1 AUTO_INCREMENT=13 ;

--
-- Dumping data for table `news`
--

INSERT INTO `news` (`news_id`, `news_date`, `news_subj`, `news_message`, `news_author`) VALUES
(10, '2015-07-02', 'Breaking news', '<p>Lorem ipsum is now breaking news</p>', 'Admin'),
(8, '2015-06-30', 'INTAKE IN PROGRESS', 'we wish to inform you that September 2015 intake is in progress.for more information about courses outline please download our brochures from download link. or email us to kitaletechnical@gmail.com', 'Registrar'),
(12, '2015-07-02', 'Soccer II', '<p>Lorem ipsum soccer decit</p>', 'Admin Kinunu');

/*!40101 SET CHARACTER_SET_CLIENT=@OLD_CHARACTER_SET_CLIENT */;
/*!40101 SET CHARACTER_SET_RESULTS=@OLD_CHARACTER_SET_RESULTS */;
/*!40101 SET COLLATION_CONNECTION=@OLD_COLLATION_CONNECTION */;
