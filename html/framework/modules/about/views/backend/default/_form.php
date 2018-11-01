<?php

use app\assets\CustomAsset;
use app\modules\meta\widgets\MetaWidget;
use krok\storage\dto\StorageDto;

/* @var $this yii\web\View */
/* @var $form yii\widgets\ActiveForm */
/* @var $model \app\modules\about\forms\AboutForm */

CustomAsset::register($this);
?>

<?= $form->field($model, 'title')->textInput(['maxlength' => true]) ?>

<?= $form->field($model, 'description')->widget(
    Yii::createObject([
        'class' => \krok\editor\interfaces\EditorInterface::class,
        'model' => $model,
        'attribute' => 'description',
    ])
) ?>

<?= $form->field($model, 'image')->widget(\kartik\file\FileInput::class, [
    'language' => 'ru',
    'options' => [
        'multiple' => false,
    ],
    'pluginOptions' => [
        'initialPreview' => $model->model->getImagePreview('image'),
        'initialPreviewAsData' => true,
        'initialPreviewConfig' => $model->model->getImagePreviewConfig('image'),
        'previewFileType' => 'any', //All file type preview
        'overwriteInitial' => false,
        'maxFileCount' => 1,
        'allowedFileExtensions' => ['jpg', 'png'],
        'showUpload' => false,//Don't show Load button
        'showRemove' => false,//Don't show Remove button
        'msgPlaceholder' => 'Выберите файл',
        'fileActionSettings' => [
            'showDrag' => false,
            'showUpload' => false,
        ],
    ],
]); ?>

<?= $form->field($model, 'mainVideo')->widget(\kartik\file\FileInput::class, [
    'language' => 'ru',
    'options' => [
        'multiple' => false,
        'accept' => 'video/mp4,video/ogg,video/webm',
    ],
    'pluginOptions' => [
        'initialPreview' => ($model->model->getMainVideo() instanceof StorageDto) ? '/static/asd/img/rsz_1play_icon_flatgreen.png' : '',
        'initialPreviewAsData' => true,
        'initialPreviewConfig' => $model->model->getImagePreviewConfig('mainVideo'),
        'previewFileType' => 'generic', //All file type preview
        'overwriteInitial' => false,
        'maxFileCount' => 1,
        'allowedFileExtensions' => ['mp4', 'ogv', 'webm'],
        'showUpload' => false,//Don't show Load button
        'showRemove' => false,//Don't show Remove button
        'msgPlaceholder' => 'Выберите файл',
        'fileActionSettings' => [
            'showDrag' => false,
            'showUpload' => false,
        ],
    ],
]); ?>

<?= $form->field($model, 'titleForImage')->textInput(['maxlength' => true]) ?>

<?= $form->field($model, 'descriptionImage')->textInput(['maxlength' => true]) ?>

<?= $form->field($model, 'titleForBanners')->textInput(['maxlength' => true]) ?>

<?= $form->field($model, 'banners')->dropDownList($model->getBannersList(), [
    'multiple' => true,
    'data-live-search' => 'true',
])->render() ?>

<?= $form->field($model, 'titleAdditionalBlock')->textInput(['maxlength' => true]) ?>

<?= $form->field($model, 'additionalDescription')->widget(
    Yii::createObject([
        'class' => \krok\editor\interfaces\EditorInterface::class,
        'model' => $model,
        'attribute' => 'additionalDescription',
    ])
) ?>

<?= $form->field($model, 'additionalImage')->widget(\kartik\file\FileInput::class, [
    'language' => 'ru',
    'options' => [
        'multiple' => false,
    ],
    'pluginOptions' => [
        'initialPreview' => $model->model->getImagePreview('additionalImage'),
        'initialPreviewAsData' => true,
        'initialPreviewConfig' => $model->model->getImagePreviewConfig('additionalImage'),
        'previewFileType' => 'any', //All file type preview
        'overwriteInitial' => false,
        'maxFileCount' => 1,
        'allowedFileExtensions' => ['jpg', 'png'],
        'showUpload' => false,//Don't show Load button
        'showRemove' => false,//Don't show Remove button
        'msgPlaceholder' => 'Выберите файл',
        'fileActionSettings' => [
            'showDrag' => false,
            'showUpload' => false,
        ],
    ],
]); ?>

<?= $form->field($model, 'urlYoutubeVideo')->textInput(['maxlength' => true]) ?>

<?= $form->field($model, 'publicHistory')->dropDownList($model::getBlockedList()) ?>

<?= $form->field($model, 'publishAnApplication')->dropDownList($model::getBlockedList()) ?>

<?= MetaWidget::widget([
    'metatag' => $model->model->meta,
    'model' => $model->model,
    'form' => $form,
]) ?>

<?= $form->field($model, 'blocked')->dropDownList($model::getBlockedList()) ?>
