<?php

namespace lgxenos\yii2\banner\models;

use Yii;
use yii\base\Model;
use yii\data\ActiveDataProvider;
use lgxenos\yii2\banner\models\AdsBanner;

/**
 * AdsBannerSearch represents the model behind the search form about `\lgxenos\yii2\banner\models\AdsBanner`.
 */
class AdsBannerSearch extends AdsBanner {
	/**
	 * @inheritdoc
	 */
	public function rules() {
		return [
			[['id', 'weigth', 'show_remains', 'user_id', 'area_id'], 'integer'],
			[['title', 'img', 'notice', 'is_enabled'], 'safe'],
		];
	}
	
	/**
	 * @inheritdoc
	 */
	public function scenarios() {
		// bypass scenarios() implementation in the parent class
		return Model::scenarios();
	}
	
	/**
	 * Creates data provider instance with search query applied
	 *
	 * @param array $params
	 *
	 * @return ActiveDataProvider
	 */
	public function search($params) {
		$query = AdsBanner::find();
		
		$dataProvider = new ActiveDataProvider([
			'query' => $query,
		]);
		
		$this->load($params);
		
		if (!$this->validate()) {
			// uncomment the following line if you do not want to return any records when validation fails
			// $query->where('0=1');
			return $dataProvider;
		}
		
		$query->andFilterWhere([
			'id'           => $this->id,
			'weigth'       => $this->weigth,
			'show_remains' => $this->show_remains,
			'user_id'      => $this->user_id,
			'area_id'      => $this->area_id,
		]);
		
		$query->andFilterWhere(['like', 'title', $this->title])
			->andFilterWhere(['like', 'img', $this->img])
			->andFilterWhere(['like', 'notice', $this->notice])
			->andFilterWhere(['like', 'is_enabled', $this->is_enabled]);
		
		return $dataProvider;
	}
}
