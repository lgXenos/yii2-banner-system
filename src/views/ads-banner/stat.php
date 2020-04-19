<?php

use yii\widgets\DetailView;

/* @var $this yii\web\View */
/* @var $model lgxenos\yii2\banner\models\AdsBanner */

$this->title                   = 'Статистика по баннеру ';
$this->params['breadcrumbs'][] = $this->title;

$minDate = date("d.m.Y", strtotime($model->getAdsDailyStatArray()['min_date'] . ' 00:00:00'));
$maxDate = date("d.m.Y", strtotime($model->getAdsDailyStatArray()['max_date'] . ' 00:00:00'));

?>
<div class="ads-banner-stat">
	<?= $this->render('../_parts/menu'); ?>
	
	<?php if (count($model->getAdsDailyStatArray()['stat'])): ?>
		<h1>Статистика с <?= $minDate ?> по <?= $maxDate ?></h1>

		<div style="width: 360px; margin: auto">
			<?= DetailView::widget([
				'model'      => $model,
				'attributes' => [
					'title',
					'show_remains',
					'cnt_show',
					'cnt_click',
					'is_enabled',
				],
			]) ?>
			<table width="100%" class="statTable">
				<tr>
					<th>Дата</th>
					<th>Показы</th>
					<th>Переходы</th>
				</tr>
				<?php foreach ($model->getAdsDailyStatArray()['stat'] as $item): ?>
					<tr>
						<td><?= date('d.m.Y', strtotime($item['show_date'])) ?></td>
						<td><?= $item['cnt_show'] ?></td>
						<td><?= $item['cnt_click'] ?></td>
					</tr>
				<?php endforeach; ?>
			</table>
		</div>
	<?php else: ?>
		<h1>По данному баннеру статистики еще не собрано</h1>
	<?php endif; ?>
</div>
<style type="text/css">
	.statTable tr:nth-child(2n) {
		background-color: #f1f1f1;
	}

	.statTable th {
		text-align: center;
		font-size: 18px;
	}

	.statTable td {
		text-align: center;
		font-size: 16px;
	}
</style>