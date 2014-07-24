-- phpMyAdmin SQL Dump
-- version 4.2.5
-- http://www.phpmyadmin.net
--
-- Gostitelj: 127.0.0.1:3306
-- Čas nastanka: 24. jul 2014 ob 20.06
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
  `priority` int(11) NOT NULL,
  `created_at` datetime NOT NULL,
  `updated_at` datetime NOT NULL
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
`id` int(11) NOT NULL,
  `slug` varchar(255) NOT NULL,
  `name` varchar(255) NOT NULL,
  `reference` varchar(255) NOT NULL,
  `thumbnail` varchar(255) DEFAULT NULL,
  `user_id` int(11) NOT NULL,
  `category_id` int(11) NOT NULL,
  `height` int(11) DEFAULT NULL,
  `width` int(11) DEFAULT NULL,
  `size` int(11) DEFAULT NULL,
  `content_type` varchar(64) DEFAULT NULL,
  `is_featured` tinyint(1) NOT NULL,
  `state` smallint(4) NOT NULL,
  `delay_at` datetime DEFAULT NULL,
  `created_at` datetime NOT NULL,
  `updated_at` datetime NOT NULL
) ENGINE=InnoDB  DEFAULT CHARSET=utf8 AUTO_INCREMENT=11 ;

--
-- Odloži podatke za tabelo `media`
--

INSERT INTO `media` (`id`, `slug`, `name`, `reference`, `thumbnail`, `user_id`, `category_id`, `height`, `width`, `size`, `content_type`, `is_featured`, `state`, `delay_at`, `created_at`, `updated_at`) VALUES
(1, 'kl7b8xyt', 'Hell yeah, I&#039;m on diet', '/photo/kl7b8xyt_460s.jpg', NULL, 1, 5, 595, 460, 46601, 'image/jpeg', 0, 1, NULL, '2014-07-17 15:29:35', '2014-07-17 15:29:35'),
(2, 'qee8prrm', 'How do you know when you&#039;re middle-aged?', '/photo/qee8prrm_460s.jpg', NULL, 1, 9, 389, 460, 43736, 'image/jpeg', 0, 1, NULL, '2014-07-20 21:56:57', '2014-07-20 21:56:57'),
(3, '3ga4cev7', 'Priorities', '/photo/3ga4cev7_460sa_v1.gif', '/photo/3ga4cev7_460s_v1.jpg', 1, 1, 253, 375, 1598728, 'image/gif', 0, 1, NULL, '2014-07-21 14:33:24', '2014-07-21 14:33:24'),
(6, '0qdsffw7', 'Wait for it... Wait for it... Wait for it...', '/photo/0qdsffw7_460s.jpg', NULL, 12, 3, 677, 460, 55290, 'image/jpeg', 0, 1, NULL, '2014-07-23 23:07:04', '2014-07-23 23:07:04'),
(7, 'snvl4rpg', 'Gamer habits, anyone else?', '/photo/snvl4rpg_460s.jpg', NULL, 12, 9, 247, 460, 25564, 'image/jpeg', 0, 1, NULL, '2014-07-23 23:09:36', '2014-07-23 23:09:36'),
(8, 'w9wx88wg', 'How to keep an idiot busy', '/photo/w9wx88wg_460sa_v1.gif', '/photo/w9wx88wg_460s_v1.jpg', 12, 3, 306, 460, 165152, 'image/gif', 0, 1, NULL, '2014-07-23 23:10:00', '2014-07-23 23:10:00'),
(9, '0h3whn9r', 'Solid snake mittens!', '/photo/0h3whn9r_460sa_v1.gif', '/photo/0h3whn9r_460s_v1.jpg', 12, 4, 131, 342, 882980, 'image/gif', 0, 1, NULL, '2014-07-23 23:12:04', '2014-07-23 23:12:04'),
(10, 'zo8w9jjc', 'Test upload', '/photo/zo8w9jjc_460sa_v1.gif', '/photo/zo8w9jjc_460s_v1.jpg', 12, 2, 131, 342, 882980, 'image/gif', 0, 1, NULL, '2014-07-24 00:53:31', '2014-07-24 00:53:31');

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
) ENGINE=InnoDB  DEFAULT CHARSET=utf8 AUTO_INCREMENT=2 ;

-- --------------------------------------------------------

--
-- Struktura tabele `media_prototype`
--

CREATE TABLE IF NOT EXISTS `media_prototype` (
`id` int(11) NOT NULL,
  `slug` varchar(255) NOT NULL,
  `name` varchar(255) NOT NULL,
  `reference` varchar(255) NOT NULL,
  `height` int(11) DEFAULT NULL,
  `width` int(11) DEFAULT NULL,
  `size` int(11) DEFAULT NULL,
  `content_type` varchar(64) DEFAULT NULL,
  `created_at` datetime NOT NULL,
  `updated_at` datetime NOT NULL
) ENGINE=InnoDB  DEFAULT CHARSET=utf8 AUTO_INCREMENT=41 ;

--
-- Odloži podatke za tabelo `media_prototype`
--

INSERT INTO `media_prototype` (`id`, `slug`, `name`, `reference`, `height`, `width`, `size`, `content_type`, `created_at`, `updated_at`) VALUES
(1, '10-guy', '10 Guy', '/prototype/10_guy.jpg', 400, 400, 28089, 'image/jpeg', '2014-07-23 18:36:07', '2014-07-23 18:36:07'),
(2, 'actual-advice-mallard', 'Actual Advice Mallard', '/prototype/actual_advice_mallard.jpg', 400, 400, 48736, 'image/jpeg', '2014-07-23 18:36:07', '2014-07-23 18:36:07'),
(3, 'all-the-things', 'All the things', '/prototype/all_the_things.jpg', 400, 400, 23229, 'image/jpeg', '2014-07-23 18:36:07', '2014-07-23 18:36:07'),
(4, 'ancient-aliens-guy', 'Ancient Aliens Guy', '/prototype/ancient_aliens_guy.jpg', 400, 400, 31404, 'image/jpeg', '2014-07-23 18:36:07', '2014-07-23 18:36:07'),
(5, 'angry-walter', 'Angry Walter', '/prototype/angry_walter.jpg', 400, 400, 34562, 'image/jpeg', '2014-07-23 18:36:07', '2014-07-23 18:36:07'),
(6, 'annoyed-picard', 'Annoyed Picard', '/prototype/annoyed_picard.jpg', 400, 400, 30977, 'image/jpeg', '2014-07-23 18:36:07', '2014-07-23 18:36:07'),
(7, 'awesome-and-awkward-penguin', 'Awesome and Awkward Penguin', '/prototype/awesome_and_awkward_penguin.jpg', 400, 400, 14209, 'image/jpeg', '2014-07-23 18:36:07', '2014-07-23 18:36:07'),
(8, 'awkward-moment-seal', 'Awkward Moment Seal', '/prototype/awkward_moment_seal.jpg', 400, 400, 41781, 'image/jpeg', '2014-07-23 18:36:07', '2014-07-23 18:36:07'),
(9, 'back-in-my-day', 'Back in my day', '/prototype/back_in_my_day.jpg', 400, 400, 38301, 'image/jpeg', '2014-07-23 18:36:07', '2014-07-23 18:36:07'),
(10, 'bad-guy-boss', 'Bad Guy Boss', '/prototype/bad_guy_boss.jpg', 400, 400, 24613, 'image/jpeg', '2014-07-23 18:36:07', '2014-07-23 18:36:07'),
(11, 'bad-luck-brian', 'Bad Luck Brian', '/prototype/bad_luck_brian.jpg', 400, 400, 33548, 'image/jpeg', '2014-07-23 18:36:07', '2014-07-23 18:36:07'),
(12, 'butthurt-dweller', 'Butthurt Dweller', '/prototype/butthurt_dweller.jpg', 400, 400, 21700, 'image/jpeg', '2014-07-23 18:36:07', '2014-07-23 18:36:07'),
(13, 'buzz-and-woody', 'Buzz and Woody', '/prototype/buzz_and_woody.jpg', 400, 400, 29272, 'image/jpeg', '2014-07-23 18:36:07', '2014-07-23 18:36:07'),
(14, 'captain-picard-facepalm', 'Captain Picard Facepalm', '/prototype/captain_picard_facepalm.jpg', 400, 400, 23957, 'image/jpeg', '2014-07-23 18:36:07', '2014-07-23 18:36:07'),
(15, 'condesending-wonka', 'Condesending Wonka', '/prototype/condesending_wonka.jpg', 400, 400, 33449, 'image/jpeg', '2014-07-23 18:36:07', '2014-07-23 18:36:07'),
(16, 'confession-bear', 'Confession Bear', '/prototype/confession_bear.jpg', 400, 400, 39441, 'image/jpeg', '2014-07-23 18:36:07', '2014-07-23 18:36:07'),
(17, 'confession-kid', 'Confession Kid', '/prototype/confession_kid.jpg', 400, 400, 26058, 'image/jpeg', '2014-07-23 18:36:07', '2014-07-23 18:36:07'),
(18, 'epic-jackie-chan', 'Epic Jackie Chan', '/prototype/epic_jackie_chan.jpg', 400, 400, 42056, 'image/jpeg', '2014-07-23 18:36:07', '2014-07-23 18:36:07'),
(19, 'evil-toddler', 'Evil Toddler', '/prototype/evil_toddler.jpg', 400, 400, 35754, 'image/jpeg', '2014-07-23 18:36:07', '2014-07-23 18:36:07'),
(20, 'first-day-on-the-internet-kid', 'First Day on the Internet Kid', '/prototype/first_day_on_the_internet_kid.jpg', 400, 400, 39429, 'image/jpeg', '2014-07-23 18:36:07', '2014-07-23 18:36:07'),
(21, 'first-world-problem', 'First World Problem', '/prototype/first_world_problem.jpg', 400, 400, 35029, 'image/jpeg', '2014-07-23 18:36:07', '2014-07-23 18:36:07'),
(22, 'good-guy-greg', 'Good Guy Greg', '/prototype/good_guy_greg.jpg', 400, 400, 26309, 'image/jpeg', '2014-07-23 18:36:08', '2014-07-23 18:36:08'),
(23, 'grinds-my-gears', 'Grinds my Gears', '/prototype/grinds_my_gears.jpg', 400, 400, 37465, 'image/jpeg', '2014-07-23 18:36:08', '2014-07-23 18:36:08'),
(24, 'grumpy-cat', 'Grumpy Cat', '/prototype/grumpy_cat.jpg', 400, 400, 26309, 'image/jpeg', '2014-07-23 18:36:08', '2014-07-23 18:36:08'),
(25, 'high-expectation-asian-father', 'High Expectation Asian Father', '/prototype/high_expectation_asian_father.jpg', 400, 400, 14912, 'image/jpeg', '2014-07-23 18:36:08', '2014-07-23 18:36:08'),
(26, 'joker-mind-loss', 'Joker Mind Loss', '/prototype/joker_mind_loss.jpg', 400, 400, 28359, 'image/jpeg', '2014-07-23 18:36:08', '2014-07-23 18:36:08'),
(27, 'lazy-college-senior', 'Lazy College Senior', '/prototype/lazy_college_senior.jpg', 400, 400, 38206, 'image/jpeg', '2014-07-23 18:36:08', '2014-07-23 18:36:08'),
(28, 'matrix-morpheus', 'Matrix Morpheus', '/prototype/matrix_morpheus.jpg', 400, 400, 37022, 'image/jpeg', '2014-07-23 18:36:08', '2014-07-23 18:36:08'),
(29, 'office-space-lumbergh', 'Office Space Lumbergh', '/prototype/office_space_lumbergh.jpg', 400, 400, 29848, 'image/jpeg', '2014-07-23 18:36:08', '2014-07-23 18:36:08'),
(30, 'one-does-not-simply', 'One Does Not Simply', '/prototype/one_does_not_simply.jpg', 400, 400, 32149, 'image/jpeg', '2014-07-23 18:36:08', '2014-07-23 18:36:08'),
(31, 'overly-manly-man', 'Overly Manly Man', '/prototype/overly_manly_man.jpg', 400, 400, 28357, 'image/jpeg', '2014-07-23 18:36:08', '2014-07-23 18:36:08'),
(32, 'philosoraptor', 'Philosoraptor', '/prototype/philosoraptor.jpg', 400, 400, 25568, 'image/jpeg', '2014-07-23 18:36:08', '2014-07-23 18:36:08'),
(33, 'scumbag-steve', 'Scumbag Steve', '/prototype/scumbag_steve.jpg', 400, 400, 30041, 'image/jpeg', '2014-07-23 18:36:08', '2014-07-23 18:36:08'),
(34, 'success-kid', 'Success Kid', '/prototype/success_kid.jpg', 400, 400, 14103, 'image/jpeg', '2014-07-23 18:36:08', '2014-07-23 18:36:08'),
(35, 'sudden-clarity-clearance', 'Sudden Clarity Clearance', '/prototype/sudden_clarity_clearance.jpg', 400, 400, 50530, 'image/jpeg', '2014-07-23 18:36:08', '2014-07-23 18:36:08'),
(36, 'suspicious-fry', 'Suspicious Fry', '/prototype/suspicious_fry.jpg', 400, 400, 24951, 'image/jpeg', '2014-07-23 18:36:08', '2014-07-23 18:36:08'),
(37, 'the-most-interesting-man', 'The Most Interesting Man', '/prototype/the_most_interesting_man.jpg', 400, 400, 37122, 'image/jpeg', '2014-07-23 18:36:08', '2014-07-23 18:36:08'),
(38, 'too-damn-high', 'Too Damn High', '/prototype/too_damn_high.jpg', 400, 400, 32819, 'image/jpeg', '2014-07-23 18:36:08', '2014-07-23 18:36:08'),
(39, 'unhelpful-highschool-teacher', 'Unhelpful Highschool Teacher', '/prototype/unhelpful_highschool_teacher.jpg', 400, 400, 36912, 'image/jpeg', '2014-07-23 18:36:08', '2014-07-23 18:36:08'),
(40, 'unpopular-opinion-puffin', 'Unpopular Opinion Puffin', '/prototype/unpopular_opinion_puffin.jpg', 400, 400, 32664, 'image/jpeg', '2014-07-23 18:36:08', '2014-07-23 18:36:08');

-- --------------------------------------------------------

--
-- Struktura tabele `media_vote`
--

CREATE TABLE IF NOT EXISTS `media_vote` (
`id` int(11) NOT NULL,
  `media_id` int(11) NOT NULL,
  `user_id` int(11) NOT NULL,
  `type` set('up','down') NOT NULL,
  `created_at` datetime NOT NULL,
  `updated_at` datetime NOT NULL
) ENGINE=InnoDB  DEFAULT CHARSET=utf8 AUTO_INCREMENT=7 ;

-- --------------------------------------------------------

--
-- Struktura tabele `user`
--

CREATE TABLE IF NOT EXISTS `user` (
`id` int(11) NOT NULL,
  `username` varchar(255) NOT NULL,
  `email` varchar(255) NOT NULL,
  `password` varchar(255) DEFAULT NULL,
  `state` smallint(4) NOT NULL,
  `created_at` datetime NOT NULL,
  `updated_at` datetime NOT NULL
) ENGINE=InnoDB  DEFAULT CHARSET=utf8 AUTO_INCREMENT=13 ;

--
-- Odloži podatke za tabelo `user`
--

INSERT INTO `user` (`id`, `username`, `email`, `password`, `state`, `created_at`, `updated_at`) VALUES
(1, 'example', 'user@example.org', '$2y$14$bUazSSLOQxWAOkY.DXaqPOlIqVJX/29kOdIcNrUgUkAFsvBVeancq', 1, '2014-07-07 23:28:38', '2014-07-07 23:28:38'),
(12, 'rok.mohar', 'rok.mohar@gmail.com', '$2y$14$P7dQZ1EiuT0IwW.z05HGMePsEnl.XzPi5xboIsMI.LFOtcR/PM7MG', 1, '2014-07-22 19:52:36', '2014-07-24 16:41:13');

-- --------------------------------------------------------

--
-- Struktura tabele `user_confirmation`
--

CREATE TABLE IF NOT EXISTS `user_confirmation` (
`id` int(11) NOT NULL,
  `user_id` int(11) NOT NULL,
  `email` varchar(255) NOT NULL,
  `remote_address` varchar(255) NOT NULL,
  `request_at` datetime NOT NULL,
  `request_token` varchar(255) NOT NULL,
  `confirmed_at` datetime DEFAULT NULL,
  `is_confirmed` tinyint(1) NOT NULL DEFAULT '0',
  `created_at` datetime NOT NULL,
  `updated_at` datetime NOT NULL
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
`id` int(11) NOT NULL,
  `user_id` int(11) NOT NULL,
  `provider` varchar(255) NOT NULL,
  `provider_id` varchar(255) NOT NULL,
  `created_at` datetime NOT NULL,
  `updated_at` datetime NOT NULL
) ENGINE=InnoDB  DEFAULT CHARSET=utf8 AUTO_INCREMENT=19 ;

--
-- Odloži podatke za tabelo `user_oauth`
--

INSERT INTO `user_oauth` (`id`, `user_id`, `provider`, `provider_id`, `created_at`, `updated_at`) VALUES
(16, 12, 'google', '113884234906240529364', '2014-07-24 13:46:15', '2014-07-24 13:46:15'),
(18, 12, 'facebook', '1513677385514321', '2014-07-24 16:41:22', '2014-07-24 16:41:22');

-- --------------------------------------------------------

--
-- Struktura tabele `user_recover`
--

CREATE TABLE IF NOT EXISTS `user_recover` (
`id` int(11) NOT NULL,
  `user_id` int(11) NOT NULL,
  `email` varchar(255) NOT NULL,
  `remote_address` varchar(255) NOT NULL,
  `request_at` datetime NOT NULL,
  `request_token` varchar(255) NOT NULL,
  `recovered_at` datetime DEFAULT NULL,
  `is_recovered` tinyint(1) NOT NULL DEFAULT '0',
  `created_at` datetime NOT NULL,
  `updated_at` datetime NOT NULL
) ENGINE=InnoDB  DEFAULT CHARSET=utf8 AUTO_INCREMENT=3 ;

--
-- Indeksi zavrženih tabel
--

--
-- Indeksi tabele `category`
--
ALTER TABLE `category`
 ADD PRIMARY KEY (`id`), ADD UNIQUE KEY `slug` (`slug`), ADD UNIQUE KEY `name` (`name`);

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
-- Indeksi tabele `media_prototype`
--
ALTER TABLE `media_prototype`
 ADD PRIMARY KEY (`id`), ADD UNIQUE KEY `slug` (`slug`);

--
-- Indeksi tabele `media_vote`
--
ALTER TABLE `media_vote`
 ADD PRIMARY KEY (`id`), ADD KEY `media_id` (`media_id`), ADD KEY `user_id` (`user_id`);

--
-- Indeksi tabele `user`
--
ALTER TABLE `user`
 ADD PRIMARY KEY (`id`), ADD UNIQUE KEY `username` (`username`), ADD UNIQUE KEY `email` (`email`);

--
-- Indeksi tabele `user_confirmation`
--
ALTER TABLE `user_confirmation`
 ADD PRIMARY KEY (`id`), ADD UNIQUE KEY `request_token` (`user_id`,`request_token`), ADD KEY `user_id` (`user_id`);

--
-- Indeksi tabele `user_oauth`
--
ALTER TABLE `user_oauth`
 ADD PRIMARY KEY (`id`), ADD UNIQUE KEY `provider` (`provider`,`provider_id`), ADD KEY `user_id` (`user_id`);

--
-- Indeksi tabele `user_recover`
--
ALTER TABLE `user_recover`
 ADD PRIMARY KEY (`id`), ADD UNIQUE KEY `request_token` (`user_id`,`request_token`), ADD KEY `user_id` (`user_id`);

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
MODIFY `id` int(11) NOT NULL AUTO_INCREMENT,AUTO_INCREMENT=11;
--
-- AUTO_INCREMENT tabele `media_comment`
--
ALTER TABLE `media_comment`
MODIFY `id` int(11) NOT NULL AUTO_INCREMENT,AUTO_INCREMENT=2;
--
-- AUTO_INCREMENT tabele `media_prototype`
--
ALTER TABLE `media_prototype`
MODIFY `id` int(11) NOT NULL AUTO_INCREMENT,AUTO_INCREMENT=41;
--
-- AUTO_INCREMENT tabele `media_vote`
--
ALTER TABLE `media_vote`
MODIFY `id` int(11) NOT NULL AUTO_INCREMENT,AUTO_INCREMENT=7;
--
-- AUTO_INCREMENT tabele `user`
--
ALTER TABLE `user`
MODIFY `id` int(11) NOT NULL AUTO_INCREMENT,AUTO_INCREMENT=13;
--
-- AUTO_INCREMENT tabele `user_confirmation`
--
ALTER TABLE `user_confirmation`
MODIFY `id` int(11) NOT NULL AUTO_INCREMENT,AUTO_INCREMENT=3;
--
-- AUTO_INCREMENT tabele `user_oauth`
--
ALTER TABLE `user_oauth`
MODIFY `id` int(11) NOT NULL AUTO_INCREMENT,AUTO_INCREMENT=19;
--
-- AUTO_INCREMENT tabele `user_recover`
--
ALTER TABLE `user_recover`
MODIFY `id` int(11) NOT NULL AUTO_INCREMENT,AUTO_INCREMENT=3;
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
