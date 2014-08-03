-- phpMyAdmin SQL Dump
-- version 4.2.3
-- http://www.phpmyadmin.net
--
-- 主機: localhost
-- 產生時間： 2014 年 08 月 03 日 19:13
-- 伺服器版本: 5.5.38-0ubuntu0.14.04.1
-- PHP 版本： 5.5.9-1ubuntu4.3

SET SQL_MODE = "NO_AUTO_VALUE_ON_ZERO";
SET time_zone = "+00:00";


/*!40101 SET @OLD_CHARACTER_SET_CLIENT=@@CHARACTER_SET_CLIENT */;
/*!40101 SET @OLD_CHARACTER_SET_RESULTS=@@CHARACTER_SET_RESULTS */;
/*!40101 SET @OLD_COLLATION_CONNECTION=@@COLLATION_CONNECTION */;
/*!40101 SET NAMES utf8 */;

--
-- 資料庫： `php-mvc-test`
--

-- --------------------------------------------------------

--
-- 資料表結構 `cf_items`
--

CREATE TABLE IF NOT EXISTS `cf_items` (
`items_id` int(10) NOT NULL,
  `items_project` int(5) NOT NULL,
  `items_outlay` char(1) NOT NULL,
  `items_price` int(10) NOT NULL,
  `items_name` varchar(255) NOT NULL,
  `items_applicant` int(5) NOT NULL,
  `items_status` int(1) NOT NULL DEFAULT '0',
  `items_reviewer` int(5) DEFAULT NULL,
  `items_app_time` timestamp NOT NULL DEFAULT CURRENT_TIMESTAMP,
  `items_rev_time` timestamp NULL DEFAULT NULL
) ENGINE=InnoDB  DEFAULT CHARSET=utf8 AUTO_INCREMENT=7 ;

-- --------------------------------------------------------

--
-- 資料表結構 `cf_project`
--

CREATE TABLE IF NOT EXISTS `cf_project` (
`project_id` int(10) NOT NULL,
  `project_name` varchar(255) NOT NULL,
  `project_status` char(1) NOT NULL DEFAULT 'T',
  `project_host` int(5) NOT NULL,
  `project_time` timestamp NOT NULL DEFAULT CURRENT_TIMESTAMP
) ENGINE=InnoDB  DEFAULT CHARSET=utf8 AUTO_INCREMENT=25 ;

-- --------------------------------------------------------

--
-- 資料表結構 `messages`
--

CREATE TABLE IF NOT EXISTS `messages` (
`messages_id` int(10) NOT NULL,
  `messages_draft` tinyint(1) NOT NULL DEFAULT '0',
  `messages_title` varchar(255) NOT NULL,
  `messages_content` longtext NOT NULL,
  `messages_author` int(5) NOT NULL,
  `messages_time` timestamp NOT NULL DEFAULT CURRENT_TIMESTAMP ON UPDATE CURRENT_TIMESTAMP
) ENGINE=InnoDB  DEFAULT CHARSET=utf8 AUTO_INCREMENT=5 ;

-- --------------------------------------------------------

--
-- 資料表結構 `worker`
--

CREATE TABLE IF NOT EXISTS `worker` (
`worker_id` int(5) NOT NULL,
  `worker_level` int(3) NOT NULL,
  `worker_name` varchar(255) NOT NULL,
  `worker_username` varchar(255) NOT NULL,
  `worker_password` char(32) NOT NULL,
  `worker_project` text NOT NULL,
  `worker_lastlogin` timestamp NOT NULL DEFAULT CURRENT_TIMESTAMP,
  `worker_lastIP` varchar(50) DEFAULT NULL
) ENGINE=InnoDB  DEFAULT CHARSET=utf8 AUTO_INCREMENT=6 ;

-- --------------------------------------------------------

--
-- 資料表結構 `worker_class`
--

CREATE TABLE IF NOT EXISTS `worker_class` (
`class_id` int(2) NOT NULL,
  `class_name` varchar(255) NOT NULL,
  `class_level` int(3) NOT NULL,
  `calss_authority` text NOT NULL
) ENGINE=InnoDB  DEFAULT CHARSET=utf8 AUTO_INCREMENT=4 ;

--
-- 已匯出資料表的索引
--

--
-- 資料表索引 `cf_items`
--
ALTER TABLE `cf_items`
 ADD PRIMARY KEY (`items_id`);

--
-- 資料表索引 `cf_project`
--
ALTER TABLE `cf_project`
 ADD PRIMARY KEY (`project_id`);

--
-- 資料表索引 `messages`
--
ALTER TABLE `messages`
 ADD PRIMARY KEY (`messages_id`);

--
-- 資料表索引 `worker`
--
ALTER TABLE `worker`
 ADD PRIMARY KEY (`worker_id`);

--
-- 資料表索引 `worker_class`
--
ALTER TABLE `worker_class`
 ADD PRIMARY KEY (`class_id`), ADD UNIQUE KEY `class_level` (`class_level`), ADD KEY `class_name` (`class_name`,`class_level`);

--
-- 在匯出的資料表使用 AUTO_INCREMENT
--

--
-- 使用資料表 AUTO_INCREMENT `cf_items`
--
ALTER TABLE `cf_items`
MODIFY `items_id` int(10) NOT NULL AUTO_INCREMENT,AUTO_INCREMENT=7;
--
-- 使用資料表 AUTO_INCREMENT `cf_project`
--
ALTER TABLE `cf_project`
MODIFY `project_id` int(10) NOT NULL AUTO_INCREMENT,AUTO_INCREMENT=25;
--
-- 使用資料表 AUTO_INCREMENT `messages`
--
ALTER TABLE `messages`
MODIFY `messages_id` int(10) NOT NULL AUTO_INCREMENT,AUTO_INCREMENT=5;
--
-- 使用資料表 AUTO_INCREMENT `worker`
--
ALTER TABLE `worker`
MODIFY `worker_id` int(5) NOT NULL AUTO_INCREMENT,AUTO_INCREMENT=6;
--
-- 使用資料表 AUTO_INCREMENT `worker_class`
--
ALTER TABLE `worker_class`
MODIFY `class_id` int(2) NOT NULL AUTO_INCREMENT,AUTO_INCREMENT=4;
/*!40101 SET CHARACTER_SET_CLIENT=@OLD_CHARACTER_SET_CLIENT */;
/*!40101 SET CHARACTER_SET_RESULTS=@OLD_CHARACTER_SET_RESULTS */;
/*!40101 SET COLLATION_CONNECTION=@OLD_COLLATION_CONNECTION */;
