-- phpMyAdmin SQL Dump
-- version 3.3.10deb1
-- http://www.phpmyadmin.net
--
-- Host: localhost
-- Generation Time: May 26, 2011 at 12:03 AM
-- Server version: 5.1.54
-- PHP Version: 5.3.5-1ubuntu7.2

SET SQL_MODE="NO_AUTO_VALUE_ON_ZERO";


/*!40101 SET @OLD_CHARACTER_SET_CLIENT=@@CHARACTER_SET_CLIENT */;
/*!40101 SET @OLD_CHARACTER_SET_RESULTS=@@CHARACTER_SET_RESULTS */;
/*!40101 SET @OLD_COLLATION_CONNECTION=@@COLLATION_CONNECTION */;
/*!40101 SET NAMES utf8 */;

--
-- Database: `DemoDatabase`
--

-- --------------------------------------------------------

--
-- Table structure for table `dc_blocked`
--

CREATE TABLE IF NOT EXISTS `dc_blocked` (
  `user_id` int(10) NOT NULL,
  `users_blocked` text NOT NULL,
  PRIMARY KEY (`user_id`)
) ENGINE=MyISAM DEFAULT CHARSET=utf8;

--
-- Dumping data for table `dc_blocked`
--

INSERT INTO `dc_blocked` (`user_id`, `users_blocked`) VALUES
(1, ''),
(3, '');

-- --------------------------------------------------------

--
-- Table structure for table `dc_messages`
--

CREATE TABLE IF NOT EXISTS `dc_messages` (
  `message_id` int(10) NOT NULL AUTO_INCREMENT,
  `user_id` int(10) NOT NULL,
  `user_ip` varchar(255) NOT NULL,
  `message_time` varchar(255) NOT NULL,
  `message` text NOT NULL,
  PRIMARY KEY (`message_id`)
) ENGINE=MyISAM  DEFAULT CHARSET=utf8 AUTO_INCREMENT=30 ;

--
-- Dumping data for table `dc_messages`
--

INSERT INTO `dc_messages` (`message_id`, `user_id`, `user_ip`, `message_time`, `message`) VALUES
(1, 1, '127.0.0.1', '22:52:49', 'Hello people, this is my new chat. :)'),
(2, 2, '127.0.0.1', '22:53:47', 'Woah, it looks really nice. Did you make it?'),
(3, 1, '127.0.0.1', '22:54:06', 'Indeed I have.'),
(4, 3, '127.0.0.1', '22:55:36', 'Well this will be kinda interesting. ^_^'),
(5, 4, '127.0.0.1', '22:56:50', 'Is it vulnerable to hack attacks? ]:)'),
(6, 1, '127.0.0.1', '22:56:59', 'Well, I hope not.'),
(7, 4, '127.0.0.1', '22:57:36', 'Okay, lets do a test.'),
(8, 1, '127.0.0.1', '22:57:44', 'Please...'),
(9, 4, '127.0.0.1', '22:58:08', '<script>alert("nasty javascript");</script>'),
(10, 1, '127.0.0.1', '22:58:20', 'Nothing! :)'),
(11, 4, '127.0.0.1', '22:58:27', 'Cool stuff.'),
(12, 2, '127.0.0.1', '22:58:46', 'I feel safe. XD'),
(13, 3, '127.0.0.1', '22:59:16', 'Ahahahaha...'),
(14, 5, '127.0.0.1', '23:00:39', 'Okay, Novak just kicked my ass.'),
(15, 3, '127.0.0.1', '23:02:07', 'Good for him... Hopefully He''ll be the first on ATP list soon.'),
(16, 6, '127.0.0.1', '23:03:03', 'What the hell are you two talking about? Who in the bloody world is Novak?'),
(17, 7, '127.0.0.1', '23:03:56', 'Is that some sort of icecream?'),
(18, 8, '127.0.0.1', '23:05:32', 'Nah... I think its an old Scandinavian alchohol drink. Who knows.'),
(19, 1, '127.0.0.1', '23:05:46', 'All is great.'),
(20, 8, '127.0.0.1', '23:06:04', 'Yup this chat of yours is working perfectly. Great job.'),
(21, 7, '127.0.0.1', '23:07:38', 'Check this out... http://www.youtube.com/watch?v=g3sJB2tcoJY'),
(22, 9, '127.0.0.1', '23:08:53', 'Bahahahaha...'),
(23, 10, '127.0.0.1', '23:12:39', 'I''m the first banned user... Yea...'),
(24, 1, '127.0.0.1', '23:14:24', 'Indeed you are.'),
(25, 1, '127.0.0.1', '23:54:49', ' So yeah...'),
(26, 1, '127.0.0.1', '23:55:11', 'Spam... For testing...'),
(27, 1, '127.0.0.1', '23:55:36', 'Everything is fine... ^^'),
(28, 2, '127.0.0.1', '23:57:40', 'Great... But what about... \\n, \\b'),
(29, 2, '127.0.0.1', '23:57:48', 'Oooo... Great coding.');

-- --------------------------------------------------------

--
-- Table structure for table `dc_users`
--

CREATE TABLE IF NOT EXISTS `dc_users` (
  `id` int(10) NOT NULL AUTO_INCREMENT,
  `username` varchar(20) NOT NULL,
  `password` varchar(40) NOT NULL,
  `privilegies` int(1) NOT NULL,
  `status` tinyint(1) NOT NULL DEFAULT '1',
  PRIMARY KEY (`id`)
) ENGINE=MyISAM  DEFAULT CHARSET=utf8 AUTO_INCREMENT=11 ;

--
-- Dumping data for table `dc_users`
--

INSERT INTO `dc_users` (`id`, `username`, `password`, `privilegies`, `status`) VALUES
(1, 'Administrator', '495ca9f792d9f204e4c6d590dddaf5a6d77669a9', 1, 1),
(2, 'AnaKarenjina', 'bab78c1ffe10fa16420bcfdbc8960e38a2f6c4c2', 0, 1),
(3, 'PinkPanter', 'e79645077b41fc01593f61a69c24e17884f1a61f', 0, 1),
(4, 'ProHacker', '086bb649575db7ba673810bbfad9a3aeecbec113', 0, 1),
(5, 'RafalNaNadala', '8dc0a33f8288e649ff8195683848c7c5d78939ed', 0, 1),
(6, 'Wellness', '1644d71a678054a6434465a429ebaa7ff3eadafc', 0, 1),
(7, 'Sunshine', '8d6e34f987851aa599257d3831a1af040886842f', 0, 1),
(8, 'frea34fd', 'c99b0a8f9982421b21530c921cbfa8a967470004', 0, 1),
(9, 'KendyTop', '528c686c18ad5ce4dcabd501385978b81624c884', 0, 1),
(10, 'BannedUser', '799fd02e2009ba0245dbf22761ac92e5048a738b', 0, 0);
