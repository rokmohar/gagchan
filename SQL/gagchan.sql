-- phpMyAdmin SQL Dump
-- version 4.2.5
-- http://www.phpmyadmin.net
--
-- Gostitelj: 127.0.0.1:3306
-- Čas nastanka: 17. jul 2014 ob 15.40
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
  `created_at` datetime NOT NULL,
  `updated_at` datetime NOT NULL
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
  `reference` varchar(255) NOT NULL,
  `thumbnail` varchar(255) DEFAULT NULL,
  `user_id` int(11) NOT NULL,
  `category_id` int(11) NOT NULL,
  `width` int(11) DEFAULT NULL,
  `height` int(11) DEFAULT NULL,
  `size` int(11) DEFAULT NULL,
  `content_type` varchar(64) DEFAULT NULL,
  `is_featured` tinyint(1) NOT NULL DEFAULT '0',
  `created_at` datetime NOT NULL,
  `updated_at` datetime NOT NULL
) ENGINE=InnoDB  DEFAULT CHARSET=utf8 AUTO_INCREMENT=26 ;

--
-- Odloži podatke za tabelo `media`
--

INSERT INTO `media` (`id`, `slug`, `name`, `reference`, `thumbnail`, `user_id`, `category_id`, `width`, `height`, `size`, `content_type`, `is_featured`, `created_at`, `updated_at`) VALUES
(25, 'kl7b8xyt', 'Hell yeah, I&#039;m on diet', '/photo/kl7b8xyt_460s.jpg', NULL, 1, 5, 460, 595, 46601, 'image/jpeg', 0, '2014-07-17 15:29:35', '2014-07-17 15:29:35');

-- --------------------------------------------------------

--
-- Struktura tabele `media_comment`
--

CREATE TABLE IF NOT EXISTS `media_comment` (
`id` int(11) NOT NULL,
  `media_id` int(11) NOT NULL,
  `user_id` int(11) NOT NULL,
  `comment` text NOT NULL,
  `created_at` datetime NOT NULL,
  `updated_at` datetime NOT NULL
) ENGINE=InnoDB  DEFAULT CHARSET=utf8 AUTO_INCREMENT=17 ;

-- --------------------------------------------------------

--
-- Struktura tabele `media_vote`
--

CREATE TABLE IF NOT EXISTS `media_vote` (
`id` int(11) NOT NULL,
  `media_id` int(11) NOT NULL,
  `user_id` int(11) DEFAULT NULL,
  `type` set('up','down') NOT NULL,
  `created_at` datetime NOT NULL,
  `updated_at` datetime NOT NULL
) ENGINE=InnoDB  DEFAULT CHARSET=utf8 AUTO_INCREMENT=22 ;

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
  `state` int(11) DEFAULT NULL,
  `created_at` datetime NOT NULL,
  `updated_at` datetime NOT NULL
) ENGINE=InnoDB  DEFAULT CHARSET=utf8 AUTO_INCREMENT=11 ;

--
-- Odloži podatke za tabelo `user`
--

INSERT INTO `user` (`user_id`, `username`, `display_name`, `email`, `password`, `state`, `created_at`, `updated_at`) VALUES
(1, 'rokm92', 'rokm92', 'no.powersupply@gmail.com', '$2y$14$qJSoy9FCiQbQY8q2PHMHneqmbs6XhWXJ83JXXpCI2WiYGUa2E.EnK', NULL, '2014-07-07 23:28:38', '2014-07-07 23:28:38'),
(2, 'roky994', 'roky994', 'tugamer@gmail.com', '$2y$14$QNkjsmnKJ3Ic1rU.EG9JI.qD0vFX.Q7rU3ZYt0KWzfYZOmIowAjsu', NULL, '2014-07-07 23:29:26', '2014-07-07 23:29:26'),
(9, 'rok.mohar', 'rok.mohar', 'rok.mohar@gmail.com', NULL, NULL, '2014-07-13 13:16:10', '2014-07-13 13:16:10'),
(10, 'test', 'test', 'test@example.org', '$2y$14$hM3BsL05EADJQSEZOCzmXeP84CYg/c2DcAP2LzkPALYmHx8.rgjMu', NULL, '2014-07-17 12:56:46', '2014-07-17 12:56:46');

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
(9, '113884234906240529364', 'google'),
(9, '1513677385514321', 'facebook');

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
-- Indeksi tabele `media_vote`
--
ALTER TABLE `media_vote`
 ADD PRIMARY KEY (`id`), ADD KEY `media_id` (`media_id`), ADD KEY `user_id` (`user_id`);

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
MODIFY `id` int(11) NOT NULL AUTO_INCREMENT,AUTO_INCREMENT=26;
--
-- AUTO_INCREMENT tabele `media_comment`
--
ALTER TABLE `media_comment`
MODIFY `id` int(11) NOT NULL AUTO_INCREMENT,AUTO_INCREMENT=17;
--
-- AUTO_INCREMENT tabele `media_vote`
--
ALTER TABLE `media_vote`
MODIFY `id` int(11) NOT NULL AUTO_INCREMENT,AUTO_INCREMENT=22;
--
-- AUTO_INCREMENT tabele `user`
--
ALTER TABLE `user`
MODIFY `user_id` int(11) NOT NULL AUTO_INCREMENT,AUTO_INCREMENT=11;
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
-- Omejitve za tabelo `media_vote`
--
ALTER TABLE `media_vote`
ADD CONSTRAINT `media_vote_ibfk_1` FOREIGN KEY (`media_id`) REFERENCES `media` (`id`),
ADD CONSTRAINT `media_vote_ibfk_2` FOREIGN KEY (`user_id`) REFERENCES `user` (`user_id`);

--
-- Omejitve za tabelo `user_provider`
--
ALTER TABLE `user_provider`
ADD CONSTRAINT `user_provider_ibfk_1` FOREIGN KEY (`user_id`) REFERENCES `user` (`user_id`);

/*!40101 SET CHARACTER_SET_CLIENT=@OLD_CHARACTER_SET_CLIENT */;
/*!40101 SET CHARACTER_SET_RESULTS=@OLD_CHARACTER_SET_RESULTS */;
/*!40101 SET COLLATION_CONNECTION=@OLD_COLLATION_CONNECTION */;
