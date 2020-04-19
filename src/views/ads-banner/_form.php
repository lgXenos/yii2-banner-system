<?php

use yii\helpers\Html;
use yii\widgets\ActiveForm;

/* @var $this yii\web\View */
/* @var $model lgxenos\yii2\banner\models\AdsBanner */
/* @var $form yii\widgets\ActiveForm */

if ($model->weigth === null || $model->weigth === '') {
	$model->weigth = 100;
}
if ($model->user_id === null || $model->user_id === '') {
	$model->user_id = Yii::$app->user->identity->getId();
}
?>

<div class="ads-banner-form">
	
	<?php $form = ActiveForm::begin(); ?>

	<table style="border-collapse: separate; border-spacing: 5px; width: 100%;">
		<tr>
			<td style="width: 49%;vertical-align: top;">
				<?= $form->field($model, 'title')->textInput(['maxlength' => true]) ?>
				
				<?= $form->field($model, 'url')->textInput(['maxlength' => true]) ?>
				
				<?php if ($model->isNewRecord): ?>
					<?= $form->field($model, 'img')->textInput(['maxlength' => true]) ?>
				<?php endif; ?>
				
				
				<?= $form->field($model, 'weigth')->textInput() ?>

				<table>
					<tr>
						<td>
							<?= $form->field($model, 'show_remains')->textInput(['maxlength' => true]) ?>
						</td>
						<td style="width: 10%;">&nbsp;</td>
						<td>
							<div class="form-group field-adsbanner-cnt_show">
								<label class="control-label" for="adsbanner-cnt_show">Показы</label>
								<div class="form-control" readonly><b><?= $model->cnt_show ?></b></div>
							</div>
						</td>
						<td>&nbsp;</td>
						<td>
							<div class="form-group field-adsbanner-cnt_click">
								<label class="control-label" for="adsbanner-cnt_click">Переходы</label>
								<div class="form-control" readonly><b><?= $model->cnt_click ?></b></div>
							</div>
						</td>
						<td style="width: 10%;">&nbsp;</td>
						<td>
							<a href="<?= \yii\helpers\Url::to(['ads-banner/stat', 'id' => $model->id]) ?>">
								Статистика по дням
							</a>
						</td>
					</tr>
				</table>
				
				<?= $form->field($model, 'is_enabled')->checkbox() ?>
				
				<?php if (!$model->isNewRecord): ?>
					<?= $form->field($model, 'img')->textInput(['readonly' => true]) ?>
					<img src="<?= $model->img ?>" style="max-height: 100px; max-width: 100px;">
					<br>
				<?php endif; ?>


			</td>
			<td style="width: 49%;vertical-align: top;">
				<?= $form->field($model, 'user_id')->textInput(['maxlength' => true]) ?>
				
				<?= $form->field($model, 'area_id')->widget(\kartik\widgets\Select2::class, [
					'language'      => 'ru',
					'data'          => \lgxenos\yii2\banner\models\AdsArea::getDropdownList(),
					'options'       => ['placeholder' => 'Выберите рекламное место'],
					'pluginOptions' => [],
				]); ?>
				
				<?= $form->field($model, 'notice')->textInput(['maxlength' => true]) ?>
				<?= $model->isNewRecord ? '' : $form->field($model, 'hash')->textInput(['readonly' => true]) ?>
				<?= $model->isNewRecord ? '' : $form->field($model, 'created_at')->textInput(['readonly' => true]) ?>

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
