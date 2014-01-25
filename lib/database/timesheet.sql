-- phpMyAdmin SQL Dump
-- version 4.0.9
-- http://www.phpmyadmin.net
--
-- Host: 127.0.0.1
-- Generation Time: Jan 25, 2014 at 07:13 AM
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
(14, 1, '0001'),
(8, 2, '0002'),
(5, 2, '0003'),
(17, 1, '0004'),
(20, 1, '0005'),
(17, 2, '0006'),
(19, 1, '0007'),
(3, 1, '0008'),
(18, 1, '0009'),
(5, 2, '0010'),
(7, 1, '0011'),
(11, 2, '0012'),
(6, 2, '0013'),
(12, 2, '0014'),
(11, 1, '0015'),
(16, 1, '0016'),
(20, 1, '0017'),
(18, 2, '0018'),
(10, 1, '0019'),
(16, 1, '0020');

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
(1, 'employer'),
(2, 'employer');

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
) ENGINE=InnoDB  DEFAULT CHARSET=latin1 AUTO_INCREMENT=51 ;

--
-- Dumping data for table `notification`
--

INSERT INTO `notification` (`notification_id`, `notification_body`, `notification_priority`, `notification_read`) VALUES
(1, 'we should do this.', 2, 1),
(2, 'Four score and seven years ago our fathers brought forth on this continent, a new nation, ', 2, 0),
(3, ' from breast cancer, he demonstrates considerable regret at his treatment of his co-workers at ISIS, buying Pam and ', 2, 1),
(4, 'Although he has numerous personality flaws, such as insensitivity, egotism, and a casual attitude towards murdering ', 0, 1),
(5, 'ground. The brave men, living and dead, who struggled here, have consecrated it, far above ', 1, 1),
(6, 'conceived and so dedicated, can long endure. We are met on a great battle-field of that war.', 0, 1),
(7, 'a stuffed alligator.  He, unfortunately, awakens before remembering his father''s face.', 2, 0),
(8, 'government of the people, by the people, for the people, shall not perish from the earth.', 0, 0),
(9, 'Archer has the less than masculine codename of "Duchess" (taken from his mother''s beloved Afghan wolfhound, ', 2, 1),
(10, 'and sometimes bluntly abusive. It is implied that Archer was exposed to "negative reinforcement" when ', 1, 0),
(11, 'though Malory Archer denies this) and used to have an on-again, off-again relationship with fellow agent Lana ', 1, 0),
(12, 'over-dependent on his mother. Archer believed for most of his life that his father was a deceased, ', 1, 0),
(13, 'ground. The brave men, living and dead, who struggled here, have consecrated it, far above ', 0, 0),
(14, 'and mentions that he spent all night helping a giant Domnican guy bury his rooster in the everglades, This becomes ', 0, 1),
(15, 'finds himself in a bar that hosts chicken-fighting matches. A big, weeping Dominican man is sitting next to him, ', 2, 0),
(16, 'with the wee baby Seamus over the course of the episode as he considers him the closest that he will ever get to having a', 1, 1),
(17, 'streets of Italy and had "blue eyes, full lips and thick wavy hair".[1]', 2, 0),
(18, 'who contributed greatly to Archer''s parenting. Archer is voiced by H. Jon Benjamin.', 2, 0),
(19, ' child, going so far as to have "Seamus" tattooed on his back in recognition of that affection.  Additionally, ', 2, 0),
(20, 'Four score and seven years ago our fathers brought forth on this continent, a new nation, ', 0, 0),
(21, ' from breast cancer, he demonstrates considerable regret at his treatment of his co-workers at ISIS, buying Pam and ', 2, 1),
(22, 'here, but it can never forget what they did here. It is for us the living, rather, to be ', 0, 1),
(23, 'Archer is not completely devoid of a sensitive side however, as seen in Stage Two, when he believes that he may di', 2, 1),
(24, 'we should do this.', 1, 0),
(25, 'you, hmm? See, that''s how the world works dear, and I''m the only one you can trust.") making Archer ', 2, 1),
(26, 'decorated Navy pilot, John Fitzgerald Archer. It was revealed in Dial M for Mother that his father ', 0, 1),
(27, 'for the Johns Hopkins lacrosse team, as well as being stalked and subsequently shot by a mysterious woman, Ruth ', 2, 1),
(28, 'Now we are engaged in a great civil war, testing whether that nation, or any nation so ', 2, 1),
(29, ' from breast cancer, he demonstrates considerable regret at his treatment of his co-workers at ISIS, buying Pam and ', 1, 1),
(30, 'conceived in Liberty, and dedicated to the proposition that all men are created equal.', 2, 0),
(31, ' Lana the last set of scuba gear and tells her he loves her before drowning to be rescucitated). Archer also bonds ', 1, 1),
(32, 'Archer is not completely devoid of a sensitive side however, as seen in Stage Two, when he believes that he may di', 2, 0),
(33, 'His relation with his mother Malory—who is also his boss at ISIS—is often strained, never sympathetic, ', 0, 0),
(34, 'ive with a fairly high degree of personal bravery, as shown during his escape from Moscow when he consistently ou', 1, 0),
(35, 'Cheryl bunches of roses and later stating to Lana Kane that he still loves her (also in the season 4 finale he gives', 2, 0),
(36, 'he was growing up by Malory in The Double Deuce (Malory denies Seamus a toy, saying, "Did somebody trick ', 1, 1),
(37, 'agency "ISIS," located in New York City. ', 0, 1),
(38, 'It is revealed in Fugue and Riffs that for a short period of time, he assumed the identity of Bob Belcher from the show Bob''s Burgers. The reason for this sudden life-change is that he entered a fugue state (stress-induced amnesia) following Malory''s wedd', 0, 0),
(39, 'here, but it can never forget what they did here. It is for us the living, rather, to be ', 0, 1),
(40, 'he was growing up by Malory in The Double Deuce (Malory denies Seamus a toy, saying, "Did somebody trick ', 1, 1),
(41, 'Now we are engaged in a great civil war, testing whether that nation, or any nation so ', 2, 1),
(42, 'Now we are engaged in a great civil war, testing whether that nation, or any nation so ', 1, 1),
(43, ' from breast cancer, he demonstrates considerable regret at his treatment of his co-workers at ISIS, buying Pam and ', 2, 0),
(44, 'have died in vain that this nation, under God, shall have a new birth of freedom and that ', 2, 0),
(45, 'is always because he will somehow benefit. He does, however, insist upon compensating anyone from whom he commandeers ', 0, 1),
(46, 'government of the people, by the people, for the people, shall not perish from the earth.', 0, 1),
(47, 'conceived in Liberty, and dedicated to the proposition that all men are created equal.', 0, 1),
(48, 'It is revealed in Fugue and Riffs that for a short period of time, he assumed the identity of Bob Belcher from the show Bob''s Burgers. The reason for this sudden life-change is that he entered a fugue state (stress-induced amnesia) following Malory''s wedd', 0, 1),
(49, 'unknown major. Woodhouse is present, also implying he is a better parent to Sterling than Malory who was not present. ', 0, 1),
(50, 'equipment or goods, although he does not always trade to them items they want or need.', 1, 0);

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
(1, 'Aide Laboratory', 'Quality Assurance', 'guide. James shows Archer memories that Sterling had blocked out. These include a visit to Baltimore to try out', 0, '2014-03-17 07:02:08', '2014-01-08 14:49:45', 18, 62963),
(2, 'Wage & Salary Manager', 'Marketing', 'streets of Italy and had "blue eyes, full lips and thick wavy hair".[1]', 0, '2014-03-07 13:21:49', '2013-12-22 15:56:57', 8, 175945),
(3, 'Research Chemist', 'Human Resources', 'finds himself in a bar that hosts chicken-fighting matches. A big, weeping Dominican man is sitting next to him, ', 1, '2014-01-26 18:07:36', '2014-01-07 23:39:50', 17, 272422),
(4, 'Social Services Director', 'Human Resources', 'alone, while his mother assisted in overthrowing the government of Guatemala (in reality the CIA ', 0, '2014-01-30 13:53:56', '2013-10-27 04:09:35', 6, 357064),
(5, 'LAN/WAN Analyst', 'Marketing', 'His relation with his mother Malory—who is also his boss at ISIS—is often strained, never sympathetic, ', 3, '2014-02-13 05:43:47', '2013-10-24 00:01:49', 12, 297273),
(6, 'Technician Hot Cell', 'Finance', 'Anne Litzenberger. Sterling''s memories culminate in remembering his sixth birthday when his real father gave him ', 1, '2014-01-26 13:09:40', '2013-12-02 21:28:51', 3, 83406),
(7, 'Warehouse Manager', 'Administration', 'he establishes a friendship with a fellow cancer patient, Ruth. Another example of this is in Honeypot when Archer ', 3, '2014-03-22 07:44:29', '2013-11-24 11:01:47', 19, 244929),
(8, 'Crusher Tender', 'Marketing', 'he was growing up by Malory in The Double Deuce (Malory denies Seamus a toy, saying, "Did somebody trick ', 3, '2014-04-14 02:02:34', '2013-11-14 01:42:47', 15, 426516),
(9, 'Marine Cargo Surveyor', 'Marketing', 'His relation with his mother Malory—who is also his boss at ISIS—is often strained, never sympathetic, ', 1, '2014-02-08 02:10:32', '2014-01-05 12:47:13', 19, 116082),
(10, 'Optical Lens Machine Tender', 'Accounts Payable', 'As a result of this long classical education and friendlessness, Archer is surprisingly well-read.', 3, '2014-04-05 15:48:15', '2013-11-25 18:55:50', 15, 27752),
(11, 'Technician Offset Press (Press Above 26 Inches)', 'Quality Assurance', 'here, but it can never forget what they did here. It is for us the living, rather, to be ', 2, '2014-03-27 19:39:47', '2014-01-03 16:56:59', 13, 147769),
(12, 'Medical Prosthetics Assistant', 'Marketing', 'He spent up to fifteen years at boarding school, despite American schooling taking thirteen years. His hobby was ', 2, '2014-01-29 06:34:19', '2013-11-03 21:58:48', 6, 431342),
(13, 'Actuary (Associate)', 'Administration', 'finds himself in a bar that hosts chicken-fighting matches. A big, weeping Dominican man is sitting next to him, ', 3, '2014-02-20 15:57:07', '2013-11-25 17:11:22', 4, 158429),
(14, 'Assistant Porcelain Buildup', 'Sales', 'and mentions that he spent all night helping a giant Domnican guy bury his rooster in the everglades, This becomes ', 0, '2014-03-17 03:50:26', '2013-12-26 00:58:56', 19, 439456),
(15, 'Director Materials', 'Human Resources', 'fears. In Heart of Archness:Pt 1, he saved Rip Riley from being attacked by a shark by pulling him out his destroyed ', 3, '2014-04-20 08:24:28', '2013-12-06 11:42:05', 14, 389973),
(16, 'Insurance Adjustor Claims', 'Sales', 'guide. James shows Archer memories that Sterling had blocked out. These include a visit to Baltimore to try out', 3, '2014-02-02 10:58:17', '2014-01-15 09:49:55', 16, 447257),
(17, 'Writer Specifications', 'Publications', 'unknown major. Woodhouse is present, also implying he is a better parent to Sterling than Malory who was not present. ', 0, '2014-03-26 20:30:47', '2013-10-11 01:42:14', 3, 353838),
(18, 'Printer Operator Color', 'Facilities', 'and "three pounds of glass" in his feet. When he was finally cornered in an elevator, he blindfolded himself and fu', 1, '2014-04-18 21:41:36', '2014-01-06 20:41:46', 5, 290975),
(19, 'Attorney Director Legal', 'Administration', 'ive with a fairly high degree of personal bravery, as shown during his escape from Moscow when he consistently ou', 2, '2014-02-15 02:22:03', '2013-12-29 13:56:19', 9, 172057),
(20, 'Buffing Machine Tender', 'Production', ' We have come to dedicate a portion of that field, as a final resting place for those who ', 1, '2014-01-31 12:36:07', '2013-12-29 18:30:58', 2, 89960),
(21, 'Animal Trainer', 'Publications', 'for the Johns Hopkins lacrosse team, as well as being stalked and subsequently shot by a mysterious woman, Ruth ', 2, '2014-03-06 15:11:17', '2013-11-09 03:10:15', 3, 421317),
(22, 'Director Materials Management', 'Finance', 'have died in vain that this nation, under God, shall have a new birth of freedom and that ', 2, '2014-01-22 07:39:37', '2013-11-25 23:30:23', 6, 90750),
(23, 'Singer', 'Accounts Payable', 'Four score and seven years ago our fathers brought forth on this continent, a new nation, ', 1, '2014-03-21 07:48:32', '2013-11-21 18:41:22', 14, 480022),
(24, 'Supervisor Computer Operations', 'Quality Assurance', 'anyone who crosses him (or even sometimes merely crosses his path), he is also undeniably an intuitively good operat', 3, '2014-03-31 22:41:55', '2013-11-04 17:39:17', 2, 12134),
(25, 'Annuities Representative', 'Facilities', 'have died in vain that this nation, under God, shall have a new birth of freedom and that ', 0, '2014-01-21 01:10:53', '2013-12-31 10:48:23', 20, 368358),
(26, 'Attorney Tax', 'Administration', 'though Malory Archer denies this) and used to have an on-again, off-again relationship with fellow agent Lana ', 1, '2014-03-17 09:54:51', '2013-11-16 15:13:21', 15, 386209),
(27, 'Inspector Quality Control', 'Finance', 'here, but it can never forget what they did here. It is for us the living, rather, to be ', 0, '2014-02-09 08:52:25', '2013-10-13 21:21:27', 15, 93351),
(28, 'Structural Engineer', 'Administration', 'anyone who crosses him (or even sometimes merely crosses his path), he is also undeniably an intuitively good operat', 2, '2014-02-28 18:22:18', '2013-10-13 13:14:41', 14, 406447),
(29, 'Engineering Laboratory Technician', 'Purchasing', 'decorated Navy pilot, John Fitzgerald Archer. It was revealed in Dial M for Mother that his father ', 2, '2014-03-29 05:34:17', '2013-12-25 14:12:05', 1, 490937),
(30, 'Manager Laundry', 'Facilities', 'twitted and outfought the numerous soldiers dispatched to recapture him despite never having a functional firearm ', 3, '2014-02-01 18:30:10', '2013-12-15 14:01:46', 6, 266760);

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
(22, 1),
(10, 2),
(10, 3),
(27, 4),
(20, 5),
(9, 6),
(22, 7),
(29, 8),
(6, 9),
(16, 10),
(11, 11),
(19, 12),
(13, 13),
(6, 14),
(7, 15),
(18, 16),
(9, 17),
(23, 18),
(17, 19),
(8, 20),
(13, 21),
(11, 22),
(23, 23),
(8, 24),
(20, 25),
(7, 26),
(27, 27),
(5, 28),
(22, 29),
(15, 30),
(23, 31),
(10, 32),
(12, 33),
(4, 34),
(28, 35),
(5, 36),
(1, 37),
(28, 38),
(21, 39),
(4, 40),
(15, 41),
(20, 42),
(4, 43),
(1, 44),
(5, 45),
(25, 46),
(7, 47),
(9, 48),
(23, 49),
(28, 50),
(15, 51),
(9, 52),
(28, 53),
(13, 54),
(19, 55),
(13, 56),
(16, 57),
(24, 58),
(7, 59),
(11, 60),
(26, 61),
(22, 62),
(7, 63),
(7, 64),
(18, 65),
(8, 66),
(10, 67),
(29, 68),
(9, 69),
(6, 70),
(23, 71),
(22, 72),
(29, 73),
(28, 74),
(14, 75),
(24, 76),
(29, 77),
(14, 78),
(28, 79),
(2, 80);

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
  PRIMARY KEY (`task_id`),
  KEY `task_timesheet_id` (`task_timesheet_id`)
) ENGINE=InnoDB  DEFAULT CHARSET=latin1 AUTO_INCREMENT=101 ;

--
-- Dumping data for table `task`
--

INSERT INTO `task` (`task_id`, `task_name`, `task_notes`, `task_timesheet_id`, `task_start_time`, `task_end_time`, `task_work_time`, `task_location`) VALUES
(1, 'Galloway', 'government of the people, by the people, for the people, shall not perish from the earth.', 79, '2014-02-23 14:28:42', '2015-01-16 02:42:28', 27723900, 'Foreland Street'),
(2, 'Epley', 'for the Johns Hopkins lacrosse team, as well as being stalked and subsequently shot by a mysterious woman, Ruth ', 54, '2014-01-30 07:42:04', '2015-01-19 22:00:56', 31950900, 'Menotti Street (formerly Manchester Street)'),
(3, 'Carden', 'and sometimes bluntly abusive. It is implied that Archer was exposed to "negative reinforcement" when ', 55, '2014-02-04 15:40:28', '2015-01-24 13:47:35', 19116100, 'Barnard Mews'),
(4, 'Langlois', 'who contributed greatly to Archer''s parenting. Archer is voiced by H. Jon Benjamin.', 31, '2014-04-22 05:22:08', '2015-01-13 00:26:24', 31408000, 'Broomfield Place'),
(5, 'Fujimoto', ' Lana the last set of scuba gear and tells her he loves her before drowning to be rescucitated). Archer also bonds ', 42, '2014-03-16 04:37:35', '2015-01-15 21:03:46', 10947200, 'Seven Stars Court'),
(6, 'Keith', 'Cheryl bunches of roses and later stating to Lana Kane that he still loves her (also in the season 4 finale he gives', 15, '2014-04-16 21:30:25', '2015-01-18 10:50:12', 9189180, 'Northwall Quarters'),
(7, 'Feldman', 'though Malory Archer denies this) and used to have an on-again, off-again relationship with fellow agent Lana ', 12, '2014-04-03 22:44:05', '2015-01-12 18:24:46', 28950400, 'Fal Villas'),
(8, 'Galarza', 'here, but it can never forget what they did here. It is for us the living, rather, to be ', 4, '2014-03-19 13:24:32', '2015-01-19 09:52:13', 27239800, 'Lorraine Mews'),
(9, 'Hatton', 'is always because he will somehow benefit. He does, however, insist upon compensating anyone from whom he commandeers ', 49, '2014-04-25 11:42:01', '2015-01-22 00:33:59', 29625000, 'Briaris Close'),
(10, 'Stringfellow', 'dedicated here to the unfinished work which they who fought here have thus far so nobly ', 13, '2014-02-27 18:30:39', '2015-01-18 06:19:01', 32000200, 'May Pole Alley'),
(11, 'Sealy', 'Anne Litzenberger. Sterling''s memories culminate in remembering his sixth birthday when his real father gave him ', 48, '2014-04-09 14:26:13', '2015-01-14 06:16:46', 31567000, 'Upper Street'),
(12, 'Reitz', 'you, hmm? See, that''s how the world works dear, and I''m the only one you can trust.") making Archer ', 58, '2014-03-06 11:11:57', '2015-01-19 06:19:16', 8476470, 'Maiden Court'),
(13, 'Hillis', 'the last full measure of devotion  that we here highly resolve that these dead shall not ', 61, '2014-04-24 13:54:05', '2015-01-08 13:49:23', 30285600, 'Cedars Court'),
(14, 'Paulus', 'he was growing up by Malory in The Double Deuce (Malory denies Seamus a toy, saying, "Did somebody trick ', 3, '2014-02-23 03:31:08', '2015-01-18 17:11:41', 14966300, 'Hengist Road'),
(15, 'Carr', 'government of the people, by the people, for the people, shall not perish from the earth.', 58, '2014-03-10 03:27:57', '2015-01-15 13:54:10', 35129600, 'Audley Street North'),
(16, 'Corcoran', 'ground. The brave men, living and dead, who struggled here, have consecrated it, far above ', 60, '2014-02-25 12:32:55', '2015-01-14 07:11:42', 1741480, 'Craigerne Road'),
(17, 'Fleury', ' from breast cancer, he demonstrates considerable regret at his treatment of his co-workers at ISIS, buying Pam and ', 41, '2014-01-29 13:46:00', '2015-01-09 08:27:39', 6346230, 'Hillsborough Road'),
(18, 'Arnone', 'Four score and seven years ago our fathers brought forth on this continent, a new nation, ', 71, '2014-04-10 19:13:12', '2015-01-21 11:05:17', 33084800, 'Hercules Chambers'),
(19, 'Cobbs', 'our poor power to add or detract. The world will little note, nor long remember what we say ', 50, '2014-03-26 13:17:31', '2015-01-21 11:59:23', 6726360, 'Granville Villas'),
(20, 'Solis', 'ive with a fairly high degree of personal bravery, as shown during his escape from Moscow when he consistently ou', 44, '2014-04-17 05:11:12', '2015-01-11 15:02:10', 5321660, 'Hood Avenue'),
(21, 'Gil', 'government of the people, by the people, for the people, shall not perish from the earth.', 59, '2014-03-03 11:54:24', '2015-01-24 00:01:22', 15171000, 'Conroy Street'),
(22, 'New', 'and "three pounds of glass" in his feet. When he was finally cornered in an elevator, he blindfolded himself and fu', 22, '2014-02-12 12:27:56', '2015-01-11 00:27:06', 23211400, 'Deans Close'),
(23, 'Easley', ' from breast cancer, he demonstrates considerable regret at his treatment of his co-workers at ISIS, buying Pam and ', 18, '2014-02-10 18:28:27', '2015-01-14 00:23:39', 7635290, 'Sermon Lane'),
(24, 'Moe', 'Archer has the less than masculine codename of "Duchess" (taken from his mother''s beloved Afghan wolfhound, ', 26, '2014-01-31 13:32:00', '2015-01-11 21:57:04', 8759780, 'Rathbone Market'),
(25, 'Griswold', 'finds himself in a bar that hosts chicken-fighting matches. A big, weeping Dominican man is sitting next to him, ', 25, '2014-03-19 14:16:49', '2015-01-24 07:39:34', 5108900, 'Upper Charlton Street'),
(26, 'Eads', 'Archer is first and foremost completely focused on himself, his needs and desires. If he aids another person, it ', 29, '2014-02-21 03:48:39', '2015-01-24 14:23:57', 31896800, 'Battersea Park Road'),
(27, 'Laurence', 'advanced. It is rather for us to be here dedicated to the great task remaining before us ', 24, '2014-04-10 13:33:57', '2015-01-07 18:44:07', 25719700, 'Tenter Street'),
(28, 'Fast', 'is always because he will somehow benefit. He does, however, insist upon compensating anyone from whom he commandeers ', 61, '2014-02-12 14:32:20', '2015-01-23 23:15:54', 24604900, 'Jesse Road'),
(29, 'Raines', 'is always because he will somehow benefit. He does, however, insist upon compensating anyone from whom he commandeers ', 43, '2014-03-06 21:38:08', '2015-01-18 09:21:54', 14165300, 'Sutcliffe Close'),
(30, 'Ratliff', 'a stuffed alligator.  He, unfortunately, awakens before remembering his father''s face.', 19, '2014-02-01 00:26:10', '2015-01-20 02:07:48', 17341300, 'Durand Gardens'),
(31, 'Shanahan', 'streets of Italy and had "blue eyes, full lips and thick wavy hair".[1]', 19, '2014-04-02 00:14:38', '2015-01-08 19:26:30', 34282100, 'Esterbrooke Street'),
(32, 'Engram', 'streets of Italy and had "blue eyes, full lips and thick wavy hair".[1]', 78, '2014-04-24 07:43:10', '2015-01-14 20:09:32', 12832300, 'Tennyson Road'),
(33, 'Melanson', 'Cheryl bunches of roses and later stating to Lana Kane that he still loves her (also in the season 4 finale he gives', 58, '2014-02-19 15:44:15', '2015-01-08 13:30:43', 18181500, 'Kings Close'),
(34, 'Craven', 'In the Season 4 episode, Once Bitten, Sterling revisits his past led by a cut-rate James Mason, as his spirit ', 55, '2014-02-19 22:34:40', '2015-01-11 13:43:05', 32652800, 'Winsford Terrace'),
(35, 'Jaimes', 'may be KGB head Major Nikolai Jakov, ODIN director Len Trexler, or jazz drummer Buddy Rich. Later ', 53, '2014-04-06 12:17:40', '2015-01-11 17:57:47', 3186610, 'Napier Grove'),
(36, 'France', 'guide. James shows Archer memories that Sterling had blocked out. These include a visit to Baltimore to try out', 74, '2014-04-14 06:30:49', '2015-01-15 03:02:48', 31000200, 'Dartmouth Chambers'),
(37, 'Mercier', 'that from these honored dead we take increased devotion to that cause for which they gave ', 64, '2014-03-30 23:00:46', '2015-01-07 19:25:54', 8647040, 'Roe Green'),
(38, 'Doty', 'Archer has the less than masculine codename of "Duchess" (taken from his mother''s beloved Afghan wolfhound, ', 71, '2014-03-19 07:35:28', '2015-01-10 08:00:34', 1321150, 'Amber Grove'),
(39, 'Sander', 'a stuffed alligator.  He, unfortunately, awakens before remembering his father''s face.', 13, '2014-01-25 04:04:13', '2015-01-13 10:54:28', 3676100, 'Provost Street'),
(40, 'Theriot', 'he establishes a friendship with a fellow cancer patient, Ruth. Another example of this is in Honeypot when Archer ', 78, '2014-01-25 00:05:02', '2015-01-09 15:25:51', 28863100, 'Fuchsia Street'),
(41, 'Espinoza', 'though Malory Archer denies this) and used to have an on-again, off-again relationship with fellow agent Lana ', 64, '2014-03-16 18:13:49', '2015-01-13 11:47:33', 2866680, 'Cox''s Gateway'),
(42, 'Blanks', 'As a result of this long classical education and friendlessness, Archer is surprisingly well-read.', 50, '2014-03-24 21:46:11', '2015-01-15 17:22:43', 4450490, 'Lambeth Mews'),
(43, 'Hurdle', 'He spent up to fifteen years at boarding school, despite American schooling taking thirteen years. His hobby was ', 72, '2014-02-04 22:03:08', '2015-01-25 04:50:57', 3390800, 'Hathorne Terrace'),
(44, 'Smiley', 'streets of Italy and had "blue eyes, full lips and thick wavy hair".[1]', 17, '2014-03-19 00:41:12', '2015-01-22 01:59:49', 8413290, 'Balchen Road'),
(45, 'Dugas', ' from breast cancer, he demonstrates considerable regret at his treatment of his co-workers at ISIS, buying Pam and ', 62, '2014-04-18 00:50:54', '2015-01-22 01:31:31', 30929700, 'Crown Row'),
(46, 'Cloud', 'Now we are engaged in a great civil war, testing whether that nation, or any nation so ', 12, '2014-04-21 04:03:07', '2015-01-16 19:05:44', 13590500, 'Codling Close'),
(47, 'Charles', 'advanced. It is rather for us to be here dedicated to the great task remaining before us ', 75, '2014-04-07 17:08:16', '2015-01-16 06:33:22', 28692200, 'Saxon Road'),
(48, 'Siegel', 'guide. James shows Archer memories that Sterling had blocked out. These include a visit to Baltimore to try out', 80, '2014-02-20 21:44:28', '2015-01-14 20:41:26', 23486700, 'Goldsmiths'' Row'),
(49, 'Rue', 'His relation with his mother Malory—who is also his boss at ISIS—is often strained, never sympathetic, ', 20, '2014-02-02 18:39:00', '2015-01-10 18:02:38', 5391320, 'Abergeldie Road'),
(50, 'Pagel', 'It is revealed in Fugue and Riffs that for a short period of time, he assumed the identity of Bob Belcher from the show Bob''s Burgers. The reason for this sudden life-change is that he entered a fugue state (stress-induced amnesia) following Malory''s wedd', 51, '2014-02-22 11:43:45', '2015-01-24 03:03:00', 7178320, 'St Andrew Street All Saints'),
(51, 'Coy', 'our poor power to add or detract. The world will little note, nor long remember what we say ', 34, '2014-02-09 17:16:43', '2015-01-14 05:23:36', 13726400, 'Welford Close'),
(52, 'Ung', 'Cheryl bunches of roses and later stating to Lana Kane that he still loves her (also in the season 4 finale he gives', 44, '2014-02-15 17:42:55', '2015-01-21 18:31:41', 19508900, 'Talbot Court'),
(53, 'Marks', 'Now we are engaged in a great civil war, testing whether that nation, or any nation so ', 34, '2014-02-16 03:17:29', '2015-01-14 17:30:53', 16848700, 'Heathwood Gardens'),
(54, 'Metcalfe', 'a stuffed alligator.  He, unfortunately, awakens before remembering his father''s face.', 1, '2014-03-08 12:17:33', '2015-01-11 17:35:16', 13996300, 'King Charles Street'),
(55, 'Borrego', 'equipment or goods, although he does not always trade to them items they want or need.', 7, '2014-03-29 06:05:52', '2015-01-15 14:38:44', 31799800, 'South Birkbeck Road'),
(56, 'Stringfellow', 'with the wee baby Seamus over the course of the episode as he considers him the closest that he will ever get to having a', 57, '2014-02-28 02:57:32', '2015-01-17 14:53:34', 3458230, 'Ongar Road'),
(57, 'Koss', 'conceived and so dedicated, can long endure. We are met on a great battle-field of that war.', 61, '2014-03-23 20:23:28', '2015-01-18 19:55:17', 19266300, 'Granville Villas'),
(58, 'Spikes', 'our poor power to add or detract. The world will little note, nor long remember what we say ', 45, '2014-02-01 11:32:01', '2015-01-13 11:12:17', 5717270, 'Seyer Road'),
(59, 'Timms', 'agency "ISIS," located in New York City. ', 46, '2014-03-09 23:06:23', '2015-01-13 10:30:44', 25314800, 'Railway Station: Peckham Rye'),
(60, 'Caton', 'even more heart warming in hindsight after the second season reveal that alligators are one of Archer''s three biggest ', 14, '2014-03-19 08:36:21', '2015-01-23 12:03:58', 8945000, 'Sims Walk'),
(61, 'Myer', 'you, hmm? See, that''s how the world works dear, and I''m the only one you can trust.") making Archer ', 40, '2014-02-03 18:46:55', '2015-01-17 07:40:39', 20855400, 'Edith Villas'),
(62, 'Lapierre', 'guide. James shows Archer memories that Sterling had blocked out. These include a visit to Baltimore to try out', 35, '2014-02-05 06:01:46', '2015-01-10 19:50:58', 13166800, 'Wrights Court'),
(63, 'Amador', 'dedicated here to the unfinished work which they who fought here have thus far so nobly ', 44, '2014-03-21 11:08:52', '2015-01-20 03:31:26', 6912820, 'Bowles Road'),
(64, 'Coffman', 'seaplane, bandaging his head and giving him CPR', 58, '2014-04-02 10:40:21', '2015-01-14 20:44:27', 32465100, 'Petherton Road'),
(65, 'Friend', ' child, going so far as to have "Seamus" tattooed on his back in recognition of that affection.  Additionally, ', 35, '2014-02-02 05:33:10', '2015-01-23 18:32:09', 21436300, 'Landridge Road'),
(66, 'Sherry', 'lacrosse, although flashbacks have indicated he had few friends. A picture of Archer in Placebo Effect shows Archer ', 19, '2014-03-10 10:08:09', '2015-01-09 13:35:15', 468791, 'Oakwood Park Cottages'),
(67, 'Shelley', 'unknown major. Woodhouse is present, also implying he is a better parent to Sterling than Malory who was not present. ', 69, '2014-01-29 10:41:30', '2015-01-23 09:07:58', 14316500, 'Louisa Gardens'),
(68, 'Mull', '', 37, '2014-03-03 04:28:38', '2015-01-14 00:16:16', 15291200, 'Prendergast Road'),
(69, 'Hostetler', 'added to the list of possible fathers was an unnamed young Italian man who was gunned down in the ', 65, '2014-02-06 07:30:16', '2015-01-15 13:32:40', 17807600, 'Steeles Road'),
(70, 'Dulin', ' We have come to dedicate a portion of that field, as a final resting place for those who ', 6, '2014-02-12 17:36:44', '2015-01-23 00:22:28', 1006030, 'Lockhart Close'),
(71, 'Bascom', 'According to the episode, "Once Bitten" Sterling Archer was age six and celebrated his birthday ', 68, '2014-02-14 22:36:29', '2015-01-14 08:13:18', 34181600, 'Wallaces Yard'),
(72, 'Kimberlin', 'Archer has the less than masculine codename of "Duchess" (taken from his mother''s beloved Afghan wolfhound, ', 66, '2014-02-04 10:30:08', '2015-01-15 05:24:20', 28588400, 'Esdaile Road'),
(73, 'Crumpler', 'Although he has numerous personality flaws, such as insensitivity, egotism, and a casual attitude towards murdering ', 26, '2014-04-24 13:38:37', '2015-01-18 00:47:55', 1502290, 'Baskerville Road'),
(74, 'Mccartney', 'Anne Litzenberger. Sterling''s memories culminate in remembering his sixth birthday when his real father gave him ', 70, '2014-03-31 16:00:19', '2015-01-08 12:41:07', 30890400, 'Lancester Court'),
(75, 'Rosenberg', '', 64, '2014-03-02 07:02:22', '2015-01-17 00:17:15', 8674350, 'Livingstone Place'),
(76, 'Lombard', 'ground. The brave men, living and dead, who struggled here, have consecrated it, far above ', 7, '2014-02-19 06:49:45', '2015-01-25 03:15:18', 15823800, 'Cox''s Court'),
(77, 'Leclair', 'advanced. It is rather for us to be here dedicated to the great task remaining before us ', 38, '2014-03-13 15:20:30', '2015-01-15 19:44:33', 30322800, 'Goulston Alley'),
(78, 'Clinton', 'and mentions that he spent all night helping a giant Domnican guy bury his rooster in the everglades, This becomes ', 66, '2014-01-26 21:54:53', '2015-01-23 22:45:30', 6798820, 'Tudor Gables'),
(79, 'Mcconnell', 'and "three pounds of glass" in his feet. When he was finally cornered in an elevator, he blindfolded himself and fu', 3, '2014-02-16 00:00:04', '2015-01-15 00:02:44', 10783000, 'Caledonian Crescent'),
(80, 'Ott', 'he was growing up by Malory in The Double Deuce (Malory denies Seamus a toy, saying, "Did somebody trick ', 43, '2014-02-13 17:16:04', '2015-01-19 12:14:41', 7392960, 'Miall Walk'),
(81, 'Gassaway', 'advanced. It is rather for us to be here dedicated to the great task remaining before us ', 71, '2014-02-11 14:47:00', '2015-01-13 10:45:50', 20960900, 'Coval Road'),
(82, 'Halsey', 'Kane, which makes their working environment tenuous and difficult. At home, he employs an aging valet, Woodhouse ', 19, '2014-03-22 03:16:04', '2015-01-11 12:11:38', 15095300, 'Meadow Way'),
(83, 'Hollis', 'Four score and seven years ago our fathers brought forth on this continent, a new nation, ', 22, '2014-03-09 11:20:00', '2015-01-19 08:12:21', 18628500, 'Regent Wharf'),
(84, 'Haskell', 'is always because he will somehow benefit. He does, however, insist upon compensating anyone from whom he commandeers ', 40, '2014-04-14 02:18:20', '2015-01-18 02:48:03', 32232800, 'Barkham Terrace'),
(85, 'Shuster', 'equipment or goods, although he does not always trade to them items they want or need.', 17, '2014-03-28 10:19:38', '2015-01-13 14:50:22', 27545000, 'Robertson Street East'),
(86, 'Mcghee', 'guide. James shows Archer memories that Sterling had blocked out. These include a visit to Baltimore to try out', 14, '2014-03-26 04:43:31', '2015-01-25 01:39:56', 32323200, 'Oldfield Mews'),
(87, 'Hoang', 'added to the list of possible fathers was an unnamed young Italian man who was gunned down in the ', 4, '2014-02-27 09:37:45', '2015-01-20 23:10:19', 21291300, 'Cosser Street'),
(88, 'Maclean', 'conceived in Liberty, and dedicated to the proposition that all men are created equal.', 80, '2014-02-04 10:00:13', '2015-01-15 19:31:16', 31779200, 'Broughton Street'),
(89, 'Blanding', 'As a result of this long classical education and friendlessness, Archer is surprisingly well-read.', 56, '2014-01-25 09:24:26', '2015-01-10 07:58:26', 6913480, 'Stimpsons Cottages'),
(90, 'Carbaugh', 'His relation with his mother Malory—who is also his boss at ISIS—is often strained, never sympathetic, ', 54, '2014-03-29 18:20:47', '2015-01-11 02:29:18', 16609400, 'Godbold Road'),
(91, 'Goodloe', 'equipment or goods, although he does not always trade to them items they want or need.', 38, '2014-02-25 05:45:49', '2015-01-08 04:24:37', 15719300, 'Daniel Place'),
(92, 'Emanuel', 'you, hmm? See, that''s how the world works dear, and I''m the only one you can trust.") making Archer ', 53, '2014-04-11 05:57:39', '2015-01-16 12:34:52', 16977900, 'Martha Court'),
(93, 'Jamieson', 'ground. The brave men, living and dead, who struggled here, have consecrated it, far above ', 62, '2014-02-13 17:35:53', '2015-01-08 07:11:15', 1700990, 'Russia Row'),
(94, 'Hersh', 'crying over the death of his slain rooster. The next time we see Archer, he is covered in dirt and carrying a shovel, ', 30, '2014-04-10 23:38:13', '2015-01-22 07:47:55', 5743360, 'Worcester Court'),
(95, 'Staton', 'who contributed greatly to Archer''s parenting. Archer is voiced by H. Jon Benjamin.', 53, '2014-02-14 00:39:06', '2015-01-17 22:14:32', 17671400, 'Avondale Court'),
(96, 'Barley', 'Anne Litzenberger. Sterling''s memories culminate in remembering his sixth birthday when his real father gave him ', 11, '2014-02-05 19:28:33', '2015-01-25 06:07:19', 16371600, 'Hobbs Terrace'),
(97, 'Osorio', 'Archer has the less than masculine codename of "Duchess" (taken from his mother''s beloved Afghan wolfhound, ', 3, '2014-03-09 18:28:06', '2015-01-12 16:48:04', 19111400, 'Laurels'),
(98, 'Regalado', 'who contributed greatly to Archer''s parenting. Archer is voiced by H. Jon Benjamin.', 74, '2014-02-21 15:06:10', '2015-01-19 09:05:28', 14701500, 'John Maurice Close'),
(99, 'Cuthbertson', 'twitted and outfought the numerous soldiers dispatched to recapture him despite never having a functional firearm ', 32, '2014-03-27 12:51:17', '2015-01-14 00:48:31', 34164900, 'Wingford Road'),
(100, 'Volz', 'crying over the death of his slain rooster. The next time we see Archer, he is covered in dirt and carrying a shovel, ', 14, '2014-02-17 13:01:35', '2015-01-19 19:22:36', 556228, 'St Philips Way');

-- --------------------------------------------------------

--
-- Table structure for table `timesheet`
--

CREATE TABLE IF NOT EXISTS `timesheet` (
  `timesheet_id` int(20) NOT NULL AUTO_INCREMENT,
  `timesheet_mark_time` datetime DEFAULT NULL,
  `timesheet_date` date DEFAULT NULL,
  `timesheet_project_name` varchar(100) DEFAULT NULL,
  `timesheet_status` int(1) DEFAULT NULL,
  PRIMARY KEY (`timesheet_id`)
) ENGINE=InnoDB  DEFAULT CHARSET=latin1 AUTO_INCREMENT=81 ;

--
-- Dumping data for table `timesheet`
--

INSERT INTO `timesheet` (`timesheet_id`, `timesheet_mark_time`, `timesheet_date`, `timesheet_project_name`, `timesheet_status`) VALUES
(1, '2014-02-03 11:07:24', '2014-09-18', 'LAN/WAN Analyst', 1),
(2, '2014-03-17 22:54:34', '2015-07-27', 'Director Materials', 0),
(3, '2014-02-10 05:31:00', '2014-09-21', 'Director Materials Management', 3),
(4, '2014-02-17 20:58:01', '2014-02-28', 'Annuities Representative', 0),
(5, '2014-05-01 04:47:14', '2014-12-03', 'Warehouse Manager', 1),
(6, '2014-03-15 10:22:45', '2014-02-12', 'Social Services Director', 3),
(7, '2014-06-26 23:07:13', '2015-06-09', 'Medical Prosthetics Assistant', 3),
(8, '2014-06-03 18:27:07', '2015-01-04', 'Insurance Adjustor Claims', 2),
(9, '2014-04-11 14:12:00', '2015-02-15', 'Supervisor Computer Operations', 1),
(10, '2014-03-11 23:22:50', '2014-04-10', 'Marine Cargo Surveyor', 2),
(11, '2014-05-05 17:44:26', '2014-02-08', 'Supervisor Computer Operations', 2),
(12, '2014-04-29 00:16:53', '2014-09-24', 'Actuary (Associate)', 0),
(13, '2014-06-22 09:01:05', '2014-06-02', 'Printer Operator Color', 3),
(14, '2014-03-30 06:13:21', '2014-05-29', 'Buffing Machine Tender', 3),
(15, '2014-02-20 03:24:03', '2015-08-14', 'Medical Prosthetics Assistant', 3),
(16, '2014-01-24 16:15:21', '2015-01-20', 'Warehouse Manager', 2),
(17, '2014-04-30 07:52:56', '2014-11-07', 'Printer Operator Color', 3),
(18, '2014-06-02 14:26:52', '2014-07-16', 'Aide Laboratory', 2),
(19, '2014-01-26 11:36:34', '2014-07-07', 'Aide Laboratory', 3),
(20, '2014-07-02 03:54:39', '2014-10-06', 'Actuary (Associate)', 3),
(21, '2014-05-17 15:25:03', '2015-05-28', 'Technician Hot Cell', 3),
(22, '2014-07-04 07:50:04', '2015-01-19', 'Director Materials', 1),
(23, '2014-04-21 04:21:31', '2014-04-17', 'Director Materials Management', 1),
(24, '2014-04-09 13:30:59', '2014-09-25', 'Research Chemist', 2),
(25, '2014-06-18 07:14:03', '2015-06-16', 'Inspector Quality Control', 2),
(26, '2014-03-25 03:23:39', '2015-06-02', 'Social Services Director', 1),
(27, '2014-03-02 03:07:31', '2015-01-08', 'Attorney Tax', 3),
(28, '2014-02-11 01:04:35', '2015-01-28', 'Annuities Representative', 3),
(29, '2014-06-24 10:55:32', '2015-01-22', 'Assistant Porcelain Buildup', 0),
(30, '2014-06-30 12:22:25', '2014-06-24', 'Wage & Salary Manager', 2),
(31, '2014-06-03 01:52:15', '2015-03-30', 'Supervisor Computer Operations', 3),
(32, '2014-07-12 05:19:46', '2015-06-04', 'Supervisor Computer Operations', 1),
(33, '2014-01-27 19:04:14', '2015-04-07', 'Singer', 2),
(34, '2014-07-25 01:15:11', '2015-07-03', 'Actuary (Associate)', 1),
(35, '2014-06-04 00:02:25', '2015-06-01', 'Aide Laboratory', 3),
(36, '2014-06-22 12:44:55', '2015-03-26', 'Writer Specifications', 3),
(37, '2014-05-28 22:13:53', '2015-03-26', 'Buffing Machine Tender', 0),
(38, '2014-04-18 20:44:52', '2015-05-24', 'Crusher Tender', 2),
(39, '2014-05-21 11:33:50', '2015-01-21', 'Social Services Director', 0),
(40, '2014-02-21 14:32:27', '2014-01-27', 'Research Chemist', 1),
(41, '2014-04-15 17:57:21', '2014-02-11', 'Wage & Salary Manager', 0),
(42, '2014-05-24 22:48:26', '2014-06-28', 'Actuary (Associate)', 0),
(43, '2014-01-27 01:51:21', '2014-08-15', 'Insurance Adjustor Claims', 3),
(44, '2014-02-27 15:38:52', '2015-02-08', 'Attorney Director Legal', 3),
(45, '2014-06-27 19:46:29', '2014-07-12', 'Singer', 3),
(46, '2014-01-24 13:36:55', '2015-04-13', 'Printer Operator Color', 3),
(47, '2014-07-19 16:48:54', '2014-03-17', 'Printer Operator Color', 1),
(48, '2014-04-11 19:44:45', '2014-04-14', 'Director Materials Management', 1),
(49, '2014-05-21 18:12:15', '2014-12-04', 'Actuary (Associate)', 3),
(50, '2014-04-20 14:35:25', '2014-10-12', 'Wage & Salary Manager', 2),
(51, '2014-04-29 23:49:28', '2015-06-12', 'Insurance Adjustor Claims', 2),
(52, '2014-02-10 14:14:43', '2014-11-26', 'Research Chemist', 2),
(53, '2014-03-27 13:44:40', '2014-08-26', 'Director Materials', 0),
(54, '2014-07-16 23:23:05', '2014-04-29', 'Structural Engineer', 3),
(55, '2014-03-07 16:45:05', '2015-06-18', 'Optical Lens Machine Tender', 3),
(56, '2014-05-20 03:17:26', '2015-03-27', 'Director Materials', 2),
(57, '2014-05-13 01:52:49', '2014-03-22', 'Technician Hot Cell', 0),
(58, '2014-06-01 22:53:07', '2015-02-17', 'Singer', 0),
(59, '2014-04-22 00:56:51', '2015-01-31', 'Attorney Director Legal', 3),
(60, '2014-01-27 16:45:41', '2015-02-23', 'Inspector Quality Control', 1),
(61, '2014-05-18 06:04:50', '2015-08-23', 'Technician Offset Press (Press Above 26 Inches)', 0),
(62, '2014-06-29 14:12:49', '2015-05-29', 'Singer', 2),
(63, '2014-07-17 02:14:58', '2014-05-25', 'Singer', 3),
(64, '2014-03-26 23:16:14', '2014-11-01', 'Technician Hot Cell', 1),
(65, '2014-05-29 14:47:55', '2014-10-11', 'Insurance Adjustor Claims', 0),
(66, '2014-06-11 01:43:31', '2015-06-02', 'Insurance Adjustor Claims', 0),
(67, '2014-02-02 03:58:39', '2014-08-13', 'Writer Specifications', 0),
(68, '2014-02-10 11:10:00', '2015-02-05', 'LAN/WAN Analyst', 3),
(69, '2014-04-24 14:28:20', '2014-04-24', 'Animal Trainer', 3),
(70, '2014-04-18 02:00:38', '2014-08-08', 'Research Chemist', 0),
(71, '2014-04-13 03:56:12', '2015-03-20', 'Director Materials', 1),
(72, '2014-06-11 21:31:54', '2014-06-26', 'Printer Operator Color', 2),
(73, '2014-05-27 22:31:25', '2014-07-19', 'Technician Offset Press (Press Above 26 Inches)', 0),
(74, '2014-02-23 04:53:38', '2015-01-16', 'Attorney Tax', 0),
(75, '2014-03-19 23:24:58', '2014-03-30', 'Medical Prosthetics Assistant', 2),
(76, '2014-02-09 13:10:56', '2014-05-03', 'Structural Engineer', 2),
(77, '2014-02-24 00:21:33', '2015-04-18', 'Assistant Porcelain Buildup', 0),
(78, '2014-05-22 06:26:02', '2015-06-07', 'Actuary (Associate)', 2),
(79, '2014-07-18 20:11:23', '2014-12-05', 'Director Materials', 3),
(80, '2014-06-04 15:40:10', '2014-04-30', 'Director Materials', 3);

-- --------------------------------------------------------

--
-- Table structure for table `user`
--

CREATE TABLE IF NOT EXISTS `user` (
  `user_id` int(20) NOT NULL AUTO_INCREMENT,
  `user_name` varchar(100) DEFAULT NULL,
  `user_sex` char(1) DEFAULT NULL,
  `user_email` varchar(100) DEFAULT NULL,
  `user_location` varchar(255) DEFAULT NULL,
  `user_phone_number` varchar(13) DEFAULT NULL,
  `user_image_url` varchar(255) DEFAULT NULL,
  PRIMARY KEY (`user_id`)
) ENGINE=InnoDB  DEFAULT CHARSET=latin1 AUTO_INCREMENT=21 ;

--
-- Dumping data for table `user`
--

INSERT INTO `user` (`user_id`, `user_name`, `user_sex`, `user_email`, `user_location`, `user_phone_number`, `user_image_url`) VALUES
(1, 'Sharon', 'm', 'N.Sims@ukmail.co.za', 'El Pelar Dr', '0570 874105', 'default.jpg'),
(2, 'Rogier', 'f', 'S.Verdeces@usmail.de', 'Karat Dr', '0448 346047', 'default.jpg'),
(3, 'Tobias', 'm', 'R.Goins@ukmail.nl', 'Persimmon St', '0319 990594', 'default.jpg'),
(4, 'JanCees', 'm', 'Y.Fururia@emailplanet.is', 'Claybourne Dr', '0576 267433', 'default.jpg'),
(5, 'Teddy', 'f', 'U.Coggins@mail.excite.co.kr', 'Stegerman Dr', '0115 566744', 'default.jpg'),
(6, 'Mario', 'f', 'F.Cañedo@popmail.co.za', 'Wood Owl Dr', '0664 240712', 'default.jpg'),
(7, 'Milan', 'f', 'P.Layman@mail.excite.jp', 'Saranac Dr', '0586 329868', 'default.jpg'),
(8, 'Kimberly', 'm', 'L.Coronel@home.au', 'Excalibur St', '0138 336487', 'default.jpg'),
(9, 'Laura', 'f', 'Z.Alvisto@uol.nl', 'Whiteriver Dr', '0499 290478', 'default.jpg'),
(10, 'Ronald', 'f', 'W.Hashimoto@1stmail.net', 'Satinleaf Dr', '0593 519270', 'default.jpg'),
(11, 'Margaret', 'f', 'L.Hawks@jpopmail.is', 'Ridgewater Ave', '0196 726182', 'default.jpg'),
(12, 'Sherman', 'f', 'X.Carroll@yahoo.de', 'Constantine Ave', '0156 979049', 'default.jpg'),
(13, 'Suzanne', 'm', 'H.Quillen@yahoo.to', 'Glencrest Way', '0161 210927', 'default.jpg'),
(14, 'Diego', 'm', 'S.Camero@usmail.au', 'Teano Dr', '0811 460570', 'default.jpg'),
(15, 'Agnieszka', 'm', 'O.Cash@3web.co.za', 'Goodman St', '0893 725330', 'default.jpg'),
(16, 'Hugo', 'm', 'U.Loro@usmail.com.mx', 'Sugar Creek Dr', '0653 945269', 'default.jpg'),
(17, 'Mike', 'm', 'F.Chapin@mail.freenation.co.jp', 'Teakwood Dr', '0193 385858', 'default.jpg'),
(18, 'Catharine', 'f', 'M.Arambarri@gmx.net', 'Ryman Creek Dr', '0710 176433', 'default.jpg'),
(19, 'Leontien', 'm', 'Z.Paez@home.gr', 'Artesian Rd', '0821 405269', 'default.jpg'),
(20, 'Kimmy', 'm', 'F.Stella@3web.tv', 'Wood Crest', '0951 834100', 'default.jpg');

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
(31, 19, 12),
(49, 16, 19),
(34, 7, 20),
(27, 12, 13),
(45, 1, 19),
(16, 6, 4),
(11, 8, 2),
(44, 17, 5),
(25, 7, 2),
(25, 12, 4),
(9, 7, 20),
(35, 4, 9),
(48, 14, 20),
(18, 13, 15),
(45, 10, 4),
(22, 16, 2),
(9, 13, 4),
(34, 20, 18),
(23, 14, 16),
(17, 10, 19),
(40, 12, 13),
(29, 9, 4),
(7, 8, 7),
(45, 15, 12),
(24, 11, 10),
(32, 13, 11),
(20, 13, 8),
(4, 8, 9),
(36, 13, 15),
(8, 7, 5),
(21, 8, 18),
(7, 20, 10),
(48, 14, 8),
(26, 6, 5),
(25, 4, 2),
(33, 18, 14),
(28, 14, 19),
(34, 18, 5),
(45, 11, 10),
(34, 6, 9),
(21, 19, 5),
(25, 13, 15),
(1, 7, 20),
(43, 12, 12),
(8, 10, 7),
(1, 18, 17),
(41, 19, 15),
(39, 10, 7),
(43, 3, 7),
(11, 8, 9);

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
(1, 3),
(13, 22),
(10, 13),
(2, 8),
(11, 21),
(3, 30),
(19, 16),
(16, 20),
(14, 8),
(11, 1),
(10, 18),
(11, 12),
(5, 11),
(10, 11),
(4, 19),
(11, 12),
(18, 29),
(2, 29),
(9, 12),
(14, 14),
(9, 27),
(14, 25),
(7, 26),
(6, 28),
(7, 19),
(5, 28),
(19, 7),
(1, 11),
(15, 9),
(13, 13);

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
(16, 4),
(4, 66),
(9, 22),
(15, 22),
(10, 6),
(11, 23),
(20, 56),
(1, 3),
(2, 64),
(12, 28),
(15, 57),
(20, 6),
(20, 76),
(17, 33),
(20, 48),
(9, 4),
(8, 58),
(20, 1),
(6, 54),
(4, 58),
(5, 72),
(4, 46),
(16, 80),
(16, 6),
(18, 53),
(14, 30),
(6, 77),
(1, 56),
(5, 25),
(3, 76),
(4, 49),
(17, 48),
(6, 64),
(2, 54),
(7, 61),
(18, 16),
(13, 2),
(15, 60),
(5, 4),
(14, 58),
(2, 75),
(9, 41),
(20, 55),
(9, 69),
(6, 44),
(9, 74),
(11, 4),
(1, 63),
(7, 50),
(15, 46),
(20, 8),
(20, 35),
(12, 23),
(18, 66),
(15, 48),
(16, 9),
(13, 29),
(16, 26),
(1, 14),
(20, 36),
(20, 50),
(19, 71),
(2, 12),
(8, 51),
(2, 62),
(2, 49),
(19, 15),
(8, 77),
(6, 20),
(14, 28),
(12, 66),
(8, 54),
(4, 67),
(15, 38),
(3, 53),
(5, 15),
(6, 16),
(6, 75),
(16, 45),
(14, 42);

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
