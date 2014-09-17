-- phpMyAdmin SQL Dump
-- version 4.2.3
-- http://www.phpmyadmin.net
--
-- 主機: localhost
-- 產生時間： 2014 年 09 月 17 日 18:37
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
) ENGINE=InnoDB  DEFAULT CHARSET=utf8 AUTO_INCREMENT=9 ;

--
-- 資料表的匯出資料 `cf_items`
--

INSERT INTO `cf_items` (`items_id`, `items_project`, `items_outlay`, `items_price`, `items_name`, `items_applicant`, `items_status`, `items_reviewer`, `items_app_time`, `items_rev_time`) VALUES
(1, 1, 'T', 800, '學員餐費（80元/人）', 1, 0, NULL, '2014-08-18 22:43:04', NULL),
(2, 1, 'T', 880, '競賽獎品', 1, 1, 1, '2014-08-18 22:43:04', '2014-08-18 22:43:25'),
(3, 1, 'T', 100, '美工材料、海報', 1, 1, 1, '2014-08-18 22:43:04', '2014-08-18 22:43:28'),
(4, 1, 'T', 1350, '全體工作人員餐費（9名）', 1, 1, 1, '2014-08-18 22:43:04', '2014-08-18 22:43:25'),
(5, 1, 'T', 90, '課程講義及回饋單（30份）', 1, 1, 1, '2014-08-18 22:43:04', '2014-09-09 02:28:51'),
(6, 1, 'T', 1600, '助教車馬費 （8名）', 1, 1, 1, '2014-08-18 22:43:04', '2014-08-18 22:43:25'),
(7, 1, 'T', 500, '講師費與車馬費', 1, 1, 1, '2014-08-18 22:43:04', '2014-08-18 22:43:25');

-- --------------------------------------------------------

--
-- 資料表結構 `cf_project`
--

CREATE TABLE IF NOT EXISTS `cf_project` (
`project_id` int(10) NOT NULL,
  `project_category` int(3) NOT NULL,
  `project_name` varchar(255) NOT NULL,
  `project_status` char(1) NOT NULL DEFAULT 'T',
  `project_host` int(5) NOT NULL,
  `project_time` timestamp NOT NULL DEFAULT CURRENT_TIMESTAMP
) ENGINE=InnoDB  DEFAULT CHARSET=utf8 AUTO_INCREMENT=3 ;

--
-- 資料表的匯出資料 `cf_project`
--

INSERT INTO `cf_project` (`project_id`, `project_category`, `project_name`, `project_status`, `project_host`, `project_time`) VALUES
(1, 2, '103學年元智電機系學會樂高機器人營', 'T', 1, '2014-08-18 20:41:18'),
(2, 2, '103學年元智電機系學會新生宿營活動既系服購買', 'T', 1, '2014-08-18 20:43:31');

-- --------------------------------------------------------

--
-- 資料表結構 `cf_project_category`
--

CREATE TABLE IF NOT EXISTS `cf_project_category` (
`category_id` int(3) NOT NULL,
  `category_name` varchar(25) NOT NULL,
  `category_color` varchar(7) NOT NULL
) ENGINE=InnoDB  DEFAULT CHARSET=utf8 AUTO_INCREMENT=3 ;

--
-- 資料表的匯出資料 `cf_project_category`
--

INSERT INTO `cf_project_category` (`category_id`, `category_name`, `category_color`) VALUES
(1, '設備採購', '#00ffff'),
(2, '學術活動', '#89bc84');

-- --------------------------------------------------------

--
-- 資料表結構 `event_list`
--

CREATE TABLE IF NOT EXISTS `event_list` (
`event_id` int(10) NOT NULL,
  `event_name` varchar(255) NOT NULL,
  `event_path` varchar(255) NOT NULL,
  `event_host` int(5) NOT NULL
) ENGINE=InnoDB  DEFAULT CHARSET=utf8 AUTO_INCREMENT=4 ;

--
-- 資料表的匯出資料 `event_list`
--

INSERT INTO `event_list` (`event_id`, `event_name`, `event_path`, `event_host`) VALUES
(2, '103學年元智電機系學會樂高機器人營', '31bd954c', 1),
(3, '103學年元智電機系學會新生宿營活動既系服購買', 'yzueesa-freshmen-active', 1);

-- --------------------------------------------------------

--
-- 資料表結構 `messages`
--

CREATE TABLE IF NOT EXISTS `messages` (
`messages_id` int(10) NOT NULL,
  `messages_type` int(2) NOT NULL DEFAULT '0',
  `messages_eventid` int(5) NOT NULL DEFAULT '0',
  `messages_draft` tinyint(1) NOT NULL DEFAULT '0',
  `messages_title` varchar(255) NOT NULL,
  `messages_content` longtext NOT NULL,
  `messages_author` int(5) NOT NULL,
  `messages_time` timestamp NOT NULL DEFAULT CURRENT_TIMESTAMP ON UPDATE CURRENT_TIMESTAMP
) ENGINE=InnoDB  DEFAULT CHARSET=utf8 AUTO_INCREMENT=3 ;

--
-- 資料表的匯出資料 `messages`
--

INSERT INTO `messages` (`messages_id`, `messages_type`, `messages_eventid`, `messages_draft`, `messages_title`, `messages_content`, `messages_author`, `messages_time`) VALUES
(1, 1, 2, 0, 'test', '&lt;p&gt;test&lt;/p&gt;', 1, '2014-08-22 08:09:24'),
(2, 0, 2, 0, 'xd', '&lt;p&gt;哈哈哈ㄏ&lt;/p&gt;', 1, '2014-08-31 04:04:21');

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
  `worker_lastlogin` timestamp NOT NULL DEFAULT CURRENT_TIMESTAMP,
  `worker_lastIP` varchar(50) DEFAULT NULL
) ENGINE=InnoDB  DEFAULT CHARSET=utf8 AUTO_INCREMENT=3 ;

--
-- 資料表的匯出資料 `worker`
--

INSERT INTO `worker` (`worker_id`, `worker_level`, `worker_name`, `worker_username`, `worker_password`, `worker_lastlogin`, `worker_lastIP`) VALUES
(1, 999, 'demo', 'demo', 'fe01ce2a7fbac8fafaed7c982a04e229', '2014-09-17 05:09:05', '10.0.2.2');

-- --------------------------------------------------------

--
-- 資料表結構 `worker_class`
--

CREATE TABLE IF NOT EXISTS `worker_class` (
`class_id` int(2) NOT NULL,
  `class_name` varchar(255) NOT NULL,
  `class_level` int(3) NOT NULL,
  `class_authority` text NOT NULL
) ENGINE=InnoDB  DEFAULT CHARSET=utf8 AUTO_INCREMENT=4 ;

--
-- 資料表的匯出資料 `worker_class`
--

INSERT INTO `worker_class` (`class_id`, `class_name`, `class_level`, `class_authority`) VALUES
(1, '系統管理員', 999, ''),
(2, '系統管理組', 901, ''),
(3, '工人', 1, '');

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
-- 資料表索引 `cf_project_category`
--
ALTER TABLE `cf_project_category`
 ADD PRIMARY KEY (`category_id`);

--
-- 資料表索引 `event_list`
--
ALTER TABLE `event_list`
 ADD PRIMARY KEY (`event_id`);

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
MODIFY `items_id` int(10) NOT NULL AUTO_INCREMENT,AUTO_INCREMENT=9;
--
-- 使用資料表 AUTO_INCREMENT `cf_project`
--
ALTER TABLE `cf_project`
MODIFY `project_id` int(10) NOT NULL AUTO_INCREMENT,AUTO_INCREMENT=3;
--
-- 使用資料表 AUTO_INCREMENT `cf_project_category`
--
ALTER TABLE `cf_project_category`
MODIFY `category_id` int(3) NOT NULL AUTO_INCREMENT,AUTO_INCREMENT=3;
--
-- 使用資料表 AUTO_INCREMENT `event_list`
--
ALTER TABLE `event_list`
MODIFY `event_id` int(10) NOT NULL AUTO_INCREMENT,AUTO_INCREMENT=4;
--
-- 使用資料表 AUTO_INCREMENT `messages`
--
ALTER TABLE `messages`
MODIFY `messages_id` int(10) NOT NULL AUTO_INCREMENT,AUTO_INCREMENT=3;
--
-- 使用資料表 AUTO_INCREMENT `worker`
--
ALTER TABLE `worker`
MODIFY `worker_id` int(5) NOT NULL AUTO_INCREMENT,AUTO_INCREMENT=3;
--
-- 使用資料表 AUTO_INCREMENT `worker_class`
--
ALTER TABLE `worker_class`
MODIFY `class_id` int(2) NOT NULL AUTO_INCREMENT,AUTO_INCREMENT=4;
/*!40101 SET CHARACTER_SET_CLIENT=@OLD_CHARACTER_SET_CLIENT */;
/*!40101 SET CHARACTER_SET_RESULTS=@OLD_CHARACTER_SET_RESULTS */;
/*!40101 SET COLLATION_CONNECTION=@OLD_COLLATION_CONNECTION */;
