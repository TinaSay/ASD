<?php

use app\modules\promoBlock\assets\PromoBlockBackendAssets;
use app\modules\promoBlock\models\PromoBlock;

$bundle = PromoBlockBackendAssets::register($this);

/* @var $this yii\web\View */
/* @var $form yii\widgets\ActiveForm */
/* @var $model app\modules\promoBlock\models\PromoBlock */
?>

<?= $form->field($model, 'title')->textInput(['maxlength' => true]) ?>

<?= $form->field($model, 'signature')->textInput(['maxlength' => true]) ?>

<?= $form->field($model, 'imageType')->dropDownList(PromoBlock::IMAGE_TYPES) ?>

<div class="alert alert-info">Максимальная высота и ширина для иллюстрации: 555px X 555px. Для загрузки доступны файлы: png.<br>
    Минимальная высота и ширина для фотографии: 680px X 680px. Для загрузки доступны файлы: png, jpg, gif.
</div>

<?= $form->field($model, 'file')->fileInput() ?>

<?= $form->field($model, 'url')->textInput(['maxlength' => true]) ?>

<?= $form->field($model, 'btnShow')->dropDownList($model::getBtnShowList()) ?>

<?= $form->field($model, 'btnText')->textInput(['maxlength' => true]) ?>

<?= $form->field($model, 'hidden')->dropDownList($model::getHiddenList()) ?>
