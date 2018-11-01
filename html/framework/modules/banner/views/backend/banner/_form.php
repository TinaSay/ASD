<?php

/* @var $this yii\web\View */
/* @var $form yii\widgets\ActiveForm */
/* @var $model app\modules\banner\models\Banner */
?>

<?= $form->field($model, $model::ATTR_TITLE)->textInput(['maxlength' => true]) ?>

<?= $form->field($model, $model::ATTR_SIGNATURE)->textInput(['maxlength' => true]) ?>

<div class="alert alert-info">Максимальная высота и ширина изображения: 200px. Для загрузки доступны файлы: png и svg.
</div>
<?= $form->field($model, $model::ATTR_FILE)->fileInput() ?>

<? /* $form->field($model, $model::ATTR_PUBLICATION_PLACES)->dropDownList($model::PUBLICATION_PLACES, [
    'multiple' => true,
    'data-live-search' => 'true',
]) */ ?>

<?= $form->field($model, $model::ATTR_SHOWONINDEX)->dropDownList($model->getShowOnIndexList()) ?>

<?= $form->field($model, $model::ATTR_SHOWONWHEREBUY)->dropDownList($model->getShowOnWherebuyList()) ?>

<?= $form->field($model, $model::ATTR_HIDDEN)->dropDownList($model::getHiddenList()) ?>
