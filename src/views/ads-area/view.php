<?php

use yii\helpers\Url;
use yii\widgets\DetailView;

/* @var $this yii\web\View */
/* @var $model lgxenos\yii2\banner\models\AdsArea */
?>
<div class="ads-area-view">
	
	<?php if (!$model->isNewRecord): ?>
		<div class="form-group field-adsarea-stat">
			<label class="control-label" for="adsarea-stat">Привязано банеров:</label>
			<div class="help-block">
				<table>
					<tr>
						<td>Всего:</td>
						<td>&nbsp;</td>
						<td><b><?= $model->getLinkedBannersOverview()['total'] ?></b></td>
						<td>&nbsp;</td>
						<td>
							<a href="<?= Url::to([
								'ads-banner/index',
								'AdsBannerSearch[area_id]' => $model->id,
							]) ?>">[посмотреть]</a>
						</td>
					</tr>
					<tr>
						<td>Активных:</td>
						<td>&nbsp;</td>
						<td><b><?= $model->getLinkedBannersOverview()['active'] ?></b></td>
						<td>&nbsp;</td>
						<td>
							<a href="<?= Url::to([
								'ads-banner/index',
								'AdsBannerSearch[area_id]'    => $model->id,
								'AdsBannerSearch[is_enabled]' => 1,
							]) ?>">[посмотреть]</a>
						</td>
					</tr>
				</table>
			</div>
		</div>
	<?php endif; ?>
	
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
