-- phpMyAdmin SQL Dump
-- version 5.2.0
-- https://www.phpmyadmin.net/
--
-- Host: 127.0.0.1
-- Generation Time: Nov 30, 2022 at 02:57 PM
-- Server version: 10.4.25-MariaDB
-- PHP Version: 8.1.10

SET SQL_MODE = "NO_AUTO_VALUE_ON_ZERO";
START TRANSACTION;
SET time_zone = "+00:00";


/*!40101 SET @OLD_CHARACTER_SET_CLIENT=@@CHARACTER_SET_CLIENT */;
/*!40101 SET @OLD_CHARACTER_SET_RESULTS=@@CHARACTER_SET_RESULTS */;
/*!40101 SET @OLD_COLLATION_CONNECTION=@@COLLATION_CONNECTION */;
/*!40101 SET NAMES utf8mb4 */;

--
-- Database: `waste`
--

DELIMITER $$
--
-- Procedures
--
CREATE DEFINER=`root`@`localhost` PROCEDURE `updatepnt` ()   begin
declare done int default 0;
declare compost int;
declare bgas int;
declare methan int;
DECLARE powersrc int;
DECLARE feed int;
declare srcid int;
declare sgid int;
declare uid int;
declare pnt int DEFAULT 0;
declare total int default 0;
declare c1 cursor
for select sg.sourceid,composting,methnation,feedstocks,biogas,power,segid,userID from segregation sg,source cs,complain c,users u where sg.sourceid=cs.SourceID and cs.comp_no=c.compID and u.id=c.userID;
declare continue handler for not found set done =1;

open c1;
sp:repeat
fetch c1 into srcid,compost,methan,feed,bgas,powersrc,sgid,uid;
set total=compost+methan+feed+bgas+powersrc;
if total >20 and total <40 then
set pnt=50;
end if;
if total>40 then
set pnt=70;
end if;
update users
set rewardpoint=pnt where id=uid;

if done=0 then
leave sp;
end if;
until done
end repeat;
close c1;


end$$

DELIMITER ;

-- --------------------------------------------------------

--
-- Table structure for table `complain`
--

CREATE TABLE `complain` (
  `compID` int(11) NOT NULL,
  `userID` int(11) NOT NULL,
  `Area` varchar(30) DEFAULT NULL,
  `Locality` varchar(30) DEFAULT NULL,
  `Landmark` varchar(30) DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4;

--
-- Dumping data for table `complain`
--

INSERT INTO `complain` (`compID`, `userID`, `Area`, `Locality`, `Landmark`) VALUES
(1, 2, 'mit', 'kothrud', 'pune'),
(3, 2, 'vanaz', 'kothrud', 'pune'),
(4, 2, 'aa', 'bb', 'cc');

--
-- Triggers `complain`
--
DELIMITER $$
CREATE TRIGGER `AddTosource` AFTER INSERT ON `complain` FOR EACH ROW BEGIN
       INSERT INTO source (Area,Locality,Landmark,comp_no) VALUES (NEW.Area,NEW.Locality,NEW.Landmark,NEW.compID);
   END
$$
DELIMITER ;

-- --------------------------------------------------------

--
-- Table structure for table `driver`
--

CREATE TABLE `driver` (
  `DriverID` int(11) NOT NULL,
  `DriverName` varchar(45) DEFAULT NULL,
  `DateOfJoining` date DEFAULT current_timestamp(),
  `Contact` int(11) DEFAULT NULL,
  `email` varchar(30) DEFAULT NULL,
  `password` varchar(30) NOT NULL DEFAULT 'password'
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4;

--
-- Dumping data for table `driver`
--

INSERT INTO `driver` (`DriverID`, `DriverName`, `DateOfJoining`, `Contact`, `email`, `password`) VALUES
(31, 'aakash', '2022-11-26', 1234567890, 'akash@akash.com', 'password'),
(34, 'prabhu', '2022-11-26', 1234567890, 'prabhu@prabhu.com', 'password'),
(35, 'vilas', '2022-11-28', 2147483647, 'vv@gmail.com', 'password');

-- --------------------------------------------------------

--
-- Table structure for table `quantity_collected`
--

CREATE TABLE `quantity_collected` (
  `DriverID` int(11) NOT NULL,
  `TotalWeight` float DEFAULT NULL,
  `sourceid` int(11) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4;

--
-- Dumping data for table `quantity_collected`
--

INSERT INTO `quantity_collected` (`DriverID`, `TotalWeight`, `sourceid`) VALUES
(31, 55, 1),
(34, 55, 3);

--
-- Triggers `quantity_collected`
--
DELIMITER $$
CREATE TRIGGER `statusupdate` AFTER INSERT ON `quantity_collected` FOR EACH ROW update source
set status=1 where source.SourceID=NEW.sourceid
$$
DELIMITER ;

-- --------------------------------------------------------

--
-- Table structure for table `segregation`
--

CREATE TABLE `segregation` (
  `sourceid` int(11) DEFAULT NULL,
  `composting` int(11) DEFAULT 0,
  `methnation` int(11) DEFAULT 0,
  `feedstocks` int(11) DEFAULT 0,
  `biogas` int(11) DEFAULT 0,
  `power` int(11) DEFAULT 0,
  `segid` int(11) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4;

--
-- Dumping data for table `segregation`
--

INSERT INTO `segregation` (`sourceid`, `composting`, `methnation`, `feedstocks`, `biogas`, `power`, `segid`) VALUES
(1, 4, 12, 7, 6, 5, 4);

--
-- Triggers `segregation`
--
DELIMITER $$
CREATE TRIGGER `call_upd_pnt` AFTER INSERT ON `segregation` FOR EACH ROW BEGIN
call updatepnt;
END
$$
DELIMITER ;

-- --------------------------------------------------------

--
-- Table structure for table `source`
--

CREATE TABLE `source` (
  `SourceID` int(11) NOT NULL,
  `Area` varchar(45) DEFAULT NULL,
  `Locality` varchar(45) NOT NULL,
  `Landmark` varchar(30) NOT NULL,
  `DriverID` int(11) DEFAULT NULL,
  `comp_no` int(11) NOT NULL,
  `VehicleNo` int(11) DEFAULT NULL,
  `status` tinyint(1) NOT NULL DEFAULT 0
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4;

--
-- Dumping data for table `source`
--

INSERT INTO `source` (`SourceID`, `Area`, `Locality`, `Landmark`, `DriverID`, `comp_no`, `VehicleNo`, `status`) VALUES
(1, 'mit', 'kothrud', 'pune', 31, 1, 1, 1),
(2, 'vanaz', 'kothrud', 'pune', NULL, 3, NULL, 0),
(3, 'aa', 'bb', 'cc', 34, 4, 2, 1);

-- --------------------------------------------------------

--
-- Table structure for table `users`
--

CREATE TABLE `users` (
  `Name` varchar(20) NOT NULL,
  `email` varchar(50) NOT NULL,
  `password` varchar(15) NOT NULL,
  `phone_no` bigint(10) NOT NULL,
  `id` int(11) NOT NULL,
  `rewardpoint` int(11) NOT NULL DEFAULT 0
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4;

--
-- Dumping data for table `users`
--

INSERT INTO `users` (`Name`, `email`, `password`, `phone_no`, `id`, `rewardpoint`) VALUES
('Om Kumar', 'abc1872@gmail.com', '12345678', 6299440358, 2, 50);

--
-- Indexes for dumped tables
--

--
-- Indexes for table `complain`
--
ALTER TABLE `complain`
  ADD PRIMARY KEY (`compID`) USING BTREE,
  ADD KEY `fkk7` (`userID`);

--
-- Indexes for table `driver`
--
ALTER TABLE `driver`
  ADD PRIMARY KEY (`DriverID`);

--
-- Indexes for table `quantity_collected`
--
ALTER TABLE `quantity_collected`
  ADD KEY `fk` (`DriverID`),
  ADD KEY `fk1` (`sourceid`);

--
-- Indexes for table `segregation`
--
ALTER TABLE `segregation`
  ADD PRIMARY KEY (`segid`),
  ADD KEY `fkk6` (`sourceid`);

--
-- Indexes for table `source`
--
ALTER TABLE `source`
  ADD PRIMARY KEY (`SourceID`),
  ADD KEY `fkk8` (`DriverID`),
  ADD KEY `fkk14` (`comp_no`);

--
-- Indexes for table `users`
--
ALTER TABLE `users`
  ADD PRIMARY KEY (`id`);

--
-- AUTO_INCREMENT for dumped tables
--

--
-- AUTO_INCREMENT for table `complain`
--
ALTER TABLE `complain`
  MODIFY `compID` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=5;

--
-- AUTO_INCREMENT for table `driver`
--
ALTER TABLE `driver`
  MODIFY `DriverID` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=37;

--
-- AUTO_INCREMENT for table `segregation`
--
ALTER TABLE `segregation`
  MODIFY `segid` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=5;

--
-- AUTO_INCREMENT for table `source`
--
ALTER TABLE `source`
  MODIFY `SourceID` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=4;

--
-- AUTO_INCREMENT for table `users`
--
ALTER TABLE `users`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=3;

--
-- Constraints for dumped tables
--

--
-- Constraints for table `complain`
--
ALTER TABLE `complain`
  ADD CONSTRAINT `fkk7` FOREIGN KEY (`userID`) REFERENCES `users` (`id`);

--
-- Constraints for table `quantity_collected`
--
ALTER TABLE `quantity_collected`
  ADD CONSTRAINT `fk` FOREIGN KEY (`DriverID`) REFERENCES `driver` (`DriverID`) ON DELETE CASCADE ON UPDATE CASCADE,
  ADD CONSTRAINT `fk1` FOREIGN KEY (`sourceid`) REFERENCES `source` (`SourceID`);

--
-- Constraints for table `segregation`
--
ALTER TABLE `segregation`
  ADD CONSTRAINT `fkk6` FOREIGN KEY (`sourceid`) REFERENCES `source` (`SourceID`);

--
-- Constraints for table `source`
--
ALTER TABLE `source`
  ADD CONSTRAINT `fkk14` FOREIGN KEY (`comp_no`) REFERENCES `complain` (`compID`),
  ADD CONSTRAINT `fkk8` FOREIGN KEY (`DriverID`) REFERENCES `driver` (`DriverID`);
COMMIT;

/*!40101 SET CHARACTER_SET_CLIENT=@OLD_CHARACTER_SET_CLIENT */;
/*!40101 SET CHARACTER_SET_RESULTS=@OLD_CHARACTER_SET_RESULTS */;
/*!40101 SET COLLATION_CONNECTION=@OLD_COLLATION_CONNECTION */;
