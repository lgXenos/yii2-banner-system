<?php

namespace lgxenos\yii2\banner;

use lgxenos\yii2\banner\models\AdsArea;
use yii\base\BootstrapInterface;
use yii\base\ErrorException;
use yii\web\View;

/**
 * banner module definition class
 */
class BannerModule extends \yii\base\Module implements BootstrapInterface {
	/** @var string $frontPrettyUrl - красивый урл для фронта */
	public $frontPrettyUrl = '/asd/';
	/** @var string $userModel - клас модели юзеров */
	public $userModel = \common\models\User::class;
	/** @var string $userModel - имя поля из модели юзеров */
	public $userModelName = 'username';
	/** @var string $uploadPath - путь загрузки картинок, поддерживает параметр ID пользователя */
	public $uploadPath = '@frontend/web/upload/bnr/%USER_ID%/';
	/** @var string $uploadWebPath - путь отображения картинок, поддерживает параметр ID пользователя */
	public $uploadWebPath = '/upload/bnr/%USER_ID%/';
	/** @var string $uploadWebPath - путь отображения картинок, поддерживает параметр ID пользователя */
	public $mobileWidth = 768;
	/** @var bool - использовать мягкие, max-heigth, а не жесткие height */
	public $useSoftAreaSizes = false;
	
	/**
	 * @param \yii\base\Application $app
	 *
	 * @throws ErrorException
	 */
	public function bootstrap($app) {
		
		// правила роутов
		$app->getUrlManager()->addRules([
			$this->frontPrettyUrl => (self::getModuleInstance())->id . '/default/front',
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
	}
	
	/**
	 * ищем в приложении свой инстанс, чтоб обращаться к параметрам
	 * вероятно есть иной способ, но я о нем не знаю
	 *
	 * @return BannerModule|null
	 */
	public static function getModuleInstance() {
		/** @var $moduleInstance $module */
		static $moduleInstance;
		if (!$moduleInstance) {
			foreach (\Yii::$app->loadedModules as $module) {
				if ($module instanceof BannerModule) {
					$moduleInstance = $module;
				}
			}
		}
		
		return $moduleInstance;
	}
	
	/**
	 * резервируем данный участок в шаблоне под рекламную зону
	 *
	 * @param $id
	 */
	public static function setArea($id) {
		$moduleInstance = self::getModuleInstance();
		if (!$moduleInstance) {
			echo "<!-- ads module init error -->";
			
			return;
		}
		$area = AdsArea::findOne($id);
		if (!$area) {
			echo "<!-- ads area not found -->";
			
			return;
		}
		if (!$area->is_enabled) {
			echo "<!-- ads area disabled -->";
			
			return;
		}
		
		static $init = null;
		static $adsClass = null;
		if (is_null($init)) {
			$adsClass    = bin2hex(random_bytes(round(mt_rand(1, 12))));
			$csrf        = "'" . \Yii::$app->request->csrfParam . "' : '" . \Yii::$app->request->getCsrfToken() . "'";
			$isMobile    = AdsArea::ADS_AREA_TYPE_MOBILE;
			$isDesktop   = AdsArea::ADS_AREA_TYPE_DESKTOP;
			$mobileWidth = $moduleInstance->mobileWidth;
			$init        = <<<JS
			    var classId = '{$adsClass}';
				function rShX() {
				  $('.' + classId).each(function() {
				  	var t = $(this);
				  	var ww = window.innerWidth;
				  	if(t.data('loaded')){
				  	  return;
				  	}
				  	if(t.data('type')=='{$isMobile}' && ww > {$mobileWidth}){
				  	  return;
				  	}
				  	else if(t.data('type')=='{$isDesktop}' && ww < {$mobileWidth}){
				  	  return;
				  	}
				  	if(t.data('busy')){
				  	  return;
				  	}
				  	t.attr('data-busy', 1);
				  	
				  	var aId = t.data('id');
				    $.post('{$moduleInstance->frontPrettyUrl}', {
				      $csrf,
				      action:'get',
				      id: aId
				    }, function(data){
				      t.attr('data-loaded', 1);
				      t.attr('data-busy', null);
				      t.removeClass(classId);
				      t.append(data);
				    });
				  });
				};
				setTimeout(function(){rShX();}, 300);
				window.addEventListener("resize", rShX);
				
				window.rShC = function(hash, e) {
				  window.open('{$moduleInstance->frontPrettyUrl}?action=go&id=' + hash);
				}
				
JS;
			\Yii::$app->controller->view->registerJs(
				preg_replace(["/\n/", "/\t/", "/\s{2}/"], '', $init), View::POS_READY
			);
		}
		
		if ($moduleInstance->useSoftAreaSizes) {
			$styleSizes = "max-width:{$area->width}px; max-height:{$area->heigth}px;";
		}
		else {
			$styleSizes = "width:{$area->width}px; height:{$area->heigth}px;";
		}
		
		echo <<<HTML
			<div class="{$adsClass}"
				 data-id="{$area->id}"
				 data-type="{$area->area_type}"
				 data-loaded="0"
				 style="overflow: hidden;{$styleSizes}"
			></div>
HTML;
	}
}
