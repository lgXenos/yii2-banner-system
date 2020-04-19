<?php

namespace lgxenos\yii2\banner\controllers;

use lgxenos\yii2\banner\helpers\CommonHelper;
use lgxenos\yii2\banner\models\AdsArea;
use lgxenos\yii2\banner\models\AdsBanner;
use yii\filters\VerbFilter;
use yii\web\Controller;

/**
 * Default controller for the `banner` module
 */
class DefaultController extends Controller {
	/**
	 * Renders the index view for the module
	 * @return string
	 */
	public function actionIndex() {
		return $this->render('index');
	}
	
	/**
	 * обрабатывает запросы с фронта
	 *
	 * @param $action
	 */
	public function actionFront() {
		
		$id     = \Yii::$app->request->get('id', \Yii::$app->request->post('id'));
		$action = \Yii::$app->request->get('action', \Yii::$app->request->post('action'));
		
		switch ($action) {
			case 'get':
			{
				if (!\Yii::$app->request->isPost) {
					return;
				}
				
				return $this->_getBannerFromArea((int)$id);
			}
			case 'go':
			{
				$banner = AdsBanner::find()->where(['hash' => $id])->one();
				if ($banner) {
					$banner->addClick();
					
					return $this->redirect($banner->url);
				}
			}
		}
	}
	
	/**
	 * получаем код для вывода банера
	 *
	 * @param $areaId
	 *
	 * @return string
	 */
	private function _getBannerFromArea($areaId) {
		$area = AdsArea::findOne($areaId);
		if (!$area->is_enabled) {
			return '<!-- ads area disabled -->';
		}
		$bannersIdsArray = $area->getBannerIdAndWeigth();
		if (!is_array($bannersIdsArray) || !count($bannersIdsArray)) {
			return '<!-- ads area havnt banners  -->';
		}
		if (count($bannersIdsArray) == 1) {
			return $this->_renderBannerById(current($bannersIdsArray)['id']);
		}
		$ids     = [];
		$weigths = [];
		foreach ($bannersIdsArray as $item) {
			$ids[]     = $item['id'];
			$weigths[] = $item['weigth'];
		}
		$val = CommonHelper::weighted_random($ids, $weigths);
		
		return $this->_renderBannerById($val);
	}
	
	/**
	 * @param $bannerId
	 *
	 * @return string
	 */
	private function _renderBannerById($bannerId) {
		$banner = AdsBanner::findOne($bannerId);
		if (!$banner) {
			return '<!-- banner not found -->';
		}
		$banner->addShow();
		
		return $this->renderPartial('banner', [
			'banner' => $banner,
		]);
	}
}
