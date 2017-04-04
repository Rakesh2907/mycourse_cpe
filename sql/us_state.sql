-- phpMyAdmin SQL Dump
-- version 4.1.14
-- http://www.phpmyadmin.net
--
-- Host: 127.0.0.1
-- Generation Time: Aug 03, 2016 at 01:14 AM
-- Server version: 5.6.17
-- PHP Version: 5.5.12

SET SQL_MODE = "NO_AUTO_VALUE_ON_ZERO";
SET time_zone = "+00:00";


/*!40101 SET @OLD_CHARACTER_SET_CLIENT=@@CHARACTER_SET_CLIENT */;
/*!40101 SET @OLD_CHARACTER_SET_RESULTS=@@CHARACTER_SET_RESULTS */;
/*!40101 SET @OLD_COLLATION_CONNECTION=@@COLLATION_CONNECTION */;
/*!40101 SET NAMES utf8 */;

--
-- Database: `trtcle_updated`
--

-- --------------------------------------------------------

--
-- Table structure for table `us_state`
--

CREATE TABLE IF NOT EXISTS `us_state` (
  `state_id` smallint(6) NOT NULL AUTO_INCREMENT COMMENT 'PK: Unique state ID',
  `state` varchar(32) NOT NULL DEFAULT '' COMMENT 'State name with first letter capital',
  `state_abbr` varchar(8) DEFAULT NULL COMMENT 'Optional state abbreviation (US is 2 capital letters)',
  `state_website` varchar(255) NOT NULL DEFAULT '',
  PRIMARY KEY (`state_id`)
) ENGINE=MyISAM  DEFAULT CHARSET=latin1 AUTO_INCREMENT=57 ;

--
-- Dumping data for table `us_state`
--

INSERT INTO `us_state` (`state_id`, `state`, `state_abbr`, `state_website`) VALUES
(1, 'Alabama', 'AL', 'http://marinolegalcle.com/alabama.php'),
(2, 'Alaska', 'AK', 'http://www.marinolegalcle.com/alaska.php'),
(3, 'Arizona', 'AZ', 'http://www.marinolegalcle.com/arizona.php'),
(4, 'Arkansas', 'AR', 'http://www.marinolegalcle.com/arkansas.php'),
(5, 'California', 'CA', 'http://www.marinolegalcle.com/california.php'),
(6, 'Colorado', 'CO', 'http://www.marinolegalcle.com/colorado.php'),
(7, 'Connecticut', 'CT', 'http://www.marinolegalcle.com/connecticut.php'),
(8, 'Delaware', 'DE', 'http://www.marinolegalcle.com/delaware.php'),
(9, 'District of Columbia', 'DC', 'http://www.marinolegalcle.com/district-of-columbia.php'),
(10, 'Florida', 'FL', 'http://www.marinolegalcle.com/florida.php'),
(11, 'Georgia', 'GA', 'http://www.marinolegalcle.com/georgia.php'),
(12, 'Hawaii', 'HI', 'http://www.marinolegalcle.com/hawaii.php'),
(13, 'Idaho', 'ID', 'http://www.marinolegalcle.com/idaho.php'),
(14, 'Illinois', 'IL', 'http://illinois.marinolegalcle.com/'),
(15, 'Indiana', 'IN', 'http://www.marinolegalcle.com/indiana.php'),
(16, 'Iowa', 'IA', 'http://www.marinolegalcle.com/iowa.php'),
(17, 'Kansas', 'KS', 'http://www.marinolegalcle.com/kansas.php'),
(18, 'Kentucky', 'KY', 'http://www.marinolegalcle.com/kentucky.php'),
(19, 'Louisiana', 'LA', 'http://www.marinolegalcle.com/louisiana.php'),
(20, 'Maine', 'ME', 'http://www.marinolegalcle.com/maine.php'),
(21, 'Maryland', 'MD', 'http://www.marinolegalcle.com/maryland.php'),
(22, 'Massachusetts', 'MA', 'http://www.marinolegalcle.com/massachusetts.php'),
(23, 'Michigan', 'MI', 'http://www.marinolegalcle.com/michigan.php'),
(24, 'Minnesota', 'MN', 'http://www.marinolegalcle.com/minnesota.php'),
(25, 'Mississippi', 'MS', 'http://www.marinolegalcle.com/mississippi.php'),
(26, 'Missouri', 'MO', 'http://www.marinolegalcle.com/missouri.php'),
(27, 'Montana', 'MT', 'http://www.marinolegalcle.com/montana.php'),
(28, 'Nebraska', 'NE', 'http://www.marinolegalcle.com/nebraska.php'),
(29, 'Nevada', 'NV', 'http://www.marinolegalcle.com/nevada.php'),
(30, 'New Hampshire', 'NH', 'http://www.marinolegalcle.com/new-hampshire.php'),
(31, 'New Jersey', 'NJ', 'http://newjersey.marinolegalcle.com/'),
(32, 'New Mexico', 'NM', 'http://www.marinolegalcle.com/new-mexico.php'),
(33, 'New York', 'NY', 'http://newyork.marinolegalcle.com/'),
(34, 'North Carolina', 'NC', 'http://www.marinolegalcle.com/north-carolina.php'),
(35, 'North Dakota', 'ND', 'http://www.marinolegalcle.com/north-dakota.php'),
(36, 'Ohio', 'OH', 'http://www.marinolegalcle.com/ohio.php'),
(37, 'Oklahoma', 'OK', 'http://www.marinolegalcle.com/oklahoma.php'),
(38, 'Oregon', 'OR', 'http://www.marinolegalcle.com/oregon.php'),
(39, 'Pennsylvania', 'PA', 'http://www.marinolegalcle.com/pennsylvania.php'),
(40, 'Rhode Island', 'RI', 'http://www.marinolegalcle.com/rhode-island.php'),
(41, 'South Carolina', 'SC', 'http://www.marinolegalcle.com/south-carolina.php'),
(42, 'South Dakota', 'SD', 'http://www.marinolegalcle.com/south-dakota.php'),
(43, 'Tennessee', 'TN', 'http://www.marinolegalcle.com/tennessee.php'),
(44, 'Texas', 'TX', 'http://www.marinolegalcle.com/texas.php'),
(45, 'Utah', 'UT', 'http://www.marinolegalcle.com/utah.php'),
(46, 'Vermont', 'VT', 'http://www.marinolegalcle.com/vermont.php'),
(47, 'Virginia', 'VA', 'http://www.marinolegalcle.com/virginia.php'),
(48, 'Washington', 'WA', 'http://www.marinolegalcle.com/washington.php'),
(49, 'West Virginia', 'WV', 'http://www.marinolegalcle.com/west-virginia.php'),
(50, 'Wisconsin', 'WI', 'http://www.marinolegalcle.com/wisconsin.php'),
(51, 'Wyoming', 'WY', 'http://www.marinolegalcle.com/wyoming.php'),
(52, 'TRT', 'TT', 'http://www.marinolegalcle.com/trt.php'),
(53, 'Ontario', 'OT', 'https://www.bridgethegapcle.com/'),
(54, 'New Brunswick', 'NB', 'https://www.bridgethegapcle.com/'),
(55, 'British Columbia', 'BC', 'https://www.bridgethegapcle.com/'),
(56, 'Puerto Rico', 'PR', 'https://www.bridgethegapcle.com/');

/*!40101 SET CHARACTER_SET_CLIENT=@OLD_CHARACTER_SET_CLIENT */;
/*!40101 SET CHARACTER_SET_RESULTS=@OLD_CHARACTER_SET_RESULTS */;
/*!40101 SET COLLATION_CONNECTION=@OLD_COLLATION_CONNECTION */;
