<?php

use yii\helpers\Url;
use lgxenos\yii2\banner\models\AdsArea;
use lgxenos\yii2\banner\helpers\CommonHelper;

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
		'hAlign'    => 'center',
		'width'     => '30px',
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
		'class'               => '\kartik\grid\DataColumn',
		'attribute'           => 'zone_type',
		'width'               => '145px',
		'hAlign'              => 'center',
		'value'               => function ($model, $key, $index, $widget) {
			//return AdsArea::getTypesArray()[$model->zone_type];
			$img = $model->zone_type == AdsArea::ADS_AREA_TYPE_DESKTOP ? CommonHelper::getImgPc() : CommonHelper::getImgMobile();
			
			return "<img src='{$img}' style='height: 20px;'>";
		},
		'filterType'          => \kartik\grid\GridView::FILTER_SELECT2,
		'filter'              => AdsArea::getTypesArray(),
		'filterWidgetOptions' => [
			'pluginOptions' => ['allowClear' => true],
		],
		'filterInputOptions'  => ['placeholder' => '----'],
		'format'              => 'raw',
	],
	[
		'class'  => '\kartik\grid\DataColumn',
		'label'  => 'Размеры',
		'format' => 'raw',
		'hAlign' => 'center',
		'width'  => '120px',
		'value'  => function ($model) {
			return "{$model->width}x{$model->heigth}";
		},
	],
	[
		'class'     => '\kartik\grid\DataColumn',
		'attribute' => 'title',
	],
	[
		'class'     => '\kartik\grid\DataColumn',
		'attribute' => 'description',
	],
	
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