-- phpMyAdmin SQL Dump
-- version 4.3.2
-- http://www.phpmyadmin.net
--
-- Host: localhost
-- Generation Time: 2015-01-20 15:01:23
-- 服务器版本： 5.5.40-0ubuntu1
-- PHP Version: 5.5.12-2ubuntu4.1

SET SQL_MODE = "NO_AUTO_VALUE_ON_ZERO";
SET time_zone = "+00:00";


/*!40101 SET @OLD_CHARACTER_SET_CLIENT=@@CHARACTER_SET_CLIENT */;
/*!40101 SET @OLD_CHARACTER_SET_RESULTS=@@CHARACTER_SET_RESULTS */;
/*!40101 SET @OLD_COLLATION_CONNECTION=@@COLLATION_CONNECTION */;
/*!40101 SET NAMES utf8 */;

--
-- Database: `joyproj`
--

-- --------------------------------------------------------

--
-- 表的结构 `lc_admin`
--

CREATE TABLE IF NOT EXISTS `lc_admin` (
  `id` tinyint(4) NOT NULL COMMENT '主键',
  `username` varchar(8) NOT NULL DEFAULT '' COMMENT '用户名',
  `password` char(40) NOT NULL DEFAULT '' COMMENT '密码'
) ENGINE=InnoDB AUTO_INCREMENT=2 DEFAULT CHARSET=utf8 COMMENT='聊天室管理员表';

--
-- 转存表中的数据 `lc_admin`
--

INSERT INTO `lc_admin` (`id`, `username`, `password`) VALUES
(1, 'root', 'adf6f214327d2a111cf0db9fe0df1d8f894053b6');

-- --------------------------------------------------------

--
-- 表的结构 `lc_category`
--

CREATE TABLE IF NOT EXISTS `lc_category` (
  `id` mediumint(8) unsigned NOT NULL COMMENT '主键',
  `name` varchar(8) NOT NULL DEFAULT '' COMMENT '分类名字',
  `parent_id` mediumint(8) unsigned NOT NULL DEFAULT '0' COMMENT '上一级分类的ID',
  `status` enum('0','1') NOT NULL DEFAULT '1' COMMENT '是否启用'
) ENGINE=InnoDB DEFAULT CHARSET=utf8 COMMENT='聊天室分类表';

-- --------------------------------------------------------

--
-- 表的结构 `lc_user`
--

CREATE TABLE IF NOT EXISTS `lc_user` (
  `id` int(11) unsigned NOT NULL COMMENT '主键',
  `username` varchar(8) NOT NULL DEFAULT '' COMMENT '用户名',
  `email` varchar(64) NOT NULL DEFAULT '' COMMENT '邮箱',
  `password` char(40) NOT NULL DEFAULT '' COMMENT '密码',
  `ctime` int(10) unsigned NOT NULL DEFAULT '0' COMMENT '创建时间'
) ENGINE=InnoDB AUTO_INCREMENT=8 DEFAULT CHARSET=utf8 COMMENT='聊天室用户表';

--
-- 转存表中的数据 `lc_user`
--

INSERT INTO `lc_user` (`id`, `username`, `email`, `password`, `ctime`) VALUES
(7, 'jmjoy', '918734043@qq.com', '6b05e14df7b86cefd47ec43d900a0e03e122cc6e', 1421414085);

-- --------------------------------------------------------

--
-- 表的结构 `lc_user_token`
--

CREATE TABLE IF NOT EXISTS `lc_user_token` (
  `id` int(11) NOT NULL COMMENT '主键',
  `uid` int(11) NOT NULL DEFAULT '0' COMMENT '用户ID',
  `token` char(32) NOT NULL DEFAULT '' COMMENT '令牌',
  `ctime` int(11) NOT NULL DEFAULT '0' COMMENT '创建时间'
) ENGINE=InnoDB DEFAULT CHARSET=utf8 COMMENT='聊天室用户令牌表';

--
-- Indexes for dumped tables
--

--
-- Indexes for table `lc_admin`
--
ALTER TABLE `lc_admin`
  ADD PRIMARY KEY (`id`), ADD UNIQUE KEY `username` (`username`);

--
-- Indexes for table `lc_category`
--
ALTER TABLE `lc_category`
  ADD PRIMARY KEY (`id`), ADD KEY `parent_id` (`parent_id`);

--
-- Indexes for table `lc_user`
--
ALTER TABLE `lc_user`
  ADD PRIMARY KEY (`id`), ADD UNIQUE KEY `email` (`email`), ADD UNIQUE KEY `username` (`username`);

--
-- Indexes for table `lc_user_token`
--
ALTER TABLE `lc_user_token`
  ADD PRIMARY KEY (`id`);

--
-- AUTO_INCREMENT for dumped tables
--

--
-- AUTO_INCREMENT for table `lc_admin`
--
ALTER TABLE `lc_admin`
  MODIFY `id` tinyint(4) NOT NULL AUTO_INCREMENT COMMENT '主键',AUTO_INCREMENT=2;
--
-- AUTO_INCREMENT for table `lc_category`
--
ALTER TABLE `lc_category`
  MODIFY `id` mediumint(8) unsigned NOT NULL AUTO_INCREMENT COMMENT '主键';
--
-- AUTO_INCREMENT for table `lc_user`
--
ALTER TABLE `lc_user`
  MODIFY `id` int(11) unsigned NOT NULL AUTO_INCREMENT COMMENT '主键',AUTO_INCREMENT=8;
--
-- AUTO_INCREMENT for table `lc_user_token`
--
ALTER TABLE `lc_user_token`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT COMMENT '主键';
/*!40101 SET CHARACTER_SET_CLIENT=@OLD_CHARACTER_SET_CLIENT */;
/*!40101 SET CHARACTER_SET_RESULTS=@OLD_CHARACTER_SET_RESULTS */;
/*!40101 SET COLLATION_CONNECTION=@OLD_COLLATION_CONNECTION */;
