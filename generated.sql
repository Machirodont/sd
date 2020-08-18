-- MySQL dump 10.13  Distrib 8.0.12, for Win64 (x86_64)
--
-- Host: localhost    Database: sd
-- ------------------------------------------------------
-- Server version	8.0.12

/*!40101 SET @OLD_CHARACTER_SET_CLIENT=@@CHARACTER_SET_CLIENT */;
/*!40101 SET @OLD_CHARACTER_SET_RESULTS=@@CHARACTER_SET_RESULTS */;
/*!40101 SET @OLD_COLLATION_CONNECTION=@@COLLATION_CONNECTION */;
 SET NAMES utf8mb4 ;
/*!40103 SET @OLD_TIME_ZONE=@@TIME_ZONE */;
/*!40103 SET TIME_ZONE='+00:00' */;
/*!40014 SET @OLD_UNIQUE_CHECKS=@@UNIQUE_CHECKS, UNIQUE_CHECKS=0 */;
/*!40014 SET @OLD_FOREIGN_KEY_CHECKS=@@FOREIGN_KEY_CHECKS, FOREIGN_KEY_CHECKS=0 */;
/*!40101 SET @OLD_SQL_MODE=@@SQL_MODE, SQL_MODE='NO_AUTO_VALUE_ON_ZERO' */;
/*!40111 SET @OLD_SQL_NOTES=@@SQL_NOTES, SQL_NOTES=0 */;

--
-- Table structure for table `sd_hit_counter`
--

DROP TABLE IF EXISTS `sd_hit_counter`;
/*!40101 SET @saved_cs_client     = @@character_set_client */;
 SET character_set_client = utf8mb4 ;
CREATE TABLE `sd_hit_counter` (
  `id` int(11) NOT NULL AUTO_INCREMENT,
  `cid` int(11) NOT NULL DEFAULT '0',
  `hit` tinytext,
  `hitTime` datetime DEFAULT NULL,
  `ip` tinytext,
  `useragent` text,
  `screen` tinytext,
  PRIMARY KEY (`id`)
) ENGINE=InnoDB  DEFAULT CHARSET=utf8;
/*!40101 SET character_set_client = @saved_cs_client */;

--
-- Table structure for table `sd_loaded_schedules`
--

DROP TABLE IF EXISTS `sd_loaded_schedules`;
/*!40101 SET @saved_cs_client     = @@character_set_client */;
 SET character_set_client = utf8mb4 ;
CREATE TABLE `sd_loaded_schedules` (
  `fileName` tinytext NOT NULL,
  `parsed` tinyint(4) NOT NULL DEFAULT '0',
  `loadTime` datetime DEFAULT NULL,
  PRIMARY KEY (`fileName`(63))
) ENGINE=InnoDB DEFAULT CHARSET=utf8;
/*!40101 SET character_set_client = @saved_cs_client */;

--
-- Table structure for table `sd_price_group`
--

DROP TABLE IF EXISTS `sd_price_group`;
/*!40101 SET @saved_cs_client     = @@character_set_client */;
 SET character_set_client = utf8mb4 ;
CREATE TABLE `sd_price_group` (
  `id` int(11) NOT NULL AUTO_INCREMENT,
  `groupName` text,
  `parentId` int(11) DEFAULT NULL,
  `removed` datetime DEFAULT NULL,
  PRIMARY KEY (`id`),
  UNIQUE KEY `groupName_parentId` (`groupName`(63),`parentId`),
  KEY `groupName` (`groupName`(63)),
  KEY `parentId` (`parentId`)
) ENGINE=InnoDB  DEFAULT CHARSET=utf8;
/*!40101 SET character_set_client = @saved_cs_client */;

--
-- Table structure for table `sd_price_group_index`
--

DROP TABLE IF EXISTS `sd_price_group_index`;
/*!40101 SET @saved_cs_client     = @@character_set_client */;
 SET character_set_client = utf8mb4 ;
CREATE TABLE `sd_price_group_index` (
  `id` int(11) NOT NULL AUTO_INCREMENT,
  `groupId` int(11) NOT NULL DEFAULT '0',
  `clinicId` int(11) NOT NULL DEFAULT '0',
  `n` int(11) NOT NULL DEFAULT '0',
  PRIMARY KEY (`id`),
  KEY `groupId` (`groupId`),
  KEY `clinicId` (`clinicId`),
  KEY `n` (`n`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8;
/*!40101 SET character_set_client = @saved_cs_client */;

--
-- Table structure for table `sd_price_items`
--

DROP TABLE IF EXISTS `sd_price_items`;
/*!40101 SET @saved_cs_client     = @@character_set_client */;
 SET character_set_client = utf8mb4 ;
CREATE TABLE `sd_price_items` (
  `id` int(11) NOT NULL AUTO_INCREMENT,
  `code` tinytext NOT NULL,
  `name` text NOT NULL,
  `groupId` int(11) DEFAULT NULL,
  `item_type` tinyint(4) DEFAULT NULL,
  `global_price` float DEFAULT NULL,
  `info` text,
  `removed` datetime DEFAULT NULL,
  PRIMARY KEY (`id`),
  KEY `code` (`code`(63))
) ENGINE=InnoDB  DEFAULT CHARSET=utf8;
/*!40101 SET character_set_client = @saved_cs_client */;

--
-- Table structure for table `sd_price_local`
--

DROP TABLE IF EXISTS `sd_price_local`;
/*!40101 SET @saved_cs_client     = @@character_set_client */;
 SET character_set_client = utf8mb4 ;
CREATE TABLE `sd_price_local` (
  `id` int(11) NOT NULL AUTO_INCREMENT,
  `itemId` int(11) NOT NULL,
  `clinicId` int(11) NOT NULL,
  `price` float DEFAULT NULL,
  PRIMARY KEY (`id`),
  KEY `itemId` (`itemId`),
  KEY `clinicId` (`clinicId`)
) ENGINE=MyISAM  DEFAULT CHARSET=utf8;
/*!40101 SET character_set_client = @saved_cs_client */;

--
-- Table structure for table `sd_shedule_assign`
--

DROP TABLE IF EXISTS `sd_shedule_assign`;
/*!40101 SET @saved_cs_client     = @@character_set_client */;
 SET character_set_client = utf8mb4 ;
CREATE TABLE `sd_shedule_assign` (
  `id` int(11) NOT NULL AUTO_INCREMENT,
  `personId` int(11) DEFAULT NULL,
  `shedule_hash` text,
  `schedule_fio` text,
  PRIMARY KEY (`id`)
) ENGINE=InnoDB  DEFAULT CHARSET=utf8;
/*!40101 SET character_set_client = @saved_cs_client */;

--
-- Table structure for table `sd_timelines`
--

DROP TABLE IF EXISTS `sd_timelines`;
/*!40101 SET @saved_cs_client     = @@character_set_client */;
 SET character_set_client = utf8mb4 ;
CREATE TABLE `sd_timelines` (
  `id` int(11) NOT NULL AUTO_INCREMENT,
  `workplace_hash` tinytext NOT NULL,
  `person_id` int(11) NOT NULL,
  PRIMARY KEY (`id`),
  UNIQUE KEY `workplace_hash_person_id` (`workplace_hash`(32),`person_id`),
  KEY `workplace_hash` (`workplace_hash`(32)),
  KEY `person_id` (`person_id`)
) ENGINE=InnoDB  DEFAULT CHARSET=utf8;
/*!40101 SET character_set_client = @saved_cs_client */;

--
-- Table structure for table `sd_timeline_cells`
--

DROP TABLE IF EXISTS `sd_timeline_cells`;
/*!40101 SET @saved_cs_client     = @@character_set_client */;
 SET character_set_client = utf8mb4 ;
CREATE TABLE `sd_timeline_cells` (
  `id` int(11) NOT NULL AUTO_INCREMENT,
  `timelineId` int(11) NOT NULL DEFAULT '0',
  `start` datetime NOT NULL,
  `end` datetime NOT NULL,
  `free` tinyint(4) NOT NULL DEFAULT '0',
  `source` varchar(63) NOT NULL,
  PRIMARY KEY (`id`),
  KEY `timelineId` (`timelineId`),
  KEY `start` (`start`),
  KEY `end` (`end`)
) ENGINE=InnoDB  DEFAULT CHARSET=utf8;
/*!40101 SET character_set_client = @saved_cs_client */;

--
-- Table structure for table `sd_timeline_changelog`
--

DROP TABLE IF EXISTS `sd_timeline_changelog`;
/*!40101 SET @saved_cs_client     = @@character_set_client */;
 SET character_set_client = utf8mb4 ;
CREATE TABLE `sd_timeline_changelog` (
  `id` int(11) NOT NULL AUTO_INCREMENT,
  `timelineId` int(11) NOT NULL DEFAULT '0',
  `cellsDate` date DEFAULT NULL,
  `oldCells` text NOT NULL,
  `newCells` text NOT NULL,
  `change_source` varchar(50) DEFAULT NULL,
  PRIMARY KEY (`id`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8;
/*!40101 SET character_set_client = @saved_cs_client */;

--
-- Table structure for table `sd_timeline_days`
--

DROP TABLE IF EXISTS `sd_timeline_days`;
/*!40101 SET @saved_cs_client     = @@character_set_client */;
 SET character_set_client = utf8mb4 ;
CREATE TABLE `sd_timeline_days` (
  `id` int(11) NOT NULL AUTO_INCREMENT,
  `timelineId` int(11) NOT NULL DEFAULT '0',
  `day` date NOT NULL,
  `is_active` tinyint(3) unsigned DEFAULT NULL,
  PRIMARY KEY (`id`),
  UNIQUE KEY `timelineId_day` (`timelineId`,`day`),
  KEY `timelineId` (`timelineId`),
  KEY `day` (`day`)
) ENGINE=InnoDB  DEFAULT CHARSET=utf8;
/*!40101 SET character_set_client = @saved_cs_client */;

--
-- Table structure for table `sd_workplaces`
--

DROP TABLE IF EXISTS `sd_workplaces`;
/*!40101 SET @saved_cs_client     = @@character_set_client */;
 SET character_set_client = utf8mb4 ;
CREATE TABLE `sd_workplaces` (
  `id` int(11) NOT NULL AUTO_INCREMENT,
  `workplace_hash` text NOT NULL,
  `clinic_hash` text,
  PRIMARY KEY (`id`),
  UNIQUE KEY `workplace_hash` (`workplace_hash`(32))
) ENGINE=InnoDB  DEFAULT CHARSET=utf8;
/*!40101 SET character_set_client = @saved_cs_client */;
/*!40103 SET TIME_ZONE=@OLD_TIME_ZONE */;

/*!40101 SET SQL_MODE=@OLD_SQL_MODE */;
/*!40014 SET FOREIGN_KEY_CHECKS=@OLD_FOREIGN_KEY_CHECKS */;
/*!40014 SET UNIQUE_CHECKS=@OLD_UNIQUE_CHECKS */;
/*!40101 SET CHARACTER_SET_CLIENT=@OLD_CHARACTER_SET_CLIENT */;
/*!40101 SET CHARACTER_SET_RESULTS=@OLD_CHARACTER_SET_RESULTS */;
/*!40101 SET COLLATION_CONNECTION=@OLD_COLLATION_CONNECTION */;
/*!40111 SET SQL_NOTES=@OLD_SQL_NOTES */;

-- Dump completed on 2020-08-18 15:55:03
