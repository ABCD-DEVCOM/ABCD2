-- phpMyAdmin SQL Dump
-- version 2.11.6
-- http://www.phpmyadmin.net
--
-- Host: localhost
-- Generation Time: Jul 10, 2009 at 10:37 PM
-- Server version: 5.0.51
-- PHP Version: 5.2.6

SET SQL_MODE="NO_AUTO_VALUE_ON_ZERO";


/*!40101 SET @OLD_CHARACTER_SET_CLIENT=@@CHARACTER_SET_CLIENT */;
/*!40101 SET @OLD_CHARACTER_SET_RESULTS=@@CHARACTER_SET_RESULTS */;
/*!40101 SET @OLD_COLLATION_CONNECTION=@@COLLATION_CONNECTION */;
/*!40101 SET NAMES utf8 */;

--
-- Database: `university`
--

-- --------------------------------------------------------

--
-- Table structure for table `users`
--

CREATE DATABASE university;
USE university;

CREATE TABLE IF NOT EXISTS `users` (
  `id` int(10) unsigned NOT NULL auto_increment,
  `identification` varchar(50) collate utf8_spanish_ci NOT NULL,
  `last_name` varchar(200) collate utf8_spanish_ci NOT NULL,
  `first_name` varchar(200) collate utf8_spanish_ci NOT NULL,
  `user_type_id` int(11) NOT NULL,
  `valid_until` date NOT NULL,
  `login` varchar(20) collate utf8_spanish_ci NOT NULL,
  `passwd` varchar(20) collate utf8_spanish_ci NOT NULL,
  PRIMARY KEY  (`id`),
  UNIQUE KEY `userlogin` (`login`)
) ENGINE=MyISAM  DEFAULT CHARSET=utf8 COLLATE=utf8_spanish_ci AUTO_INCREMENT=5 ;

--
-- Dumping data for table `users`
--

INSERT INTO `users` (`id`, `identification`, `last_name`, `first_name`, `user_type_id`, `valid_until`, `login`, `passwd`) VALUES
(1, 'ABX-6272', 'Johansen', 'Arthur ', 1, '2022-12-24', 'arthur', 'arthur'),
(2, 'ABX-6362', 'Summer', 'Albert John', 1, '2022-10-22', 'summer', 'summer'),
(3, 'CBX-1627', 'Winter', 'Gladys', 2, '2022-03-24', 'gladys', 'gladys'),
(4, 'CBR-22782', 'Spring', 'Ernest', 4, '2022-07-31', 'spring', 'spring');

-- --------------------------------------------------------

--
-- Table structure for table `user_type`
--

CREATE TABLE IF NOT EXISTS `user_type` (
  `id` int(11) NOT NULL auto_increment,
  `name` varchar(200) collate utf8_spanish_ci NOT NULL,
  PRIMARY KEY  (`id`)
) ENGINE=MyISAM  DEFAULT CHARSET=utf8 COLLATE=utf8_spanish_ci AUTO_INCREMENT=5 ;

--
-- Dumping data for table `user_type`
--

INSERT INTO `user_type` (`id`, `name`) VALUES
(1, 'Students'),
(2, 'Proffesors'),
(3, 'Assistants'),
(4, 'Post-graduate Students');
