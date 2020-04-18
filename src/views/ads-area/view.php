<?php

use yii\widgets\DetailView;

/* @var $this yii\web\View */
/* @var $model lgxenos\yii2\banner\models\AdsArea */
?>
<div class="ads-area-view">
	
	<?= DetailView::widget([
		'model'      => $model,
		'attributes' => [
			'id',
			'title',
			'description',
			'area_type',
			'is_enabled',
		],
	]) ?>

</div>
