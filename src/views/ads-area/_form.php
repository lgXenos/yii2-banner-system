<?php

use yii\helpers\Html;
use yii\widgets\ActiveForm;

/* @var $this yii\web\View */
/* @var $model lgxenos\yii2\banner\models\AdsArea */
/* @var $form yii\widgets\ActiveForm */
?>

<div class="ads-area-form">
	
	<?php $form = ActiveForm::begin(); ?>
	
	<?= $form->field($model, 'title')->textInput(['maxlength' => true]) ?>
	
	<?= $form->field($model, 'width')->textInput(['maxlength' => true]) ?>
	
	<?= $form->field($model, 'heigth')->textInput(['maxlength' => true]) ?>
	
	<?= $form->field($model, 'description')->textInput(['maxlength' => true]) ?>
	
	<?= $form->field($model, 'zone_type')->dropDownList(['mobile'  => 'Mobile',
	                                                     'desktop' => 'Desktop',
	], ['prompt' => '']) ?>
	
	<?= $form->field($model, 'is_enabled')->checkbox() ?>
	
	
	<?php if (!Yii::$app->request->isAjax) { ?>
		<div class="form-group">
			<?= Html::submitButton($model->isNewRecord ? 'Создать' : 'Изменить', ['class' => $model->isNewRecord ? 'btn btn-success' : 'btn btn-primary']) ?>
		</div>
	<?php } ?>
	
	<?php ActiveForm::end(); ?>

</div>
