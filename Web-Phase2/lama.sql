-- phpMyAdmin SQL Dump
-- version 5.2.1
-- https://www.phpmyadmin.net/
--
-- Host: localhost
-- Generation Time: May 07, 2024 at 11:23 PM
-- Server version: 10.4.28-MariaDB
-- PHP Version: 8.0.28

SET SQL_MODE = "NO_AUTO_VALUE_ON_ZERO";
START TRANSACTION;
SET time_zone = "+00:00";


/*!40101 SET @OLD_CHARACTER_SET_CLIENT=@@CHARACTER_SET_CLIENT */;
/*!40101 SET @OLD_CHARACTER_SET_RESULTS=@@CHARACTER_SET_RESULTS */;
/*!40101 SET @OLD_COLLATION_CONNECTION=@@COLLATION_CONNECTION */;
/*!40101 SET NAMES utf8mb4 */;

--
-- Database: `lama`
--

-- --------------------------------------------------------

--
-- Table structure for table `contact`
--

CREATE TABLE `contact` (
  `fname` varchar(50) NOT NULL,
  `email` varchar(50) NOT NULL,
  `title` varchar(50) NOT NULL,
  `msg` varchar(100) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

-- --------------------------------------------------------

--
-- Table structure for table `learner`
--

CREATE TABLE `learner` (
  `fname` varchar(50) NOT NULL,
  `lname` varchar(50) NOT NULL,
  `email` varchar(50) NOT NULL,
  `city` varchar(50) NOT NULL,
  `password` varchar(50) NOT NULL,
  `location` varchar(50) NOT NULL,
  `photo` varchar(100) NOT NULL DEFAULT 'ava.jpg'
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

--
-- Dumping data for table `learner`
--

INSERT INTO `learner` (`fname`, `lname`, `email`, `city`, `password`, `location`, `photo`) VALUES
('bb', 'hhhhhhhhhh', 'dddd@gmai.com', 'dededed', 'ggggggggggggggg', 'ghg', 'usericon.png'),
('Bayader', 'Aljondeby', 'ddddj@gmai.com', 'Here', 'ggggggggggggggg', 'jj', 'Aleem+Business+Headshot+for+LinkedIn+Profile.jpg'),
('Jack', 'Smith', 'jack@gmail.com', 'nyc', 'jack12345678', 'nyc', 'usericon.png'),
('Tom', 'Smith', 'tsmith@yahoo.com', 'nyc', 'tom123456', 'nyc', 'usericon.png');

-- --------------------------------------------------------

--
-- Table structure for table `rate`
--

CREATE TABLE `rate` (
  `rID` int(11) NOT NULL,
  `star` varchar(50) NOT NULL,
  `feedback` varchar(200) NOT NULL,
  `dateAndtime` datetime NOT NULL,
  `tutorEmail` varchar(50) NOT NULL,
  `learnerEmail` varchar(50) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

--
-- Dumping data for table `rate`
--

INSERT INTO `rate` (`rID`, `star`, `feedback`, `dateAndtime`, `tutorEmail`, `learnerEmail`) VALUES
(11, '4.5', 'Awesome', '2024-05-07 22:10:28', 'samantha@yahoo.com', 'jack@gmail.com'),
(12, '4.8', 'Amazing', '2024-05-07 22:13:13', 'samantha@yahoo.com', 'jack@gmail.com');

-- --------------------------------------------------------

--
-- Table structure for table `request`
--

CREATE TABLE `request` (
  `language` varchar(50) NOT NULL,
  `prolevel` varchar(50) NOT NULL,
  `date` date NOT NULL,
  `time` time NOT NULL,
  `duration` varchar(50) NOT NULL,
  `status` varchar(50) NOT NULL DEFAULT 'pending',
  `TutorEmail` varchar(50) NOT NULL,
  `LearnerEmail` varchar(50) NOT NULL,
  `ReqId` int(11) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

--
-- Dumping data for table `request`
--

INSERT INTO `request` (`language`, `prolevel`, `date`, `time`, `duration`, `status`, `TutorEmail`, `LearnerEmail`, `ReqId`) VALUES
('eng', 'proffissional', '2024-05-06', '06:00:00', '3', 'accepted', 'skdjk@gmail.com', 'ddddj@gmai.com', 4),
('French ', 'beginner ', '2024-05-16', '11:00:00', '2', 'accepted', 'skdjk@gmail.com', 'ddddj@gmai.com', 5),
('spanish', 'beginner ', '2024-05-01', '10:00:00', '1', 'accepted', 'skdjk@gmail.com', 'ddddj@gmai.com', 6),
('arabic ', 'beginner ', '2024-05-01', '10:00:00', '5', 'pending', 'jjj@gmail.com', 'ddddj@gmai.com', 7),
('Spanish', 'intermediate', '2024-05-08', '12:00:00', '1', 'accepted', 'samantha@yahoo.com', 'jack@gmail.com', 10),
('English', 'Beginner', '2024-05-06', '10:00:00', '1', 'accepted', 'samantha@yahoo.com', 'jack@gmail.com', 11),
('Spanish', 'Beginner', '2024-04-10', '10:00:00', '1', 'accepted', 'samantha@yahoo.com', 'jack@gmail.com', 12),
('French', 'intermediate', '2024-05-09', '11:00:00', '2', 'rejected', 'samantha@yahoo.com', 'jack@gmail.com', 13);

-- --------------------------------------------------------

--
-- Table structure for table `tutor`
--

CREATE TABLE `tutor` (
  `fname` varchar(50) NOT NULL,
  `lname` varchar(50) NOT NULL,
  `email` varchar(50) NOT NULL,
  `age` varchar(30) NOT NULL,
  `gender` varchar(50) NOT NULL,
  `password` varchar(50) NOT NULL,
  `city` varchar(50) NOT NULL,
  `phone` varchar(50) NOT NULL,
  `bio` varchar(200) NOT NULL,
  `photo` varchar(100) NOT NULL DEFAULT 'ava.jpg',
  `price` varchar(50) NOT NULL DEFAULT '50'
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

--
-- Dumping data for table `tutor`
--

INSERT INTO `tutor` (`fname`, `lname`, `email`, `age`, `gender`, `password`, `city`, `phone`, `bio`, `photo`, `price`) VALUES
('Olivia', ' Reynolds', 'jjj@gmail.com', '20', 'F', '5555555ggtgtgtgtgt', 'da', '0537291934', 'rfrtttttttttttttttttt\r\n', 'ava.jpg', '50'),
('Samantha', 'Jack', 'samantha@yahoo.com', '28', 'F', 'samantha12345', 'miami', '0574936120', 'Happy Learning', '', '58'),
('Hessah', 'jsndjs', 'skdjk@gmail.com', '3', 'F', '23456789jhgd', 'ee', '0537291934', 'rrrrr4444', 'ava.jpg', '50');

--
-- Indexes for dumped tables
--

--
-- Indexes for table `learner`
--
ALTER TABLE `learner`
  ADD PRIMARY KEY (`email`);

--
-- Indexes for table `rate`
--
ALTER TABLE `rate`
  ADD KEY `learnerEmail` (`learnerEmail`),
  ADD KEY `tutorEmail` (`tutorEmail`),
  ADD KEY `rID` (`rID`);

--
-- Indexes for table `request`
--
ALTER TABLE `request`
  ADD PRIMARY KEY (`ReqId`),
  ADD KEY `TutorEmail` (`TutorEmail`),
  ADD KEY `LearnerEmail` (`LearnerEmail`);

--
-- Indexes for table `tutor`
--
ALTER TABLE `tutor`
  ADD PRIMARY KEY (`email`);

--
-- AUTO_INCREMENT for dumped tables
--

--
-- AUTO_INCREMENT for table `request`
--
ALTER TABLE `request`
  MODIFY `ReqId` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=14;

--
-- Constraints for dumped tables
--

--
-- Constraints for table `rate`
--
ALTER TABLE `rate`
  ADD CONSTRAINT `rate_ibfk_1` FOREIGN KEY (`learnerEmail`) REFERENCES `learner` (`email`) ON DELETE CASCADE ON UPDATE CASCADE,
  ADD CONSTRAINT `rate_ibfk_2` FOREIGN KEY (`tutorEmail`) REFERENCES `tutor` (`email`) ON DELETE CASCADE ON UPDATE CASCADE,
  ADD CONSTRAINT `rate_ibfk_3` FOREIGN KEY (`rID`) REFERENCES `request` (`ReqId`) ON DELETE CASCADE ON UPDATE CASCADE;

--
-- Constraints for table `request`
--
ALTER TABLE `request`
  ADD CONSTRAINT `request_ibfk_1` FOREIGN KEY (`TutorEmail`) REFERENCES `tutor` (`email`) ON DELETE CASCADE ON UPDATE CASCADE,
  ADD CONSTRAINT `request_ibfk_2` FOREIGN KEY (`LearnerEmail`) REFERENCES `learner` (`email`) ON DELETE CASCADE ON UPDATE CASCADE;
COMMIT;

/*!40101 SET CHARACTER_SET_CLIENT=@OLD_CHARACTER_SET_CLIENT */;
/*!40101 SET CHARACTER_SET_RESULTS=@OLD_CHARACTER_SET_RESULTS */;
/*!40101 SET COLLATION_CONNECTION=@OLD_COLLATION_CONNECTION */;
