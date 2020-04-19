<?php

use yii\helpers\Html;
use yii\widgets\ActiveForm;
use lgxenos\yii2\banner\models\AdsArea;
use \yii\helpers\Url;

/* @var $this yii\web\View */
/* @var $model lgxenos\yii2\banner\models\AdsArea */
/* @var $form yii\widgets\ActiveForm */
?>

<div class="ads-area-form">
	
	<?php $form = ActiveForm::begin(); ?>

	<table style="border-collapse: separate; border-spacing: 5px; width: 100%;">
		<tr>
			<td style="width: 49%;vertical-align: top;">
				
				<?= $form->field($model, 'title')->textInput(['maxlength' => true]) ?>

				<table>
					<tr>
						<td>
							<?= $form->field($model, 'width')->textInput(['maxlength' => true, 'type' => 'number']) ?>
						</td>
						<td>&nbsp;</td>
						<td>
							<?= $form->field($model, 'heigth')->textInput(['maxlength' => true, 'type' => 'number']) ?>
						</td>
						<td>&nbsp;</td>
						<td>
							<?= $form->field($model, 'area_type')->dropDownList(AdsArea::getTypesArray(), ['prompt' => '']) ?>
						</td>
					</tr>
				</table>
				
				<?= $form->field($model, 'is_enabled')->checkbox() ?>


			</td>
			<td style="width: 49%;vertical-align: top;">
				
				<?= $form->field($model, 'description')->textInput(['maxlength' => true]) ?>
				
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
											'AdsBannerSearch[area_id]' => $model->id,
											'AdsBannerSearch[is_enabled]' => 1,
										]) ?>">[посмотреть]</a>
									</td>
								</tr>
							</table>
						</div>
					</div>
				<?php endif; ?>


			</td>
		</tr>
	</table>
	
	
	<?php if (!Yii::$app->request->isAjax) { ?>
		<div class="form-group">
			<?= Html::submitButton($model->isNewRecord ? 'Создать' : 'Изменить', ['class' => $model->isNewRecord ? 'btn btn-success' : 'btn btn-primary']) ?>
		</div>
	<?php } ?>
	
	<?php ActiveForm::end(); ?>

</div>
