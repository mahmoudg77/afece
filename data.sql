-- MySQL dump 10.13  Distrib 5.5.41, for debian-linux-gnu (x86_64)
--
-- Host: 10.123.0.85    Database: mahgom35_fw_v1
-- ------------------------------------------------------
-- Server version	5.6.27

/*!40101 SET @OLD_CHARACTER_SET_CLIENT=@@CHARACTER_SET_CLIENT */;
/*!40101 SET @OLD_CHARACTER_SET_RESULTS=@@CHARACTER_SET_RESULTS */;
/*!40101 SET @OLD_COLLATION_CONNECTION=@@COLLATION_CONNECTION */;
/*!40101 SET NAMES utf8 */;
/*!40103 SET @OLD_TIME_ZONE=@@TIME_ZONE */;
/*!40103 SET TIME_ZONE='+00:00' */;
/*!40014 SET @OLD_UNIQUE_CHECKS=@@UNIQUE_CHECKS, UNIQUE_CHECKS=0 */;
/*!40014 SET @OLD_FOREIGN_KEY_CHECKS=@@FOREIGN_KEY_CHECKS, FOREIGN_KEY_CHECKS=0 */;
/*!40101 SET @OLD_SQL_MODE=@@SQL_MODE, SQL_MODE='NO_AUTO_VALUE_ON_ZERO' */;
/*!40111 SET @OLD_SQL_NOTES=@@SQL_NOTES, SQL_NOTES=0 */;

--
-- Table structure for table `category`
--

DROP TABLE IF EXISTS `category`;
/*!40101 SET @saved_cs_client     = @@character_set_client */;
/*!40101 SET character_set_client = utf8 */;
CREATE TABLE `category` (
  `id` int(11) unsigned NOT NULL AUTO_INCREMENT,
  `name` varchar(200) CHARACTER SET utf8 NOT NULL,
  `description` varchar(255) COLLATE utf8_unicode_ci NOT NULL,
  `created_by` int(11) DEFAULT NULL,
  `created_at` timestamp NULL DEFAULT CURRENT_TIMESTAMP,
  `updated_by` int(11) DEFAULT NULL,
  `updated_at` timestamp NULL DEFAULT NULL ON UPDATE CURRENT_TIMESTAMP,
  `deleted_by` int(11) DEFAULT NULL,
  `deleted_at` datetime DEFAULT NULL,
  `is_deleted` tinyint(1) DEFAULT '0',
  PRIMARY KEY (`id`),
  KEY `name` (`name`)
) ENGINE=MyISAM AUTO_INCREMENT=3 DEFAULT CHARSET=utf8 COLLATE=utf8_unicode_ci;
/*!40101 SET character_set_client = @saved_cs_client */;

--
-- Dumping data for table `category`
--

LOCK TABLES `category` WRITE;
/*!40000 ALTER TABLE `category` DISABLE KEYS */;
INSERT INTO `category` VALUES (1,'مقالات','مقالات متنوعة',1,'2018-02-16 13:53:02',NULL,NULL,NULL,NULL,0),(2,'أخبار','أخبار متنوعة',1,'2018-02-16 13:53:17',NULL,NULL,NULL,NULL,0);
/*!40000 ALTER TABLE `category` ENABLE KEYS */;
UNLOCK TABLES;

--
-- Table structure for table `images`
--

DROP TABLE IF EXISTS `images`;
/*!40101 SET @saved_cs_client     = @@character_set_client */;
/*!40101 SET character_set_client = utf8 */;
CREATE TABLE `images` (
  `id` int(10) unsigned NOT NULL AUTO_INCREMENT,
  `file_name` varchar(300) CHARACTER SET utf8 NOT NULL,
  `model_id` int(11) NOT NULL,
  `model_name` varchar(100) NOT NULL,
  `tag` varchar(50) NOT NULL,
  `created_by` int(11) NOT NULL,
  `created_at` timestamp NOT NULL DEFAULT CURRENT_TIMESTAMP,
  `updated_by` int(11) DEFAULT NULL,
  `updated_at` timestamp NULL DEFAULT NULL ON UPDATE CURRENT_TIMESTAMP,
  `deleted_by` int(11) DEFAULT NULL,
  `deleted_at` datetime DEFAULT NULL,
  `is_deleted` tinyint(1) DEFAULT '0',
  PRIMARY KEY (`id`)
) ENGINE=MyISAM AUTO_INCREMENT=45 DEFAULT CHARSET=latin1;
/*!40101 SET character_set_client = @saved_cs_client */;

--
-- Dumping data for table `images`
--

LOCK TABLES `images` WRITE;
/*!40000 ALTER TABLE `images` DISABLE KEYS */;
INSERT INTO `images` VALUES (17,'435e8.jpg',67,'App\\Models\\Profile\\Profile','Personal',0,'2017-08-08 14:19:11',NULL,NULL,NULL,NULL,0),(18,'fa659.png',67,'App\\Models\\Profile\\Profile','Cover',0,'2017-08-08 14:19:11',NULL,NULL,NULL,NULL,0),(19,'953a4.gif',68,'App\\Models\\Profile\\Profile','Personal',0,'2017-08-08 14:22:51',NULL,NULL,NULL,NULL,0),(20,'67ca9.jpg',68,'App\\Models\\Profile\\Profile','Cover',0,'2017-08-08 14:22:51',NULL,NULL,NULL,NULL,0),(21,'5dea6.gif',1,'App\\Models\\Profile\\Profile','Personal',0,'2017-08-08 14:28:07',NULL,NULL,NULL,NULL,0),(22,'44327.jpg',1,'App\\Models\\Profile\\Profile','Cover',0,'2017-08-08 14:28:07',NULL,NULL,NULL,NULL,0),(23,'e38eb.jpg',3,'App\\Models\\Profile\\Profile','Personal',0,'2017-08-15 03:21:44',NULL,NULL,NULL,NULL,0),(24,'b9a30.jpg',3,'App\\Models\\Profile\\Profile','Cover',0,'2017-08-15 03:21:44',NULL,NULL,NULL,NULL,0),(25,'dd70a.png',29,'App\\Models\\Profile\\Profile','Personal',0,'2017-08-27 08:29:56',NULL,NULL,NULL,NULL,0),(26,'0c099.jpg',29,'App\\Models\\Profile\\Profile','Cover',0,'2017-08-27 08:29:56',NULL,NULL,NULL,NULL,0),(27,'10f43.jpg',30,'App\\Models\\Profile\\Profile','Personal',0,'2017-08-27 11:07:07',1,'2017-08-29 05:38:48',NULL,NULL,0),(28,'b5d26.jpg',30,'App\\Models\\Profile\\Profile','Cover',0,'2017-08-27 11:07:07',NULL,NULL,NULL,NULL,0),(29,'2cb87.jpg',44,'App\\Models\\Profile\\Profile','Personal',0,'2017-08-30 07:39:18',NULL,NULL,NULL,NULL,0),(30,'d5b70.jpg',44,'App\\Models\\Profile\\Profile','Cover',0,'2017-08-30 07:39:18',NULL,NULL,NULL,NULL,0),(31,'f6a1b.jpg',45,'App\\Models\\Profile\\Profile','Personal',0,'2017-08-30 07:41:49',NULL,NULL,NULL,NULL,0),(32,'42016.jpg',45,'App\\Models\\Profile\\Profile','Cover',0,'2017-08-30 07:41:49',NULL,NULL,NULL,NULL,0),(33,'68ad2.jpg',46,'App\\Models\\Profile\\Profile','Personal',0,'2017-09-24 11:17:30',NULL,NULL,NULL,NULL,0),(34,'ee122.jpg',46,'App\\Models\\Profile\\Profile','Cover',0,'2017-09-24 11:17:30',NULL,NULL,NULL,NULL,0),(35,'c66e0.jpg',47,'App\\Models\\Profile\\Profile','Personal',0,'2017-09-26 08:33:03',NULL,NULL,NULL,NULL,0),(36,'f5ce4.jpg',47,'App\\Models\\Profile\\Profile','Cover',0,'2017-09-26 08:33:03',NULL,NULL,NULL,NULL,0),(37,'99b0d.png',50,'App\\Models\\Profile\\Profile','Personal',0,'2017-10-01 09:07:53',NULL,NULL,NULL,NULL,0),(38,'bdca5.png',50,'App\\Models\\Profile\\Profile','Cover',0,'2017-10-01 09:07:53',NULL,NULL,NULL,NULL,0),(39,'425de.png',51,'App\\Models\\Profile\\Profile','Personal',0,'2017-10-01 09:40:47',NULL,NULL,NULL,NULL,0),(40,'9f24d.png',51,'App\\Models\\Profile\\Profile','Cover',0,'2017-10-01 09:40:48',NULL,NULL,NULL,NULL,0),(41,'af249.jpg',57,'App\\Models\\Profile\\Profile','Personal',0,'2017-10-24 16:15:13',NULL,NULL,NULL,NULL,0),(42,'b8f63.jpg',57,'App\\Models\\Profile\\Profile','Cover',0,'2017-10-24 16:15:13',NULL,NULL,NULL,NULL,0),(43,'f779a.jpg',0,'App\\Models\\Profile\\Profile','Personal',0,'2017-11-12 10:39:37',NULL,NULL,NULL,NULL,0),(44,'ed38b.jpg',0,'App\\Models\\Profile\\Profile','Personal',0,'2017-11-12 10:42:49',NULL,NULL,NULL,NULL,0);
/*!40000 ALTER TABLE `images` ENABLE KEYS */;
UNLOCK TABLES;

--
-- Table structure for table `languages`
--

DROP TABLE IF EXISTS `languages`;
/*!40101 SET @saved_cs_client     = @@character_set_client */;
/*!40101 SET character_set_client = utf8 */;
CREATE TABLE `languages` (
  `shortcut` varchar(3) COLLATE utf8_unicode_ci NOT NULL,
  `name` varchar(50) COLLATE utf8_unicode_ci NOT NULL,
  PRIMARY KEY (`shortcut`)
) ENGINE=MyISAM DEFAULT CHARSET=utf8 COLLATE=utf8_unicode_ci;
/*!40101 SET character_set_client = @saved_cs_client */;

--
-- Dumping data for table `languages`
--

LOCK TABLES `languages` WRITE;
/*!40000 ALTER TABLE `languages` DISABLE KEYS */;
INSERT INTO `languages` VALUES ('en','English'),('ar','عربي');
/*!40000 ALTER TABLE `languages` ENABLE KEYS */;
UNLOCK TABLES;

--
-- Table structure for table `posts`
--

DROP TABLE IF EXISTS `posts`;
/*!40101 SET @saved_cs_client     = @@character_set_client */;
/*!40101 SET character_set_client = utf8 */;
CREATE TABLE `posts` (
  `id` int(11) unsigned NOT NULL AUTO_INCREMENT,
  `title` varchar(200) CHARACTER SET utf8 NOT NULL,
  `description` varchar(255) COLLATE utf8_unicode_ci NOT NULL,
  `body` longtext CHARACTER SET utf8 NOT NULL,
  `category_id` int(8) DEFAULT NULL,
  `created_by` int(11) DEFAULT NULL,
  `created_at` timestamp NULL DEFAULT CURRENT_TIMESTAMP,
  `updated_by` int(11) DEFAULT NULL,
  `updated_at` timestamp NULL DEFAULT NULL ON UPDATE CURRENT_TIMESTAMP,
  `deleted_by` int(11) DEFAULT NULL,
  `deleted_at` datetime DEFAULT NULL,
  `is_deleted` tinyint(1) DEFAULT '0',
  PRIMARY KEY (`id`),
  KEY `title` (`title`),
  KEY `category_id` (`category_id`)
) ENGINE=MyISAM AUTO_INCREMENT=2 DEFAULT CHARSET=utf8 COLLATE=utf8_unicode_ci;
/*!40101 SET character_set_client = @saved_cs_client */;

--
-- Dumping data for table `posts`
--

LOCK TABLES `posts` WRITE;
/*!40000 ALTER TABLE `posts` DISABLE KEYS */;
INSERT INTO `posts` VALUES (1,'New Post','Test New Post','asda asd asd asd asda\r\nsd\r\nas\r\ndasfasdfg\r\nsdfsdf\r\n<img src=\"http://thawrastory.com/wp-content/uploads/2016/07/mobile-300x212.jpg\" />',1,1,'2018-02-16 13:16:11',1,'2018-02-16 13:53:42',1,'2018-02-16 13:16:14',0);
/*!40000 ALTER TABLE `posts` ENABLE KEYS */;
UNLOCK TABLES;

--
-- Table structure for table `sec_accessright`
--

DROP TABLE IF EXISTS `sec_accessright`;
/*!40101 SET @saved_cs_client     = @@character_set_client */;
/*!40101 SET character_set_client = utf8 */;
CREATE TABLE `sec_accessright` (
  `id` int(8) unsigned NOT NULL AUTO_INCREMENT,
  `groupid` int(8) NOT NULL,
  `model_name` varchar(50) NOT NULL,
  `accesstype` enum('view','add','edit','delete') NOT NULL,
  `filter` varchar(255) CHARACTER SET utf8 DEFAULT NULL,
  `created_by` int(11) NOT NULL,
  `created_at` timestamp NOT NULL DEFAULT CURRENT_TIMESTAMP,
  `updated_by` int(11) DEFAULT NULL,
  `updated_at` timestamp NULL DEFAULT NULL ON UPDATE CURRENT_TIMESTAMP,
  PRIMARY KEY (`id`),
  KEY `accesstype` (`accesstype`),
  KEY `model` (`model_name`)
) ENGINE=MyISAM AUTO_INCREMENT=271 DEFAULT CHARSET=latin1;
/*!40101 SET character_set_client = @saved_cs_client */;

--
-- Dumping data for table `sec_accessright`
--

LOCK TABLES `sec_accessright` WRITE;
/*!40000 ALTER TABLE `sec_accessright` DISABLE KEYS */;
INSERT INTO `sec_accessright` VALUES (213,1,'App\\*','view','',0,'2017-07-15 11:50:32',7,'2017-08-08 14:48:13'),(222,1,'App\\*','delete','',0,'2017-07-15 15:53:30',7,'2017-08-08 14:48:18'),(221,1,'App\\*','edit','',0,'2017-07-15 15:53:20',NULL,'2017-08-08 14:48:21'),(220,1,'App\\*','add','',0,'2017-07-15 15:53:07',NULL,'2017-08-08 14:48:24'),(224,8,'App\\Models\\Lookup\\TeamsReg','view','[[\'LeaderId\',USER_ACCID_ID]]',1,'2017-08-12 15:59:41',1,'2017-09-26 14:33:30'),(225,8,'App\\Models\\Lookup\\TeamsReg','add','',1,'2017-08-17 03:16:14',NULL,NULL),(226,8,'App\\Models\\Lookup\\*','view','',1,'2017-08-17 05:08:53',NULL,NULL),(227,8,'App\\Models\\Admin\\Teams','view','',1,'2017-08-17 05:16:21',NULL,NULL),(228,8,'App\\Models\\Profile\\Profile','add','',1,'2017-08-17 05:22:14',NULL,NULL),(229,8,'App\\Models\\Profile\\*','add','',1,'2017-08-17 05:23:04',NULL,NULL),(230,8,'App\\Models\\Admin\\RegisteryUserLog','add','',1,'2017-08-17 13:44:38',NULL,NULL),(231,8,'App\\Models\\Admin\\RegisteryUserLog','view','',1,'2017-08-17 13:45:23',NULL,NULL),(232,8,'App\\Models\\Admin\\Teams','add','',1,'2017-08-17 13:47:54',NULL,NULL),(233,8,'App\\Models\\Profile\\Profile','view','[[\'team_id\',USER_ACCID_TEAM_ID_ID]]',1,'2017-08-27 08:34:50',NULL,NULL),(234,6,'App\\Models\\Profile\\Profile','view','[[\'branch_id\',USER_ACCID_BRANCH_ID_ID]]',1,'2017-08-27 08:35:19',1,'2017-08-27 08:43:24'),(235,6,'App\\Models\\Lookup\\*','view','',1,'2017-08-27 08:50:03',NULL,NULL),(262,6,'App\\Models\\Lookup\\*','add','',1,'2017-08-27 09:39:35',NULL,NULL),(237,6,'App\\Models\\Lookup\\*','edit','',1,'2017-08-27 08:51:40',1,'2017-08-27 08:52:35'),(238,6,'App\\Models\\Lookup\\*','delete','',1,'2017-08-27 08:51:56',1,'2017-08-27 08:52:27'),(239,6,'App\\Models\\Admin\\Register','add','',1,'2017-08-27 08:54:04',NULL,NULL),(240,6,'App\\Models\\Admin\\RegisteryUserLog','view','',1,'2017-08-27 08:54:25',NULL,NULL),(241,6,'App\\Models\\Admin\\Register','edit','',1,'2017-08-27 08:55:06',NULL,NULL),(242,6,'App\\Models\\Admin\\Register','view','',1,'2017-08-27 08:56:04',NULL,NULL),(243,6,'App\\Models\\Admin\\RegisteryUserLog','edit','',1,'2017-08-27 08:57:03',NULL,NULL),(244,6,'App\\Models\\Admin\\RegisteryUserLog','add','',1,'2017-08-27 08:58:05',NULL,NULL),(245,6,'App\\Models\\Admin\\RegisteryUserLog','delete','',1,'2017-08-27 08:58:17',NULL,NULL),(246,6,'App\\Models\\Profile\\Comp','add','',1,'2017-08-27 09:02:40',NULL,NULL),(247,6,'App\\Models\\Profile\\Comp','edit','',1,'2017-08-27 09:03:32',NULL,NULL),(248,6,'App\\Models\\Profile\\Comp','delete','',1,'2017-08-27 09:03:49',NULL,NULL),(249,6,'App\\Models\\Profile\\Comp','view','',1,'2017-08-27 09:04:06',NULL,NULL),(250,6,'App\\Models\\Profile\\CompUserLog','add','',1,'2017-08-27 09:04:22',NULL,NULL),(251,6,'App\\Models\\Profile\\CompUserLog','edit','',1,'2017-08-27 09:04:36',NULL,NULL),(252,6,'App\\Models\\Profile\\CompUserLog','delete','',1,'2017-08-27 09:04:54',NULL,NULL),(253,6,'App\\Models\\Profile\\CompUserLog','view','',1,'2017-08-27 09:06:20',NULL,NULL),(263,6,'App\\Models\\Notify\\Waitinglist','view','',1,'2017-08-27 10:57:48',NULL,NULL),(264,6,'App\\Models\\Notify\\Waitinglist','add','',1,'2017-08-27 10:58:06',NULL,NULL),(265,6,'App\\Models\\Notify\\Waitinglist','edit','',1,'2017-08-27 10:58:21',NULL,NULL),(266,6,'App\\Models\\Notify\\Waitinglist','delete','',1,'2017-08-27 10:58:34',NULL,NULL),(267,6,'App\\Models\\Lookup\\TeamsReg','edit','',1,'2017-08-27 11:43:19',NULL,NULL),(268,6,'App\\Models\\Admin\\Teams','edit','',1,'2017-08-27 11:43:41',NULL,NULL),(269,6,'App\\Models\\Profile\\*','edit','',1,'2017-08-27 11:45:50',NULL,NULL),(270,1,'App\\Models\\Lookup\\TeamsReg','view','',1,'2017-09-26 14:34:28',1,'2017-09-26 14:35:16');
/*!40000 ALTER TABLE `sec_accessright` ENABLE KEYS */;
UNLOCK TABLES;

--
-- Table structure for table `sec_group`
--

DROP TABLE IF EXISTS `sec_group`;
/*!40101 SET @saved_cs_client     = @@character_set_client */;
/*!40101 SET character_set_client = utf8 */;
CREATE TABLE `sec_group` (
  `id` int(8) unsigned NOT NULL AUTO_INCREMENT,
  `name` varchar(100) CHARACTER SET utf8 COLLATE utf8_unicode_ci NOT NULL,
  `groupkey` varchar(50) CHARACTER SET utf8 COLLATE utf8_unicode_ci NOT NULL,
  `categoryid` int(8) NOT NULL,
  `description` varchar(255) NOT NULL,
  `created_by` int(11) NOT NULL,
  `created_at` timestamp NOT NULL DEFAULT CURRENT_TIMESTAMP,
  `updated_by` int(11) DEFAULT NULL,
  `updated_at` timestamp NULL DEFAULT NULL ON UPDATE CURRENT_TIMESTAMP,
  PRIMARY KEY (`id`),
  UNIQUE KEY `key` (`groupkey`)
) ENGINE=MyISAM AUTO_INCREMENT=9 DEFAULT CHARSET=latin1;
/*!40101 SET character_set_client = @saved_cs_client */;

--
-- Dumping data for table `sec_group`
--

LOCK TABLES `sec_group` WRITE;
/*!40000 ALTER TABLE `sec_group` DISABLE KEYS */;
INSERT INTO `sec_group` VALUES (1,'Admin','sys_admin',1,'System Administrator',0,'2017-07-14 12:48:42',1,'2017-08-08 15:17:21'),(4,'Country Admin','country_admin',1,'Administrtors of country scout',1,'2017-08-08 14:53:13',1,'2017-08-08 15:12:27'),(5,'Organization Admin','org_admin',1,'Administrators of organizations in scout',1,'2017-08-08 14:54:14',1,'2017-08-08 15:12:33'),(6,'Branch Admin','branch_admin',1,'Administrators of branches in scout',1,'2017-08-08 14:55:13',1,'2017-08-08 15:12:39'),(7,'Office Admin','office_admin',1,'Administrators of office in scout',1,'2017-08-08 14:55:59',1,'2017-08-08 15:12:44'),(8,'Team Admin','team_admin',1,'Administrators of team inside office in scout',1,'2017-08-08 15:13:52',NULL,NULL);
/*!40000 ALTER TABLE `sec_group` ENABLE KEYS */;
UNLOCK TABLES;

--
-- Table structure for table `sec_group_category`
--

DROP TABLE IF EXISTS `sec_group_category`;
/*!40101 SET @saved_cs_client     = @@character_set_client */;
/*!40101 SET character_set_client = utf8 */;
CREATE TABLE `sec_group_category` (
  `id` int(8) unsigned NOT NULL AUTO_INCREMENT,
  `name` varchar(100) NOT NULL,
  `created_by` int(11) NOT NULL,
  `created_at` timestamp NOT NULL DEFAULT CURRENT_TIMESTAMP,
  `updated_by` int(11) DEFAULT NULL,
  `updated_at` timestamp NULL DEFAULT NULL ON UPDATE CURRENT_TIMESTAMP,
  PRIMARY KEY (`id`)
) ENGINE=MyISAM AUTO_INCREMENT=5 DEFAULT CHARSET=latin1;
/*!40101 SET character_set_client = @saved_cs_client */;

--
-- Dumping data for table `sec_group_category`
--

LOCK TABLES `sec_group_category` WRITE;
/*!40000 ALTER TABLE `sec_group_category` DISABLE KEYS */;
INSERT INTO `sec_group_category` VALUES (1,'Accounting',0,'2017-07-14 12:48:42',7,'2017-08-08 06:17:51'),(2,'Events',0,'2017-07-14 12:48:42',NULL,NULL),(3,'Articles',0,'2017-07-14 12:48:42',NULL,NULL),(4,'Finance',0,'2017-07-14 12:48:42',NULL,NULL);
/*!40000 ALTER TABLE `sec_group_category` ENABLE KEYS */;
UNLOCK TABLES;

--
-- Table structure for table `sec_user_group_rel`
--

DROP TABLE IF EXISTS `sec_user_group_rel`;
/*!40101 SET @saved_cs_client     = @@character_set_client */;
/*!40101 SET character_set_client = utf8 */;
CREATE TABLE `sec_user_group_rel` (
  `id` int(8) unsigned NOT NULL AUTO_INCREMENT,
  `userid` int(8) NOT NULL,
  `groupid` int(8) NOT NULL,
  `created_by` int(11) NOT NULL,
  `created_at` timestamp NOT NULL DEFAULT CURRENT_TIMESTAMP,
  `updated_by` int(11) DEFAULT NULL,
  `updated_at` timestamp NULL DEFAULT NULL ON UPDATE CURRENT_TIMESTAMP,
  PRIMARY KEY (`id`)
) ENGINE=MyISAM AUTO_INCREMENT=16 DEFAULT CHARSET=latin1;
/*!40101 SET character_set_client = @saved_cs_client */;

--
-- Dumping data for table `sec_user_group_rel`
--

LOCK TABLES `sec_user_group_rel` WRITE;
/*!40000 ALTER TABLE `sec_user_group_rel` DISABLE KEYS */;
INSERT INTO `sec_user_group_rel` VALUES (1,1,1,0,'2017-08-08 14:47:40',NULL,NULL),(4,2,8,1,'2017-08-20 04:31:39',NULL,NULL),(8,29,6,1,'2017-08-27 11:12:20',1,'2017-08-27 11:40:51'),(6,28,6,1,'2017-08-27 08:31:18',NULL,NULL),(9,43,8,1,'2017-08-30 07:43:46',NULL,NULL),(10,44,6,1,'2017-08-30 07:43:48',NULL,NULL),(11,45,8,29,'2017-09-24 11:28:13',NULL,NULL),(12,46,6,29,'2017-10-01 09:23:51',NULL,NULL),(13,47,8,29,'2017-10-01 09:27:23',NULL,NULL),(14,48,8,1,'2017-10-02 04:00:27',NULL,NULL),(15,50,8,1,'2017-10-03 11:16:42',NULL,NULL);
/*!40000 ALTER TABLE `sec_user_group_rel` ENABLE KEYS */;
UNLOCK TABLES;

--
-- Table structure for table `setting`
--

DROP TABLE IF EXISTS `setting`;
/*!40101 SET @saved_cs_client     = @@character_set_client */;
/*!40101 SET character_set_client = utf8 */;
CREATE TABLE `setting` (
  `id` int(4) unsigned NOT NULL AUTO_INCREMENT,
  `name` varchar(200) NOT NULL,
  `hint` varchar(200) NOT NULL,
  `setting_key` varchar(50) NOT NULL,
  `value` text,
  `type` int(4) NOT NULL DEFAULT '1',
  `availables` varchar(255) DEFAULT NULL,
  `lang` varchar(4) NOT NULL DEFAULT '*',
  `setting_group` varchar(100) NOT NULL DEFAULT 'General Setting',
  PRIMARY KEY (`id`),
  KEY `lang` (`lang`),
  KEY `setting_group` (`setting_group`)
) ENGINE=MyISAM AUTO_INCREMENT=80 DEFAULT CHARSET=utf8;
/*!40101 SET character_set_client = @saved_cs_client */;

--
-- Dumping data for table `setting`
--

LOCK TABLES `setting` WRITE;
/*!40000 ALTER TABLE `setting` DISABLE KEYS */;
INSERT INTO `setting` VALUES (1,'Site name','Title of your website','site_name','Cairo Sea Scout',1,'','en','General'),(2,'إسم الموقع','Title of your website','site_name','الكشافة المصرية',1,'','ar','General'),(3,'Default email البريد الإلفتراضي ','Website email you can use any place','emails_default','info@arabscout.net',1,'','*','General'),(4,'No-replay email بريد الإشعارات','This email for message you not follow up it\'s response ','emails_noreplay','no-replay@arabscout.net',1,'','*','General'),(5,'About Us','about_us','about_us','',8,'','en','General'),(77,'Notes','Notes','site_notes','',1,'','en','General'),(78,'نبذة عن الموقع','نبذة عن الموقع','site_notes','',8,'','ar','General'),(73,'العنوان','العنوان','site_address','',1,'','ar','General'),(7,'Max count in home','','max_home','6',1,'','*','Posts'),(8,'Max count on load more','','max_loadmore','6',1,'','*','Posts'),(10,'Max post length','','max_length','200',1,'','*','Posts'),(11,'Allow new comment','','allow_new_comment','Yes',3,'','*','Posts'),(12,'Allow Like','','allow_like','Yes',3,'','*','Posts'),(13,'Allow share','','allow_share','Yes',3,'','*','Posts'),(14,'Max comment length','','max_comment_length','200',1,'','*','Posts'),(15,'Max comments load','','max_comments_load','2',1,'','*','Posts'),(16,'Max comments loadmore','',' max_comments_loadmore','2',1,'','*','Posts'),(17,'Max image size (KB)','','max_image_size','100',1,'','*','Events'),(18,'Max count in home','','max_home','9',1,'','*','Events'),(19,'Max count on load more','','max_loadmore','9',1,'','*','Events'),(20,'Max post length','','max_length','200',1,'','*','Events'),(21,'Allow new comment','','allow_new_comment','Yes',3,'','*','Events'),(22,'Allow register','','allow_like','Yes',3,'','*','Events'),(23,'Allow share','','allow_share','Yes',3,'','*','Events'),(24,'Max comment length','','max_comment_length','200',1,'','*','Events'),(25,'Max comments load','','max_comments_load','6',1,'','*','Events'),(26,'Max comments loadmore','','max_comments_loadmore','6',1,'','*','Events'),(27,'Using editor','','editor','No',3,'','*','Events'),(28,'Comment required approve','','comment_approve','No',3,'','*','Posts'),(29,'Comment required approve','','comment_approve','No',3,'','*','Events'),(30,'Max image size (KB)','','max_image_size','100',1,'','*','Articles'),(31,'Max count in home','','max_home','9',1,'','*','Articles'),(32,'Max count on load more','','max_loadmore','9',1,'','*','Articles'),(33,'Max post length','','max_length','200',1,'','*','Articles'),(34,'Allow new comment','','allow_new_comment','Yes',3,'','*','Articles'),(35,'Allow register','','allow_like','Yes',3,'','*','Articles'),(36,'Allow share','','allow_share','Yes',3,'','*','Articles'),(37,'Max comment length','','max_comment_length','200',1,'','*','Articles'),(38,'Max comments load','','max_comments_load','6',1,'','*','Articles'),(39,'Max comments loadmore','','max_comments_loadmore','6',1,'','*','Articles'),(40,'Using editor','','editor','No',3,'','*','Events'),(41,'Comment required approve','','comment_approve','No',3,'','*','Articles'),(42,'Default language لغة الموقع','','site_lang','ar',4,'{shortcut as id ,name from languages}','*','General'),(43,'Allow write post','','allow_write_post','Yes',3,'','*','Profile'),(44,'Allow write event','','allow_write_event','No',3,'','*','Profile'),(45,'Allow write article','','allow_write_article','No',3,'','*','Profile'),(46,'Allow write comment','','allow_write_comment','Yes',3,'','*','Profile'),(47,'Using editor','','editor','No',3,'','*','Posts'),(48,'Using editor','','editor','Yes',3,'','*','Articles'),(49,'Allow follow','','allow_follow','No',3,'','*','Profile'),(50,'Can followed','','can_followed','No',3,'','*','Profile'),(51,'Allow write post','','allow_write_post','Yes',3,'','*','Activity'),(52,'Allow write event','','allow_write_event','Yes',3,'','*','Activity'),(53,'Allow write article','','allow_write_article','No',3,'','*','Activity'),(54,'Allow write comment','','allow_write_comment','Yes',3,'','*','Activity'),(55,'Allow follow','','allow_follow','No',3,'','*','Activity'),(56,'Can followed','','can_followed','No',3,'','*','Activity'),(57,'Activation periods (Day)','','activiation_period','10',1,'','*','Profile'),(58,'On expired','','expired_action','Suspense Account',4,'{1 as id,\'No Action\' as name union all select 2 as id,\'Suspense Account\' as name union all select 3 as id,\'Denied Post, event and article\' as name}','*','Profile'),(59,'Activation periods (Day)','','activiation_period','10',1,'','*','Activity'),(60,'On expired','','expired_action','Suspense Account',4,'{1 as id,\'No Action\' as name union all select 2 as id,\'Suspense Account\' as name union all select 3 as id,\'Denied Post, event and article\' as name}','*','Activity'),(61,'Site Description','Description of your website','site_desc','',1,'','en','General'),(74,'Address','Address','site_address','',1,'','en','General'),(75,'phone','phone','site_phone','0580816665',1,'','*','General'),(76,'Fax','Fax','site_fax','0542725883',1,'','*','General'),(62,'وصف الموقع','Description of your website','site_desc','',1,'','ar','General'),(68,'Facebook فيسبوك','facebook','facebook','//www.facebook.com',1,'','*','General'),(69,'Twitter تويتر','twitter','twitter','//www.twitter.com',1,'','*','General'),(70,'Youtube يوتيوب','youtube','youtube','//www.youtube.com',1,'','*','General'),(71,'Instagram انستجرام','Instagram','instagram','//www.instegram.com',1,'','*','General'),(63,'Site Keaywords','Keaywords of your website','site_key','',1,'','en','General'),(64,'الكلمات الدلالية','Keywords of your website','site_key','',1,'','ar','General'),(65,'Site Image لوجو الموقع','Image of your website','site_image','',1,'','*','General'),(79,'API Link','API Link','sms_api_link','http://smssmartegypt.com/sms/api/?username=Mahmoudgomaa&password=Yosef1590&sendername=cairo%20scout&message={msg}&mobiles={mobiles}',1,'','*','SMS');
/*!40000 ALTER TABLE `setting` ENABLE KEYS */;
UNLOCK TABLES;

--
-- Table structure for table `users`
--

DROP TABLE IF EXISTS `users`;
/*!40101 SET @saved_cs_client     = @@character_set_client */;
/*!40101 SET character_set_client = utf8 */;
CREATE TABLE `users` (
  `id` int(10) unsigned NOT NULL AUTO_INCREMENT,
  `name` varchar(255) NOT NULL,
  `email` varchar(255) NOT NULL,
  `password` varchar(60) NOT NULL,
  `remember_token` varchar(100) DEFAULT NULL,
  `phone` varchar(20) DEFAULT NULL,
  `accid` int(8) NOT NULL,
  `token` varchar(100) NOT NULL,
  `api_token` varchar(100) DEFAULT NULL,
  `created_by` int(11) NOT NULL,
  `created_at` timestamp NOT NULL DEFAULT CURRENT_TIMESTAMP,
  `updated_by` int(11) DEFAULT NULL,
  `updated_at` timestamp NULL DEFAULT NULL ON UPDATE CURRENT_TIMESTAMP,
  `deleted_by` int(11) DEFAULT NULL,
  `deleted_at` datetime DEFAULT NULL,
  `is_deleted` tinyint(1) DEFAULT '0',
  PRIMARY KEY (`id`),
  UNIQUE KEY `email` (`email`),
  KEY `token` (`token`)
) ENGINE=MyISAM AUTO_INCREMENT=52 DEFAULT CHARSET=latin1;
/*!40101 SET character_set_client = @saved_cs_client */;

--
-- Dumping data for table `users`
--

LOCK TABLES `users` WRITE;
/*!40000 ALTER TABLE `users` DISABLE KEYS */;
INSERT INTO `users` VALUES (1,'Admin','info@arabscout.net','db8134a0a4a486caf791320bedee266e',NULL,NULL,1,'0ffdcdea-7c46-11e7-beee-0025902a8534',NULL,0,'2017-08-08 14:30:01',NULL,'2017-08-27 07:53:08',NULL,NULL,0),(2,'ahmed abdalah mohamed','ahmedscout','25f9e794323b453885f5181f1b624d0b',NULL,NULL,3,'33A825BF-872B-96DB-F4EA-E98A4F0DC40E',NULL,1,'2017-08-15 03:23:12',NULL,'2017-08-19 12:20:52',NULL,NULL,0),(22,'Profile 8 Second Name ','234','d763671fb0c1a93f301fe8ec1c0c499b',NULL,'',24,'0C82E3D4-6F6D-A4BB-B071-19DD91D9B950',NULL,1,'2017-08-18 10:14:30',NULL,NULL,NULL,NULL,0),(21,'Profile 7 Second Name ','1234567890','07f8941a7bc63b05577ac264b08dad4b',NULL,'',23,'21D5D3D8-9B18-080F-F050-7B9BDA65FBA2',NULL,1,'2017-08-18 10:14:29',NULL,NULL,NULL,NULL,0),(20,'Profile 6 Second Name ','123456789','2c29c221886d01a3f19e3affecf22249',NULL,'',22,'AA7198A0-3841-6879-C218-703515882E8F',NULL,1,'2017-08-18 10:14:29',NULL,NULL,NULL,NULL,0),(19,'Profile 5 Second Name ','12345678','754ee1cffefd697ebe5608fb240e54e6',NULL,'',21,'8A507185-3EF1-8702-985C-1A1BA7B49C04',NULL,1,'2017-08-18 10:14:29',NULL,NULL,NULL,NULL,0),(18,'Profile 4 Second Name ','1234567','1b39e6e9528fd166e6ebd2ba526483e6',NULL,'',20,'6A39ED15-48C5-1B95-FF63-CA043B3233A4',NULL,1,'2017-08-18 10:14:29',NULL,NULL,NULL,NULL,0),(17,'Profile 3 Second Name ','123456','b5cc21c868426c9d8a99b0fe62d4f189',NULL,'',19,'313978FA-733C-FCDA-B68F-F13E85F5CC08',NULL,1,'2017-08-18 10:14:29',NULL,NULL,NULL,NULL,0),(16,'Profile 2 Second Name ','12345','8c4aef1a98cd98da27834cc4bbf8f89f',NULL,'',18,'41DAECB5-BC9D-E52D-C30C-87A98C80A1FE',NULL,1,'2017-08-18 10:14:29',NULL,NULL,NULL,NULL,0),(15,'Profile 1 Second Name ','1234','a5a1e6c8997b54ac70f5a4e3ce8e5ce2',NULL,'',17,'02A570A1-46F4-5DD4-B8A7-C3E2F909248B',NULL,1,'2017-08-18 10:14:29',NULL,'2017-08-19 12:21:56',NULL,NULL,0),(23,'Profile 9 Second Name ','2345','8c4aef1a98cd98da27834cc4bbf8f89f',NULL,'',25,'DCD17192-9102-9A6A-3EBF-8BC34618BCA6',NULL,1,'2017-08-18 10:14:30',NULL,NULL,NULL,NULL,0),(24,'Profile 10 Second Name ','23456','b5cc21c868426c9d8a99b0fe62d4f189',NULL,'',26,'7F21537D-2540-71F0-3B05-D12ADE8F5652',NULL,1,'2017-08-18 10:14:30',NULL,NULL,NULL,NULL,0),(25,'Profile 11 Second Name ','234567','1b39e6e9528fd166e6ebd2ba526483e6',NULL,'',27,'4351D55B-91C3-3763-43CD-8C52E82E7B2E',NULL,1,'2017-08-18 10:14:30',NULL,NULL,NULL,NULL,0),(26,'Profile 12 Second Name ','2345678','754ee1cffefd697ebe5608fb240e54e6',NULL,'',28,'7992023F-4E1D-3670-A833-203FE49571B0',NULL,1,'2017-08-18 10:14:30',NULL,NULL,NULL,NULL,0),(27,'Leader Second Name ','123','6e73f13e0bd7ed238e35f637fff21540',NULL,'',2,'9F244790-B0C4-98F3-495E-1FDFFB020876',NULL,1,'2017-08-20 01:39:17',NULL,NULL,NULL,NULL,0),(28,'Cairo Branch Admin','987654321','cbe39b05ecc61b152fef49111cfe89bb',NULL,'',29,'7586DB42-51D8-BD93-69C1-00954984101D',NULL,1,'2017-08-27 08:30:24',NULL,NULL,NULL,NULL,0),(29,'Eman Rizk Bostan','27310150102817','bd60e3125f054b6bcc6fa844740acb57',NULL,'',30,'367E4E4E-C434-4766-C4F8-7B7E4EFDC9F5',NULL,1,'2017-08-27 11:07:53',NULL,NULL,NULL,NULL,0),(30,'Mohamed Eli Selman','30310150102817','bd60e3125f054b6bcc6fa844740acb57',NULL,'',31,'FD352D63-A35E-59D3-0D24-F37A11685138',NULL,29,'2017-08-27 11:46:02',NULL,NULL,NULL,NULL,0),(31,'Mohamed Husssein Mansy','31310150102817','bd60e3125f054b6bcc6fa844740acb57',NULL,'',32,'60FC1E19-DCF1-F851-3626-E7CC6021CC98',NULL,29,'2017-08-27 11:46:02',NULL,NULL,NULL,NULL,0),(32,'Mohamed Eli Mansy','31310150102017','eba69765a90ec703921d54bc72679a0b',NULL,'',33,'58B967BA-6F6C-A43A-2284-8E9CBF190D03',NULL,29,'2017-08-27 11:46:02',NULL,NULL,NULL,NULL,0),(33,'Mohamed Husssein Mansy','31310050102017','eba69765a90ec703921d54bc72679a0b',NULL,'',35,'E25B1AC9-A3E6-3E8A-2DE3-480A66C54ED8',NULL,29,'2017-08-27 11:46:02',NULL,NULL,NULL,NULL,0),(34,'Mohamed Husssein Selman','31310050502017','eba69765a90ec703921d54bc72679a0b',NULL,'',36,'8FE5349C-6201-070F-6BEF-54582C83436D',NULL,29,'2017-08-27 11:46:02',NULL,NULL,NULL,NULL,0),(35,'Mohamed Eli Mansy','31310550502017','eba69765a90ec703921d54bc72679a0b',NULL,'',37,'72B2139E-F9F6-12E4-096D-19A739C520DF',NULL,29,'2017-08-27 11:46:02',NULL,NULL,NULL,NULL,0),(36,'Mohamed Husssein Mansy','31310050502117','2c3871d3d26b94e7bf7fc670d9e507e2',NULL,'',38,'DB6C1DDA-7256-2C1D-AFD9-F9927D3050DC',NULL,29,'2017-08-27 11:46:02',NULL,NULL,NULL,NULL,0),(37,'Mohamed Husssein Selman','31310050502018','fb57515f9b2a65cd45871ccc23c47ec2',NULL,'',39,'3C388559-8745-D708-24EE-030530C101AC',NULL,29,'2017-08-27 11:46:03',NULL,NULL,NULL,NULL,0),(38,'Mohamed Eli Mansy','31310050502019','9c9eda83c7b63e1c43b69abd09a45546',NULL,'',40,'94E12385-6251-E323-8F71-A93BD3D4F911',NULL,29,'2017-08-27 11:46:03',NULL,NULL,NULL,NULL,0),(39,'Mohamed Eli Selman','31310050502020','eea9f018acf33b036b2109d1bd98013d',NULL,'',41,'9FD8FE4F-E7D7-36A2-A87D-94111BF7EDAE',NULL,29,'2017-08-27 11:46:03',NULL,NULL,NULL,NULL,0),(40,'Mohamed Eli Mansy','31310050502015','b7f781b45389c070840bc0aaa7701472',NULL,'',42,'5001C793-DCBE-C270-877E-3838FBC10417',NULL,29,'2017-08-27 11:46:03',NULL,NULL,NULL,NULL,0),(41,'Mohamed Eli Selman','31310050502014','878b92cb033c15cbc64017889be88caf',NULL,'',43,'49AE5277-F326-19A6-2284-8F41CD5B1E3F',NULL,29,'2017-08-27 11:46:03',NULL,NULL,NULL,NULL,0),(42,'Mohamed Husssein Selman','27310155102817','bd60e3125f054b6bcc6fa844740acb57',NULL,'',34,'180C06AB-741E-5AE7-C7D7-694FA9B5EC06',NULL,29,'2017-08-27 11:46:29',NULL,NULL,NULL,NULL,0),(43,'Mahmoud Medhat Mahmoud','29607010105715','b0d8ea8ec9a2b952fccda30498ba307b',NULL,'',44,'D8396A65-A396-CBF1-39F7-39F7969C90BE',NULL,1,'2017-08-30 07:43:36',NULL,NULL,NULL,NULL,0),(44,'Ahmed Shams El-Din Mohamed','2333','d244692deca62dba567087df8f0b5436',NULL,'',45,'AC076A79-D620-4D48-F596-05FBEF8D9E4F',NULL,1,'2017-08-30 07:43:42',NULL,NULL,NULL,NULL,0),(45,'Mahmoud Ali Mohammed','31245678912','80bb18409ccf192cd150636d4dc9a576',NULL,'',46,'F03EF0C1-44B0-7555-CFF7-733DEC1432A7',NULL,29,'2017-09-24 11:28:00',NULL,NULL,NULL,NULL,0),(46,'Ali sharaf Sharaf','11111111111111','7b5b0d84045bf7467895c636ba8afe99',NULL,'',50,'1B140FCF-FB0D-5CB4-7251-5F0EFE1FD935','',29,'2017-10-01 09:14:54',NULL,NULL,NULL,NULL,0),(47,'eslam alaa sayed','29508130100999','7b6099fce0d582418c1e34e239fb2e43',NULL,'',47,'CCA205EE-EAB5-FBA6-7C1F-6BDE60FFB3E9','',29,'2017-10-01 09:27:14',NULL,NULL,NULL,NULL,0),(48,'one tow three','11111111111112','9dad184afdb84be2ccd6915b6e0558e6',NULL,'',51,'9CD7650C-C202-E643-AEE4-F4943FF76FB9','',29,'2017-10-01 09:46:45',NULL,NULL,NULL,NULL,0),(49,'Ahmed Fawzy  mohamed','321234423423243','873d8505f23c4d3ca978e2e23b66c95e','','',48,'17918CDD-BC44-D347-9445-E50987D51C5F','',29,'2017-10-01 09:47:53',NULL,'2018-02-16 08:58:39',NULL,NULL,0),(50,'Ahmed Fawzy  mohamed','3212121','32967c299559fd4ed51e208d6726f567','','',49,'38024F15-8061-A188-81D1-285DBDA0C2F4','',1,'2017-10-03 11:16:39',1,'2018-02-16 12:01:31',NULL,NULL,0),(51,'Test 123456','mahmoudg77@gmail.com','ISD@183927','123456789','123456',12,'1121223123123123132','546854987987',0,'2018-02-16 09:00:04',NULL,'2018-02-16 09:03:14',NULL,'2018-02-16 09:03:14',1);
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

-- Dump completed on 2018-02-17  5:33:53
