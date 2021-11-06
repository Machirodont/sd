<?php

use yii\db\Migration;

/**
 * Class m211106_163138_initial
 */
class m211106_163138_initial extends Migration
{
    /**
     * {@inheritdoc}
     */
    public function safeUp()
    {
        $query = <<<SQL
CREATE TABLE IF NOT EXISTS `sd_appointment` (
  `id` int unsigned NOT NULL AUTO_INCREMENT,
  `person_id` int unsigned NOT NULL DEFAULT '0',
  `clinic_id` int unsigned NOT NULL DEFAULT '0',
  `phone` tinytext CHARACTER SET utf8mb4 COLLATE utf8mb4_general_ci NOT NULL,
  `day` date DEFAULT NULL,
  `cookie` tinytext CHARACTER SET utf8mb4 COLLATE utf8mb4_general_ci NOT NULL,
  `status` tinyint NOT NULL DEFAULT '0',
  `created` datetime NOT NULL,
  `owner_id` int unsigned DEFAULT NULL,
  `ip` text,
  `comment` tinytext CHARACTER SET utf8mb4 COLLATE utf8mb4_general_ci,
  PRIMARY KEY (`id`)
) ENGINE=InnoDB AUTO_INCREMENT=0 DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

-- Экспортируемые данные не выделены.

-- Дамп структуры для таблица sd.sd_clinics
CREATE TABLE IF NOT EXISTS `sd_clinics` (
  `id` int NOT NULL AUTO_INCREMENT,
  `city` text NOT NULL COMMENT 'город',
  `in` text NOT NULL,
  `region` text COMMENT 'район',
  `address` text COMMENT 'адрес клиники',
  `phone` text COMMENT 'телефон клиники',
  `hash_id` text,
  `companyPage` int DEFAULT NULL,
  `crm_id` int DEFAULT NULL,
  PRIMARY KEY (`id`),
  UNIQUE KEY `hash_id` (`hash_id`(32))
) ENGINE=InnoDB AUTO_INCREMENT=0 DEFAULT CHARSET=utf8;

-- Экспортируемые данные не выделены.

-- Дамп структуры для таблица sd.sd_hit_counter
CREATE TABLE IF NOT EXISTS `sd_hit_counter` (
  `id` int NOT NULL AUTO_INCREMENT,
  `cid` int NOT NULL DEFAULT '0',
  `hit` tinytext,
  `hitTime` datetime DEFAULT NULL,
  `ip` tinytext,
  `useragent` text,
  `screen` tinytext,
  PRIMARY KEY (`id`)
) ENGINE=InnoDB AUTO_INCREMENT=0 DEFAULT CHARSET=utf8;

-- Экспортируемые данные не выделены.

-- Дамп структуры для таблица sd.sd_html_block
CREATE TABLE IF NOT EXISTS `sd_html_block` (
  `id` int NOT NULL AUTO_INCREMENT,
  `itemKey` int NOT NULL,
  `itemTable` text NOT NULL,
  `html` text NOT NULL,
  `order` int NOT NULL DEFAULT '0',
  PRIMARY KEY (`id`)
) ENGINE=InnoDB AUTO_INCREMENT=0 DEFAULT CHARSET=utf8;

-- Экспортируемые данные не выделены.

-- Дамп структуры для таблица sd.sd_institutions
CREATE TABLE IF NOT EXISTS `sd_institutions` (
  `institution_id` int NOT NULL AUTO_INCREMENT,
  `name` text COMMENT 'название заведения',
  `shortname` text COMMENT 'сокращенное название заведения',
  PRIMARY KEY (`institution_id`)
) ENGINE=InnoDB AUTO_INCREMENT=0 DEFAULT CHARSET=utf8 COMMENT='Места основной работы специалистов клиники';

-- Экспортируемые данные не выделены.

-- Дамп структуры для таблица sd.sd_loaded_schedules
CREATE TABLE IF NOT EXISTS `sd_loaded_schedules` (
  `fileName` tinytext NOT NULL,
  `parsed` tinyint NOT NULL DEFAULT '0',
  `loadTime` datetime DEFAULT NULL,
  PRIMARY KEY (`fileName`(63))
) ENGINE=InnoDB DEFAULT CHARSET=utf8;

-- Экспортируемые данные не выделены.

-- Дамп структуры для таблица sd.sd_pages
CREATE TABLE IF NOT EXISTS `sd_pages` (
  `id` int NOT NULL AUTO_INCREMENT,
  `title` text,
  `description` text,
  `keywords` text,
  PRIMARY KEY (`id`)
) ENGINE=InnoDB AUTO_INCREMENT=0 DEFAULT CHARSET=utf8;

-- Экспортируемые данные не выделены.

-- Дамп структуры для таблица sd.sd_persons
CREATE TABLE IF NOT EXISTS `sd_persons` (
  `person_id` int NOT NULL AUTO_INCREMENT,
  `firstname` text NOT NULL COMMENT 'Имя',
  `lastname` text NOT NULL COMMENT 'Фамилия',
  `patronymic` text COMMENT 'Отчество',
  `education` int DEFAULT NULL COMMENT 'Основное образование',
  `years_work` tinyint DEFAULT NULL COMMENT 'Стаж работы, лет',
  `removed` datetime DEFAULT NULL,
  PRIMARY KEY (`person_id`),
  KEY `person` (`person_id`),
  KEY `FK_sd_persons_sd_institutions` (`education`),
  CONSTRAINT `FK_sd_persons_sd_institutions` FOREIGN KEY (`education`) REFERENCES `sd_institutions` (`institution_id`)
) ENGINE=InnoDB AUTO_INCREMENT=0 DEFAULT CHARSET=utf8;

-- Экспортируемые данные не выделены.

-- Дамп структуры для таблица sd.sd_price_group
CREATE TABLE IF NOT EXISTS `sd_price_group` (
  `id` int NOT NULL AUTO_INCREMENT,
  `groupName` text,
  `parentId` int DEFAULT NULL,
  `removed` datetime DEFAULT NULL,
  PRIMARY KEY (`id`),
  UNIQUE KEY `groupName_parentId` (`groupName`(63),`parentId`),
  KEY `groupName` (`groupName`(63)),
  KEY `parentId` (`parentId`)
) ENGINE=InnoDB AUTO_INCREMENT=0 DEFAULT CHARSET=utf8;

-- Экспортируемые данные не выделены.

-- Дамп структуры для таблица sd.sd_price_group_index
CREATE TABLE IF NOT EXISTS `sd_price_group_index` (
  `id` int NOT NULL AUTO_INCREMENT,
  `groupId` int NOT NULL DEFAULT '0',
  `clinicId` int NOT NULL DEFAULT '0',
  `n` int NOT NULL DEFAULT '0',
  PRIMARY KEY (`id`),
  KEY `groupId` (`groupId`),
  KEY `clinicId` (`clinicId`),
  KEY `n` (`n`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8;

-- Экспортируемые данные не выделены.

-- Дамп структуры для таблица sd.sd_price_items
CREATE TABLE IF NOT EXISTS `sd_price_items` (
  `id` int NOT NULL AUTO_INCREMENT,
  `code` tinytext NOT NULL,
  `name` text NOT NULL,
  `groupId` int DEFAULT NULL,
  `item_type` tinyint DEFAULT NULL,
  `global_price` float DEFAULT NULL,
  `info` text,
  `removed` datetime DEFAULT NULL,
  PRIMARY KEY (`id`),
  KEY `code` (`code`(63))
) ENGINE=InnoDB AUTO_INCREMENT=0 DEFAULT CHARSET=utf8;

-- Экспортируемые данные не выделены.

-- Дамп структуры для таблица sd.sd_price_local
CREATE TABLE IF NOT EXISTS `sd_price_local` (
  `id` int NOT NULL AUTO_INCREMENT,
  `itemId` int NOT NULL,
  `clinicId` int NOT NULL,
  `price` float DEFAULT NULL,
  PRIMARY KEY (`id`),
  KEY `itemId` (`itemId`),
  KEY `clinicId` (`clinicId`)
) ENGINE=MyISAM AUTO_INCREMENT=0 DEFAULT CHARSET=utf8;

-- Экспортируемые данные не выделены.

-- Дамп структуры для таблица sd.sd_promo
CREATE TABLE IF NOT EXISTS `sd_promo` (
  `id` int NOT NULL AUTO_INCREMENT,
  `title` text,
  `startDate` date DEFAULT NULL,
  `endDate` date DEFAULT NULL,
  `clinics` text,
  `html` text,
  PRIMARY KEY (`id`)
) ENGINE=InnoDB AUTO_INCREMENT=0 DEFAULT CHARSET=utf8;

-- Экспортируемые данные не выделены.

-- Дамп структуры для таблица sd.sd_redirect
CREATE TABLE IF NOT EXISTS `sd_redirect` (
  `id` int NOT NULL AUTO_INCREMENT,
  `from` text,
  `to` text,
  PRIMARY KEY (`id`),
  UNIQUE KEY `from` (`from`(64))
) ENGINE=InnoDB AUTO_INCREMENT=0 DEFAULT CHARSET=utf8;

-- Экспортируемые данные не выделены.

-- Дамп структуры для таблица sd.sd_shedule_assign
CREATE TABLE IF NOT EXISTS `sd_shedule_assign` (
  `id` int NOT NULL AUTO_INCREMENT,
  `personId` int DEFAULT NULL,
  `shedule_hash` text,
  `schedule_fio` text,
  PRIMARY KEY (`id`)
) ENGINE=InnoDB AUTO_INCREMENT=0 DEFAULT CHARSET=utf8;

-- Экспортируемые данные не выделены.

-- Дамп структуры для таблица sd.sd_timelines
CREATE TABLE IF NOT EXISTS `sd_timelines` (
  `id` int NOT NULL AUTO_INCREMENT,
  `workplace_hash` tinytext NOT NULL,
  `person_id` int NOT NULL,
  PRIMARY KEY (`id`),
  UNIQUE KEY `workplace_hash_person_id` (`workplace_hash`(32),`person_id`),
  KEY `workplace_hash` (`workplace_hash`(32)),
  KEY `person_id` (`person_id`)
) ENGINE=InnoDB AUTO_INCREMENT=0 DEFAULT CHARSET=utf8;

-- Экспортируемые данные не выделены.

-- Дамп структуры для таблица sd.sd_timeline_cells
CREATE TABLE IF NOT EXISTS `sd_timeline_cells` (
  `id` int NOT NULL AUTO_INCREMENT,
  `timelineId` int NOT NULL DEFAULT '0',
  `start` datetime NOT NULL,
  `end` datetime NOT NULL,
  `free` tinyint NOT NULL DEFAULT '0',
  `source` varchar(63) NOT NULL,
  PRIMARY KEY (`id`),
  KEY `timelineId` (`timelineId`),
  KEY `start` (`start`),
  KEY `end` (`end`)
) ENGINE=InnoDB AUTO_INCREMENT=0 DEFAULT CHARSET=utf8;

-- Экспортируемые данные не выделены.

-- Дамп структуры для таблица sd.sd_timeline_changelog
CREATE TABLE IF NOT EXISTS `sd_timeline_changelog` (
  `id` int NOT NULL AUTO_INCREMENT,
  `timelineId` int NOT NULL DEFAULT '0',
  `cellsDate` date DEFAULT NULL,
  `oldCells` text NOT NULL,
  `newCells` text NOT NULL,
  `change_source` varchar(50) DEFAULT NULL,
  PRIMARY KEY (`id`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8;

-- Экспортируемые данные не выделены.

-- Дамп структуры для таблица sd.sd_timeline_days
CREATE TABLE IF NOT EXISTS `sd_timeline_days` (
  `id` int NOT NULL AUTO_INCREMENT,
  `timelineId` int NOT NULL DEFAULT '0',
  `day` date NOT NULL,
  `is_active` tinyint unsigned DEFAULT NULL,
  PRIMARY KEY (`id`),
  UNIQUE KEY `timelineId_day` (`timelineId`,`day`),
  KEY `timelineId` (`timelineId`),
  KEY `day` (`day`)
) ENGINE=InnoDB AUTO_INCREMENT=0 DEFAULT CHARSET=utf8;

-- Экспортируемые данные не выделены.

-- Дамп структуры для таблица sd.sd_traits
CREATE TABLE IF NOT EXISTS `sd_traits` (
  `trait_id` int NOT NULL AUTO_INCREMENT,
  `person_id` int NOT NULL DEFAULT '0' COMMENT 'врач',
  `title` text NOT NULL,
  `description` text NOT NULL,
  `institution_id` int DEFAULT '0',
  `sort` int NOT NULL DEFAULT '0',
  PRIMARY KEY (`trait_id`),
  KEY `FK_sd_traits_sd_persons` (`person_id`),
  KEY `FK_sd_traits_sd_institutions` (`institution_id`),
  CONSTRAINT `FK_sd_traits_sd_institutions` FOREIGN KEY (`institution_id`) REFERENCES `sd_institutions` (`institution_id`),
  CONSTRAINT `FK_sd_traits_sd_persons` FOREIGN KEY (`person_id`) REFERENCES `sd_persons` (`person_id`)
) ENGINE=InnoDB AUTO_INCREMENT=0 DEFAULT CHARSET=utf8;

-- Экспортируемые данные не выделены.

-- Дамп структуры для таблица sd.sd_url_tags
CREATE TABLE IF NOT EXISTS `sd_url_tags` (
  `id` int NOT NULL AUTO_INCREMENT,
  `tag` text NOT NULL,
  `param` text NOT NULL,
  `value` text NOT NULL,
  `route` text,
  PRIMARY KEY (`id`),
  UNIQUE KEY `tag` (`tag`(63))
) ENGINE=InnoDB AUTO_INCREMENT=0 DEFAULT CHARSET=utf8;

-- Экспортируемые данные не выделены.

-- Дамп структуры для таблица sd.sd_users
CREATE TABLE IF NOT EXISTS `sd_users` (
  `id` int unsigned NOT NULL AUTO_INCREMENT,
  `login` tinytext COLLATE utf8mb4_general_ci NOT NULL,
  `hash` text CHARACTER SET utf8mb4 COLLATE utf8mb4_general_ci NOT NULL,
  `is_admin` tinyint NOT NULL DEFAULT '0',
  `clinics` text COLLATE utf8mb4_general_ci NOT NULL,
  `removed` datetime DEFAULT NULL,
  PRIMARY KEY (`id`)
) ENGINE=InnoDB AUTO_INCREMENT=0 DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

-- Экспортируемые данные не выделены.

-- Дамп структуры для таблица sd.sd_workplaces
CREATE TABLE IF NOT EXISTS `sd_workplaces` (
  `id` int NOT NULL AUTO_INCREMENT,
  `workplace_hash` text NOT NULL,
  `clinic_hash` text,
  PRIMARY KEY (`id`),
  UNIQUE KEY `workplace_hash` (`workplace_hash`(32))
) ENGINE=InnoDB AUTO_INCREMENT=0 DEFAULT CHARSET=utf8;
SQL;

        $this->execute($query);
    }

    /**
     * {@inheritdoc}
     */
    public function safeDown()
    {
        echo "m211106_163138_initial cannot be reverted.\n";

        return false;
    }
}
