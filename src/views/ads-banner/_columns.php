<?php

use yii\helpers\Url;

return [
	[
		'class' => 'kartik\grid\CheckboxColumn',
		'width' => '20px',
	],
	[
		'class' => 'kartik\grid\SerialColumn',
		'width' => '30px',
	],
	// [
	// 'class'=>'\kartik\grid\DataColumn',
	// 'attribute'=>'id',
	// ],
	[
		'class'     => '\kartik\grid\DataColumn',
		'attribute' => 'title',
	],
	[
		'class'     => '\kartik\grid\DataColumn',
		'attribute' => 'img',
	],
	[
		'class'     => '\kartik\grid\DataColumn',
		'attribute' => 'weigth',
	],
	[
		'class'     => '\kartik\grid\DataColumn',
		'attribute' => 'show_remains',
	],
	[
		'class'     => '\kartik\grid\DataColumn',
		'attribute' => 'user_id',
	],
	// [
	// 'class'=>'\kartik\grid\DataColumn',
	// 'attribute'=>'zone_id',
	// ],
	// [
	// 'class'=>'\kartik\grid\DataColumn',
	// 'attribute'=>'notice',
	// ],
	// [
	// 'class'=>'\kartik\grid\DataColumn',
	// 'attribute'=>'is_enabled',
	// ],
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