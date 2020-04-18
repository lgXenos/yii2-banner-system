<?php

use lgxenos\yii2\banner\helpers\CommonHelper;
use yii\helpers\Url;

return [
	[
		'class' => 'kartik\grid\CheckboxColumn',
		'width' => '20px',
	],
	//	[
	//		'class' => 'kartik\grid\SerialColumn',
	//		'width' => '30px',
	//	],
	[
		'class'     => '\kartik\grid\DataColumn',
		'attribute' => 'id',
		'width'     => '30px',
		'vAlign'    => 'middle',
		'hAlign'    => 'center',
	],
	[
		'class'               => '\kartik\grid\DataColumn',
		'width'               => '120px',
		'vAlign'              => 'middle',
		'hAlign'              => 'center',
		'attribute'           => 'is_enabled',
		'value'               => function ($model, $key, $index, $widget) {
			$color = $model->is_enabled ? 'green' : 'red';
			$value = CommonHelper::getBooleanDescriptArray()[$model->is_enabled];
			
			return "<b style='color: {$color}'>{$value}</b>";
		},
		'filterType'          => \kartik\grid\GridView::FILTER_SELECT2,
		'filter'              => CommonHelper::getBooleanDescriptArray(),
		'filterWidgetOptions' => [
			'pluginOptions' => ['allowClear' => true],
		],
		'filterInputOptions'  => ['placeholder' => '----'],
		'format'              => 'raw',
	],
	[
		'class'     => '\kartik\grid\DataColumn',
		'attribute' => 'img',
		'format'    => 'raw',
		'width'     => '110px',
		'vAlign'    => 'middle',
		'hAlign'    => 'center',
		'value'     => function ($model) {
			/** @var $model \lgxenos\yii2\banner\models\AdsBanner */
			$r = '';
			if (!empty($model->img)) {
				$r = "<img src=\"{$model->img}\" style=\"max-height: 100px; max-width: 100px;\">";
			}
			
			return $r;
		},
	],
	[
		'class'     => '\kartik\grid\DataColumn',
		'attribute' => 'title',
		'vAlign'    => 'middle',
	],
	[
		'class'          => '\kartik\grid\DataColumn',
		'attribute'      => 'url',
		'vAlign'         => 'middle',
		'contentOptions' => ['style' => 'white-space: normal;'],
	],
	[
		'class'     => '\kartik\grid\DataColumn',
		'attribute' => 'show_remains',
		'vAlign'    => 'middle',
		'width'     => '140px',
		'hAlign'    => 'center',
	],
	[
		'class'     => '\kartik\grid\DataColumn',
		'attribute' => 'user_id',
		'vAlign'    => 'middle',
		'format'    => 'raw',
		'value'     => function ($model) {
			/** @var $model \lgxenos\yii2\banner\models\AdsBanner */
			return CommonHelper::getUserById($model->user_id);
		},
	],
	[
		'class'     => '\kartik\grid\DataColumn',
		'attribute' => 'area_id',
		'vAlign'    => 'middle',
		'hAlign'    => 'center',
		'format'    => 'raw',
		'value'     => function ($model) {
			/** @var $model \lgxenos\yii2\banner\models\AdsBanner */
			return
				'<a href="' . Url::to(['ads-area/index', 'AdsAreaSearch[id]' => $model->area_id]) . '">' .
				'№' . $model->area_id . '<br>' .
				sprintf("%s (%sx%s, %s)", $model->area->title, $model->area->width, $model->area->heigth, $model->area->area_type) .
				'</a>';
		},
	],
	[
		'class'     => '\kartik\grid\DataColumn',
		'attribute' => 'weigth',
		'vAlign'    => 'middle',
		'hAlign'    => 'center',
		'width'     => '50px',
	],
	// [
	// 'class'=>'\kartik\grid\DataColumn',
	// 'attribute'=>'notice',
	// ],
	// [
	[
		'class'         => 'kartik\grid\ActionColumn',
		'dropdown'      => false,
		'vAlign'        => 'middle',
		'urlCreator'    => function ($action, $model, $key, $index) {
			return Url::to([$action, 'id' => $key]);
		},
		'viewOptions'   => ['role' => 'modal-remote', 'title' => 'Просмотр', 'data-toggle' => 'tooltip'],
		'updateOptions' => ['role' => 'modal-remote', 'title' => 'Правка', 'data-toggle' => 'tooltip'],
		'deleteOptions' => [
			'role'                 => 'modal-remote',
			'title'                => 'Удаление',
			'data-confirm'         => false,
			'data-method'          => false,// for overide yii data api
			'data-request-method'  => 'post',
			'data-toggle'          => 'tooltip',
			'data-confirm-title'   => 'Вы уверены?',
			'data-confirm-message' => 'Вы точно хотите удалить эту запись?',
		],
	],

];   