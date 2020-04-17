<?php

namespace lgxenos\yii2\banner;

use yii\base\BootstrapInterface;
use yii\base\ErrorException;

/**
 * banner module definition class
 */
class BannerModule extends \yii\base\Module implements BootstrapInterface {
	/** @var string $moduleName - имя при подключении через конфиг */
	public $moduleName;
	/** @var string $frontPrettyUrl - красивый урл для фронта */
	public $frontPrettyUrl;
	
	/**
	 * @param \yii\base\Application $app
	 *
	 * @throws ErrorException
	 */
	public function bootstrap($app) {
		
		if (empty($this->frontPrettyUrl)) {
			throw new ErrorException('You must pass module alias from your config');
		}
		
		if (empty($this->moduleName)) {
			throw new ErrorException('You must specify module pretty link from frontend in your config');
		}
		
		// правила роутов
		$app->getUrlManager()->addRules([
			$this->frontPrettyUrl => '',
		]);
	}
	
	/**
	 * {@inheritdoc}
	 */
	public $controllerNamespace = 'lgxenos\yii2\banner\controllers';
	
	/**
	 * {@inheritdoc}
	 */
	public function init() {
		parent::init();
		
		// custom initialization code goes here
	}
	
	public static function setArea($id) {
		static $moduleInstance;
		if (!$moduleInstance) {
			foreach (\Yii::$app->loadedModules as $module) {
				if ($module instanceof BannerModule) {
					$moduleInstance = $module;
					iout($module);
				}
			}
		}
		if (!$moduleInstance) {
			echo "<!-- module init error -->";
		}
	}
}