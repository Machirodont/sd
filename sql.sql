-- MySQL dump 10.13  Distrib 5.6.38, for Win32 (AMD64)
--
-- Host: localhost    Database: yii
-- ------------------------------------------------------
-- Server version	5.6.38

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
-- Table structure for table `sd_clinics`
--

DROP TABLE IF EXISTS `sd_clinics`;
/*!40101 SET @saved_cs_client     = @@character_set_client */;
/*!40101 SET character_set_client = utf8 */;
CREATE TABLE `sd_clinics` (
  `id` int(11) NOT NULL AUTO_INCREMENT,
  `city` text NOT NULL COMMENT 'город',
  `region` text COMMENT 'район',
  `address` text COMMENT 'адрес клиники',
  `phone` text COMMENT 'телефон клиники',
  `hash_id` text,
  `companyPage` int(11) DEFAULT NULL,
  PRIMARY KEY (`id`),
  UNIQUE KEY `hash_id` (`hash_id`(32))
) ENGINE=InnoDB AUTO_INCREMENT=10 DEFAULT CHARSET=utf8;
/*!40101 SET character_set_client = @saved_cs_client */;

--
-- Dumping data for table `sd_clinics`
--

LOCK TABLES `sd_clinics` WRITE;
/*!40000 ALTER TABLE `sd_clinics` DISABLE KEYS */;
INSERT INTO `sd_clinics` (`id`, `city`, `region`, `address`, `phone`, `hash_id`, `companyPage`) VALUES (1,'Тучково',NULL,NULL,'+7(915) 480-03-03','f041c4c2da484ea0aa5b7cc8d91dc798',2),(2,'Руза',NULL,NULL,'+7(915) 480-03-03','5cc8fea2ed2f483282c9fdd2a4a84341',3),(3,'Сафоново',NULL,NULL,NULL,'19d6da22f59a4d82b8840fc95db5c4e7',NULL),(4,'Стародуб',NULL,NULL,NULL,'41ddca448e2d45b9ac99d6bcb551161e',NULL),(5,'Гагарин',NULL,NULL,'+7(915) 650-03-03','1722cf1e95a345fc8863dfe6a48ac0d3',4),(6,'Клинцы',NULL,NULL,NULL,'3e68757c2faa460f8f0410d4fc90ce05',NULL),(7,'Новозыбков',NULL,NULL,NULL,'76563309d6244354b748057237bda61f',NULL),(8,'Почеп',NULL,NULL,NULL,'2a85465c0d8d4b9b928646f91fd7ace5',NULL),(9,'Климово',NULL,NULL,NULL,'268334bbd12e417ebc3947a94a9d4ba4',NULL);
/*!40000 ALTER TABLE `sd_clinics` ENABLE KEYS */;
UNLOCK TABLES;

--
-- Table structure for table `sd_html_block`
--

DROP TABLE IF EXISTS `sd_html_block`;
/*!40101 SET @saved_cs_client     = @@character_set_client */;
/*!40101 SET character_set_client = utf8 */;
CREATE TABLE `sd_html_block` (
  `id` int(11) NOT NULL AUTO_INCREMENT,
  `itemKey` int(11) NOT NULL,
  `itemTable` text NOT NULL,
  `html` text NOT NULL,
  `order` text NOT NULL,
  PRIMARY KEY (`id`)
) ENGINE=InnoDB AUTO_INCREMENT=39 DEFAULT CHARSET=utf8;
/*!40101 SET character_set_client = @saved_cs_client */;

--
-- Dumping data for table `sd_html_block`
--

LOCK TABLES `sd_html_block` WRITE;
/*!40000 ALTER TABLE `sd_html_block` DISABLE KEYS */;
INSERT INTO `sd_html_block` (`id`, `itemKey`, `itemTable`, `html`, `order`) VALUES (1,5,'sd_persons','HTML BLOCK 1','1'),(2,5,'sd_persons','view::/pages/_2_test','2'),(3,1,'sd_pages','view::/pages/_3_main_page','1'),(4,1,'sd_clinics','view::/pages/_contacts_tuchkovo','1'),(5,2,'sd_clinics','view::/pages/_contacts_ruza','1'),(6,5,'sd_clinics','view::/pages/_contacts_gagarin','1'),(7,2,'sd_pages','view::/pages/_yridicheskaya_info_ruza','1'),(8,3,'sd_pages','view::/pages/_yridicheskaya_info_ruza','1'),(9,4,'sd_pages','view::/pages/_yridicheskaya_info_gagarin','1'),(10,5,'sd_pages','view::/pages/_10_rezus_konflikt','1'),(11,6,'sd_pages','view::/pages/_11_test_na_otsovstvo','1'),(12,7,'sd_pages','view::/pages/_12_prena_test','1'),(13,8,'sd_pages','view::/pages/_13_pol_rebenka','1'),(14,9,'sd_pages','view::/pages/_14_lazernaya_medicina_vlok','1'),(15,10,'sd_pages','view::/pages/_15_prenatalnyi_geneticheskiy_test','1'),(16,11,'sd_pages','view::/pages/_16_holter_eeg_ekg','1'),(17,12,'sd_pages','view::/pages/_17_ekg','1'),(18,13,'sd_pages','view::/pages/_18_podgotovka_k_uzi','1'),(19,14,'sd_pages','view::/pages/_19_podgotovka_k_analizam','1'),(20,15,'sd_pages','view::/pages/_20_ginekologya','1'),(21,10,'sd_persons','view::/pages/_21_endokrinolog_vanyan','1'),(22,16,'sd_pages','view::/pages/_22_endokrinologiya','1'),(23,16,'sd_persons','view::/pages/_23_gematolog_gadaev','1'),(24,9,'sd_persons','view::/pages/_24_mammolog_lebedev','1'),(25,17,'sd_persons','view::/pages/_25_nevrolog_elizarova','1'),(26,17,'sd_pages','view::/pages/_26_nevrologia','1'),(27,18,'sd_persons','view::/pages/_27_lor_jakovlev','1'),(28,18,'sd_pages','view::/pages/_28_otolaringologia','1'),(29,19,'sd_persons','view::/pages/_29_pediatr_maximova','1'),(30,21,'sd_persons','view::/pages/_30_urolog_zunnunuv','1'),(31,11,'sd_persons','view::/pages/_31_urolog_usikov','1'),(32,19,'sd_pages','view::/pages/_32_urologia','1'),(33,20,'sd_pages','view::/pages/_33_uzi_pri_beremennosti','1'),(34,21,'sd_pages','view::/pages/_34_neirosonografiya','1'),(35,23,'sd_persons','view::/pages/_35_uzi_sosudov_sherbanina','1'),(36,22,'sd_pages','view::/pages/_36_ehokardiografia','1'),(37,8,'sd_persons','view::/pages/_37_kosmetolog_leonenko','1'),(38,23,'sd_pages','view::/pages/_38_udalenie_novoobrazovanii','1');
/*!40000 ALTER TABLE `sd_html_block` ENABLE KEYS */;
UNLOCK TABLES;

--
-- Table structure for table `sd_institutions`
--

DROP TABLE IF EXISTS `sd_institutions`;
/*!40101 SET @saved_cs_client     = @@character_set_client */;
/*!40101 SET character_set_client = utf8 */;
CREATE TABLE `sd_institutions` (
  `institution_id` int(11) NOT NULL AUTO_INCREMENT,
  `name` text COMMENT 'название заведения',
  `shortname` text COMMENT 'сокращенное название заведения',
  PRIMARY KEY (`institution_id`)
) ENGINE=InnoDB AUTO_INCREMENT=21 DEFAULT CHARSET=utf8 COMMENT='Места основной работы специалистов клиники';
/*!40101 SET character_set_client = @saved_cs_client */;

--
-- Dumping data for table `sd_institutions`
--

LOCK TABLES `sd_institutions` WRITE;
/*!40000 ALTER TABLE `sd_institutions` DISABLE KEYS */;
INSERT INTO `sd_institutions` (`institution_id`, `name`, `shortname`) VALUES (1,'Московский Государственный Университет им. М.В.Ломоносова','МГУ'),(2,'Первый Московский государственный медицинский университет имени И.М. Сеченова','Первый МГМУ им. И.М. Сеченова'),(3,'Национальный медико-хирургический Центр им. Н.И. Пирогова',''),(4,'Московский научно-практический центр дерматовенерологии и косметологии',''),(5,'Центр планирования семьи и репродукции Москвы','ЦПСиР г. Москва'),(6,'Московский государственный медико-стоматологический университет','МГМСУ'),(7,'Государственный научный центр “Институт иммунологии” Федерального медико-биологического агентства','ГНЦ Институт иммунологии ФМБА России'),(8,'Московский областной научно-исследовательский клинический институт им. М.Ф.Владимирского','МОНИКИ'),(9,'Университетская клиническая больница №2','УКБ №2'),(10,'Клиника ЭКО Альтравита',''),(11,'Научно-исследовательский институт клинической кардиологии им. А.Л. Мясникова','НИИ клинической кардиологии'),(12,'Можайская центральная районная больница','ГБУЗ МО Можайская ЦРБ'),(13,'Иркустский Государственный Медицинский Университет','ИГМУ'),(14,'Главный военный клинический госпиталь имени академика Н.Н. Бурденко','ГВКГ'),(15,'Российский Университет Дружбы Народов','РУДН'),(16,'Городская клиническая больница №36 им.Иноземцева, г.Москва','Московская клиническая больница №36'),(17,'Университетская клиническая больница №1','УКБ №1'),(18,'Санкт-Петербургская Государственная Медицинская Академия им.Мечникова',''),(19,'Куйбышевский медицинский институт им. Д.И. Ульянова',''),(20,'Российский государственный медицинский университет им. Н.И.Пирогова','');
/*!40000 ALTER TABLE `sd_institutions` ENABLE KEYS */;
UNLOCK TABLES;

--
-- Table structure for table `sd_loaded_schedules`
--

DROP TABLE IF EXISTS `sd_loaded_schedules`;
/*!40101 SET @saved_cs_client     = @@character_set_client */;
/*!40101 SET character_set_client = utf8 */;
CREATE TABLE `sd_loaded_schedules` (
  `fileName` tinytext NOT NULL,
  `parsed` tinyint(4) NOT NULL DEFAULT '0',
  PRIMARY KEY (`fileName`(63))
) ENGINE=InnoDB DEFAULT CHARSET=utf8;
/*!40101 SET character_set_client = @saved_cs_client */;

--
-- Dumping data for table `sd_loaded_schedules`
--

LOCK TABLES `sd_loaded_schedules` WRITE;
/*!40000 ALTER TABLE `sd_loaded_schedules` DISABLE KEYS */;
INSERT INTO `sd_loaded_schedules` (`fileName`, `parsed`) VALUES ('schedule.json',0);
/*!40000 ALTER TABLE `sd_loaded_schedules` ENABLE KEYS */;
UNLOCK TABLES;

--
-- Table structure for table `sd_pages`
--

DROP TABLE IF EXISTS `sd_pages`;
/*!40101 SET @saved_cs_client     = @@character_set_client */;
/*!40101 SET character_set_client = utf8 */;
CREATE TABLE `sd_pages` (
  `id` int(11) NOT NULL AUTO_INCREMENT,
  `title` text,
  `description` text,
  `keywords` text,
  PRIMARY KEY (`id`)
) ENGINE=InnoDB AUTO_INCREMENT=24 DEFAULT CHARSET=utf8;
/*!40101 SET character_set_client = @saved_cs_client */;

--
-- Dumping data for table `sd_pages`
--

LOCK TABLES `sd_pages` WRITE;
/*!40000 ALTER TABLE `sd_pages` DISABLE KEYS */;
INSERT INTO `sd_pages` (`id`, `title`, `description`, `keywords`) VALUES (1,'Главная страница','Главная страница','Главная страница'),(2,'Юридическая информация. Столичная диагностика - Тучково','Юридическая информация. Столичная диагностика - Тучково','Юридическая информация. Столичная диагностика - Тучково'),(3,'Юридическая информация. Столичная диагностика - Руза','Юридическая информация. Столичная диагностика -  Руза','Юридическая информация. Столичная диагностика -  Руза'),(4,'Юридическая информация. Столичная диагностика - Гагарин','Юридическая информация. Столичная диагностика - Гагарин','Юридическая информация. Столичная диагностика - Гагарин'),(5,'Резус-конфликт. Профилактика возможна.','Резус-конфликт. Профилактика возможна.','Резус-конфликт. Профилактика возможна.'),(6,'Тест на отцовство','Тест на отцовство','Тест на отцовство'),(7,'Prenatest - пренатальное тестирование на хромосомные нарушения','Prenatest - пренатальное тестирование на хромосомные нарушения','Prenatest - пренатальное тестирование на хромосомные нарушения'),(8,'Определение пола ребенка по анализу крови матери','Определение пола ребенка по анализу крови матери','Определение пола ребенка по анализу крови матери'),(9,'Лазерная медицина. ВЛОК.','Лазерная медицина. ВЛОК.','Лазерная медицина. ВЛОК.'),(10,'Пренатальный генетический тест','Пренатальный генетический тест','Пренатальный генетический тест'),(11,'Холтер. ЭКГ. ЭЭГ.','Холтер. ЭКГ. ЭЭГ.','Холтер. ЭКГ. ЭЭГ.'),(12,'Электрокардиограмма (ЭКГ)','Электрокардиограмма (ЭКГ)','Электрокардиограмма (ЭКГ)'),(13,'Подготовка к УЗИ','Подготовка к УЗИ','Подготовка к УЗИ'),(14,'Подготовка к анализам','Подготовка к анализам','Подготовка к анализам'),(15,'Гинекология','Гинекология','Гинекология'),(16,'Эндокринология','Эндокринология','Эндокринология'),(17,'Неврология','Неврология','Неврология'),(18,'Отоларингология, ЛОР','Отоларингология, ЛОР','Отоларингология, ЛОР'),(19,'Урология','Урология','Урология'),(20,'УЗИ при беременности','УЗИ при беременности','УЗИ при беременности'),(21,'Нейросонография (УЗИ новорожденных)','Нейросонография (УЗИ новорожденных)','Нейросонография (УЗИ новорожденных)'),(22,'Эхокардиография (ЭхоКГ)','Эхокардиография (ЭхоКГ)','Эхокардиография (ЭхоКГ)'),(23,'Удаление новообразований (бородавок) - онкодерматология','Удаление новообразований (бородавок) - онкодерматология','Удаление новообразований (бородавок) - онкодерматология');
/*!40000 ALTER TABLE `sd_pages` ENABLE KEYS */;
UNLOCK TABLES;

--
-- Table structure for table `sd_persons`
--

DROP TABLE IF EXISTS `sd_persons`;
/*!40101 SET @saved_cs_client     = @@character_set_client */;
/*!40101 SET character_set_client = utf8 */;
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
) ENGINE=InnoDB AUTO_INCREMENT=27 DEFAULT CHARSET=utf8;
/*!40101 SET character_set_client = @saved_cs_client */;

--
-- Dumping data for table `sd_persons`
--

LOCK TABLES `sd_persons` WRITE;
/*!40000 ALTER TABLE `sd_persons` DISABLE KEYS */;
INSERT INTO `sd_persons` (`person_id`, `firstname`, `lastname`, `patronymic`, `education`, `years_work`) VALUES (4,'Владимир','Кузнецов','Михайлович',2,15),(5,'Мария','Меркулова','Дмитриевна',NULL,15),(7,'Лидия','Никулкова','Константиновна',NULL,NULL),(8,'Валентина','Леоненко','Васильевна',2,15),(9,'Семен','Лебедев','Валерьевич',12,15),(10,'Ануш','Ванян','Овиковна',NULL,20),(11,'Александр','Усиков','Николаевич',2,NULL),(12,'Екатерина','Барсукова','Олеговна',2,18),(13,'Надежда','Бриллиантова','Николаевна',NULL,15),(14,'Зарина','Гаглоева','Рафиковна',15,NULL),(15,'Сергей','Перфилов','Владимирович',3,10),(16,'Игорь','Гадаев','Юрьевич',2,20),(17,'Дарья','Елизарова','Владимировна',18,NULL),(18,'Дмитрий','Яковлев','Андреевич',6,7),(19,'Ольга','Максимова','Владиславовна',19,25),(20,'Евгений','Фомин','Викторович',NULL,15),(21,'Сергей','Зуннунов','Шухратович',3,19),(22,'Раиса','Богнат','Петровна',NULL,10),(23,'Вероника','Щербанина','Юрьевна',20,15),(24,'Дарья','Покусаева','Павловна',20,10),(25,'Александр','Азаренков','Викторович',2,15),(26,'Игорь','Попов','Владимирович',NULL,20);
/*!40000 ALTER TABLE `sd_persons` ENABLE KEYS */;
UNLOCK TABLES;

--
-- Table structure for table `sd_price_group_assign`
--

DROP TABLE IF EXISTS `sd_price_group_assign`;
/*!40101 SET @saved_cs_client     = @@character_set_client */;
/*!40101 SET character_set_client = utf8 */;
CREATE TABLE `sd_price_group_assign` (
  `groupName` text,
  `itemId` int(11) DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8;
/*!40101 SET character_set_client = @saved_cs_client */;

--
-- Dumping data for table `sd_price_group_assign`
--

LOCK TABLES `sd_price_group_assign` WRITE;
/*!40000 ALTER TABLE `sd_price_group_assign` DISABLE KEYS */;
/*!40000 ALTER TABLE `sd_price_group_assign` ENABLE KEYS */;
UNLOCK TABLES;

--
-- Table structure for table `sd_price_items`
--

DROP TABLE IF EXISTS `sd_price_items`;
/*!40101 SET @saved_cs_client     = @@character_set_client */;
/*!40101 SET character_set_client = utf8 */;
CREATE TABLE `sd_price_items` (
  `id` int(11) NOT NULL,
  `code` tinytext NOT NULL,
  `name` text NOT NULL,
  `item_type` tinyint(4) NOT NULL,
  `global_price` float NOT NULL,
  `info` text NOT NULL,
  PRIMARY KEY (`id`),
  KEY `code` (`code`(63))
) ENGINE=InnoDB DEFAULT CHARSET=utf8;
/*!40101 SET character_set_client = @saved_cs_client */;

--
-- Dumping data for table `sd_price_items`
--

LOCK TABLES `sd_price_items` WRITE;
/*!40000 ALTER TABLE `sd_price_items` DISABLE KEYS */;
/*!40000 ALTER TABLE `sd_price_items` ENABLE KEYS */;
UNLOCK TABLES;

--
-- Table structure for table `sd_price_local`
--

DROP TABLE IF EXISTS `sd_price_local`;
/*!40101 SET @saved_cs_client     = @@character_set_client */;
/*!40101 SET character_set_client = utf8 */;
CREATE TABLE `sd_price_local` (
  `id` int(11) NOT NULL,
  `itemId` int(11) NOT NULL,
  `clinicId` int(11) NOT NULL,
  `price` float DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8;
/*!40101 SET character_set_client = @saved_cs_client */;

--
-- Dumping data for table `sd_price_local`
--

LOCK TABLES `sd_price_local` WRITE;
/*!40000 ALTER TABLE `sd_price_local` DISABLE KEYS */;
/*!40000 ALTER TABLE `sd_price_local` ENABLE KEYS */;
UNLOCK TABLES;

--
-- Table structure for table `sd_redirect`
--

DROP TABLE IF EXISTS `sd_redirect`;
/*!40101 SET @saved_cs_client     = @@character_set_client */;
/*!40101 SET character_set_client = utf8 */;
CREATE TABLE `sd_redirect` (
  `id` int(11) NOT NULL AUTO_INCREMENT,
  `from` text,
  `to` text,
  PRIMARY KEY (`id`),
  UNIQUE KEY `from` (`from`(64))
) ENGINE=InnoDB AUTO_INCREMENT=32 DEFAULT CHARSET=utf8;
/*!40101 SET character_set_client = @saved_cs_client */;

--
-- Dumping data for table `sd_redirect`
--

LOCK TABLES `sd_redirect` WRITE;
/*!40000 ALTER TABLE `sd_redirect` DISABLE KEYS */;
INSERT INTO `sd_redirect` (`id`, `from`, `to`) VALUES (1,'pediatr-tuchkovo/','tuchkovo/pediatr-maksimova/'),(2,'detskiy-hirurg-urolog-androlog/','detskii-urolog-androlog-zunnunov/'),(3,'specialisty/udalenie-novoobrazovanij-lazerom-onkodermatolog/','dermatolog-popov/'),(4,'specialisty/uzi-sosudov/','uzi-sosudov-sherbanina/'),(5,'vedenie-novorozhdennyx-pediatriya/','pediatr-fomin/'),(6,'centr-v-tuchkovo/','tuchkovo/contacts/'),(7,'specialisty/endokrinolog/','endokrinolog-vanyan/'),(8,'specialisty/gematolog/','gematolog-gadaev/'),(9,'specialisty/otorinolaringologiya-lor/','otolaringolog-jakovlev/'),(10,'specialisty/urologiya/','androlog-usikov/'),(11,'specialisty/pediatriya/','uzi-detyam-bognat/'),(12,'specialisty/dermatologiya/','kosmetolog-leonenko/'),(13,'specialisty/mammolog/','mammolog-lebedev/'),(14,'specialisty/nevrolog/','nevrolog-elizarova/'),(15,'centr-v-ruze/','ruza/contacts/'),(16,'centr-v-gagarine/','gagarin/contacts/'),(17,'yuridicheskaya-informaciya/','ruza/company/'),(18,'rezus-konflikt-profilaktika-vozmozhna/','rezus-konflikt-profilaktika/'),(19,'test-na-otcovstvomaterinstvo/','test-na-otcovstvo/'),(20,'neinvazivnoe-prenatalnoe-testirovanie-na-xromosomnye-narusheniya/','prenatest-prenatalny-skrining/'),(22,'specialisty/lazernaya-medicina-vlok/','vlok/'),(23,'specialisty/neinvazivnyj-prenatalnyj-geneticheskij-test/','prenatalnyi-geneticheskiy-test/'),(24,'specialisty/xolter/','holter/'),(25,'specialisty/elektrokardiogramma-ekg/','ekg-elektrokardiogramma/'),(26,'glavnaya/podgotovka-k-uzi/','podgotovka-k-uzi/'),(27,'glavnaya/podgotovka-k-sdache-analizov/\r\n','podgotovka-k-analizam/'),(28,'specialisty/ginekologiya/','ginekologiya/'),(29,'uzi-pri-beremennosti/','uzi-beremennost/'),(30,'exokardiografiya/','echokardiografia/');
/*!40000 ALTER TABLE `sd_redirect` ENABLE KEYS */;
UNLOCK TABLES;

--
-- Table structure for table `sd_shedule_assign`
--

DROP TABLE IF EXISTS `sd_shedule_assign`;
/*!40101 SET @saved_cs_client     = @@character_set_client */;
/*!40101 SET character_set_client = utf8 */;
CREATE TABLE `sd_shedule_assign` (
  `id` int(11) NOT NULL AUTO_INCREMENT,
  `personId` int(11) DEFAULT NULL,
  `shedule_hash` text,
  PRIMARY KEY (`id`)
) ENGINE=InnoDB AUTO_INCREMENT=22 DEFAULT CHARSET=utf8;
/*!40101 SET character_set_client = @saved_cs_client */;

--
-- Dumping data for table `sd_shedule_assign`
--

LOCK TABLES `sd_shedule_assign` WRITE;
/*!40000 ALTER TABLE `sd_shedule_assign` DISABLE KEYS */;
INSERT INTO `sd_shedule_assign` (`id`, `personId`, `shedule_hash`) VALUES (1,5,'8304747f13a24e988c4def60a882d828'),(2,7,'600b7de898b44baa9da75f3f3571a95c'),(3,9,'2eed78695e0b456b8526af478d4c6277'),(4,10,'88fa0c3258ce44839ac2966cc48a0451'),(5,10,'6e47b1734f7b4e63a8252ec539b4342d'),(6,11,'737a56f99c304e4b9ea739ceaf2d13b6'),(7,12,'6aba8354e556483e975e14b2adcbdaf3'),(8,13,'7271d473d48f489dbce13952d9c07b5a'),(9,14,'9ffc57b83be94e01995e624ab39796cf'),(10,15,'8c3e894edab749889ddd3ff3fa8a4940'),(11,15,'f2d14cd891d9499c96849ebfaf53af00'),(12,16,'fe789aeccc7e46e4ad4048d5ebcb4e16'),(13,17,'8d7e73613fe043deaf995ee5037aed0d'),(14,25,'8ff62746dcf94cf2b986c650dab12684'),(15,22,'2d9b9478bf9244bfb3bb1e2dec720bec'),(16,18,'9024a5a884ef4876a975f198cfb5677b'),(17,19,'5cd5f1645f3d489984434b6215e07d47'),(18,24,'d8689b5d582549f884dadfc0a00d0564'),(19,26,'be8324561bb64da1a0d29b2ef1baaf0e'),(20,23,'2646d1c2d8c6418fb413f12aee9ef79a'),(21,25,'e3d56b1abf05410c82e9c0c359320287');
/*!40000 ALTER TABLE `sd_shedule_assign` ENABLE KEYS */;
UNLOCK TABLES;

--
-- Table structure for table `sd_timeline_days`
--

DROP TABLE IF EXISTS `sd_timeline_days`;
/*!40101 SET @saved_cs_client     = @@character_set_client */;
/*!40101 SET character_set_client = utf8 */;
CREATE TABLE `sd_timeline_days` (
  `id` int(11) NOT NULL AUTO_INCREMENT,
  `timelineId` int(11) NOT NULL DEFAULT '0',
  `day` date NOT NULL,
  `is_active` tinyint(3) unsigned DEFAULT NULL,
  PRIMARY KEY (`id`),
  UNIQUE KEY `timelineId_day` (`timelineId`,`day`),
  KEY `timelineId` (`timelineId`),
  KEY `day` (`day`),
  CONSTRAINT `FK1_timeline_days_teimline` FOREIGN KEY (`timelineId`) REFERENCES `sd_timelines` (`id`)
) ENGINE=InnoDB AUTO_INCREMENT=541 DEFAULT CHARSET=utf8;
/*!40101 SET character_set_client = @saved_cs_client */;

--
-- Dumping data for table `sd_timeline_days`
--

LOCK TABLES `sd_timeline_days` WRITE;
/*!40000 ALTER TABLE `sd_timeline_days` DISABLE KEYS */;
INSERT INTO `sd_timeline_days` (`id`, `timelineId`, `day`, `is_active`) VALUES (1,39,'2019-03-12',1),(2,39,'2019-03-13',0),(3,39,'2019-03-14',0),(4,39,'2019-03-15',0),(5,39,'2019-03-16',0),(6,39,'2019-03-17',0),(7,39,'2019-03-18',0),(8,39,'2019-03-19',1),(9,39,'2019-03-20',0),(10,39,'2019-03-21',0),(11,39,'2019-03-22',0),(12,39,'2019-03-23',0),(13,39,'2019-03-24',0),(14,39,'2019-03-25',0),(15,39,'2019-03-26',1),(16,40,'2019-03-12',0),(17,40,'2019-03-13',0),(18,40,'2019-03-14',0),(19,40,'2019-03-15',0),(20,40,'2019-03-16',0),(21,40,'2019-03-17',0),(22,40,'2019-03-18',0),(23,40,'2019-03-19',0),(24,40,'2019-03-20',0),(25,40,'2019-03-21',0),(26,40,'2019-03-22',0),(27,40,'2019-03-23',0),(28,40,'2019-03-24',0),(29,40,'2019-03-25',0),(30,40,'2019-03-26',0),(31,41,'2019-03-12',0),(32,41,'2019-03-13',0),(33,41,'2019-03-14',0),(34,41,'2019-03-15',0),(35,41,'2019-03-16',0),(36,41,'2019-03-17',0),(37,41,'2019-03-18',0),(38,41,'2019-03-19',0),(39,41,'2019-03-20',0),(40,41,'2019-03-21',0),(41,41,'2019-03-22',0),(42,41,'2019-03-23',0),(43,41,'2019-03-24',0),(44,41,'2019-03-25',0),(45,41,'2019-03-26',0),(46,42,'2019-03-12',0),(47,42,'2019-03-13',0),(48,42,'2019-03-14',0),(49,42,'2019-03-15',0),(50,42,'2019-03-16',0),(51,42,'2019-03-17',0),(52,42,'2019-03-18',0),(53,42,'2019-03-19',0),(54,42,'2019-03-20',0),(55,42,'2019-03-21',0),(56,42,'2019-03-22',0),(57,42,'2019-03-23',0),(58,42,'2019-03-24',0),(59,42,'2019-03-25',0),(60,42,'2019-03-26',0),(61,43,'2019-03-12',0),(62,43,'2019-03-13',0),(63,43,'2019-03-14',0),(64,43,'2019-03-15',0),(65,43,'2019-03-16',0),(66,43,'2019-03-17',0),(67,43,'2019-03-18',0),(68,43,'2019-03-19',0),(69,43,'2019-03-20',0),(70,43,'2019-03-21',0),(71,43,'2019-03-22',0),(72,43,'2019-03-23',0),(73,43,'2019-03-24',0),(74,43,'2019-03-25',0),(75,43,'2019-03-26',0),(76,44,'2019-03-12',0),(77,44,'2019-03-13',0),(78,44,'2019-03-14',0),(79,44,'2019-03-15',0),(80,44,'2019-03-16',0),(81,44,'2019-03-17',0),(82,44,'2019-03-18',0),(83,44,'2019-03-19',0),(84,44,'2019-03-20',0),(85,44,'2019-03-21',0),(86,44,'2019-03-22',0),(87,44,'2019-03-23',0),(88,44,'2019-03-24',0),(89,44,'2019-03-25',0),(90,44,'2019-03-26',0),(91,45,'2019-03-12',0),(92,45,'2019-03-13',0),(93,45,'2019-03-14',0),(94,45,'2019-03-15',0),(95,45,'2019-03-16',0),(96,45,'2019-03-17',0),(97,45,'2019-03-18',0),(98,45,'2019-03-19',0),(99,45,'2019-03-20',0),(100,45,'2019-03-21',0),(101,45,'2019-03-22',0),(102,45,'2019-03-23',0),(103,45,'2019-03-24',0),(104,45,'2019-03-25',0),(105,45,'2019-03-26',0),(106,46,'2019-03-12',0),(107,46,'2019-03-13',0),(108,46,'2019-03-14',0),(109,46,'2019-03-15',0),(110,46,'2019-03-16',0),(111,46,'2019-03-17',0),(112,46,'2019-03-18',0),(113,46,'2019-03-19',0),(114,46,'2019-03-20',0),(115,46,'2019-03-21',0),(116,46,'2019-03-22',0),(117,46,'2019-03-23',0),(118,46,'2019-03-24',0),(119,46,'2019-03-25',0),(120,46,'2019-03-26',0),(121,47,'2019-03-12',0),(122,47,'2019-03-13',0),(123,47,'2019-03-14',0),(124,47,'2019-03-15',0),(125,47,'2019-03-16',0),(126,47,'2019-03-17',0),(127,47,'2019-03-18',0),(128,47,'2019-03-19',0),(129,47,'2019-03-20',0),(130,47,'2019-03-21',0),(131,47,'2019-03-22',0),(132,47,'2019-03-23',0),(133,47,'2019-03-24',0),(134,47,'2019-03-25',0),(135,47,'2019-03-26',0),(136,48,'2019-03-12',0),(137,48,'2019-03-13',0),(138,48,'2019-03-14',0),(139,48,'2019-03-15',0),(140,48,'2019-03-16',0),(141,48,'2019-03-17',0),(142,48,'2019-03-18',0),(143,48,'2019-03-19',0),(144,48,'2019-03-20',0),(145,48,'2019-03-21',0),(146,48,'2019-03-22',0),(147,48,'2019-03-23',0),(148,48,'2019-03-24',0),(149,48,'2019-03-25',0),(150,48,'2019-03-26',0),(151,49,'2019-03-12',0),(152,49,'2019-03-13',0),(153,49,'2019-03-14',0),(154,49,'2019-03-15',0),(155,49,'2019-03-16',0),(156,49,'2019-03-17',0),(157,49,'2019-03-18',0),(158,49,'2019-03-19',0),(159,49,'2019-03-20',0),(160,49,'2019-03-21',0),(161,49,'2019-03-22',0),(162,49,'2019-03-23',0),(163,49,'2019-03-24',0),(164,49,'2019-03-25',0),(165,49,'2019-03-26',0),(166,50,'2019-03-12',0),(167,50,'2019-03-13',0),(168,50,'2019-03-14',0),(169,50,'2019-03-15',0),(170,50,'2019-03-16',0),(171,50,'2019-03-17',0),(172,50,'2019-03-18',0),(173,50,'2019-03-19',0),(174,50,'2019-03-20',0),(175,50,'2019-03-21',0),(176,50,'2019-03-22',0),(177,50,'2019-03-23',0),(178,50,'2019-03-24',0),(179,50,'2019-03-25',0),(180,50,'2019-03-26',0),(181,51,'2019-03-12',0),(182,51,'2019-03-13',0),(183,51,'2019-03-14',0),(184,51,'2019-03-15',0),(185,51,'2019-03-16',0),(186,51,'2019-03-17',0),(187,51,'2019-03-18',0),(188,51,'2019-03-19',0),(189,51,'2019-03-20',0),(190,51,'2019-03-21',0),(191,51,'2019-03-22',0),(192,51,'2019-03-23',0),(193,51,'2019-03-24',0),(194,51,'2019-03-25',0),(195,51,'2019-03-26',0),(196,52,'2019-03-12',0),(197,52,'2019-03-13',0),(198,52,'2019-03-14',0),(199,52,'2019-03-15',0),(200,52,'2019-03-16',0),(201,52,'2019-03-17',0),(202,52,'2019-03-18',0),(203,52,'2019-03-19',0),(204,52,'2019-03-20',0),(205,52,'2019-03-21',0),(206,52,'2019-03-22',0),(207,52,'2019-03-23',0),(208,52,'2019-03-24',0),(209,52,'2019-03-25',0),(210,52,'2019-03-26',0),(211,53,'2019-03-12',0),(212,53,'2019-03-13',0),(213,53,'2019-03-14',0),(214,53,'2019-03-15',0),(215,53,'2019-03-16',0),(216,53,'2019-03-17',0),(217,53,'2019-03-18',0),(218,53,'2019-03-19',0),(219,53,'2019-03-20',0),(220,53,'2019-03-21',0),(221,53,'2019-03-22',0),(222,53,'2019-03-23',0),(223,53,'2019-03-24',0),(224,53,'2019-03-25',0),(225,53,'2019-03-26',0),(226,54,'2019-03-12',0),(227,54,'2019-03-13',0),(228,54,'2019-03-14',0),(229,54,'2019-03-15',0),(230,54,'2019-03-16',0),(231,54,'2019-03-17',0),(232,54,'2019-03-18',0),(233,54,'2019-03-19',0),(234,54,'2019-03-20',0),(235,54,'2019-03-21',0),(236,54,'2019-03-22',0),(237,54,'2019-03-23',0),(238,54,'2019-03-24',0),(239,54,'2019-03-25',0),(240,54,'2019-03-26',0),(241,55,'2019-03-12',0),(242,55,'2019-03-13',0),(243,55,'2019-03-14',0),(244,55,'2019-03-15',0),(245,55,'2019-03-16',0),(246,55,'2019-03-17',0),(247,55,'2019-03-18',0),(248,55,'2019-03-19',0),(249,55,'2019-03-20',0),(250,55,'2019-03-21',0),(251,55,'2019-03-22',0),(252,55,'2019-03-23',0),(253,55,'2019-03-24',0),(254,55,'2019-03-25',0),(255,55,'2019-03-26',0),(256,56,'2019-03-12',0),(257,56,'2019-03-13',0),(258,56,'2019-03-14',0),(259,56,'2019-03-15',0),(260,56,'2019-03-16',0),(261,56,'2019-03-17',0),(262,56,'2019-03-18',0),(263,56,'2019-03-19',0),(264,56,'2019-03-20',0),(265,56,'2019-03-21',0),(266,56,'2019-03-22',0),(267,56,'2019-03-23',0),(268,56,'2019-03-24',0),(269,56,'2019-03-25',0),(270,56,'2019-03-26',0),(271,57,'2019-03-12',0),(272,57,'2019-03-13',0),(273,57,'2019-03-14',0),(274,57,'2019-03-15',0),(275,57,'2019-03-16',0),(276,57,'2019-03-17',0),(277,57,'2019-03-18',0),(278,57,'2019-03-19',0),(279,57,'2019-03-20',0),(280,57,'2019-03-21',0),(281,57,'2019-03-22',0),(282,57,'2019-03-23',0),(283,57,'2019-03-24',0),(284,57,'2019-03-25',0),(285,57,'2019-03-26',0),(286,58,'2019-03-12',0),(287,58,'2019-03-13',0),(288,58,'2019-03-14',0),(289,58,'2019-03-15',0),(290,58,'2019-03-16',0),(291,58,'2019-03-17',0),(292,58,'2019-03-18',0),(293,58,'2019-03-19',0),(294,58,'2019-03-20',0),(295,58,'2019-03-21',0),(296,58,'2019-03-22',0),(297,58,'2019-03-23',0),(298,58,'2019-03-24',0),(299,58,'2019-03-25',0),(300,58,'2019-03-26',0),(301,59,'2019-03-12',0),(302,59,'2019-03-13',0),(303,59,'2019-03-14',0),(304,59,'2019-03-15',0),(305,59,'2019-03-16',0),(306,59,'2019-03-17',0),(307,59,'2019-03-18',0),(308,59,'2019-03-19',0),(309,59,'2019-03-20',0),(310,59,'2019-03-21',0),(311,59,'2019-03-22',0),(312,59,'2019-03-23',0),(313,59,'2019-03-24',0),(314,59,'2019-03-25',0),(315,59,'2019-03-26',0),(316,60,'2019-03-12',0),(317,60,'2019-03-13',0),(318,60,'2019-03-14',0),(319,60,'2019-03-15',0),(320,60,'2019-03-16',0),(321,60,'2019-03-17',0),(322,60,'2019-03-18',0),(323,60,'2019-03-19',0),(324,60,'2019-03-20',0),(325,60,'2019-03-21',0),(326,60,'2019-03-22',0),(327,60,'2019-03-23',0),(328,60,'2019-03-24',0),(329,60,'2019-03-25',0),(330,60,'2019-03-26',0),(331,61,'2019-03-12',0),(332,61,'2019-03-13',0),(333,61,'2019-03-14',0),(334,61,'2019-03-15',0),(335,61,'2019-03-16',0),(336,61,'2019-03-17',0),(337,61,'2019-03-18',0),(338,61,'2019-03-19',0),(339,61,'2019-03-20',0),(340,61,'2019-03-21',0),(341,61,'2019-03-22',0),(342,61,'2019-03-23',0),(343,61,'2019-03-24',0),(344,61,'2019-03-25',0),(345,61,'2019-03-26',0),(346,62,'2019-03-12',0),(347,62,'2019-03-13',0),(348,62,'2019-03-14',0),(349,62,'2019-03-15',0),(350,62,'2019-03-16',0),(351,62,'2019-03-17',0),(352,62,'2019-03-18',0),(353,62,'2019-03-19',0),(354,62,'2019-03-20',0),(355,62,'2019-03-21',0),(356,62,'2019-03-22',0),(357,62,'2019-03-23',0),(358,62,'2019-03-24',0),(359,62,'2019-03-25',0),(360,62,'2019-03-26',0),(361,63,'2019-03-12',0),(362,63,'2019-03-13',0),(363,63,'2019-03-14',0),(364,63,'2019-03-15',0),(365,63,'2019-03-16',0),(366,63,'2019-03-17',0),(367,63,'2019-03-18',0),(368,63,'2019-03-19',0),(369,63,'2019-03-20',0),(370,63,'2019-03-21',0),(371,63,'2019-03-22',0),(372,63,'2019-03-23',0),(373,63,'2019-03-24',0),(374,63,'2019-03-25',0),(375,63,'2019-03-26',0),(376,64,'2019-03-12',0),(377,64,'2019-03-13',0),(378,64,'2019-03-14',0),(379,64,'2019-03-15',0),(380,64,'2019-03-16',0),(381,64,'2019-03-17',0),(382,64,'2019-03-18',0),(383,64,'2019-03-19',0),(384,64,'2019-03-20',0),(385,64,'2019-03-21',0),(386,64,'2019-03-22',0),(387,64,'2019-03-23',0),(388,64,'2019-03-24',0),(389,64,'2019-03-25',0),(390,64,'2019-03-26',0),(391,65,'2019-03-12',0),(392,65,'2019-03-13',0),(393,65,'2019-03-14',0),(394,65,'2019-03-15',0),(395,65,'2019-03-16',0),(396,65,'2019-03-17',0),(397,65,'2019-03-18',0),(398,65,'2019-03-19',0),(399,65,'2019-03-20',0),(400,65,'2019-03-21',0),(401,65,'2019-03-22',0),(402,65,'2019-03-23',0),(403,65,'2019-03-24',0),(404,65,'2019-03-25',0),(405,65,'2019-03-26',0),(406,66,'2019-03-12',0),(407,66,'2019-03-13',0),(408,66,'2019-03-14',0),(409,66,'2019-03-15',0),(410,66,'2019-03-16',0),(411,66,'2019-03-17',0),(412,66,'2019-03-18',0),(413,66,'2019-03-19',0),(414,66,'2019-03-20',0),(415,66,'2019-03-21',0),(416,66,'2019-03-22',0),(417,66,'2019-03-23',0),(418,66,'2019-03-24',0),(419,66,'2019-03-25',0),(420,66,'2019-03-26',0),(421,67,'2019-03-12',0),(422,67,'2019-03-13',0),(423,67,'2019-03-14',0),(424,67,'2019-03-15',0),(425,67,'2019-03-16',0),(426,67,'2019-03-17',0),(427,67,'2019-03-18',0),(428,67,'2019-03-19',0),(429,67,'2019-03-20',0),(430,67,'2019-03-21',0),(431,67,'2019-03-22',0),(432,67,'2019-03-23',0),(433,67,'2019-03-24',0),(434,67,'2019-03-25',0),(435,67,'2019-03-26',0),(436,68,'2019-03-12',0),(437,68,'2019-03-13',0),(438,68,'2019-03-14',0),(439,68,'2019-03-15',0),(440,68,'2019-03-16',0),(441,68,'2019-03-17',0),(442,68,'2019-03-18',0),(443,68,'2019-03-19',0),(444,68,'2019-03-20',0),(445,68,'2019-03-21',0),(446,68,'2019-03-22',0),(447,68,'2019-03-23',0),(448,68,'2019-03-24',0),(449,68,'2019-03-25',0),(450,68,'2019-03-26',0),(451,69,'2019-03-12',0),(452,69,'2019-03-13',0),(453,69,'2019-03-14',0),(454,69,'2019-03-15',0),(455,69,'2019-03-16',0),(456,69,'2019-03-17',0),(457,69,'2019-03-18',0),(458,69,'2019-03-19',0),(459,69,'2019-03-20',0),(460,69,'2019-03-21',0),(461,69,'2019-03-22',0),(462,69,'2019-03-23',0),(463,69,'2019-03-24',0),(464,69,'2019-03-25',0),(465,69,'2019-03-26',0),(466,70,'2019-03-12',0),(467,70,'2019-03-13',0),(468,70,'2019-03-14',0),(469,70,'2019-03-15',0),(470,70,'2019-03-16',0),(471,70,'2019-03-17',0),(472,70,'2019-03-18',0),(473,70,'2019-03-19',0),(474,70,'2019-03-20',0),(475,70,'2019-03-21',0),(476,70,'2019-03-22',0),(477,70,'2019-03-23',0),(478,70,'2019-03-24',0),(479,70,'2019-03-25',0),(480,70,'2019-03-26',0),(481,71,'2019-03-12',0),(482,71,'2019-03-13',0),(483,71,'2019-03-14',0),(484,71,'2019-03-15',0),(485,71,'2019-03-16',0),(486,71,'2019-03-17',0),(487,71,'2019-03-18',0),(488,71,'2019-03-19',0),(489,71,'2019-03-20',0),(490,71,'2019-03-21',0),(491,71,'2019-03-22',0),(492,71,'2019-03-23',0),(493,71,'2019-03-24',0),(494,71,'2019-03-25',0),(495,71,'2019-03-26',0),(496,72,'2019-03-12',0),(497,72,'2019-03-13',0),(498,72,'2019-03-14',0),(499,72,'2019-03-15',0),(500,72,'2019-03-16',0),(501,72,'2019-03-17',0),(502,72,'2019-03-18',0),(503,72,'2019-03-19',0),(504,72,'2019-03-20',0),(505,72,'2019-03-21',0),(506,72,'2019-03-22',0),(507,72,'2019-03-23',0),(508,72,'2019-03-24',0),(509,72,'2019-03-25',0),(510,72,'2019-03-26',0),(511,73,'2019-03-12',0),(512,73,'2019-03-13',0),(513,73,'2019-03-14',0),(514,73,'2019-03-15',0),(515,73,'2019-03-16',1),(516,73,'2019-03-17',0),(517,73,'2019-03-18',0),(518,73,'2019-03-19',0),(519,73,'2019-03-20',0),(520,73,'2019-03-21',0),(521,73,'2019-03-22',0),(522,73,'2019-03-23',1),(523,73,'2019-03-24',0),(524,73,'2019-03-25',0),(525,73,'2019-03-26',0),(526,74,'2019-03-12',0),(527,74,'2019-03-13',0),(528,74,'2019-03-14',0),(529,74,'2019-03-15',0),(530,74,'2019-03-16',0),(531,74,'2019-03-17',0),(532,74,'2019-03-18',0),(533,74,'2019-03-19',0),(534,74,'2019-03-20',0),(535,74,'2019-03-21',0),(536,74,'2019-03-22',0),(537,74,'2019-03-23',0),(538,74,'2019-03-24',0),(539,74,'2019-03-25',0),(540,74,'2019-03-26',0);
/*!40000 ALTER TABLE `sd_timeline_days` ENABLE KEYS */;
UNLOCK TABLES;

--
-- Table structure for table `sd_timelines`
--

DROP TABLE IF EXISTS `sd_timelines`;
/*!40101 SET @saved_cs_client     = @@character_set_client */;
/*!40101 SET character_set_client = utf8 */;
CREATE TABLE `sd_timelines` (
  `id` int(11) NOT NULL AUTO_INCREMENT,
  `workplace_hash` tinytext NOT NULL,
  `person_id` int(11) NOT NULL,
  PRIMARY KEY (`id`),
  UNIQUE KEY `workplace_hash_person_id` (`workplace_hash`(32),`person_id`),
  KEY `workplace_hash` (`workplace_hash`(32)),
  KEY `person_id` (`person_id`)
) ENGINE=InnoDB AUTO_INCREMENT=75 DEFAULT CHARSET=utf8;
/*!40101 SET character_set_client = @saved_cs_client */;

--
-- Dumping data for table `sd_timelines`
--

LOCK TABLES `sd_timelines` WRITE;
/*!40000 ALTER TABLE `sd_timelines` DISABLE KEYS */;
INSERT INTO `sd_timelines` (`id`, `workplace_hash`, `person_id`) VALUES (39,'3cdfc0f0db054598bc37a50d9be0e02b',17),(40,'41e0844279ef46ec92276a3a0cb5dae9',25),(41,'ec399761507840de9e15b3c7f8fa0ae8',12),(42,'ec399761507840de9e15b3c7f8fa0ae8',13),(43,'57491828e8284e4597daabd9cf661764',22),(44,'f3762f8c64df4d2f87a1411439f0695d',10),(45,'4a4551b61e5542af81eb066a4cb871f2',14),(46,'a832bdb481a84241ae8cf3576aad65e1',16),(47,'0f67cf4e3be34025adcc2b526dde9724',18),(48,'3bdc8187c82641cab412dbdbbe3e2925',9),(49,'b212616b89484fa3957ffe30ee21dd85',19),(50,'4f5c759e776344bab43a06cf718ef650',5),(51,'7e86155fa9454ee68c4e2b5754b1c6b4',7),(52,'ce948f2b6fee4c5494d413a51bee515b',15),(53,'72c58bbddd6447f888337ece61f7453b',24),(54,'dbb256a83c354b77b1e176f1f43e7131',26),(55,'a1385764c0dc464d80a9e99ac61276dc',26),(56,'43b6f1e6b66643c487df9c664f55f277',11),(57,'1856be9ff11c4232b9f63f844a099152',23),(58,'729149faa9944726a6d0023f5960f429',25),(59,'729149faa9944726a6d0023f5960f429',24),(60,'117715832de743a5892da1ab7b6461e3',12),(61,'117715832de743a5892da1ab7b6461e3',13),(62,'5ea44f3fb51648efbf7b2d79668d9053',22),(63,'191287a61ccb4a109407e67a071b7dd4',10),(64,'2f31a4c9f4eb47ae99c6594cfb94ec2f',17),(65,'1dce28c288d54283b282b454b80423da',9),(66,'326e1037165e464ca3b8d0d7a56bdb81',5),(67,'ac647a4b3c8948fe93708eeb39d8e795',23),(68,'2ed2d9fc2a9c48d19e4c33d8c25c6908',18),(69,'5b7e95a0504b4ea49ebdc8cee07e7118',25),(70,'5ca0e8d476444f68aff481f386584ceb',22),(71,'5ca0e8d476444f68aff481f386584ceb',23),(72,'e20ae40d9c4d40d18210208412383c2b',10),(73,'e715da9a70cb4a66b27e963224a3a796',9),(74,'7eff5c99172047d6b7f482ddbd80124a',15);
/*!40000 ALTER TABLE `sd_timelines` ENABLE KEYS */;
UNLOCK TABLES;

--
-- Table structure for table `sd_traits`
--

DROP TABLE IF EXISTS `sd_traits`;
/*!40101 SET @saved_cs_client     = @@character_set_client */;
/*!40101 SET character_set_client = utf8 */;
CREATE TABLE `sd_traits` (
  `trait_id` int(11) NOT NULL AUTO_INCREMENT,
  `person_id` int(11) NOT NULL DEFAULT '0' COMMENT 'врач',
  `title` text NOT NULL,
  `description` text NOT NULL,
  `institution_id` int(11) DEFAULT '0',
  `sort` int(11) NOT NULL DEFAULT '0',
  PRIMARY KEY (`trait_id`),
  KEY `FK_sd_traits_sd_persons` (`person_id`),
  KEY `FK_sd_traits_sd_institutions` (`institution_id`),
  CONSTRAINT `FK_sd_traits_sd_institutions` FOREIGN KEY (`institution_id`) REFERENCES `sd_institutions` (`institution_id`),
  CONSTRAINT `FK_sd_traits_sd_persons` FOREIGN KEY (`person_id`) REFERENCES `sd_persons` (`person_id`)
) ENGINE=InnoDB AUTO_INCREMENT=56 DEFAULT CHARSET=utf8;
/*!40101 SET character_set_client = @saved_cs_client */;

--
-- Dumping data for table `sd_traits`
--

LOCK TABLES `sd_traits` WRITE;
/*!40000 ALTER TABLE `sd_traits` DISABLE KEYS */;
INSERT INTO `sd_traits` (`trait_id`, `person_id`, `title`, `description`, `institution_id`, `sort`) VALUES (1,4,'Основное место работы','Ассистент кафедры акушерства и гинекологии',6,10),(2,4,'специальность','акушер-гинеколог',NULL,1),(3,4,'специальность','гинеколог-эндокринолог',NULL,10),(4,4,'специальность','гинеколог',NULL,10),(5,5,'Основное место работы','',5,10),(6,5,'специальность','акушер-гинеколог',NULL,10),(7,7,'специальность','аллерголог',7,10),(8,8,'специальность','врач-дерматовенеролог',NULL,10),(9,8,'специальность','врач- косметолог',NULL,10),(10,9,'Основное место работы','Заведующий онкологическим отделением',14,10),(11,10,'специальность','гинеколог-эндокринолог',NULL,12),(12,10,'специальность','эндокринолог',NULL,11),(13,11,'специальность','андролог',NULL,1),(14,11,'Основное место работы','Заведующий урологическим кабинетом',8,10),(15,11,'специальность','УЗИ почек',NULL,10),(16,11,'специальность','УЗИ простаты',NULL,10),(17,12,'специальность','врач ультразвуковой диагностики',NULL,1),(18,12,'специальность','УЗИ',NULL,10),(19,12,'Основное место работы','Специалист отделения медицинской генетики',9,10),(20,13,'специальность','врач ультразвуковой диагностики',NULL,1),(21,13,'специальность','УЗИ',NULL,10),(22,13,'Основное место работы','',10,10),(23,14,'Основное место работы','',3,10),(25,14,'специальность','гастроэнтеролог',NULL,10),(26,15,'специальность','врач-эндоскопист',NULL,10),(27,15,'специальность','гастроэнтеролог',NULL,1),(28,15,'специальность','ЭФГДС',NULL,10),(29,15,'Основное место работы','',16,10),(30,16,'Основное место работы','Гематолог лечебно-диагностического отделения',17,10),(31,16,'специальность','гематолог',NULL,10),(32,16,'Научные степени и звания','кандидат медицинских наук',NULL,10),(33,16,'Научные степени и звания','доцент кафедры госпитальной терапии',2,10),(34,9,'специальность','маммолог',NULL,10),(35,17,'специальность','невролог',NULL,10),(36,18,'специальность','отоларинголог',NULL,10),(37,18,'специальность','ЛОР',NULL,10),(38,19,'специальность','педиатр',NULL,10),(39,20,'специальность','педиатр',NULL,10),(40,20,'Основное место работы','заведующий детским отделением',12,10),(41,21,'специальность','детский уролог',NULL,1),(42,21,'специальность','андролог',NULL,10),(43,23,'Основное место работы','Доцент кафедры функциональной и ультразвуковой диагностики',2,10),(44,23,'специальность','врач ультразвуковой диагностики',NULL,10),(45,23,'специальность','УЗИ сосудов',NULL,1),(46,23,'специальность','транскраниальное УЗИ сосудов головного мозга',NULL,10),(47,24,'специальность','эхокардиография',NULL,1),(48,24,'специальность','УЗИ сердца',NULL,10),(49,24,'Основное место работы','',11,10),(50,25,'Основное место работы','Заведующий отделением кардиологии',12,10),(51,25,'специальность','функциональная диагностика',NULL,10),(52,26,'специальность','дерматолог',NULL,1),(53,26,'специальность','онкодерматолог',NULL,10),(54,26,'Основное место работы','Заведующим детским отделением дерматологии',4,10),(55,22,'специальность','врач ультразвуковой диагностики',NULL,10);
/*!40000 ALTER TABLE `sd_traits` ENABLE KEYS */;
UNLOCK TABLES;

--
-- Table structure for table `sd_url_tags`
--

DROP TABLE IF EXISTS `sd_url_tags`;
/*!40101 SET @saved_cs_client     = @@character_set_client */;
/*!40101 SET character_set_client = utf8 */;
CREATE TABLE `sd_url_tags` (
  `id` int(11) NOT NULL AUTO_INCREMENT,
  `tag` text NOT NULL,
  `param` text NOT NULL,
  `value` text NOT NULL,
  `route` text,
  PRIMARY KEY (`id`),
  UNIQUE KEY `tag` (`tag`(63))
) ENGINE=InnoDB AUTO_INCREMENT=50 DEFAULT CHARSET=utf8;
/*!40101 SET character_set_client = @saved_cs_client */;

--
-- Dumping data for table `sd_url_tags`
--

LOCK TABLES `sd_url_tags` WRITE;
/*!40000 ALTER TABLE `sd_url_tags` DISABLE KEYS */;
INSERT INTO `sd_url_tags` (`id`, `tag`, `param`, `value`, `route`) VALUES (1,'tuchkovo','cid','1',NULL),(2,'ruza','cid','2',NULL),(3,'gagarin','cid','5',NULL),(4,'ginekolog-merkulova','id','5','persons/view'),(5,'pediatr-maksimova','id','19','persons/view'),(6,'detskii-urolog-androlog-zunnunov','id','21','persons/view'),(7,'dermatolog-popov','id','26','persons/view'),(8,'ginekolog-kuznetsov','id','4','persons/view'),(9,'allergolog-nukulkova','id','7','persons/view'),(10,'androlog-usikov','id','11','persons/view'),(11,'uzi-detyam-bognat','id','22','persons/view'),(14,'uzi-barsukova','id','12','persons/view'),(15,'uzi-brilliantova','id','13','persons/view'),(17,'kosmetolog-leonenko','id','8','persons/view'),(18,'gastroenterolog-perfilov','id','15','persons/view'),(19,'gastroenterolog-gagloeva','id','14','persons/view'),(20,'gematolog-gadaev','id','16','persons/view'),(21,'mammolog-lebedev','id','9','persons/view'),(22,'nevrolog-elizarova','id','17','persons/view'),(24,'otolaringolog-jakovlev','id','18','persons/view'),(25,'pediatr-fomin','id','20','persons/view'),(26,'uzi-sosudov-sherbanina','id','23','persons/view'),(27,'funkcionalnaya-diagnostika-azarenkov','id','25','persons/view'),(28,'endokrinolog-vanyan','id','10','persons/view'),(29,'ekg-pokusaeva','id','24','persons/view'),(30,'rezus-konflikt-profilaktika','id','5','site/page'),(31,'test-na-otcovstvo','id','6','site/page'),(32,'prenatest-prenatalny-skrining','id','7','site/page'),(33,'pol-rebenka-po-krovi-materi','id','8','site/page'),(34,'vlok','id','9','site/page'),(35,'prenatalnyi-geneticheskiy-test','id','10','site/page'),(36,'holter','id','11','site/page'),(37,'ekg-elektrokardiogramma','id','12','site/page'),(38,'podgotovka-k-uzi','id','13','site/page'),(39,'podgotovka-k-analizam','id','14','site/page'),(40,'799855594adc0f2bd7302c69d3234b5a','code','799855594adc0f2bd7302c69d3234b5a','site/load-schedule'),(41,'ginekologiya','id','15','site/page'),(42,'endokrinologya','id','16','site/page'),(43,'nevrologia','id','17','site/page'),(44,'lor-otolaringologia','id','18','site/page'),(45,'urologia','id','19','site/page'),(46,'uzi-beremennost','id','20','site/page'),(47,'neirosonografia','id','21','site/page'),(48,'echokardiografia','id','22','site/page'),(49,'onkodermatologia','id','23','site/page');
/*!40000 ALTER TABLE `sd_url_tags` ENABLE KEYS */;
UNLOCK TABLES;

--
-- Table structure for table `sd_workplaces`
--

DROP TABLE IF EXISTS `sd_workplaces`;
/*!40101 SET @saved_cs_client     = @@character_set_client */;
/*!40101 SET character_set_client = utf8 */;
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
/*!40101 SET character_set_client = utf8 */;
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
/*!40101 SET character_set_client = utf8 */;
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

-- Dump completed on 2019-03-31 20:14:00
