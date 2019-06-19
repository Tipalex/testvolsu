-- phpMyAdmin SQL Dump
-- version 3.5.8.2
-- http://www.phpmyadmin.net
--
-- Host: sql207.byetcluster.com
-- Generation Time: Jun 16, 2019 at 10:09 AM
-- Server version: 5.6.41-84.1
-- PHP Version: 5.3.3

SET SQL_MODE="NO_AUTO_VALUE_ON_ZERO";
SET time_zone = "+00:00";


/*!40101 SET @OLD_CHARACTER_SET_CLIENT=@@CHARACTER_SET_CLIENT */;
/*!40101 SET @OLD_CHARACTER_SET_RESULTS=@@CHARACTER_SET_RESULTS */;
/*!40101 SET @OLD_COLLATION_CONNECTION=@@COLLATION_CONNECTION */;
/*!40101 SET NAMES utf8 */;

--
-- Database: `epiz_23924756_diplom`
--

-- --------------------------------------------------------

--
-- Table structure for table `discipline`
--

CREATE TABLE IF NOT EXISTS `discipline` (
  `id` int(11) NOT NULL AUTO_INCREMENT,
  `teacher` int(11) NOT NULL DEFAULT '0',
  `name` varchar(128) DEFAULT NULL,
  `control` varchar(128) DEFAULT NULL,
  PRIMARY KEY (`id`)
) ENGINE=MyISAM  DEFAULT CHARSET=utf8 AUTO_INCREMENT=8 ;

--
-- Dumping data for table `discipline`
--

INSERT INTO `discipline` (`id`, `teacher`, `name`, `control`) VALUES
(1, 3, 'Математический анализ', 'зачёт'),
(2, 3, 'Дифференциальные уравнения', 'экзамен'),
(5, 3, 'Операционные системы', 'зачёт с оценкой'),
(6, 6, 'Введение в программную инженерию', 'экзамен'),
(7, 9, 'Базы данных', 'зачёт с оценкой');

-- --------------------------------------------------------

--
-- Table structure for table `examination`
--

CREATE TABLE IF NOT EXISTS `examination` (
  `id` int(11) NOT NULL AUTO_INCREMENT,
  `task` int(11) DEFAULT '0',
  `path` varchar(128) DEFAULT NULL,
  PRIMARY KEY (`id`)
) ENGINE=MyISAM DEFAULT CHARSET=utf8 AUTO_INCREMENT=1 ;

-- --------------------------------------------------------

--
-- Table structure for table `group_discipline`
--

CREATE TABLE IF NOT EXISTS `group_discipline` (
  `id` int(11) NOT NULL AUTO_INCREMENT,
  `groupe` int(11) DEFAULT '0',
  `discipline` int(11) DEFAULT '0',
  PRIMARY KEY (`id`)
) ENGINE=MyISAM  DEFAULT CHARSET=utf8 AUTO_INCREMENT=20 ;

--
-- Dumping data for table `group_discipline`
--

INSERT INTO `group_discipline` (`id`, `groupe`, `discipline`) VALUES
(1, 1, 1),
(2, 2, 1),
(3, 1, 2),
(4, NULL, 1),
(18, 4, 7),
(6, NULL, 6),
(7, NULL, 1),
(8, NULL, 2),
(9, NULL, 1),
(10, 2, 2),
(11, NULL, 6),
(12, NULL, 1),
(13, NULL, 6),
(15, 3, 1),
(16, 3, 6),
(19, 1, 5);

-- --------------------------------------------------------

--
-- Table structure for table `materials`
--

CREATE TABLE IF NOT EXISTS `materials` (
  `id` int(11) NOT NULL AUTO_INCREMENT,
  `discipline` int(11) DEFAULT NULL,
  `filePath` varchar(500) DEFAULT NULL,
  `name` varchar(500) DEFAULT NULL,
  PRIMARY KEY (`id`)
) ENGINE=MyISAM  DEFAULT CHARSET=utf8 AUTO_INCREMENT=5 ;

--
-- Dumping data for table `materials`
--

INSERT INTO `materials` (`id`, `discipline`, `filePath`, `name`) VALUES
(1, 1, 'uploads/Снимок экрана 2019-05-06 в 22.39.36.png', 'Тестовый материал 323'),
(4, 5, 'uploads/Лаб_ОС_2.pdf', 'Лабораторная работа №2');

-- --------------------------------------------------------

--
-- Table structure for table `role`
--

CREATE TABLE IF NOT EXISTS `role` (
  `user_id` int(11) NOT NULL DEFAULT '0',
  `role` int(11) NOT NULL DEFAULT '0',
  PRIMARY KEY (`user_id`)
) ENGINE=MyISAM DEFAULT CHARSET=utf8;

--
-- Dumping data for table `role`
--

INSERT INTO `role` (`user_id`, `role`) VALUES
(1, 10);

-- --------------------------------------------------------

--
-- Table structure for table `student`
--

CREATE TABLE IF NOT EXISTS `student` (
  `user` int(11) NOT NULL DEFAULT '0',
  `s_group` int(11) DEFAULT '0',
  PRIMARY KEY (`user`)
) ENGINE=MyISAM DEFAULT CHARSET=utf8;

--
-- Dumping data for table `student`
--

INSERT INTO `student` (`user`, `s_group`) VALUES
(1, 1),
(2, 1),
(7, 1),
(8, 1);

-- --------------------------------------------------------

--
-- Table structure for table `student_group`
--

CREATE TABLE IF NOT EXISTS `student_group` (
  `id` int(11) NOT NULL AUTO_INCREMENT,
  `name` varchar(50) NOT NULL DEFAULT '',
  PRIMARY KEY (`name`),
  KEY `id` (`id`)
) ENGINE=MyISAM  DEFAULT CHARSET=utf8 AUTO_INCREMENT=5 ;

--
-- Dumping data for table `student_group`
--

INSERT INTO `student_group` (`id`, `name`) VALUES
(1, 'ИВТ-151'),
(2, 'ИСТ-151'),
(3, 'ПРИ-151');

-- --------------------------------------------------------

--
-- Table structure for table `student_score`
--

CREATE TABLE IF NOT EXISTS `student_score` (
  `id` int(11) NOT NULL AUTO_INCREMENT,
  `test_id` int(11) DEFAULT '0',
  `score` int(11) DEFAULT '0',
  `user` int(11) DEFAULT '0',
  `discipline` int(11) DEFAULT '0',
  `status` varchar(128) DEFAULT NULL,
  PRIMARY KEY (`id`)
) ENGINE=MyISAM  DEFAULT CHARSET=utf8 AUTO_INCREMENT=61 ;

--
-- Dumping data for table `student_score`
--

INSERT INTO `student_score` (`id`, `test_id`, `score`, `user`, `discipline`, `status`) VALUES
(46, 31, 0, 2, 31, 'Отправлено'),
(52, 31, 0, 8, 5, 'Не выполнено в срок'),
(53, 33, 10, 8, 5, 'Проверено');

-- --------------------------------------------------------

--
-- Table structure for table `task`
--

CREATE TABLE IF NOT EXISTS `task` (
  `id` int(11) NOT NULL AUTO_INCREMENT,
  `name` varchar(128) DEFAULT NULL,
  `end_date` date DEFAULT NULL,
  PRIMARY KEY (`id`)
) ENGINE=MyISAM DEFAULT CHARSET=utf8 AUTO_INCREMENT=1 ;

-- --------------------------------------------------------

--
-- Table structure for table `teacher`
--

CREATE TABLE IF NOT EXISTS `teacher` (
  `user` int(11) DEFAULT '0'
) ENGINE=MyISAM DEFAULT CHARSET=utf8;

--
-- Dumping data for table `teacher`
--

INSERT INTO `teacher` (`user`) VALUES
(1),
(3);

-- --------------------------------------------------------

--
-- Table structure for table `test`
--

CREATE TABLE IF NOT EXISTS `test` (
  `id` int(11) NOT NULL AUTO_INCREMENT,
  `name` varchar(50) DEFAULT NULL,
  `discipline` int(11) DEFAULT '0',
  `time` smallint(6) DEFAULT '0',
  `dateOfStart` date DEFAULT NULL,
  `dateOfEnd` date DEFAULT NULL,
  `description` text,
  `type` enum('tack','test') DEFAULT 'test',
  `filePath` text,
  `isPublished` tinyint(4) DEFAULT '0',
  PRIMARY KEY (`id`)
) ENGINE=MyISAM  DEFAULT CHARSET=utf8 AUTO_INCREMENT=37 ;

--
-- Dumping data for table `test`
--

INSERT INTO `test` (`id`, `name`, `discipline`, `time`, `dateOfStart`, `dateOfEnd`, `description`, `type`, `filePath`, `isPublished`) VALUES
(31, 'Лабораторная работа №1', 5, 0, '2019-06-04', '2019-06-05', 'Необходимо подготовить отчет о выполнении работы.', 'tack', NULL, 1),
(33, 'Лабораторная работа №2', 5, 0, '2019-06-14', '2019-06-17', 'Выполнить согласно методическому материалу.\r\nВыполненное задание прикрепить к ответу!', 'tack', NULL, 1);

-- --------------------------------------------------------

--
-- Table structure for table `test_answer`
--

CREATE TABLE IF NOT EXISTS `test_answer` (
  `id` int(11) NOT NULL AUTO_INCREMENT,
  `question` int(11) DEFAULT '0',
  `answer` varchar(128) DEFAULT NULL,
  PRIMARY KEY (`id`)
) ENGINE=MyISAM  DEFAULT CHARSET=utf8 AUTO_INCREMENT=64 ;

--
-- Dumping data for table `test_answer`
--

INSERT INTO `test_answer` (`id`, `question`, `answer`) VALUES
(40, 56, 'Верно'),
(41, 56, 'Неверно'),
(42, 57, 'Ответ 1'),
(43, 57, 'Ответ 2'),
(44, 59, 'Верно'),
(45, 59, 'Неверно'),
(46, 61, 'программа тестирования POST'),
(47, 61, 'программа-загрузчик операционной системы'),
(48, 61, 'BIOS'),
(49, 61, 'командный процессор'),
(50, 62, 'Верно'),
(51, 62, 'Неверно'),
(52, 63, '^ * ( f ) 2 % ~ 1 '),
(53, 63, ' d 3 @ \\ & i 2 / *'),
(54, 63, '% d & ( ) e [ ] r '),
(55, 63, '% d & ( ) e < > r '),
(56, 63, 'u p @ 3 $ % ( 1 _ '),
(57, 64, 'Верно'),
(58, 64, 'Неверно'),
(59, 67, '1995'),
(60, 67, '1981'),
(61, 67, '1992'),
(62, 67, '1945'),
(63, 67, '2000');

-- --------------------------------------------------------

--
-- Table structure for table `test_question`
--

CREATE TABLE IF NOT EXISTS `test_question` (
  `id` int(11) NOT NULL AUTO_INCREMENT,
  `test` int(11) DEFAULT '0',
  `question` varchar(128) DEFAULT NULL,
  `type` varchar(15) DEFAULT '0',
  `image` varchar(45) DEFAULT NULL,
  PRIMARY KEY (`id`)
) ENGINE=MyISAM  DEFAULT CHARSET=utf8 AUTO_INCREMENT=69 ;

--
-- Dumping data for table `test_question`
--

INSERT INTO `test_question` (`id`, `test`, `question`, `type`, `image`) VALUES
(56, 28, 'Вопрос 1', 'yes_no', NULL),
(57, 28, 'Вопрос 2', 'select_single', 'uploads/generalB.png'),
(58, 28, 'Вопрос 3', 'write', NULL),
(59, 29, 'Еуеы', 'yes_no', NULL),
(60, 30, 'Операционная система это?', 'write', NULL),
(61, 30, 'Проверку работоспособности основных устройств компьютера осуществляет', 'select_single', NULL),
(62, 30, 'Верно ли утверждение, операционная система относится к прикладному программному обеспечению?', 'yes_no', NULL),
(63, 30, 'Какие символы разрешены в имени файла в ОС Windows?', 'select_multiple', NULL),
(64, 32, 'фывафыва', 'yes_no', NULL),
(65, 32, 'орплро', 'write', NULL),
(66, 34, 'ОС - это...', 'write', NULL),
(67, 34, 'Когда появилась операционная система Windows?', 'select_single', NULL),
(68, 35, 'тест', 'select_multiple', NULL);

-- --------------------------------------------------------

--
-- Table structure for table `user`
--

CREATE TABLE IF NOT EXISTS `user` (
  `id` int(11) NOT NULL AUTO_INCREMENT,
  `login` varchar(128) NOT NULL DEFAULT '',
  `password` varchar(128) NOT NULL DEFAULT '',
  `firstname` varchar(128) NOT NULL DEFAULT '',
  `lastname` varchar(128) NOT NULL DEFAULT '',
  `middlename` varchar(128) DEFAULT NULL,
  `email` varchar(128) NOT NULL DEFAULT '',
  `authKey` char(128) NOT NULL DEFAULT '',
  `role` varchar(128) NOT NULL DEFAULT 'студент',
  PRIMARY KEY (`id`)
) ENGINE=MyISAM  DEFAULT CHARSET=utf8 AUTO_INCREMENT=10 ;

--
-- Dumping data for table `user`
--

INSERT INTO `user` (`id`, `login`, `password`, `firstname`, `lastname`, `middlename`, `email`, `authKey`, `role`) VALUES
(2, 'a.strashchenko', 'strashchenko', 'Александр', 'Стращенко', NULL, 'alex@alex.com', 'aasdas', 'student'),
(3, 'test', 'test', 'Татьяна', 'Дьяконова', 'Андреевна', 'volsu@volsu.ru', 'sdfaf', 'teacher'),
(4, 'admin', 'admin', 'Кафедры', 'Директор ', '', 'admin', 'dfgsdfg', 'admin'),
(9, 'test2', 'test2', 'Николай', 'Кузьмин', 'Михайлович', 'kuzmin@volsu.ru', '', 'teacher'),
(7, 'serdyukova', 'serdyukovaserdyukova', 'Дарья', 'Сердюкова', 'Юрьевна', 'test2@mail.ru', '', 'student'),
(8, 'test1', 'test1', 'Павел', 'Усачев', 'Сергеевич', 'usachev@gmail.com', '', 'student');

-- --------------------------------------------------------

--
-- Table structure for table `user_answers`
--

CREATE TABLE IF NOT EXISTS `user_answers` (
  `id` int(11) NOT NULL AUTO_INCREMENT,
  `user` int(11) DEFAULT '0',
  `test` int(11) DEFAULT '0',
  `question` int(11) DEFAULT '0',
  `answer` varchar(128) DEFAULT NULL,
  `score` int(11) DEFAULT NULL,
  PRIMARY KEY (`id`)
) ENGINE=MyISAM  DEFAULT CHARSET=utf8 AUTO_INCREMENT=96 ;

--
-- Dumping data for table `user_answers`
--

INSERT INTO `user_answers` (`id`, `user`, `test`, `question`, `answer`, `score`) VALUES
(76, 2, 28, 56, 'Неверно', NULL),
(77, 2, 28, 58, '', NULL),
(75, 2, 29, 59, 'Неверно', 0),
(78, 2, 30, 62, 'Неверно', 2),
(79, 2, 30, 61, 'программа тестирования POST', 2),
(80, 2, 30, 60, '', 0),
(81, 2, 30, 63, ' d 3 @ \\ & i 2 / *', 1),
(82, 2, 31, 0, 'uploads/Лаб_ОС_1.doc', NULL),
(84, 2, 32, 65, '', NULL),
(85, 8, 33, 0, 'uploads/VKR.docx', 10),
(86, 8, 34, 66, '', NULL),
(87, 8, 34, 66, '', NULL),
(88, 8, 34, 66, '', NULL),
(89, 8, 34, 66, '', NULL),
(90, 8, 34, 67, '1995', NULL),
(91, 8, 34, 66, '', NULL),
(92, 8, 34, 67, '1995', NULL),
(93, 8, 34, 66, '', NULL),
(94, 8, 34, 67, '1995', NULL),
(95, 8, 34, 66, 'ОС — комплекс взаимосвязанных программ, предназначенных для управления ресурсами компьютера и организации взаимодействия с польз', NULL);

/*!40101 SET CHARACTER_SET_CLIENT=@OLD_CHARACTER_SET_CLIENT */;
/*!40101 SET CHARACTER_SET_RESULTS=@OLD_CHARACTER_SET_RESULTS */;
/*!40101 SET COLLATION_CONNECTION=@OLD_COLLATION_CONNECTION */;
