-- phpMyAdmin SQL Dump
-- version 4.0.9
-- http://www.phpmyadmin.net
--
-- Host: 127.0.0.1
-- Generation Time: Jan 20, 2014 at 07:24 PM
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
(16, 2, '0001'),
(13, 2, '0002'),
(19, 1, '0003'),
(5, 1, '0004'),
(19, 2, '0005'),
(2, 1, '0006'),
(17, 2, '0007'),
(14, 2, '0008'),
(13, 2, '0009'),
(17, 1, '0010'),
(18, 2, '0011'),
(9, 2, '0012'),
(15, 1, '0013'),
(8, 1, '0014'),
(17, 2, '0015'),
(12, 2, '0016'),
(3, 2, '0017'),
(5, 1, '0018'),
(12, 1, '0019'),
(20, 2, '0020');

-- --------------------------------------------------------

--
-- Table structure for table `groups`
--

CREATE TABLE IF NOT EXISTS `groups` (
  `group_id` int(20) NOT NULL,
  `group_name` varchar(100) DEFAULT NULL,
  PRIMARY KEY (`group_id`)
) ENGINE=InnoDB DEFAULT CHARSET=latin1;

--
-- Dumping data for table `groups`
--

INSERT INTO `groups` (`group_id`, `group_name`) VALUES
(1, 'employee'),
(2, 'employee');

-- --------------------------------------------------------

--
-- Table structure for table `project`
--

CREATE TABLE IF NOT EXISTS `project` (
  `project_id` int(20) NOT NULL,
  `project_name` varchar(100) DEFAULT NULL,
  `project_about` varchar(100) DEFAULT NULL,
  `project_description` varchar(255) DEFAULT NULL,
  `project_status` int(1) DEFAULT NULL,
  `project_time_alloted` datetime DEFAULT NULL,
  `project_created_date` datetime DEFAULT NULL,
  `project_manager_id` int(20) DEFAULT NULL,
  PRIMARY KEY (`project_id`),
  KEY `project_manager_id` (`project_manager_id`)
) ENGINE=InnoDB DEFAULT CHARSET=latin1;

--
-- Dumping data for table `project`
--

INSERT INTO `project` (`project_id`, `project_name`, `project_about`, `project_description`, `project_status`, `project_time_alloted`, `project_created_date`, `project_manager_id`) VALUES
(1, 'Tuner Piano', 'Administration', 'the last full measure of devotion  that we here highly resolve that these dead shall not ', 2, '2014-01-21 05:32:51', '2013-11-12 22:56:31', 16),
(2, 'Banking Head Of Lending', 'Research and Development', 'Archer is not completely devoid of a sensitive side however, as seen in Stage Two, when he believes that he may di', 3, '2014-03-01 20:15:27', '2013-11-29 12:55:31', 1),
(3, 'Sales Training Manager', 'Research and Development', 'he was growing up by Malory in The Double Deuce (Malory denies Seamus a toy, saying, "Did somebody trick ', 0, '2014-02-04 07:23:43', '2013-12-16 21:55:40', 6),
(4, 'Transformer Repairer', 'Purchasing', 'lacrosse, although flashbacks have indicated he had few friends. A picture of Archer in Placebo Effect shows Archer ', 1, '2014-01-26 22:00:10', '2013-10-19 19:17:27', 16),
(5, 'Clergy Member', 'Publications', 'Kane, which makes their working environment tenuous and difficult. At home, he employs an aging valet, Woodhouse ', 3, '2014-02-08 22:12:35', '2013-12-05 05:53:09', 13),
(6, 'Supervisor Powerline', 'Human Resources', 'graduating from Georgetown University, implying he is at least smart enough to receive a bachelors degree in an ', 3, '2014-02-14 04:03:19', '2013-12-25 20:58:33', 13),
(7, 'Supervisor Traffic', 'Accounts Payable', 'for the Johns Hopkins lacrosse team, as well as being stalked and subsequently shot by a mysterious woman, Ruth ', 2, '2014-02-26 07:31:44', '2014-01-04 05:34:59', 12),
(8, 'Flight Security Specialist', 'Facilities', 'over-dependent on his mother. Archer believed for most of his life that his father was a deceased, ', 1, '2014-01-26 17:13:42', '2013-11-21 08:36:54', 3),
(9, 'Medical Histotechnologist', 'Finance', 'agency "ISIS," located in New York City. ', 1, '2014-04-09 19:24:22', '2013-10-14 08:15:09', 17),
(10, 'Hydroelectric Station Operator', 'Facilities', 'may be KGB head Major Nikolai Jakov, ODIN director Len Trexler, or jazz drummer Buddy Rich. Later ', 2, '2014-03-07 04:41:43', '2013-10-17 12:10:06', 10),
(11, 'Sports Instructor', 'Maintenance', 'decorated Navy pilot, John Fitzgerald Archer. It was revealed in Dial M for Mother that his father ', 0, '2014-04-09 04:39:00', '2013-10-10 03:33:07', 1),
(12, 'Contact Lens Molder', 'Maintenance', 'you, hmm? See, that''s how the world works dear, and I''m the only one you can trust.") making Archer ', 1, '2014-02-10 12:44:36', '2014-01-07 22:18:43', 4),
(13, 'Repairer Safe', 'Purchasing', 'conceived in Liberty, and dedicated to the proposition that all men are created equal.', 2, '2014-01-28 06:32:45', '2013-10-29 22:34:55', 19),
(14, 'Occupational Analyst', 'Executive', 'Archer is first and foremost completely focused on himself, his needs and desires. If he aids another person, it ', 3, '2014-02-21 08:47:33', '2014-01-07 06:56:01', 13),
(15, 'Breeder Plant', 'Research and Development', 'here gave their lives that that nation might live. It is altogether fitting and proper that ', 3, '2014-01-19 09:59:56', '2014-01-11 11:10:54', 1),
(16, 'Lens Fabricating Machine Tender', 'Human Resources', 'equipment or goods, although he does not always trade to them items they want or need.', 0, '2014-03-04 00:55:43', '2014-01-17 21:06:39', 4),
(17, 'Research Mechanic', 'Purchasing', 'added to the list of possible fathers was an unnamed young Italian man who was gunned down in the ', 3, '2014-01-24 10:52:53', '2013-10-31 05:04:47', 14),
(18, 'Director Financial Analysis', 'Sales', 'Archer is not completely devoid of a sensitive side however, as seen in Stage Two, when he believes that he may di', 0, '2014-01-23 02:48:49', '2013-12-05 17:28:00', 14),
(19, 'Zoologist', 'Marketing', 'overthrew Guatemala''s government in 1954, making his birth year around 1948). He is a member of spy ', 1, '2014-02-07 13:08:12', '2013-11-28 00:02:13', 2),
(20, 'Librarian Music', 'Marketing', 'even more heart warming in hindsight after the second season reveal that alligators are one of Archer''s three biggest ', 3, '2014-01-22 10:38:14', '2013-10-23 11:45:41', 3),
(21, 'Packer Shipper', 'Purchasing', 'According to the episode, "Once Bitten" Sterling Archer was age six and celebrated his birthday ', 0, '2014-02-10 17:24:20', '2013-12-16 18:21:35', 13),
(22, 'Medical Laboratory Head', 'Research and Development', 'who contributed greatly to Archer''s parenting. Archer is voiced by H. Jon Benjamin.', 1, '2014-01-28 06:16:15', '2013-12-20 15:28:44', 12),
(23, 'Medical Magnetic Imaging Technologist', 'Human Resources', 'Now we are engaged in a great civil war, testing whether that nation, or any nation so ', 3, '2014-03-29 00:05:13', '2014-01-07 19:35:29', 1),
(24, 'Top Risk Management Executive', 'Accounts Payable', 'you, hmm? See, that''s how the world works dear, and I''m the only one you can trust.") making Archer ', 0, '2014-02-05 16:27:50', '2014-01-17 06:29:58', 9),
(25, 'Director Quality Assurance', 'Human Resources', 'unknown major. Woodhouse is present, also implying he is a better parent to Sterling than Malory who was not present. ', 0, '2014-01-28 17:19:59', '2013-11-13 11:18:13', 12),
(26, 'Marine Services Technician', 'Facilities', 'and mentions that he spent all night helping a giant Domnican guy bury his rooster in the everglades, This becomes ', 1, '2014-02-25 05:17:04', '2013-12-28 16:13:24', 7),
(27, 'Engineer Value', 'Maintenance', 'conceived in Liberty, and dedicated to the proposition that all men are created equal.', 1, '2014-04-15 06:00:05', '2014-01-06 17:13:23', 7),
(28, 'ERP Programmer', 'Finance', 'though Malory Archer denies this) and used to have an on-again, off-again relationship with fellow agent Lana ', 3, '2014-01-22 15:34:12', '2013-12-25 08:13:32', 16),
(29, 'Brush Painter', 'Purchasing', 'government of the people, by the people, for the people, shall not perish from the earth.', 0, '2014-01-24 18:32:39', '2013-10-19 17:54:36', 17),
(30, 'Shipping Packer', 'Administration', 'fears. In Heart of Archness:Pt 1, he saved Rip Riley from being attacked by a shark by pulling him out his destroyed ', 2, '2014-04-20 04:23:12', '2013-12-27 15:10:00', 2);

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
(15, 1),
(6, 2),
(9, 3),
(22, 4),
(4, 5),
(12, 6),
(10, 7),
(15, 8),
(16, 9),
(24, 10),
(1, 11),
(5, 12),
(21, 13),
(3, 14),
(4, 15),
(11, 16),
(2, 17),
(21, 18),
(24, 19),
(30, 20),
(18, 21),
(13, 22),
(1, 23),
(11, 24),
(26, 25),
(27, 26),
(30, 27),
(14, 28),
(12, 29),
(27, 30),
(14, 31),
(18, 32),
(27, 33),
(9, 34),
(9, 35),
(6, 36),
(20, 37),
(26, 38),
(21, 39),
(6, 40),
(8, 41),
(16, 42),
(8, 43),
(24, 44),
(14, 45),
(23, 46),
(30, 47),
(2, 48),
(7, 49),
(2, 50),
(17, 51),
(6, 52),
(12, 53),
(26, 54),
(19, 55),
(24, 56),
(14, 57),
(5, 58),
(3, 59),
(19, 60),
(25, 61),
(24, 62),
(18, 63),
(17, 64),
(25, 65),
(7, 66),
(2, 67),
(4, 68),
(17, 69),
(6, 70),
(7, 71),
(6, 72),
(10, 73),
(20, 74),
(16, 75),
(10, 76),
(17, 77),
(15, 78),
(22, 79),
(8, 80);

-- --------------------------------------------------------

--
-- Table structure for table `timesheet`
--

CREATE TABLE IF NOT EXISTS `timesheet` (
  `timesheet_id` int(20) NOT NULL,
  `timesheet_start_time` datetime DEFAULT NULL,
  `timesheet_end_time` datetime DEFAULT NULL,
  `timesheet_location` varchar(255) DEFAULT NULL,
  `timesheet_task` varchar(100) DEFAULT NULL,
  `timesheet_project_name` varchar(100) DEFAULT NULL,
  `timesheet_description` varchar(255) DEFAULT NULL,
  PRIMARY KEY (`timesheet_id`)
) ENGINE=InnoDB DEFAULT CHARSET=latin1;

--
-- Dumping data for table `timesheet`
--

INSERT INTO `timesheet` (`timesheet_id`, `timesheet_start_time`, `timesheet_end_time`, `timesheet_location`, `timesheet_task`, `timesheet_project_name`, `timesheet_description`) VALUES
(1, '2014-03-06 08:28:57', '2014-11-10 22:52:04', 'MONASTERIO DE IRANZU, PLAZA 63', 'Software engineer', 'Occupational Analyst', 'the last full measure of devotion  that we here highly resolve that these dead shall not '),
(2, '2014-03-17 15:16:29', '2014-08-27 17:22:27', 'ELIAS MUJICA 336', 'Fishmonger', 'Repairer Safe', 'Archer is first and foremost completely focused on himself, his needs and desires. If he aids another person, it '),
(3, '2014-01-20 04:20:33', '2014-07-11 08:43:38', 'GARBALLO 431', 'Haberdasher', 'Hydroelectric Station Operator', 'anyone who crosses him (or even sometimes merely crosses his path), he is also undeniably an intuitively good operat'),
(4, '2014-01-22 23:13:41', '2014-06-13 04:14:52', 'Temperley Road 418', 'Bacteriologist', 'Director Quality Assurance', 'advanced. It is rather for us to be here dedicated to the great task remaining before us '),
(5, '2014-02-25 12:17:39', '2014-09-21 15:35:09', 'Rosewood Dr 30', 'Baker', 'ERP Programmer', 'graduating from Georgetown University, implying he is at least smart enough to receive a bachelors degree in an '),
(6, '2014-03-12 13:31:50', '2014-09-16 13:24:19', 'CARBAJOSA, CARRETERA 44', 'Geologist', 'Medical Laboratory Head', 'who contributed greatly to Archer''s parenting. Archer is voiced by H. Jon Benjamin.'),
(7, '2014-02-22 03:20:41', '2015-01-28 02:08:00', 'Hollen Street 124', 'Theologian', 'Supervisor Powerline', 'anyone who crosses him (or even sometimes merely crosses his path), he is also undeniably an intuitively good operat'),
(8, '2014-03-13 04:56:58', '2014-08-02 02:52:43', 'ANGEL NUÑEZ 176', 'Software engineer', 'Tuner Piano', 'advanced. It is rather for us to be here dedicated to the great task remaining before us '),
(9, '2014-02-12 06:09:13', '2014-07-07 02:04:26', 'Via Turbigo 134', 'Exchequer', 'Librarian Music', 'ive with a fairly high degree of personal bravery, as shown during his escape from Moscow when he consistently ou'),
(10, '2014-02-08 22:54:38', '2014-12-28 21:47:16', 'Bulwer Road 207', 'Weaver', 'Director Financial Analysis', 'Anne Litzenberger. Sterling''s memories culminate in remembering his sixth birthday when his real father gave him '),
(11, '2014-03-10 05:07:30', '2014-05-29 09:38:38', 'S''ESPERO, (C/ D POLIGONO INDUSTRIAL) 156', 'Organist', 'Director Quality Assurance', 'alone, while his mother assisted in overthrowing the government of Guatemala (in reality the CIA '),
(12, '2014-03-08 22:42:51', '2014-08-15 01:02:46', 'Pollard Close 279', 'Coroner', 'ERP Programmer', 'crying over the death of his slain rooster. The next time we see Archer, he is covered in dirt and carrying a shovel, '),
(13, '2014-01-25 19:25:37', '2014-09-07 16:06:21', 'Joseph Ave 38', 'Dog breeder', 'Medical Magnetic Imaging Technologist', 'here, but it can never forget what they did here. It is for us the living, rather, to be '),
(14, '2014-01-28 20:49:42', '2015-01-30 09:25:06', 'AZTECA, PLAZA 333', 'Contract Manager', 'Contact Lens Molder', 'who contributed greatly to Archer''s parenting. Archer is voiced by H. Jon Benjamin.'),
(15, '2014-02-04 01:17:39', '2014-08-29 08:35:24', 'Thorpe Hall Road 16', 'Baker', 'Brush Painter', 'even more heart warming in hindsight after the second season reveal that alligators are one of Archer''s three biggest '),
(16, '2014-03-11 16:39:25', '2015-01-09 12:55:53', 'Smiths Yard 55', 'Agronomist', 'Medical Histotechnologist', 'graduating from Georgetown University, implying he is at least smart enough to receive a bachelors degree in an '),
(17, '2014-02-13 08:28:48', '2014-08-10 02:13:40', 'Ashbury Place 12', 'Dramatist', 'Transformer Repairer', 'added to the list of possible fathers was an unnamed young Italian man who was gunned down in the '),
(18, '2014-02-16 18:24:11', '2014-09-12 10:17:33', 'ARZOBISPO GELMIREZ 209', 'Truck Driver', 'Zoologist', 'our poor power to add or detract. The world will little note, nor long remember what we say '),
(19, '2014-03-18 13:52:06', '2014-10-30 02:24:08', 'St Barnabas Road 248', 'Police officer', 'Engineer Value', 'for the Johns Hopkins lacrosse team, as well as being stalked and subsequently shot by a mysterious woman, Ruth '),
(20, '2014-03-08 12:57:33', '2015-01-25 07:41:50', 'Champion Hill Terrace 236', 'Tinsmith', 'Hydroelectric Station Operator', 'ive with a fairly high degree of personal bravery, as shown during his escape from Moscow when he consistently ou'),
(21, '2014-01-24 20:01:24', '2014-04-07 18:38:05', 'BERILIO 216', 'Information Technologist', 'Supervisor Traffic', 'lly intended his last words to be "F*** you, you douchebags."'),
(22, '2014-02-28 06:13:22', '2014-11-25 17:42:10', 'Broom Hall 410', 'Pawnbroker', 'Director Financial Analysis', 'finds himself in a bar that hosts chicken-fighting matches. A big, weeping Dominican man is sitting next to him, '),
(23, '2014-02-02 08:50:20', '2014-10-30 15:38:09', 'Camden Gardens 186', 'General', 'Director Financial Analysis', 'unknown major. Woodhouse is present, also implying he is a better parent to Sterling than Malory who was not present. '),
(24, '2014-02-24 07:48:20', '2014-11-17 09:11:25', 'CANEDO 392', 'Weaver', 'Tuner Piano', 'His relation with his mother Malory—who is also his boss at ISIS—is often strained, never sympathetic, '),
(25, '2014-01-23 05:28:22', '2014-04-12 14:52:19', 'EGUIA, CALZADA DE 149', 'Ecologist', 'Occupational Analyst', 'Archer is first and foremost completely focused on himself, his needs and desires. If he aids another person, it '),
(26, '2014-02-28 23:48:33', '2014-12-29 09:21:04', 'RIU FRESSER, PASSATGE 190', 'Diver', 'Tuner Piano', 'with the wee baby Seamus over the course of the episode as he considers him the closest that he will ever get to having a'),
(27, '2014-02-01 12:23:10', '2014-06-30 16:07:34', 'CENICEROS 477', 'Receptionist', 'Occupational Analyst', 'advanced. It is rather for us to be here dedicated to the great task remaining before us '),
(28, '2014-03-06 06:10:19', '2015-01-13 06:37:11', 'SIGUES 332', 'Translator', 'Engineer Value', 'even more heart warming in hindsight after the second season reveal that alligators are one of Archer''s three biggest '),
(29, '2014-01-20 14:34:32', '2014-10-16 01:28:49', 'HEROES DE LA DIVISION AZUL 288', 'Sex worker', 'Contact Lens Molder', 'we should do this.'),
(30, '2014-02-20 04:02:18', '2014-12-14 11:59:55', 'CONCEJAL MASSO ROURA 105', 'Solicitor', 'Occupational Analyst', 'conceived in Liberty, and dedicated to the proposition that all men are created equal.'),
(31, '2014-02-05 23:58:48', '2015-01-05 02:24:17', 'CIUTAT DE MALLORCA, PASSATGE 202', 'CEO', 'Clergy Member', 'he was growing up by Malory in The Double Deuce (Malory denies Seamus a toy, saying, "Did somebody trick '),
(32, '2014-01-29 04:41:19', '2014-07-18 23:50:13', 'OLIMPIA 413', 'Park ranger', 'Supervisor Powerline', 'Archer is not completely devoid of a sensitive side however, as seen in Stage Two, when he believes that he may di'),
(33, '2014-02-17 20:33:04', '2014-12-21 06:42:35', 'Bective Villas 29', 'Game designer', 'Librarian Music', 'the last full measure of devotion  that we here highly resolve that these dead shall not '),
(34, '2014-01-23 15:45:40', '2014-05-27 10:16:51', 'Colina Road 346', 'Correspondent', 'Director Quality Assurance', 'for the Johns Hopkins lacrosse team, as well as being stalked and subsequently shot by a mysterious woman, Ruth '),
(35, '2014-02-20 04:37:32', '2015-02-06 08:29:42', 'Burns St 54', 'Tax Collector', 'Banking Head Of Lending', 'and mentions that he spent all night helping a giant Domnican guy bury his rooster in the everglades, This becomes '),
(36, '2014-01-23 07:49:58', '2014-09-05 16:50:28', 'MERCAT, PASSATGE 268', 'Servant', 'Research Mechanic', 'Anne Litzenberger. Sterling''s memories culminate in remembering his sixth birthday when his real father gave him '),
(37, '2014-03-19 08:59:57', '2015-01-27 01:25:55', 'Vinson St 211', 'Sleuth', 'Packer Shipper', 'with the wee baby Seamus over the course of the episode as he considers him the closest that he will ever get to having a'),
(38, '2014-02-05 03:52:43', '2014-10-03 02:18:47', 'Burdett  St 383', 'Shepherd', 'Tuner Piano', 'advanced. It is rather for us to be here dedicated to the great task remaining before us '),
(39, '2014-03-12 14:29:38', '2014-06-05 12:13:09', 'Dennington Park Road 137', 'Administrator', 'Medical Magnetic Imaging Technologist', 'we should do this.'),
(40, '2014-03-17 10:41:57', '2014-07-07 07:08:18', 'Biscayne  Ave 137', 'Educator', 'Medical Laboratory Head', 'have died in vain that this nation, under God, shall have a new birth of freedom and that '),
(41, '2014-02-13 14:49:20', '2015-01-05 15:22:13', 'ARQUITECTE LAMARCA 83', 'Civil engineer', 'Packer Shipper', 'here, but it can never forget what they did here. It is for us the living, rather, to be '),
(42, '2014-02-15 10:07:18', '2015-02-01 18:42:22', 'ANTONINUS PIUS 147', 'Muralist', 'Marine Services Technician', 'It is revealed in Fugue and Riffs that for a short period of time, he assumed the identity of Bob Belcher from the show Bob''s Burgers. The reason for this sudden life-change is that he entered a fugue state (stress-induced amnesia) following Malory''s wedd'),
(43, '2014-02-05 10:11:57', '2014-04-11 15:08:03', 'PASQUAL I VILA 81', 'Philosopher', 'Breeder Plant', 'for the Johns Hopkins lacrosse team, as well as being stalked and subsequently shot by a mysterious woman, Ruth '),
(44, '2014-02-16 13:35:54', '2014-04-16 12:34:29', 'Luxmore Street 84', 'Tanner', 'Repairer Safe', 'He spent up to fifteen years at boarding school, despite American schooling taking thirteen years. His hobby was '),
(45, '2014-02-02 19:24:49', '2014-08-26 13:46:34', 'Gough Road 239', 'Bacteriologist', 'Brush Painter', 'It is revealed in Fugue and Riffs that for a short period of time, he assumed the identity of Bob Belcher from the show Bob''s Burgers. The reason for this sudden life-change is that he entered a fugue state (stress-induced amnesia) following Malory''s wedd'),
(46, '2014-02-07 21:46:52', '2014-04-14 11:37:32', 'TEATINOS, CUESTA 99', 'Gynecologist', 'ERP Programmer', 'with the wee baby Seamus over the course of the episode as he considers him the closest that he will ever get to having a'),
(47, '2014-02-19 23:57:42', '2014-10-30 04:13:46', 'Mountain Creek St 292', 'Moldmaker', 'Hydroelectric Station Operator', 'with the wee baby Seamus over the course of the episode as he considers him the closest that he will ever get to having a'),
(48, '2014-01-31 01:44:04', '2014-09-19 03:16:25', 'Bellamy  Ave 11', 'Necromancer', 'Transformer Repairer', 'But, in a larger sense, we can not dedicate we can not consecrate we can not hallow this '),
(49, '2014-02-12 16:21:45', '2014-09-13 09:40:31', 'Mercy Terrace 140', 'Chemical Technologist', 'Engineer Value', 'is always because he will somehow benefit. He does, however, insist upon compensating anyone from whom he commandeers '),
(50, '2014-03-18 23:38:34', '2014-12-22 18:30:41', 'LUCA DE TENA, PLAZA 169', 'Courier', 'Contact Lens Molder', 'According to the episode, "Once Bitten" Sterling Archer was age six and celebrated his birthday '),
(51, '2014-03-05 18:54:55', '2014-12-10 03:30:17', 'Carlisle Avenue 289', 'Music Director', 'Research Mechanic', 'for the Johns Hopkins lacrosse team, as well as being stalked and subsequently shot by a mysterious woman, Ruth '),
(52, '2014-01-27 03:12:30', '2014-03-27 08:17:52', 'MESTRE MATEO 8', 'Novelist', 'Engineer Value', 'His relation with his mother Malory—who is also his boss at ISIS—is often strained, never sympathetic, '),
(53, '2014-02-21 13:55:24', '2014-10-24 16:48:38', 'SANTUARIO DE LA VIRGEN DE LA MONTAÑA 1', 'Stuffer', 'Lens Fabricating Machine Tender', 'Kane, which makes their working environment tenuous and difficult. At home, he employs an aging valet, Woodhouse '),
(54, '2014-02-24 00:22:29', '2015-01-29 15:05:21', 'Little Brook Street 157', 'Social worker', 'Occupational Analyst', 'and mentions that he spent all night helping a giant Domnican guy bury his rooster in the everglades, This becomes '),
(55, '2014-02-19 22:48:08', '2014-03-25 09:33:22', 'Hunter  St 192', 'Firefighter', 'Packer Shipper', ' from breast cancer, he demonstrates considerable regret at his treatment of his co-workers at ISIS, buying Pam and '),
(56, '2014-02-17 14:36:09', '2014-08-17 12:39:47', 'Kaiserring 211', 'Anthropologist', 'Flight Security Specialist', 'the last full measure of devotion  that we here highly resolve that these dead shall not '),
(57, '2014-01-29 18:30:02', '2014-08-15 18:24:11', 'SANTA ELVIRA 398', 'Physical Therapist', 'Director Quality Assurance', 'decorated Navy pilot, John Fitzgerald Archer. It was revealed in Dial M for Mother that his father '),
(58, '2014-01-29 08:37:08', '2014-08-28 18:17:39', 'Garrick Industrial Centre 334', 'Video game developer', 'Supervisor Powerline', 'Four score and seven years ago our fathers brought forth on this continent, a new nation, '),
(59, '2014-01-19 02:18:38', '2014-09-27 07:17:45', 'Kareela  Rd 55', 'Broker', 'ERP Programmer', 'guide. James shows Archer memories that Sterling had blocked out. These include a visit to Baltimore to try out'),
(60, '2014-02-22 03:23:29', '2014-09-29 22:19:47', 'Duikersloot 446', 'Netmaker', 'Research Mechanic', ' from breast cancer, he demonstrates considerable regret at his treatment of his co-workers at ISIS, buying Pam and '),
(61, '2014-01-31 07:24:00', '2014-09-06 00:51:40', 'SILLEDA 127', 'Police officer', 'Supervisor Traffic', 'here, but it can never forget what they did here. It is for us the living, rather, to be '),
(62, '2014-02-01 18:02:05', '2014-05-13 09:44:05', 'Trevor Square 82', 'Consul', 'ERP Programmer', 'He spent up to fifteen years at boarding school, despite American schooling taking thirteen years. His hobby was '),
(63, '2014-03-16 08:18:06', '2014-04-13 15:55:44', 'Paisley  Rd 372', 'Farmer', 'Marine Services Technician', 'Although he has numerous personality flaws, such as insensitivity, egotism, and a casual attitude towards murdering '),
(64, '2014-02-03 16:25:48', '2014-12-30 20:47:42', 'CABELLO 84', 'Tea lady', 'Marine Services Technician', 'is always because he will somehow benefit. He does, however, insist upon compensating anyone from whom he commandeers '),
(65, '2014-02-14 07:05:46', '2014-07-02 23:33:21', 'COMENDADORAS DE SANTIAGO 437', 'Bailiff', 'Medical Magnetic Imaging Technologist', 'he was growing up by Malory in The Double Deuce (Malory denies Seamus a toy, saying, "Did somebody trick '),
(66, '2014-01-20 00:32:44', '2014-08-12 12:19:09', 'ESPAÑA, PRAZA 58', 'Messenger', 'Librarian Music', 'twitted and outfought the numerous soldiers dispatched to recapture him despite never having a functional firearm '),
(67, '2014-03-18 06:10:46', '2014-08-03 13:18:48', 'Roffs Wharf 196', 'Mechanical engineer', 'Banking Head Of Lending', 'As a result of this long classical education and friendlessness, Archer is surprisingly well-read.'),
(68, '2014-03-07 03:46:20', '2014-08-16 14:54:40', 'Carnegie Street 136', 'Call girl', 'Medical Magnetic Imaging Technologist', 'lacrosse, although flashbacks have indicated he had few friends. A picture of Archer in Placebo Effect shows Archer '),
(69, '2014-03-12 21:15:46', '2015-01-25 01:47:50', 'Bray Rd 393', 'Manufacturer', 'ERP Programmer', 'agency "ISIS," located in New York City. '),
(70, '2014-02-13 15:02:24', '2014-11-16 22:40:24', 'Roger Street 487', 'Fishmonger', 'Repairer Safe', 'and sometimes bluntly abusive. It is implied that Archer was exposed to "negative reinforcement" when '),
(71, '2014-02-27 17:38:48', '2015-01-10 12:49:40', 'Shannon  Cl 439', 'Systems designer', 'ERP Programmer', 'he was growing up by Malory in The Double Deuce (Malory denies Seamus a toy, saying, "Did somebody trick '),
(72, '2014-02-07 11:03:57', '2014-11-22 01:33:21', 'Clennam Street 261', 'Seamstress', 'Engineer Value', 'here gave their lives that that nation might live. It is altogether fitting and proper that '),
(73, '2014-03-11 20:49:22', '2014-05-13 02:07:28', 'Old Narrrandera  Rd 259', 'Physician Assistant', 'Research Mechanic', 'here, but it can never forget what they did here. It is for us the living, rather, to be '),
(74, '2014-03-11 22:46:28', '2014-07-09 23:58:13', 'Riverside St 297', 'Baker', 'Lens Fabricating Machine Tender', 'In the Season 4 episode, Once Bitten, Sterling revisits his past led by a cut-rate James Mason, as his spirit '),
(75, '2014-03-14 12:06:25', '2014-08-04 08:52:19', 'Oude Roswinkelerweg 53', 'Dramaturg', 'Transformer Repairer', 'Now we are engaged in a great civil war, testing whether that nation, or any nation so '),
(76, '2014-02-03 13:46:36', '2014-04-23 16:46:48', 'Boulevard Diderot 463', 'Beadle', 'Clergy Member', 'He spent up to fifteen years at boarding school, despite American schooling taking thirteen years. His hobby was '),
(77, '2014-02-14 04:15:36', '2014-09-07 19:02:51', 'Hartsmead Road 402', 'Pedologist', 'Breeder Plant', 'and mentions that he spent all night helping a giant Domnican guy bury his rooster in the everglades, This becomes '),
(78, '2014-01-28 20:43:46', '2015-01-14 09:48:01', 'Moccasin Ct 460', 'Recording engineer', 'Director Financial Analysis', 'he was growing up by Malory in The Double Deuce (Malory denies Seamus a toy, saying, "Did somebody trick '),
(79, '2014-02-12 05:57:13', '2014-03-24 05:07:29', 'JUAN XXIII, PASEO 415', 'Bhikkhu', 'Lens Fabricating Machine Tender', 'dedicated here to the unfinished work which they who fought here have thus far so nobly '),
(80, '2014-03-01 22:29:23', '2014-11-22 15:03:22', 'JAN, COSTA DEL 415', 'Audiologist', 'Zoologist', 'As a result of this long classical education and friendlessness, Archer is surprisingly well-read.');

-- --------------------------------------------------------

--
-- Table structure for table `user`
--

CREATE TABLE IF NOT EXISTS `user` (
  `user_id` int(20) NOT NULL,
  `user_name` varchar(100) DEFAULT NULL,
  `user_email` varchar(100) DEFAULT NULL,
  `user_location` varchar(255) DEFAULT NULL,
  PRIMARY KEY (`user_id`)
) ENGINE=InnoDB DEFAULT CHARSET=latin1;

--
-- Dumping data for table `user`
--

INSERT INTO `user` (`user_id`, `user_name`, `user_email`, `user_location`) VALUES
(1, 'Rasmus', 'A.Quade@home.de', 'Hofmannstr. 190'),
(2, 'Nate', 'J.Elmer@hotmail.info', 'Boardman Avenue 385'),
(3, 'Cecilie', 'N.Hoedt den@uolmail.co.jp', 'Plaistow Road 469'),
(4, 'Rachel', 'M.Hita@ukmail.tv', 'PERON, PLAZA 251'),
(5, 'Stephen', 'R.Szymanski@usmail.gr', 'Pritchards Place 415'),
(6, 'Coby', 'B.Bellinger@emailplanet.de', 'Spearman  St 227'),
(7, 'Victor', 'B.Marchese@mighty.br', 'Palace Parade 478'),
(8, 'Adrian', 'Y.Estua@sina.hr', 'Blackmans Court 2'),
(9, 'Lara', 'P.Pires@netscape.hr', 'Virgo St 231'),
(10, 'Harold', 'W.Santamaria@mail.excite.au', 'Moncrieff Street 100'),
(11, 'Duncan', 'H.Senter@sina.tv', 'GORBEA 410'),
(12, 'Francisco', 'D.Pedrosa@nexmail.co.kr', 'BERNAT VISCA 7'),
(13, 'Andrzej', 'E.Potappel@yupi.com', 'Orme Square 228'),
(14, 'Ollie', 'F.Urguia@alloymail.co.jp', 'PEDRO I 321'),
(15, 'Betty', 'R.Greenfield@doramail.org', 'Swiss Cottages 393'),
(16, 'Tyler', 'O.Falcon@mailasia.com.mx', 'Roto Station  p 179'),
(17, 'Sarah', 'L.Berlicum van@go.mn', 'PALOS 24'),
(18, 'Nick', 'G.Barfield@doramail.co.uk', 'Via Toselli Pietro 99'),
(19, 'Johnny', 'R.Roldan@go.fr', 'Ravenscroft Avenue 340'),
(20, 'Jody', 'H.Bratton@yupi.au', 'ARCEDIANO SALDAÑA 369');

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
(9, 17),
(3, 13),
(7, 21),
(5, 1),
(16, 19),
(10, 28),
(8, 4),
(18, 23),
(16, 27),
(4, 23),
(20, 19),
(16, 2),
(7, 27),
(1, 5),
(10, 6),
(10, 29),
(19, 14),
(15, 28),
(13, 8),
(13, 15),
(17, 30),
(12, 12),
(6, 23),
(5, 29),
(3, 12),
(18, 26),
(15, 7),
(11, 18),
(5, 15),
(3, 18);

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
(18, 4),
(6, 1),
(13, 10),
(5, 37),
(1, 71),
(4, 70),
(2, 48),
(6, 12),
(19, 65),
(9, 44),
(2, 73),
(5, 56),
(2, 76),
(8, 70),
(8, 35),
(10, 78),
(7, 59),
(5, 80),
(9, 12),
(5, 28),
(20, 57),
(10, 14),
(5, 42),
(8, 24),
(16, 72),
(6, 63),
(11, 70),
(17, 9),
(19, 54),
(8, 23),
(9, 23),
(17, 56),
(13, 21),
(7, 22),
(19, 16),
(19, 33),
(6, 65),
(16, 50),
(7, 32),
(3, 78),
(8, 80),
(10, 54),
(8, 59),
(2, 33),
(17, 12),
(6, 35),
(8, 22),
(5, 10),
(11, 3),
(10, 78),
(14, 6),
(9, 76),
(12, 10),
(14, 58),
(16, 41),
(18, 24),
(5, 36),
(15, 75),
(6, 13),
(3, 35),
(15, 2),
(3, 17),
(9, 22),
(17, 55),
(19, 70),
(13, 79),
(20, 62),
(9, 66),
(19, 39),
(6, 19),
(6, 65),
(3, 37),
(1, 80),
(13, 10),
(14, 75),
(16, 43),
(6, 68),
(10, 60),
(5, 63),
(2, 62);

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
