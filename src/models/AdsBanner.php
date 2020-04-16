<?php

namespace lgxenos\yii2\banner\models;

use Yii;

/**
 * This is the model class for table "ads_banner".
 *
 * @property int         $id           ID
 * @property string      $title        Название
 * @property string      $img          Изображение
 * @property int         $weigth       Вес
 * @property int         $show_remains Остаток показов
 * @property int         $user_id      ID пользователя
 * @property int         $zone_id      ID баннерной зоны
 * @property string|null $notice       Заметка для себя
 * @property int         $is_enabled   Включен
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
			[['title', 'img', 'show_remains', 'user_id', 'zone_id'], 'required'],
			[['weigth', 'show_remains', 'user_id', 'zone_id', 'is_enabled'], 'integer'],
			[['title'], 'string', 'max' => 250],
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
			'zone_id'      => 'ID баннерной зоны',
			'notice'       => 'Заметка для себя',
			'is_enabled'   => 'Включен',
		];
	}
}
