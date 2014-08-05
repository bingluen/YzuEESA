-- phpMyAdmin SQL Dump
-- version 4.2.3
-- http://www.phpmyadmin.net
--
-- 主機: localhost
-- 產生時間： 2014 年 08 月 03 日 19:12
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

--
-- 資料表的匯出資料 `cf_items`
--

INSERT INTO `cf_items` (`items_id`, `items_project`, `items_outlay`, `items_price`, `items_name`, `items_applicant`, `items_status`, `items_reviewer`, `items_app_time`, `items_rev_time`) VALUES
(1, 2, 'T', 10000, '購買主機', 1, 2, 1, '2014-07-13 12:30:16', '2014-07-13 12:33:35'),
(2, 2, 'T', 5000, '主機板', 1, 0, NULL, '2014-07-13 12:39:58', '0000-00-00 00:00:00'),
(3, 2, 'T', 1000, '硬碟', 1, 0, NULL, '2014-07-13 12:39:58', '0000-00-00 00:00:00'),
(4, 2, 'T', 3000, 'cpu', 1, 0, NULL, '2014-08-02 21:15:23', '0000-00-00 00:00:00'),
(5, 2, 'T', 2000, 'POWER', 1, 0, NULL, '2014-08-02 21:18:44', NULL),
(6, 2, 'T', 10, 'test', 5, 0, NULL, '2014-08-02 21:21:21', NULL);

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

--
-- 資料表的匯出資料 `cf_project`
--

INSERT INTO `cf_project` (`project_id`, `project_name`, `project_status`, `project_host`, `project_time`) VALUES
(2, '系學會伺服器採購', 'F', 1, '2014-07-13 03:01:22'),
(24, '系學會宣傳計畫', 'T', 1, '2014-07-13 12:35:24');

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

--
-- 資料表的匯出資料 `messages`
--

INSERT INTO `messages` (`messages_id`, `messages_draft`, `messages_title`, `messages_content`, `messages_author`, `messages_time`) VALUES
(1, 0, '修改測試', '<p>文字測試 test</p>\n<p>youtube測試</p>\n<p><iframe src="//www.youtube.com/embed/KMLHZas0DRM" width="640" height="360" frameborder="0" allowfullscreen="allowfullscreen"></iframe></p>\n<p>圖片插入測試</p>\n<p><img src="https://i.ytimg.com/sb/KMLHZas0DRM/storyboard3_L1/M0.jpg?sigh=bpLJ6jCVP54YOLgJbDuEupLah58" alt="" width="800" height="450" /></p>', 1, '2014-08-02 03:17:17'),
(2, 0, '測試文章咩', '<p><iframe src="//www.youtube.com/embed/K_xTet06SUo?rel=0" width="640" height="360" frameborder="0" allowfullscreen="allowfullscreen"></iframe></p>', 1, '2014-08-02 08:40:58'),
(3, 0, '多文章測試', '<p>多文章測試</p>', 1, '2014-08-02 09:02:01'),
(4, 0, '多文章測試', '<p>多文章測試</p>', 1, '2014-08-02 18:23:18');

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

--
-- 資料表的匯出資料 `worker`
--

INSERT INTO `worker` (`worker_id`, `worker_level`, `worker_name`, `worker_username`, `worker_password`, `worker_project`, `worker_lastlogin`, `worker_lastIP`) VALUES
(1, 999, '莊秉倫', 'erickson_juang', 'bfa31f12479c2e31f94405e3c18dcf57', '2,24', '2014-08-02 21:08:27', '10.0.2.2'),
(4, 901, '系統Clone', 'Suerclone', '098f6bcd4621d373cade4e832627b4f6', '', '2014-08-02 17:54:03', '10.0.2.2'),
(5, 1, '工人 Clone', 'workerman', '098f6bcd4621d373cade4e832627b4f6', '2', '2014-08-02 21:19:34', '10.0.2.2');

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
-- 資料表的匯出資料 `worker_class`
--

INSERT INTO `worker_class` (`class_id`, `class_name`, `class_level`, `calss_authority`) VALUES
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
