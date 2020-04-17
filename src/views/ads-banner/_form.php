<?php

use yii\helpers\Html;
use yii\widgets\ActiveForm;

/* @var $this yii\web\View */
/* @var $model lgxenos\yii2\banner\models\AdsBanner */
/* @var $form yii\widgets\ActiveForm */
?>

<div class="ads-banner-form">
	
	<?php $form = ActiveForm::begin(); ?>
	
	<?= $form->field($model, 'title')->textInput(['maxlength' => true]) ?>
	
	<?= $form->field($model, 'img')->textInput(['maxlength' => true]) ?>
	
	<?= $form->field($model, 'weigth')->textInput() ?>
	
	<?= $form->field($model, 'show_remains')->textInput(['maxlength' => true]) ?>
	
	<?= $form->field($model, 'user_id')->textInput(['maxlength' => true]) ?>
	
	<?= $form->field($model, 'zone_id')->textInput(['maxlength' => true]) ?>
	
	<?= $form->field($model, 'notice')->textInput(['maxlength' => true]) ?>
	
	<?= $form->field($model, 'is_enabled')->checkbox() ?>
	
	
	<?php if (!Yii::$app->request->isAjax) { ?>
		<div class="form-group">
			<?= Html::submitButton($model->isNewRecord ? 'Создать' : 'Изменить', ['class' => $model->isNewRecord ? 'btn btn-success' : 'btn btn-primary']) ?>
		</div>
	<?php } ?>
	
	<?php ActiveForm::end(); ?>

</div>
