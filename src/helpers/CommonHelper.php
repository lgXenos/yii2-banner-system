<?php

namespace lgxenos\yii2\banner\helpers;

use common\models\User;
use lgxenos\yii2\banner\BannerModule;
use yii;
use yii\base\BaseObject;

class CommonHelper extends BaseObject {
	/**
	 * отдаем массив для булевых значений и визуализации
	 *
	 * @return array
	 */
	public static function getBooleanDescriptArray() {
		return [0 => 'Нет', 1 => 'Да'];
	}
	
	/**
	 * отдаем картинку мобилки в виде base64
	 *
	 * @return string
	 */
	public static function getImgMobile() {
		return 'data:image/png;base64,iVBORw0KGgoAAAANSUhEUgAAACQAAAA8CAMAAAA5W+hcAAAAhFBMVEUAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAD8qm6wAAAAK3RSTlMA8GjyPvyTGnrsoVtl4Ng9pnhtXVJORPTAj4N/dOnGraCZhybOuGFUNBMJvBLllgAAANxJREFUSMft1MluwjAUheFDXBLaYjfzzNz5vP/71S6BFb4WEsv8i0ixvoUH6QL4TnXz7KnRuxq2FQPFQMlgOd6djVae8mNDGijyAKGMVA6tJfQ2oQyJN1TkwqGl2ITk7kFpFXkrO4vCp5tQJKGnGc1oRjN6LLpnPrVD7K3fPXywbruXS+l+GMfskF4X4o9bG0+y4RQarDltnXxPyZKuWkRr/teLqDqjUURondG/8rP8bElzunG6HkKfpIKxn6h6vVR81XVZXH/LQpMaEYMdgX3ItLAVZqMWntTG5MAfAb9iS4R7ksgAAAAASUVORK5CYII=';
	}
	
	/**
	 * отдаем картинку компа в виде base64
	 *
	 * @return string
	 */
	public static function getImgPc() {
		return 'data:image/png;base64,iVBORw0KGgoAAAANSUhEUgAAAEoAAAA8CAMAAAD2ddyfAAAAeFBMVEUAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAVyEiIAAAAJ3RSTlMAvPJDYoD4hlTRxohpTS/87eDdsa+nnJR9c205KR0XEgXluEZFDQmdwSmsAAAAy0lEQVRYw+3XtxqDMAxF4WvHmE56b6Tq/d8w2MkYDwZt6F/udj6tQudtVvOp7s3eivQMryYGKToZsdgAV008MhyISQHlN1+q3u7KusQMMzeLFkMkrqGh3SgMYkaSWvCllKQkJSlJSUpSkpKUpMaS0lkz6e+0+qa2xGSOIzHZAGtiYc8AcuLwgFNaGqpo8NPsyySkUv7+dJ8EpLv6EvWivdDf5GC859JfVWXGqcwVsUoKyFvEOVHQDnGOFLRGnIulEINItZ7qPyxtEfABfNSt88HArxAAAAAASUVORK5CYII=';
	}
	
	/**
	 * получаем ник юзера из переданной модели пользователя или просто его ID
	 *
	 * @param $id
	 *
	 * @return string
	 */
	public static function getUserById($id){
		$module = BannerModule::getModuleInstance();

		try{
			$uModel = $module->userModel;
			$u = $uModel::findOne($id);
			/** @var $u User */
			return $u->{$module->userModelName};
		}
		catch (\Throwable $e){
			return 'User id #'. $id;
		}
		
	}
}