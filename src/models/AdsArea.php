<?php

namespace lgxenos\yii2\banner\models;

use Yii;

/**
 * This is the model class for table "ads_area".
 *
 * @property int    $id          ID
 * @property string $title       Название
 * @property string $description Описание
 * @property string $zone_type   Тип зоны
 * @property int    $is_enabled  Зона включена
 */
class AdsArea extends \yii\db\ActiveRecord {
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
			[['title', 'description', 'zone_type'], 'required'],
			[['zone_type'], 'string'],
			[['is_enabled'], 'integer'],
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
			'description' => 'Описание',
			'zone_type'   => 'Тип зоны',
			'is_enabled'  => 'Зона включена',
		];
	}
}
