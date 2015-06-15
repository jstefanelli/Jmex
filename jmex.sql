-- phpMyAdmin SQL Dump
-- version 4.3.11
-- http://www.phpmyadmin.net
--
-- Host: 127.0.0.1
-- Generation Time: Giu 15, 2015 alle 16:08
-- Versione del server: 5.6.24
-- PHP Version: 5.6.8

SET SQL_MODE = "NO_AUTO_VALUE_ON_ZERO";
SET time_zone = "+00:00";


/*!40101 SET @OLD_CHARACTER_SET_CLIENT=@@CHARACTER_SET_CLIENT */;
/*!40101 SET @OLD_CHARACTER_SET_RESULTS=@@CHARACTER_SET_RESULTS */;
/*!40101 SET @OLD_COLLATION_CONNECTION=@@COLLATION_CONNECTION */;
/*!40101 SET NAMES utf8 */;

--
-- Database: `jmex`
--

-- --------------------------------------------------------

--
-- Struttura della tabella `users`
--

CREATE TABLE IF NOT EXISTS `users` (
  `id` int(11) NOT NULL,
  `name` varchar(40) COLLATE utf8_bin NOT NULL,
  `psw` varchar(24) COLLATE utf8_bin NOT NULL,
  `logged` text COLLATE utf8_bin,
  `lastActivity` datetime DEFAULT NULL
) ENGINE=InnoDB AUTO_INCREMENT=5 DEFAULT CHARSET=utf8 COLLATE=utf8_bin;

--
-- Dump dei dati per la tabella `users`
--

INSERT INTO `users` (`id`, `name`, `psw`, `logged`, `lastActivity`) VALUES
(1, 'root', 'zDBDyaBWi9053mX4Feme0A==', '336de06a69e6ebe8fcaa98d42f8a8e58987c6d7085689632ac36cfdb897c0af9', '2015-06-15 14:29:03'),
(2, 'JPS', '5hCIlSCTXrcmF9puI9Mh7g==', '915a2056121e5741bbc55c3fb9e70c13691009c36afef257baef3156405d9295', '2015-06-15 14:35:19'),
(3, 'CAFFA', 'clE8WsVdRlnFmfkD2lLe9g==', 'd481f0556729b92a345a29601ead8d7fd4673e6e7b61c0663ff11007c53f32e8', '2015-06-15 15:36:21'),
(4, 'Wasson01', 'bmvE5J3Ud+vJjvQEbAZ7Xw==', NULL, NULL);

--
-- Indexes for dumped tables
--

--
-- Indexes for table `users`
--
ALTER TABLE `users`
  ADD PRIMARY KEY (`id`), ADD UNIQUE KEY `name` (`name`);

--
-- AUTO_INCREMENT for dumped tables
--

--
-- AUTO_INCREMENT for table `users`
--
ALTER TABLE `users`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT,AUTO_INCREMENT=5;
/*!40101 SET CHARACTER_SET_CLIENT=@OLD_CHARACTER_SET_CLIENT */;
/*!40101 SET CHARACTER_SET_RESULTS=@OLD_CHARACTER_SET_RESULTS */;
/*!40101 SET COLLATION_CONNECTION=@OLD_COLLATION_CONNECTION */;
