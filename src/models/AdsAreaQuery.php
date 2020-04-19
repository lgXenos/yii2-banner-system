<?php

namespace lgxenos\yii2\banner\models;

/**
 * This is the ActiveQuery class for [[AdsArea]].
 *
 * @see AdsArea
 */
class AdsAreaQuery extends \yii\db\ActiveQuery {
	/**
	 * @param $areaId
	 *
	 * @return AdsAreaQuery
	 */
	public function getActiveBanners($areaId) {
		return
			$this
				->joinWith('banners', false)
				->andWhere([AdsArea::tableName() . '.[[id]]' => $areaId])
				->andWhere(AdsBanner::tableName() . '.[[is_enabled]]=1')
				->andWhere(AdsBanner::tableName() . '.[[show_remains]]>0');
	}
	
	/**
	 * @inheritdoc
	 * @return AdsAreaQuery[]|array
	 */
	public function all($db = null) {
		return parent::all($db);
	}
	
	/**
	 * @inheritdoc
	 * @return AdsAreaQuery|array|null
	 */
	public function one($db = null) {
		return parent::one($db);
	}
}
