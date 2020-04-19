<?php
/* @var $this yii\web\View */
/* @var $banner \lgxenos\yii2\banner\models\AdsBanner */
?>

<?php if($banner->banner_type == \lgxenos\yii2\banner\models\AdsBanner::ADS_AREA_TYPE_IMAGE): ?>
	<img src="<?= $banner->img ?>"
	     style="max-width: -webkit-fill-available; max-height: -webkit-fill-available; cursor: pointer;"
	     onclick="rShC('<?=$banner->hash?>')"
	>
<?php endif; ?>