<?php

use app\modules\meta\widgets\MetaWidget;

/* @var $this yii\web\View */
/* @var $form yii\widgets\ActiveForm */
/* @var $model \app\modules\content\models\Content */
?>

<?= $form->field($model, 'alias')->textInput(['maxlength' => true]) ?>

<?= $form->field($model, 'title')->textInput(['maxlength' => true]) ?>

<?= $form->field($model, 'text')->widget(
    Yii::createObject([
        'class' => \krok\editor\interfaces\EditorInterface::class,
        'model' => $model,
        'attribute' => 'text',
    ])
) ?>

<?= $form->field($model, 'layout')->hiddenInput(['value' => '//common'])->label(false) ?>

<?= $form->field($model, 'skedId')->dropDownList($model->getSkedList(), [
    'multiple' => true,
]) ?>

<?= $form->field($model, 'bannerId')->dropDownList($model->getBannerList(), [
    'multiple' => true,
])->label('Баннеры') /* не получилось с модели*/ ?>

<?= $form->field($model, 'bannerPosition')->dropDownList($model::getBannerPositionList()) ?>

<?= $form->field($model, 'bannerColor')->dropDownList($model::getBannerColorList()) ?>

<?= $form->field($model, 'productSet')->dropDownList($model::getProductSetList()) ?>

<?= $form->field($model, 'renderForm')->dropDownList($model::getRenderFormList()) ?>

<?= $form->field($model, 'view')->dropDownList($model::getViews()) ?>

<?= MetaWidget::widget([
    'metatag' => $model->meta,
    'model' => $model,
    'form' => $form,
]) ?>

<?= $form->field($model, 'hidden')->dropDownList($model::getHiddenList())->label('Заблокировано') ?>
