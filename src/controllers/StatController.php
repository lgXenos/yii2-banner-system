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
class StatController extends Controller {
	/**
	 * Renders the index view for the module
	 * @return string
	 */
	public function actionIndex() {
		$resultTable = [];
		if (\Yii::$app->request->isPost) {
		
		}
		
		//$banner
		
		return $this->render('index', [
			'areasList' => AdsArea::getDropdownList(),
		]);
	}
	
	public function actionGetBanners4Zone() {
		//AdsBanner::getDropdownListByArea($areaId);
	}
}
