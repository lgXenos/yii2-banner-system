<?php
/*
*   RomanSh Migrate Tpl ;)
*
*            https://github.com/yiisoft/yii2/blob/master/docs/guide-ru/db-migrations.md
*/

use yii\db\Migration;

class m200416_141921_add_adwert_tables extends Migration {
	private $up = [
		"
CREATE TABLE `ads_area` (
  `id` bigint(16) unsigned NOT NULL AUTO_INCREMENT COMMENT 'ID',
  `title` varchar(250) NOT NULL COMMENT 'Название',
  `description` varchar(2048) NOT NULL COMMENT 'Описание',
  `zone_type` enum('mobile','desktop') NOT NULL COMMENT 'Тип зоны',
  `width` int(8) UNSIGNED NOT NULL COMMENT 'Ширина',
  `heigth` int(8) UNSIGNED NOT NULL COMMENT 'Высота',
  `is_enabled` tinyint(1) NOT NULL DEFAULT '1' COMMENT 'Зона включена',
  PRIMARY KEY (`id`),
  KEY `zone_type` (`zone_type`),
  KEY `is_enabled` (`is_enabled`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8 COMMENT='Баннерные зоны';
	",
		"
CREATE TABLE `ads_banner` (
  `id` bigint(16) unsigned NOT NULL AUTO_INCREMENT COMMENT 'ID',
  `title` varchar(250) NOT NULL COMMENT 'Название',
  `img` varchar(512) NOT NULL COMMENT 'Изображение',
  `weigth` int(8) unsigned NOT NULL DEFAULT '100' COMMENT 'Вес',
  `show_remains` bigint(16) unsigned NOT NULL COMMENT 'Остаток показов',
  `user_id` bigint(16) unsigned NOT NULL COMMENT 'ID пользователя',
  `zone_id` bigint(16) unsigned NOT NULL COMMENT 'ID баннерной зоны',
  `notice` varchar(1024) DEFAULT NULL COMMENT 'Заметка для себя',
  `is_enabled` tinyint(1) NOT NULL DEFAULT '0' COMMENT 'Включен',
  `hash` varchar(32) NOT NULL COMMENT 'Служебный хэш',
  PRIMARY KEY (`id`),
  KEY `show_remains` (`show_remains`),
  KEY `is_enabled` (`is_enabled`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8 COMMENT='Банеры';
	",
		"
CREATE TABLE `ads_stat` (
  `id` bigint(16) unsigned NOT NULL AUTO_INCREMENT COMMENT 'ID',
  `banner_id` bigint(16) unsigned NOT NULL COMMENT 'ID баннера',
  `show_date` date NOT NULL COMMENT 'Дата показа',
  `cnt_show` int(8) unsigned NOT NULL COMMENT 'Количество показов в дату',
  `cnt_click` int(8) unsigned NOT NULL COMMENT 'Количество кликов в дату',
  PRIMARY KEY (`id`),
  UNIQUE KEY `banner_id__date` (`banner_id`,`show_date`) USING BTREE,
  KEY `show_date` (`show_date`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8 COMMENT='Статистика показа баннеров';
	",
	];
	
	public function up() {
		
		foreach ($this->up as $sql) {
			$this->execute($sql);
		}
		
		return true;
	}
	
	public function down() {
		$this->dropTable('ads_area');
		$this->dropTable('ads_banner');
		$this->dropTable('ads_stat');
	}
}