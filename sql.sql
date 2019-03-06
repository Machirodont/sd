-- MySQL dump 10.13  Distrib 8.0.12, for Win64 (x86_64)
--
-- Host: localhost    Database: yii
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
-- Table structure for table `sd_clinics`
--

DROP TABLE IF EXISTS `sd_clinics`;
/*!40101 SET @saved_cs_client     = @@character_set_client */;
 SET character_set_client = utf8mb4 ;
CREATE TABLE `sd_clinics` (
  `id` int(11) NOT NULL AUTO_INCREMENT,
  `city` text NOT NULL COMMENT 'город',
  `region` text COMMENT 'район',
  `address` text COMMENT 'адрес клиники',
  `phone` text COMMENT 'телефон клиники',
  `hash_id` text,
  PRIMARY KEY (`id`),
  UNIQUE KEY `hash_id` (`hash_id`(32))
) ENGINE=InnoDB AUTO_INCREMENT=10 DEFAULT CHARSET=utf8;
/*!40101 SET character_set_client = @saved_cs_client */;

--
-- Dumping data for table `sd_clinics`
--

LOCK TABLES `sd_clinics` WRITE;
/*!40000 ALTER TABLE `sd_clinics` DISABLE KEYS */;
INSERT INTO `sd_clinics` (`id`, `city`, `region`, `address`, `phone`, `hash_id`) VALUES (1,'Тучково',NULL,NULL,NULL,'f041c4c2da484ea0aa5b7cc8d91dc798'),(2,'Руза',NULL,NULL,NULL,'5cc8fea2ed2f483282c9fdd2a4a84341'),(3,'Сафоново',NULL,NULL,NULL,'19d6da22f59a4d82b8840fc95db5c4e7'),(4,'Стародуб',NULL,NULL,NULL,'41ddca448e2d45b9ac99d6bcb551161e'),(5,'Гагарин',NULL,NULL,NULL,'1722cf1e95a345fc8863dfe6a48ac0d3'),(6,'Клинцы',NULL,NULL,NULL,'3e68757c2faa460f8f0410d4fc90ce05'),(7,'Новозыбков',NULL,NULL,NULL,'76563309d6244354b748057237bda61f'),(8,'Почеп',NULL,NULL,NULL,'2a85465c0d8d4b9b928646f91fd7ace5'),(9,'Климово',NULL,NULL,NULL,'268334bbd12e417ebc3947a94a9d4ba4');
/*!40000 ALTER TABLE `sd_clinics` ENABLE KEYS */;
UNLOCK TABLES;

--
-- Table structure for table `sd_institutions`
--

DROP TABLE IF EXISTS `sd_institutions`;
/*!40101 SET @saved_cs_client     = @@character_set_client */;
 SET character_set_client = utf8mb4 ;
CREATE TABLE `sd_institutions` (
  `institution_id` int(11) NOT NULL AUTO_INCREMENT,
  `name` text COMMENT 'название заведения',
  `shortname` text COMMENT 'сокращенное название заведения',
  PRIMARY KEY (`institution_id`)
) ENGINE=InnoDB AUTO_INCREMENT=15 DEFAULT CHARSET=utf8 COMMENT='Места основной работы специалистов клиники';
/*!40101 SET character_set_client = @saved_cs_client */;

--
-- Dumping data for table `sd_institutions`
--

LOCK TABLES `sd_institutions` WRITE;
/*!40000 ALTER TABLE `sd_institutions` DISABLE KEYS */;
INSERT INTO `sd_institutions` (`institution_id`, `name`, `shortname`) VALUES (1,'Московский Государственный Университет им. М.В.Ломоносова','МГУ'),(2,'Первый Московский государственный медицинский университет имени И.М. Сеченова','Первый МГМУ им. И.М. Сеченова'),(3,'Национальный медико-хирургический Центр им. Н.И. Пирогова',''),(4,'Московский научно-практический центр дерматовенерологии и косметологии',''),(5,'Центр планирования семьи и репродукции Москвы','ЦПСиР г. Москва'),(6,'Московский государственный медико-стоматологический университет','МГМСУ'),(7,'Государственный научный центр “Институт иммунологии” Федерального медико-биологического агентства','ГНЦ Институт иммунологии ФМБА России'),(8,'Московский областной научно-исследовательский клинический институт им. М.Ф.Владимирского','МОНИКИ'),(9,'Университетская клиническая больница №2','УКБ №2'),(10,'Клиника ЭКО Альтравита',''),(11,'Научно-исследовательский институт клинической кардиологии им. А.Л. Мясникова','НИИ клинической кардиологии'),(12,'Можайская центральная районная больница','ГБУЗ МО Можайская ЦРБ'),(13,'Иркустский Государственный Медицинский Университет','ИГМУ'),(14,'Главный военный клинический госпиталь имени академика Н.Н. Бурденко','ГВКГ');
/*!40000 ALTER TABLE `sd_institutions` ENABLE KEYS */;
UNLOCK TABLES;

--
-- Table structure for table `sd_persons`
--

DROP TABLE IF EXISTS `sd_persons`;
/*!40101 SET @saved_cs_client     = @@character_set_client */;
 SET character_set_client = utf8mb4 ;
CREATE TABLE `sd_persons` (
  `person_id` int(11) NOT NULL AUTO_INCREMENT,
  `firstname` text NOT NULL COMMENT 'Имя',
  `lastname` text NOT NULL COMMENT 'Фамилия',
  `patronymic` text COMMENT 'Отчество',
  `education` int(11) DEFAULT NULL COMMENT 'Основное образование',
  `years_work` tinyint(4) DEFAULT NULL COMMENT 'Стаж работы, лет',
  PRIMARY KEY (`person_id`),
  KEY `person` (`person_id`),
  KEY `FK_sd_persons_sd_institutions` (`education`),
  CONSTRAINT `FK_sd_persons_sd_institutions` FOREIGN KEY (`education`) REFERENCES `sd_institutions` (`institution_id`)
) ENGINE=InnoDB AUTO_INCREMENT=12 DEFAULT CHARSET=utf8;
/*!40101 SET character_set_client = @saved_cs_client */;

--
-- Dumping data for table `sd_persons`
--

LOCK TABLES `sd_persons` WRITE;
/*!40000 ALTER TABLE `sd_persons` DISABLE KEYS */;
INSERT INTO `sd_persons` (`person_id`, `firstname`, `lastname`, `patronymic`, `education`, `years_work`) VALUES (4,'Владимир','Кузнецов','Михайлович',2,15),(5,'Мария','Меркулова','Дмитриевна',NULL,15),(7,'Лидия','Никулкова','Константиновна',NULL,NULL),(8,'Валентина','Леоненко','Васильевна',2,15),(9,'Семен','Лебедев','Валерьевич',12,15),(10,'Ануш','Ванян','Овиковна',NULL,20),(11,'ffff','Ванян','Овиковна',NULL,20);
/*!40000 ALTER TABLE `sd_persons` ENABLE KEYS */;
UNLOCK TABLES;

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
  PRIMARY KEY (`id`)
) ENGINE=InnoDB AUTO_INCREMENT=4 DEFAULT CHARSET=utf8;
/*!40101 SET character_set_client = @saved_cs_client */;

--
-- Dumping data for table `sd_shedule_assign`
--

LOCK TABLES `sd_shedule_assign` WRITE;
/*!40000 ALTER TABLE `sd_shedule_assign` DISABLE KEYS */;
INSERT INTO `sd_shedule_assign` (`id`, `personId`, `shedule_hash`) VALUES (1,5,'8304747f13a24e988c4def60a882d828'),(2,7,'600b7de898b44baa9da75f3f3571a95c'),(3,9,'2eed78695e0b456b8526af478d4c6277');
/*!40000 ALTER TABLE `sd_shedule_assign` ENABLE KEYS */;
UNLOCK TABLES;

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
  CONSTRAINT `FK1_timeline_days_teimline` FOREIGN KEY (`timelineId`) REFERENCES `sd_timelines` (`id`)
) ENGINE=InnoDB AUTO_INCREMENT=91 DEFAULT CHARSET=utf8;
/*!40101 SET character_set_client = @saved_cs_client */;

--
-- Dumping data for table `sd_timeline_days`
--

LOCK TABLES `sd_timeline_days` WRITE;
/*!40000 ALTER TABLE `sd_timeline_days` DISABLE KEYS */;
INSERT INTO `sd_timeline_days` (`id`, `timelineId`, `day`, `is_active`) VALUES (1,5,'2019-01-24',1),(2,6,'2019-01-19',1),(3,6,'2019-01-26',1),(4,1,'2019-01-15',0),(5,1,'2019-01-16',0),(6,1,'2019-01-17',0),(7,1,'2019-01-18',0),(8,1,'2019-01-19',0),(9,1,'2019-01-20',0),(10,1,'2019-01-21',0),(11,1,'2019-01-22',0),(12,1,'2019-01-23',0),(13,1,'2019-01-24',0),(14,1,'2019-01-25',0),(15,1,'2019-01-26',0),(16,1,'2019-01-27',0),(17,1,'2019-01-28',0),(18,1,'2019-01-29',0),(19,2,'2019-01-15',0),(20,2,'2019-01-16',0),(21,2,'2019-01-17',0),(22,2,'2019-01-18',0),(23,2,'2019-01-19',0),(24,2,'2019-01-20',0),(25,2,'2019-01-21',0),(26,2,'2019-01-22',0),(27,2,'2019-01-23',0),(28,2,'2019-01-24',0),(29,2,'2019-01-25',0),(30,2,'2019-01-26',0),(31,2,'2019-01-27',0),(32,2,'2019-01-28',0),(33,2,'2019-01-29',0),(34,3,'2019-01-15',0),(35,3,'2019-01-16',0),(36,3,'2019-01-17',0),(37,3,'2019-01-18',0),(38,3,'2019-01-19',0),(39,3,'2019-01-20',0),(40,3,'2019-01-21',0),(41,3,'2019-01-22',0),(42,3,'2019-01-23',0),(43,3,'2019-01-24',0),(44,3,'2019-01-25',0),(45,3,'2019-01-26',0),(46,3,'2019-01-27',0),(47,3,'2019-01-28',0),(48,3,'2019-01-29',0),(49,4,'2019-01-15',0),(50,4,'2019-01-16',0),(51,4,'2019-01-17',0),(52,4,'2019-01-18',0),(53,4,'2019-01-19',0),(54,4,'2019-01-20',0),(55,4,'2019-01-21',0),(56,4,'2019-01-22',0),(57,4,'2019-01-23',0),(58,4,'2019-01-24',0),(59,4,'2019-01-25',0),(60,4,'2019-01-26',0),(61,4,'2019-01-27',0),(62,4,'2019-01-28',0),(63,4,'2019-01-29',0),(64,5,'2019-01-15',0),(65,5,'2019-01-16',0),(66,5,'2019-01-17',0),(67,5,'2019-01-18',0),(68,5,'2019-01-19',0),(69,5,'2019-01-20',0),(70,5,'2019-01-21',0),(71,5,'2019-01-22',0),(72,5,'2019-01-23',0),(73,5,'2019-01-25',0),(74,5,'2019-01-26',0),(75,5,'2019-01-27',0),(76,5,'2019-01-28',0),(77,5,'2019-01-29',0),(78,6,'2019-01-15',0),(79,6,'2019-01-16',0),(80,6,'2019-01-17',0),(81,6,'2019-01-18',0),(82,6,'2019-01-20',0),(83,6,'2019-01-21',0),(84,6,'2019-01-22',0),(85,6,'2019-01-23',0),(86,6,'2019-01-24',0),(87,6,'2019-01-25',0),(88,6,'2019-01-27',0),(89,6,'2019-01-28',0),(90,6,'2019-01-29',0);
/*!40000 ALTER TABLE `sd_timeline_days` ENABLE KEYS */;
UNLOCK TABLES;

--
-- Table structure for table `sd_timelines`
--

DROP TABLE IF EXISTS `sd_timelines`;
/*!40101 SET @saved_cs_client     = @@character_set_client */;
 SET character_set_client = utf8mb4 ;
CREATE TABLE `sd_timelines` (
  `id` int(11) NOT NULL AUTO_INCREMENT,
  `workplace_hash` text NOT NULL,
  `person_id` int(11) NOT NULL,
  PRIMARY KEY (`id`),
  UNIQUE KEY `workplace_hash_person_id` (`workplace_hash`(32),`person_id`)
) ENGINE=InnoDB AUTO_INCREMENT=9 DEFAULT CHARSET=utf8;
/*!40101 SET character_set_client = @saved_cs_client */;

--
-- Dumping data for table `sd_timelines`
--

LOCK TABLES `sd_timelines` WRITE;
/*!40000 ALTER TABLE `sd_timelines` DISABLE KEYS */;
INSERT INTO `sd_timelines` (`id`, `workplace_hash`, `person_id`) VALUES (1,'3bdc8187c82641cab412dbdbbe3e2925',9),(2,'4f5c759e776344bab43a06cf718ef650',5),(3,'7e86155fa9454ee68c4e2b5754b1c6b4',7),(4,'1dce28c288d54283b282b454b80423da',9),(5,'326e1037165e464ca3b8d0d7a56bdb81',5),(6,'e715da9a70cb4a66b27e963224a3a796',9);
/*!40000 ALTER TABLE `sd_timelines` ENABLE KEYS */;
UNLOCK TABLES;

--
-- Table structure for table `sd_traits`
--

DROP TABLE IF EXISTS `sd_traits`;
/*!40101 SET @saved_cs_client     = @@character_set_client */;
 SET character_set_client = utf8mb4 ;
CREATE TABLE `sd_traits` (
  `trait_id` int(11) NOT NULL AUTO_INCREMENT,
  `person_id` int(11) NOT NULL DEFAULT '0' COMMENT 'врач',
  `title` text NOT NULL,
  `description` text NOT NULL,
  `institution_id` int(11) DEFAULT '0',
  PRIMARY KEY (`trait_id`),
  KEY `FK_sd_traits_sd_persons` (`person_id`),
  KEY `FK_sd_traits_sd_institutions` (`institution_id`),
  CONSTRAINT `FK_sd_traits_sd_institutions` FOREIGN KEY (`institution_id`) REFERENCES `sd_institutions` (`institution_id`),
  CONSTRAINT `FK_sd_traits_sd_persons` FOREIGN KEY (`person_id`) REFERENCES `sd_persons` (`person_id`)
) ENGINE=InnoDB AUTO_INCREMENT=13 DEFAULT CHARSET=utf8;
/*!40101 SET character_set_client = @saved_cs_client */;

--
-- Dumping data for table `sd_traits`
--

LOCK TABLES `sd_traits` WRITE;
/*!40000 ALTER TABLE `sd_traits` DISABLE KEYS */;
INSERT INTO `sd_traits` (`trait_id`, `person_id`, `title`, `description`, `institution_id`) VALUES (1,4,'Основное место работы','Ассистент Кафедры Акушерства и гинекологии',6),(2,4,'специальность','акушер-гинеколог',NULL),(3,4,'специальность','гинеколог-эндокринолог',NULL),(4,4,'специальность','гинеколог',NULL),(5,5,'Основное место работы','Ассистент Кафедры Акушерства и гинекологии',5),(6,5,'специальность','акушер-гинеколог',NULL),(7,7,'Основное место работы','аллерголог',7),(8,8,'специальность','врач-дерматовенеролог',NULL),(9,8,'специальность','врач- косметолог',NULL),(10,9,'Основное место работы','заведующий онкологическим отделением',14),(11,10,'специальность','гинеколог-эндокринолог',NULL),(12,10,'специальность','эндокринолог',NULL);
/*!40000 ALTER TABLE `sd_traits` ENABLE KEYS */;
UNLOCK TABLES;

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
) ENGINE=InnoDB AUTO_INCREMENT=93 DEFAULT CHARSET=utf8;
/*!40101 SET character_set_client = @saved_cs_client */;

--
-- Dumping data for table `sd_workplaces`
--

LOCK TABLES `sd_workplaces` WRITE;
/*!40000 ALTER TABLE `sd_workplaces` DISABLE KEYS */;
INSERT INTO `sd_workplaces` (`id`, `workplace_hash`, `clinic_hash`) VALUES (1,'41e0844279ef46ec92276a3a0cb5dae9','f041c4c2da484ea0aa5b7cc8d91dc798'),(2,'ec399761507840de9e15b3c7f8fa0ae8','f041c4c2da484ea0aa5b7cc8d91dc798'),(3,'57491828e8284e4597daabd9cf661764','f041c4c2da484ea0aa5b7cc8d91dc798'),(4,'f3762f8c64df4d2f87a1411439f0695d','f041c4c2da484ea0aa5b7cc8d91dc798'),(5,'4a4551b61e5542af81eb066a4cb871f2','f041c4c2da484ea0aa5b7cc8d91dc798'),(6,'a832bdb481a84241ae8cf3576aad65e1','f041c4c2da484ea0aa5b7cc8d91dc798'),(7,'0f67cf4e3be34025adcc2b526dde9724','f041c4c2da484ea0aa5b7cc8d91dc798'),(8,'3cdfc0f0db054598bc37a50d9be0e02b','f041c4c2da484ea0aa5b7cc8d91dc798'),(9,'3bdc8187c82641cab412dbdbbe3e2925','f041c4c2da484ea0aa5b7cc8d91dc798'),(10,'b212616b89484fa3957ffe30ee21dd85','f041c4c2da484ea0aa5b7cc8d91dc798'),(11,'4f5c759e776344bab43a06cf718ef650','f041c4c2da484ea0aa5b7cc8d91dc798'),(12,'7e86155fa9454ee68c4e2b5754b1c6b4','f041c4c2da484ea0aa5b7cc8d91dc798'),(13,'ce948f2b6fee4c5494d413a51bee515b','f041c4c2da484ea0aa5b7cc8d91dc798'),(14,'72c58bbddd6447f888337ece61f7453b','f041c4c2da484ea0aa5b7cc8d91dc798'),(15,'dbb256a83c354b77b1e176f1f43e7131','f041c4c2da484ea0aa5b7cc8d91dc798'),(16,'a1385764c0dc464d80a9e99ac61276dc','f041c4c2da484ea0aa5b7cc8d91dc798'),(17,'43b6f1e6b66643c487df9c664f55f277','f041c4c2da484ea0aa5b7cc8d91dc798'),(18,'1856be9ff11c4232b9f63f844a099152','f041c4c2da484ea0aa5b7cc8d91dc798'),(19,'2f31a4c9f4eb47ae99c6594cfb94ec2f','5cc8fea2ed2f483282c9fdd2a4a84341'),(20,'729149faa9944726a6d0023f5960f429','5cc8fea2ed2f483282c9fdd2a4a84341'),(21,'117715832de743a5892da1ab7b6461e3','5cc8fea2ed2f483282c9fdd2a4a84341'),(22,'5ea44f3fb51648efbf7b2d79668d9053','5cc8fea2ed2f483282c9fdd2a4a84341'),(23,'191287a61ccb4a109407e67a071b7dd4','5cc8fea2ed2f483282c9fdd2a4a84341'),(24,'1b0165ad9359464f8140735d922fee46','5cc8fea2ed2f483282c9fdd2a4a84341'),(25,'5733693f6e7244b5ba8184d7237a2054','5cc8fea2ed2f483282c9fdd2a4a84341'),(26,'1dce28c288d54283b282b454b80423da','5cc8fea2ed2f483282c9fdd2a4a84341'),(27,'326e1037165e464ca3b8d0d7a56bdb81','5cc8fea2ed2f483282c9fdd2a4a84341'),(28,'0ead6d01d0a648dc9b8d6fb5c3d0e53b','5cc8fea2ed2f483282c9fdd2a4a84341'),(29,'ac647a4b3c8948fe93708eeb39d8e795','5cc8fea2ed2f483282c9fdd2a4a84341'),(30,'2ed2d9fc2a9c48d19e4c33d8c25c6908','5cc8fea2ed2f483282c9fdd2a4a84341'),(31,'1779e884dd7145bf921ebb13d89354b3','19d6da22f59a4d82b8840fc95db5c4e7'),(32,'7ff57ddf0b2d4404841bcccee7ddfc66','19d6da22f59a4d82b8840fc95db5c4e7'),(33,'0d74e41bb52c4cd590e78462e3e99006','19d6da22f59a4d82b8840fc95db5c4e7'),(34,'d497e39c69ce48a485249144cccb6a9b','19d6da22f59a4d82b8840fc95db5c4e7'),(35,'e1f7a2536c224fa3b1962e83b833c831','41ddca448e2d45b9ac99d6bcb551161e'),(36,'9a6e041d85d441ceb593899efdb15daa','41ddca448e2d45b9ac99d6bcb551161e'),(37,'22d6ddda8dfa46b9982b2de39b2911b6','41ddca448e2d45b9ac99d6bcb551161e'),(38,'775062b91f584fc38cd50b0bfff096d0','41ddca448e2d45b9ac99d6bcb551161e'),(39,'6cb0ba61f8064f90b9fdfe1165b4f00c','41ddca448e2d45b9ac99d6bcb551161e'),(40,'1f98934ff3e946f095a18f651e640a42','41ddca448e2d45b9ac99d6bcb551161e'),(41,'28c7b0f901cf4839928629419e2ede70','41ddca448e2d45b9ac99d6bcb551161e'),(42,'10a6206ca75c4b19b7a1c1b27424c215','41ddca448e2d45b9ac99d6bcb551161e'),(43,'5b7e95a0504b4ea49ebdc8cee07e7118','1722cf1e95a345fc8863dfe6a48ac0d3'),(44,'5ca0e8d476444f68aff481f386584ceb','1722cf1e95a345fc8863dfe6a48ac0d3'),(45,'e20ae40d9c4d40d18210208412383c2b','1722cf1e95a345fc8863dfe6a48ac0d3'),(46,'b4f105d9f223496ea20b66589f6ea4f1','1722cf1e95a345fc8863dfe6a48ac0d3'),(47,'d7c0246a72d74d42b932490471e0247e','1722cf1e95a345fc8863dfe6a48ac0d3'),(48,'39a9900c25304f1b884cab12165a5068','1722cf1e95a345fc8863dfe6a48ac0d3'),(49,'e715da9a70cb4a66b27e963224a3a796','1722cf1e95a345fc8863dfe6a48ac0d3'),(50,'53d069f2ebc545ffac1d19aaa548dc94','1722cf1e95a345fc8863dfe6a48ac0d3'),(51,'7eff5c99172047d6b7f482ddbd80124a','1722cf1e95a345fc8863dfe6a48ac0d3'),(52,'273c1e35a04f4cfcaad6743e6024947e','1722cf1e95a345fc8863dfe6a48ac0d3'),(53,'ae9de30777224a10bd9dd1d892de808e','1722cf1e95a345fc8863dfe6a48ac0d3'),(54,'be910732a37442849fc0a04a0b13a9a8','3e68757c2faa460f8f0410d4fc90ce05'),(55,'c0fbd28bd85f4a8a9d96993d87a80fbd','3e68757c2faa460f8f0410d4fc90ce05'),(56,'a1b8fbfed7004c168f2f6c64457552d4','3e68757c2faa460f8f0410d4fc90ce05'),(57,'a232690e6fab4720818b7684c87e9049','3e68757c2faa460f8f0410d4fc90ce05'),(58,'c4ec4a83f2fc4292a16e78198fc79484','3e68757c2faa460f8f0410d4fc90ce05'),(59,'eed492b6b06e4838af9b4da4ed661696','3e68757c2faa460f8f0410d4fc90ce05'),(60,'fd99f9b1314d4f7ab292aa8b3fd79058','76563309d6244354b748057237bda61f'),(61,'7761f716119e4e439a1bc89396dec7dd','76563309d6244354b748057237bda61f'),(62,'88c9b886c5dc4c03a1b2011057a234a7','76563309d6244354b748057237bda61f'),(63,'42563927ca1347139eea5f93e5fc636d','76563309d6244354b748057237bda61f'),(64,'154ab730109d4fbba4b367e4709ca014','76563309d6244354b748057237bda61f'),(65,'10d3550f143c45a99833aa9eea3c1c68','76563309d6244354b748057237bda61f'),(66,'c756fc3124324a0fb25246e8cc7ea35a','76563309d6244354b748057237bda61f'),(67,'472e351ac65d474d9e572f030733e908','76563309d6244354b748057237bda61f'),(68,'1fe00086a4064f648e3c3dc07d579cf6','76563309d6244354b748057237bda61f'),(69,'cb71c09e09af42e8ad03f6ee69e042f7','76563309d6244354b748057237bda61f'),(70,'3765ce681fac4333a21ca7820816cbee','76563309d6244354b748057237bda61f'),(71,'fc64c02f4d244a119abcd393a6599fbc','76563309d6244354b748057237bda61f'),(72,'95eff1d9227d4e73960a38b1d3834ef8','76563309d6244354b748057237bda61f'),(73,'7bd28bde0d264b98b0370bf8edbf75ab','76563309d6244354b748057237bda61f'),(74,'9a2ed8fa3e144cbd87bd974b8a906897','76563309d6244354b748057237bda61f'),(75,'fa899ccbf59246489a60167c15375222','2a85465c0d8d4b9b928646f91fd7ace5'),(76,'5dc387812b384551a96c8b9ec87d5760','2a85465c0d8d4b9b928646f91fd7ace5'),(77,'72485d086e6346faac8bdfcd49fe745f','2a85465c0d8d4b9b928646f91fd7ace5'),(78,'15910f987fa0443bb0dc62effe141bd1','2a85465c0d8d4b9b928646f91fd7ace5'),(79,'c76375abe5264977833faef9d38bbdeb','2a85465c0d8d4b9b928646f91fd7ace5'),(80,'a5c2f60eb1e145f1af95e307b175a5ba','2a85465c0d8d4b9b928646f91fd7ace5'),(81,'b9fc34843cbb499d8e05be6c815fee2d','2a85465c0d8d4b9b928646f91fd7ace5'),(82,'857bed796d97400e9996ada78c367714','2a85465c0d8d4b9b928646f91fd7ace5'),(83,'d55d85adca4d4a3da9beb31164a5ba9a','268334bbd12e417ebc3947a94a9d4ba4'),(84,'c2ed458739ba4582b4e9f4995305219e','268334bbd12e417ebc3947a94a9d4ba4'),(85,'12c935d9d7ed4e25bfe6b7ec6f1d8f5b','268334bbd12e417ebc3947a94a9d4ba4'),(86,'9d9cc688edc043ef87699fe0469279a7','268334bbd12e417ebc3947a94a9d4ba4'),(87,'7650669f23064fc2b65f32d20c76f7ea','268334bbd12e417ebc3947a94a9d4ba4'),(88,'05898321f2aa437983366484f624383c','268334bbd12e417ebc3947a94a9d4ba4'),(89,'325766704a9f41c282c0e9bc229aae25','268334bbd12e417ebc3947a94a9d4ba4'),(90,'0d18855ed80f4d429b2dca58d65d6740','268334bbd12e417ebc3947a94a9d4ba4'),(91,'292477cce5984a7ca63e348811f7c6cc','268334bbd12e417ebc3947a94a9d4ba4'),(92,'fe60cee437044034875c9b65b99ca6eb','268334bbd12e417ebc3947a94a9d4ba4');
/*!40000 ALTER TABLE `sd_workplaces` ENABLE KEYS */;
UNLOCK TABLES;

--
-- Table structure for table `z_schedule`
--

DROP TABLE IF EXISTS `z_schedule`;
/*!40101 SET @saved_cs_client     = @@character_set_client */;
 SET character_set_client = utf8mb4 ;
CREATE TABLE `z_schedule` (
  `id` int(11) NOT NULL AUTO_INCREMENT,
  `hash` text NOT NULL,
  `person_name` text NOT NULL,
  `person_id` int(11) NOT NULL,
  `workplace_hash` text NOT NULL,
  `workplace_name` text NOT NULL,
  `subdivision_hash` text NOT NULL,
  `subdivision_name` text NOT NULL,
  PRIMARY KEY (`id`)
) ENGINE=InnoDB AUTO_INCREMENT=109 DEFAULT CHARSET=utf8 ROW_FORMAT=COMPACT;
/*!40101 SET character_set_client = @saved_cs_client */;

--
-- Dumping data for table `z_schedule`
--

LOCK TABLES `z_schedule` WRITE;
/*!40000 ALTER TABLE `z_schedule` DISABLE KEYS */;
INSERT INTO `z_schedule` (`id`, `hash`, `person_name`, `person_id`, `workplace_hash`, `workplace_name`, `subdivision_hash`, `subdivision_name`) VALUES (1,'8ff62746dcf94cf2b986c650dab12684','Азаренков А.В.',0,'41e0844279ef46ec92276a3a0cb5dae9','Кардиолог+УЗИ сердца','f041c4c2da484ea0aa5b7cc8d91dc798','Тучково'),(2,'6aba8354e556483e975e14b2adcbdaf3','Барсукова Е.О.',0,'ec399761507840de9e15b3c7f8fa0ae8','УЗИ','f041c4c2da484ea0aa5b7cc8d91dc798','Тучково'),(3,'7271d473d48f489dbce13952d9c07b5a','Бриллиантова Н.Н.',0,'ec399761507840de9e15b3c7f8fa0ae8','УЗИ','f041c4c2da484ea0aa5b7cc8d91dc798','Тучково'),(4,'766ebe165d6a4cfc83fd6760cd85dcf7','Егельская В.К.',0,'ec399761507840de9e15b3c7f8fa0ae8','УЗИ','f041c4c2da484ea0aa5b7cc8d91dc798','Тучково'),(5,'e4b9bd5fba0c4c048e8d90f4aa32c4ec','Кучейник В.И.',0,'ec399761507840de9e15b3c7f8fa0ae8','УЗИ','f041c4c2da484ea0aa5b7cc8d91dc798','Тучково'),(6,'2d9b9478bf9244bfb3bb1e2dec720bec','Богнат Р.П.',0,'57491828e8284e4597daabd9cf661764','УЗИ детям','f041c4c2da484ea0aa5b7cc8d91dc798','Тучково'),(7,'88fa0c3258ce44839ac2966cc48a0451','Ванян А.О.',10,'f3762f8c64df4d2f87a1411439f0695d','Эндокринология','f041c4c2da484ea0aa5b7cc8d91dc798','Тучково'),(8,'b7300926ac3c4cdd99a132f3b29938b6','Чайкина И.В.',0,'f3762f8c64df4d2f87a1411439f0695d','Эндокринология','f041c4c2da484ea0aa5b7cc8d91dc798','Тучково'),(9,'9ffc57b83be94e01995e624ab39796cf','Гаглоева З.Р.',0,'4a4551b61e5542af81eb066a4cb871f2','Гастроэнтеролог+УЗИ бр.п.','f041c4c2da484ea0aa5b7cc8d91dc798','Тучково'),(10,'fe789aeccc7e46e4ad4048d5ebcb4e16','Гадаев И.Ю.',0,'a832bdb481a84241ae8cf3576aad65e1','Терапевт, Гематолог','f041c4c2da484ea0aa5b7cc8d91dc798','Тучково'),(11,'141098d83b2147d192e7b71512255416','Екатеринчев В.А.',0,'0f67cf4e3be34025adcc2b526dde9724','ЛОР','f041c4c2da484ea0aa5b7cc8d91dc798','Тучково'),(12,'9024a5a884ef4876a975f198cfb5677b','Яковлев Д.А.',0,'0f67cf4e3be34025adcc2b526dde9724','ЛОР','f041c4c2da484ea0aa5b7cc8d91dc798','Тучково'),(13,'8d7e73613fe043deaf995ee5037aed0d','Елизарова Д.В.',0,'3cdfc0f0db054598bc37a50d9be0e02b','Неврология','f041c4c2da484ea0aa5b7cc8d91dc798','Тучково'),(14,'9e55c2cde8244936b11350b36aaeece1','Пустынников Я.А.',0,'3cdfc0f0db054598bc37a50d9be0e02b','Неврология','f041c4c2da484ea0aa5b7cc8d91dc798','Тучково'),(15,'2eed78695e0b456b8526af478d4c6277','Лебедев С.В.',9,'3bdc8187c82641cab412dbdbbe3e2925','Маммолог, Удаления','f041c4c2da484ea0aa5b7cc8d91dc798','Тучково'),(16,'5cd5f1645f3d489984434b6215e07d47','Максимова О.В.',0,'b212616b89484fa3957ffe30ee21dd85','Педиатрия','f041c4c2da484ea0aa5b7cc8d91dc798','Тучково'),(17,'8304747f13a24e988c4def60a882d828','Меркулова М.Д.',5,'4f5c759e776344bab43a06cf718ef650','Гинекология','f041c4c2da484ea0aa5b7cc8d91dc798','Тучково'),(18,'600b7de898b44baa9da75f3f3571a95c','Никулкова Л.К.',7,'7e86155fa9454ee68c4e2b5754b1c6b4','Аллергология','f041c4c2da484ea0aa5b7cc8d91dc798','Тучково'),(19,'8c3e894edab749889ddd3ff3fa8a4940','Перфилов С.В.',0,'ce948f2b6fee4c5494d413a51bee515b','Гастроскопия','f041c4c2da484ea0aa5b7cc8d91dc798','Тучково'),(20,'d8689b5d582549f884dadfc0a00d0564','Покусаева Д.П.',0,'72c58bbddd6447f888337ece61f7453b','УЗИ сердца, общее узи','f041c4c2da484ea0aa5b7cc8d91dc798','Тучково'),(21,'be8324561bb64da1a0d29b2ef1baaf0e','Попов И.В.',0,'dbb256a83c354b77b1e176f1f43e7131','Дерматолог+Удаления','f041c4c2da484ea0aa5b7cc8d91dc798','Тучково'),(22,'be8324561bb64da1a0d29b2ef1baaf0e','Попов И.В.',0,'a1385764c0dc464d80a9e99ac61276dc','Косметология','f041c4c2da484ea0aa5b7cc8d91dc798','Тучково'),(23,'737a56f99c304e4b9ea739ceaf2d13b6','Усиков А.Н.',0,'43b6f1e6b66643c487df9c664f55f277','Уролог+УЗИ в Урологии','f041c4c2da484ea0aa5b7cc8d91dc798','Тучково'),(24,'2646d1c2d8c6418fb413f12aee9ef79a','Щербанина В.Ю.',0,'1856be9ff11c4232b9f63f844a099152','УЗИ сосудов, нервов','f041c4c2da484ea0aa5b7cc8d91dc798','Тучково'),(25,'8d7e73613fe043deaf995ee5037aed0d','Елизарова Д.В.',0,'2f31a4c9f4eb47ae99c6594cfb94ec2f','Невролог','5cc8fea2ed2f483282c9fdd2a4a84341','Руза'),(26,'8ff62746dcf94cf2b986c650dab12684','Азаренков А.В.',0,'729149faa9944726a6d0023f5960f429','УЗИ сердца','5cc8fea2ed2f483282c9fdd2a4a84341','Руза'),(27,'d8689b5d582549f884dadfc0a00d0564','Покусаева Д.П.',0,'729149faa9944726a6d0023f5960f429','УЗИ сердца','5cc8fea2ed2f483282c9fdd2a4a84341','Руза'),(28,'6aba8354e556483e975e14b2adcbdaf3','Барсукова Е.О.',0,'117715832de743a5892da1ab7b6461e3','УЗИ','5cc8fea2ed2f483282c9fdd2a4a84341','Руза'),(29,'7271d473d48f489dbce13952d9c07b5a','Бриллиантова Н.Н.',0,'117715832de743a5892da1ab7b6461e3','УЗИ','5cc8fea2ed2f483282c9fdd2a4a84341','Руза'),(30,'2d9b9478bf9244bfb3bb1e2dec720bec','Богнат Р.П.',0,'5ea44f3fb51648efbf7b2d79668d9053','УЗИ детям','5cc8fea2ed2f483282c9fdd2a4a84341','Руза'),(31,'88fa0c3258ce44839ac2966cc48a0451','Ванян А.О.',10,'191287a61ccb4a109407e67a071b7dd4','Эндокринология','5cc8fea2ed2f483282c9fdd2a4a84341','Руза'),(32,'d7acf622c067480a94f56c8c352db78c','Гурко А.М.',0,'1b0165ad9359464f8140735d922fee46','Проктолог+Хирург','5cc8fea2ed2f483282c9fdd2a4a84341','Руза'),(33,'bddfd7eef2874e1f8a7855be75058491','Домнина С.М.',0,'5733693f6e7244b5ba8184d7237a2054','Педиатр','5cc8fea2ed2f483282c9fdd2a4a84341','Руза'),(34,'2eed78695e0b456b8526af478d4c6277','Лебедев С.В.',9,'1dce28c288d54283b282b454b80423da','Маммолог, Удаления','5cc8fea2ed2f483282c9fdd2a4a84341','Руза'),(35,'8304747f13a24e988c4def60a882d828','Меркулова М.Д.',5,'326e1037165e464ca3b8d0d7a56bdb81','Гинекология+УЗИ в гинекологии','5cc8fea2ed2f483282c9fdd2a4a84341','Руза'),(36,'616641c7bf2742d5af4e4b693ae61a85','Чепелкин В.Ю.',0,'0ead6d01d0a648dc9b8d6fb5c3d0e53b','Детский Ортопед, Хирург','5cc8fea2ed2f483282c9fdd2a4a84341','Руза'),(37,'2646d1c2d8c6418fb413f12aee9ef79a','Щербанина В.Ю.',0,'ac647a4b3c8948fe93708eeb39d8e795','УЗИ сосудов, нервов','5cc8fea2ed2f483282c9fdd2a4a84341','Руза'),(38,'9024a5a884ef4876a975f198cfb5677b','Яковлев Д.А.',0,'2ed2d9fc2a9c48d19e4c33d8c25c6908','ЛОР','5cc8fea2ed2f483282c9fdd2a4a84341','Руза'),(39,'7e3fd524b3f8478c9b53e6d4a934d46c','Ватоян М.А.',0,'1779e884dd7145bf921ebb13d89354b3','Гинекология+УЗИ','19d6da22f59a4d82b8840fc95db5c4e7','Сафоново'),(40,'c5dff729eaee4a5d925f988e103995cf','Громакова Е.Ф.',0,'7ff57ddf0b2d4404841bcccee7ddfc66','Кардиолог, УЗИ сердца, ЭКГ','19d6da22f59a4d82b8840fc95db5c4e7','Сафоново'),(41,'eb6eaed620f54826b7eb301b6f446ba3','Скрицкий В.С.',0,'7ff57ddf0b2d4404841bcccee7ddfc66','Кардиолог, УЗИ сердца, ЭКГ','19d6da22f59a4d82b8840fc95db5c4e7','Сафоново'),(42,'382a01f9dc074788a7797b52bc2cc545','Ошерова М.В.',0,'0d74e41bb52c4cd590e78462e3e99006','УЗИ','19d6da22f59a4d82b8840fc95db5c4e7','Сафоново'),(43,'37da73f8fee24e589d9251a825dd4157','Титова Л.Л.',0,'d497e39c69ce48a485249144cccb6a9b','Невролог','19d6da22f59a4d82b8840fc95db5c4e7','Сафоново'),(44,'41d5d7b0611b4e4091b68ad1c73b3816','Ващенко Е.Н.',0,'e1f7a2536c224fa3b1962e83b833c831','Эндокринолог','41ddca448e2d45b9ac99d6bcb551161e','Стародуб'),(45,'934f6d81a42e4df18b7f60723ef05551','Гайдашова О.А.',0,'9a6e041d85d441ceb593899efdb15daa','Кардиолог','41ddca448e2d45b9ac99d6bcb551161e','Стародуб'),(46,'c5dff729eaee4a5d925f988e103995cf','Громакова Е.Ф.',0,'22d6ddda8dfa46b9982b2de39b2911b6','Кардиолог+УЗИ сердца+ЭКГ','41ddca448e2d45b9ac99d6bcb551161e','Стародуб'),(47,'413398873b714ce0972df46096e10229','Кожан А.И.',0,'775062b91f584fc38cd50b0bfff096d0','Уролог','41ddca448e2d45b9ac99d6bcb551161e','Стародуб'),(48,'c5191f6270984f0b9e81d818a64702c9','Лощ И.Е.',0,'6cb0ba61f8064f90b9fdfe1165b4f00c','Гинеколог','41ddca448e2d45b9ac99d6bcb551161e','Стародуб'),(49,'bfc81bc750f94687b37157184045809b','Смирнов В.С.',0,'1f98934ff3e946f095a18f651e640a42','НЕВРОЛОГ','41ddca448e2d45b9ac99d6bcb551161e','Стародуб'),(50,'f62f0d96f2104147b9d02fa5b4d10ea9','Соколова И.В.',0,'28c7b0f901cf4839928629419e2ede70','УЗИ сердца, сосудов','41ddca448e2d45b9ac99d6bcb551161e','Стародуб'),(51,'2bbce1dcdf5544128a549a3e3015c4fb','Чирун Е.В.',0,'10a6206ca75c4b19b7a1c1b27424c215','Гинеколог+УЗИ общее','41ddca448e2d45b9ac99d6bcb551161e','Стародуб'),(52,'e3d56b1abf05410c82e9c0c359320287','Азаренков А.В.',0,'5b7e95a0504b4ea49ebdc8cee07e7118','4 Кардиология+УЗИ сердца','1722cf1e95a345fc8863dfe6a48ac0d3','Гагарин'),(53,'c5dff729eaee4a5d925f988e103995cf','Громакова Е.Ф.',0,'5b7e95a0504b4ea49ebdc8cee07e7118','4 Кардиология+УЗИ сердца','1722cf1e95a345fc8863dfe6a48ac0d3','Гагарин'),(54,'2d9b9478bf9244bfb3bb1e2dec720bec','Богнат Р.П.',0,'5ca0e8d476444f68aff481f386584ceb','2 УЗИ сосудов+общее+ДЕТИ','1722cf1e95a345fc8863dfe6a48ac0d3','Гагарин'),(55,'e4b9bd5fba0c4c048e8d90f4aa32c4ec','Кучейник В.И.',0,'5ca0e8d476444f68aff481f386584ceb','2 УЗИ сосудов+общее+ДЕТИ','1722cf1e95a345fc8863dfe6a48ac0d3','Гагарин'),(56,'2646d1c2d8c6418fb413f12aee9ef79a','Щербанина В.Ю.',0,'5ca0e8d476444f68aff481f386584ceb','2 УЗИ сосудов+общее+ДЕТИ','1722cf1e95a345fc8863dfe6a48ac0d3','Гагарин'),(57,'6e47b1734f7b4e63a8252ec539b4342d','Ванян А.О.',10,'e20ae40d9c4d40d18210208412383c2b','Эндокринология','1722cf1e95a345fc8863dfe6a48ac0d3','Гагарин'),(58,'7e3fd524b3f8478c9b53e6d4a934d46c','Ватоян М.А.',0,'b4f105d9f223496ea20b66589f6ea4f1','3 Гинекология+УЗИ в гинекологии','1722cf1e95a345fc8863dfe6a48ac0d3','Гагарин'),(59,'d7acf622c067480a94f56c8c352db78c','Гурко А.М.',0,'d7c0246a72d74d42b932490471e0247e','Проктолог+хирург','1722cf1e95a345fc8863dfe6a48ac0d3','Гагарин'),(60,'141098d83b2147d192e7b71512255416','Екатеринчев В.А.',0,'39a9900c25304f1b884cab12165a5068','ЛОР','1722cf1e95a345fc8863dfe6a48ac0d3','Гагарин'),(61,'2eed78695e0b456b8526af478d4c6277','Лебедев С.В.',9,'e715da9a70cb4a66b27e963224a3a796','5 Маммолог, Удаления','1722cf1e95a345fc8863dfe6a48ac0d3','Гагарин'),(62,'48d451f7f4594c03928242b07f3b3b40','Малахов А.М.',0,'53d069f2ebc545ffac1d19aaa548dc94','Урология+УЗИ общее+ТРУЗИ','1722cf1e95a345fc8863dfe6a48ac0d3','Гагарин'),(63,'f2d14cd891d9499c96849ebfaf53af00','Перфилов С.В.',0,'7eff5c99172047d6b7f482ddbd80124a','Гастроэнтерология, эндоскопия','1722cf1e95a345fc8863dfe6a48ac0d3','Гагарин'),(64,'f4c0b2b1865d4ddaae1f2242bfa6fe9d','Пустынников Я.А.',0,'273c1e35a04f4cfcaad6743e6024947e','Неврология','1722cf1e95a345fc8863dfe6a48ac0d3','Гагарин'),(65,'616641c7bf2742d5af4e4b693ae61a85','Чепелкин В.Ю.',0,'ae9de30777224a10bd9dd1d892de808e','Детский Ортопед, Хирург','1722cf1e95a345fc8863dfe6a48ac0d3','Гагарин'),(66,'41d5d7b0611b4e4091b68ad1c73b3816','Ващенко Е.Н.',0,'be910732a37442849fc0a04a0b13a9a8','Эндокринолог','3e68757c2faa460f8f0410d4fc90ce05','Клинцы'),(67,'67edcaca4b3f4708b1e4b4f7221ae4da','Матусов П.Г.',0,'c0fbd28bd85f4a8a9d96993d87a80fbd','Флеболог, сосудистый хирург','3e68757c2faa460f8f0410d4fc90ce05','Клинцы'),(68,'aa0ae02d5e734cd7aa5c1562cb2b6036','Родина Е.В.',0,'a1b8fbfed7004c168f2f6c64457552d4','Кардиолог+УЗИ+ЭКГ','3e68757c2faa460f8f0410d4fc90ce05','Клинцы'),(69,'bfc81bc750f94687b37157184045809b','Смирнов В.С.',0,'a232690e6fab4720818b7684c87e9049','Невролог','3e68757c2faa460f8f0410d4fc90ce05','Клинцы'),(70,'2bbce1dcdf5544128a549a3e3015c4fb','Чирун Е.В.',0,'c4ec4a83f2fc4292a16e78198fc79484','Гинеколог+УЗИ общее','3e68757c2faa460f8f0410d4fc90ce05','Клинцы'),(71,'c3f37758ef9c4dacbcd670ffa609f783','Шаметько Е.В.',0,'eed492b6b06e4838af9b4da4ed661696','Гастроэнтеролог, Гастроскопия, УЗИ','3e68757c2faa460f8f0410d4fc90ce05','Клинцы'),(72,'c5dff729eaee4a5d925f988e103995cf','Громакова Е.Ф.',0,'fd99f9b1314d4f7ab292aa8b3fd79058','Кардиолог+УЗИ сердца+ЭКГ','76563309d6244354b748057237bda61f','Новозыбков'),(73,'df1bcbc03f654c4e8f0eb53a2526b865','Абраменко Д.М.',0,'7761f716119e4e439a1bc89396dec7dd','УЗИ суставов, общее, сосуды, сердце','76563309d6244354b748057237bda61f','Новозыбков'),(74,'cd584543da3742f1a374ddcad556c235','Автушенко Н.В.',0,'88c9b886c5dc4c03a1b2011057a234a7','Аллерголог','76563309d6244354b748057237bda61f','Новозыбков'),(75,'fc2e2d3f4ab94c36bad19927f7ec843e','Борсук Д.П.',0,'42563927ca1347139eea5f93e5fc636d','УЗИ сердца, сосудов, общее','76563309d6244354b748057237bda61f','Новозыбков'),(76,'bb40729cfcdf4f3182c4ac787dda8cb6','Быстревский В.А.',0,'154ab730109d4fbba4b367e4709ca014','Уролог+УЗИ в урологии','76563309d6244354b748057237bda61f','Новозыбков'),(77,'41d5d7b0611b4e4091b68ad1c73b3816','Ващенко Е.Н.',0,'10d3550f143c45a99833aa9eea3c1c68','Эндокринолог','76563309d6244354b748057237bda61f','Новозыбков'),(78,'6cd9f10b416041a5969ba095efc99cef','Дедечко М.П.',0,'c756fc3124324a0fb25246e8cc7ea35a','Гинеколог+Лечение эрозии','76563309d6244354b748057237bda61f','Новозыбков'),(79,'3298c2c6d1d74a70be96678b04e47653','Ефимова Н.Н.',0,'472e351ac65d474d9e572f030733e908','Кардиолог+Гастроэнтеролог+ЭКГ','76563309d6244354b748057237bda61f','Новозыбков'),(80,'2f52df3d6bea4e64820ee54bd85c3334','Закружная Ю.С.',0,'1fe00086a4064f648e3c3dc07d579cf6','Невролог','76563309d6244354b748057237bda61f','Новозыбков'),(81,'bfc81bc750f94687b37157184045809b','Смирнов В.С.',0,'1fe00086a4064f648e3c3dc07d579cf6','Невролог','76563309d6244354b748057237bda61f','Новозыбков'),(82,'67edcaca4b3f4708b1e4b4f7221ae4da','Матусов П.Г.',0,'cb71c09e09af42e8ad03f6ee69e042f7','Флеболог, сосудистый хирург','76563309d6244354b748057237bda61f','Новозыбков'),(83,'b4d10ad8b8a64f2c9ef4714aae822b0b','Окунцев Д.В.',0,'3765ce681fac4333a21ca7820816cbee','Онколог, удаление новообразований','76563309d6244354b748057237bda61f','Новозыбков'),(84,'cef3405280f9430cbd51d2908bc62569','Родина Е.В.',0,'fc64c02f4d244a119abcd393a6599fbc','Кардиолог+УЗИ всего+ЭКГ','76563309d6244354b748057237bda61f','Новозыбков'),(85,'2bbce1dcdf5544128a549a3e3015c4fb','Чирун Е.В.',0,'95eff1d9227d4e73960a38b1d3834ef8','Гинеколог+УЗИ общее','76563309d6244354b748057237bda61f','Новозыбков'),(86,'c3f37758ef9c4dacbcd670ffa609f783','Шаметько Е.В.',0,'7bd28bde0d264b98b0370bf8edbf75ab','Гастроэнтеролог, УЗИ общее','76563309d6244354b748057237bda61f','Новозыбков'),(87,'1f8f26fc0ddf48af95abe0f9773aceeb','Ядченко Е.С.',0,'9a2ed8fa3e144cbd87bd974b8a906897','ЛОР','76563309d6244354b748057237bda61f','Новозыбков'),(88,'9f5b4c7848594305a2e4189cceee429d','Большаков А.Н.',0,'fa899ccbf59246489a60167c15375222','Невролог','2a85465c0d8d4b9b928646f91fd7ace5','Почеп'),(89,'12203c6c71c64e19af9d65797d8a097b','Большакова Т.В.',0,'5dc387812b384551a96c8b9ec87d5760','ЛОР Почеп','2a85465c0d8d4b9b928646f91fd7ace5','Почеп'),(90,'934f6d81a42e4df18b7f60723ef05551','Гайдашова О.А.',0,'72485d086e6346faac8bdfcd49fe745f','Кардиолог','2a85465c0d8d4b9b928646f91fd7ace5','Почеп'),(91,'6e7f08c22f444e3a819acdfc339c1e97','Зезюлина А.П.',0,'15910f987fa0443bb0dc62effe141bd1','Эндокринолог','2a85465c0d8d4b9b928646f91fd7ace5','Почеп'),(92,'413398873b714ce0972df46096e10229','Кожан А.И.',0,'c76375abe5264977833faef9d38bbdeb','Уролог','2a85465c0d8d4b9b928646f91fd7ace5','Почеп'),(93,'190c8f9908df448f96a3b0d1aade2f0f','Левая М.А.',0,'a5c2f60eb1e145f1af95e307b175a5ba','Общее УЗИ + Беременность','2a85465c0d8d4b9b928646f91fd7ace5','Почеп'),(94,'f62f0d96f2104147b9d02fa5b4d10ea9','Соколова И.В.',0,'b9fc34843cbb499d8e05be6c815fee2d','УЗИ сердца, сосудов','2a85465c0d8d4b9b928646f91fd7ace5','Почеп'),(95,'2bbce1dcdf5544128a549a3e3015c4fb','Чирун Е.В.',0,'857bed796d97400e9996ada78c367714','Гинеколог+УЗИ общее','2a85465c0d8d4b9b928646f91fd7ace5','Почеп'),(96,'fc2e2d3f4ab94c36bad19927f7ec843e','Борсук Д.П.',0,'d55d85adca4d4a3da9beb31164a5ba9a','УЗИ','268334bbd12e417ebc3947a94a9d4ba4','Климово'),(97,'75c80468caba4c8288beffe29d4738bc','Костюкевич А.А.',0,'d55d85adca4d4a3da9beb31164a5ba9a','УЗИ','268334bbd12e417ebc3947a94a9d4ba4','Климово'),(98,'c3f37758ef9c4dacbcd670ffa609f783','Шаметько Е.В.',0,'d55d85adca4d4a3da9beb31164a5ba9a','УЗИ','268334bbd12e417ebc3947a94a9d4ba4','Климово'),(99,'41d5d7b0611b4e4091b68ad1c73b3816','Ващенко Е.Н.',0,'c2ed458739ba4582b4e9f4995305219e','Эндокринолог','268334bbd12e417ebc3947a94a9d4ba4','Климово'),(100,'83fb367ace8547e898c05af263a9cfad','Гошкис М.В.',0,'12c935d9d7ed4e25bfe6b7ec6f1d8f5b','Кардиолог+Гастроэнтеролог+ЭКГ','268334bbd12e417ebc3947a94a9d4ba4','Климово'),(101,'3298c2c6d1d74a70be96678b04e47653','Ефимова Н.Н.',0,'12c935d9d7ed4e25bfe6b7ec6f1d8f5b','Кардиолог+Гастроэнтеролог+ЭКГ','268334bbd12e417ebc3947a94a9d4ba4','Климово'),(102,'6cd9f10b416041a5969ba095efc99cef','Дедечко М.П.',0,'9d9cc688edc043ef87699fe0469279a7','Гинеколог, лечение Эрозии','268334bbd12e417ebc3947a94a9d4ba4','Климово'),(103,'953e60c5d9dd4056936fb998c6f048ab','Дорошко Е.А.',0,'7650669f23064fc2b65f32d20c76f7ea','Офтальмология','268334bbd12e417ebc3947a94a9d4ba4','Климово'),(104,'2f52df3d6bea4e64820ee54bd85c3334','Закружная Ю.С.',0,'05898321f2aa437983366484f624383c','Невролог','268334bbd12e417ebc3947a94a9d4ba4','Климово'),(105,'413398873b714ce0972df46096e10229','Кожан А.И.',0,'325766704a9f41c282c0e9bc229aae25','Уролог','268334bbd12e417ebc3947a94a9d4ba4','Климово'),(106,'7e88a75c269b4c26aa384c28f738fd39','Маслова А.Ю.',0,'0d18855ed80f4d429b2dca58d65d6740','Процедурный кабинет','268334bbd12e417ebc3947a94a9d4ba4','Климово'),(107,'67edcaca4b3f4708b1e4b4f7221ae4da','Матусов П.Г.',0,'292477cce5984a7ca63e348811f7c6cc','Флеболог, сосудистый хирург','268334bbd12e417ebc3947a94a9d4ba4','Климово'),(108,'2bbce1dcdf5544128a549a3e3015c4fb','Чирун Е.В.',0,'fe60cee437044034875c9b65b99ca6eb','Гинеколог+УЗИ общее','268334bbd12e417ebc3947a94a9d4ba4','Климово');
/*!40000 ALTER TABLE `z_schedule` ENABLE KEYS */;
UNLOCK TABLES;

--
-- Table structure for table `z_schedule_parsing`
--

DROP TABLE IF EXISTS `z_schedule_parsing`;
/*!40101 SET @saved_cs_client     = @@character_set_client */;
 SET character_set_client = utf8mb4 ;
CREATE TABLE `z_schedule_parsing` (
  `id` int(11) NOT NULL AUTO_INCREMENT,
  `hash` text NOT NULL,
  `person_name` text NOT NULL,
  `workplace_hash` text NOT NULL,
  `workplace_name` text NOT NULL,
  `subdivision_hash` text NOT NULL,
  `subdivision_name` text NOT NULL,
  PRIMARY KEY (`id`)
) ENGINE=InnoDB AUTO_INCREMENT=109 DEFAULT CHARSET=utf8;
/*!40101 SET character_set_client = @saved_cs_client */;

--
-- Dumping data for table `z_schedule_parsing`
--

LOCK TABLES `z_schedule_parsing` WRITE;
/*!40000 ALTER TABLE `z_schedule_parsing` DISABLE KEYS */;
INSERT INTO `z_schedule_parsing` (`id`, `hash`, `person_name`, `workplace_hash`, `workplace_name`, `subdivision_hash`, `subdivision_name`) VALUES (1,'8ff62746dcf94cf2b986c650dab12684','Азаренков А.В.','41e0844279ef46ec92276a3a0cb5dae9','Кардиолог+УЗИ сердца','f041c4c2da484ea0aa5b7cc8d91dc798','Тучково'),(2,'6aba8354e556483e975e14b2adcbdaf3','Барсукова Е.О.','ec399761507840de9e15b3c7f8fa0ae8','УЗИ','f041c4c2da484ea0aa5b7cc8d91dc798','Тучково'),(3,'7271d473d48f489dbce13952d9c07b5a','Бриллиантова Н.Н.','ec399761507840de9e15b3c7f8fa0ae8','УЗИ','f041c4c2da484ea0aa5b7cc8d91dc798','Тучково'),(4,'766ebe165d6a4cfc83fd6760cd85dcf7','Егельская В.К.','ec399761507840de9e15b3c7f8fa0ae8','УЗИ','f041c4c2da484ea0aa5b7cc8d91dc798','Тучково'),(5,'e4b9bd5fba0c4c048e8d90f4aa32c4ec','Кучейник В.И.','ec399761507840de9e15b3c7f8fa0ae8','УЗИ','f041c4c2da484ea0aa5b7cc8d91dc798','Тучково'),(6,'2d9b9478bf9244bfb3bb1e2dec720bec','Богнат Р.П.','57491828e8284e4597daabd9cf661764','УЗИ детям','f041c4c2da484ea0aa5b7cc8d91dc798','Тучково'),(7,'88fa0c3258ce44839ac2966cc48a0451','Ванян А.О.','f3762f8c64df4d2f87a1411439f0695d','Эндокринология','f041c4c2da484ea0aa5b7cc8d91dc798','Тучково'),(8,'b7300926ac3c4cdd99a132f3b29938b6','Чайкина И.В.','f3762f8c64df4d2f87a1411439f0695d','Эндокринология','f041c4c2da484ea0aa5b7cc8d91dc798','Тучково'),(9,'9ffc57b83be94e01995e624ab39796cf','Гаглоева З.Р.','4a4551b61e5542af81eb066a4cb871f2','Гастроэнтеролог+УЗИ бр.п.','f041c4c2da484ea0aa5b7cc8d91dc798','Тучково'),(10,'fe789aeccc7e46e4ad4048d5ebcb4e16','Гадаев И.Ю.','a832bdb481a84241ae8cf3576aad65e1','Терапевт, Гематолог','f041c4c2da484ea0aa5b7cc8d91dc798','Тучково'),(11,'141098d83b2147d192e7b71512255416','Екатеринчев В.А.','0f67cf4e3be34025adcc2b526dde9724','ЛОР','f041c4c2da484ea0aa5b7cc8d91dc798','Тучково'),(12,'9024a5a884ef4876a975f198cfb5677b','Яковлев Д.А.','0f67cf4e3be34025adcc2b526dde9724','ЛОР','f041c4c2da484ea0aa5b7cc8d91dc798','Тучково'),(13,'8d7e73613fe043deaf995ee5037aed0d','Елизарова Д.В.','3cdfc0f0db054598bc37a50d9be0e02b','Неврология','f041c4c2da484ea0aa5b7cc8d91dc798','Тучково'),(14,'9e55c2cde8244936b11350b36aaeece1','Пустынников Я.А.','3cdfc0f0db054598bc37a50d9be0e02b','Неврология','f041c4c2da484ea0aa5b7cc8d91dc798','Тучково'),(15,'2eed78695e0b456b8526af478d4c6277','Лебедев С.В.','3bdc8187c82641cab412dbdbbe3e2925','Маммолог, Удаления','f041c4c2da484ea0aa5b7cc8d91dc798','Тучково'),(16,'5cd5f1645f3d489984434b6215e07d47','Максимова О.В.','b212616b89484fa3957ffe30ee21dd85','Педиатрия','f041c4c2da484ea0aa5b7cc8d91dc798','Тучково'),(17,'8304747f13a24e988c4def60a882d828','Меркулова М.Д.','4f5c759e776344bab43a06cf718ef650','Гинекология','f041c4c2da484ea0aa5b7cc8d91dc798','Тучково'),(18,'600b7de898b44baa9da75f3f3571a95c','Никулкова Л.К.','7e86155fa9454ee68c4e2b5754b1c6b4','Аллергология','f041c4c2da484ea0aa5b7cc8d91dc798','Тучково'),(19,'8c3e894edab749889ddd3ff3fa8a4940','Перфилов С.В.','ce948f2b6fee4c5494d413a51bee515b','Гастроскопия','f041c4c2da484ea0aa5b7cc8d91dc798','Тучково'),(20,'d8689b5d582549f884dadfc0a00d0564','Покусаева Д.П.','72c58bbddd6447f888337ece61f7453b','УЗИ сердца, общее узи','f041c4c2da484ea0aa5b7cc8d91dc798','Тучково'),(21,'be8324561bb64da1a0d29b2ef1baaf0e','Попов И.В.','dbb256a83c354b77b1e176f1f43e7131','Дерматолог+Удаления','f041c4c2da484ea0aa5b7cc8d91dc798','Тучково'),(22,'be8324561bb64da1a0d29b2ef1baaf0e','Попов И.В.','a1385764c0dc464d80a9e99ac61276dc','Косметология','f041c4c2da484ea0aa5b7cc8d91dc798','Тучково'),(23,'737a56f99c304e4b9ea739ceaf2d13b6','Усиков А.Н.','43b6f1e6b66643c487df9c664f55f277','Уролог+УЗИ в Урологии','f041c4c2da484ea0aa5b7cc8d91dc798','Тучково'),(24,'2646d1c2d8c6418fb413f12aee9ef79a','Щербанина В.Ю.','1856be9ff11c4232b9f63f844a099152','УЗИ сосудов, нервов','f041c4c2da484ea0aa5b7cc8d91dc798','Тучково'),(25,'8d7e73613fe043deaf995ee5037aed0d','Елизарова Д.В.','2f31a4c9f4eb47ae99c6594cfb94ec2f','Невролог','5cc8fea2ed2f483282c9fdd2a4a84341','Руза'),(26,'8ff62746dcf94cf2b986c650dab12684','Азаренков А.В.','729149faa9944726a6d0023f5960f429','УЗИ сердца','5cc8fea2ed2f483282c9fdd2a4a84341','Руза'),(27,'d8689b5d582549f884dadfc0a00d0564','Покусаева Д.П.','729149faa9944726a6d0023f5960f429','УЗИ сердца','5cc8fea2ed2f483282c9fdd2a4a84341','Руза'),(28,'6aba8354e556483e975e14b2adcbdaf3','Барсукова Е.О.','117715832de743a5892da1ab7b6461e3','УЗИ','5cc8fea2ed2f483282c9fdd2a4a84341','Руза'),(29,'7271d473d48f489dbce13952d9c07b5a','Бриллиантова Н.Н.','117715832de743a5892da1ab7b6461e3','УЗИ','5cc8fea2ed2f483282c9fdd2a4a84341','Руза'),(30,'2d9b9478bf9244bfb3bb1e2dec720bec','Богнат Р.П.','5ea44f3fb51648efbf7b2d79668d9053','УЗИ детям','5cc8fea2ed2f483282c9fdd2a4a84341','Руза'),(31,'88fa0c3258ce44839ac2966cc48a0451','Ванян А.О.','191287a61ccb4a109407e67a071b7dd4','Эндокринология','5cc8fea2ed2f483282c9fdd2a4a84341','Руза'),(32,'d7acf622c067480a94f56c8c352db78c','Гурко А.М.','1b0165ad9359464f8140735d922fee46','Проктолог+Хирург','5cc8fea2ed2f483282c9fdd2a4a84341','Руза'),(33,'bddfd7eef2874e1f8a7855be75058491','Домнина С.М.','5733693f6e7244b5ba8184d7237a2054','Педиатр','5cc8fea2ed2f483282c9fdd2a4a84341','Руза'),(34,'2eed78695e0b456b8526af478d4c6277','Лебедев С.В.','1dce28c288d54283b282b454b80423da','Маммолог, Удаления','5cc8fea2ed2f483282c9fdd2a4a84341','Руза'),(35,'8304747f13a24e988c4def60a882d828','Меркулова М.Д.','326e1037165e464ca3b8d0d7a56bdb81','Гинекология+УЗИ в гинекологии','5cc8fea2ed2f483282c9fdd2a4a84341','Руза'),(36,'616641c7bf2742d5af4e4b693ae61a85','Чепелкин В.Ю.','0ead6d01d0a648dc9b8d6fb5c3d0e53b','Детский Ортопед, Хирург','5cc8fea2ed2f483282c9fdd2a4a84341','Руза'),(37,'2646d1c2d8c6418fb413f12aee9ef79a','Щербанина В.Ю.','ac647a4b3c8948fe93708eeb39d8e795','УЗИ сосудов, нервов','5cc8fea2ed2f483282c9fdd2a4a84341','Руза'),(38,'9024a5a884ef4876a975f198cfb5677b','Яковлев Д.А.','2ed2d9fc2a9c48d19e4c33d8c25c6908','ЛОР','5cc8fea2ed2f483282c9fdd2a4a84341','Руза'),(39,'7e3fd524b3f8478c9b53e6d4a934d46c','Ватоян М.А.','1779e884dd7145bf921ebb13d89354b3','Гинекология+УЗИ','19d6da22f59a4d82b8840fc95db5c4e7','Сафоново'),(40,'c5dff729eaee4a5d925f988e103995cf','Громакова Е.Ф.','7ff57ddf0b2d4404841bcccee7ddfc66','Кардиолог, УЗИ сердца, ЭКГ','19d6da22f59a4d82b8840fc95db5c4e7','Сафоново'),(41,'eb6eaed620f54826b7eb301b6f446ba3','Скрицкий В.С.','7ff57ddf0b2d4404841bcccee7ddfc66','Кардиолог, УЗИ сердца, ЭКГ','19d6da22f59a4d82b8840fc95db5c4e7','Сафоново'),(42,'382a01f9dc074788a7797b52bc2cc545','Ошерова М.В.','0d74e41bb52c4cd590e78462e3e99006','УЗИ','19d6da22f59a4d82b8840fc95db5c4e7','Сафоново'),(43,'37da73f8fee24e589d9251a825dd4157','Титова Л.Л.','d497e39c69ce48a485249144cccb6a9b','Невролог','19d6da22f59a4d82b8840fc95db5c4e7','Сафоново'),(44,'41d5d7b0611b4e4091b68ad1c73b3816','Ващенко Е.Н.','e1f7a2536c224fa3b1962e83b833c831','Эндокринолог','41ddca448e2d45b9ac99d6bcb551161e','Стародуб'),(45,'934f6d81a42e4df18b7f60723ef05551','Гайдашова О.А.','9a6e041d85d441ceb593899efdb15daa','Кардиолог','41ddca448e2d45b9ac99d6bcb551161e','Стародуб'),(46,'c5dff729eaee4a5d925f988e103995cf','Громакова Е.Ф.','22d6ddda8dfa46b9982b2de39b2911b6','Кардиолог+УЗИ сердца+ЭКГ','41ddca448e2d45b9ac99d6bcb551161e','Стародуб'),(47,'413398873b714ce0972df46096e10229','Кожан А.И.','775062b91f584fc38cd50b0bfff096d0','Уролог','41ddca448e2d45b9ac99d6bcb551161e','Стародуб'),(48,'c5191f6270984f0b9e81d818a64702c9','Лощ И.Е.','6cb0ba61f8064f90b9fdfe1165b4f00c','Гинеколог','41ddca448e2d45b9ac99d6bcb551161e','Стародуб'),(49,'bfc81bc750f94687b37157184045809b','Смирнов В.С.','1f98934ff3e946f095a18f651e640a42','НЕВРОЛОГ','41ddca448e2d45b9ac99d6bcb551161e','Стародуб'),(50,'f62f0d96f2104147b9d02fa5b4d10ea9','Соколова И.В.','28c7b0f901cf4839928629419e2ede70','УЗИ сердца, сосудов','41ddca448e2d45b9ac99d6bcb551161e','Стародуб'),(51,'2bbce1dcdf5544128a549a3e3015c4fb','Чирун Е.В.','10a6206ca75c4b19b7a1c1b27424c215','Гинеколог+УЗИ общее','41ddca448e2d45b9ac99d6bcb551161e','Стародуб'),(52,'e3d56b1abf05410c82e9c0c359320287','Азаренков А.В.','5b7e95a0504b4ea49ebdc8cee07e7118','4 Кардиология+УЗИ сердца','1722cf1e95a345fc8863dfe6a48ac0d3','Гагарин'),(53,'c5dff729eaee4a5d925f988e103995cf','Громакова Е.Ф.','5b7e95a0504b4ea49ebdc8cee07e7118','4 Кардиология+УЗИ сердца','1722cf1e95a345fc8863dfe6a48ac0d3','Гагарин'),(54,'2d9b9478bf9244bfb3bb1e2dec720bec','Богнат Р.П.','5ca0e8d476444f68aff481f386584ceb','2 УЗИ сосудов+общее+ДЕТИ','1722cf1e95a345fc8863dfe6a48ac0d3','Гагарин'),(55,'e4b9bd5fba0c4c048e8d90f4aa32c4ec','Кучейник В.И.','5ca0e8d476444f68aff481f386584ceb','2 УЗИ сосудов+общее+ДЕТИ','1722cf1e95a345fc8863dfe6a48ac0d3','Гагарин'),(56,'2646d1c2d8c6418fb413f12aee9ef79a','Щербанина В.Ю.','5ca0e8d476444f68aff481f386584ceb','2 УЗИ сосудов+общее+ДЕТИ','1722cf1e95a345fc8863dfe6a48ac0d3','Гагарин'),(57,'6e47b1734f7b4e63a8252ec539b4342d','Ванян А.О.','e20ae40d9c4d40d18210208412383c2b','Эндокринология','1722cf1e95a345fc8863dfe6a48ac0d3','Гагарин'),(58,'7e3fd524b3f8478c9b53e6d4a934d46c','Ватоян М.А.','b4f105d9f223496ea20b66589f6ea4f1','3 Гинекология+УЗИ в гинекологии','1722cf1e95a345fc8863dfe6a48ac0d3','Гагарин'),(59,'d7acf622c067480a94f56c8c352db78c','Гурко А.М.','d7c0246a72d74d42b932490471e0247e','Проктолог+хирург','1722cf1e95a345fc8863dfe6a48ac0d3','Гагарин'),(60,'141098d83b2147d192e7b71512255416','Екатеринчев В.А.','39a9900c25304f1b884cab12165a5068','ЛОР','1722cf1e95a345fc8863dfe6a48ac0d3','Гагарин'),(61,'2eed78695e0b456b8526af478d4c6277','Лебедев С.В.','e715da9a70cb4a66b27e963224a3a796','5 Маммолог, Удаления','1722cf1e95a345fc8863dfe6a48ac0d3','Гагарин'),(62,'48d451f7f4594c03928242b07f3b3b40','Малахов А.М.','53d069f2ebc545ffac1d19aaa548dc94','Урология+УЗИ общее+ТРУЗИ','1722cf1e95a345fc8863dfe6a48ac0d3','Гагарин'),(63,'f2d14cd891d9499c96849ebfaf53af00','Перфилов С.В.','7eff5c99172047d6b7f482ddbd80124a','Гастроэнтерология, эндоскопия','1722cf1e95a345fc8863dfe6a48ac0d3','Гагарин'),(64,'f4c0b2b1865d4ddaae1f2242bfa6fe9d','Пустынников Я.А.','273c1e35a04f4cfcaad6743e6024947e','Неврология','1722cf1e95a345fc8863dfe6a48ac0d3','Гагарин'),(65,'616641c7bf2742d5af4e4b693ae61a85','Чепелкин В.Ю.','ae9de30777224a10bd9dd1d892de808e','Детский Ортопед, Хирург','1722cf1e95a345fc8863dfe6a48ac0d3','Гагарин'),(66,'41d5d7b0611b4e4091b68ad1c73b3816','Ващенко Е.Н.','be910732a37442849fc0a04a0b13a9a8','Эндокринолог','3e68757c2faa460f8f0410d4fc90ce05','Клинцы'),(67,'67edcaca4b3f4708b1e4b4f7221ae4da','Матусов П.Г.','c0fbd28bd85f4a8a9d96993d87a80fbd','Флеболог, сосудистый хирург','3e68757c2faa460f8f0410d4fc90ce05','Клинцы'),(68,'aa0ae02d5e734cd7aa5c1562cb2b6036','Родина Е.В.','a1b8fbfed7004c168f2f6c64457552d4','Кардиолог+УЗИ+ЭКГ','3e68757c2faa460f8f0410d4fc90ce05','Клинцы'),(69,'bfc81bc750f94687b37157184045809b','Смирнов В.С.','a232690e6fab4720818b7684c87e9049','Невролог','3e68757c2faa460f8f0410d4fc90ce05','Клинцы'),(70,'2bbce1dcdf5544128a549a3e3015c4fb','Чирун Е.В.','c4ec4a83f2fc4292a16e78198fc79484','Гинеколог+УЗИ общее','3e68757c2faa460f8f0410d4fc90ce05','Клинцы'),(71,'c3f37758ef9c4dacbcd670ffa609f783','Шаметько Е.В.','eed492b6b06e4838af9b4da4ed661696','Гастроэнтеролог, Гастроскопия, УЗИ','3e68757c2faa460f8f0410d4fc90ce05','Клинцы'),(72,'c5dff729eaee4a5d925f988e103995cf','Громакова Е.Ф.','fd99f9b1314d4f7ab292aa8b3fd79058','Кардиолог+УЗИ сердца+ЭКГ','76563309d6244354b748057237bda61f','Новозыбков'),(73,'df1bcbc03f654c4e8f0eb53a2526b865','Абраменко Д.М.','7761f716119e4e439a1bc89396dec7dd','УЗИ суставов, общее, сосуды, сердце','76563309d6244354b748057237bda61f','Новозыбков'),(74,'cd584543da3742f1a374ddcad556c235','Автушенко Н.В.','88c9b886c5dc4c03a1b2011057a234a7','Аллерголог','76563309d6244354b748057237bda61f','Новозыбков'),(75,'fc2e2d3f4ab94c36bad19927f7ec843e','Борсук Д.П.','42563927ca1347139eea5f93e5fc636d','УЗИ сердца, сосудов, общее','76563309d6244354b748057237bda61f','Новозыбков'),(76,'bb40729cfcdf4f3182c4ac787dda8cb6','Быстревский В.А.','154ab730109d4fbba4b367e4709ca014','Уролог+УЗИ в урологии','76563309d6244354b748057237bda61f','Новозыбков'),(77,'41d5d7b0611b4e4091b68ad1c73b3816','Ващенко Е.Н.','10d3550f143c45a99833aa9eea3c1c68','Эндокринолог','76563309d6244354b748057237bda61f','Новозыбков'),(78,'6cd9f10b416041a5969ba095efc99cef','Дедечко М.П.','c756fc3124324a0fb25246e8cc7ea35a','Гинеколог+Лечение эрозии','76563309d6244354b748057237bda61f','Новозыбков'),(79,'3298c2c6d1d74a70be96678b04e47653','Ефимова Н.Н.','472e351ac65d474d9e572f030733e908','Кардиолог+Гастроэнтеролог+ЭКГ','76563309d6244354b748057237bda61f','Новозыбков'),(80,'2f52df3d6bea4e64820ee54bd85c3334','Закружная Ю.С.','1fe00086a4064f648e3c3dc07d579cf6','Невролог','76563309d6244354b748057237bda61f','Новозыбков'),(81,'bfc81bc750f94687b37157184045809b','Смирнов В.С.','1fe00086a4064f648e3c3dc07d579cf6','Невролог','76563309d6244354b748057237bda61f','Новозыбков'),(82,'67edcaca4b3f4708b1e4b4f7221ae4da','Матусов П.Г.','cb71c09e09af42e8ad03f6ee69e042f7','Флеболог, сосудистый хирург','76563309d6244354b748057237bda61f','Новозыбков'),(83,'b4d10ad8b8a64f2c9ef4714aae822b0b','Окунцев Д.В.','3765ce681fac4333a21ca7820816cbee','Онколог, удаление новообразований','76563309d6244354b748057237bda61f','Новозыбков'),(84,'cef3405280f9430cbd51d2908bc62569','Родина Е.В.','fc64c02f4d244a119abcd393a6599fbc','Кардиолог+УЗИ всего+ЭКГ','76563309d6244354b748057237bda61f','Новозыбков'),(85,'2bbce1dcdf5544128a549a3e3015c4fb','Чирун Е.В.','95eff1d9227d4e73960a38b1d3834ef8','Гинеколог+УЗИ общее','76563309d6244354b748057237bda61f','Новозыбков'),(86,'c3f37758ef9c4dacbcd670ffa609f783','Шаметько Е.В.','7bd28bde0d264b98b0370bf8edbf75ab','Гастроэнтеролог, УЗИ общее','76563309d6244354b748057237bda61f','Новозыбков'),(87,'1f8f26fc0ddf48af95abe0f9773aceeb','Ядченко Е.С.','9a2ed8fa3e144cbd87bd974b8a906897','ЛОР','76563309d6244354b748057237bda61f','Новозыбков'),(88,'9f5b4c7848594305a2e4189cceee429d','Большаков А.Н.','fa899ccbf59246489a60167c15375222','Невролог','2a85465c0d8d4b9b928646f91fd7ace5','Почеп'),(89,'12203c6c71c64e19af9d65797d8a097b','Большакова Т.В.','5dc387812b384551a96c8b9ec87d5760','ЛОР Почеп','2a85465c0d8d4b9b928646f91fd7ace5','Почеп'),(90,'934f6d81a42e4df18b7f60723ef05551','Гайдашова О.А.','72485d086e6346faac8bdfcd49fe745f','Кардиолог','2a85465c0d8d4b9b928646f91fd7ace5','Почеп'),(91,'6e7f08c22f444e3a819acdfc339c1e97','Зезюлина А.П.','15910f987fa0443bb0dc62effe141bd1','Эндокринолог','2a85465c0d8d4b9b928646f91fd7ace5','Почеп'),(92,'413398873b714ce0972df46096e10229','Кожан А.И.','c76375abe5264977833faef9d38bbdeb','Уролог','2a85465c0d8d4b9b928646f91fd7ace5','Почеп'),(93,'190c8f9908df448f96a3b0d1aade2f0f','Левая М.А.','a5c2f60eb1e145f1af95e307b175a5ba','Общее УЗИ + Беременность','2a85465c0d8d4b9b928646f91fd7ace5','Почеп'),(94,'f62f0d96f2104147b9d02fa5b4d10ea9','Соколова И.В.','b9fc34843cbb499d8e05be6c815fee2d','УЗИ сердца, сосудов','2a85465c0d8d4b9b928646f91fd7ace5','Почеп'),(95,'2bbce1dcdf5544128a549a3e3015c4fb','Чирун Е.В.','857bed796d97400e9996ada78c367714','Гинеколог+УЗИ общее','2a85465c0d8d4b9b928646f91fd7ace5','Почеп'),(96,'fc2e2d3f4ab94c36bad19927f7ec843e','Борсук Д.П.','d55d85adca4d4a3da9beb31164a5ba9a','УЗИ','268334bbd12e417ebc3947a94a9d4ba4','Климово'),(97,'75c80468caba4c8288beffe29d4738bc','Костюкевич А.А.','d55d85adca4d4a3da9beb31164a5ba9a','УЗИ','268334bbd12e417ebc3947a94a9d4ba4','Климово'),(98,'c3f37758ef9c4dacbcd670ffa609f783','Шаметько Е.В.','d55d85adca4d4a3da9beb31164a5ba9a','УЗИ','268334bbd12e417ebc3947a94a9d4ba4','Климово'),(99,'41d5d7b0611b4e4091b68ad1c73b3816','Ващенко Е.Н.','c2ed458739ba4582b4e9f4995305219e','Эндокринолог','268334bbd12e417ebc3947a94a9d4ba4','Климово'),(100,'83fb367ace8547e898c05af263a9cfad','Гошкис М.В.','12c935d9d7ed4e25bfe6b7ec6f1d8f5b','Кардиолог+Гастроэнтеролог+ЭКГ','268334bbd12e417ebc3947a94a9d4ba4','Климово'),(101,'3298c2c6d1d74a70be96678b04e47653','Ефимова Н.Н.','12c935d9d7ed4e25bfe6b7ec6f1d8f5b','Кардиолог+Гастроэнтеролог+ЭКГ','268334bbd12e417ebc3947a94a9d4ba4','Климово'),(102,'6cd9f10b416041a5969ba095efc99cef','Дедечко М.П.','9d9cc688edc043ef87699fe0469279a7','Гинеколог, лечение Эрозии','268334bbd12e417ebc3947a94a9d4ba4','Климово'),(103,'953e60c5d9dd4056936fb998c6f048ab','Дорошко Е.А.','7650669f23064fc2b65f32d20c76f7ea','Офтальмология','268334bbd12e417ebc3947a94a9d4ba4','Климово'),(104,'2f52df3d6bea4e64820ee54bd85c3334','Закружная Ю.С.','05898321f2aa437983366484f624383c','Невролог','268334bbd12e417ebc3947a94a9d4ba4','Климово'),(105,'413398873b714ce0972df46096e10229','Кожан А.И.','325766704a9f41c282c0e9bc229aae25','Уролог','268334bbd12e417ebc3947a94a9d4ba4','Климово'),(106,'7e88a75c269b4c26aa384c28f738fd39','Маслова А.Ю.','0d18855ed80f4d429b2dca58d65d6740','Процедурный кабинет','268334bbd12e417ebc3947a94a9d4ba4','Климово'),(107,'67edcaca4b3f4708b1e4b4f7221ae4da','Матусов П.Г.','292477cce5984a7ca63e348811f7c6cc','Флеболог, сосудистый хирург','268334bbd12e417ebc3947a94a9d4ba4','Климово'),(108,'2bbce1dcdf5544128a549a3e3015c4fb','Чирун Е.В.','fe60cee437044034875c9b65b99ca6eb','Гинеколог+УЗИ общее','268334bbd12e417ebc3947a94a9d4ba4','Климово');
/*!40000 ALTER TABLE `z_schedule_parsing` ENABLE KEYS */;
UNLOCK TABLES;
/*!40103 SET TIME_ZONE=@OLD_TIME_ZONE */;

/*!40101 SET SQL_MODE=@OLD_SQL_MODE */;
/*!40014 SET FOREIGN_KEY_CHECKS=@OLD_FOREIGN_KEY_CHECKS */;
/*!40014 SET UNIQUE_CHECKS=@OLD_UNIQUE_CHECKS */;
/*!40101 SET CHARACTER_SET_CLIENT=@OLD_CHARACTER_SET_CLIENT */;
/*!40101 SET CHARACTER_SET_RESULTS=@OLD_CHARACTER_SET_RESULTS */;
/*!40101 SET COLLATION_CONNECTION=@OLD_COLLATION_CONNECTION */;
/*!40111 SET SQL_NOTES=@OLD_SQL_NOTES */;

-- Dump completed on 2019-03-06 13:58:21
