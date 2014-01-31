-- phpMyAdmin SQL Dump
-- version 4.0.9
-- http://www.phpmyadmin.net
--
-- Host: 127.0.0.1
-- Generation Time: Jan 29, 2014 at 11:47 AM
-- Server version: 5.6.14
-- PHP Version: 5.5.8

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
-- Table structure for table `notification`
--

CREATE TABLE IF NOT EXISTS `notification` (
  `notification_id` int(20) NOT NULL AUTO_INCREMENT,
  `notification_body` varchar(255) DEFAULT NULL,
  `notification_priority` int(1) DEFAULT NULL,
  `notification_read` int(1) DEFAULT NULL,
  `notification_type` int(1) DEFAULT NULL,
  `notification_subject_id` int(20) DEFAULT NULL,
  `notification_date` datetime DEFAULT NULL,
  PRIMARY KEY (`notification_id`)
) ENGINE=InnoDB  DEFAULT CHARSET=latin1 AUTO_INCREMENT=52 ;

--
-- Dumping data for table `notification`
--

INSERT INTO `notification` (`notification_id`, `notification_body`, `notification_priority`, `notification_read`, `notification_type`, `notification_subject_id`, `notification_date`) VALUES
(1, 'ground. The brave men, living and dead, who struggled here, have consecrated it, far above ', 2, 0, 0, 20, '2013-12-01 21:02:45'),
(2, 'over-dependent on his mother. Archer believed for most of his life that his father was a deceased, ', 2, 1, 1, 1, '2013-10-22 16:57:05'),
(3, 'alone, while his mother assisted in overthrowing the government of Guatemala (in reality the CIA ', 1, 1, 0, 18, '2013-07-21 10:03:36'),
(4, 'we should do this.', 0, 0, 0, 7, '2013-11-04 19:09:36'),
(5, 'with the wee baby Seamus over the course of the episode as he considers him the closest that he will ever get to having a', 2, 0, 0, 17, '2013-08-11 14:18:05'),
(6, 'Cheryl bunches of roses and later stating to Lana Kane that he still loves her (also in the season 4 finale he gives', 2, 0, 1, 18, '2013-10-25 01:42:52'),
(7, 'He spent up to fifteen years at boarding school, despite American schooling taking thirteen years. His hobby was ', 0, 1, 1, 2, '2014-01-01 04:11:10'),
(8, 'Anne Litzenberger. Sterling''s memories culminate in remembering his sixth birthday when his real father gave him ', 0, 0, 0, 5, '2013-08-06 17:26:25'),
(9, 'though Malory Archer denies this) and used to have an on-again, off-again relationship with fellow agent Lana ', 1, 1, 0, 13, '2013-09-09 10:24:09'),
(10, 'government of the people, by the people, for the people, shall not perish from the earth.', 0, 1, 0, 18, '2013-09-04 19:20:16'),
(11, 'Four score and seven years ago our fathers brought forth on this continent, a new nation, ', 2, 0, 1, 6, '2013-10-13 08:40:34'),
(12, 'and "three pounds of glass" in his feet. When he was finally cornered in an elevator, he blindfolded himself and fu', 2, 1, 1, 4, '2013-08-29 00:57:14'),
(13, 'and sometimes bluntly abusive. It is implied that Archer was exposed to "negative reinforcement" when ', 0, 0, 0, 8, '2013-08-10 20:37:31'),
(14, 'our poor power to add or detract. The world will little note, nor long remember what we say ', 2, 0, 1, 4, '2013-11-29 17:36:02'),
(15, 'advanced. It is rather for us to be here dedicated to the great task remaining before us ', 1, 1, 1, 14, '2013-08-30 06:12:52'),
(16, 'In the Season 4 episode, Once Bitten, Sterling revisits his past led by a cut-rate James Mason, as his spirit ', 0, 0, 0, 12, '2013-08-14 11:54:48'),
(17, 'the last full measure of devotion  that we here highly resolve that these dead shall not ', 0, 0, 1, 13, '2013-08-21 11:17:52'),
(18, 'fears. In Heart of Archness:Pt 1, he saved Rip Riley from being attacked by a shark by pulling him out his destroyed ', 0, 0, 0, 6, '2013-08-21 15:15:25'),
(19, 'ground. The brave men, living and dead, who struggled here, have consecrated it, far above ', 0, 1, 0, 13, '2013-10-17 01:45:30'),
(20, 'graduating from Georgetown University, implying he is at least smart enough to receive a bachelors degree in an ', 2, 0, 1, 4, '2013-12-27 00:28:23'),
(21, 'Kane, which makes their working environment tenuous and difficult. At home, he employs an aging valet, Woodhouse ', 2, 0, 0, 20, '2014-01-11 15:44:22'),
(22, 'and sometimes bluntly abusive. It is implied that Archer was exposed to "negative reinforcement" when ', 1, 1, 1, 8, '2014-01-28 05:28:21'),
(23, 'here, but it can never forget what they did here. It is for us the living, rather, to be ', 0, 0, 0, 19, '2013-11-03 17:28:21'),
(24, 'fears. In Heart of Archness:Pt 1, he saved Rip Riley from being attacked by a shark by pulling him out his destroyed ', 1, 1, 0, 19, '2013-10-21 19:10:11'),
(25, 'unknown major. Woodhouse is present, also implying he is a better parent to Sterling than Malory who was not present. ', 1, 0, 1, 15, '2013-09-07 12:11:46'),
(26, 'alone, while his mother assisted in overthrowing the government of Guatemala (in reality the CIA ', 0, 0, 1, 10, '2013-10-06 09:15:47'),
(27, 'twitted and outfought the numerous soldiers dispatched to recapture him despite never having a functional firearm ', 1, 1, 0, 18, '2013-09-04 21:40:10'),
(28, 'lly intended his last words to be "F*** you, you douchebags."', 2, 1, 1, 11, '2013-12-07 15:21:27'),
(29, 'streets of Italy and had "blue eyes, full lips and thick wavy hair".[1]', 1, 0, 0, 2, '2013-09-03 23:46:48'),
(30, 'he was growing up by Malory in The Double Deuce (Malory denies Seamus a toy, saying, "Did somebody trick ', 2, 1, 0, 18, '2013-09-28 14:55:53'),
(31, 'added to the list of possible fathers was an unnamed young Italian man who was gunned down in the ', 0, 0, 1, 7, '2013-07-26 07:44:41'),
(32, 'Now we are engaged in a great civil war, testing whether that nation, or any nation so ', 2, 1, 0, 3, '2013-08-28 13:38:49'),
(33, 'we should do this.', 1, 0, 0, 6, '2013-10-31 08:24:20'),
(34, 'here, but it can never forget what they did here. It is for us the living, rather, to be ', 2, 0, 0, 11, '2013-11-27 19:30:16'),
(35, 'Archer is first and foremost completely focused on himself, his needs and desires. If he aids another person, it ', 1, 0, 0, 11, '2013-11-08 07:06:58'),
(36, 'he establishes a friendship with a fellow cancer patient, Ruth. Another example of this is in Honeypot when Archer ', 2, 1, 0, 7, '2014-01-14 16:20:28'),
(37, ' child, going so far as to have "Seamus" tattooed on his back in recognition of that affection.  Additionally, ', 2, 0, 1, 14, '2013-08-27 18:43:38'),
(38, 'with the wee baby Seamus over the course of the episode as he considers him the closest that he will ever get to having a', 1, 0, 0, 6, '2013-12-18 04:10:19'),
(39, 'Archer is first and foremost completely focused on himself, his needs and desires. If he aids another person, it ', 0, 0, 1, 9, '2013-08-12 12:09:36'),
(40, 'twitted and outfought the numerous soldiers dispatched to recapture him despite never having a functional firearm ', 0, 1, 1, 13, '2014-01-21 05:52:31'),
(41, 'unknown major. Woodhouse is present, also implying he is a better parent to Sterling than Malory who was not present. ', 1, 1, 1, 8, '2013-10-17 08:04:39'),
(42, 'Anne Litzenberger. Sterling''s memories culminate in remembering his sixth birthday when his real father gave him ', 1, 0, 0, 20, '2013-08-09 11:43:21'),
(43, 'even more heart warming in hindsight after the second season reveal that alligators are one of Archer''s three biggest ', 1, 0, 1, 12, '2013-08-15 01:08:56'),
(44, 'twitted and outfought the numerous soldiers dispatched to recapture him despite never having a functional firearm ', 2, 0, 1, 3, '2014-01-10 01:15:06'),
(45, 'a stuffed alligator.  He, unfortunately, awakens before remembering his father''s face.', 1, 1, 0, 15, '2013-10-21 02:24:16'),
(46, 'government of the people, by the people, for the people, shall not perish from the earth.', 1, 1, 0, 2, '2014-01-28 13:58:58'),
(47, 'His relation with his mother Malory—who is also his boss at ISIS—is often strained, never sympathetic, ', 1, 0, 0, 17, '2013-12-28 17:11:23'),
(48, 'His relation with his mother Malory—who is also his boss at ISIS—is often strained, never sympathetic, ', 2, 1, 1, 7, '2013-12-13 00:28:46'),
(49, ' Lana the last set of scuba gear and tells her he loves her before drowning to be rescucitated). Archer also bonds ', 2, 1, 1, 17, '2013-09-12 14:12:30'),
(50, 'over-dependent on his mother. Archer believed for most of his life that his father was a deceased, ', 0, 1, 1, 10, '2013-08-02 01:15:11'),
(51, 'You''ve been requested to join Analyst Wage & Salary', 1, 0, 0, 24, '2014-01-29 11:31:13');

-- --------------------------------------------------------

--
-- Table structure for table `project`
--

CREATE TABLE IF NOT EXISTS `project` (
  `project_id` int(20) NOT NULL AUTO_INCREMENT,
  `project_name` varchar(100) DEFAULT NULL,
  `project_description` varchar(255) DEFAULT NULL,
  `project_status` int(1) DEFAULT NULL,
  `project_time_alloted` datetime DEFAULT NULL,
  `project_created_date` datetime DEFAULT NULL,
  `project_manager_id` int(20) DEFAULT NULL,
  `project_salary` double DEFAULT NULL,
  `project_state` int(1) DEFAULT NULL,
  PRIMARY KEY (`project_id`),
  KEY `project_manager_id` (`project_manager_id`)
) ENGINE=InnoDB  DEFAULT CHARSET=latin1 AUTO_INCREMENT=31 ;

--
-- Dumping data for table `project`
--

INSERT INTO `project` (`project_id`, `project_name`, `project_description`, `project_status`, `project_time_alloted`, `project_created_date`, `project_manager_id`, `project_salary`, `project_state`) VALUES
(1, 'Certified Nurse Assistant', 'dedicated here to the unfinished work which they who fought here have thus far so nobly ', 0, '2014-12-03 00:08:29', '2014-01-04 14:36:38', 13, 3516, 0),
(2, 'Insurance Supervisor', 'graduating from Georgetown University, implying he is at least smart enough to receive a bachelors degree in an ', 1, '2014-08-11 06:50:16', '2013-12-10 09:01:33', 15, 1125, 1),
(3, 'Sewage Facilities Supervisor', 'agency "ISIS," located in New York City. ', 1, '2014-05-09 13:46:20', '2014-01-16 06:11:15', 20, 3291, 2),
(4, 'Beautician Mortuary', 'Kane, which makes their working environment tenuous and difficult. At home, he employs an aging valet, Woodhouse ', 2, '2015-04-18 01:04:37', '2013-10-26 07:41:19', 13, 1734, 1),
(5, 'Engineer Physical Metallurgist', 'twitted and outfought the numerous soldiers dispatched to recapture him despite never having a functional firearm ', 0, '2014-08-19 14:20:07', '2013-12-22 23:18:57', 3, 3661, 0),
(6, 'Manager Telecommunications', 'But, in a larger sense, we can not dedicate we can not consecrate we can not hallow this ', 0, '2014-04-16 00:36:55', '2013-10-21 15:07:33', 9, 3921, 2),
(7, 'Physical Therapy Manager', ' from breast cancer, he demonstrates considerable regret at his treatment of his co-workers at ISIS, buying Pam and ', 3, '2014-08-02 19:29:56', '2013-11-23 23:01:31', 11, 4400, 2),
(8, 'Studio Technician', 'he was growing up by Malory in The Double Deuce (Malory denies Seamus a toy, saying, "Did somebody trick ', 0, '2014-04-17 13:06:49', '2013-12-20 15:50:52', 17, 4673, 0),
(9, 'Packager Manual', 'may be KGB head Major Nikolai Jakov, ODIN director Len Trexler, or jazz drummer Buddy Rich. Later ', 1, '2014-06-29 23:09:55', '2013-10-30 19:55:56', 13, 3898, 0),
(10, 'International Sales Manager', 'he was growing up by Malory in The Double Deuce (Malory denies Seamus a toy, saying, "Did somebody trick ', 1, '2015-01-10 14:58:00', '2013-11-10 21:12:03', 20, 1968, 1),
(11, 'Attendant Coin-Operated Laundry', 'though Malory Archer denies this) and used to have an on-again, off-again relationship with fellow agent Lana ', 3, '2014-10-02 04:28:18', '2013-12-08 00:44:16', 3, 3907, 0),
(12, 'Physical Therapy Aide', 'over-dependent on his mother. Archer believed for most of his life that his father was a deceased, ', 0, '2014-05-30 08:18:13', '2013-10-22 07:52:01', 7, 3520, 1),
(13, 'Manager Medical Services', 'conceived in Liberty, and dedicated to the proposition that all men are created equal.', 2, '2014-07-18 08:47:21', '2013-11-10 06:43:49', 13, 2292, 1),
(14, 'Research Environmental Manager', 'government of the people, by the people, for the people, shall not perish from the earth.', 1, '2014-10-02 05:59:17', '2014-01-01 00:21:54', 16, 3533, 2),
(15, 'Engineering Supervisor Administrative', 'graduating from Georgetown University, implying he is at least smart enough to receive a bachelors degree in an ', 1, '2014-04-09 12:43:26', '2014-01-15 00:16:58', 20, 1782, 0),
(16, 'Correspondence Clerk', 'Cheryl bunches of roses and later stating to Lana Kane that he still loves her (also in the season 4 finale he gives', 2, '2015-02-24 16:37:03', '2013-11-09 09:32:54', 3, 3449, 1),
(17, 'Technician CAM', 'agency "ISIS," located in New York City. ', 1, '2014-03-20 05:06:57', '2013-12-14 19:21:20', 12, 2719, 0),
(18, 'Medical CT Technologist', 'here gave their lives that that nation might live. It is altogether fitting and proper that ', 3, '2015-03-05 05:31:28', '2013-11-11 19:06:27', 13, 4697, 0),
(19, 'Physicist BS', ' child, going so far as to have "Seamus" tattooed on his back in recognition of that affection.  Additionally, ', 2, '2014-06-19 20:02:21', '2013-12-21 19:59:37', 4, 3808, 1),
(20, 'Director Engineering', 'agency "ISIS," located in New York City. ', 1, '2014-10-13 23:46:32', '2013-11-01 20:04:06', 9, 1445, 2),
(21, 'Property Manager', 'advanced. It is rather for us to be here dedicated to the great task remaining before us ', 2, '2014-11-03 01:48:10', '2013-11-21 06:49:43', 17, 2867, 1),
(22, 'Banking Disbursement Clerk', ' Lana the last set of scuba gear and tells her he loves her before drowning to be rescucitated). Archer also bonds ', 1, '2014-04-05 01:10:19', '2013-12-08 21:17:34', 16, 1350, 2),
(23, 'Extractive Metallurgist', 'with the wee baby Seamus over the course of the episode as he considers him the closest that he will ever get to having a', 3, '2014-10-19 05:57:00', '2013-12-08 19:34:41', 15, 1580, 2),
(24, 'Analyst Wage & Salary', 'guide. James shows Archer memories that Sterling had blocked out. These include a visit to Baltimore to try out', 2, '2014-02-09 19:14:57', '2014-01-14 11:58:43', 18, 2307, 0),
(25, 'Repairer Carpenter', ' Lana the last set of scuba gear and tells her he loves her before drowning to be rescucitated). Archer also bonds ', 3, '2014-08-19 16:15:31', '2013-11-16 23:32:42', 11, 2240, 2),
(26, 'Top Sales Officer', 'crying over the death of his slain rooster. The next time we see Archer, he is covered in dirt and carrying a shovel, ', 3, '2015-01-04 08:16:35', '2013-11-26 20:09:36', 18, 1198, 1),
(27, 'Automobile Mechanic', ' Lana the last set of scuba gear and tells her he loves her before drowning to be rescucitated). Archer also bonds ', 0, '2014-02-14 01:44:25', '2014-01-06 16:07:08', 12, 4506, 0),
(28, 'Clerk Correspondence', 'for the Johns Hopkins lacrosse team, as well as being stalked and subsequently shot by a mysterious woman, Ruth ', 0, '2015-03-14 20:15:30', '2013-12-12 03:12:23', 12, 2645, 0),
(29, 'Medical Dietary Aide', 'the last full measure of devotion  that we here highly resolve that these dead shall not ', 0, '2014-12-19 21:38:29', '2014-01-05 13:16:30', 15, 2150, 1),
(30, 'Clinical Research Coordinator', 'who contributed greatly to Archer''s parenting. Archer is voiced by H. Jon Benjamin.', 2, '2014-03-06 21:56:00', '2014-01-08 02:19:25', 18, 3757, 1);

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
(3, 1),
(25, 2),
(12, 3),
(21, 4),
(6, 5),
(17, 6),
(4, 7),
(4, 8),
(9, 9),
(4, 10),
(20, 11),
(5, 12),
(26, 13),
(6, 14),
(25, 15),
(26, 16),
(14, 17),
(12, 18),
(11, 19),
(19, 20),
(3, 21),
(27, 22),
(14, 23),
(9, 24),
(18, 25),
(20, 26),
(14, 27),
(18, 28),
(11, 29),
(7, 30),
(3, 31),
(30, 32),
(17, 33),
(24, 34),
(21, 35),
(8, 36),
(14, 37),
(5, 38),
(24, 39),
(17, 40),
(14, 41),
(19, 42),
(16, 43),
(14, 44),
(15, 45),
(28, 46),
(10, 47),
(27, 48),
(1, 49),
(27, 50),
(2, 51),
(25, 52),
(15, 53),
(9, 54),
(20, 55),
(19, 56),
(18, 57),
(11, 58),
(18, 59),
(27, 60),
(1, 61),
(13, 62),
(5, 63),
(15, 64),
(6, 65),
(29, 66),
(3, 67),
(7, 68),
(12, 69),
(7, 70),
(27, 71),
(27, 72),
(5, 73),
(27, 74),
(13, 75),
(28, 76),
(29, 77),
(13, 78),
(8, 79),
(11, 80);

-- --------------------------------------------------------

--
-- Table structure for table `task`
--

CREATE TABLE IF NOT EXISTS `task` (
  `task_id` int(20) NOT NULL AUTO_INCREMENT,
  `task_name` varchar(255) DEFAULT NULL,
  `task_notes` varchar(255) DEFAULT NULL,
  `task_timesheet_id` int(20) DEFAULT NULL,
  `task_start_time` datetime DEFAULT NULL,
  `task_end_time` datetime DEFAULT NULL,
  `task_work_time` float DEFAULT NULL,
  `task_location` varchar(255) DEFAULT NULL,
  `task_status` int(1) DEFAULT NULL,
  PRIMARY KEY (`task_id`),
  KEY `task_timesheet_id` (`task_timesheet_id`)
) ENGINE=InnoDB  DEFAULT CHARSET=latin1 AUTO_INCREMENT=101 ;

--
-- Dumping data for table `task`
--

INSERT INTO `task` (`task_id`, `task_name`, `task_notes`, `task_timesheet_id`, `task_start_time`, `task_end_time`, `task_work_time`, `task_location`, `task_status`) VALUES
(1, 'Spiker', 'though Malory Archer denies this) and used to have an on-again, off-again relationship with fellow agent Lana ', 22, '2013-12-01 21:26:43', '2014-01-29 08:35:59', 365395, 'Viscount Drive', 2),
(2, 'Vargas', 'lacrosse, although flashbacks have indicated he had few friends. A picture of Archer in Placebo Effect shows Archer ', 42, '2013-09-20 23:27:49', '2014-01-28 21:52:13', 311298, 'Vulcan Road', 2),
(3, 'Ribeiro', 'advanced. It is rather for us to be here dedicated to the great task remaining before us ', 21, '2013-03-20 07:32:27', '2014-01-30 11:06:33', 348268, 'Fordington Road', 2),
(4, 'Moriarty', 'alone, while his mother assisted in overthrowing the government of Guatemala (in reality the CIA ', 35, '2013-06-22 18:38:08', '2014-01-30 08:56:20', 333543, 'Walton Gardens', 0),
(5, 'Beals', 'though Malory Archer denies this) and used to have an on-again, off-again relationship with fellow agent Lana ', 33, '2014-01-02 13:31:56', '2014-01-30 12:06:50', 310964, 'Kendal Place', 0),
(6, 'Fernandes', 'though Malory Archer denies this) and used to have an on-again, off-again relationship with fellow agent Lana ', 47, '2013-10-30 01:56:03', '2014-01-28 23:48:04', 359175, 'Church Porch Chambers', 0),
(7, 'Marcus', 'In the Season 4 episode, Once Bitten, Sterling revisits his past led by a cut-rate James Mason, as his spirit ', 27, '2013-02-13 16:33:26', '2014-01-28 14:51:44', 371927, 'Lockhart Terrace', 0),
(8, 'Telford', 'lly intended his last words to be "F*** you, you douchebags."', 20, '2013-06-01 08:13:26', '2014-01-28 20:08:05', 349925, 'Laurel View', 0),
(9, 'Hindman', 'alone, while his mother assisted in overthrowing the government of Guatemala (in reality the CIA ', 54, '2013-05-11 01:57:23', '2014-01-29 09:42:43', 335046, 'Weyman Road', 1),
(10, 'Llamas', 'As a result of this long classical education and friendlessness, Archer is surprisingly well-read.', 45, '2014-01-15 10:04:17', '2014-01-29 15:13:36', 349082, 'Hanford Row', 0),
(11, 'Gallardo', 'Kane, which makes their working environment tenuous and difficult. At home, he employs an aging valet, Woodhouse ', 56, '2013-11-19 14:16:24', '2014-01-29 07:07:49', 337012, 'Canonbury Terrace', 2),
(12, 'Hackett', 'graduating from Georgetown University, implying he is at least smart enough to receive a bachelors degree in an ', 13, '2013-02-05 16:44:51', '2014-01-29 02:58:28', 332099, 'North Court South St', 1),
(13, 'Oswalt', 'In the Season 4 episode, Once Bitten, Sterling revisits his past led by a cut-rate James Mason, as his spirit ', 9, '2013-09-10 16:15:17', '2014-01-28 22:41:35', 335775, 'Cloisters Business Centre', 2),
(14, 'Langevin', 'unknown major. Woodhouse is present, also implying he is a better parent to Sterling than Malory who was not present. ', 73, '2014-01-16 05:13:30', '2014-01-29 10:53:01', 346933, 'Anchor Hope Alley', 0),
(15, 'Ferrara', 'you, hmm? See, that''s how the world works dear, and I''m the only one you can trust.") making Archer ', 48, '2014-01-14 11:51:03', '2014-01-29 14:05:12', 323303, 'Lincolns Inn Fields', 2),
(16, 'Chiles', 'seaplane, bandaging his head and giving him CPR', 44, '2013-10-13 19:10:51', '2014-01-29 13:04:11', 364653, 'Ardgowan Road', 2),
(17, 'Proctor', 'Archer is first and foremost completely focused on himself, his needs and desires. If he aids another person, it ', 50, '2013-11-12 01:12:52', '2014-01-29 10:06:22', 321063, 'Mullins Path', 0),
(18, 'Pringle', 'that from these honored dead we take increased devotion to that cause for which they gave ', 34, '2013-02-28 03:59:41', '2014-01-29 11:15:28', 347343, 'Lightfoot Road', 1),
(19, 'Laureano', 'that from these honored dead we take increased devotion to that cause for which they gave ', 5, '2013-04-03 07:42:07', '2014-01-29 23:39:20', 303061, 'Oakwood View', 1),
(20, 'Hayashi', ' from breast cancer, he demonstrates considerable regret at his treatment of his co-workers at ISIS, buying Pam and ', 10, '2013-05-13 01:44:56', '2014-01-28 19:46:54', 316012, 'Hyde Park Gate South', 1),
(21, 'Ferretti', 'ive with a fairly high degree of personal bravery, as shown during his escape from Moscow when he consistently ou', 75, '2013-11-12 08:52:22', '2014-01-30 12:44:58', 336173, 'Cranwell Close', 2),
(22, 'Hewett', 'Cheryl bunches of roses and later stating to Lana Kane that he still loves her (also in the season 4 finale he gives', 17, '2013-05-14 10:13:47', '2014-01-29 02:35:08', 346061, 'Lavina Green', 0),
(23, 'Rolle', ' child, going so far as to have "Seamus" tattooed on his back in recognition of that affection.  Additionally, ', 1, '2013-05-09 11:29:20', '2014-01-30 09:30:39', 358330, 'Bank Buildings', 2),
(24, 'Lovell', 'even more heart warming in hindsight after the second season reveal that alligators are one of Archer''s three biggest ', 73, '2013-05-18 09:55:33', '2014-01-30 02:13:19', 345463, 'St Georges School', 2),
(25, 'Moriarty', 'and "three pounds of glass" in his feet. When he was finally cornered in an elevator, he blindfolded himself and fu', 48, '2013-10-31 06:30:59', '2014-01-29 09:10:20', 318849, 'Middle Field', 1),
(26, 'Anselmo', 'lacrosse, although flashbacks have indicated he had few friends. A picture of Archer in Placebo Effect shows Archer ', 59, '2013-04-07 15:01:47', '2014-01-30 04:51:12', 339964, 'North Worple Way', 1),
(27, 'Osborne', 'lly intended his last words to be "F*** you, you douchebags."', 12, '2013-04-15 20:07:25', '2014-01-30 03:04:34', 318774, 'Staceys Terrace', 2),
(28, 'Gallo', 'conceived in Liberty, and dedicated to the proposition that all men are created equal.', 21, '2014-01-03 04:26:12', '2014-01-28 21:15:06', 323693, 'Basil Street', 1),
(29, 'Barton', 'he was growing up by Malory in The Double Deuce (Malory denies Seamus a toy, saying, "Did somebody trick ', 79, '2014-01-15 20:40:58', '2014-01-30 11:40:24', 316616, 'Thornfield Parade', 0),
(30, 'Vang', 'agency "ISIS," located in New York City. ', 61, '2013-02-08 20:44:41', '2014-01-28 23:47:52', 327064, 'Northburgh Street', 0),
(31, 'Overstreet', 'According to the episode, "Once Bitten" Sterling Archer was age six and celebrated his birthday ', 1, '2013-02-26 17:46:06', '2014-01-29 21:31:31', 341130, 'Princes Gate', 1),
(32, 'Kimball', 'But, in a larger sense, we can not dedicate we can not consecrate we can not hallow this ', 71, '2014-01-25 05:15:20', '2014-01-29 03:28:56', 339819, 'Church Street All Saints', 2),
(33, 'Artis', 'But, in a larger sense, we can not dedicate we can not consecrate we can not hallow this ', 26, '2013-11-28 17:09:32', '2014-01-29 18:18:06', 341914, 'St Giles High Street', 2),
(34, 'Michael', ' from breast cancer, he demonstrates considerable regret at his treatment of his co-workers at ISIS, buying Pam and ', 31, '2013-10-13 16:58:27', '2014-01-30 02:54:17', 306502, 'Forest Street', 1),
(35, 'Bulter', 'Archer is first and foremost completely focused on himself, his needs and desires. If he aids another person, it ', 78, '2013-03-12 23:50:07', '2014-01-29 19:46:55', 329756, 'Wellington Barracks', 0),
(36, 'Roger', 'added to the list of possible fathers was an unnamed young Italian man who was gunned down in the ', 63, '2014-01-07 19:36:28', '2014-01-29 05:16:29', 339226, 'Fandon Row', 0),
(37, 'Batiste', 'have died in vain that this nation, under God, shall have a new birth of freedom and that ', 51, '2013-12-29 20:58:55', '2014-01-30 12:51:20', 372100, 'Rainton Road', 1),
(38, 'Dominquez', 'and sometimes bluntly abusive. It is implied that Archer was exposed to "negative reinforcement" when ', 5, '2013-10-27 04:34:02', '2014-01-28 15:24:39', 350985, 'Moor Lane', 0),
(39, 'Bonham', 'guide. James shows Archer memories that Sterling had blocked out. These include a visit to Baltimore to try out', 21, '2013-10-13 20:59:10', '2014-01-29 10:31:14', 371224, 'Gunterstone Road', 2),
(40, 'Butterfield', 'added to the list of possible fathers was an unnamed young Italian man who was gunned down in the ', 26, '2013-12-18 17:58:02', '2014-01-29 20:44:27', 340860, 'Nicholas Gardens', 1),
(41, 'Daves', 'and "three pounds of glass" in his feet. When he was finally cornered in an elevator, he blindfolded himself and fu', 63, '2013-12-29 20:26:20', '2014-01-29 12:53:04', 349445, 'Keats Estate', 2),
(42, 'Flaherty', 'Archer has the less than masculine codename of "Duchess" (taken from his mother''s beloved Afghan wolfhound, ', 42, '2013-05-22 19:37:27', '2014-01-30 00:18:08', 317055, 'Holborn Viaduct', 1),
(43, 'Abrego', 'Archer is not completely devoid of a sensitive side however, as seen in Stage Two, when he believes that he may di', 69, '2013-06-09 03:08:01', '2014-01-29 16:09:51', 372154, 'Kelly Street', 2),
(44, 'Truelove', 'fears. In Heart of Archness:Pt 1, he saved Rip Riley from being attacked by a shark by pulling him out his destroyed ', 12, '2013-08-23 06:03:31', '2014-01-30 05:44:30', 364803, 'Hamilton Road', 1),
(45, 'Ellinger', 'government of the people, by the people, for the people, shall not perish from the earth.', 38, '2013-09-30 15:04:01', '2014-01-28 21:41:12', 326000, 'Lynch Walk', 1),
(46, 'Zumwalt', ' Lana the last set of scuba gear and tells her he loves her before drowning to be rescucitated). Archer also bonds ', 70, '2013-04-21 13:29:39', '2014-01-30 02:18:55', 352112, 'Thornaby Gardens', 0),
(47, 'Shumate', 'Anne Litzenberger. Sterling''s memories culminate in remembering his sixth birthday when his real father gave him ', 53, '2013-10-25 23:26:21', '2014-01-28 20:53:14', 348949, 'Cornish Grove', 2),
(48, 'Kirschner', ' child, going so far as to have "Seamus" tattooed on his back in recognition of that affection.  Additionally, ', 22, '2013-06-09 00:51:25', '2014-01-29 21:53:18', 359832, 'Westcombe Park Road', 1),
(49, 'Knotts', 'Archer has the less than masculine codename of "Duchess" (taken from his mother''s beloved Afghan wolfhound, ', 18, '2013-03-26 15:39:12', '2014-01-30 04:18:41', 318735, 'Akerman Road', 1),
(50, 'Boswell', 'here, but it can never forget what they did here. It is for us the living, rather, to be ', 41, '2014-01-06 20:46:37', '2014-01-29 03:56:10', 314964, 'Beacon Road', 2),
(51, 'Galarza', 'that from these honored dead we take increased devotion to that cause for which they gave ', 28, '2013-09-21 02:18:55', '2014-01-28 18:36:48', 355357, 'Churchmore Road', 1),
(52, 'Kinard', 'Kane, which makes their working environment tenuous and difficult. At home, he employs an aging valet, Woodhouse ', 3, '2013-05-15 06:35:12', '2014-01-28 20:32:34', 348293, 'Prince Arthur Road', 2),
(53, 'Cano', 'a stuffed alligator.  He, unfortunately, awakens before remembering his father''s face.', 29, '2013-07-28 20:14:05', '2014-01-30 07:33:26', 309530, 'Hilltop Road', 0),
(54, 'Lheureux', 'finds himself in a bar that hosts chicken-fighting matches. A big, weeping Dominican man is sitting next to him, ', 17, '2013-08-13 15:19:20', '2014-01-29 21:24:06', 355274, 'Chesnut Villas', 1),
(55, 'Edelstein', 'is always because he will somehow benefit. He does, however, insist upon compensating anyone from whom he commandeers ', 33, '2013-02-02 15:25:27', '2014-01-28 13:00:58', 337611, 'Lord Hills Road', 2),
(56, 'Folsom', 'who contributed greatly to Archer''s parenting. Archer is voiced by H. Jon Benjamin.', 6, '2013-02-06 14:43:21', '2014-01-29 10:48:57', 353659, 'Chance Street', 0),
(57, 'Munford', 'twitted and outfought the numerous soldiers dispatched to recapture him despite never having a functional firearm ', 8, '2014-01-10 14:05:56', '2014-01-29 15:58:23', 317618, 'Bentley''s Place', 2),
(58, 'Legault', 'dedicated here to the unfinished work which they who fought here have thus far so nobly ', 1, '2013-11-03 06:13:46', '2014-01-29 08:41:52', 334111, 'Leaf Grove', 1),
(59, 'Snider', 'may be KGB head Major Nikolai Jakov, ODIN director Len Trexler, or jazz drummer Buddy Rich. Later ', 17, '2014-01-04 05:40:40', '2014-01-28 17:31:11', 351725, 'Barleycorn Way', 1),
(60, 'Ritz', 'ive with a fairly high degree of personal bravery, as shown during his escape from Moscow when he consistently ou', 32, '2013-12-10 03:59:19', '2014-01-30 11:34:09', 328106, 'Torquay Street', 0),
(61, 'Haugh', 'is always because he will somehow benefit. He does, however, insist upon compensating anyone from whom he commandeers ', 33, '2013-12-29 17:46:57', '2014-01-29 23:51:28', 327145, 'Pauls Square', 1),
(62, 'Magnuson', 'graduating from Georgetown University, implying he is at least smart enough to receive a bachelors degree in an ', 26, '2014-01-22 13:50:54', '2014-01-29 01:33:39', 330973, 'Hope Cottages', 2),
(63, 'Pitcher', 'But, in a larger sense, we can not dedicate we can not consecrate we can not hallow this ', 72, '2013-09-10 23:14:17', '2014-01-29 07:17:52', 346195, 'Alexander Cottages', 1),
(64, 'Donegan', 'conceived and so dedicated, can long endure. We are met on a great battle-field of that war.', 24, '2013-10-29 12:21:36', '2014-01-29 03:24:49', 369803, 'Longfellow Road', 0),
(65, 'Bates', 'lacrosse, although flashbacks have indicated he had few friends. A picture of Archer in Placebo Effect shows Archer ', 11, '2014-01-07 15:04:22', '2014-01-30 11:15:37', 359606, 'Muschamp Road', 1),
(66, 'Peer', ' We have come to dedicate a portion of that field, as a final resting place for those who ', 71, '2013-04-15 21:46:42', '2014-01-28 21:28:38', 354055, 'Hartswood Road', 2),
(67, 'Graziano', 'graduating from Georgetown University, implying he is at least smart enough to receive a bachelors degree in an ', 40, '2013-07-05 09:31:03', '2014-01-29 15:16:28', 306864, 'Ferdinand Street', 2),
(68, 'Dingman', '', 35, '2013-05-06 17:03:40', '2014-01-29 00:42:40', 360757, 'Summerlee Gardens', 2),
(69, 'Pounds', 'conceived in Liberty, and dedicated to the proposition that all men are created equal.', 77, '2013-10-13 01:00:24', '2014-01-29 15:58:45', 328978, 'St Pauls Mews', 0),
(70, 'Lavender', 'finds himself in a bar that hosts chicken-fighting matches. A big, weeping Dominican man is sitting next to him, ', 60, '2013-03-09 00:52:10', '2014-01-29 03:41:00', 340253, 'Vernon Square', 0),
(71, 'Ferreira', 'even more heart warming in hindsight after the second season reveal that alligators are one of Archer''s three biggest ', 65, '2013-12-16 13:10:40', '2014-01-30 12:07:23', 329358, 'Irene Mews', 2),
(72, 'Chavarria', 'that from these honored dead we take increased devotion to that cause for which they gave ', 61, '2013-09-22 06:34:01', '2014-01-30 03:34:21', 328970, 'Nash''s Cottages', 1),
(73, 'Stabler', 'It is revealed in Fugue and Riffs that for a short period of time, he assumed the identity of Bob Belcher from the show Bob''s Burgers. The reason for this sudden life-change is that he entered a fugue state (stress-induced amnesia) following Malory''s wedd', 27, '2013-02-08 05:52:17', '2014-01-29 13:33:48', 331452, 'St Marys Vicarage', 1),
(74, 'Murphey', 'and "three pounds of glass" in his feet. When he was finally cornered in an elevator, he blindfolded himself and fu', 23, '2014-01-17 05:13:15', '2014-01-28 13:09:56', 300028, 'Mary Cottages', 2),
(75, 'Lozier', 'anyone who crosses him (or even sometimes merely crosses his path), he is also undeniably an intuitively good operat', 40, '2013-09-06 22:07:53', '2014-01-30 02:16:03', 329352, 'Kinloch Street', 2),
(76, 'Kimberlin', 'Kane, which makes their working environment tenuous and difficult. At home, he employs an aging valet, Woodhouse ', 48, '2013-10-30 04:36:05', '2014-01-28 21:51:33', 303576, 'Richmond Terrace', 0),
(77, 'Pizarro', ' from breast cancer, he demonstrates considerable regret at his treatment of his co-workers at ISIS, buying Pam and ', 49, '2013-12-16 23:12:15', '2014-01-29 13:18:43', 355701, 'Pratts Alley', 2),
(78, 'Sink', 'streets of Italy and had "blue eyes, full lips and thick wavy hair".[1]', 17, '2013-10-20 04:10:56', '2014-01-30 04:39:36', 317402, 'Bay Tree Cottages', 2),
(79, 'Crutcher', 'he establishes a friendship with a fellow cancer patient, Ruth. Another example of this is in Honeypot when Archer ', 4, '2013-06-20 11:32:25', '2014-01-29 23:52:55', 332301, 'Banbury Court', 2),
(80, 'Amador', 'Four score and seven years ago our fathers brought forth on this continent, a new nation, ', 44, '2013-02-28 22:08:23', '2014-01-30 03:10:58', 314840, 'Chaucer Road', 0),
(81, 'Reagan', 'lacrosse, although flashbacks have indicated he had few friends. A picture of Archer in Placebo Effect shows Archer ', 74, '2013-06-10 09:47:32', '2014-01-30 10:16:24', 355314, 'Butler Road', 0),
(82, 'Bluhm', 'we should do this.', 47, '2014-01-13 02:21:12', '2014-01-29 14:39:10', 332668, 'Briants Street', 0),
(83, 'Bacon', 'Although he has numerous personality flaws, such as insensitivity, egotism, and a casual attitude towards murdering ', 62, '2013-03-28 15:48:59', '2014-01-29 04:53:25', 328576, 'Fenton Street', 0),
(84, 'Ulrich', 'here, but it can never forget what they did here. It is for us the living, rather, to be ', 46, '2013-11-17 09:24:22', '2014-01-29 00:54:16', 321727, 'Wharf Road South', 1),
(85, 'Lovato', 'graduating from Georgetown University, implying he is at least smart enough to receive a bachelors degree in an ', 19, '2013-10-19 05:40:20', '2014-01-30 09:14:48', 321230, 'Glenhurst Road', 0),
(86, 'Caban', 'It is revealed in Fugue and Riffs that for a short period of time, he assumed the identity of Bob Belcher from the show Bob''s Burgers. The reason for this sudden life-change is that he entered a fugue state (stress-induced amnesia) following Malory''s wedd', 60, '2013-12-16 15:35:02', '2014-01-28 17:22:51', 359681, 'Maltravers Street', 2),
(87, 'Lafave', 'advanced. It is rather for us to be here dedicated to the great task remaining before us ', 64, '2014-01-23 08:37:20', '2014-01-30 02:57:57', 345898, 'Brittania Terrace', 1),
(88, 'Landrum', 'twitted and outfought the numerous soldiers dispatched to recapture him despite never having a functional firearm ', 78, '2013-10-04 23:52:31', '2014-01-29 06:08:07', 356767, 'Cottage Walk', 2),
(89, 'Shank', 'conceived in Liberty, and dedicated to the proposition that all men are created equal.', 30, '2013-06-01 14:07:54', '2014-01-29 00:46:50', 354164, 'Cornwallis Walk', 1),
(90, 'Cram', 'Although he has numerous personality flaws, such as insensitivity, egotism, and a casual attitude towards murdering ', 34, '2013-06-07 22:58:23', '2014-01-29 20:49:49', 340995, 'Foxley Road', 0),
(91, 'Thrift', 'alone, while his mother assisted in overthrowing the government of Guatemala (in reality the CIA ', 7, '2013-02-19 22:52:10', '2014-01-28 13:31:58', 304468, 'Shepherds Bush Market', 0),
(92, 'Starkey', 'though Malory Archer denies this) and used to have an on-again, off-again relationship with fellow agent Lana ', 27, '2013-03-27 14:16:19', '2014-01-28 19:44:14', 308756, 'Carys Road', 1),
(93, 'Monson', 'conceived and so dedicated, can long endure. We are met on a great battle-field of that war.', 75, '2013-10-28 01:42:27', '2014-01-29 09:10:26', 302453, 'Brayards Road Estate', 0),
(94, 'Jaimes', 'seaplane, bandaging his head and giving him CPR', 50, '2013-12-17 14:52:15', '2014-01-29 18:44:14', 365160, 'Harton Road', 2),
(95, 'Tew', 'Kane, which makes their working environment tenuous and difficult. At home, he employs an aging valet, Woodhouse ', 36, '2013-10-27 06:43:14', '2014-01-29 17:45:53', 306701, 'Elder Place', 2),
(96, 'Crabb', 'Cheryl bunches of roses and later stating to Lana Kane that he still loves her (also in the season 4 finale he gives', 49, '2013-05-18 12:34:15', '2014-01-30 04:19:15', 357350, 'Badmeeris Mews', 0),
(97, 'Truong', 'he establishes a friendship with a fellow cancer patient, Ruth. Another example of this is in Honeypot when Archer ', 33, '2013-09-06 18:11:12', '2014-01-29 20:28:32', 341510, 'Alice Cottages', 2),
(98, 'Densmore', 'even more heart warming in hindsight after the second season reveal that alligators are one of Archer''s three biggest ', 56, '2013-09-04 16:52:36', '2014-01-29 14:35:17', 304564, 'Sunnyside Road East', 1),
(99, 'Zelaya', 'dedicated here to the unfinished work which they who fought here have thus far so nobly ', 40, '2013-08-04 15:35:14', '2014-01-30 06:35:09', 347496, 'Campbell Cottages', 2),
(100, 'Betts', 'conceived in Liberty, and dedicated to the proposition that all men are created equal.', 5, '2013-11-23 13:59:47', '2014-01-30 04:14:53', 321178, 'Crowborough Road', 1);

-- --------------------------------------------------------

--
-- Table structure for table `timesheet`
--

CREATE TABLE IF NOT EXISTS `timesheet` (
  `timesheet_id` int(20) NOT NULL AUTO_INCREMENT,
  `timesheet_date` date DEFAULT NULL,
  `timesheet_project_name` varchar(100) DEFAULT NULL,
  PRIMARY KEY (`timesheet_id`)
) ENGINE=InnoDB  DEFAULT CHARSET=latin1 AUTO_INCREMENT=81 ;

--
-- Dumping data for table `timesheet`
--

INSERT INTO `timesheet` (`timesheet_id`, `timesheet_date`, `timesheet_project_name`) VALUES
(1, '2015-02-11', 'Repairer Carpenter'),
(2, '2014-09-22', 'International Sales Manager'),
(3, '2014-10-24', 'Engineering Supervisor Administrative'),
(4, '2015-03-06', 'Technician CAM'),
(5, '2014-10-01', 'Sewage Facilities Supervisor'),
(6, '2014-07-08', 'Top Sales Officer'),
(7, '2014-10-17', 'Clinical Research Coordinator'),
(8, '2014-10-24', 'Engineering Supervisor Administrative'),
(9, '2014-11-15', 'Clerk Correspondence'),
(10, '2015-01-21', 'Insurance Supervisor'),
(11, '2015-05-15', 'Engineering Supervisor Administrative'),
(12, '2014-05-09', 'Manager Medical Services'),
(13, '2015-08-17', 'Technician CAM'),
(14, '2014-03-14', 'Physicist BS'),
(15, '2015-06-07', 'Engineer Physical Metallurgist'),
(16, '2015-05-25', 'Medical CT Technologist'),
(17, '2015-02-19', 'Sewage Facilities Supervisor'),
(18, '2014-12-30', 'Engineering Supervisor Administrative'),
(19, '2015-05-08', 'Sewage Facilities Supervisor'),
(20, '2015-06-16', 'Sewage Facilities Supervisor'),
(21, '2014-03-29', 'Technician CAM'),
(22, '2014-03-12', 'Technician CAM'),
(23, '2015-03-23', 'Automobile Mechanic'),
(24, '2014-12-17', 'Insurance Supervisor'),
(25, '2015-05-26', 'Physical Therapy Aide'),
(26, '2014-03-31', 'Correspondence Clerk'),
(27, '2015-03-18', 'Director Engineering'),
(28, '2014-06-04', 'Extractive Metallurgist'),
(29, '2014-02-24', 'Engineering Supervisor Administrative'),
(30, '2014-05-26', 'Banking Disbursement Clerk'),
(31, '2014-10-08', 'Correspondence Clerk'),
(32, '2014-07-09', 'Director Engineering'),
(33, '2014-11-06', 'Automobile Mechanic'),
(34, '2014-03-02', 'Physical Therapy Manager'),
(35, '2015-07-25', 'Certified Nurse Assistant'),
(36, '2014-04-03', 'Clerk Correspondence'),
(37, '2015-03-11', 'Clinical Research Coordinator'),
(38, '2014-12-06', 'Banking Disbursement Clerk'),
(39, '2015-05-13', 'Technician CAM'),
(40, '2015-03-07', 'Manager Medical Services'),
(41, '2015-01-10', 'Manager Telecommunications'),
(42, '2014-11-24', 'Analyst Wage & Salary'),
(43, '2015-02-06', 'Clinical Research Coordinator'),
(44, '2014-03-28', 'Physical Therapy Aide'),
(45, '2014-07-21', 'Physical Therapy Aide'),
(46, '2014-11-03', 'Automobile Mechanic'),
(47, '2015-05-06', 'Engineer Physical Metallurgist'),
(48, '2015-04-12', 'Physicist BS'),
(49, '2014-08-04', 'Banking Disbursement Clerk'),
(50, '2014-01-26', 'Physicist BS'),
(51, '2014-11-05', 'Property Manager'),
(52, '2014-12-29', 'Engineer Physical Metallurgist'),
(53, '2014-03-18', 'Sewage Facilities Supervisor'),
(54, '2015-07-28', 'Insurance Supervisor'),
(55, '2014-05-05', 'Medical CT Technologist'),
(56, '2015-06-02', 'Banking Disbursement Clerk'),
(57, '2015-02-25', 'Engineer Physical Metallurgist'),
(58, '2015-01-13', 'Insurance Supervisor'),
(59, '2014-07-01', 'Beautician Mortuary'),
(60, '2015-08-08', 'Physical Therapy Aide'),
(61, '2014-02-05', 'Certified Nurse Assistant'),
(62, '2014-12-04', 'Medical CT Technologist'),
(63, '2014-05-15', 'Physicist BS'),
(64, '2015-08-10', 'Packager Manual'),
(65, '2014-06-09', 'Beautician Mortuary'),
(66, '2014-06-24', 'Physical Therapy Aide'),
(67, '2015-02-02', 'Research Environmental Manager'),
(68, '2015-06-27', 'International Sales Manager'),
(69, '2014-10-08', 'Beautician Mortuary'),
(70, '2015-04-11', 'Packager Manual'),
(71, '2014-07-29', 'Clinical Research Coordinator'),
(72, '2015-07-19', 'Medical Dietary Aide'),
(73, '2015-04-24', 'Physical Therapy Manager'),
(74, '2015-05-23', 'Clerk Correspondence'),
(75, '2015-05-08', 'Medical CT Technologist'),
(76, '2014-09-16', 'Engineer Physical Metallurgist'),
(77, '2015-04-30', 'Extractive Metallurgist'),
(78, '2014-05-14', 'International Sales Manager'),
(79, '2015-07-04', 'Top Sales Officer'),
(80, '2014-12-09', 'Packager Manual');

-- --------------------------------------------------------

--
-- Table structure for table `user`
--

CREATE TABLE IF NOT EXISTS `user` (
  `user_id` int(20) NOT NULL AUTO_INCREMENT,
  `user_first_name` varchar(255) DEFAULT NULL,
  `user_last_name` varchar(255) DEFAULT NULL,
  `user_sex` char(1) DEFAULT NULL,
  `user_email` varchar(100) DEFAULT NULL,
  `user_location` varchar(255) DEFAULT NULL,
  `user_phone_number` varchar(13) DEFAULT NULL,
  `user_image_url` varchar(255) DEFAULT NULL,
  PRIMARY KEY (`user_id`),
  UNIQUE KEY `user_email` (`user_email`)
) ENGINE=InnoDB  DEFAULT CHARSET=latin1 AUTO_INCREMENT=21 ;

--
-- Dumping data for table `user`
--

INSERT INTO `user` (`user_id`, `user_first_name`, `user_last_name`, `user_sex`, `user_email`, `user_location`, `user_phone_number`, `user_image_url`) VALUES
(1, 'Cathi', 'Norman', 'f', 'Z.Pinillos@usmail.co.kr', 'Janelle St', '0459 216205', 'default.jpg'),
(2, 'Una', 'Crumb', 'm', 'H.Ermua@emailplanet.com.br', 'Reserve St', '0979 236995', 'default.jpg'),
(3, 'Lurline', 'Blackman', 'm', 'C.Parrish@hotmail.com.au', 'Saturn Way', '0187 871027', 'default.jpg'),
(4, 'Keith', 'Shedd', 'f', 'L.Levi@1stmail.info', 'Temperance Way', '0963 789783', 'default.jpg'),
(5, 'Kirsten', 'Lange', 'f', 'Q.Cram@home.tk', 'Atlantic Pl', '0229 829539', 'default.jpg'),
(6, 'Veronica', 'Dallas', 'f', 'J.Galdia@2ndmail.com.sg', 'Santa Ana Ave', '0785 732338', 'default.jpg'),
(7, 'Jamar', 'Holder', 'm', 'D.Gilpin@1stmail.in', 'Delphinium Ave', '0378 579930', 'default.jpg'),
(8, 'Neoma', 'Summerlin', 'm', 'J.Fontevilla@fastmail.hu', 'Crossland Dr', '0329 697288', 'default.jpg'),
(9, 'Daria', 'Mortenson', 'm', 'N.Cammack@netvigator.info', 'Monarch Ridge Dr', '0728 926630', 'default.jpg'),
(10, 'Mitzi', 'Mabry', 'f', 'R.Oneal@latino.com', 'Broadwing Way', '0510 545103', 'default.jpg'),
(11, 'Latonya', 'Cotten', 'f', 'Y.Desimone@excite.com.ar', 'Lookout Cir', '0282 216262', 'default.jpg'),
(12, 'Elena', 'Armentrout', 'm', 'C.Loughlin@web.co.uk', 'Wampum Way', '0495 359097', 'default.jpg'),
(13, 'Roxanne', 'Crow', 'm', 'S.Kiser@1stmail.nl', 'Crosspoint Ave', '0601 505505', 'default.jpg'),
(14, 'Thea', 'Volkman', 'f', 'H.Penafiel@loja.is', 'Wheaton Ln', '0785 969624', 'default.jpg'),
(15, 'Nieves', 'Mair', 'f', 'Y.Kuntz@brasilia.nl', 'Chandra Way', '0659 937268', 'default.jpg'),
(16, 'Julieta', 'Suiter', 'f', 'D.Preciado@xoom.gr', 'Kirkam Ln', '0201 712585', 'default.jpg'),
(17, 'Dario', 'Edmonson', 'f', 'X.Craig@doramail.br', 'Bluebell Dr', '0748 399080', 'default.jpg'),
(18, 'Evia', 'Hammock', 'm', 'M.Hay@web.com.mx', 'Stone Ridge Way', '0278 224919', 'default.jpg'),
(19, 'Christy', 'Strawser', 'm', 'I.Barros@jpopmail.com.br', 'Winterivy', '0267 105097', 'default.jpg'),
(20, 'Valarie', 'Orr', 'm', 'F.Trail@freemail.gr', 'Fifeshire Ave', '0177 597240', 'default.jpg');

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
(33, 11, 14),
(5, 16, 18),
(44, 6, 3),
(32, 13, 9),
(16, 8, 1),
(19, 14, 14),
(3, 10, 15),
(7, 19, 9),
(22, 17, 13),
(47, 7, 2),
(49, 6, 13),
(49, 17, 18),
(42, 11, 3),
(34, 5, 7),
(49, 6, 1),
(5, 5, 20),
(8, 8, 1),
(2, 11, 5),
(32, 7, 5),
(9, 2, 10),
(3, 1, 4),
(43, 2, 15),
(37, 11, 19),
(10, 9, 17),
(46, 7, 8),
(28, 19, 19),
(26, 17, 16),
(5, 3, 11),
(26, 14, 13),
(6, 4, 7),
(32, 18, 3),
(33, 14, 20),
(46, 5, 15),
(44, 1, 10),
(24, 5, 5),
(24, 19, 16),
(24, 13, 18),
(29, 6, 19),
(29, 1, 20),
(27, 15, 8),
(50, 10, 20),
(34, 1, 20),
(24, 2, 5),
(31, 7, 17),
(16, 6, 16),
(1, 2, 15),
(16, 19, 15),
(2, 18, 1),
(34, 12, 13),
(31, 6, 4),
(51, 1, 1),
(51, 1, 2),
(51, 1, 3),
(51, 1, 5);

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
(15, 1),
(10, 24),
(20, 2),
(18, 11),
(10, 7),
(9, 19),
(6, 22),
(8, 15),
(5, 12),
(10, 21),
(17, 19),
(17, 25),
(13, 12),
(3, 7),
(6, 9),
(12, 10),
(18, 8),
(2, 7),
(13, 26),
(2, 4),
(7, 24),
(4, 9),
(17, 10),
(5, 22),
(12, 29),
(17, 12),
(10, 18),
(7, 28),
(14, 20),
(20, 23),
(1, 24),
(2, 24),
(3, 24),
(5, 24);

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
(18, 24),
(3, 36),
(8, 32),
(7, 33),
(20, 69),
(15, 63),
(14, 59),
(8, 39),
(2, 32),
(6, 57),
(17, 7),
(3, 56),
(2, 76),
(4, 63),
(18, 29),
(5, 40),
(4, 1),
(10, 33),
(18, 79),
(8, 6),
(7, 65),
(9, 11),
(18, 20),
(6, 38),
(16, 15),
(1, 8),
(20, 13),
(15, 71),
(10, 80),
(16, 47),
(18, 75),
(3, 65),
(4, 7),
(17, 41),
(11, 80),
(10, 41),
(9, 69),
(12, 6),
(11, 43),
(4, 28),
(6, 30),
(7, 36),
(8, 52),
(16, 24),
(18, 80),
(10, 45),
(3, 8),
(12, 34),
(1, 55),
(16, 66),
(14, 38),
(15, 41),
(3, 55),
(8, 6),
(19, 9),
(12, 57),
(9, 3),
(10, 39),
(10, 35),
(11, 20),
(13, 26),
(19, 45),
(18, 74),
(16, 18),
(19, 24),
(17, 18),
(11, 48),
(18, 32),
(18, 68),
(10, 71),
(11, 12),
(3, 16),
(5, 50),
(14, 55),
(14, 42),
(17, 45),
(16, 17),
(7, 57),
(11, 12),
(6, 6);

--
-- Constraints for dumped tables
--

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
-- Constraints for table `task`
--
ALTER TABLE `task`
  ADD CONSTRAINT `task_ibfk_1` FOREIGN KEY (`task_timesheet_id`) REFERENCES `timesheet` (`timesheet_id`) ON DELETE CASCADE ON UPDATE CASCADE;

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
