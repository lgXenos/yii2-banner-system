<?php

namespace lgxenos\yii2\banner\models;

use Yii;

/**
 * This is the model class for table "ads_stat".
 *
 * @property int    $id        ID
 * @property int    $banner_id ID баннера
 * @property string $show_date Дата показа
 * @property int    $cnt_show  Количество показов в дату
 * @property int    $cnt_click Количество кликов в дату
 */
class AdsStat extends \yii\db\ActiveRecord {
	/**
	 * {@inheritdoc}
	 */
	public static function tableName() {
		return 'ads_stat';
	}
	
	/**
	 * {@inheritdoc}
	 */
	public function rules() {
		return [
			[['banner_id', 'show_date', 'cnt_show', 'cnt_click'], 'required'],
			[['banner_id', 'cnt_show', 'cnt_click'], 'integer'],
			[['show_date'], 'safe'],
			[['banner_id', 'show_date'], 'unique', 'targetAttribute' => ['banner_id', 'show_date']],
		];
	}
	
	/**
	 * {@inheritdoc}
	 */
	public function attributeLabels() {
		return [
			'id'        => 'ID',
			'banner_id' => 'ID баннера',
			'show_date' => 'Дата показа',
			'cnt_show'  => 'Количество показов в дату',
			'cnt_click' => 'Количество кликов в дату',
		];
	}
}
