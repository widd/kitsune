-- phpMyAdmin SQL Dump
-- version 4.5.0.2
-- http://www.phpmyadmin.net
--
-- Host: 127.0.0.1
-- Generation Time: Dec 24, 2015 at 03:59 AM
-- Server version: 10.0.17-MariaDB
-- PHP Version: 5.6.14

SET SQL_MODE = "NO_AUTO_VALUE_ON_ZERO";
SET time_zone = "+00:00";


/*!40101 SET @OLD_CHARACTER_SET_CLIENT=@@CHARACTER_SET_CLIENT */;
/*!40101 SET @OLD_CHARACTER_SET_RESULTS=@@CHARACTER_SET_RESULTS */;
/*!40101 SET @OLD_COLLATION_CONNECTION=@@COLLATION_CONNECTION */;
/*!40101 SET NAMES utf8mb4 */;

--
-- Database: `kitsune`
--

-- --------------------------------------------------------

--
-- Table structure for table `bans`
--

CREATE TABLE `bans` (
  `ID` int(11) NOT NULL,
  `Moderator` char(12) NOT NULL,
  `Player` int(11) UNSIGNED NOT NULL,
  `Comment` text NOT NULL,
  `Expiration` int(8) NOT NULL,
  `Time` int(8) NOT NULL,
  `Type` smallint(3) UNSIGNED NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=latin1;

-- --------------------------------------------------------

--
-- Table structure for table `igloos`
--

CREATE TABLE `igloos` (
  `ID` int(10) UNSIGNED NOT NULL,
  `Owner` int(10) UNSIGNED NOT NULL,
  `Type` tinyint(3) UNSIGNED NOT NULL DEFAULT '1',
  `Floor` tinyint(3) UNSIGNED NOT NULL DEFAULT '0',
  `Music` smallint(6) NOT NULL DEFAULT '0',
  `Furniture` text NOT NULL,
  `Location` tinyint(3) UNSIGNED NOT NULL DEFAULT '1',
  `Likes` text NOT NULL,
  `Locked` tinyint(1) NOT NULL DEFAULT '1'
) ENGINE=InnoDB DEFAULT CHARSET=latin1;

-- --------------------------------------------------------

--
-- Table structure for table `penguins`
--

CREATE TABLE `penguins` (
  `ID` int(10) UNSIGNED NOT NULL,
  `Username` char(12) NOT NULL,
  `Nickname` char(16) NOT NULL,
  `Password` char(255) NOT NULL,
  `LoginKey` char(32) NOT NULL,
  `ConfirmationHash` char(32) NOT NULL,
  `SWID` char(38) CHARACTER SET ascii COLLATE ascii_bin NOT NULL,
  `Avatar` tinyint(3) UNSIGNED NOT NULL DEFAULT '0' COMMENT 'Don''t think ID will go beyond 255',
  `AvatarAttributes` char(98) NOT NULL DEFAULT '{"spriteScale":100,"spriteSpeed":100,"ignoresBlockLayer":false,"invisible":false,"floating":false}',
  `Email` char(254) NOT NULL,
  `RegistrationDate` int(8) NOT NULL,
  `Moderator` tinyint(1) NOT NULL DEFAULT '0',
  `Inventory` text NOT NULL,
  `CareInventory` text NOT NULL,
  `Coins` mediumint(7) UNSIGNED NOT NULL DEFAULT '200000',
  `Igloo` int(10) UNSIGNED NOT NULL COMMENT 'Current active igloo',
  `Igloos` text NOT NULL COMMENT 'Owned igloo types',
  `Floors` text NOT NULL COMMENT 'Owned floorings',
  `Locations` text NOT NULL COMMENT 'Owned locations',
  `Furniture` text NOT NULL COMMENT 'Furniture inventory',
  `Color` tinyint(3) UNSIGNED NOT NULL DEFAULT '1',
  `Head` smallint(5) UNSIGNED NOT NULL DEFAULT '0',
  `Face` smallint(5) UNSIGNED NOT NULL DEFAULT '0',
  `Neck` smallint(5) UNSIGNED NOT NULL DEFAULT '0',
  `Body` smallint(5) UNSIGNED NOT NULL DEFAULT '0',
  `Hand` smallint(5) UNSIGNED NOT NULL DEFAULT '0',
  `Feet` smallint(5) UNSIGNED NOT NULL DEFAULT '0',
  `Photo` smallint(5) UNSIGNED NOT NULL DEFAULT '0',
  `Flag` smallint(5) UNSIGNED NOT NULL DEFAULT '0',
  `Walking` int(10) UNSIGNED NOT NULL DEFAULT '0' COMMENT 'Puffle ID',
  `Banned` varchar(20) NOT NULL DEFAULT '0' COMMENT 'Timestamp of ban',
  `Stamps` text NOT NULL,
  `StampBook` varchar(150) NOT NULL DEFAULT '1%1%1%1',
  `EPF` varchar(9) NOT NULL DEFAULT '0,0,0',
  `PuffleQuest` varchar(25) NOT NULL DEFAULT '0,1,|0;0;1403959119;'
) ENGINE=InnoDB DEFAULT CHARSET=latin1;

-- --------------------------------------------------------

--
-- Table structure for table `postcards`
--

CREATE TABLE `postcards` (
  `ID` int(10) UNSIGNED NOT NULL,
  `Recipient` int(10) UNSIGNED NOT NULL,
  `SenderName` char(12) NOT NULL,
  `SenderID` int(10) UNSIGNED NOT NULL,
  `Details` varchar(12) NOT NULL,
  `Date` int(8) NOT NULL,
  `Type` smallint(5) UNSIGNED NOT NULL,
  `HasRead` tinyint(1) NOT NULL DEFAULT '0'
) ENGINE=InnoDB DEFAULT CHARSET=latin1;

-- --------------------------------------------------------

--
-- Table structure for table `puffles`
--

CREATE TABLE `puffles` (
  `ID` int(10) UNSIGNED NOT NULL,
  `Owner` int(10) UNSIGNED NOT NULL,
  `Name` char(12) NOT NULL,
  `AdoptionDate` int(8) NOT NULL,
  `Type` tinyint(3) UNSIGNED NOT NULL,
  `Subtype` smallint(5) UNSIGNED NOT NULL,
  `Hat` smallint(5) UNSIGNED NOT NULL,
  `Food` tinyint(3) UNSIGNED NOT NULL DEFAULT '100',
  `Play` tinyint(3) UNSIGNED NOT NULL DEFAULT '100',
  `Rest` tinyint(3) UNSIGNED NOT NULL DEFAULT '100',
  `Clean` tinyint(3) UNSIGNED NOT NULL DEFAULT '100',
  `Backyard` tinyint(1) NOT NULL DEFAULT '0'
) ENGINE=InnoDB DEFAULT CHARSET=latin1;

-- --------------------------------------------------------

--
-- Table structure for table `tracks`
--

CREATE TABLE `tracks` (
  `ID` int(10) UNSIGNED NOT NULL,
  `Name` varchar(12) COLLATE utf8mb4_unicode_ci NOT NULL,
  `Owner` int(10) UNSIGNED NOT NULL,
  `Hash` char(32) COLLATE utf8mb4_unicode_ci NOT NULL,
  `Sharing` tinyint(1) NOT NULL DEFAULT '0',
  `Pattern` mediumtext COLLATE utf8mb4_unicode_ci NOT NULL,
  `Likes` smallint(5) UNSIGNED NOT NULL DEFAULT '0',
  `LikeStatistics` text COLLATE utf8mb4_unicode_ci NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

--
-- Indexes for dumped tables
--

--
-- Indexes for table `bans`
--
ALTER TABLE `bans`
  ADD PRIMARY KEY (`ID`),
  ADD UNIQUE KEY `Time` (`Time`);

--
-- Indexes for table `igloos`
--
ALTER TABLE `igloos`
  ADD PRIMARY KEY (`ID`);

--
-- Indexes for table `penguins`
--
ALTER TABLE `penguins`
  ADD PRIMARY KEY (`ID`),
  ADD UNIQUE KEY `Username` (`Username`);

--
-- Indexes for table `postcards`
--
ALTER TABLE `postcards`
  ADD PRIMARY KEY (`ID`);

--
-- Indexes for table `puffles`
--
ALTER TABLE `puffles`
  ADD PRIMARY KEY (`ID`);

--
-- Indexes for table `tracks`
--
ALTER TABLE `tracks`
  ADD PRIMARY KEY (`ID`);

--
-- AUTO_INCREMENT for dumped tables
--

--
-- AUTO_INCREMENT for table `bans`
--
ALTER TABLE `bans`
  MODIFY `ID` int(11) NOT NULL AUTO_INCREMENT;
--
-- AUTO_INCREMENT for table `igloos`
--
ALTER TABLE `igloos`
  MODIFY `ID` int(10) UNSIGNED NOT NULL AUTO_INCREMENT;
--
-- AUTO_INCREMENT for table `penguins`
--
ALTER TABLE `penguins`
  MODIFY `ID` int(10) UNSIGNED NOT NULL AUTO_INCREMENT;
--
-- AUTO_INCREMENT for table `postcards`
--
ALTER TABLE `postcards`
  MODIFY `ID` int(10) UNSIGNED NOT NULL AUTO_INCREMENT;
--
-- AUTO_INCREMENT for table `puffles`
--
ALTER TABLE `puffles`
  MODIFY `ID` int(10) UNSIGNED NOT NULL AUTO_INCREMENT;
--
-- AUTO_INCREMENT for table `tracks`
--
ALTER TABLE `tracks`
  MODIFY `ID` int(10) UNSIGNED NOT NULL AUTO_INCREMENT;
/*!40101 SET CHARACTER_SET_CLIENT=@OLD_CHARACTER_SET_CLIENT */;
/*!40101 SET CHARACTER_SET_RESULTS=@OLD_CHARACTER_SET_RESULTS */;
/*!40101 SET COLLATION_CONNECTION=@OLD_COLLATION_CONNECTION */;
