-- MySQL dump 10.13  Distrib 8.0.34, for macos13 (arm64)
--
-- Host: localhost    Database: qualilab
-- ------------------------------------------------------
-- Server version	8.2.0

/*!40101 SET @OLD_CHARACTER_SET_CLIENT=@@CHARACTER_SET_CLIENT */;
/*!40101 SET @OLD_CHARACTER_SET_RESULTS=@@CHARACTER_SET_RESULTS */;
/*!40101 SET @OLD_COLLATION_CONNECTION=@@COLLATION_CONNECTION */;
/*!50503 SET NAMES utf8 */;
/*!40103 SET @OLD_TIME_ZONE=@@TIME_ZONE */;
/*!40103 SET TIME_ZONE='+00:00' */;
/*!40014 SET @OLD_UNIQUE_CHECKS=@@UNIQUE_CHECKS, UNIQUE_CHECKS=0 */;
/*!40014 SET @OLD_FOREIGN_KEY_CHECKS=@@FOREIGN_KEY_CHECKS, FOREIGN_KEY_CHECKS=0 */;
/*!40101 SET @OLD_SQL_MODE=@@SQL_MODE, SQL_MODE='NO_AUTO_VALUE_ON_ZERO' */;
/*!40111 SET @OLD_SQL_NOTES=@@SQL_NOTES, SQL_NOTES=0 */;

--
-- Table structure for table `feedback`
--

DROP TABLE IF EXISTS `feedback`;
/*!40101 SET @saved_cs_client     = @@character_set_client */;
/*!50503 SET character_set_client = utf8mb4 */;
CREATE TABLE `feedback` (
  `feedbackId` int NOT NULL AUTO_INCREMENT,
  `subSectionId` int NOT NULL,
  `feedback` text,
  `comments` text,
  `createdBy` int NOT NULL,
  `createdTime` timestamp NOT NULL DEFAULT CURRENT_TIMESTAMP,
  `updatedTime` datetime NOT NULL DEFAULT CURRENT_TIMESTAMP ON UPDATE CURRENT_TIMESTAMP,
  `deletedTime` datetime DEFAULT NULL,
  `deleted` int NOT NULL DEFAULT '0',
  PRIMARY KEY (`feedbackId`),
  KEY `feedback_createdBy_idx` (`createdBy`),
  KEY `feedback_subSectionId_idx` (`subSectionId`),
  CONSTRAINT `feedback_createdBy` FOREIGN KEY (`createdBy`) REFERENCES `users` (`userId`),
  CONSTRAINT `feedback_subSectionId` FOREIGN KEY (`subSectionId`) REFERENCES `sub_sections` (`subSectionId`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_0900_ai_ci;
/*!40101 SET character_set_client = @saved_cs_client */;

--
-- Dumping data for table `feedback`
--

LOCK TABLES `feedback` WRITE;
/*!40000 ALTER TABLE `feedback` DISABLE KEYS */;
/*!40000 ALTER TABLE `feedback` ENABLE KEYS */;
UNLOCK TABLES;

--
-- Table structure for table `feedback_status`
--

DROP TABLE IF EXISTS `feedback_status`;
/*!40101 SET @saved_cs_client     = @@character_set_client */;
/*!50503 SET character_set_client = utf8mb4 */;
CREATE TABLE `feedback_status` (
  `feedbackStatusId` int NOT NULL AUTO_INCREMENT,
  `feedbackStatusName` varchar(45) NOT NULL,
  `comment` text,
  `createdBy` int NOT NULL,
  `createdTime` timestamp NOT NULL DEFAULT CURRENT_TIMESTAMP,
  `updatedTime` datetime NOT NULL DEFAULT CURRENT_TIMESTAMP ON UPDATE CURRENT_TIMESTAMP,
  `deletedTime` datetime DEFAULT NULL,
  `deleted` int NOT NULL DEFAULT '0',
  PRIMARY KEY (`feedbackStatusId`),
  UNIQUE KEY `feedbackStatusName_UNIQUE` (`feedbackStatusName`),
  KEY `feedback_status_createdBy_idx` (`createdBy`),
  CONSTRAINT `feedback_status_createdBy` FOREIGN KEY (`createdBy`) REFERENCES `users` (`userId`)
) ENGINE=InnoDB AUTO_INCREMENT=3 DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_0900_ai_ci;
/*!40101 SET character_set_client = @saved_cs_client */;

--
-- Dumping data for table `feedback_status`
--

LOCK TABLES `feedback_status` WRITE;
/*!40000 ALTER TABLE `feedback_status` DISABLE KEYS */;
INSERT INTO `feedback_status` VALUES (1,'New',NULL,1,'2023-01-22 04:03:30','2023-01-22 07:03:30',NULL,0),(2,'Reviewed',NULL,1,'2023-01-22 04:03:30','2023-01-22 07:03:30',NULL,0);
/*!40000 ALTER TABLE `feedback_status` ENABLE KEYS */;
UNLOCK TABLES;

--
-- Table structure for table `forum_responses`
--

DROP TABLE IF EXISTS `forum_responses`;
/*!40101 SET @saved_cs_client     = @@character_set_client */;
/*!50503 SET character_set_client = utf8mb4 */;
CREATE TABLE `forum_responses` (
  `forumResponseId` int NOT NULL AUTO_INCREMENT,
  `response` text NOT NULL,
  `forumId` int NOT NULL,
  `published` int NOT NULL DEFAULT '0',
  `comments` text,
  `createdBy` int NOT NULL,
  `createdTime` timestamp NOT NULL DEFAULT CURRENT_TIMESTAMP,
  `updatedTime` datetime NOT NULL DEFAULT CURRENT_TIMESTAMP ON UPDATE CURRENT_TIMESTAMP,
  `deletedTime` datetime DEFAULT NULL,
  `deleted` int NOT NULL DEFAULT '0',
  PRIMARY KEY (`forumResponseId`),
  KEY `forum_responses_createdBy_idx` (`createdBy`),
  KEY `forum_responses_forumId_idx` (`forumId`),
  CONSTRAINT `forum_responses_createdBy` FOREIGN KEY (`createdBy`) REFERENCES `users` (`userId`),
  CONSTRAINT `forum_responses_forumId` FOREIGN KEY (`forumId`) REFERENCES `forums` (`forumId`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_0900_ai_ci;
/*!40101 SET character_set_client = @saved_cs_client */;

--
-- Dumping data for table `forum_responses`
--

LOCK TABLES `forum_responses` WRITE;
/*!40000 ALTER TABLE `forum_responses` DISABLE KEYS */;
/*!40000 ALTER TABLE `forum_responses` ENABLE KEYS */;
UNLOCK TABLES;

--
-- Table structure for table `forums`
--

DROP TABLE IF EXISTS `forums`;
/*!40101 SET @saved_cs_client     = @@character_set_client */;
/*!50503 SET character_set_client = utf8mb4 */;
CREATE TABLE `forums` (
  `forumId` int NOT NULL AUTO_INCREMENT,
  `title` varchar(45) DEFAULT NULL,
  `comments` text,
  `createdBy` int NOT NULL,
  `createdTime` timestamp NOT NULL DEFAULT CURRENT_TIMESTAMP,
  `updatedTime` datetime NOT NULL DEFAULT CURRENT_TIMESTAMP ON UPDATE CURRENT_TIMESTAMP,
  `deletedTime` datetime DEFAULT NULL,
  `deleted` int NOT NULL DEFAULT '0',
  PRIMARY KEY (`forumId`),
  KEY `forum_createdBy_idx` (`createdBy`),
  CONSTRAINT `forum_createdBy` FOREIGN KEY (`createdBy`) REFERENCES `users` (`userId`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_0900_ai_ci;
/*!40101 SET character_set_client = @saved_cs_client */;

--
-- Dumping data for table `forums`
--

LOCK TABLES `forums` WRITE;
/*!40000 ALTER TABLE `forums` DISABLE KEYS */;
/*!40000 ALTER TABLE `forums` ENABLE KEYS */;
UNLOCK TABLES;

--
-- Table structure for table `pages`
--

DROP TABLE IF EXISTS `pages`;
/*!40101 SET @saved_cs_client     = @@character_set_client */;
/*!50503 SET character_set_client = utf8mb4 */;
CREATE TABLE `pages` (
  `pageId` int NOT NULL AUTO_INCREMENT,
  `pageName` varchar(45) DEFAULT NULL,
  `create` int NOT NULL DEFAULT '0',
  `edit` int NOT NULL DEFAULT '0',
  `delete` int NOT NULL DEFAULT '0',
  `view` int NOT NULL DEFAULT '0',
  `comments` text,
  `createdTime` timestamp NOT NULL DEFAULT CURRENT_TIMESTAMP,
  `updatedTime` datetime NOT NULL DEFAULT CURRENT_TIMESTAMP ON UPDATE CURRENT_TIMESTAMP,
  `deletedTime` datetime DEFAULT NULL,
  `createdBy` int NOT NULL,
  `deleted` int NOT NULL DEFAULT '0',
  PRIMARY KEY (`pageId`),
  KEY `pages_createdBy_idx` (`createdBy`),
  CONSTRAINT `pages_createdBy` FOREIGN KEY (`createdBy`) REFERENCES `users` (`userId`)
) ENGINE=InnoDB AUTO_INCREMENT=15 DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_0900_ai_ci;
/*!40101 SET character_set_client = @saved_cs_client */;

--
-- Dumping data for table `pages`
--

LOCK TABLES `pages` WRITE;
/*!40000 ALTER TABLE `pages` DISABLE KEYS */;
INSERT INTO `pages` VALUES (1,'Users',1,1,1,1,NULL,'2021-04-08 09:13:19','2021-04-08 15:13:19',NULL,1,0),(2,'User Groups',1,1,1,1,NULL,'2021-04-08 09:13:19','2021-04-08 15:13:19',NULL,1,0),(3,'User Status',1,1,1,1,NULL,'2021-04-08 09:13:19','2021-04-08 15:13:19',NULL,1,0),(5,'Support Subject',1,1,1,1,NULL,'2021-04-08 09:13:19','2021-10-24 06:20:05',NULL,1,0),(6,'Support Status',1,1,1,1,NULL,'2021-04-08 09:13:19','2021-10-24 06:20:05',NULL,1,0),(7,'Manage Support',1,1,1,1,NULL,'2021-04-08 09:13:19','2021-10-24 06:20:05',NULL,1,0),(8,'Templates',1,1,1,1,NULL,'2021-04-08 09:13:19','2022-10-21 18:55:18',NULL,1,0),(9,'Reports',1,1,1,1,NULL,'2023-01-20 18:36:13','2023-01-30 14:19:16',NULL,1,0),(10,'Report Types',1,1,1,1,NULL,'2023-01-20 18:36:13','2023-01-30 14:19:16',NULL,1,0),(11,'Report Status',1,1,1,1,NULL,'2023-01-20 18:36:13','2023-01-30 14:19:16',NULL,1,0),(12,'Calendar',1,1,1,1,NULL,'2023-01-22 02:53:34','2023-01-30 14:19:16',NULL,1,0),(13,'Forum',1,1,1,1,NULL,'2023-01-22 02:53:34','2023-01-30 14:19:16',NULL,1,0),(14,'Resources',1,1,1,1,NULL,'2023-01-27 10:44:28','2023-01-30 14:19:16',NULL,1,0);
/*!40000 ALTER TABLE `pages` ENABLE KEYS */;
UNLOCK TABLES;

--
-- Table structure for table `support`
--

DROP TABLE IF EXISTS `support`;
/*!40101 SET @saved_cs_client     = @@character_set_client */;
/*!50503 SET character_set_client = utf8mb4 */;
CREATE TABLE `support` (
  `supportId` int NOT NULL AUTO_INCREMENT,
  `fullName` varchar(100) DEFAULT NULL,
  `mobile` varchar(45) DEFAULT NULL,
  `email` varchar(255) DEFAULT NULL,
  `supportSubjectId` int NOT NULL,
  `description` text NOT NULL,
  `supportStatusId` int NOT NULL,
  `resolution` text,
  `dateClosed` int DEFAULT NULL,
  `closedBy` int DEFAULT NULL,
  `createdBy` int NOT NULL,
  `createdTime` timestamp NOT NULL DEFAULT CURRENT_TIMESTAMP,
  `updatedTime` datetime NOT NULL DEFAULT CURRENT_TIMESTAMP ON UPDATE CURRENT_TIMESTAMP,
  `deletedTime` datetime DEFAULT NULL,
  `deleted` int NOT NULL DEFAULT '0',
  PRIMARY KEY (`supportId`),
  KEY `support_createdBy_idx` (`createdBy`),
  KEY `support_supportStatusId_idx` (`supportStatusId`),
  KEY `support_supportSubjectId_idx` (`supportSubjectId`),
  CONSTRAINT `support_createdBy` FOREIGN KEY (`createdBy`) REFERENCES `users` (`userId`),
  CONSTRAINT `support_supportStatusId` FOREIGN KEY (`supportStatusId`) REFERENCES `support_status` (`supportStatusId`),
  CONSTRAINT `support_supportSubjectId` FOREIGN KEY (`supportSubjectId`) REFERENCES `support_subjects` (`supportSubjectId`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_0900_ai_ci;
/*!40101 SET character_set_client = @saved_cs_client */;

--
-- Dumping data for table `support`
--

LOCK TABLES `support` WRITE;
/*!40000 ALTER TABLE `support` DISABLE KEYS */;
/*!40000 ALTER TABLE `support` ENABLE KEYS */;
UNLOCK TABLES;

--
-- Table structure for table `support_attachments`
--

DROP TABLE IF EXISTS `support_attachments`;
/*!40101 SET @saved_cs_client     = @@character_set_client */;
/*!50503 SET character_set_client = utf8mb4 */;
CREATE TABLE `support_attachments` (
  `attachmentId` int NOT NULL AUTO_INCREMENT,
  `caption` varchar(45) DEFAULT NULL,
  `supportId` int NOT NULL,
  `image` longtext,
  `createdBy` int NOT NULL,
  `createdTime` timestamp NOT NULL DEFAULT CURRENT_TIMESTAMP,
  `updatedTime` datetime NOT NULL DEFAULT CURRENT_TIMESTAMP ON UPDATE CURRENT_TIMESTAMP,
  `deletedTime` datetime DEFAULT NULL,
  `deleted` int NOT NULL DEFAULT '0',
  PRIMARY KEY (`attachmentId`),
  KEY `support_attachments_createdBy_idx` (`createdBy`),
  KEY `support_attachments_supportId_idx` (`supportId`),
  CONSTRAINT `support_attachments_createdBy` FOREIGN KEY (`createdBy`) REFERENCES `users` (`userId`),
  CONSTRAINT `support_attachments_supportId` FOREIGN KEY (`supportId`) REFERENCES `support` (`supportId`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_0900_ai_ci;
/*!40101 SET character_set_client = @saved_cs_client */;

--
-- Dumping data for table `support_attachments`
--

LOCK TABLES `support_attachments` WRITE;
/*!40000 ALTER TABLE `support_attachments` DISABLE KEYS */;
/*!40000 ALTER TABLE `support_attachments` ENABLE KEYS */;
UNLOCK TABLES;

--
-- Table structure for table `support_notes`
--

DROP TABLE IF EXISTS `support_notes`;
/*!40101 SET @saved_cs_client     = @@character_set_client */;
/*!50503 SET character_set_client = utf8mb4 */;
CREATE TABLE `support_notes` (
  `supportNoteId` int NOT NULL AUTO_INCREMENT,
  `supportId` int DEFAULT NULL,
  `comments` text,
  `createdBy` int NOT NULL,
  `createdTime` timestamp NOT NULL DEFAULT CURRENT_TIMESTAMP,
  `updatedTime` datetime NOT NULL DEFAULT CURRENT_TIMESTAMP ON UPDATE CURRENT_TIMESTAMP,
  `deletedTime` datetime DEFAULT NULL,
  `deleted` int NOT NULL DEFAULT '0',
  PRIMARY KEY (`supportNoteId`),
  KEY `support_notes_createdBy_idx` (`createdBy`),
  KEY `support_notes_supportId_idx` (`supportId`),
  CONSTRAINT `support_notes_createdBy` FOREIGN KEY (`createdBy`) REFERENCES `users` (`userId`),
  CONSTRAINT `support_notes_supportId` FOREIGN KEY (`supportId`) REFERENCES `support` (`supportId`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_0900_ai_ci;
/*!40101 SET character_set_client = @saved_cs_client */;

--
-- Dumping data for table `support_notes`
--

LOCK TABLES `support_notes` WRITE;
/*!40000 ALTER TABLE `support_notes` DISABLE KEYS */;
/*!40000 ALTER TABLE `support_notes` ENABLE KEYS */;
UNLOCK TABLES;

--
-- Table structure for table `support_status`
--

DROP TABLE IF EXISTS `support_status`;
/*!40101 SET @saved_cs_client     = @@character_set_client */;
/*!50503 SET character_set_client = utf8mb4 */;
CREATE TABLE `support_status` (
  `supportStatusId` int NOT NULL AUTO_INCREMENT,
  `supportStatusName` varchar(45) NOT NULL,
  `comments` text,
  `createdBy` int NOT NULL,
  `createdTime` timestamp NOT NULL DEFAULT CURRENT_TIMESTAMP,
  `updatedTime` datetime NOT NULL DEFAULT CURRENT_TIMESTAMP ON UPDATE CURRENT_TIMESTAMP,
  `deletedTime` datetime DEFAULT NULL,
  `deleted` int NOT NULL DEFAULT '0',
  PRIMARY KEY (`supportStatusId`),
  UNIQUE KEY `supportStatusName_UNIQUE` (`supportStatusName`),
  KEY `support_status_createdBy_idx` (`createdBy`),
  CONSTRAINT `support_status_createdBy` FOREIGN KEY (`createdBy`) REFERENCES `users` (`userId`)
) ENGINE=InnoDB AUTO_INCREMENT=3 DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_0900_ai_ci;
/*!40101 SET character_set_client = @saved_cs_client */;

--
-- Dumping data for table `support_status`
--

LOCK TABLES `support_status` WRITE;
/*!40000 ALTER TABLE `support_status` DISABLE KEYS */;
INSERT INTO `support_status` VALUES (1,'Pending',NULL,1,'2022-10-21 16:04:32','2022-10-21 19:04:32',NULL,0),(2,'Completed',NULL,1,'2022-10-21 16:04:32','2022-10-21 19:04:32',NULL,0);
/*!40000 ALTER TABLE `support_status` ENABLE KEYS */;
UNLOCK TABLES;

--
-- Table structure for table `support_subjects`
--

DROP TABLE IF EXISTS `support_subjects`;
/*!40101 SET @saved_cs_client     = @@character_set_client */;
/*!50503 SET character_set_client = utf8mb4 */;
CREATE TABLE `support_subjects` (
  `supportSubjectId` int NOT NULL AUTO_INCREMENT,
  `supportSubjectName` varchar(45) NOT NULL,
  `comments` text,
  `createdBy` int NOT NULL,
  `createdTime` timestamp NOT NULL DEFAULT CURRENT_TIMESTAMP,
  `updatedTime` datetime NOT NULL DEFAULT CURRENT_TIMESTAMP ON UPDATE CURRENT_TIMESTAMP,
  `deletedTime` datetime DEFAULT NULL,
  `deleted` int NOT NULL DEFAULT '0',
  PRIMARY KEY (`supportSubjectId`),
  UNIQUE KEY `supportSubjectName_UNIQUE` (`supportSubjectName`),
  KEY `support_subjects_createdBy_idx` (`createdBy`),
  CONSTRAINT `support_subjects_createdBy` FOREIGN KEY (`createdBy`) REFERENCES `users` (`userId`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_0900_ai_ci;
/*!40101 SET character_set_client = @saved_cs_client */;

--
-- Dumping data for table `support_subjects`
--

LOCK TABLES `support_subjects` WRITE;
/*!40000 ALTER TABLE `support_subjects` DISABLE KEYS */;
/*!40000 ALTER TABLE `support_subjects` ENABLE KEYS */;
UNLOCK TABLES;

--
-- Table structure for table `templates`
--

DROP TABLE IF EXISTS `templates`;
/*!40101 SET @saved_cs_client     = @@character_set_client */;
/*!50503 SET character_set_client = utf8mb4 */;
CREATE TABLE `templates` (
  `templateId` int NOT NULL AUTO_INCREMENT,
  `code` varchar(5) NOT NULL,
  `description` varchar(50) NOT NULL,
  `subject` varchar(50) NOT NULL,
  `message` text NOT NULL,
  `createdTime` timestamp NOT NULL DEFAULT CURRENT_TIMESTAMP,
  `updatedTime` datetime NOT NULL DEFAULT CURRENT_TIMESTAMP ON UPDATE CURRENT_TIMESTAMP,
  `deletedTime` datetime DEFAULT NULL,
  `createdBy` int NOT NULL,
  `deleted` int NOT NULL DEFAULT '0',
  PRIMARY KEY (`templateId`),
  UNIQUE KEY `code_UNIQUE` (`code`),
  KEY `templates_createdBy_idx` (`createdBy`),
  CONSTRAINT `templates_createdBy` FOREIGN KEY (`createdBy`) REFERENCES `users` (`userId`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_0900_ai_ci;
/*!40101 SET character_set_client = @saved_cs_client */;

--
-- Dumping data for table `templates`
--

LOCK TABLES `templates` WRITE;
/*!40000 ALTER TABLE `templates` DISABLE KEYS */;
/*!40000 ALTER TABLE `templates` ENABLE KEYS */;
UNLOCK TABLES;

--
-- Table structure for table `user_group_members`
--

DROP TABLE IF EXISTS `user_group_members`;
/*!40101 SET @saved_cs_client     = @@character_set_client */;
/*!50503 SET character_set_client = utf8mb4 */;
CREATE TABLE `user_group_members` (
  `userGroupMemberId` int NOT NULL AUTO_INCREMENT,
  `userId` int NOT NULL,
  `userGroupId` int NOT NULL,
  `active` int NOT NULL DEFAULT '0',
  `createdTime` timestamp NOT NULL DEFAULT CURRENT_TIMESTAMP,
  `updatedTime` datetime NOT NULL DEFAULT CURRENT_TIMESTAMP ON UPDATE CURRENT_TIMESTAMP,
  `deletedTime` datetime DEFAULT NULL,
  `createdBy` int NOT NULL,
  `deleted` int NOT NULL DEFAULT '0',
  PRIMARY KEY (`userGroupMemberId`),
  KEY `user_group_members_createdBy_idx` (`createdBy`),
  KEY `user_group_members_userId_idx` (`userId`),
  KEY `user_group_members_userGroupId_idx` (`userGroupId`),
  CONSTRAINT `user_group_members_createdBy` FOREIGN KEY (`createdBy`) REFERENCES `users` (`userId`),
  CONSTRAINT `user_group_members_userGroupId` FOREIGN KEY (`userGroupId`) REFERENCES `user_groups` (`userGroupId`),
  CONSTRAINT `user_group_members_userId` FOREIGN KEY (`userId`) REFERENCES `users` (`userId`)
) ENGINE=InnoDB AUTO_INCREMENT=2 DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_0900_ai_ci;
/*!40101 SET character_set_client = @saved_cs_client */;

--
-- Dumping data for table `user_group_members`
--

LOCK TABLES `user_group_members` WRITE;
/*!40000 ALTER TABLE `user_group_members` DISABLE KEYS */;
INSERT INTO `user_group_members` VALUES (1,1,1,1,'2023-01-20 18:34:20','2023-01-20 21:34:20',NULL,1,0);
/*!40000 ALTER TABLE `user_group_members` ENABLE KEYS */;
UNLOCK TABLES;

--
-- Table structure for table `user_group_rights`
--

DROP TABLE IF EXISTS `user_group_rights`;
/*!40101 SET @saved_cs_client     = @@character_set_client */;
/*!50503 SET character_set_client = utf8mb4 */;
CREATE TABLE `user_group_rights` (
  `userGroupRightId` int NOT NULL AUTO_INCREMENT,
  `pageId` int NOT NULL,
  `userGroupId` int NOT NULL,
  `create` int NOT NULL DEFAULT '0',
  `edit` int NOT NULL DEFAULT '0',
  `view` int NOT NULL DEFAULT '0',
  `delete` int NOT NULL DEFAULT '0',
  `createdTime` timestamp NOT NULL DEFAULT CURRENT_TIMESTAMP,
  `updatedTime` datetime NOT NULL DEFAULT CURRENT_TIMESTAMP ON UPDATE CURRENT_TIMESTAMP,
  `deletedTime` datetime DEFAULT NULL,
  `createdBy` int NOT NULL,
  `deleted` int NOT NULL DEFAULT '0',
  PRIMARY KEY (`userGroupRightId`),
  KEY `user_group_rights_createdBy_idx` (`createdBy`),
  KEY `user_group_rights_pageId_idx` (`pageId`),
  KEY `user_group_rights_userGroupId_idx` (`userGroupId`),
  CONSTRAINT `user_group_rights_createdBy` FOREIGN KEY (`createdBy`) REFERENCES `users` (`userId`),
  CONSTRAINT `user_group_rights_pageId` FOREIGN KEY (`pageId`) REFERENCES `pages` (`pageId`),
  CONSTRAINT `user_group_rights_userGroupId` FOREIGN KEY (`userGroupId`) REFERENCES `user_groups` (`userGroupId`)
) ENGINE=InnoDB AUTO_INCREMENT=16 DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_0900_ai_ci;
/*!40101 SET character_set_client = @saved_cs_client */;

--
-- Dumping data for table `user_group_rights`
--

LOCK TABLES `user_group_rights` WRITE;
/*!40000 ALTER TABLE `user_group_rights` DISABLE KEYS */;
INSERT INTO `user_group_rights` VALUES (1,1,1,1,1,1,1,'2023-01-19 06:28:55','2023-01-19 09:29:22',NULL,1,0),(2,2,1,1,1,1,1,'2023-01-19 06:28:55','2023-01-19 09:29:22',NULL,1,0),(3,3,1,1,1,1,1,'2023-01-19 06:28:55','2023-01-19 09:29:22',NULL,1,0),(5,5,1,1,1,1,1,'2023-01-19 06:28:55','2023-01-19 09:29:22',NULL,1,0),(6,6,1,1,1,1,1,'2023-01-19 06:28:55','2023-01-19 09:29:22',NULL,1,0),(7,7,1,1,1,1,1,'2023-01-19 06:28:55','2023-01-19 09:29:22',NULL,1,0),(8,8,1,1,1,1,1,'2023-01-19 06:28:55','2023-01-19 09:29:22',NULL,1,0),(9,9,1,1,1,1,1,'2023-01-20 18:37:20','2023-01-20 21:37:20',NULL,1,0),(10,10,1,1,1,1,1,'2023-01-20 18:37:20','2023-01-20 21:37:20',NULL,1,0),(11,11,1,1,1,1,1,'2023-01-20 18:37:20','2023-01-20 21:37:20',NULL,1,0),(12,12,1,1,1,1,1,'2023-01-22 02:54:12','2023-01-22 05:54:12',NULL,1,0),(13,13,1,1,1,1,1,'2023-01-22 02:54:12','2023-01-22 05:54:12',NULL,1,0),(14,14,1,1,1,1,1,'2023-01-27 10:45:27','2023-01-27 13:45:27',NULL,1,0);
/*!40000 ALTER TABLE `user_group_rights` ENABLE KEYS */;
UNLOCK TABLES;

--
-- Table structure for table `user_groups`
--

DROP TABLE IF EXISTS `user_groups`;
/*!40101 SET @saved_cs_client     = @@character_set_client */;
/*!50503 SET character_set_client = utf8mb4 */;
CREATE TABLE `user_groups` (
  `userGroupId` int NOT NULL AUTO_INCREMENT,
  `userGroupName` varchar(45) NOT NULL,
  `comments` text,
  `createdBy` int NOT NULL,
  `createdTime` timestamp NOT NULL DEFAULT CURRENT_TIMESTAMP,
  `updatedTime` datetime NOT NULL DEFAULT CURRENT_TIMESTAMP ON UPDATE CURRENT_TIMESTAMP,
  `deletedTime` datetime DEFAULT NULL,
  `deleted` int NOT NULL DEFAULT '0',
  PRIMARY KEY (`userGroupId`),
  UNIQUE KEY `userGroupName_UNIQUE` (`userGroupName`),
  KEY `user_groups_createdBy_idx` (`createdBy`),
  CONSTRAINT `user_groups_createdBy` FOREIGN KEY (`createdBy`) REFERENCES `users` (`userId`)
) ENGINE=InnoDB AUTO_INCREMENT=2 DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_0900_ai_ci;
/*!40101 SET character_set_client = @saved_cs_client */;

--
-- Dumping data for table `user_groups`
--

LOCK TABLES `user_groups` WRITE;
/*!40000 ALTER TABLE `user_groups` DISABLE KEYS */;
INSERT INTO `user_groups` VALUES (1,'Administrator',NULL,1,'2023-01-19 06:23:05','2023-01-19 09:23:05',NULL,0);
/*!40000 ALTER TABLE `user_groups` ENABLE KEYS */;
UNLOCK TABLES;

--
-- Table structure for table `user_status`
--

DROP TABLE IF EXISTS `user_status`;
/*!40101 SET @saved_cs_client     = @@character_set_client */;
/*!50503 SET character_set_client = utf8mb4 */;
CREATE TABLE `user_status` (
  `userStatusId` int NOT NULL AUTO_INCREMENT,
  `userStatusName` varchar(45) NOT NULL,
  `comments` text,
  `createdBy` int NOT NULL,
  `createdTime` timestamp NOT NULL DEFAULT CURRENT_TIMESTAMP,
  `updatedTime` datetime NOT NULL DEFAULT CURRENT_TIMESTAMP ON UPDATE CURRENT_TIMESTAMP,
  `deletedTime` datetime DEFAULT NULL,
  `deleted` int NOT NULL DEFAULT '0',
  PRIMARY KEY (`userStatusId`),
  UNIQUE KEY `userStatusName_UNIQUE` (`userStatusName`),
  KEY `user_status_createdBy_idx` (`createdBy`),
  CONSTRAINT `user_status_createdBy` FOREIGN KEY (`createdBy`) REFERENCES `users` (`userId`)
) ENGINE=InnoDB AUTO_INCREMENT=3 DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_0900_ai_ci;
/*!40101 SET character_set_client = @saved_cs_client */;

--
-- Dumping data for table `user_status`
--

LOCK TABLES `user_status` WRITE;
/*!40000 ALTER TABLE `user_status` DISABLE KEYS */;
INSERT INTO `user_status` VALUES (1,'Active',NULL,1,'2021-04-08 05:03:51','2021-04-08 11:03:51',NULL,0),(2,'Disabled',NULL,1,'2021-04-08 05:03:51','2021-04-08 11:03:51',NULL,0);
/*!40000 ALTER TABLE `user_status` ENABLE KEYS */;
UNLOCK TABLES;

--
-- Table structure for table `users`
--

DROP TABLE IF EXISTS `users`;
/*!40101 SET @saved_cs_client     = @@character_set_client */;
/*!50503 SET character_set_client = utf8mb4 */;
CREATE TABLE `users` (
  `userId` int NOT NULL AUTO_INCREMENT,
  `firstName` varchar(45) NOT NULL,
  `lastName` varchar(45) NOT NULL,
  `email` varchar(200) DEFAULT NULL,
  `mobile` varchar(45) NOT NULL,
  `passwordHash` varchar(128) DEFAULT NULL,
  `authKey` varchar(128) DEFAULT NULL,
  `userStatusId` int NOT NULL DEFAULT '0',
  `authToken` varchar(128) DEFAULT NULL,
  `renewToken` varchar(128) DEFAULT NULL,
  `resetCode` varchar(45) DEFAULT NULL,
  `expiryDate` int DEFAULT NULL,
  `tokenExpiry` date DEFAULT NULL,
  `changePassword` int NOT NULL DEFAULT '0',
  `createdTime` timestamp NOT NULL DEFAULT CURRENT_TIMESTAMP,
  `updatedTime` datetime NOT NULL DEFAULT CURRENT_TIMESTAMP ON UPDATE CURRENT_TIMESTAMP,
  `deletedTime` datetime DEFAULT NULL,
  `createdBy` int NOT NULL,
  `deleted` int NOT NULL DEFAULT '0',
  PRIMARY KEY (`userId`),
  UNIQUE KEY `mobile_UNIQUE` (`mobile`),
  KEY `users_userStatusId_idx` (`userStatusId`),
  CONSTRAINT `users_userStatusId` FOREIGN KEY (`userStatusId`) REFERENCES `user_status` (`userStatusId`)
) ENGINE=InnoDB AUTO_INCREMENT=2 DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_0900_ai_ci;
/*!40101 SET character_set_client = @saved_cs_client */;

--
-- Dumping data for table `users`
--

LOCK TABLES `users` WRITE;
/*!40000 ALTER TABLE `users` DISABLE KEYS */;
INSERT INTO `users` VALUES (1,'Joseph','Ngugi','ngugi.joseph@gmail.com','0722896758','$2y$13$eAVuYvdlbttNAZ1.xBwA/.EnDE9uNVhEP6N9jAzjWCQ0tPL83bkVi','M8jE5vffG_qAUmIAw5Kfx0ULsjWJC3j7',1,NULL,NULL,NULL,NULL,NULL,0,'2022-10-19 07:29:31','2022-10-21 18:19:42',NULL,1,0);
/*!40000 ALTER TABLE `users` ENABLE KEYS */;
UNLOCK TABLES;
/*!40103 SET TIME_ZONE=@OLD_TIME_ZONE */;

/*!40101 SET SQL_MODE=@OLD_SQL_MODE */;
/*!40014 SET FOREIGN_KEY_CHECKS=@OLD_FOREIGN_KEY_CHECKS */;
/*!40014 SET UNIQUE_CHECKS=@OLD_UNIQUE_CHECKS */;
/*!40101 SET CHARACTER_SET_CLIENT=@OLD_CHARACTER_SET_CLIENT */;
/*!40101 SET CHARACTER_SET_RESULTS=@OLD_CHARACTER_SET_RESULTS */;
/*!40101 SET COLLATION_CONNECTION=@OLD_COLLATION_CONNECTION */;
/*!40111 SET SQL_NOTES=@OLD_SQL_NOTES */;

-- Dump completed on 2024-02-08 14:39:34
