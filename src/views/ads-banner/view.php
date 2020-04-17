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
			'user_id',
			'zone_id',
			'notice',
			'is_enabled',
		],
	]) ?>

</div>
