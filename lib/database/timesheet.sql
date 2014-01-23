-- phpMyAdmin SQL Dump
-- version 4.0.9
-- http://www.phpmyadmin.net
--
-- Host: 127.0.0.1
-- Generation Time: Jan 22, 2014 at 05:09 PM
-- Server version: 5.6.14
-- PHP Version: 5.5.6

SET SQL_MODE = "NO_AUTO_VALUE_ON_ZERO";
SET time_zone = "+00:00";


/*!40101 SET @OLD_CHARACTER_SET_CLIENT=@@CHARACTER_SET_CLIENT */;
/*!40101 SET @OLD_CHARACTER_SET_RESULTS=@@CHARACTER_SET_RESULTS */;
/*!40101 SET @OLD_COLLATION_CONNECTION=@@COLLATION_CONNECTION */;
/*!40101 SET NAMES utf8 */;

--
-- Database: `timesheet`
--

-- --------------------------------------------------------

--
-- Table structure for table `authentication`
--

CREATE TABLE IF NOT EXISTS `authentication` (
  `user_id` int(20) DEFAULT NULL,
  `group_id` int(20) DEFAULT NULL,
  `password` varchar(100) DEFAULT NULL,
  KEY `user_id` (`user_id`),
  KEY `group_id` (`group_id`)
) ENGINE=InnoDB DEFAULT CHARSET=latin1;

--
-- Dumping data for table `authentication`
--

INSERT INTO `authentication` (`user_id`, `group_id`, `password`) VALUES
(8, 2, '0001'),
(17, 1, '0002'),
(12, 1, '0003'),
(11, 1, '0004'),
(14, 1, '0005'),
(5, 2, '0006'),
(2, 2, '0007'),
(20, 2, '0008'),
(4, 2, '0009'),
(16, 1, '0010'),
(3, 2, '0011'),
(5, 1, '0012'),
(20, 2, '0013'),
(12, 2, '0014'),
(4, 2, '0015'),
(19, 2, '0016'),
(8, 2, '0017'),
(4, 2, '0018'),
(17, 1, '0019'),
(4, 1, '0020');

-- --------------------------------------------------------

--
-- Table structure for table `groups`
--

CREATE TABLE IF NOT EXISTS `groups` (
  `group_id` int(20) NOT NULL AUTO_INCREMENT,
  `group_name` varchar(100) DEFAULT NULL,
  PRIMARY KEY (`group_id`)
) ENGINE=InnoDB  DEFAULT CHARSET=latin1 AUTO_INCREMENT=3 ;

--
-- Dumping data for table `groups`
--

INSERT INTO `groups` (`group_id`, `group_name`) VALUES
(1, 'employee'),
(2, 'employee');

-- --------------------------------------------------------

--
-- Table structure for table `notification`
--

CREATE TABLE IF NOT EXISTS `notification` (
  `notification_id` int(20) NOT NULL AUTO_INCREMENT,
  `notification_body` varchar(255) DEFAULT NULL,
  `notification_priority` int(1) DEFAULT NULL,
  `notification_read` int(1) DEFAULT NULL,
  PRIMARY KEY (`notification_id`)
) ENGINE=InnoDB  DEFAULT CHARSET=latin1 AUTO_INCREMENT=52 ;

--
-- Dumping data for table `notification`
--

INSERT INTO `notification` (`notification_id`, `notification_body`, `notification_priority`, `notification_read`) VALUES
(1, 'Archer has the less than masculine codename of "Duchess" (taken from his mother''s beloved Afghan wolfhound, ', 1, 1),
(2, ' child, going so far as to have "Seamus" tattooed on his back in recognition of that affection.  Additionally, ', 2, 0),
(3, 'unknown major. Woodhouse is present, also implying he is a better parent to Sterling than Malory who was not present. ', 0, 1),
(4, 'As a result of this long classical education and friendlessness, Archer is surprisingly well-read.', 2, 1),
(5, 'overthrew Guatemala''s government in 1954, making his birth year around 1948). He is a member of spy ', 2, 0),
(6, 'overthrew Guatemala''s government in 1954, making his birth year around 1948). He is a member of spy ', 1, 0),
(7, 'He spent up to fifteen years at boarding school, despite American schooling taking thirteen years. His hobby was ', 2, 0),
(8, 'Archer has the less than masculine codename of "Duchess" (taken from his mother''s beloved Afghan wolfhound, ', 2, 1),
(9, 'we should do this.', 1, 0),
(10, 'he was growing up by Malory in The Double Deuce (Malory denies Seamus a toy, saying, "Did somebody trick ', 0, 1),
(11, 'ground. The brave men, living and dead, who struggled here, have consecrated it, far above ', 1, 0),
(12, 'Anne Litzenberger. Sterling''s memories culminate in remembering his sixth birthday when his real father gave him ', 0, 0),
(13, 'Archer is not completely devoid of a sensitive side however, as seen in Stage Two, when he believes that he may di', 2, 0),
(14, 'Anne Litzenberger. Sterling''s memories culminate in remembering his sixth birthday when his real father gave him ', 2, 1),
(15, 'even more heart warming in hindsight after the second season reveal that alligators are one of Archer''s three biggest ', 0, 1),
(16, 'is always because he will somehow benefit. He does, however, insist upon compensating anyone from whom he commandeers ', 1, 1),
(17, 'He spent up to fifteen years at boarding school, despite American schooling taking thirteen years. His hobby was ', 2, 0),
(18, 'added to the list of possible fathers was an unnamed young Italian man who was gunned down in the ', 0, 0),
(19, 'a stuffed alligator.  He, unfortunately, awakens before remembering his father''s face.', 1, 1),
(20, 'crying over the death of his slain rooster. The next time we see Archer, he is covered in dirt and carrying a shovel, ', 2, 1),
(21, 'with the wee baby Seamus over the course of the episode as he considers him the closest that he will ever get to having a', 2, 1),
(22, 'he was growing up by Malory in The Double Deuce (Malory denies Seamus a toy, saying, "Did somebody trick ', 2, 1),
(23, 'and "three pounds of glass" in his feet. When he was finally cornered in an elevator, he blindfolded himself and fu', 1, 1),
(24, 'Four score and seven years ago our fathers brought forth on this continent, a new nation, ', 0, 1),
(25, 'for the Johns Hopkins lacrosse team, as well as being stalked and subsequently shot by a mysterious woman, Ruth ', 1, 1),
(26, 'and "three pounds of glass" in his feet. When he was finally cornered in an elevator, he blindfolded himself and fu', 0, 1),
(27, 'added to the list of possible fathers was an unnamed young Italian man who was gunned down in the ', 2, 1),
(28, 'finds himself in a bar that hosts chicken-fighting matches. A big, weeping Dominican man is sitting next to him, ', 2, 0),
(29, 'lly intended his last words to be "F*** you, you douchebags."', 1, 0),
(30, 'Anne Litzenberger. Sterling''s memories culminate in remembering his sixth birthday when his real father gave him ', 0, 0),
(31, 'lacrosse, although flashbacks have indicated he had few friends. A picture of Archer in Placebo Effect shows Archer ', 0, 1),
(32, 'agency "ISIS," located in New York City. ', 2, 0),
(33, 'ive with a fairly high degree of personal bravery, as shown during his escape from Moscow when he consistently ou', 1, 1),
(34, 'Cheryl bunches of roses and later stating to Lana Kane that he still loves her (also in the season 4 finale he gives', 0, 0),
(35, 'graduating from Georgetown University, implying he is at least smart enough to receive a bachelors degree in an ', 2, 1),
(36, 'His relation with his mother Malory—who is also his boss at ISIS—is often strained, never sympathetic, ', 2, 1),
(37, 'dedicated here to the unfinished work which they who fought here have thus far so nobly ', 2, 1),
(38, ' from breast cancer, he demonstrates considerable regret at his treatment of his co-workers at ISIS, buying Pam and ', 2, 0),
(39, 'streets of Italy and had "blue eyes, full lips and thick wavy hair".[1]', 1, 0),
(40, 'streets of Italy and had "blue eyes, full lips and thick wavy hair".[1]', 2, 1),
(41, 'you, hmm? See, that''s how the world works dear, and I''m the only one you can trust.") making Archer ', 2, 0),
(42, 'and mentions that he spent all night helping a giant Domnican guy bury his rooster in the everglades, This becomes ', 1, 1),
(43, 'we should do this.', 0, 1),
(44, 'and sometimes bluntly abusive. It is implied that Archer was exposed to "negative reinforcement" when ', 0, 1),
(45, 'But, in a larger sense, we can not dedicate we can not consecrate we can not hallow this ', 2, 0),
(46, ' from breast cancer, he demonstrates considerable regret at his treatment of his co-workers at ISIS, buying Pam and ', 1, 1),
(47, 'equipment or goods, although he does not always trade to them items they want or need.', 2, 1),
(48, 'But, in a larger sense, we can not dedicate we can not consecrate we can not hallow this ', 1, 1),
(49, 'unknown major. Woodhouse is present, also implying he is a better parent to Sterling than Malory who was not present. ', 0, 0),
(50, 'As a result of this long classical education and friendlessness, Archer is surprisingly well-read.', 2, 1),
(51, 'Sup Brah. How''s it hanging?', 1, 0);

-- --------------------------------------------------------

--
-- Table structure for table `project`
--

CREATE TABLE IF NOT EXISTS `project` (
  `project_id` int(20) NOT NULL AUTO_INCREMENT,
  `project_name` varchar(100) DEFAULT NULL,
  `project_about` varchar(100) DEFAULT NULL,
  `project_description` varchar(255) DEFAULT NULL,
  `project_status` int(1) DEFAULT NULL,
  `project_time_alloted` datetime DEFAULT NULL,
  `project_created_date` datetime DEFAULT NULL,
  `project_manager_id` int(20) DEFAULT NULL,
  `project_salary` double DEFAULT NULL,
  PRIMARY KEY (`project_id`),
  KEY `project_manager_id` (`project_manager_id`)
) ENGINE=InnoDB  DEFAULT CHARSET=latin1 AUTO_INCREMENT=31 ;

--
-- Dumping data for table `project`
--

INSERT INTO `project` (`project_id`, `project_name`, `project_about`, `project_description`, `project_status`, `project_time_alloted`, `project_created_date`, `project_manager_id`, `project_salary`) VALUES
(1, 'Mechanical Design Technician', 'Research and Development', 'ground. The brave men, living and dead, who struggled here, have consecrated it, far above ', 1, '2014-02-15 04:39:42', '2013-10-17 09:38:18', 5, 181055),
(2, 'Medical Affairs Head', 'Accounts Payable', 'government of the people, by the people, for the people, shall not perish from the earth.', 0, '2014-04-09 11:20:42', '2013-11-11 07:43:10', 1, 288310),
(3, 'Banking Safe Deposit Clerk', 'Maintenance', 'Four score and seven years ago our fathers brought forth on this continent, a new nation, ', 3, '2014-03-28 18:32:47', '2013-12-26 00:26:16', 2, 169113),
(4, 'Insurance & Senior Benefits Clerk', 'Quality Assurance', 'twitted and outfought the numerous soldiers dispatched to recapture him despite never having a functional firearm ', 1, '2014-02-22 05:02:28', '2013-12-07 07:21:45', 17, 330055),
(5, 'Personal Banker', 'Marketing', 'that from these honored dead we take increased devotion to that cause for which they gave ', 0, '2014-01-19 21:37:00', '2013-12-28 07:49:36', 19, 152326),
(6, 'Director Pastoral Services', 'Research and Development', ' child, going so far as to have "Seamus" tattooed on his back in recognition of that affection.  Additionally, ', 0, '2014-04-12 00:54:09', '2013-10-16 09:41:43', 12, 19289),
(7, 'Banking Loan Officer Mortgage', 'Production', 'even more heart warming in hindsight after the second season reveal that alligators are one of Archer''s three biggest ', 3, '2014-02-05 12:41:50', '2013-12-11 05:37:45', 9, 231741),
(8, 'Tax Supervisor', 'Marketing', 'over-dependent on his mother. Archer believed for most of his life that his father was a deceased, ', 2, '2014-04-03 04:47:49', '2013-10-21 08:51:05', 14, 203855),
(9, 'Bowling Alley Manager', 'Quality Assurance', 'and sometimes bluntly abusive. It is implied that Archer was exposed to "negative reinforcement" when ', 2, '2014-04-17 13:19:26', '2013-12-18 00:24:43', 18, 434822),
(10, 'Manager Assistant Retail Store (Revenue)', 'Maintenance', ' Lana the last set of scuba gear and tells her he loves her before drowning to be rescucitated). Archer also bonds ', 0, '2014-03-18 02:33:12', '2014-01-17 03:57:19', 5, 270167),
(11, 'Top Professional Services Executive Medical', 'Maintenance', 'even more heart warming in hindsight after the second season reveal that alligators are one of Archer''s three biggest ', 3, '2014-03-30 06:14:36', '2013-11-09 23:59:01', 4, 434762),
(12, 'Operator Folding Machine', 'Human Resources', 'for the Johns Hopkins lacrosse team, as well as being stalked and subsequently shot by a mysterious woman, Ruth ', 3, '2014-02-14 18:27:40', '2013-12-28 15:37:28', 10, 357525),
(13, 'HRIS Manager', 'Publications', 'alone, while his mother assisted in overthrowing the government of Guatemala (in reality the CIA ', 0, '2014-01-20 17:54:47', '2013-12-13 05:53:42', 6, 267798),
(14, 'Medical Nephrologist', 'Administration', 'have died in vain that this nation, under God, shall have a new birth of freedom and that ', 3, '2014-02-12 05:46:16', '2013-11-24 06:28:06', 16, 79428),
(15, 'Ticket Taker', 'Production', 'Archer is not completely devoid of a sensitive side however, as seen in Stage Two, when he believes that he may di', 1, '2014-02-17 09:00:07', '2013-12-08 05:56:21', 20, 52520),
(16, 'Engineering Assistant Mechanical', 'Research and Development', 'Four score and seven years ago our fathers brought forth on this continent, a new nation, ', 1, '2014-03-31 01:11:40', '2013-12-10 17:35:20', 2, 238887),
(17, 'Transportation Top Officer', 'Sales', 'His relation with his mother Malory—who is also his boss at ISIS—is often strained, never sympathetic, ', 0, '2014-03-12 04:53:21', '2013-12-27 14:39:06', 14, 208184),
(18, 'Technician Physical Therapy', 'Publications', 'His relation with his mother Malory—who is also his boss at ISIS—is often strained, never sympathetic, ', 0, '2014-04-17 15:24:15', '2013-12-09 17:04:47', 16, 52733),
(19, 'Vice President Real Estate', 'Human Resources', 'he establishes a friendship with a fellow cancer patient, Ruth. Another example of this is in Honeypot when Archer ', 0, '2014-02-06 10:09:55', '2013-11-26 17:48:35', 17, 176028),
(20, 'Operator Power Plant', 'Administration', 'and "three pounds of glass" in his feet. When he was finally cornered in an elevator, he blindfolded himself and fu', 0, '2014-01-28 19:32:00', '2013-11-14 12:31:37', 5, 363936),
(21, 'Scientist Animal', 'Administration', 'and sometimes bluntly abusive. It is implied that Archer was exposed to "negative reinforcement" when ', 3, '2014-02-23 19:07:55', '2013-11-30 12:55:58', 19, 134580),
(22, 'Contract Coordinator', 'Research and Development', 'According to the episode, "Once Bitten" Sterling Archer was age six and celebrated his birthday ', 2, '2014-04-04 03:40:35', '2013-11-13 19:30:32', 12, 366912),
(23, 'Project Engineer', 'Sales', 'Now we are engaged in a great civil war, testing whether that nation, or any nation so ', 3, '2014-02-05 02:18:05', '2013-11-04 01:47:00', 20, 219973),
(24, 'Product Design Analyst', 'Facilities', 'is always because he will somehow benefit. He does, however, insist upon compensating anyone from whom he commandeers ', 3, '2014-02-01 11:23:20', '2013-12-04 06:05:45', 10, 320839),
(25, 'Planner Special Meetings', 'Executive', 'he establishes a friendship with a fellow cancer patient, Ruth. Another example of this is in Honeypot when Archer ', 2, '2014-03-29 12:53:48', '2013-11-29 06:51:53', 5, 245257),
(26, 'Drafter Civil', 'Quality Assurance', 'and sometimes bluntly abusive. It is implied that Archer was exposed to "negative reinforcement" when ', 0, '2014-04-11 06:11:12', '2013-11-14 05:21:03', 10, 270967),
(27, 'Materials Director', 'Human Resources', 'He spent up to fifteen years at boarding school, despite American schooling taking thirteen years. His hobby was ', 1, '2014-03-07 05:21:07', '2013-11-25 15:55:25', 1, 417712),
(28, 'Porcelain Buildup Assistant', 'Executive', 'finds himself in a bar that hosts chicken-fighting matches. A big, weeping Dominican man is sitting next to him, ', 3, '2014-03-22 02:02:49', '2013-11-29 11:49:41', 4, 266934),
(29, 'Building Superintendent', 'Purchasing', 'Cheryl bunches of roses and later stating to Lana Kane that he still loves her (also in the season 4 finale he gives', 0, '2014-02-21 13:48:46', '2013-12-16 22:26:54', 4, 60160),
(30, 'Concrete Finisher', 'Quality Assurance', 'He spent up to fifteen years at boarding school, despite American schooling taking thirteen years. His hobby was ', 2, '2014-02-06 01:54:29', '2013-10-14 22:04:29', 11, 82074);

-- --------------------------------------------------------

--
-- Table structure for table `project_timesheet`
--

CREATE TABLE IF NOT EXISTS `project_timesheet` (
  `project_id` int(20) DEFAULT NULL,
  `timesheet_id` int(20) DEFAULT NULL,
  KEY `timesheet_id` (`timesheet_id`),
  KEY `project_id` (`project_id`)
) ENGINE=InnoDB DEFAULT CHARSET=latin1;

--
-- Dumping data for table `project_timesheet`
--

INSERT INTO `project_timesheet` (`project_id`, `timesheet_id`) VALUES
(23, 1),
(26, 2),
(11, 3),
(5, 4),
(26, 5),
(29, 6),
(5, 7),
(20, 8),
(30, 9),
(4, 10),
(18, 11),
(17, 12),
(24, 13),
(24, 14),
(27, 15),
(10, 16),
(12, 17),
(2, 18),
(24, 19),
(17, 20),
(13, 21),
(13, 22),
(6, 23),
(21, 24),
(8, 25),
(23, 26),
(30, 27),
(29, 28),
(28, 29),
(5, 30),
(26, 31),
(7, 32),
(18, 33),
(21, 34),
(17, 35),
(1, 36),
(30, 37),
(21, 38),
(19, 39),
(3, 40),
(2, 41),
(27, 42),
(17, 43),
(14, 44),
(14, 45),
(14, 46),
(18, 47),
(24, 48),
(30, 49),
(30, 50),
(1, 51),
(15, 52),
(27, 53),
(26, 54),
(6, 55),
(18, 56),
(25, 57),
(12, 58),
(28, 59),
(27, 60),
(22, 61),
(25, 62),
(8, 63),
(11, 64),
(22, 65),
(12, 66),
(3, 67),
(8, 68),
(13, 69),
(8, 70),
(19, 71),
(2, 72),
(19, 73),
(19, 74),
(20, 75),
(5, 76),
(13, 77),
(16, 78),
(26, 79),
(20, 80);

-- --------------------------------------------------------

--
-- Table structure for table `timesheet`
--

CREATE TABLE IF NOT EXISTS `timesheet` (
  `timesheet_id` int(20) NOT NULL AUTO_INCREMENT,
  `timesheet_work_time` double DEFAULT NULL,
  `timesheet_start_time` datetime DEFAULT NULL,
  `timesheet_end_time` datetime DEFAULT NULL,
  `timesheet_mark_time` datetime DEFAULT NULL,
  `timesheet_location` varchar(255) DEFAULT NULL,
  `timesheet_task` varchar(100) DEFAULT NULL,
  `timesheet_project_name` varchar(100) DEFAULT NULL,
  `timesheet_description` varchar(255) DEFAULT NULL,
  PRIMARY KEY (`timesheet_id`)
) ENGINE=InnoDB  DEFAULT CHARSET=latin1 AUTO_INCREMENT=81 ;

--
-- Dumping data for table `timesheet`
--

INSERT INTO `timesheet` (`timesheet_id`, `timesheet_work_time`, `timesheet_start_time`, `timesheet_end_time`, `timesheet_mark_time`, `timesheet_location`, `timesheet_task`, `timesheet_project_name`, `timesheet_description`) VALUES
(1, 13, '2014-03-16 09:06:11', '2014-09-06 22:34:15', '2014-04-22 13:51:48', 'Ball  Ave 469', 'Undertaker', 'Operator Power Plant', 'Now we are engaged in a great civil war, testing whether that nation, or any nation so '),
(2, 22, '2014-02-20 12:18:21', '2014-10-19 20:38:35', '2014-04-10 08:05:29', 'JAZMINERO 314', 'Specialist', 'Personal Banker', 'As a result of this long classical education and friendlessness, Archer is surprisingly well-read.'),
(3, 24, '2014-03-06 18:00:29', '2014-08-01 03:18:11', '2014-03-07 13:57:21', 'Boys Orphanage 416', 'Custodian', 'Product Design Analyst', 'streets of Italy and had "blue eyes, full lips and thick wavy hair".[1]'),
(4, 1, '2014-03-03 20:42:02', '2014-10-24 16:43:24', '2014-05-02 15:17:27', 'OLVIDO, TRAVESIA 120', 'Cardiologist', 'Ticket Taker', 'and mentions that he spent all night helping a giant Domnican guy bury his rooster in the everglades, This becomes '),
(5, 11, '2014-03-05 07:05:02', '2014-04-02 01:54:49', '2014-05-18 00:11:57', 'MAYOR DE SANTA MARINA 81', 'Trademark attorney', 'Scientist Animal', ' We have come to dedicate a portion of that field, as a final resting place for those who '),
(6, 21, '2014-03-10 16:36:10', '2014-06-01 03:54:33', '2014-05-28 07:32:24', 'Irene Mews 78', 'Webmaster', 'Medical Nephrologist', 'anyone who crosses him (or even sometimes merely crosses his path), he is also undeniably an intuitively good operat'),
(7, 19, '2014-03-18 16:40:32', '2015-01-06 13:42:30', '2014-05-29 11:55:00', 'SAN MARTIN DE VALDEIGLESIAS, KMS. 4,8CARRETERA 00 136', 'Expressman', 'Insurance & Senior Benefits Clerk', 'alone, while his mother assisted in overthrowing the government of Guatemala (in reality the CIA '),
(8, 2, '2014-02-09 01:48:56', '2015-01-16 13:22:32', '2014-01-30 18:00:47', 'Glacierspring Dr 332', 'Courier', 'Materials Director', 'our poor power to add or detract. The world will little note, nor long remember what we say '),
(9, 12, '2014-02-20 12:23:07', '2014-07-17 15:28:37', '2014-07-17 08:48:12', 'JOSEP TAPIOLAS 212', 'Numerologist', 'Top Professional Services Executive Medical', 'overthrew Guatemala''s government in 1954, making his birth year around 1948). He is a member of spy '),
(10, 26, '2014-02-22 20:02:25', '2015-02-08 19:30:16', '2014-05-17 20:32:34', 'Derwent Road 445', 'Gynecologist', 'Product Design Analyst', 'dedicated here to the unfinished work which they who fought here have thus far so nobly '),
(11, 16, '2014-03-02 21:36:30', '2015-01-31 09:44:47', '2014-02-22 18:03:01', 'GOLONDRINA, LA 187', 'Transit planner', 'Medical Nephrologist', ''),
(12, 12, '2014-03-06 03:41:28', '2015-02-09 00:41:38', '2014-04-02 22:09:10', 'HUERTAS ALTAS 152', 'Financier', 'Director Pastoral Services', ' Lana the last set of scuba gear and tells her he loves her before drowning to be rescucitated). Archer also bonds '),
(13, 20, '2014-03-05 19:33:34', '2014-12-07 04:32:20', '2014-02-11 10:58:26', 'FERRER DALMAU 114', 'Fraudster', 'Materials Director', 'may be KGB head Major Nikolai Jakov, ODIN director Len Trexler, or jazz drummer Buddy Rich. Later '),
(14, 5, '2014-01-28 00:51:31', '2015-01-09 17:07:43', '2014-07-01 06:05:33', 'Diego Way 205', 'Car designer', 'Operator Folding Machine', 'agency "ISIS," located in New York City. '),
(15, 25, '2014-02-13 14:40:57', '2015-01-08 07:43:42', '2014-04-15 22:48:04', 'Heidelberger Str. 185', 'Chef', 'Porcelain Buildup Assistant', 'crying over the death of his slain rooster. The next time we see Archer, he is covered in dirt and carrying a shovel, '),
(16, 19, '2014-02-01 16:40:34', '2014-05-20 17:37:52', '2014-07-13 02:34:07', 'Buckland  Ave 377', 'Sexologist', 'Product Design Analyst', 'for the Johns Hopkins lacrosse team, as well as being stalked and subsequently shot by a mysterious woman, Ruth '),
(17, 14, '2014-03-19 10:47:02', '2014-09-27 18:52:39', '2014-06-04 16:14:43', 'Trebeck Street 280', 'Model', 'Transportation Top Officer', 'our poor power to add or detract. The world will little note, nor long remember what we say '),
(18, 29, '2014-03-09 08:06:26', '2014-11-19 20:24:39', '2014-04-05 21:46:47', 'Willow Brook Grove 126', 'Manufacturer', 'Project Engineer', 'ground. The brave men, living and dead, who struggled here, have consecrated it, far above '),
(19, 12, '2014-01-24 12:33:41', '2014-12-12 21:39:44', '2014-02-19 01:07:05', 'Waveney Close 296', 'Mountaineer', 'Engineering Assistant Mechanical', 'here gave their lives that that nation might live. It is altogether fitting and proper that '),
(20, 12, '2014-01-21 13:19:29', '2014-09-19 13:24:22', '2014-07-25 08:24:59', 'The Towers 347', 'Scribe', 'Vice President Real Estate', 'over-dependent on his mother. Archer believed for most of his life that his father was a deceased, '),
(21, 7, '2014-02-05 21:23:44', '2014-11-26 19:09:31', '2014-03-16 13:27:09', 'Ramp  Rd 428', 'Manager', 'Banking Safe Deposit Clerk', ' from breast cancer, he demonstrates considerable regret at his treatment of his co-workers at ISIS, buying Pam and '),
(22, 21, '2014-02-17 01:20:50', '2014-06-26 13:29:30', '2014-06-21 03:27:12', 'FEDERICO GARCIA LORCA, AVENIDA 168', 'Pharmacist', 'Insurance & Senior Benefits Clerk', 'we should do this.'),
(23, 7, '2014-01-21 20:21:51', '2014-04-30 06:51:49', '2014-07-12 07:28:46', 'MARIA LLACER 438', 'Agent', 'Technician Physical Therapy', 'Archer is first and foremost completely focused on himself, his needs and desires. If he aids another person, it '),
(24, 5, '2014-02-03 03:30:49', '2014-03-23 14:34:27', '2014-05-08 18:51:51', 'Lockwoods Cottages 292', 'Coachman', 'HRIS Manager', 'Although he has numerous personality flaws, such as insensitivity, egotism, and a casual attitude towards murdering '),
(25, 23, '2014-02-16 04:22:35', '2014-10-08 18:51:51', '2014-02-23 01:16:38', 'ACHETA, CAMINO 400', 'Fishmonger', 'Banking Loan Officer Mortgage', ''),
(26, 29, '2014-03-02 12:37:10', '2014-05-20 11:02:58', '2014-07-24 02:48:13', 'SANCHO 183', 'Music Director', 'Transportation Top Officer', 'unknown major. Woodhouse is present, also implying he is a better parent to Sterling than Malory who was not present. '),
(27, 10, '2014-01-30 02:09:39', '2014-04-08 13:32:40', '2014-03-31 21:01:31', 'Claigmar Gardens 66', 'Cryptographer', 'Manager Assistant Retail Store (Revenue)', 'our poor power to add or detract. The world will little note, nor long remember what we say '),
(28, 10, '2014-01-30 01:11:51', '2014-06-14 13:43:41', '2014-06-16 11:51:22', 'Salisbury Close 133', 'Mortgage banker', 'Building Superintendent', 'agency "ISIS," located in New York City. '),
(29, 2, '2014-02-25 22:32:47', '2014-10-11 17:07:59', '2014-02-10 20:31:51', 'ANTONI MARQUES 95', 'Contract Manager', 'HRIS Manager', 'twitted and outfought the numerous soldiers dispatched to recapture him despite never having a functional firearm '),
(30, 4, '2014-03-05 10:25:39', '2014-09-17 04:38:51', '2014-07-24 12:07:02', 'EPILANO 455', 'Negotiator', 'Transportation Top Officer', 'here gave their lives that that nation might live. It is altogether fitting and proper that '),
(31, 26, '2014-02-01 07:02:41', '2014-07-31 10:45:00', '2014-07-25 11:03:05', 'Badlis Road 462', 'Shepherd', 'Drafter Civil', 'overthrew Guatemala''s government in 1954, making his birth year around 1948). He is a member of spy '),
(32, 14, '2014-02-08 20:33:28', '2014-05-13 13:42:39', '2014-05-16 05:10:17', 'HONTALVILLA, PLAZA 146', 'Investment broker', 'Contract Coordinator', 'and mentions that he spent all night helping a giant Domnican guy bury his rooster in the everglades, This becomes '),
(33, 12, '2014-01-24 13:12:19', '2014-05-07 07:53:29', '2014-03-01 16:25:20', 'Valley  Glen 173', 'Dog walker', 'Scientist Animal', 'Although he has numerous personality flaws, such as insensitivity, egotism, and a casual attitude towards murdering '),
(34, 8, '2014-03-15 09:29:13', '2015-01-17 00:16:35', '2014-06-17 05:27:16', 'Kingsley Place 26', 'Coachman', 'Tax Supervisor', 'crying over the death of his slain rooster. The next time we see Archer, he is covered in dirt and carrying a shovel, '),
(35, 19, '2014-03-14 01:32:04', '2014-11-26 11:01:37', '2014-05-09 09:06:43', 'Trevelyan Road 103', 'Bodybuilder', 'Building Superintendent', ' child, going so far as to have "Seamus" tattooed on his back in recognition of that affection.  Additionally, '),
(36, 5, '2014-02-05 15:17:22', '2014-09-19 07:12:27', '2014-01-23 09:01:52', 'VISTABELLA 10', 'Janitor', 'Operator Folding Machine', 'that from these honored dead we take increased devotion to that cause for which they gave '),
(37, 3, '2014-02-22 13:58:46', '2014-05-23 08:38:47', '2014-05-03 19:03:23', 'Stanford  St 400', 'Dietician', 'Banking Safe Deposit Clerk', 'conceived and so dedicated, can long endure. We are met on a great battle-field of that war.'),
(38, 27, '2014-02-27 21:59:26', '2014-12-30 19:58:03', '2014-07-21 21:29:47', 'CHILCHES 398', 'Mechanician', 'Operator Power Plant', 'government of the people, by the people, for the people, shall not perish from the earth.'),
(39, 13, '2014-01-21 03:03:10', '2014-12-20 16:11:14', '2014-06-29 09:58:55', 'Montpelier Road 270', 'Management consultant', 'Vice President Real Estate', 'anyone who crosses him (or even sometimes merely crosses his path), he is also undeniably an intuitively good operat'),
(40, 7, '2014-03-04 22:46:52', '2014-11-22 01:35:45', '2014-03-24 09:30:01', 'Salisbury  p 374', 'Lamplighter', 'Medical Affairs Head', 'overthrew Guatemala''s government in 1954, making his birth year around 1948). He is a member of spy '),
(41, 19, '2014-02-09 22:37:22', '2015-02-09 22:19:16', '2014-05-23 14:25:19', 'Camborne Mews 129', 'Wrangler', 'Bowling Alley Manager', 'streets of Italy and had "blue eyes, full lips and thick wavy hair".[1]'),
(42, 24, '2014-03-20 10:08:13', '2014-06-30 06:21:01', '2014-06-01 05:19:03', 'Lakefork Dr 329', 'Photographer', 'Medical Affairs Head', 'Cheryl bunches of roses and later stating to Lana Kane that he still loves her (also in the season 4 finale he gives'),
(43, 20, '2014-02-05 17:14:07', '2014-09-20 18:33:16', '2014-03-20 15:43:35', 'Drury Lane 204', 'Archaeologist', 'Vice President Real Estate', ''),
(44, 28, '2014-01-18 18:56:00', '2014-06-04 00:55:54', '2014-06-07 17:56:24', 'Peter Street 240', 'Mountaineer', 'Director Pastoral Services', 'streets of Italy and had "blue eyes, full lips and thick wavy hair".[1]'),
(45, 16, '2014-03-18 19:31:06', '2014-06-04 07:30:05', '2014-05-05 18:06:34', 'INCURNIA, TRAVESIA 29', 'Public Relations Officer', 'Director Pastoral Services', 'though Malory Archer denies this) and used to have an on-again, off-again relationship with fellow agent Lana '),
(46, 7, '2014-02-04 11:40:43', '2014-09-25 19:01:52', '2014-04-12 02:19:34', 'Bavaria Road 49', 'Press officer', 'Scientist Animal', ''),
(47, 23, '2014-02-14 13:48:56', '2014-04-28 22:03:28', '2014-04-23 21:08:02', 'Lange Lozanastraat 252', 'Hosier', 'Building Superintendent', 'Archer has the less than masculine codename of "Duchess" (taken from his mother''s beloved Afghan wolfhound, '),
(48, 9, '2014-02-22 09:22:07', '2014-06-10 18:56:23', '2014-01-31 17:45:12', 'Occupation Lane 38', 'Art director', 'Top Professional Services Executive Medical', 'Four score and seven years ago our fathers brought forth on this continent, a new nation, '),
(49, 22, '2014-03-08 21:38:06', '2014-06-14 22:28:20', '2014-03-06 12:01:01', 'Lone Tree Ln 309', 'Gamekeeper', 'Operator Power Plant', 'He spent up to fifteen years at boarding school, despite American schooling taking thirteen years. His hobby was '),
(50, 6, '2014-02-11 22:13:54', '2014-09-22 01:40:01', '2014-03-12 13:37:47', 'Noble  Rd 359', 'Transit planner', 'Materials Director', 'the last full measure of devotion  that we here highly resolve that these dead shall not '),
(51, 18, '2014-03-11 19:50:18', '2014-05-10 17:33:17', '2014-02-26 14:45:15', 'Roderick Road 39', 'CFO', 'Porcelain Buildup Assistant', 'he establishes a friendship with a fellow cancer patient, Ruth. Another example of this is in Honeypot when Archer '),
(52, 4, '2014-02-02 06:46:57', '2014-06-25 22:53:15', '2014-02-16 11:40:44', 'Nahuatl Dr 432', 'Flight instructor', 'Director Pastoral Services', 'may be KGB head Major Nikolai Jakov, ODIN director Len Trexler, or jazz drummer Buddy Rich. Later '),
(53, 26, '2014-01-19 00:41:12', '2014-09-05 06:25:06', '2014-05-04 16:17:10', 'Cold Blow Road 299', 'Camp Counselor', 'Drafter Civil', 'anyone who crosses him (or even sometimes merely crosses his path), he is also undeniably an intuitively good operat'),
(54, 29, '2014-03-17 22:06:15', '2014-10-28 00:36:35', '2014-07-12 10:04:16', 'CATABOY 211', 'Bishop', 'Transportation Top Officer', 'with the wee baby Seamus over the course of the episode as he considers him the closest that he will ever get to having a'),
(55, 15, '2014-03-06 12:57:10', '2014-11-02 08:45:09', '2014-03-17 09:47:56', 'Whitehouse Way 367', 'Bassoonist', 'Bowling Alley Manager', 'According to the episode, "Once Bitten" Sterling Archer was age six and celebrated his birthday '),
(56, 6, '2014-02-07 12:11:05', '2014-11-08 14:13:09', '2014-06-29 00:53:00', 'Via Budrio 495', 'Moneylender', 'Top Professional Services Executive Medical', 'is always because he will somehow benefit. He does, however, insist upon compensating anyone from whom he commandeers '),
(57, 24, '2014-03-02 14:14:40', '2015-01-17 23:09:53', '2014-02-09 04:43:40', 'ALFONSO XIII, CARRETERA 385', 'Professional dominant', 'Engineering Assistant Mechanical', 'for the Johns Hopkins lacrosse team, as well as being stalked and subsequently shot by a mysterious woman, Ruth '),
(58, 7, '2014-03-09 19:23:16', '2014-06-20 05:59:40', '2014-05-18 14:11:08', 'Sulgrave Road 459', 'Physician', 'Drafter Civil', 'But, in a larger sense, we can not dedicate we can not consecrate we can not hallow this '),
(59, 14, '2014-03-15 05:31:54', '2014-09-28 11:06:36', '2014-03-16 11:09:00', 'COBAS, LAS (NARON) 121', 'Lawyer', 'Personal Banker', 'here gave their lives that that nation might live. It is altogether fitting and proper that '),
(60, 8, '2014-03-07 09:46:51', '2015-01-07 13:49:10', '2014-02-07 03:05:49', 'Notley Street 38', 'Hit Man', 'Medical Nephrologist', 'here, but it can never forget what they did here. It is for us the living, rather, to be '),
(61, 24, '2014-03-09 22:33:08', '2014-06-14 10:49:48', '2014-04-19 07:58:39', 'Robson Avenue 414', 'Pathologist', 'Bowling Alley Manager', ' from breast cancer, he demonstrates considerable regret at his treatment of his co-workers at ISIS, buying Pam and '),
(62, 16, '2014-02-17 17:04:02', '2015-01-24 20:09:02', '2014-04-28 03:19:54', 'ALTO ARAGON 135', 'Historiographer', 'Scientist Animal', 'added to the list of possible fathers was an unnamed young Italian man who was gunned down in the '),
(63, 5, '2014-03-20 02:22:13', '2014-10-02 12:05:19', '2014-05-21 04:43:42', 'PARC MOLINET 136', 'Bioengineer', 'Engineering Assistant Mechanical', 'But, in a larger sense, we can not dedicate we can not consecrate we can not hallow this '),
(64, 15, '2014-01-23 21:14:41', '2015-01-05 01:47:13', '2014-05-01 13:02:58', 'JUAN ORELLANA 472', 'Embalmer', 'Medical Nephrologist', ' from breast cancer, he demonstrates considerable regret at his treatment of his co-workers at ISIS, buying Pam and '),
(65, 8, '2014-03-13 03:47:42', '2014-09-15 18:46:08', '2014-07-10 16:38:14', 'Pepper Close 307', 'Beader', 'Banking Safe Deposit Clerk', 'Cheryl bunches of roses and later stating to Lana Kane that he still loves her (also in the season 4 finale he gives'),
(66, 29, '2014-03-06 15:53:39', '2014-10-12 16:12:21', '2014-03-17 23:14:34', 'Alexander Street 199', 'Fortune-teller', 'Manager Assistant Retail Store (Revenue)', 'is always because he will somehow benefit. He does, however, insist upon compensating anyone from whom he commandeers '),
(67, 21, '2014-03-21 06:42:43', '2014-06-17 19:07:47', '2014-04-29 19:28:13', 'EDUARDO DATO, PLAZA 57', 'Referee', 'Building Superintendent', 'Four score and seven years ago our fathers brought forth on this continent, a new nation, '),
(68, 5, '2014-02-27 13:07:53', '2014-06-09 23:35:24', '2014-02-04 12:27:05', 'Cyprus Road 255', 'Registrar', 'HRIS Manager', 'and mentions that he spent all night helping a giant Domnican guy bury his rooster in the everglades, This becomes '),
(69, 28, '2014-03-14 08:34:13', '2015-01-02 11:10:48', '2014-04-06 04:39:08', 'Boeckstr. 254', 'Medical Technologist', 'Concrete Finisher', 'government of the people, by the people, for the people, shall not perish from the earth.'),
(70, 8, '2014-03-07 08:46:33', '2014-10-16 19:45:43', '2014-03-05 01:15:02', 'Winters  Rd 361', 'Shepherd', 'Banking Safe Deposit Clerk', 'But, in a larger sense, we can not dedicate we can not consecrate we can not hallow this '),
(71, 14, '2014-02-13 21:21:14', '2014-06-22 03:44:05', '2014-05-23 12:09:55', 'St Kitts Terrace 398', 'Warder', 'Top Professional Services Executive Medical', 'with the wee baby Seamus over the course of the episode as he considers him the closest that he will ever get to having a'),
(72, 16, '2014-02-22 15:10:52', '2014-09-13 20:28:49', '2014-07-24 04:46:21', 'Hendon Hall Court 42', 'Illusionist', 'Operator Folding Machine', 'crying over the death of his slain rooster. The next time we see Archer, he is covered in dirt and carrying a shovel, '),
(73, 7, '2014-02-15 22:18:52', '2014-08-31 14:45:03', '2014-04-27 21:10:12', 'OCTAVI AUGUST 479', 'Beekeeper', 'Building Superintendent', 'guide. James shows Archer memories that Sterling had blocked out. These include a visit to Baltimore to try out'),
(74, 7, '2014-02-22 06:25:55', '2014-04-03 12:30:54', '2014-06-09 08:25:49', 'Woodpecker Close 171', 'Theologian', 'Porcelain Buildup Assistant', 'conceived and so dedicated, can long endure. We are met on a great battle-field of that war.'),
(75, 27, '2014-02-26 03:34:40', '2015-02-04 00:01:17', '2014-02-24 09:24:07', 'Alder Ct 74', 'Doctor', 'Technician Physical Therapy', 'streets of Italy and had "blue eyes, full lips and thick wavy hair".[1]'),
(76, 25, '2014-02-10 03:15:49', '2014-12-02 16:02:19', '2014-04-10 14:03:59', 'Pestells  La 333', 'Molecatcher', 'Tax Supervisor', 'is always because he will somehow benefit. He does, however, insist upon compensating anyone from whom he commandeers '),
(77, 11, '2014-03-06 20:25:41', '2015-01-24 13:43:07', '2014-06-12 23:08:13', 'CARLOS RUBIO 191', 'Wrangler', 'Product Design Analyst', 'graduating from Georgetown University, implying he is at least smart enough to receive a bachelors degree in an '),
(78, 12, '2014-02-21 02:03:50', '2014-11-21 22:41:49', '2014-03-07 03:55:06', 'CONSUL, TRAVESIA 224', 'House painter', 'Technician Physical Therapy', 'As a result of this long classical education and friendlessness, Archer is surprisingly well-read.'),
(79, 0, '2014-01-25 08:39:46', '2014-05-04 10:07:51', '2014-07-13 16:52:28', 'Britannia Terrace 363', 'Hairdresser', 'Medical Nephrologist', 'advanced. It is rather for us to be here dedicated to the great task remaining before us '),
(80, 28, '2014-03-20 00:42:49', '2014-11-30 12:43:49', '2014-06-13 23:05:33', 'Old Mill Dr 10', 'Messenger', 'Project Engineer', 'equipment or goods, although he does not always trade to them items they want or need.');

-- --------------------------------------------------------

--
-- Table structure for table `user`
--

CREATE TABLE IF NOT EXISTS `user` (
  `user_id` int(20) NOT NULL AUTO_INCREMENT,
  `user_name` varchar(100) DEFAULT NULL,
  `user_email` varchar(100) DEFAULT NULL,
  `user_location` varchar(255) DEFAULT NULL,
  PRIMARY KEY (`user_id`)
) ENGINE=InnoDB  DEFAULT CHARSET=latin1 AUTO_INCREMENT=46 ;

--
-- Dumping data for table `user`
--

INSERT INTO `user` (`user_id`, `user_name`, `user_email`, `user_location`) VALUES
(1, 'Al', 'V.Kerssens@mail.freenation.is', 'Hanbury Street (Jack the Ripper Murder) 260'),
(2, 'Theodore', 'T.Craig@yupi.com.au', 'PEPE SANTIAGO 455'),
(3, 'Mathilde', 'J.Corver@usmail.com.br', 'Carnegie St 368'),
(4, 'Tim', 'N.Donley@yahoo.gr', 'CHABUCA GRANDA, PLAZA 222'),
(5, 'Paula', 'P.Reddick@ukmail.com.br', 'MATADERILLO, CALLEJON 243'),
(6, 'Siska', 'T.Lorencio@loja.nl', 'CASTELL D''ARGENCOLA 318'),
(7, 'Caitlin', 'N.Barendse@icqmail.com.sg', 'Ebor  St 396'),
(8, 'Carla', 'I.Kelderman@alloymail.de', 'PIAS, DAS 151'),
(9, 'Matthijs', 'T.Diem van@netvigator.tv', 'Warple Road 233'),
(10, 'Simon', 'B.Daves@popmail.se', 'CONDE DE CHESTE, PLAZA 400'),
(11, 'William', 'V.Lonergan@mighty.to', 'GALANES 9'),
(12, 'Luka', 'B.Toussaint@aol.com.ar', 'DOS HERMANAS 34'),
(13, 'Gillian', 'Q.Quade@1stmail.cl', 'Verlengde Hoogeveensevaart 450'),
(14, 'Stanislaw', 'P.Olozaga@fastmail.com', 'QUINCE DE AGOSTO 120'),
(15, 'Tonnie', 'X.Driskell@nexmail.cz', 'Hardy  Ave 312'),
(16, 'Ivan', 'T.Bentz@go.hu', 'Passfields Rents 270'),
(17, 'Adam', 'G.Lambeek@nexmail.mn', 'DISENADORAS 190'),
(18, 'Anthony', 'E.Huskey@go.it', 'Popes Lane 112'),
(19, 'Lars', 'M.Cabrerizo@hotmail.hu', 'HAZA DE SAN ANTONIO 434'),
(20, 'Pedro', 'V.Gaona@uolmail.to', 'Nova Ln 476'),
(45, 'Amitab', 'amitab.das@outlook.com', 'KR Puram, Bangalore');

-- --------------------------------------------------------

--
-- Table structure for table `user_notification`
--

CREATE TABLE IF NOT EXISTS `user_notification` (
  `notification_id` int(20) DEFAULT NULL,
  `from_user_id` int(20) DEFAULT NULL,
  `to_user_id` int(20) DEFAULT NULL,
  KEY `to_user_id` (`to_user_id`),
  KEY `from_user_id` (`from_user_id`),
  KEY `notification_id` (`notification_id`)
) ENGINE=InnoDB DEFAULT CHARSET=latin1;

--
-- Dumping data for table `user_notification`
--

INSERT INTO `user_notification` (`notification_id`, `from_user_id`, `to_user_id`) VALUES
(50, 8, 8),
(9, 10, 16),
(47, 6, 7),
(24, 12, 5),
(26, 1, 17),
(44, 16, 7),
(1, 16, 1),
(39, 20, 17),
(3, 8, 10),
(44, 19, 4),
(49, 1, 2),
(33, 11, 5),
(34, 20, 17),
(38, 5, 18),
(41, 6, 14),
(30, 12, 16),
(3, 2, 18),
(27, 11, 15),
(15, 4, 15),
(36, 6, 16),
(42, 12, 5),
(20, 10, 11),
(49, 4, 4),
(37, 11, 8),
(2, 14, 3),
(48, 14, 5),
(43, 15, 5),
(35, 2, 14),
(21, 14, 20),
(43, 5, 18),
(30, 15, 14),
(29, 18, 6),
(45, 5, 16),
(44, 19, 9),
(44, 20, 10),
(10, 17, 20),
(44, 6, 9),
(45, 14, 9),
(21, 13, 18),
(40, 2, 5),
(44, 17, 5),
(43, 16, 1),
(28, 1, 19),
(22, 1, 19),
(40, 13, 10),
(43, 20, 12),
(30, 7, 20),
(41, 6, 8),
(43, 18, 14),
(33, 20, 11),
(1, 12, 1),
(1, 12, 2),
(51, 20, 1),
(51, 20, 2),
(51, 20, 3),
(51, 20, 4);

-- --------------------------------------------------------

--
-- Table structure for table `user_project`
--

CREATE TABLE IF NOT EXISTS `user_project` (
  `user_id` int(20) DEFAULT NULL,
  `project_id` int(20) DEFAULT NULL,
  KEY `user_id` (`user_id`),
  KEY `project_id` (`project_id`)
) ENGINE=InnoDB DEFAULT CHARSET=latin1;

--
-- Dumping data for table `user_project`
--

INSERT INTO `user_project` (`user_id`, `project_id`) VALUES
(11, 8),
(17, 16),
(17, 8),
(8, 25),
(4, 16),
(15, 24),
(20, 27),
(19, 2),
(18, 1),
(1, 18),
(14, 13),
(6, 9),
(1, 13),
(7, 3),
(10, 10),
(6, 7),
(7, 28),
(5, 18),
(15, 10),
(5, 5),
(19, 1),
(12, 29),
(4, 9),
(12, 12),
(11, 4),
(1, 20),
(13, 11),
(19, 3),
(17, 11),
(2, 1),
(1, 12),
(2, 12),
(1, 12),
(5, 12),
(8, 12),
(20, 12),
(5, 12),
(8, 12),
(20, 12),
(5, 12),
(8, 12),
(20, 12),
(5, 12),
(8, 12),
(20, 12),
(5, 12),
(8, 12),
(20, 12);

-- --------------------------------------------------------

--
-- Table structure for table `user_timesheet`
--

CREATE TABLE IF NOT EXISTS `user_timesheet` (
  `user_id` int(20) DEFAULT NULL,
  `timesheet_id` int(20) DEFAULT NULL,
  KEY `user_id` (`user_id`),
  KEY `timesheet_id` (`timesheet_id`)
) ENGINE=InnoDB DEFAULT CHARSET=latin1;

--
-- Dumping data for table `user_timesheet`
--

INSERT INTO `user_timesheet` (`user_id`, `timesheet_id`) VALUES
(8, 1),
(5, 74),
(10, 41),
(1, 41),
(11, 80),
(11, 80),
(2, 60),
(15, 14),
(17, 59),
(17, 51),
(16, 60),
(7, 72),
(15, 34),
(7, 39),
(16, 51),
(8, 7),
(17, 33),
(20, 26),
(14, 10),
(8, 78),
(12, 48),
(9, 30),
(15, 50),
(11, 41),
(8, 62),
(1, 13),
(9, 42),
(14, 61),
(17, 17),
(11, 4),
(17, 30),
(19, 68),
(10, 16),
(13, 12),
(8, 28),
(5, 46),
(15, 48),
(8, 78),
(3, 44),
(8, 38),
(4, 53),
(10, 42),
(3, 42),
(10, 40),
(5, 53),
(18, 4),
(3, 60),
(9, 21),
(19, 60),
(1, 20),
(16, 25),
(19, 64),
(4, 65),
(5, 10),
(17, 36),
(18, 77),
(12, 36),
(4, 31),
(1, 29),
(15, 26),
(13, 74),
(2, 31),
(1, 75),
(14, 53),
(14, 19),
(19, 49),
(13, 49),
(11, 1),
(16, 21),
(1, 64),
(10, 21),
(10, 19),
(16, 74),
(1, 46),
(4, 15),
(19, 22),
(7, 34),
(4, 47),
(3, 12),
(11, 62);

--
-- Constraints for dumped tables
--

--
-- Constraints for table `authentication`
--
ALTER TABLE `authentication`
  ADD CONSTRAINT `authentication_ibfk_1` FOREIGN KEY (`user_id`) REFERENCES `user` (`user_id`) ON DELETE CASCADE ON UPDATE CASCADE,
  ADD CONSTRAINT `authentication_ibfk_2` FOREIGN KEY (`group_id`) REFERENCES `groups` (`group_id`) ON DELETE CASCADE ON UPDATE CASCADE;

--
-- Constraints for table `project`
--
ALTER TABLE `project`
  ADD CONSTRAINT `project_ibfk_1` FOREIGN KEY (`project_manager_id`) REFERENCES `user` (`user_id`) ON DELETE CASCADE ON UPDATE CASCADE;

--
-- Constraints for table `project_timesheet`
--
ALTER TABLE `project_timesheet`
  ADD CONSTRAINT `project_timesheet_ibfk_1` FOREIGN KEY (`timesheet_id`) REFERENCES `timesheet` (`timesheet_id`) ON DELETE CASCADE ON UPDATE CASCADE,
  ADD CONSTRAINT `project_timesheet_ibfk_2` FOREIGN KEY (`project_id`) REFERENCES `project` (`project_id`) ON DELETE CASCADE ON UPDATE CASCADE;

--
-- Constraints for table `user_notification`
--
ALTER TABLE `user_notification`
  ADD CONSTRAINT `user_notification_ibfk_1` FOREIGN KEY (`to_user_id`) REFERENCES `user` (`user_id`) ON DELETE CASCADE ON UPDATE CASCADE,
  ADD CONSTRAINT `user_notification_ibfk_2` FOREIGN KEY (`from_user_id`) REFERENCES `user` (`user_id`) ON DELETE CASCADE ON UPDATE CASCADE,
  ADD CONSTRAINT `user_notification_ibfk_3` FOREIGN KEY (`notification_id`) REFERENCES `notification` (`notification_id`) ON DELETE CASCADE ON UPDATE CASCADE;

--
-- Constraints for table `user_project`
--
ALTER TABLE `user_project`
  ADD CONSTRAINT `user_project_ibfk_1` FOREIGN KEY (`user_id`) REFERENCES `user` (`user_id`) ON DELETE CASCADE ON UPDATE CASCADE,
  ADD CONSTRAINT `user_project_ibfk_2` FOREIGN KEY (`project_id`) REFERENCES `project` (`project_id`) ON DELETE CASCADE ON UPDATE CASCADE;

--
-- Constraints for table `user_timesheet`
--
ALTER TABLE `user_timesheet`
  ADD CONSTRAINT `user_timesheet_ibfk_1` FOREIGN KEY (`user_id`) REFERENCES `user` (`user_id`) ON DELETE CASCADE ON UPDATE CASCADE,
  ADD CONSTRAINT `user_timesheet_ibfk_2` FOREIGN KEY (`timesheet_id`) REFERENCES `timesheet` (`timesheet_id`) ON DELETE CASCADE ON UPDATE CASCADE;

/*!40101 SET CHARACTER_SET_CLIENT=@OLD_CHARACTER_SET_CLIENT */;
/*!40101 SET CHARACTER_SET_RESULTS=@OLD_CHARACTER_SET_RESULTS */;
/*!40101 SET COLLATION_CONNECTION=@OLD_COLLATION_CONNECTION */;
