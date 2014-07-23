-- phpMyAdmin SQL Dump
-- version 4.1.14
-- http://www.phpmyadmin.net
--
-- Gostitelj: 127.0.0.1
-- Čas nastanka: 23. jul 2014 ob 17.32
-- Različica strežnika: 5.6.17
-- Različica PHP: 5.5.12

SET SQL_MODE = "NO_AUTO_VALUE_ON_ZERO";
SET time_zone = "+00:00";


/*!40101 SET @OLD_CHARACTER_SET_CLIENT=@@CHARACTER_SET_CLIENT */;
/*!40101 SET @OLD_CHARACTER_SET_RESULTS=@@CHARACTER_SET_RESULTS */;
/*!40101 SET @OLD_COLLATION_CONNECTION=@@COLLATION_CONNECTION */;
/*!40101 SET NAMES utf8 */;

--
-- Zbirka podatkov: `gagchan`
--

-- --------------------------------------------------------

--
-- Struktura tabele `category`
--

CREATE TABLE IF NOT EXISTS `category` (
  `id` int(11) NOT NULL AUTO_INCREMENT,
  `slug` varchar(255) NOT NULL,
  `name` varchar(255) NOT NULL,
  `priority` int(11) NOT NULL DEFAULT '0',
  `created_at` datetime NOT NULL,
  `updated_at` datetime NOT NULL,
  PRIMARY KEY (`id`),
  UNIQUE KEY `slug` (`slug`)
) ENGINE=InnoDB  DEFAULT CHARSET=utf8 AUTO_INCREMENT=11 ;

--
-- Odloži podatke za tabelo `category`
--

INSERT INTO `category` (`id`, `slug`, `name`, `priority`, `created_at`, `updated_at`) VALUES
(1, 'gif', 'GIF', 0, '2014-07-07 13:53:39', '2014-07-07 13:53:39'),
(2, 'cute', 'Cute', 0, '2014-07-07 13:53:46', '2014-07-07 13:53:46'),
(3, 'geeky', 'Geeky', 0, '2014-07-07 13:53:53', '2014-07-07 13:53:53'),
(4, 'cosplay', 'Cosplay', 0, '2014-07-07 13:54:02', '2014-07-07 13:54:02'),
(5, 'meme', 'Meme', 0, '2014-07-07 13:54:29', '2014-07-07 13:54:29'),
(6, 'timely', 'Timely', 0, '2014-07-07 13:54:40', '2014-07-07 13:54:40'),
(7, 'girl', 'Girl', 0, '2014-07-07 13:55:01', '2014-07-07 13:55:01'),
(8, 'food', 'Food', 0, '2014-07-07 13:55:16', '2014-07-07 13:55:16'),
(9, 'wtf', 'WTF', 0, '2014-07-07 13:55:26', '2014-07-07 13:55:26'),
(10, 'comic', 'Comic', 0, '2014-07-07 13:55:33', '2014-07-07 13:55:33');

-- --------------------------------------------------------

--
-- Struktura tabele `media`
--

CREATE TABLE IF NOT EXISTS `media` (
  `id` int(11) NOT NULL AUTO_INCREMENT,
  `slug` varchar(255) NOT NULL,
  `name` varchar(255) NOT NULL,
  `reference` varchar(255) NOT NULL,
  `thumbnail` varchar(255) DEFAULT NULL,
  `user_id` int(11) NOT NULL,
  `category_id` int(11) NOT NULL,
  `width` int(11) DEFAULT NULL,
  `height` int(11) DEFAULT NULL,
  `size` int(11) DEFAULT NULL,
  `content_type` varchar(64) DEFAULT NULL,
  `is_enabled` tinyint(1) NOT NULL DEFAULT '1',
  `is_featured` tinyint(1) NOT NULL DEFAULT '0',
  `created_at` datetime NOT NULL,
  `updated_at` datetime NOT NULL,
  PRIMARY KEY (`id`),
  UNIQUE KEY `slug` (`slug`),
  KEY `user_id` (`user_id`),
  KEY `category_id` (`category_id`)
) ENGINE=InnoDB  DEFAULT CHARSET=utf8 AUTO_INCREMENT=4 ;

--
-- Odloži podatke za tabelo `media`
--

INSERT INTO `media` (`id`, `slug`, `name`, `reference`, `thumbnail`, `user_id`, `category_id`, `width`, `height`, `size`, `content_type`, `is_enabled`, `is_featured`, `created_at`, `updated_at`) VALUES
(1, 'kl7b8xyt', 'Hell yeah, I&#039;m on diet', '/photo/kl7b8xyt_460s.jpg', NULL, 1, 5, 460, 595, 46601, 'image/jpeg', 0, 0, '2014-07-17 15:29:35', '2014-07-17 15:29:35'),
(2, 'qee8prrm', 'How do you know when you&#039;re middle-aged?', '/photo/qee8prrm_460s.jpg', NULL, 1, 9, 460, 389, 43736, 'image/jpeg', 0, 0, '2014-07-20 21:56:57', '2014-07-20 21:56:57'),
(3, '3ga4cev7', 'Priorities', '/photo/3ga4cev7_460sa_v1.gif', '/photo/3ga4cev7_460s_v1.jpg', 1, 1, 375, 253, 1598728, 'image/gif', 1, 0, '2014-07-21 14:33:24', '2014-07-21 14:33:24');

-- --------------------------------------------------------

--
-- Struktura tabele `media_comment`
--

CREATE TABLE IF NOT EXISTS `media_comment` (
  `id` int(11) NOT NULL AUTO_INCREMENT,
  `media_id` int(11) NOT NULL,
  `user_id` int(11) NOT NULL,
  `comment` text NOT NULL,
  `created_at` datetime NOT NULL,
  `updated_at` datetime NOT NULL,
  PRIMARY KEY (`id`),
  KEY `media_id` (`media_id`),
  KEY `user_id` (`user_id`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8 AUTO_INCREMENT=1 ;

-- --------------------------------------------------------

--
-- Struktura tabele `media_prototype`
--

CREATE TABLE IF NOT EXISTS `media_prototype` (
  `id` int(11) NOT NULL AUTO_INCREMENT,
  `slug` varchar(255) NOT NULL,
  `name` varchar(255) NOT NULL,
  `reference` varchar(255) NOT NULL,
  `width` int(11) DEFAULT NULL,
  `height` int(11) DEFAULT NULL,
  `size` int(11) DEFAULT NULL,
  `content_type` varchar(64) DEFAULT NULL,
  `created_at` datetime NOT NULL,
  `updated_at` datetime NOT NULL,
  PRIMARY KEY (`id`),
  UNIQUE KEY `slug` (`slug`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8 AUTO_INCREMENT=1 ;

-- --------------------------------------------------------

--
-- Struktura tabele `media_vote`
--

CREATE TABLE IF NOT EXISTS `media_vote` (
  `id` int(11) NOT NULL AUTO_INCREMENT,
  `media_id` int(11) NOT NULL,
  `user_id` int(11) DEFAULT NULL,
  `type` set('up','down') NOT NULL,
  `created_at` datetime NOT NULL,
  `updated_at` datetime NOT NULL,
  PRIMARY KEY (`id`),
  KEY `media_id` (`media_id`),
  KEY `user_id` (`user_id`)
) ENGINE=InnoDB  DEFAULT CHARSET=utf8 AUTO_INCREMENT=5 ;

-- --------------------------------------------------------

--
-- Struktura tabele `user`
--

CREATE TABLE IF NOT EXISTS `user` (
  `id` int(11) NOT NULL AUTO_INCREMENT,
  `username` varchar(255) NOT NULL,
  `email` varchar(255) NOT NULL,
  `password` varchar(255) DEFAULT NULL,
  `state` int(11) NOT NULL,
  `created_at` datetime NOT NULL,
  `updated_at` datetime NOT NULL,
  PRIMARY KEY (`id`),
  UNIQUE KEY `username` (`username`),
  UNIQUE KEY `email` (`email`)
) ENGINE=InnoDB  DEFAULT CHARSET=utf8 AUTO_INCREMENT=13 ;

--
-- Odloži podatke za tabelo `user`
--

INSERT INTO `user` (`id`, `username`, `email`, `password`, `state`, `created_at`, `updated_at`) VALUES
(1, 'example', 'user@example.org', '$2y$14$bUazSSLOQxWAOkY.DXaqPOlIqVJX/29kOdIcNrUgUkAFsvBVeancq', 1, '2014-07-07 23:28:38', '2014-07-07 23:28:38'),
(12, 'rok.mohar', 'rok.mohar@gmail.com', '$2y$14$cXNOX0zQayyOvFaFo7M1Kuu1U7pBdDhTkAylN0iREWwB0S5BTK2Dq', 1, '2014-07-22 19:52:36', '2014-07-22 20:01:27');

-- --------------------------------------------------------

--
-- Struktura tabele `user_confirmation`
--

CREATE TABLE IF NOT EXISTS `user_confirmation` (
  `id` int(11) NOT NULL AUTO_INCREMENT,
  `user_id` int(11) NOT NULL,
  `email` varchar(255) NOT NULL,
  `remote_address` varchar(255) NOT NULL,
  `request_at` datetime NOT NULL,
  `request_token` varchar(255) NOT NULL,
  `confirmed_at` datetime DEFAULT NULL,
  `is_confirmed` tinyint(1) NOT NULL DEFAULT '0',
  `created_at` datetime NOT NULL,
  `updated_at` datetime NOT NULL,
  PRIMARY KEY (`id`),
  KEY `user_id` (`user_id`)
) ENGINE=InnoDB  DEFAULT CHARSET=utf8 AUTO_INCREMENT=3 ;

--
-- Odloži podatke za tabelo `user_confirmation`
--

INSERT INTO `user_confirmation` (`id`, `user_id`, `email`, `remote_address`, `request_at`, `request_token`, `confirmed_at`, `is_confirmed`, `created_at`, `updated_at`) VALUES
(2, 12, 'rok.mohar@gmail.com', '127.0.0.1', '2014-07-22 19:52:36', '5GjWjK2Si6MO3R7Zes5pclMCt8CIggPW', '2014-07-22 20:01:27', 1, '2014-07-22 19:52:36', '2014-07-22 20:01:27');

-- --------------------------------------------------------

--
-- Struktura tabele `user_oauth`
--

CREATE TABLE IF NOT EXISTS `user_oauth` (
  `id` int(11) NOT NULL AUTO_INCREMENT,
  `user_id` int(11) NOT NULL,
  `provider` varchar(255) NOT NULL,
  `provider_id` varchar(255) NOT NULL,
  `created_at` datetime NOT NULL,
  `updated_at` datetime NOT NULL,
  PRIMARY KEY (`id`),
  KEY `user_id` (`user_id`)
) ENGINE=InnoDB  DEFAULT CHARSET=utf8 AUTO_INCREMENT=11 ;

-- --------------------------------------------------------

--
-- Struktura tabele `user_recover`
--

CREATE TABLE IF NOT EXISTS `user_recover` (
  `id` int(11) NOT NULL AUTO_INCREMENT,
  `user_id` int(11) NOT NULL,
  `email` varchar(255) NOT NULL,
  `remote_address` varchar(255) NOT NULL,
  `request_at` datetime NOT NULL,
  `request_token` varchar(255) NOT NULL,
  `recovered_at` datetime DEFAULT NULL,
  `is_recovered` tinyint(1) NOT NULL DEFAULT '0',
  `created_at` datetime NOT NULL,
  `updated_at` datetime NOT NULL,
  PRIMARY KEY (`id`),
  KEY `user_id` (`user_id`)
) ENGINE=InnoDB  DEFAULT CHARSET=utf8 AUTO_INCREMENT=3 ;

--
-- Omejitve tabel za povzetek stanja
--

--
-- Omejitve za tabelo `media`
--
ALTER TABLE `media`
  ADD CONSTRAINT `media_ibfk_1` FOREIGN KEY (`user_id`) REFERENCES `user` (`id`),
  ADD CONSTRAINT `media_ibfk_2` FOREIGN KEY (`category_id`) REFERENCES `category` (`id`);

--
-- Omejitve za tabelo `media_comment`
--
ALTER TABLE `media_comment`
  ADD CONSTRAINT `media_comment_ibfk_1` FOREIGN KEY (`media_id`) REFERENCES `media` (`id`),
  ADD CONSTRAINT `media_comment_ibfk_2` FOREIGN KEY (`user_id`) REFERENCES `user` (`id`);

--
-- Omejitve za tabelo `media_vote`
--
ALTER TABLE `media_vote`
  ADD CONSTRAINT `media_vote_ibfk_1` FOREIGN KEY (`media_id`) REFERENCES `media` (`id`),
  ADD CONSTRAINT `media_vote_ibfk_2` FOREIGN KEY (`user_id`) REFERENCES `user` (`id`);

--
-- Omejitve za tabelo `user_confirmation`
--
ALTER TABLE `user_confirmation`
  ADD CONSTRAINT `user_confirmation_ibfk_1` FOREIGN KEY (`user_id`) REFERENCES `user` (`id`);

--
-- Omejitve za tabelo `user_oauth`
--
ALTER TABLE `user_oauth`
  ADD CONSTRAINT `user_oauth_ibfk_1` FOREIGN KEY (`user_id`) REFERENCES `user` (`id`);

--
-- Omejitve za tabelo `user_recover`
--
ALTER TABLE `user_recover`
  ADD CONSTRAINT `user_recover_ibfk_1` FOREIGN KEY (`user_id`) REFERENCES `user` (`id`);

/*!40101 SET CHARACTER_SET_CLIENT=@OLD_CHARACTER_SET_CLIENT */;
/*!40101 SET CHARACTER_SET_RESULTS=@OLD_CHARACTER_SET_RESULTS */;
/*!40101 SET COLLATION_CONNECTION=@OLD_COLLATION_CONNECTION */;
