-- phpMyAdmin SQL Dump
-- version 3.1.3.1
-- http://www.phpmyadmin.net
--
-- Host: localhost
-- Generation Time: May 08, 2012 at 05:00 PM
-- Server version: 5.1.61
-- PHP Version: 5.3.3-7+squeeze8

SET SQL_MODE="NO_AUTO_VALUE_ON_ZERO";

--
-- Database: 'life'
--

-- --------------------------------------------------------

--
-- Table structure for table 'photos'
--

CREATE TABLE photos (
  id int(11) NOT NULL AUTO_INCREMENT,
  title text COLLATE utf8_unicode_ci NOT NULL,
  extension varchar(5) COLLATE utf8_unicode_ci NOT NULL,
  size int(11) NOT NULL,
  uploaded datetime NOT NULL,
  taken datetime NOT NULL,
  userid int(11) NOT NULL,
  `hash` char(32) COLLATE utf8_unicode_ci NOT NULL,
  width int(11) NOT NULL,
  height int(11) NOT NULL,
  PRIMARY KEY (id),
  KEY userid (userid)
) ENGINE=MyISAM  DEFAULT CHARSET=utf8 COLLATE=utf8_unicode_ci;

--
-- Triggers 'photos'
--
DROP TRIGGER IF EXISTS `life`.`photocreate`;
DELIMITER //
CREATE TRIGGER `life`.`photocreate` BEFORE INSERT ON `life`.`photos`
 FOR EACH ROW BEGIN
SET NEW.uploaded = NOW();
END
//
DELIMITER ;

-- --------------------------------------------------------

--
-- Table structure for table 'posts'
--

CREATE TABLE posts (
  id int(11) NOT NULL AUTO_INCREMENT,
  userid int(11) NOT NULL,
  `text` text COLLATE utf8_unicode_ci NOT NULL,
  created datetime NOT NULL,
  visibility enum('private','public') COLLATE utf8_unicode_ci NOT NULL,
  `type` enum('text','photo') COLLATE utf8_unicode_ci NOT NULL,
  deleted enum('no','yes') COLLATE utf8_unicode_ci NOT NULL,
  PRIMARY KEY (id)
) ENGINE=MyISAM  DEFAULT CHARSET=utf8 COLLATE=utf8_unicode_ci;

--
-- Triggers 'posts'
--
DROP TRIGGER IF EXISTS `life`.`postcreate`;
DELIMITER //
CREATE TRIGGER `life`.`postcreate` BEFORE INSERT ON `life`.`posts`
 FOR EACH ROW BEGIN
IF NEW.created = '0000-00-00 00:00:00' THEN
SET NEW.created = NOW();
END IF;
END
//
DELIMITER ;

-- --------------------------------------------------------

--
-- Table structure for table 'users'
--

CREATE TABLE users (
  id int(11) NOT NULL AUTO_INCREMENT,
  `name` varchar(32) COLLATE utf8_unicode_ci NOT NULL,
  `password` varchar(256) COLLATE utf8_unicode_ci NOT NULL,
  hashing varchar(128) COLLATE utf8_unicode_ci NOT NULL,
  created datetime NOT NULL DEFAULT '0000-00-00 00:00:00',
  PRIMARY KEY (id),
  UNIQUE KEY `name` (`name`)
) ENGINE=MyISAM  DEFAULT CHARSET=utf8 COLLATE=utf8_unicode_ci;

--
-- Triggers 'users'
--
DROP TRIGGER IF EXISTS `life`.`newuser`;
DELIMITER //
CREATE TRIGGER `life`.`newuser` BEFORE INSERT ON `life`.`users`
 FOR EACH ROW BEGIN
    SET NEW.created = NOW();
END
//
DELIMITER ;

