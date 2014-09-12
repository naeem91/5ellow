-- phpMyAdmin SQL Dump
-- version 3.2.4
-- http://www.phpmyadmin.net
--
-- Host: localhost
-- Generation Time: Nov 19, 2012 at 01:50 PM
-- Server version: 5.1.41
-- PHP Version: 5.3.1

SET SQL_MODE="NO_AUTO_VALUE_ON_ZERO";


/*!40101 SET @OLD_CHARACTER_SET_CLIENT=@@CHARACTER_SET_CLIENT */;
/*!40101 SET @OLD_CHARACTER_SET_RESULTS=@@CHARACTER_SET_RESULTS */;
/*!40101 SET @OLD_COLLATION_CONNECTION=@@COLLATION_CONNECTION */;
/*!40101 SET NAMES utf8 */;

--
-- Database: `studenttribe`
--

-- --------------------------------------------------------

--
-- Table structure for table `admin`
--

CREATE TABLE IF NOT EXISTS `admin` (
  `admin_id` int(11) NOT NULL AUTO_INCREMENT,
  `user_id` int(11) NOT NULL,
  `super_admin` tinyint(1) NOT NULL,
  `date_created` timestamp NOT NULL DEFAULT CURRENT_TIMESTAMP ON UPDATE CURRENT_TIMESTAMP,
  PRIMARY KEY (`admin_id`)
) ENGINE=MyISAM  DEFAULT CHARSET=latin1 AUTO_INCREMENT=10 ;

--
-- Dumping data for table `admin`
--

INSERT INTO `admin` (`admin_id`, `user_id`, `super_admin`, `date_created`) VALUES
(1, 13, 1, '2012-10-18 16:00:08');

-- --------------------------------------------------------

--
-- Table structure for table `chat`
--

CREATE TABLE IF NOT EXISTS `chat` (
  `id` int(10) unsigned NOT NULL AUTO_INCREMENT,
  `from` varchar(255) NOT NULL DEFAULT '',
  `to` varchar(255) NOT NULL DEFAULT '',
  `message` text NOT NULL,
  `sent` datetime NOT NULL DEFAULT '0000-00-00 00:00:00',
  `recd` int(10) unsigned NOT NULL DEFAULT '0',
  PRIMARY KEY (`id`)
) ENGINE=InnoDB  DEFAULT CHARSET=latin1 AUTO_INCREMENT=120 ;

--
-- Dumping data for table `chat`
--

INSERT INTO `chat` (`id`, `from`, `to`, `message`, `sent`, `recd`) VALUES
(111, '', '10661719', 'Salam', '2012-11-18 23:18:09', 1),
(112, '10661719', '10661713', 'hi', '2012-11-19 11:32:54', 1),
(113, '10661713', '10661719', 'jee janab', '2012-11-19 11:33:10', 1),
(114, 'wasi', '10661713', 'jjjjjjjjjjjjjjjjjjjjjjjjjjjjjjjjjjjjjjjjjjjjjjjjjjjjjjjjjjjjjjjjjjjjjjjjjjjjjjjjjjjjjjjjjjjjjjjjjjjjjjjjjjjjjjjjjjjj', '2012-11-19 12:02:11', 1),
(115, 'wasi', '10661713', 'ffffffffffffkkkyhhhhhhhhhhhhhhhhhhhhhy', '2012-11-19 12:02:22', 1),
(116, '10661713', 'wasi', 'aaaaaaaaaaaaaaaaaaaaaa', '2012-11-19 12:02:39', 1),
(117, 'wasi', '10661713', 'salam', '2012-11-19 13:07:16', 1),
(118, '10661713', 'wasi', 'wa salam', '2012-11-19 13:07:40', 1),
(119, '10661713', 'wasi', 'gggg', '2012-11-19 13:08:16', 1);

-- --------------------------------------------------------

--
-- Table structure for table `comment`
--

CREATE TABLE IF NOT EXISTS `comment` (
  `comment_id` int(11) NOT NULL AUTO_INCREMENT,
  `comment_text` text NOT NULL,
  `commenter` int(11) NOT NULL,
  `post_id` int(11) NOT NULL,
  `comment_time` timestamp NOT NULL DEFAULT CURRENT_TIMESTAMP ON UPDATE CURRENT_TIMESTAMP,
  PRIMARY KEY (`comment_id`)
) ENGINE=MyISAM  DEFAULT CHARSET=latin1 AUTO_INCREMENT=333 ;

--
-- Dumping data for table `comment`
--

INSERT INTO `comment` (`comment_id`, `comment_text`, `commenter`, `post_id`, `comment_time`) VALUES
(332, 'achee haii\n', 13, 461, '2012-11-19 13:47:29'),
(331, 'nice one\n', 13, 461, '2012-11-19 13:36:12'),
(330, '10\n', 22, 458, '2012-11-19 13:31:55'),
(329, '9\n', 22, 458, '2012-11-19 13:31:52'),
(328, '8\n', 22, 458, '2012-11-19 13:31:50'),
(327, '7\n', 22, 458, '2012-11-19 13:31:46'),
(326, '6\n', 22, 458, '2012-11-19 13:31:45'),
(325, '5\n', 22, 458, '2012-11-19 13:31:40'),
(324, '4\n', 22, 458, '2012-11-19 13:31:39'),
(322, '2\n', 13, 458, '2012-11-19 13:31:25'),
(323, '3\n', 22, 458, '2012-11-19 13:31:36'),
(320, 'hmmm\n', 13, 458, '2012-11-19 13:31:18'),
(321, '1\n', 13, 458, '2012-11-19 13:31:22'),
(318, 'nice one\n', 21, 457, '2012-11-19 13:24:38'),
(319, 'nice scene\n', 21, 458, '2012-11-19 13:27:10'),
(317, 'use google :p\n', 21, 456, '2012-11-19 13:22:34'),
(316, 'How to use arrays\n', 13, 456, '2012-11-19 13:22:24'),
(315, 'Tell me I can solve. Elaborate your problem please\n', 21, 456, '2012-11-19 13:21:09'),
(314, 'Good one\n', 13, 454, '2012-11-19 13:13:10'),
(313, 'kkkkkkjkjkjkjkjkjkjkjkjkjkjkjkkjkkjkjkjkjkjkjkjkjk\n', 13, 453, '2012-11-19 12:22:50'),
(312, 'good\n', 19, 446, '2012-11-19 11:24:41'),
(311, 'fineeee\n', 13, 445, '2012-11-19 11:17:52');

-- --------------------------------------------------------

--
-- Table structure for table `education_profile`
--

CREATE TABLE IF NOT EXISTS `education_profile` (
  `edu_id` int(11) NOT NULL AUTO_INCREMENT,
  `profile_id` int(11) NOT NULL,
  `institute_name` varchar(255) NOT NULL,
  `institute_type` varchar(255) NOT NULL,
  `attended_for` varchar(255) NOT NULL,
  `completion_year` year(4) DEFAULT NULL,
  PRIMARY KEY (`edu_id`)
) ENGINE=MyISAM  DEFAULT CHARSET=latin1 AUTO_INCREMENT=113 ;

--
-- Dumping data for table `education_profile`
--

INSERT INTO `education_profile` (`edu_id`, `profile_id`, `institute_name`, `institute_type`, `attended_for`, `completion_year`) VALUES
(109, 49, 'UOG', '', 'BS-CS', 2012),
(110, 43, 'UOG GRT', '', 'BS-CS', 2012),
(111, 52, 'Govt. hight school', '', 'Matric', 2006),
(112, 52, 'UOG', '', 'BS-CS', 2012);

-- --------------------------------------------------------

--
-- Table structure for table `fellows`
--

CREATE TABLE IF NOT EXISTS `fellows` (
  `fellow_id` int(11) NOT NULL AUTO_INCREMENT,
  `user_id` int(11) NOT NULL,
  `fellower_id` int(11) NOT NULL,
  PRIMARY KEY (`fellow_id`)
) ENGINE=MyISAM  DEFAULT CHARSET=latin1 AUTO_INCREMENT=22 ;

--
-- Dumping data for table `fellows`
--

INSERT INTO `fellows` (`fellow_id`, `user_id`, `fellower_id`) VALUES
(21, 22, 13),
(20, 13, 19);

-- --------------------------------------------------------

--
-- Table structure for table `file`
--

CREATE TABLE IF NOT EXISTS `file` (
  `file_id` int(11) NOT NULL AUTO_INCREMENT,
  `user_id` int(11) NOT NULL,
  `file_name` varchar(255) NOT NULL,
  `uploaded_in` int(11) NOT NULL,
  `uploaded_time` timestamp NOT NULL DEFAULT CURRENT_TIMESTAMP ON UPDATE CURRENT_TIMESTAMP,
  PRIMARY KEY (`file_id`)
) ENGINE=MyISAM  DEFAULT CHARSET=latin1 AUTO_INCREMENT=32 ;

--
-- Dumping data for table `file`
--

INSERT INTO `file` (`file_id`, `user_id`, `file_name`, `uploaded_in`, `uploaded_time`) VALUES
(31, 13, 'AngelInside.pdf', 0, '2012-11-19 13:30:40'),
(29, 19, 'new links.txt', 0, '2012-11-19 11:29:15'),
(30, 19, 'Windows_Developer_Preview-Windows8_guide.pdf', 20, '2012-11-19 13:11:14');

-- --------------------------------------------------------

--
-- Table structure for table `group`
--

CREATE TABLE IF NOT EXISTS `group` (
  `group_id` int(11) NOT NULL AUTO_INCREMENT,
  `group_name` varchar(255) NOT NULL,
  `group_display_name` varchar(255) NOT NULL,
  `group_description` text NOT NULL,
  `group_cover` int(11) NOT NULL,
  `group_creator` int(11) NOT NULL,
  `date_created` timestamp NOT NULL DEFAULT CURRENT_TIMESTAMP ON UPDATE CURRENT_TIMESTAMP,
  PRIMARY KEY (`group_id`)
) ENGINE=MyISAM  DEFAULT CHARSET=latin1 AUTO_INCREMENT=24 ;

--
-- Dumping data for table `group`
--

INSERT INTO `group` (`group_id`, `group_name`, `group_display_name`, `group_description`, `group_cover`, `group_creator`, `date_created`) VALUES
(23, 'phpiams', 'PHP coders', 'group for phpians', 301, 21, '2012-11-19 13:20:30'),
(21, 'design', 'Designers', 'Group for designers', 297, 13, '2012-11-19 13:14:11'),
(22, 'csit', 'CSIT', 'Group for CS and IT', 299, 20, '2012-11-19 13:17:52'),
(19, 'coders', 'Programmers ', '', 291, 13, '2012-11-19 11:26:54'),
(20, 'net', '.NET dev', 'Group for .NET developers', 295, 19, '2012-11-19 13:10:29');

-- --------------------------------------------------------

--
-- Table structure for table `group_members`
--

CREATE TABLE IF NOT EXISTS `group_members` (
  `membership_id` int(11) NOT NULL AUTO_INCREMENT,
  `group_id` int(11) NOT NULL,
  `user_id` int(11) NOT NULL,
  `join_date` timestamp NOT NULL DEFAULT CURRENT_TIMESTAMP ON UPDATE CURRENT_TIMESTAMP,
  PRIMARY KEY (`membership_id`)
) ENGINE=MyISAM  DEFAULT CHARSET=latin1 AUTO_INCREMENT=47 ;

--
-- Dumping data for table `group_members`
--

INSERT INTO `group_members` (`membership_id`, `group_id`, `user_id`, `join_date`) VALUES
(46, 23, 21, '2012-11-19 13:20:30'),
(45, 22, 20, '2012-11-19 13:17:52'),
(44, 20, 20, '2012-11-19 13:16:59'),
(43, 21, 19, '2012-11-19 13:14:34'),
(42, 21, 13, '2012-11-19 13:14:11'),
(41, 20, 19, '2012-11-19 13:10:29'),
(40, 19, 19, '2012-11-19 11:33:42'),
(39, 19, 13, '2012-11-19 11:26:54');

-- --------------------------------------------------------

--
-- Table structure for table `like`
--

CREATE TABLE IF NOT EXISTS `like` (
  `like_id` int(11) NOT NULL AUTO_INCREMENT,
  `post_id` int(11) NOT NULL,
  `liker` int(11) NOT NULL,
  PRIMARY KEY (`like_id`)
) ENGINE=MyISAM  DEFAULT CHARSET=latin1 AUTO_INCREMENT=53 ;

--
-- Dumping data for table `like`
--

INSERT INTO `like` (`like_id`, `post_id`, `liker`) VALUES
(52, 459, 13),
(51, 458, 13),
(50, 458, 21),
(49, 457, 21),
(48, 454, 13),
(47, 452, 13),
(46, 452, 19),
(45, 446, 13),
(44, 445, 13),
(41, 443, 13),
(42, 442, 13),
(43, 441, 13);

-- --------------------------------------------------------

--
-- Table structure for table `link`
--

CREATE TABLE IF NOT EXISTS `link` (
  `link_id` int(11) NOT NULL AUTO_INCREMENT,
  `link_link` tinytext NOT NULL,
  PRIMARY KEY (`link_id`)
) ENGINE=MyISAM  DEFAULT CHARSET=latin1 AUTO_INCREMENT=20 ;

--
-- Dumping data for table `link`
--

INSERT INTO `link` (`link_id`, `link_link`) VALUES
(1, '0'),
(2, '0'),
(3, '0'),
(4, 'http://www.com'),
(5, 'http://www.csuog.com'),
(6, 'http://www.yahoo.com'),
(7, 'http://www.facebook.com'),
(8, 'http://www.5ellow.csuog.com '),
(9, 'www.facebook.com'),
(10, 'http://www.facebook.com'),
(11, 'http://www.csuog.com'),
(12, 'http://www.yahoo.com'),
(13, 'http://www.facebook.com'),
(14, 'http://www.techviral.com'),
(15, 'http://www.bbc.co.uk'),
(16, 'http://www.wordpress.com'),
(17, 'http://www.twitter.com'),
(18, 'http://www.stackoverflow.com'),
(19, 'http://www.bbc.co.uk');

-- --------------------------------------------------------

--
-- Table structure for table `message`
--

CREATE TABLE IF NOT EXISTS `message` (
  `msg_id` int(11) NOT NULL AUTO_INCREMENT,
  `msg_sender` int(11) NOT NULL,
  `msg_receiver` int(11) NOT NULL,
  `msg_text` text NOT NULL,
  `msg_read` tinyint(1) NOT NULL,
  `msg_reply` int(11) NOT NULL,
  `msg_time` timestamp NOT NULL DEFAULT CURRENT_TIMESTAMP ON UPDATE CURRENT_TIMESTAMP,
  PRIMARY KEY (`msg_id`)
) ENGINE=MyISAM  DEFAULT CHARSET=latin1 AUTO_INCREMENT=141 ;

--
-- Dumping data for table `message`
--

INSERT INTO `message` (`msg_id`, `msg_sender`, `msg_receiver`, `msg_text`, `msg_read`, `msg_reply`, `msg_time`) VALUES
(140, 19, 13, 'gggggg', 1, 0, '2012-11-19 11:41:19'),
(139, 13, 19, 'kuch nhee\n', 1, 138, '2012-11-19 11:43:46'),
(138, 19, 13, 'kaya ho reha ha', 1, 0, '2012-11-19 11:41:19');

-- --------------------------------------------------------

--
-- Table structure for table `notification`
--

CREATE TABLE IF NOT EXISTS `notification` (
  `id` int(11) NOT NULL AUTO_INCREMENT,
  `type` varchar(255) NOT NULL,
  `sender` int(11) NOT NULL,
  `receiver` int(11) NOT NULL,
  `post` text NOT NULL,
  `read` tinyint(1) NOT NULL,
  `time` varchar(255) NOT NULL,
  PRIMARY KEY (`id`)
) ENGINE=MyISAM  DEFAULT CHARSET=latin1 AUTO_INCREMENT=97 ;

--
-- Dumping data for table `notification`
--

INSERT INTO `notification` (`id`, `type`, `sender`, `receiver`, `post`, `read`, `time`) VALUES
(96, 'comment', 13, 22, '461', 1, '2012-11-19 13:36:12');

-- --------------------------------------------------------

--
-- Table structure for table `photo`
--

CREATE TABLE IF NOT EXISTS `photo` (
  `photo_id` int(11) NOT NULL AUTO_INCREMENT,
  `user_id` int(11) NOT NULL,
  `photo_name` varchar(255) NOT NULL,
  `uploaded_in` int(11) NOT NULL,
  `uploaded_date` timestamp NOT NULL DEFAULT CURRENT_TIMESTAMP ON UPDATE CURRENT_TIMESTAMP,
  PRIMARY KEY (`photo_id`)
) ENGINE=MyISAM  DEFAULT CHARSET=latin1 AUTO_INCREMENT=306 ;

--
-- Dumping data for table `photo`
--

INSERT INTO `photo` (`photo_id`, `user_id`, `photo_name`, `uploaded_in`, `uploaded_date`) VALUES
(293, 19, '70656_100003612812315_1003489323_n.jpg', 0, '2012-11-19 11:29:58'),
(305, 22, 'monster.png', 0, '2012-11-19 13:37:35'),
(304, 22, 'UOGdesign1.png', 0, '2012-11-19 13:35:58'),
(302, 13, '800px-Flamingos_Laguna_Colorada1.jpg', 0, '2012-11-19 13:26:38'),
(300, 21, 'default.jpg', 0, '2012-11-19 13:18:31'),
(299, 20, 'group_default.jpg', 0, '2012-11-19 13:17:52'),
(298, 20, 'default.jpg', 0, '2012-11-19 13:15:07'),
(297, 13, 'group_default.jpg', 0, '2012-11-19 13:14:11'),
(296, 19, 'business-card2.jpg', 0, '2012-11-19 13:12:05'),
(295, 19, 'logo-design_band-of-coders.jpg', 0, '2012-11-19 13:10:29'),
(294, 13, 'group_default.jpg', 0, '2012-11-19 12:14:32'),
(292, 19, '931_28067494_medium.jpg', 0, '2012-11-19 11:29:34'),
(285, 16, 'group_default.jpg', 0, '2012-11-17 22:20:01'),
(286, 16, '1098_static1.jpg', 0, '2012-11-17 22:20:52'),
(289, 13, 'area1-300x132.jpg', 0, '2012-11-18 17:02:44'),
(290, 19, 'default.jpg', 0, '2012-11-19 11:19:45'),
(283, 18, 'default.jpg', 0, '2012-11-17 17:45:26'),
(284, 16, 'group_default.jpg', 0, '2012-11-17 22:19:30'),
(282, 17, 'default.jpg', 0, '2012-11-17 17:39:21'),
(279, 12, 'mag.jpg', 0, '2012-11-06 21:07:44'),
(277, 14, 'code.png', 0, '2012-11-06 21:06:11'),
(278, 10, 'book2.png', 0, '2012-11-06 21:06:54'),
(276, 14, 'twitter.png', 0, '2012-11-06 21:04:30'),
(275, 13, 'Computer-Science.jpg', 0, '2012-11-06 20:59:42'),
(274, 13, 'logo-design_band-of-coders.jpg', 0, '2012-11-06 20:48:20'),
(291, 13, 'Computer-Science.jpg', 0, '2012-11-19 11:26:54'),
(272, 13, '70656_100003612812315_1003489323_n.jpg', 0, '2012-11-06 20:40:29'),
(280, 10, '800px-Flamingos_Laguna_Colorada.jpg', 0, '2012-11-14 10:51:55'),
(281, 16, 'default.jpg', 0, '2012-11-17 17:34:06'),
(287, 13, '800px-Flamingos_Laguna_Colorada.jpg', 0, '2012-11-18 16:17:58'),
(267, 10, 'cl3.jpg', 0, '2012-11-06 13:10:55'),
(266, 13, '70656_100003612812315_1003489323_n.jpg', 0, '2012-11-06 13:02:11');

-- --------------------------------------------------------

--
-- Table structure for table `post`
--

CREATE TABLE IF NOT EXISTS `post` (
  `post_id` int(11) NOT NULL AUTO_INCREMENT,
  `post_text` text NOT NULL,
  `poster` int(11) NOT NULL,
  `attachment_type` varchar(255) NOT NULL,
  `attachment_id` int(11) NOT NULL,
  `posted_in` int(11) NOT NULL,
  `posted_on` int(11) NOT NULL,
  `post_time` timestamp NOT NULL DEFAULT CURRENT_TIMESTAMP ON UPDATE CURRENT_TIMESTAMP,
  PRIMARY KEY (`post_id`)
) ENGINE=MyISAM  DEFAULT CHARSET=latin1 AUTO_INCREMENT=462 ;

--
-- Dumping data for table `post`
--

INSERT INTO `post` (`post_id`, `post_text`, `poster`, `attachment_type`, `attachment_id`, `posted_in`, `posted_on`, `post_time`) VALUES
(461, 'I made this design', 22, 'photo', 304, 0, 0, '2012-11-19 13:35:58'),
(460, 'a test post 1', 13, '', 0, 0, 0, '2012-11-19 13:35:17'),
(459, 'post with a file attachment', 13, 'file', 31, 0, 0, '2012-11-19 13:30:40'),
(458, 'post with a photo attachment', 13, 'photo', 302, 0, 0, '2012-11-19 13:26:38'),
(457, 'check out this video', 13, 'video', 27, 0, 0, '2012-11-19 13:24:11'),
(456, 'I have a problem in my code. someone help me please', 20, '', 0, 20, 0, '2012-11-19 13:17:15'),
(455, 'This is my new graphics', 19, 'photo', 296, 0, 0, '2012-11-19 13:12:05'),
(454, 'Hi check out Windows 8 overview', 19, 'file', 30, 20, 0, '2012-11-19 13:11:14'),
(452, 'hi coders', 19, '', 0, 19, 0, '2012-11-19 11:34:08'),
(451, 'jkkjk', 19, 'photo', 293, 0, 0, '2012-11-19 11:29:58'),
(450, 'kjkj', 19, 'photo', 292, 0, 0, '2012-11-19 11:29:34'),
(447, 'whats up', 19, '', 0, 0, 0, '2012-11-19 11:28:10'),
(449, 'klkl', 19, 'file', 29, 0, 0, '2012-11-19 11:29:15'),
(446, 'new post', 13, '', 0, 0, 0, '2012-11-19 11:17:08'),
(445, 'hi every one how are u\r\n', 13, '', 0, 0, 0, '2012-11-19 11:15:52');

-- --------------------------------------------------------

--
-- Table structure for table `profile`
--

CREATE TABLE IF NOT EXISTS `profile` (
  `profile_id` int(11) NOT NULL AUTO_INCREMENT,
  `user_id` int(11) NOT NULL,
  `display_name` varchar(255) NOT NULL,
  `dob` varchar(255) NOT NULL,
  `gender` varchar(6) NOT NULL,
  `photo` int(11) NOT NULL,
  `about_me` text NOT NULL,
  `last_active_time` varchar(255) NOT NULL,
  PRIMARY KEY (`profile_id`)
) ENGINE=MyISAM  DEFAULT CHARSET=latin1 AUTO_INCREMENT=53 ;

--
-- Dumping data for table `profile`
--

INSERT INTO `profile` (`profile_id`, `user_id`, `display_name`, `dob`, `gender`, `photo`, `about_me`, `last_active_time`) VALUES
(52, 22, 'Baba Jee', '1985-11-03', 'male', 305, 'I am a student of cs', '1353314685'),
(43, 13, 'Naeem', '1991-01-01', 'male', 272, 'I am a admin', '1353315028'),
(51, 21, 'M Ishtiaq', '', '', 300, '', '1353313700'),
(50, 20, 'Zafar', '', '', 298, '', '1353313108'),
(49, 19, 'waseem', '1992-11-04', 'male', 290, 'I am a teacher', '1353312913');

-- --------------------------------------------------------

--
-- Table structure for table `service_status`
--

CREATE TABLE IF NOT EXISTS `service_status` (
  `service_name` varchar(255) NOT NULL,
  `service_status` tinyint(1) NOT NULL
) ENGINE=MyISAM DEFAULT CHARSET=latin1;

--
-- Dumping data for table `service_status`
--

INSERT INTO `service_status` (`service_name`, `service_status`) VALUES
('registration', 1),
('uploading', 1);

-- --------------------------------------------------------

--
-- Table structure for table `user`
--

CREATE TABLE IF NOT EXISTS `user` (
  `user_id` int(11) NOT NULL AUTO_INCREMENT,
  `user_name` varchar(255) NOT NULL,
  `user_email` varchar(255) NOT NULL,
  `user_pass` varchar(255) NOT NULL,
  `active` varchar(255) NOT NULL,
  `banned` tinyint(1) NOT NULL,
  `date_registered` timestamp NOT NULL DEFAULT CURRENT_TIMESTAMP ON UPDATE CURRENT_TIMESTAMP,
  PRIMARY KEY (`user_id`)
) ENGINE=MyISAM  DEFAULT CHARSET=latin1 AUTO_INCREMENT=23 ;

--
-- Dumping data for table `user`
--

INSERT INTO `user` (`user_id`, `user_name`, `user_email`, `user_pass`, `active`, `banned`, `date_registered`) VALUES
(21, '10661721', 'ishtiaq@ishtiaq.com', '04afbdd7de3c5034e391bb358293f722b552d055', '1', 0, '2012-11-19 13:18:47'),
(22, 'umar', 'babag@yahoo.com', '04afbdd7de3c5034e391bb358293f722b552d055', '1', 0, '2012-11-19 13:37:33'),
(13, '10661713', 'naeem-ilyas@live.com', '04afbdd7de3c5034e391bb358293f722b552d055', '1', 0, '2012-10-18 15:28:12'),
(20, '10661720', 'zafar@zafar.com', '04afbdd7de3c5034e391bb358293f722b552d055', '1', 0, '2012-11-19 13:15:22'),
(19, 'wasi', 'waseemcheema2010@gmail.com', '77b37548fa1c3a1e4eb26c7efe4ebebacd3ef2ad', '1', 0, '2012-11-19 13:05:13');

-- --------------------------------------------------------

--
-- Table structure for table `video`
--

CREATE TABLE IF NOT EXISTS `video` (
  `video_id` int(11) NOT NULL AUTO_INCREMENT,
  `user_id` int(11) NOT NULL,
  `video_link` varchar(255) NOT NULL,
  `uploaded_in` int(11) NOT NULL,
  `uploaded_time` timestamp NOT NULL DEFAULT CURRENT_TIMESTAMP ON UPDATE CURRENT_TIMESTAMP,
  PRIMARY KEY (`video_id`)
) ENGINE=MyISAM  DEFAULT CHARSET=latin1 AUTO_INCREMENT=28 ;

--
-- Dumping data for table `video`
--

INSERT INTO `video` (`video_id`, `user_id`, `video_link`, `uploaded_in`, `uploaded_time`) VALUES
(13, 13, 'http://vimeo.com/29144891', 0, '2012-10-13 13:18:03'),
(11, 13, 'http://vimeo.com/29144891', 0, '2012-10-13 12:14:28'),
(15, 13, 'http://vimeo.com/51325336', 0, '2012-10-20 11:33:36'),
(20, 13, ' http://vimeo.com/51325336', 0, '2012-11-04 22:40:14'),
(17, 13, ' http://vimeo.com/51325336', 0, '2012-10-20 20:37:29'),
(18, 12, 'http://vimeo.com/51325336', 0, '2012-10-20 20:40:05'),
(19, 12, 'http://vimeo.com/51325336', 0, '2012-10-20 21:02:55'),
(21, 13, 'http://vimeo.com/51325336', 15, '2012-11-05 12:34:32'),
(22, 13, 'http://vimeo.com/51325336', 15, '2012-11-05 12:41:40'),
(26, 13, 'http://vimeo.com/51325336', 0, '2012-11-18 17:45:35'),
(24, 13, 'http://vimeo.com/51325336', 0, '2012-11-15 17:20:40'),
(27, 13, ' http://vimeo.com/51325336', 0, '2012-11-19 13:24:11');

/*!40101 SET CHARACTER_SET_CLIENT=@OLD_CHARACTER_SET_CLIENT */;
/*!40101 SET CHARACTER_SET_RESULTS=@OLD_CHARACTER_SET_RESULTS */;
/*!40101 SET COLLATION_CONNECTION=@OLD_COLLATION_CONNECTION */;
