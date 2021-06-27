-- phpMyAdmin SQL Dump
-- version 4.2.7.1
-- http://www.phpmyadmin.net
--
-- Host: localhost
-- Generation Time: Aug 13, 2017 at 12:05 PM
-- Server version: 5.6.20
-- PHP Version: 5.5.15

SET SQL_MODE = "NO_AUTO_VALUE_ON_ZERO";
SET time_zone = "+00:00";


/*!40101 SET @OLD_CHARACTER_SET_CLIENT=@@CHARACTER_SET_CLIENT */;
/*!40101 SET @OLD_CHARACTER_SET_RESULTS=@@CHARACTER_SET_RESULTS */;
/*!40101 SET @OLD_COLLATION_CONNECTION=@@COLLATION_CONNECTION */;
/*!40101 SET NAMES utf8 */;

--
-- Database: `slotify`
--

-- --------------------------------------------------------

--
-- Table structure for table `Songs`
--

CREATE TABLE IF NOT EXISTS `Songs` (
`id` int(11) NOT NULL,
  `title` varchar(250) NOT NULL,
  `artist` int(11) NOT NULL,
  `album` int(11) NOT NULL,
  `genre` int(11) NOT NULL,
  `duration` varchar(8) NOT NULL,
  `path` varchar(500) NOT NULL,
  `albumOrder` int(11) NOT NULL,
  `plays` int(11) NOT NULL
) ENGINE=InnoDB  DEFAULT CHARSET=latin1 AUTO_INCREMENT=32 ;

--
-- Dumping data for table `Songs`
--

INSERT INTO `Songs` (`id`, `title`, `artist`, `album`, `genre`, `duration`, `path`, `albumOrder`, `plays`) VALUES
(1, 'Shape Of You', 1, 1, 2, '3:53', 'assets/music/Shape-Of-You.mp3', 1, 0),
(2, 'Galway Girl', 1, 1, 2, '2:50', 'assets/music/Galway-Girl.mp3', 2, 0),
(3, 'Closer', 3, 6, 4, '3:57', 'assets/music/Closer.mp3', 1, 0),
(4, 'Something Just Like This', 2, 7, 4, '4:07', 'assets/music/Something-Just-Like-This.mp3', 1, 0),
(5, 'Paradise', 2, 3, 2, '4:20', 'assets/music/paradise.mp3', 1, 0),
(6, 'Updown Funk', 11, 4, 11, '4:30', 'assets/music/Uptown-Funk.mp3', 1, 0),
(7, '24K Magic', 11, 5, 11, '3:46', 'assets/music/24K-Magic.mp3', 1, 0),
(8, 'Alone', 7, 2, 4, '2:43', 'assets/music/alone.mp3', 1, 0),
(9, 'Faded', 7, 2, 4, '3:32', 'assets/music/Faded.mp3', 2, 0),
(10, 'Despacito', 10, 8, 9, '3:48', 'assets/music/Despacito.mp3', 1, 0),
(11, 'Let Me Love You', 4, 9, 2, '3:24', 'assets/music/Let-Me-Love-You.mp3', 1, 0),
(12, 'Billy Jean', 9, 11, 7, '4:52', 'assets/music/Billy-Jean.mp3', 1, 0),
(13, 'Smooth Criminal', 9, 11, 7, '4:16', 'assets/music/Smooth-Criminal.mp3', 2, 0),
(14, 'Dangerous', 9, 11, 7, '7:01', 'assets/music/Dangerous.mp3', 3, 0),
(15, 'Believer', 8, 10, 11, '3:23', 'assets/music/Believer.mp3', 1, 0),
(16, 'In My Feelings', 5, 12, 3, '3:37', 'assets/music/In-My-Feelings.mp3', 1, 0),
(17, 'MockingBird', 6, 13, 5, '4:14', 'assets/music/Mockingbird.mp3', 1, 0),


-- (18, 'Moose', 4, 7, 1, '2:43', 'assets/music/bensound-moose.mp3', 5, 0),
-- (19, 'November', 4, 7, 2, '3:32', 'assets/music/bensound-november.mp3', 4, 0),
-- (20, 'Of Elias Dream', 4, 7, 3, '4:58', 'assets/music/bensound-ofeliasdream.mp3', 3, 0),
-- (21, 'Pop Dance', 4, 7, 2, '2:42', 'assets/music/bensound-popdance.mp3', 2, 0),
-- (22, 'Retro Soul', 4, 7, 5, '3:36', 'assets/music/bensound-retrosoul.mp3', 1, 0),
-- (23, 'Sad Day', 5, 2, 1, '2:28', 'assets/music/bensound-sadday.mp3', 1, 0),
-- (24, 'Sci-fi', 5, 2, 2, '4:44', 'assets/music/bensound-scifi.mp3', 2, 0),
-- (25, 'Slow Motion', 5, 2, 3, '3:26', 'assets/music/bensound-slowmotion.mp3', 3, 0),
-- (26, 'Sunny', 5, 2, 4, '2:20', 'assets/music/bensound-sunny.mp3', 4, 0),
-- (27, 'Sweet', 5, 2, 5, '5:07', 'assets/music/bensound-sweet.mp3', 5, 0),
-- (28, 'Tenderness ', 3, 3, 7, '2:03', 'assets/music/bensound-tenderness.mp3', 4, 0),
-- (29, 'The Lounge', 3, 3, 8, '4:16', 'assets/music/bensound-thelounge.mp3 ', 3, 0),
-- (30, 'Ukulele', 3, 3, 9, '2:26', 'assets/music/bensound-ukulele.mp3 ', 2, 0),
-- (31, 'Tomorrow', 3, 3, 1, '4:54', 'assets/music/bensound-tomorrow.mp3 ', 1, 0);

--
-- Indexes for dumped tables
--

--
-- Indexes for table `Songs`
--
ALTER TABLE `Songs`
 ADD PRIMARY KEY (`id`);

--
-- AUTO_INCREMENT for dumped tables
--

--
-- AUTO_INCREMENT for table `Songs`
--
ALTER TABLE `Songs`
MODIFY `id` int(11) NOT NULL AUTO_INCREMENT,AUTO_INCREMENT=32;
/*!40101 SET CHARACTER_SET_CLIENT=@OLD_CHARACTER_SET_CLIENT */;
/*!40101 SET CHARACTER_SET_RESULTS=@OLD_CHARACTER_SET_RESULTS */;
/*!40101 SET COLLATION_CONNECTION=@OLD_COLLATION_CONNECTION */;
