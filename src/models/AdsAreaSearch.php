<?php

namespace lgxenos\yii2\banner\models;

use Yii;
use yii\base\Model;
use yii\data\ActiveDataProvider;
use lgxenos\yii2\banner\models\AdsArea;

/**
 * AdsAreaSearch represents the model behind the search form about `\lgxenos\yii2\banner\models\AdsArea`.
 */
class AdsAreaSearch extends AdsArea {
	/**
	 * @inheritdoc
	 */
	public function rules() {
		return [
			[['id'], 'integer'],
			[['title', 'description', 'area_type', 'is_enabled'], 'safe'],
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
		$query = AdsArea::find();
		
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
			'id' => $this->id,
		]);
		
		$query->andFilterWhere(['like', 'title', $this->title])
			->andFilterWhere(['like', 'description', $this->description])
			->andFilterWhere(['like', 'area_type', $this->area_type])
			->andFilterWhere(['like', 'is_enabled', $this->is_enabled]);
		
		return $dataProvider;
	}
}
