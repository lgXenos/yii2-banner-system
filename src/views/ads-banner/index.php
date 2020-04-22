<?php

use yii\helpers\Url;
use yii\helpers\Html;
use yii\bootstrap\Modal;
use kartik\grid\GridView;
use johnitvn\ajaxcrud\CrudAsset;
use johnitvn\ajaxcrud\BulkButtonWidget;

/* @var $this yii\web\View */
/* @var $searchModel lgxenos\yii2\banner\models\AdsBannerSearch */
/* @var $dataProvider yii\data\ActiveDataProvider */

$this->title                   = 'Баннеры';
$this->params['breadcrumbs'][] = $this->title;

CrudAsset::register($this);

?>
<div class="ads-banner-index">
	<?= $this->render('../_parts/menu'); ?>
	<div id="ajaxCrudDatatable">
		<?= GridView::widget([
			'id'           => 'crud-datatable',
			'dataProvider' => $dataProvider,
			'filterModel'  => $searchModel,
			'pjax'         => true,
			'columns'      => require(__DIR__ . '/_columns.php'),
			'toolbar'      => [
				[
					'content' =>
						Html::a('<i class="glyphicon glyphicon-plus"></i>', ['create'],
							[
								'role'  => 'modal-remote',
								'title' => 'Создание нового банера',
								'class' => 'btn btn-default',
							]) .
						Html::a('<i class="glyphicon glyphicon-repeat"></i>', [''],
							['data-pjax' => 1, 'class' => 'btn btn-default', 'title' => 'Сброс Grid']) .
						'{toggleData}' .
						'{export}',
				],
			],
			'striped'      => true,
			'condensed'    => true,
			'responsive'   => true,
			'panel'        => [
				'type'    => 'primary',
				'heading' => '<i class="glyphicon glyphicon-list"></i> Список баннеров ',
				'before'  => '<em>* Размер столбца можно изменить, перетащив за край столбца.</em>',
				'after'   => BulkButtonWidget::widget([
						'buttons' => Html::a('<i class="glyphicon glyphicon-trash"></i>&nbsp; Удалить все',
							["bulkdelete"],
							[
								"class"                => "btn btn-danger btn-xs",
								'role'                 => 'modal-remote-bulk',
								'data-confirm'         => false,
								'data-method'          => false,// for overide yii data api
								'data-request-method'  => 'post',
								'data-confirm-title'   => 'Вы уверены?',
								'data-confirm-message' => 'Вы точно хотите удалить эту запись?',
							]),
					]) .
					'<div class="clearfix"></div>',
			],
		]) ?>
	</div>
</div>
<?php Modal::begin([
	"id"     => "ajaxCrudModal",
	"size"   => Modal::SIZE_LARGE, // SIZE_LARGE / SIZE_SMALL / SIZE_DEFAULT
	"footer" => "",// always need it for jquery plugin
]) ?>
<?php Modal::end(); ?>
