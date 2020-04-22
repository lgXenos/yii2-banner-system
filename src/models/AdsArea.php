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
			[['title', 'area_type'], 'required'],
			[['area_type'], 'in', 'range' => array_keys(self::getTypesArray())],
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
			'area_type'   => 'Тип зоны',
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
	
	/**
	 * предотвращаем удаление зоны, к которой привязаны баннеры
	 *
	 * @return false|int
	 * @throws ErrorException
	 * @throws \Throwable
	 * @throws \yii\db\StaleObjectException
	 */
	public function delete() {
		if ($this->getBanners()->count()) {
			throw new ErrorException('Нельзя удалить зону, за которой закреплены баннеры.');
		}
		
		return parent::delete();
	}
	
	/**
	 * получаем общую статистику по баннерам в этой зоне: total + active
	 *
	 *
	 * @return array
	 */
	public function getLinkedBannersOverview() {
		static $ret;
		if (!$ret) {
			$ret = [
				'total'  => $this->getBanners()->count(),
				'active' => $this->getBanners()->andWhere(['is_enabled' => 1])->count(),
			];
		}
		
		return $ret;
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
	
	/**
	 * список для выпадашек
	 *
	 * @return array
	 */
	public static function getDropdownList() {
		return self::find()
			->select(["CONCAT(title,' (', width, 'x', heigth, ', ', area_type, ')') as title"])
			->indexBy('id')
			->orderBy('title ASC')
			->asArray()
			->column();
	}
	
	/**
	 * получить ID баннеров и их веса
	 *
	 * @return array|AdsAreaQuery[]
	 */
	public function getBannerIdAndWeigth() {
		return self::find()
			->getActiveBanners($this->id)
			->select([AdsBanner::tableName() . '.[[id]] AS id', AdsBanner::tableName() . '.[[weigth]] AS weigth',])
			->asArray()
			->all();
	}
	
	/**
	 * @inheritdoc
	 * @return AdsAreaQuery the active query used by this AR class.
	 */
	public static function find() {
		return new AdsAreaQuery(get_called_class());
	}
}
