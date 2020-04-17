<?php

use yii\helpers\Html;
use yii\widgets\ActiveForm;
use lgxenos\yii2\banner\models\AdsArea;

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
							<?= $form->field($model, 'zone_type')->dropDownList(AdsArea::getTypesArray(), ['prompt' => '']) ?>
						</td>
					</tr>
				</table>
				
				<?= $form->field($model, 'is_enabled')->checkbox() ?>


			</td>
			<td style="width: 49%;vertical-align: top;">
				
				<?= $form->field($model, 'description')->textInput(['maxlength' => true]) ?>
				
				<?php if (!$model->isNewRecord): ?>
					<div class="form-group field-adsarea-description">
						<label class="control-label" for="adsarea-description">Привязано банеров:</label>
						<div class="help-block">
							фывфыв
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
