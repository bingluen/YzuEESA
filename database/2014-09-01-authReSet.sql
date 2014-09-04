-- phpMyAdmin SQL Dump
-- version 4.1.14.3
-- http://www.phpmyadmin.net
--
-- 主機: localhost
-- 產生時間： 2014-09-01: 12:29:58
-- 伺服器版本: 5.6.17
-- PHP 版本： 5.5.12

SET SQL_MODE = "NO_AUTO_VALUE_ON_ZERO";
SET time_zone = "+00:00";


/*!40101 SET @OLD_CHARACTER_SET_CLIENT=@@CHARACTER_SET_CLIENT */;
/*!40101 SET @OLD_CHARACTER_SET_RESULTS=@@CHARACTER_SET_RESULTS */;
/*!40101 SET @OLD_COLLATION_CONNECTION=@@COLLATION_CONNECTION */;
/*!40101 SET NAMES utf8 */;

--
-- 資料庫： `yzueesa`
--

-- --------------------------------------------------------

--
-- 資料表結構 `cf_items`
--

CREATE TABLE IF NOT EXISTS `cf_items` (
  `items_id` int(10) NOT NULL AUTO_INCREMENT,
  `items_project` int(5) NOT NULL,
  `items_outlay` char(1) NOT NULL,
  `items_price` int(10) NOT NULL,
  `items_name` varchar(255) NOT NULL,
  `items_applicant` int(5) NOT NULL,
  `items_status` int(1) NOT NULL DEFAULT '0',
  `items_reviewer` int(5) DEFAULT NULL,
  `items_app_time` timestamp NOT NULL DEFAULT CURRENT_TIMESTAMP,
  `items_rev_time` timestamp NULL DEFAULT NULL,
  PRIMARY KEY (`items_id`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8 AUTO_INCREMENT=1 ;

-- --------------------------------------------------------

--
-- 資料表結構 `cf_project`
--

CREATE TABLE IF NOT EXISTS `cf_project` (
  `project_id` int(10) NOT NULL AUTO_INCREMENT,
  `project_category` int(3) NOT NULL,
  `project_name` varchar(255) NOT NULL,
  `project_status` char(1) NOT NULL DEFAULT 'T',
  `project_host` int(5) NOT NULL,
  `project_member` text,
  `project_time` timestamp NOT NULL DEFAULT CURRENT_TIMESTAMP,
  PRIMARY KEY (`project_id`)
) ENGINE=InnoDB  DEFAULT CHARSET=utf8 AUTO_INCREMENT=2 ;

--
-- 資料表的匯出資料 `cf_project`
--

INSERT INTO `cf_project` (`project_id`, `project_category`, `project_name`, `project_status`, `project_host`, `project_member`, `project_time`) VALUES
(1, 2, '103學年元智電機系學會樂高機器人營', 'T', 1, NULL, '2014-08-22 09:42:32');

-- --------------------------------------------------------

--
-- 資料表結構 `cf_project_category`
--

CREATE TABLE IF NOT EXISTS `cf_project_category` (
  `category_id` int(3) NOT NULL AUTO_INCREMENT,
  `category_name` varchar(25) NOT NULL,
  `category_color` varchar(7) NOT NULL,
  PRIMARY KEY (`category_id`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8 AUTO_INCREMENT=1 ;

-- --------------------------------------------------------

--
-- 資料表結構 `event_list`
--

CREATE TABLE IF NOT EXISTS `event_list` (
  `event_id` int(5) NOT NULL AUTO_INCREMENT,
  `event_name` varchar(250) NOT NULL,
  `event_path` varchar(250) NOT NULL,
  `event_host` int(5) NOT NULL,
  `event_member` text,
  PRIMARY KEY (`event_id`)
) ENGINE=InnoDB  DEFAULT CHARSET=utf8 AUTO_INCREMENT=2 ;

--
-- 資料表的匯出資料 `event_list`
--

INSERT INTO `event_list` (`event_id`, `event_name`, `event_path`, `event_host`, `event_member`) VALUES
(1, '103學年元智電機系學會樂高機器人營', '31bd954c', 1, NULL);

-- --------------------------------------------------------

--
-- 資料表結構 `messages`
--

CREATE TABLE IF NOT EXISTS `messages` (
  `messages_id` int(10) NOT NULL AUTO_INCREMENT,
  `messages_type` tinyint(1) NOT NULL DEFAULT '0',
  `messages_eventid` int(5) NOT NULL,
  `messages_draft` tinyint(1) NOT NULL DEFAULT '0',
  `messages_title` varchar(255) NOT NULL,
  `messages_content` longtext NOT NULL,
  `messages_author` int(5) NOT NULL,
  `messages_time` timestamp NOT NULL DEFAULT CURRENT_TIMESTAMP ON UPDATE CURRENT_TIMESTAMP,
  PRIMARY KEY (`messages_id`)
) ENGINE=InnoDB  DEFAULT CHARSET=utf8 AUTO_INCREMENT=3 ;

--
-- 資料表的匯出資料 `messages`
--

INSERT INTO `messages` (`messages_id`, `messages_type`, `messages_eventid`, `messages_draft`, `messages_title`, `messages_content`, `messages_author`, `messages_time`) VALUES
(2, 1, 1, 0, 'TEst', '&lt;p&gt;TEST&lt;/p&gt;', 1, '2014-08-22 10:48:20');

-- --------------------------------------------------------

--
-- 資料表結構 `worker`
--

CREATE TABLE IF NOT EXISTS `worker` (
  `worker_id` int(5) NOT NULL AUTO_INCREMENT,
  `worker_level` int(3) NOT NULL,
  `worker_name` varchar(255) NOT NULL,
  `worker_username` varchar(255) NOT NULL,
  `worker_password` char(32) NOT NULL,
  `worker_project` text NOT NULL,
  `worker_lastlogin` timestamp NOT NULL DEFAULT CURRENT_TIMESTAMP,
  `worker_lastIP` varchar(50) DEFAULT NULL,
  PRIMARY KEY (`worker_id`)
) ENGINE=InnoDB  DEFAULT CHARSET=utf8 AUTO_INCREMENT=2 ;

--
-- 資料表的匯出資料 `worker`
--

INSERT INTO `worker` (`worker_id`, `worker_level`, `worker_name`, `worker_username`, `worker_password`, `worker_project`, `worker_lastlogin`, `worker_lastIP`) VALUES
(1, 999, '系統管理員', 'erickson', '33f56baeca95d3b0131858e0a5ac88f6', '1, 2, 3', '2014-09-01 04:03:38', '127.0.0.1');

-- --------------------------------------------------------

--
-- 資料表結構 `worker_class`
--

CREATE TABLE IF NOT EXISTS `worker_class` (
  `class_id` int(2) NOT NULL AUTO_INCREMENT,
  `class_name` varchar(255) NOT NULL,
  `class_level` int(3) NOT NULL,
  `calss_authority` text NOT NULL,
  PRIMARY KEY (`class_id`),
  UNIQUE KEY `class_level` (`class_level`),
  KEY `class_name` (`class_name`,`class_level`)
) ENGINE=InnoDB  DEFAULT CHARSET=utf8 AUTO_INCREMENT=2 ;

--
-- 資料表的匯出資料 `worker_class`
--

INSERT INTO `worker_class` (`class_id`, `class_name`, `class_level`, `calss_authority`) VALUES
(1, '系統管理員', 999, '');

/*!40101 SET CHARACTER_SET_CLIENT=@OLD_CHARACTER_SET_CLIENT */;
/*!40101 SET CHARACTER_SET_RESULTS=@OLD_CHARACTER_SET_RESULTS */;
/*!40101 SET COLLATION_CONNECTION=@OLD_COLLATION_CONNECTION */;
