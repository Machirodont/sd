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
-- Table structure for table `sd_clinics`
--

DROP TABLE IF EXISTS `sd_clinics`;
/*!40101 SET @saved_cs_client     = @@character_set_client */;
 SET character_set_client = utf8mb4 ;
CREATE TABLE `sd_clinics` (
  `id` int(11) NOT NULL AUTO_INCREMENT,
  `city` text NOT NULL COMMENT 'город',
  `in` text NOT NULL,
  `region` text COMMENT 'район',
  `address` text COMMENT 'адрес клиники',
  `phone` text COMMENT 'телефон клиники',
  `hash_id` text,
  `companyPage` int(11) DEFAULT NULL,
  `crm_id` int(11) DEFAULT NULL,
  PRIMARY KEY (`id`),
  UNIQUE KEY `hash_id` (`hash_id`(32))
) ENGINE=InnoDB AUTO_INCREMENT=10 DEFAULT CHARSET=utf8;
/*!40101 SET character_set_client = @saved_cs_client */;

--
-- Dumping data for table `sd_clinics`
--

LOCK TABLES `sd_clinics` WRITE;
/*!40000 ALTER TABLE `sd_clinics` DISABLE KEYS */;
INSERT INTO `sd_clinics` (`id`, `city`, `in`, `region`, `address`, `phone`, `hash_id`, `companyPage`, `crm_id`) VALUES (1,'Тучково','в Тучково',NULL,NULL,'+7(915) 480-03-03','5c5ca002d659476daf755fd558276b27',2,1),(2,'Руза','в Рузе',NULL,NULL,'+7(915) 480-03-03','e1a85b918d244df493a44d4d46fbbdec',3,2),(3,'Сафоново','',NULL,NULL,NULL,'19d6da22f59a4d82b8840fc95db5c4e7',NULL,NULL),(4,'Стародуб','',NULL,NULL,NULL,'b27562ac7929481aaf1c2b2314b60890',NULL,NULL),(5,'Гагарин','в Гагарине',NULL,NULL,'+7(915) 650-03-03','ed3ad1e9ed654766b8a70a28417aba4c',4,3),(6,'Клинцы','',NULL,NULL,NULL,'4dec7a15aeef44ca9cffdf903271aadc',NULL,NULL),(7,'Новозыбков','',NULL,NULL,NULL,'30a56ee2d815429f8d4e87b85c46e01b',NULL,NULL),(8,'Почеп','',NULL,NULL,NULL,'9f85193cf9f74c3594879a4295938af5',NULL,NULL),(9,'Климово','',NULL,NULL,NULL,'16b9f5d953314f80ac886f6fe3011e85',NULL,8);
/*!40000 ALTER TABLE `sd_clinics` ENABLE KEYS */;
UNLOCK TABLES;

--
-- Table structure for table `sd_html_block`
--

DROP TABLE IF EXISTS `sd_html_block`;
/*!40101 SET @saved_cs_client     = @@character_set_client */;
 SET character_set_client = utf8mb4 ;
CREATE TABLE `sd_html_block` (
  `id` int(11) NOT NULL AUTO_INCREMENT,
  `itemKey` int(11) NOT NULL,
  `itemTable` text NOT NULL,
  `html` text NOT NULL,
  `order` int(11) NOT NULL DEFAULT '0',
  PRIMARY KEY (`id`)
) ENGINE=InnoDB AUTO_INCREMENT=50 DEFAULT CHARSET=utf8;
/*!40101 SET character_set_client = @saved_cs_client */;

--
-- Dumping data for table `sd_html_block`
--

LOCK TABLES `sd_html_block` WRITE;
/*!40000 ALTER TABLE `sd_html_block` DISABLE KEYS */;
INSERT INTO `sd_html_block` (`id`, `itemKey`, `itemTable`, `html`, `order`) VALUES (1,5,'sd_persons','',1),(2,5,'sd_persons','',2),(3,1,'sd_pages','view::/pages/_3_main_page',1),(4,1,'sd_clinics','view::/pages/_contacts_tuchkovo',1),(5,2,'sd_clinics','view::/pages/_contacts_ruza',1),(6,5,'sd_clinics','view::/pages/_contacts_gagarin',1),(7,2,'sd_pages','view::/pages/_yridicheskaya_info_tuchkovo',1),(8,3,'sd_pages','view::/pages/_yridicheskaya_info_ruza',1),(9,4,'sd_pages','view::/pages/_yridicheskaya_info_gagarin',1),(10,5,'sd_pages','view::/pages/_10_rezus_konflikt',1),(11,6,'sd_pages','view::/pages/_11_test_na_otsovstvo',1),(12,7,'sd_pages','view::/pages/_12_prena_test',1),(13,8,'sd_pages','view::/pages/_13_pol_rebenka',1),(14,9,'sd_pages','view::/pages/_14_lazernaya_medicina_vlok',1),(15,10,'sd_pages','view::/pages/_15_prenatalnyi_geneticheskiy_test',1),(16,11,'sd_pages','view::/pages/_16_holter_eeg_ekg',1),(17,12,'sd_pages','view::/pages/_17_ekg',1),(18,13,'sd_pages','view::/pages/_18_podgotovka_k_uzi',1),(19,14,'sd_pages','view::/pages/_19_podgotovka_k_analizam',1),(20,15,'sd_pages','view::/pages/_20_ginekologya',1),(21,10,'sd_persons','view::/pages/_21_endokrinolog_vanyan',1),(22,16,'sd_pages','view::/pages/_22_endokrinologiya',1),(23,16,'sd_persons','view::/pages/_23_gematolog_gadaev',1),(24,9,'sd_persons','view::/pages/_24_mammolog_lebedev',1),(25,17,'sd_persons','view::/pages/_25_nevrolog_elizarova',1),(26,17,'sd_pages','view::/pages/_26_nevrologia',1),(27,18,'sd_persons','view::/pages/_27_lor_jakovlev',1),(28,18,'sd_pages','view::/pages/_28_otolaringologia',1),(29,19,'sd_persons','view::/pages/_29_pediatr_maximova',1),(30,21,'sd_persons','view::/pages/_30_urolog_zunnunuv',1),(31,11,'sd_persons','view::/pages/_31_urolog_usikov',1),(32,19,'sd_pages','view::/pages/_32_urologia',1),(33,20,'sd_pages','view::/pages/_33_uzi_pri_beremennosti',1),(34,21,'sd_pages','view::/pages/_34_neirosonografiya',1),(35,23,'sd_persons','view::/pages/_35_uzi_sosudov_sherbanina',1),(36,22,'sd_pages','view::/pages/_36_ehokardiografia',1),(37,8,'sd_persons','view::/pages/_37_kosmetolog_leonenko',1),(38,23,'sd_pages','view::/pages/_38_udalenie_novoobrazovanii',1),(39,4,'sd_persons','view::/pages/_39_ginekolog_kuznetsov',1),(40,27,'sd_persons','view::/pages/_40_ginekolog_vatojan',1),(41,28,'sd_persons','view::/pages/_41_kardiolog_gromakova',1),(42,29,'sd_persons','view::/pages/_42_nevrolog_pustynnikov',1),(43,30,'sd_persons','view::/pages/_43_lor_ekaterynchev',1),(44,22,'sd_persons','view::/pages/_44_uzi_bognat',1),(45,31,'sd_persons','view::/pages/_45_urolog_malahov',1),(46,24,'sd_pages','view::/pages/_46_gidkostnaya_cytologia',1),(47,25,'sd_pages','<h3>Наши вакансии</h3><br><br>\r\n<script src=\"https://www.superjob.ru/hrom/vacancy-widget/script/3320532?hash=0cbb195537d7dfb23051422f3b8e9f4a\"></script><div id=\"sj-vacancies-list-container\"><div><a href=\"//www.superjob.ru/\" target=\"_blank\">Superjob.ru</a></div></div>',1),(48,40,'sd_persons','<p>&nbsp;</p>\r\n<p>&nbsp;</p>\r\n<p>Диагностика и лечение следующих заболеваний:</p>\r\n<ul>\r\n<li>аденома предстательной железы</li>\r\n<li>воспалительные заболевания (баланит, баланопостит и лр.)</li>\r\n<li>варикоцеле</li>\r\n<li>ЗППП (уреаплазмоз, микоплазмоз, трихомониаз, хламилиоз)</li>\r\n<li>камни в почках</li>\r\n<li>недержание мочи</li>\r\n<li>пиелонефрит</li>\r\n<li>простатит</li>\r\n<li>уретрит</li>\r\n<li>цистит</li>\r\n<li>смотровая цистоскопия с биопсией</li>\r\n<li>циркумцизия (обрезание)</li>\r\n<li>пластика уздечки</li>\r\n<li>резекция полипов уретры</li>\r\n<li>удаление лоброкачественных образований органов мошонки и полового члена</li>\r\n<li>мужское бесплодие</li>\r\n</ul>',1),(49,39,'sd_persons','<p>&nbsp;</p>\r\n<p>&nbsp;</p>\r\n<ul>\r\n<li>диагностика и лечение кислотозависимых заболеваний желудочно-кишечного тракта: язвенная болезнь желудка и двенадцатиперстной кишки, гастроэзофагеальная рефлюксная болезнь и многие другие;</li>\r\n<li>лечение пациентов с функциональными расстройствами желчного пузыря и сфинктерного аппарата, хронические холециститы, желчнокаменная болезнь, холангиты, постхолецистэктомический синдром;</li>\r\n<li>лечение заболеваний поджелудочной железы;</li>\r\n<li>лечение метаболических заболеваний печени (стеатогепатоз, стеатогепатит), алкогольные и лекарственные поражения печени;</li>\r\n<li>лечение воспалительных заболеваний кишечника, дивертикулярная болезнь, функциональными заболеваниями тонкой и толстой кишки (синдром раздраженного кишечника);</li>\r\n<li>лечением запоров и синдрома избыточного бактериального роста (дисбактериоз);</li>\r\n<li>составление индивидуальных программ и динамическое наблюдение за пациентами с хроническими заболеваниями для определения оптимальной схемы лечения, диетотерапии с целью профилактики обострений.</li>\r\n</ul>',1);
/*!40000 ALTER TABLE `sd_html_block` ENABLE KEYS */;
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
) ENGINE=InnoDB AUTO_INCREMENT=32 DEFAULT CHARSET=utf8 COMMENT='Места основной работы специалистов клиники';
/*!40101 SET character_set_client = @saved_cs_client */;

--
-- Dumping data for table `sd_institutions`
--

LOCK TABLES `sd_institutions` WRITE;
/*!40000 ALTER TABLE `sd_institutions` DISABLE KEYS */;
INSERT INTO `sd_institutions` (`institution_id`, `name`, `shortname`) VALUES (1,'Московский Государственный Университет им. М.В.Ломоносова','МГУ'),(2,'Первый Московский государственный медицинский университет имени И.М. Сеченова','Первый МГМУ им. И.М. Сеченова'),(3,'Национальный медико-хирургический Центр им. Н.И. Пирогова',''),(4,'Московский научно-практический центр дерматовенерологии и косметологии',''),(5,'Центр планирования семьи и репродукции Москвы','ЦПСиР г. Москва'),(6,'Московский государственный медико-стоматологический университет','МГМСУ'),(7,'Государственный научный центр “Институт иммунологии” Федерального медико-биологического агентства','ГНЦ Институт иммунологии ФМБА России'),(8,'Московский областной научно-исследовательский клинический институт им. М.Ф.Владимирского','МОНИКИ'),(9,'Университетская клиническая больница №2','УКБ №2'),(10,'Клиника ЭКО Альтравита',''),(11,'Научно-исследовательский институт клинической кардиологии им. А.Л. Мясникова','НИИ клинической кардиологии'),(12,'Можайская центральная районная больница','ГБУЗ МО Можайская ЦРБ'),(13,'Иркустский Государственный Медицинский Университет','ИГМУ'),(14,'Главный военный клинический госпиталь имени академика Н.Н. Бурденко','ГВКГ'),(15,'Российский Университет Дружбы Народов','РУДН'),(16,'Городская клиническая больница №36 им.Иноземцева, г.Москва','Московская клиническая больница №36'),(17,'Университетская клиническая больница №1','УКБ №1'),(18,'Санкт-Петербургская Государственная Медицинская Академия им.Мечникова',''),(19,'Куйбышевский медицинский институт им. Д.И. Ульянова',''),(20,'Российский государственный медицинский университет им. Н.И.Пирогова',''),(21,'Амурская Государственная Медицинская Академия',NULL),(22,'Минский Государственный Медицинский Институт',NULL),(23,'Новгородский государственный университет им. Ярослава Мудрого',NULL),(24,'Клиника компании «ИНГОССТРАХ» г. Москва.',NULL),(25,'Смоленская государственная медицинская академия',NULL),(26,'Санаторий МВД «Руза»',NULL),(27,'Саратовский Государственный Медицинский Университет им. В.И. Разумовского','СГМУ им. В.И. Разумовского'),(28,'Клиника «Медси»',NULL),(29,'Оренбургская Государственная Медицинская Академия','ОрГМУ'),(30,'Одинцовская областная больница',NULL),(31,'Медицинский институт Мордовского Государственного Университета им. Н.П. Огарёва','Мордовский медицинский институт');
/*!40000 ALTER TABLE `sd_institutions` ENABLE KEYS */;
UNLOCK TABLES;

--
-- Table structure for table `sd_pages`
--

DROP TABLE IF EXISTS `sd_pages`;
/*!40101 SET @saved_cs_client     = @@character_set_client */;
 SET character_set_client = utf8mb4 ;
CREATE TABLE `sd_pages` (
  `id` int(11) NOT NULL AUTO_INCREMENT,
  `title` text,
  `description` text,
  `keywords` text,
  PRIMARY KEY (`id`)
) ENGINE=InnoDB AUTO_INCREMENT=26 DEFAULT CHARSET=utf8;
/*!40101 SET character_set_client = @saved_cs_client */;

--
-- Dumping data for table `sd_pages`
--

LOCK TABLES `sd_pages` WRITE;
/*!40000 ALTER TABLE `sd_pages` DISABLE KEYS */;
INSERT INTO `sd_pages` (`id`, `title`, `description`, `keywords`) VALUES (1,'Главная страница','Главная страница','Главная страница'),(2,'Медицинский центр в Тучково. Столичная диагностика.','Медицинский центр в Тучково. Столичная диагностика. Юридическая информация о клинике.','медицинский центр, Тучково, столичная диагностика, клиника, юридическая информация, реквизиты, адрес, телефон'),(3,'Медицинский центр в Рузе. Столичная диагностика.','Медицинский центр в Рузе. Столичная диагностика. Юридическая информация о клинике.','медицинский центр, Руза, столичная диагностика, клиника, юридическая информация, реквизиты, адрес, телефон'),(4,'Медицинский центр в Гагарине. Столичная диагностика.','Медицинский центр в Гагарине. Столичная диагностика. Юридическая информация о клинике.','медицинский центр, Гагарин, столичная диагностика, клиника, юридическая информация, реквизиты, адрес, телефон'),(5,'Резус-конфликт: профилактика при беременности','Резус-конфликт: профилактика при беременности. Анализ на резус-фактор для предотвращения анемии плода.','Резус-конфликт, резус-фактор, беременность, профилактика, плод, эмбрион, анализ'),(6,'Тест на отцовство. Анализ на исключение и вероятность отцовства.','Тест на отцовство. Анализ на исключение и вероятность отцовства.','Тест на отцовство, анализ, вероятность'),(7,'Prenatest - исследование хромосомного здоровья плода.','Prenatest - исследование хромосомного здоровья плода. Пренатальное тестирование на хромосомные нарушения. Синдром Дауна, определение пола плода.','Prenatest, хромосомные нарушения, беременность, анализ, тестирование, здоровье плода,  Синдром Дауна, определение пола плода.'),(8,'Определение пола ребенка по анализу крови матери','Определение пола ребенка по анализу крови матери. Мальчик или девочка?','беременность, пол ребенка, анализ крови матери, пол эмбриона, определение пола плода, мальчик или девочка, анализ, тест'),(9,'Лазерная терапия. ВЛОК.','Лазерная медицина. Терапия ВЛОК - внутривенное лазерное освечивание крови.','Лазерная медицина, лазерная терапия, ВЛОК, внутривенное лазерное освечивание крови.'),(10,'Генетический тест плода при беременности','Пренатальный генетический тест плода при беременности. Безопасное выявление хромосомных нарушений - синдром Дауна, синдром Эдвардса, синдром Патау, синдром Тернера - трисомия/моносомия хромосом. Анализ неинвазивный, по крови матери.','генетический тест, хромосомные нарушения, беременность, плод, эмбрион, анализ крови матери, синдром Дауна , синдром Эдвардса, синдром Патау, синдром Тернера, трисомия, моносомия, хромосомы'),(11,'Холтер. ЭКГ (электрокардиограмма). ЭЭГ (электроэнцефалограмма).','Холтер. ЭЭГ (электроэнцефалограмма). Электроэнцефалография. Диагностика эпилепсии, вегето-сосудистой дистонии, сосудов головного мозга, опухолей мозга, бессонницы, головных болей.','Холтер, ЭЭГ, электроэнцефалограмма, ЭКГ, электроэнцефалография, диагностика, повышенное давление, диабет, инфаркт, нисульт, эпилепсия, вегето-сосудистой дистония, опухоли мозга, бессонница, головные боли'),(12,'Электрокардиограмма (ЭКГ)','Электрокардиограмма (ЭКГ)','Электрокардиограмма (ЭКГ)'),(13,'Подготовка к УЗИ','Подготовка к УЗИ','Подготовка к УЗИ'),(14,'Подготовка к анализам','Подготовка к анализам','Подготовка к анализам'),(15,'Гинекология','Гинекология','Гинекология'),(16,'Эндокринология','Эндокринология','Эндокринология'),(17,'Неврология','Неврология','Неврология'),(18,'Отоларингология, ЛОР','Отоларингология, ЛОР','Отоларингология, ЛОР'),(19,'Урология','Урология','Урология'),(20,'УЗИ при беременности','УЗИ при беременности','УЗИ при беременности'),(21,'Нейросонография (УЗИ новорожденных)','Нейросонография (УЗИ новорожденных)','Нейросонография (УЗИ новорожденных)'),(22,'Эхокардиография (ЭхоКГ)','Эхокардиография (ЭхоКГ)','Эхокардиография (ЭхоКГ)'),(23,'Удаление новообразований (бородавок) - онкодерматология','Удаление новообразований (бородавок) - онкодерматология','Удаление новообразований (бородавок) - онкодерматология'),(24,'Жидкостная цитология соскоба шейки матки','Жидкостная цитология соскоба шейки матки','Жидкостная цитология соскоба шейки матки'),(25,'Вакансии медицинского центра Столичная диагностика','Вакансии медицинского центра Столичная диагностика','Вакансии медицинского центра Столичная диагностика');
/*!40000 ALTER TABLE `sd_pages` ENABLE KEYS */;
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
  `removed` datetime DEFAULT NULL,
  PRIMARY KEY (`person_id`),
  KEY `person` (`person_id`),
  KEY `FK_sd_persons_sd_institutions` (`education`),
  CONSTRAINT `FK_sd_persons_sd_institutions` FOREIGN KEY (`education`) REFERENCES `sd_institutions` (`institution_id`)
) ENGINE=InnoDB AUTO_INCREMENT=44 DEFAULT CHARSET=utf8;
/*!40101 SET character_set_client = @saved_cs_client */;

--
-- Dumping data for table `sd_persons`
--

LOCK TABLES `sd_persons` WRITE;
/*!40000 ALTER TABLE `sd_persons` DISABLE KEYS */;
INSERT INTO `sd_persons` (`person_id`, `firstname`, `lastname`, `patronymic`, `education`, `years_work`, `removed`) VALUES (4,'Владимир','Кузнецов','Михайлович',2,15,NULL),(5,'Мария','Меркулова','Дмитриевна',NULL,15,'2020-01-10 12:50:47'),(7,'Лидия','Никулкова','Константиновна',NULL,NULL,'2019-04-14 21:06:20'),(8,'Валентина','Леоненко','Васильевна',2,15,NULL),(9,'Семен','Лебедев','Валерьевич',12,15,NULL),(10,'Ануш','Ванян','Овиковна',NULL,20,NULL),(11,'Александр','Усиков','Николаевич',2,NULL,NULL),(12,'Екатерина','Барсукова','Олеговна',2,18,NULL),(13,'Надежда','Бриллиантова','Николаевна',NULL,15,'2020-01-10 12:50:11'),(14,'Зарина','Гаглоева','Рафиковна',15,NULL,'2020-07-28 13:35:15'),(15,'Сергей','Перфилов','Владимирович',3,10,'2019-08-27 17:35:14'),(16,'Игорь','Гадаев','Юрьевич',2,20,NULL),(17,'Дарья','Елизарова','Владимировна',18,NULL,NULL),(18,'Дмитрий','Яковлев','Андреевич',6,7,NULL),(19,'Ольга','Максимова','Владиславовна',19,25,NULL),(20,'Евгений','Фомин','Викторович',NULL,15,'2020-07-28 13:35:01'),(21,'Сергей','Зуннунов','Шухратович',3,19,'2020-01-10 12:50:17'),(22,'Раиса','Богнат','Петровна',23,10,NULL),(23,'Вероника','Щербанина','Юрьевна',20,15,NULL),(24,'Дарья','Покусаева','Павловна',20,10,NULL),(25,'Александр','Азаренков','Викторович',2,15,NULL),(26,'Игорь','Попов','Владимирович',NULL,20,NULL),(27,'Марине','Ватоян','Аршалуисовна',21,12,NULL),(28,'Елена','Громакова','Федоровна',22,25,NULL),(29,'Ярослав','Пустынников','Александрович',NULL,NULL,'2020-01-10 12:50:38'),(30,'Вячеслав','Екатериничев','Александрович',NULL,7,NULL),(31,'Алексей ','Малахов','Михайлович',NULL,25,NULL),(32,'Мария','Ошерова','Владимировна',25,7,'2020-01-10 12:50:34'),(34,'Самира','Абдуллаева','Сабировна',NULL,NULL,NULL),(35,'Анна','Дударева','Викторовна',NULL,NULL,NULL),(36,'Валерий','Нецветаев','Витальевич',NULL,NULL,NULL),(37,'Светлана','Домнина','Михайловна',NULL,NULL,'2020-08-13 13:46:55'),(38,'Артемий','Волков','Викторович',NULL,NULL,NULL),(39,'Светлана','Прокопец','Викторовна',27,25,NULL),(40,'Умид','Тоштемиров','Муратович',31,5,NULL),(41,'Ирина','Чайкина','Викторовна',NULL,NULL,NULL),(42,'Андрей','Тиунов','Викторович',29,12,'2020-03-08 14:24:09'),(43,'Юрий','Шенгелия','Григорьевич',NULL,NULL,NULL);
/*!40000 ALTER TABLE `sd_persons` ENABLE KEYS */;
UNLOCK TABLES;

--
-- Table structure for table `sd_promo`
--

DROP TABLE IF EXISTS `sd_promo`;
/*!40101 SET @saved_cs_client     = @@character_set_client */;
 SET character_set_client = utf8mb4 ;
CREATE TABLE `sd_promo` (
  `id` int(11) NOT NULL AUTO_INCREMENT,
  `title` text,
  `startDate` date DEFAULT NULL,
  `endDate` date DEFAULT NULL,
  `clinics` text,
  `html` text CHARACTER SET utf8mb4 COLLATE utf8mb4_0900_ai_ci,
  PRIMARY KEY (`id`)
) ENGINE=InnoDB AUTO_INCREMENT=3 DEFAULT CHARSET=utf8;
/*!40101 SET character_set_client = @saved_cs_client */;

--
-- Dumping data for table `sd_promo`
--

LOCK TABLES `sd_promo` WRITE;
/*!40000 ALTER TABLE `sd_promo` DISABLE KEYS */;
INSERT INTO `sd_promo` (`id`, `title`, `startDate`, `endDate`, `clinics`, `html`) VALUES (1,'ВЕСЬ ДЕКАБРЬ в медицинском центре Столичная Диагностика в Гагарине - уникальные акции!','2019-12-01','2019-12-31','[\"0\",\"5\"]','<p>⠀<br /><strong>Скидка 50% на УЗИ по беременности.</strong></p>\r\n<p>Исследование проводит кандидат медицинских наук, основатель сети клиник \"Столичная диагностика\", <span style=\"text-decoration: underline;\"><span style=\"color: #34495e; text-decoration: underline;\"><strong><a style=\"color: #34495e; text-decoration: underline;\" href=\"../gagarin/ginekolog-kuznetsov/\">Кузнецов Владимир Михайлович</a></strong></span></span>.<br />⠀<br />Владимир Михайлович имеет международный сертификат для проведения скринингов во время беременности.<br />⠀<br />Исследование проводится на узи-аппарате экспертного уровня с технологией 4D HD LIVE<br />⠀<br />Не упустите свой шанс!<br />⠀</p>\r\n<p><br /><strong>Скидка 40% на анализ крови на уровень витамина Д</strong></p>\r\n<p>Стоимость анализа по акции всего 750 рублей!!!&nbsp;</p>\r\n<p>Эта акция - наша гордость, благодаря специальной цене нам удалось выявить и скомпенсировать дефицит этого наиважнейшего витамина у еще бо́льшего количества наших пациентов!!!<br />⠀⠀<br />Поторопитесь, специальная цена будет действовать только до конца 2019 года!</p>\r\n<p><br />⠀<br /><strong>Cкидка 10% на все анализы, кроме анализа на вит. Д (на него скидка 40%)</strong></p>'),(2,'Тестирование на COVID-19',NULL,NULL,NULL,'<p><span style=\"color: #ff0000;\"><strong>Мы определяем антитела к&nbsp; COVID-19 в КРОВИ: </strong></span></p>\r\n<p><span style=\"color: #ff0000;\"><strong>острофазные (M)</strong></span><span style=\"color: #ff0000;\"><strong> + памяти (G)</strong></span></p>');
/*!40000 ALTER TABLE `sd_promo` ENABLE KEYS */;
UNLOCK TABLES;

--
-- Table structure for table `sd_redirect`
--

DROP TABLE IF EXISTS `sd_redirect`;
/*!40101 SET @saved_cs_client     = @@character_set_client */;
 SET character_set_client = utf8mb4 ;
CREATE TABLE `sd_redirect` (
  `id` int(11) NOT NULL AUTO_INCREMENT,
  `from` text,
  `to` text,
  PRIMARY KEY (`id`),
  UNIQUE KEY `from` (`from`(64))
) ENGINE=InnoDB AUTO_INCREMENT=56 DEFAULT CHARSET=utf8;
/*!40101 SET character_set_client = @saved_cs_client */;

--
-- Dumping data for table `sd_redirect`
--

LOCK TABLES `sd_redirect` WRITE;
/*!40000 ALTER TABLE `sd_redirect` DISABLE KEYS */;
INSERT INTO `sd_redirect` (`id`, `from`, `to`) VALUES (1,'pediatr-tuchkovo/','tuchkovo/pediatr-maksimova/'),(2,'detskiy-hirurg-urolog-androlog/','detskii-urolog-androlog-zunnunov/'),(3,'specialisty/udalenie-novoobrazovanij-lazerom-onkodermatolog/','dermatolog-popov/'),(4,'specialisty/uzi-sosudov/','uzi-sosudov-sherbanina/'),(5,'vedenie-novorozhdennyx-pediatriya/','pediatr-fomin/'),(6,'centr-v-tuchkovo/','tuchkovo/contacts/'),(7,'specialisty/endokrinolog/','endokrinolog-vanyan/'),(8,'specialisty/gematolog/','gematolog-gadaev/'),(9,'specialisty/otorinolaringologiya-lor/','otolaringolog-jakovlev/'),(10,'specialisty/urologiya/','androlog-usikov/'),(11,'specialisty/pediatriya/','neirosonografia/'),(12,'specialisty/dermatologiya/','kosmetolog-leonenko/'),(13,'specialisty/mammolog/','mammolog-lebedev/'),(14,'specialisty/nevrolog/','nevrolog-elizarova/'),(15,'centr-v-ruze/','ruza/contacts/'),(16,'centr-v-gagarine/','gagarin/contacts/'),(17,'yuridicheskaya-informaciya/','company/'),(18,'rezus-konflikt-profilaktika-vozmozhna/','rezus-konflikt-profilaktika/'),(19,'test-na-otcovstvomaterinstvo/','test-na-otcovstvo/'),(20,'neinvazivnoe-prenatalnoe-testirovanie-na-xromosomnye-narusheniya/','prenatest-prenatalny-skrining/'),(22,'specialisty/lazernaya-medicina-vlok/','vlok/'),(23,'specialisty/neinvazivnyj-prenatalnyj-geneticheskij-test/','prenatalnyi-geneticheskiy-test/'),(24,'specialisty/xolter/','holter/'),(25,'specialisty/elektrokardiogramma-ekg/','ekg-elektrokardiogramma/'),(26,'glavnaya/podgotovka-k-uzi/','podgotovka-k-uzi/'),(27,'glavnaya/podgotovka-k-sdache-analizov/\r\n','podgotovka-k-analizam/'),(28,'specialisty/ginekologiya/','ginekologiya/'),(29,'uzi-pri-beremennosti/','uzi-beremennost/'),(30,'exokardiografiya/','echokardiografia/'),(32,'analizy/','podgotovka-k-analizam/'),(33,'ceny/','services/'),(34,'kak-dobratsya/','contacts/'),(35,'7915-480-03-03/','ruza/contacts/'),(36,'glavnaya/podgotovka-k-sdache-analizov/','podgotovka-k-analizam/'),(37,'gagarin/dnk-test-na-otcovstvo/','gagarin/test-na-otcovstvo/'),(38,'7-915-480-03-03/','ruza/contacts/'),(39,'gagarin/prenatest-tochnee-skrininga-1-semestra/','gagarin/prenatest-prenatalny-skrining/'),(40,'pol-budushhego-rebenka-po-krovi-materi/','pol-rebenka-po-krovi-materi/'),(41,'prenatest-tochnee-skrininga-1-semestra/','prenatest-prenatalny-skrining/'),(42,'specialisty/vlok-vnutrivennoe-lazernoe-obluchenie-krovi/','vlok/'),(43,'funkcionalnaya-diagnostika-ekg-xolter-smad/','holter/'),(44,'dnk-test-na-otcovstvo/','test-na-otcovstvo/'),(45,'specialisty/uzi/','uzi-detyam-bognat/'),(46,'specialisty/dermatologiya-medicinskaya-kosmetologiya/','kosmetolog-leonenko/'),(47,'specialisty/akusherstvo-i-ginekologiya/','ginekolog-kuznetsov/'),(48,'specialisty/ginekolog/','ginekolog-vatojan/'),(49,'kardiolog/','kardiolog-gromakova/'),(50,'specialisty/urolog/','urolog-uzi-malahov/'),(51,'specialisty/udalenie-borodavok-papillom-rodinok-lazerom/','onkodermatologia/'),(52,'specialisty/uzi-sosudov-obshhee-uzi/','uzi-osherova/'),(53,'specialisty/gastroenterolog-gastroskopiya-kolonoskopiya/','gastroenterolog-perfilov/'),(55,'7915-650-03-03/','gagarin/contacts/');
/*!40000 ALTER TABLE `sd_redirect` ENABLE KEYS */;
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
  `sort` int(11) NOT NULL DEFAULT '0',
  PRIMARY KEY (`trait_id`),
  KEY `FK_sd_traits_sd_persons` (`person_id`),
  KEY `FK_sd_traits_sd_institutions` (`institution_id`),
  CONSTRAINT `FK_sd_traits_sd_institutions` FOREIGN KEY (`institution_id`) REFERENCES `sd_institutions` (`institution_id`),
  CONSTRAINT `FK_sd_traits_sd_persons` FOREIGN KEY (`person_id`) REFERENCES `sd_persons` (`person_id`)
) ENGINE=InnoDB AUTO_INCREMENT=94 DEFAULT CHARSET=utf8;
/*!40101 SET character_set_client = @saved_cs_client */;

--
-- Dumping data for table `sd_traits`
--

LOCK TABLES `sd_traits` WRITE;
/*!40000 ALTER TABLE `sd_traits` DISABLE KEYS */;
INSERT INTO `sd_traits` (`trait_id`, `person_id`, `title`, `description`, `institution_id`, `sort`) VALUES (1,4,'Основное место работы','Ассистент кафедры акушерства и гинекологии',6,10),(2,4,'специальность','акушер-гинеколог',NULL,1),(3,4,'специальность','гинеколог-эндокринолог',NULL,10),(4,4,'специальность','гинеколог',NULL,10),(5,5,'Основное место работы','',5,10),(6,5,'специальность','акушер-гинеколог',NULL,10),(7,7,'специальность','аллерголог',7,10),(8,8,'специальность','врач-дерматовенеролог',NULL,10),(9,8,'специальность','врач- косметолог',NULL,10),(10,9,'Основное место работы','Заведующий онкологическим отделением',14,10),(11,10,'специальность','гинеколог-эндокринолог',NULL,12),(12,10,'специальность','эндокринолог',NULL,11),(13,11,'специальность','андролог',NULL,1),(14,11,'Основное место работы','Заведующий урологическим кабинетом',8,10),(15,11,'специальность','УЗИ почек',NULL,10),(16,11,'специальность','УЗИ простаты',NULL,10),(17,12,'специальность','врач ультразвуковой диагностики',NULL,1),(18,12,'специальность','УЗИ',NULL,10),(19,12,'Основное место работы','Специалист отделения медицинской генетики',9,10),(20,13,'специальность','врач ультразвуковой диагностики',NULL,1),(21,13,'специальность','УЗИ',NULL,10),(22,13,'Основное место работы','',10,10),(23,14,'Основное место работы','',3,10),(25,14,'специальность','гастроэнтеролог',NULL,10),(26,15,'специальность','врач-эндоскопист',NULL,10),(27,15,'специальность','гастроэнтеролог',NULL,1),(28,15,'специальность','ЭФГДС',NULL,10),(29,15,'Основное место работы','',16,10),(30,16,'Основное место работы','Гематолог лечебно-диагностического отделения',17,10),(31,16,'специальность','гематолог',NULL,10),(32,16,'Научные степени и звания','кандидат медицинских наук',NULL,10),(33,16,'Научные степени и звания','доцент кафедры госпитальной терапии',2,10),(34,9,'специальность','маммолог',NULL,10),(35,17,'специальность','невролог',NULL,10),(36,18,'специальность','отоларинголог',NULL,10),(37,18,'специальность','ЛОР',NULL,10),(38,19,'специальность','педиатр',NULL,10),(39,20,'специальность','педиатр',NULL,10),(40,20,'Основное место работы','заведующий детским отделением',12,10),(41,21,'специальность','детский уролог',NULL,1),(42,21,'специальность','андролог',NULL,10),(43,23,'Основное место работы','Доцент кафедры функциональной и ультразвуковой диагностики',2,10),(44,23,'специальность','врач ультразвуковой диагностики',NULL,10),(45,23,'специальность','УЗИ сосудов',NULL,1),(46,23,'специальность','транскраниальное УЗИ сосудов головного мозга',NULL,10),(47,24,'специальность','эхокардиография',NULL,1),(48,24,'специальность','УЗИ сердца',NULL,10),(49,24,'Основное место работы','',11,10),(50,25,'Основное место работы','Заведующий отделением кардиологии',12,10),(51,25,'специальность','функциональная диагностика',NULL,10),(52,26,'специальность','дерматолог',NULL,1),(53,26,'специальность','онкодерматолог',NULL,10),(54,26,'Основное место работы','Заведующим детским отделением дерматологии',4,10),(55,22,'специальность','врач ультразвуковой диагностики',NULL,10),(56,27,'специальность','акушер-гинеколог',NULL,10),(57,27,'специальность','гинеколог-эндокринолог',NULL,10),(58,27,'специальность','врач УЗД в гинекологии и акушерстве',NULL,10),(59,28,'специальность','кардиолог',NULL,10),(60,29,'специальность','невролог',NULL,10),(61,29,'Основное место работы','Заведующий сосудистым отделением неврологии',12,10),(62,30,'специальность','отоларинголог',NULL,10),(63,30,'специальность','ЛОР',NULL,10),(64,30,'Основное место работы','Ассистент кафедры оториноларингологии',6,10),(65,22,'специальность','сосудистый хирург',NULL,10),(66,22,'Основное место работы','',12,10),(67,31,'специальность','уролог',NULL,10),(68,31,'специальность','врач ультразвуковой диагностики',NULL,20),(69,31,'Основное место работы','Заведующий хирургическим отделением',24,10),(70,32,'специальность','врач ультразвуковой диагностики',NULL,10),(71,32,'специальность','хирург',NULL,20),(72,32,'Основное место работы','Сотрудник кафедры факультетской хирургии',25,10),(73,34,'специальность','терапевт',NULL,10),(74,34,'специальность','кардиолог',NULL,20),(75,35,'специальность','терапевт',NULL,10),(76,35,'специальность','кардиолог',NULL,20),(77,36,'специальность','терапевт',NULL,10),(78,36,'специальность','врач общей практики',NULL,10),(79,37,'специальность','педиатр',NULL,10),(80,38,'специальность','гастроскопия',NULL,10),(81,39,'специальность','гастроэнтеролог',NULL,10),(82,40,'специальность','уролог',NULL,10),(83,40,'специальность','УЗИ почек',NULL,20),(84,40,'специальность','УЗИ простаты',NULL,30),(85,41,'специальность','эндокринолог',NULL,10),(86,42,'специальность','офтальмолог',NULL,10),(87,43,'специальность','офтальмолог',NULL,10),(88,39,'Научные степени и звания','врач высшей квалификационной категории',NULL,10),(89,39,'Основное место работы','',26,10),(90,42,'Основное место работы','Врач-офтальмолог',28,10),(91,40,'Основное место работы','',30,10),(92,40,'Научные степени и звания','член Российского Общества Урологов',NULL,10),(93,40,'Научные степени и звания','участник проекта «Академия амбулаторной урологии»',NULL,10);
/*!40000 ALTER TABLE `sd_traits` ENABLE KEYS */;
UNLOCK TABLES;

--
-- Table structure for table `sd_url_tags`
--

DROP TABLE IF EXISTS `sd_url_tags`;
/*!40101 SET @saved_cs_client     = @@character_set_client */;
 SET character_set_client = utf8mb4 ;
CREATE TABLE `sd_url_tags` (
  `id` int(11) NOT NULL AUTO_INCREMENT,
  `tag` text NOT NULL,
  `param` text NOT NULL,
  `value` text NOT NULL,
  `route` text,
  PRIMARY KEY (`id`),
  UNIQUE KEY `tag` (`tag`(63))
) ENGINE=InnoDB AUTO_INCREMENT=69 DEFAULT CHARSET=utf8;
/*!40101 SET character_set_client = @saved_cs_client */;

--
-- Dumping data for table `sd_url_tags`
--

LOCK TABLES `sd_url_tags` WRITE;
/*!40000 ALTER TABLE `sd_url_tags` DISABLE KEYS */;
INSERT INTO `sd_url_tags` (`id`, `tag`, `param`, `value`, `route`) VALUES (1,'tuchkovo','cid','1','site/main-page'),(2,'ruza','cid','2','site/main-page'),(3,'gagarin','cid','5','site/main-page'),(4,'ginekolog-merkulova','id','5','persons/view'),(5,'pediatr-maksimova','id','19','persons/view'),(6,'detskii-urolog-androlog-zunnunov','id','21','persons/view'),(7,'dermatolog-popov','id','26','persons/view'),(8,'ginekolog-kuznetsov','id','4','persons/view'),(9,'allergolog-nukulkova','id','7','persons/view'),(10,'androlog-usikov','id','11','persons/view'),(11,'uzi-detyam-bognat','id','22','persons/view'),(14,'uzi-barsukova','id','12','persons/view'),(15,'uzi-brilliantova','id','13','persons/view'),(17,'kosmetolog-leonenko','id','8','persons/view'),(18,'gastroenterolog-perfilov','id','15','persons/view'),(19,'gastroenterolog-gagloeva','id','14','persons/view'),(20,'gematolog-gadaev','id','16','persons/view'),(21,'mammolog-lebedev','id','9','persons/view'),(22,'nevrolog-elizarova','id','17','persons/view'),(24,'otolaringolog-jakovlev','id','18','persons/view'),(25,'pediatr-fomin','id','20','persons/view'),(26,'uzi-sosudov-sherbanina','id','23','persons/view'),(27,'funkcionalnaya-diagnostika-azarenkov','id','25','persons/view'),(28,'endokrinolog-vanyan','id','10','persons/view'),(29,'ekg-pokusaeva','id','24','persons/view'),(30,'rezus-konflikt-profilaktika','id','5','site/page'),(31,'test-na-otcovstvo','id','6','site/page'),(32,'prenatest-prenatalny-skrining','id','7','site/page'),(33,'pol-rebenka-po-krovi-materi','id','8','site/page'),(34,'vlok','id','9','site/page'),(35,'prenatalnyi-geneticheskiy-test','id','10','site/page'),(36,'holter','id','11','site/page'),(37,'ekg-elektrokardiogramma','id','12','site/page'),(38,'podgotovka-k-uzi','id','13','site/page'),(39,'podgotovka-k-analizam','id','14','site/page'),(40,'799855594adc0f2bd7302c69d3234b5a','code','799855594adc0f2bd7302c69d3234b5a','site/load-schedule'),(41,'ginekologiya','id','15','site/page'),(42,'endokrinologya','id','16','site/page'),(43,'nevrologia','id','17','site/page'),(44,'lor-otolaringologia','id','18','site/page'),(45,'urologia','id','19','site/page'),(46,'uzi-beremennost','id','20','site/page'),(47,'neirosonografia','id','21','site/page'),(48,'echokardiografia','id','22','site/page'),(49,'onkodermatologia','id','23','site/page'),(50,'ginekolog-vatojan','id','27','persons/view'),(51,'kardiolog-gromakova','id','28','persons/view'),(52,'nevrolog-pustynnikov','id','29','persons/view'),(53,'otolaringolog-ekaterynchev','id','30','persons/view'),(54,'urolog-uzi-malahov','id','31','persons/view'),(55,'uzi-osherova','id','32','persons/view'),(56,'zhidkostnaya-citologiya-soskoba-shejki-matki','id','24','site/page'),(57,'41445463905c0ed3ebb1e694a8d7ab','code','41445463905c0ed3ebb1e694a8d7ab','site/load-schedule'),(58,'vacancy','id','25','site/page'),(59,'terapevt-abdullayeva','id','34','persons/view'),(60,'terapevt-dudareva','id','35','persons/view'),(61,'terapevt-netsvetayev','id','36','persons/view'),(62,'pediatr-domnina','id','37','persons/view'),(63,'gastroskopiya-volkov','id','38','persons/view'),(64,'gastroenterolog-prokopets','id','39','persons/view'),(65,'urolog-toshtemirov','id','40','persons/view'),(66,'endokrinolog-chaykina','id','41','persons/view'),(67,'ofstalmolog-tiunov','id','42','persons/view'),(68,'ofstalmolog-shengeliya','id','43','persons/view');
/*!40000 ALTER TABLE `sd_url_tags` ENABLE KEYS */;
UNLOCK TABLES;
/*!40103 SET TIME_ZONE=@OLD_TIME_ZONE */;

/*!40101 SET SQL_MODE=@OLD_SQL_MODE */;
/*!40014 SET FOREIGN_KEY_CHECKS=@OLD_FOREIGN_KEY_CHECKS */;
/*!40014 SET UNIQUE_CHECKS=@OLD_UNIQUE_CHECKS */;
/*!40101 SET CHARACTER_SET_CLIENT=@OLD_CHARACTER_SET_CLIENT */;
/*!40101 SET CHARACTER_SET_RESULTS=@OLD_CHARACTER_SET_RESULTS */;
/*!40101 SET COLLATION_CONNECTION=@OLD_COLLATION_CONNECTION */;
/*!40111 SET SQL_NOTES=@OLD_SQL_NOTES */;

-- Dump completed on 2020-08-19 14:45:49
