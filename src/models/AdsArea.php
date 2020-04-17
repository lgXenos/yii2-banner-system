<?php

namespace lgxenos\yii2\banner\models;

use Yii;
use yii\base\ErrorException;

/**
 * This is the model class for table "ads_area".
 *
 * @property int    $id          ID
 * @property string $title       Название
 * @property string $description Заметка-описание
 * @property string $zone_type   Тип зоны
 * @property string $width       Ширина, px
 * @property string $heigth      Высота, px
 * @property int    $is_enabled  Зона включена
 */
class AdsArea extends \yii\db\ActiveRecord {
	const ADS_AREA_TYPE_MOBILE  = 'mobile';
	const ADS_AREA_TYPE_DESKTOP = 'desktop';
	
	/**
	 * {@inheritdoc}
	 */
	public static function tableName() {
		return 'ads_area';
	}
	
	/**
	 * {@inheritdoc}
	 */
	public function rules() {
		return [
			[['title', 'zone_type'], 'required'],
			[['zone_type'], 'in', 'range' => array_keys(self::getTypesArray())],
			[['is_enabled'], 'integer', 'min' => 0, 'max' => 1],
			[['width', 'heigth'], 'integer', 'min' => 0, 'max' => 5000],
			[['title'], 'string', 'max' => 250],
			[['description'], 'string', 'max' => 2048],
		];
	}
	
	/**
	 * {@inheritdoc}
	 */
	public function attributeLabels() {
		return [
			'id'          => 'ID',
			'title'       => 'Название',
			'description' => 'Заметка-описание',
			'zone_type'   => 'Тип зоны',
			'width'       => 'Ширина, px',
			'heigth'      => 'Высота, px',
			'is_enabled'  => 'Зона включена',
		];
	}
	
	/**
	 * Реляция на банеры
	 *
	 * @return \yii\db\ActiveQuery
	 */
	public function getBanners() {
		//                             <--------------->
		return $this->hasMany(AdsBanner::class, ['area_id' => 'id']);
		//                                              selfModel  -> ^
	}
	
	public function delete() {
		if ($this->getBanners()->count()) {
			throw new ErrorException('Нельзя удалить зону, за которой закреплены баннеры.');
		}
		
		return parent::delete();
	}
	
	/**
	 * типы банерных зон: мобила и десктоп
	 *
	 * @return array
	 */
	public static function getTypesArray() {
		return [
			self::ADS_AREA_TYPE_MOBILE  => 'Мобильная',
			self::ADS_AREA_TYPE_DESKTOP => 'Десктопная',
		];
	}
	
	public static function getDropdownList() {
		return self::find()
			->select(["CONCAT(title,' (', width, 'x', heigth, ', ', zone_type, ')') as title"])
			->indexBy('id')
			->orderBy('title ASC')
			->asArray()
			->column();
	}
}
