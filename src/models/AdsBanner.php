<?php

namespace lgxenos\yii2\banner\models;

use Yii;
use yii\base\ErrorException;

/**
 * This is the model class for table "ads_banner".
 *
 * @property int         $id           ID
 * @property string      $title        Название
 * @property string      $img          Изображение
 * @property int         $weigth       Вес
 * @property int         $show_remains Остаток показов
 * @property int         $user_id      ID пользователя
 * @property int         $area_id      ID баннерной зоны
 * @property string|null $notice       Заметка для себя
 * @property int         $is_enabled   Включен
 * @property int         $hash         Служебный хэш
 *                                     
 * @property AdsArea     $area         Зона установки банера
 */
class AdsBanner extends \yii\db\ActiveRecord {
	/**
	 * {@inheritdoc}
	 */
	public static function tableName() {
		return 'ads_banner';
	}
	
	/**
	 * {@inheritdoc}
	 */
	public function rules() {
		return [
			[['title', 'img', 'show_remains', 'user_id', 'area_id'], 'required'],
			[['weigth', 'show_remains', 'user_id', 'area_id', 'is_enabled'], 'integer'],
			[['title'], 'string', 'max' => 250],
			[['hash'], 'string', 'max' => 32],
			[['img'], 'string', 'max' => 512],
			[['notice'], 'string', 'max' => 1024],
		];
	}
	
	/**
	 * {@inheritdoc}
	 */
	public function attributeLabels() {
		return [
			'id'           => 'ID',
			'title'        => 'Название',
			'img'          => 'Изображение',
			'weigth'       => 'Вес',
			'show_remains' => 'Остаток показов',
			'user_id'      => 'ID пользователя',
			'area_id'      => 'ID баннерной зоны',
			'notice'       => 'Заметка для себя',
			'is_enabled'   => 'Включен',
			'hash'         => 'Служебный хэш',
		];
	}
	
	/**
	 * {@inheritdoc}
	 */
	public function beforeSave($insert) {
		if (empty($this->hash)) {
			$this->hash = md5(time() . $this->title);
		}
		
		return parent::beforeSave($insert);
	}
	
	
	/**
	 * Реляция на банеры
	 *
	 * @return \yii\db\ActiveQuery
	 */
	public function getArea() {
		//                             <--------------->
		return $this->hasOne(AdsArea::class, ['id' => 'area_id']);
		//                                              selfModel  -> ^
	}
	
	public function delete() {
		if($this->show_remains){
			throw new ErrorException('Нельзя удалять активные баннера');
		}
		return parent::delete();
	}
}
