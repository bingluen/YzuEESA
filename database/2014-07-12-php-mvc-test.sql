-- phpMyAdmin SQL Dump
-- version 4.2.3
-- http://www.phpmyadmin.net
--
-- 主機: localhost
-- 產生時間： 2014 年 07 月 12 日 08:39
-- 伺服器版本: 5.5.37-0ubuntu0.14.04.1
-- PHP 版本： 5.5.9-1ubuntu4.2

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
-- 資料表結構 `event`
--

CREATE TABLE IF NOT EXISTS `event` (
`id` int(11) NOT NULL,
  `eventName` varchar(250) NOT NULL,
  `updateTime` timestamp NOT NULL DEFAULT '0000-00-00 00:00:00',
  `regTimeStart` timestamp NOT NULL DEFAULT '0000-00-00 00:00:00',
  `regTimeEnd` timestamp NOT NULL DEFAULT '0000-00-00 00:00:00',
  `eventTimeStart` timestamp NOT NULL DEFAULT '0000-00-00 00:00:00',
  `eventTimeEnd` timestamp NOT NULL DEFAULT '0000-00-00 00:00:00'
) ENGINE=InnoDB DEFAULT CHARSET=utf8 AUTO_INCREMENT=1 ;

-- --------------------------------------------------------

--
-- 資料表結構 `eventManager`
--

CREATE TABLE IF NOT EXISTS `eventManager` (
`id` int(10) unsigned NOT NULL,
  `account` varchar(100) NOT NULL,
  `password` varchar(256) NOT NULL,
  `username` varchar(100) NOT NULL,
  `email` varchar(500) NOT NULL,
  `lastLogin` timestamp NOT NULL DEFAULT CURRENT_TIMESTAMP ON UPDATE CURRENT_TIMESTAMP,
  `lastIp` varchar(256) NOT NULL,
  `token` varchar(256) NOT NULL
) ENGINE=InnoDB  DEFAULT CHARSET=utf8 AUTO_INCREMENT=2 ;

--
-- 資料表的匯出資料 `eventManager`
--

INSERT INTO `eventManager` (`id`, `account`, `password`, `username`, `email`, `lastLogin`, `lastIp`, `token`) VALUES
(1, 'test', '098f6bcd4621d373cade4e832627b4f6', 'testamdin', 'test@gmail.com', '2014-06-25 09:13:03', '10.0.2.2', '8b15885ead8718b3b1632ed9fe212914');

-- --------------------------------------------------------

--
-- 資料表結構 `eventReg`
--

CREATE TABLE IF NOT EXISTS `eventReg` (
`id` int(11) NOT NULL,
  `eventId` int(11) NOT NULL,
  `columName` longtext NOT NULL,
  `columData` longtext NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8 AUTO_INCREMENT=1 ;

-- --------------------------------------------------------

--
-- 資料表結構 `log`
--

CREATE TABLE IF NOT EXISTS `log` (
  `time` timestamp NOT NULL DEFAULT CURRENT_TIMESTAMP,
  `type` varchar(100) NOT NULL,
  `ip` varchar(256) NOT NULL,
  `page` varchar(256) NOT NULL,
  `messages` text NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8;

--
-- 資料表的匯出資料 `log`
--

INSERT INTO `log` (`time`, `type`, `ip`, `page`, `messages`) VALUES
('2014-06-25 09:10:27', 'event', '10.0.2.2', 'eventMan', 'read eventMan page'),
('2014-06-25 09:10:32', 'successLogin', '10.0.2.2', 'login for eventMan', 'login eventMan success'),
('2014-06-25 09:12:00', 'event', '10.0.2.2', 'eventMan', 'read eventMan page'),
('2014-06-25 09:12:03', 'successLogin', '10.0.2.2', 'login for eventMan', 'login eventMan success'),
('2014-06-25 09:12:31', 'event', '10.0.2.2', 'eventMan', 'read eventMan page'),
('2014-06-25 09:12:34', 'successLogin', '10.0.2.2', 'login for eventMan', 'login eventMan success'),
('2014-06-25 09:12:59', 'event', '10.0.2.2', 'eventMan', 'read eventMan page'),
('2014-06-25 09:13:03', 'successLogin', '10.0.2.2', 'login for eventMan', 'login eventMan success');

--
-- 已匯出資料表的索引
--

--
-- 資料表索引 `event`
--
ALTER TABLE `event`
 ADD PRIMARY KEY (`id`), ADD KEY `eventName` (`eventName`);

--
-- 資料表索引 `eventManager`
--
ALTER TABLE `eventManager`
 ADD PRIMARY KEY (`id`), ADD UNIQUE KEY `account` (`account`), ADD KEY `account_2` (`account`);

--
-- 資料表索引 `eventReg`
--
ALTER TABLE `eventReg`
 ADD PRIMARY KEY (`id`);

--
-- 資料表索引 `log`
--
ALTER TABLE `log`
 ADD PRIMARY KEY (`time`);

--
-- 在匯出的資料表使用 AUTO_INCREMENT
--

--
-- 使用資料表 AUTO_INCREMENT `event`
--
ALTER TABLE `event`
MODIFY `id` int(11) NOT NULL AUTO_INCREMENT;
--
-- 使用資料表 AUTO_INCREMENT `eventManager`
--
ALTER TABLE `eventManager`
MODIFY `id` int(10) unsigned NOT NULL AUTO_INCREMENT,AUTO_INCREMENT=2;
--
-- 使用資料表 AUTO_INCREMENT `eventReg`
--
ALTER TABLE `eventReg`
MODIFY `id` int(11) NOT NULL AUTO_INCREMENT;
/*!40101 SET CHARACTER_SET_CLIENT=@OLD_CHARACTER_SET_CLIENT */;
/*!40101 SET CHARACTER_SET_RESULTS=@OLD_CHARACTER_SET_RESULTS */;
/*!40101 SET COLLATION_CONNECTION=@OLD_COLLATION_CONNECTION */;
