-- phpMyAdmin SQL Dump
-- version 4.2.5
-- http://www.phpmyadmin.net
--
-- Gostitelj: 127.0.0.1:3306
-- Čas nastanka: 11. jul 2014 ob 16.27
-- Različica strežnika: 5.6.19
-- Različica PHP: 5.5.13

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
`id` int(11) NOT NULL,
  `slug` varchar(255) NOT NULL,
  `name` varchar(255) NOT NULL,
  `created_at` datetime NOT NULL DEFAULT CURRENT_TIMESTAMP,
  `updated_at` datetime NOT NULL DEFAULT CURRENT_TIMESTAMP
) ENGINE=InnoDB  DEFAULT CHARSET=utf8 AUTO_INCREMENT=11 ;

--
-- Odloži podatke za tabelo `category`
--

INSERT INTO `category` (`id`, `slug`, `name`, `created_at`, `updated_at`) VALUES
(1, 'gif', 'GIF', '2014-07-07 13:53:39', '2014-07-07 13:53:39'),
(2, 'cute', 'Cute', '2014-07-07 13:53:46', '2014-07-07 13:53:46'),
(3, 'geeky', 'Geeky', '2014-07-07 13:53:53', '2014-07-07 13:53:53'),
(4, 'cosplay', 'Cosplay', '2014-07-07 13:54:02', '2014-07-07 13:54:02'),
(5, 'meme', 'Meme', '2014-07-07 13:54:29', '2014-07-07 13:54:29'),
(6, 'timely', 'Timely', '2014-07-07 13:54:40', '2014-07-07 13:54:40'),
(7, 'girl', 'Girl', '2014-07-07 13:55:01', '2014-07-07 13:55:01'),
(8, 'food', 'Food', '2014-07-07 13:55:16', '2014-07-07 13:55:16'),
(9, 'wtf', 'WTF', '2014-07-07 13:55:26', '2014-07-07 13:55:26'),
(10, 'comic', 'Comic', '2014-07-07 13:55:33', '2014-07-07 13:55:33');

-- --------------------------------------------------------

--
-- Struktura tabele `media`
--

CREATE TABLE IF NOT EXISTS `media` (
`id` int(11) NOT NULL,
  `slug` varchar(255) NOT NULL,
  `name` varchar(255) NOT NULL,
  `reference` varchar(255) DEFAULT NULL,
  `user_id` int(11) NOT NULL,
  `category_id` int(11) NOT NULL,
  `width` int(11) DEFAULT NULL,
  `height` int(11) DEFAULT NULL,
  `size` int(11) DEFAULT NULL,
  `content_type` varchar(64) DEFAULT NULL,
  `created_at` datetime NOT NULL DEFAULT CURRENT_TIMESTAMP,
  `updated_at` datetime NOT NULL DEFAULT CURRENT_TIMESTAMP
) ENGINE=InnoDB  DEFAULT CHARSET=utf8 AUTO_INCREMENT=7 ;

--
-- Odloži podatke za tabelo `media`
--

INSERT INTO `media` (`id`, `slug`, `name`, `reference`, `user_id`, `category_id`, `width`, `height`, `size`, `content_type`, `created_at`, `updated_at`) VALUES
(5, 'r97o0hqs', 'This is just a meme', 'r97o0hqs.jpg', 1, 1, 460, 397, 82304, 'image/jpeg', '2014-07-10 23:52:07', '2014-07-10 23:52:07');

-- --------------------------------------------------------

--
-- Struktura tabele `media_comment`
--

CREATE TABLE IF NOT EXISTS `media_comment` (
`id` int(11) NOT NULL,
  `media_id` int(11) NOT NULL,
  `user_id` int(11) NOT NULL,
  `comment` text NOT NULL,
  `created_at` datetime NOT NULL DEFAULT CURRENT_TIMESTAMP,
  `updated_at` datetime NOT NULL DEFAULT CURRENT_TIMESTAMP
) ENGINE=InnoDB  DEFAULT CHARSET=utf8 AUTO_INCREMENT=6 ;

--
-- Odloži podatke za tabelo `media_comment`
--

INSERT INTO `media_comment` (`id`, `media_id`, `user_id`, `comment`, `created_at`, `updated_at`) VALUES
(1, 5, 1, 'This is my first comment', '2014-07-11 14:58:44', '2014-07-11 14:58:44'),
(2, 5, 1, 'Test comment', '2014-07-11 15:43:09', '2014-07-11 15:43:09'),
(5, 5, 1, 'Another comment', '2014-07-11 15:44:57', '2014-07-11 15:44:57');

-- --------------------------------------------------------

--
-- Struktura tabele `media_response`
--

CREATE TABLE IF NOT EXISTS `media_response` (
  `media_id` int(11) NOT NULL,
  `user_id` int(11) NOT NULL,
  `type` set('up','down') NOT NULL,
  `created_at` datetime NOT NULL DEFAULT CURRENT_TIMESTAMP,
  `updated_at` datetime NOT NULL DEFAULT CURRENT_TIMESTAMP
) ENGINE=InnoDB DEFAULT CHARSET=utf8;

-- --------------------------------------------------------

--
-- Struktura tabele `newsletter`
--

CREATE TABLE IF NOT EXISTS `newsletter` (
`id` int(11) NOT NULL,
  `user_id` int(11) DEFAULT NULL,
  `email` varchar(255) DEFAULT NULL,
  `created_at` int(11) NOT NULL,
  `updated_at` int(11) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8 AUTO_INCREMENT=1 ;

-- --------------------------------------------------------

--
-- Struktura tabele `user`
--

CREATE TABLE IF NOT EXISTS `user` (
`user_id` int(11) NOT NULL,
  `username` varchar(255) DEFAULT NULL,
  `display_name` varchar(255) DEFAULT NULL,
  `email` varchar(255) DEFAULT NULL,
  `password` varchar(128) DEFAULT NULL,
  `state` smallint(4) DEFAULT NULL,
  `created_at` datetime NOT NULL DEFAULT CURRENT_TIMESTAMP,
  `updated_at` datetime NOT NULL DEFAULT CURRENT_TIMESTAMP
) ENGINE=InnoDB  DEFAULT CHARSET=utf8 AUTO_INCREMENT=5 ;

--
-- Odloži podatke za tabelo `user`
--

INSERT INTO `user` (`user_id`, `username`, `display_name`, `email`, `password`, `state`, `created_at`, `updated_at`) VALUES
(1, 'rokm92', NULL, 'nekdo@gmail.com', '$2y$14$qJSoy9FCiQbQY8q2PHMHneqmbs6XhWXJ83JXXpCI2WiYGUa2E.EnK', 1, '2014-07-07 23:28:38', '2014-07-07 23:28:38'),
(2, 'roky994', NULL, 'tugamer@gmail.com', '$2y$14$QNkjsmnKJ3Ic1rU.EG9JI.qD0vFX.Q7rU3ZYt0KWzfYZOmIowAjsu', 1, '2014-07-07 23:29:26', '2014-07-07 23:29:26'),
(4, NULL, 'Rok Mohar', 'rok.mohar@gmail.com', 'googleToLocalUser', 1, '2014-07-08 19:50:29', '2014-07-08 19:50:29');

-- --------------------------------------------------------

--
-- Struktura tabele `user_provider`
--

CREATE TABLE IF NOT EXISTS `user_provider` (
  `user_id` int(11) NOT NULL,
  `provider_id` varchar(50) NOT NULL,
  `provider` varchar(255) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8;

--
-- Odloži podatke za tabelo `user_provider`
--

INSERT INTO `user_provider` (`user_id`, `provider_id`, `provider`) VALUES
(4, '113884234906240529364', 'google');

--
-- Indeksi zavrženih tabel
--

--
-- Indeksi tabele `category`
--
ALTER TABLE `category`
 ADD PRIMARY KEY (`id`), ADD UNIQUE KEY `slug` (`slug`);

--
-- Indeksi tabele `media`
--
ALTER TABLE `media`
 ADD PRIMARY KEY (`id`), ADD UNIQUE KEY `slug` (`slug`), ADD KEY `user_id` (`user_id`), ADD KEY `category_id` (`category_id`);

--
-- Indeksi tabele `media_comment`
--
ALTER TABLE `media_comment`
 ADD PRIMARY KEY (`id`), ADD KEY `media_id` (`media_id`), ADD KEY `user_id` (`user_id`);

--
-- Indeksi tabele `media_response`
--
ALTER TABLE `media_response`
 ADD KEY `media_id` (`media_id`), ADD KEY `user_id` (`user_id`);

--
-- Indeksi tabele `newsletter`
--
ALTER TABLE `newsletter`
 ADD PRIMARY KEY (`id`), ADD KEY `user_id` (`user_id`);

--
-- Indeksi tabele `user`
--
ALTER TABLE `user`
 ADD PRIMARY KEY (`user_id`), ADD UNIQUE KEY `username` (`username`), ADD UNIQUE KEY `email` (`email`);

--
-- Indeksi tabele `user_provider`
--
ALTER TABLE `user_provider`
 ADD PRIMARY KEY (`user_id`,`provider_id`), ADD UNIQUE KEY `provider_id` (`provider_id`,`provider`);

--
-- AUTO_INCREMENT zavrženih tabel
--

--
-- AUTO_INCREMENT tabele `category`
--
ALTER TABLE `category`
MODIFY `id` int(11) NOT NULL AUTO_INCREMENT,AUTO_INCREMENT=11;
--
-- AUTO_INCREMENT tabele `media`
--
ALTER TABLE `media`
MODIFY `id` int(11) NOT NULL AUTO_INCREMENT,AUTO_INCREMENT=7;
--
-- AUTO_INCREMENT tabele `media_comment`
--
ALTER TABLE `media_comment`
MODIFY `id` int(11) NOT NULL AUTO_INCREMENT,AUTO_INCREMENT=6;
--
-- AUTO_INCREMENT tabele `newsletter`
--
ALTER TABLE `newsletter`
MODIFY `id` int(11) NOT NULL AUTO_INCREMENT;
--
-- AUTO_INCREMENT tabele `user`
--
ALTER TABLE `user`
MODIFY `user_id` int(11) NOT NULL AUTO_INCREMENT,AUTO_INCREMENT=5;
--
-- Omejitve tabel za povzetek stanja
--

--
-- Omejitve za tabelo `media`
--
ALTER TABLE `media`
ADD CONSTRAINT `media_ibfk_1` FOREIGN KEY (`user_id`) REFERENCES `user` (`user_id`),
ADD CONSTRAINT `media_ibfk_2` FOREIGN KEY (`category_id`) REFERENCES `category` (`id`);

--
-- Omejitve za tabelo `media_comment`
--
ALTER TABLE `media_comment`
ADD CONSTRAINT `media_comment_ibfk_1` FOREIGN KEY (`media_id`) REFERENCES `media` (`id`),
ADD CONSTRAINT `media_comment_ibfk_2` FOREIGN KEY (`user_id`) REFERENCES `user` (`user_id`);

--
-- Omejitve za tabelo `media_response`
--
ALTER TABLE `media_response`
ADD CONSTRAINT `media_response_ibfk_1` FOREIGN KEY (`media_id`) REFERENCES `media` (`id`),
ADD CONSTRAINT `media_response_ibfk_2` FOREIGN KEY (`user_id`) REFERENCES `user` (`user_id`);

--
-- Omejitve za tabelo `newsletter`
--
ALTER TABLE `newsletter`
ADD CONSTRAINT `newsletter_ibfk_1` FOREIGN KEY (`user_id`) REFERENCES `user` (`user_id`);

--
-- Omejitve za tabelo `user_provider`
--
ALTER TABLE `user_provider`
ADD CONSTRAINT `user_provider_ibfk_1` FOREIGN KEY (`user_id`) REFERENCES `user` (`user_id`);

/*!40101 SET CHARACTER_SET_CLIENT=@OLD_CHARACTER_SET_CLIENT */;
/*!40101 SET CHARACTER_SET_RESULTS=@OLD_CHARACTER_SET_RESULTS */;
/*!40101 SET COLLATION_CONNECTION=@OLD_COLLATION_CONNECTION */;
