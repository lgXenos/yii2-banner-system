yii2 Баннерная система ( ALPHA !!! )
=============

[![Latest Stable Version](https://poser.pugx.org/lg-xenos/yii2-banner-system/v/stable)](https://packagist.org/packages/lg-xenos/yii2-banner-system)
[![Total Downloads](https://poser.pugx.org/lg-xenos/yii2-banner-system/downloads)](https://packagist.org/packages/lg-xenos/yii2-banner-system)

![yii2 banner system screenshot](https://raw.githubusercontent.com/lgXenos/yii2-banner-system/master/img/main.png "Пример главного экрана")


Особенности (Features)
------------
**(RU)**
+ Лимит показов не по дате, а по количеству
+ Рекламные зоны отдельны для мобильной и десктопа
+ Расчитано на работу в MySql v.5+ из-за [on-duplicate-key-update](https://www.mysqltutorial.org/mysql-insert-or-update-on-duplicate-key-update/) для ускорения статистики

**(EN)**
+ Impression limit by quantity, not by date
+ Advert zones divided to mobile & desktop
+ Work on MySql v.5+ because of [on-duplicate-key-update](https://www.mysqltutorial.org/mysql-insert-or-update-on-duplicate-key-update/) to speed-up stat counters

Установка (Installation)
------------

```shell script
composer require lg-xenos/yii2-banner-system
```

Или добавить в `composer.json` (or add to `composer.json`)

```
"lg-xenos/yii2-banner-system": "*"
```


Использование (Usage)
-----
(in English below)

Добавляем данные строчки в 2 места файла конфигурации приложения (например `frontend/config/main.php`)
```php
	/* ... */
	'bootstrap'           => [ /* ... */ 'adwert' /* ... */ ],
	/* ... */
	'modules'             => [
		/* ... */
		'adwert'   => [
			'class'          => lgxenos\yii2\banner\Module::class,
			'moduleName'     => 'adwert',
			'frontPrettyUrl' => 'asd',
			'layout'         => '@frontend/modules/yiiAdmin/views/layouts/main.php',
		],
		/* ... */
	],
```

Выполняем миграции:
```shell script
yii migrate --migrationPath=@vendor/lgxenos/yii2-banner-system/src/migrations
```

Теперь нужно
+ открыть главную страницу по ссылке: http://localhost/adwert
+ создать зону
+ создать баннер  
+ вставить в view-файл код: `\lgxenos\yii2\banner\BannerModule::setArea(AREA_ID);`

- - - 

English version
----

Let 's add into 2 places of your app-config (for example `frontend/config/main.php`)
```php
	/* ... */
	'bootstrap'           => [ /* ... */ 'adwert' /* ... */ ],
	/* ... */
	'modules'             => [
		/* ... */
		'adwert'   => [
			'class'          => lgxenos\yii2\banner\Module::class,
			'moduleName'     => 'adwert',
			'frontPrettyUrl' => 'asd',
			'layout'         => '@frontend/modules/yiiAdmin/views/layouts/main.php',
		],
		/* ... */
	],
```

Execute migrations:
```shell script
yii migrate --migrationPath=@vendor/lgxenos/yii2-banner-system/src/migrations
```

Now we need
+ open system by link http://localhost/adwert
+ create zone
+ create banner  
+ insert into view-file code: `\lgxenos\yii2\banner\BannerModule::setArea(AREA_ID);`