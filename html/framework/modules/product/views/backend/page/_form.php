<?php

/* @var $this yii\web\View */
/* @var $form yii\widgets\ActiveForm */
/* @var $model app\modules\product\models\ProductPage */

?>

<?= $form->field($model, 'title')->textInput(['maxlength' => true]) ?>

<?= $form->field($model, 'description')->textarea(['maxlength' => true]) ?>

<?= $form->field($model, 'text')->widget(
    Yii::createObject([
        'class' => \krok\editor\interfaces\EditorInterface::class,
        'model' => $model,
        'attribute' => 'text',
    ])
) ?>

<?= $form->field($model, 'image')->widget(\kartik\file\FileInput::class, [
    'language' => 'ru',
    'options' => [
        'multiple' => false,
    ],
    'pluginOptions' => [
        'initialPreview' => $model->getImageUrl(),
        'initialPreviewAsData' => true,
        'initialPreviewConfig' => [],
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

<?= $form->field($model, 'hidden')->dropDownList($model::getHiddenList()) ?>
