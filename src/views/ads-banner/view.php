<?php

use yii\widgets\DetailView;

/* @var $this yii\web\View */
/* @var $model lgxenos\yii2\banner\models\AdsBanner */
?>
<div class="ads-banner-view">
	
	<?= DetailView::widget([
		'model'      => $model,
		'attributes' => [
			'id',
			'title',
			'img',
			'weigth',
			'show_remains',
			'cnt_show',
			'cnt_click',
			'user_id',
			'area_id',
			'notice',
			'is_enabled',
			'hash',
			'created_at',
		],
	]) ?>


</div>
