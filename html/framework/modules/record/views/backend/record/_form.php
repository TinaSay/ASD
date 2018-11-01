<?php

use yii\jui\DatePicker;

/* @var $this yii\web\View */
/* @var $form yii\widgets\ActiveForm */
/* @var $model app\modules\record\models\Record */
?>

<?php $form->field($model, 'dateHistory')->textInput() ?>

<?= $form->field($model, 'dateHistory')->widget(DatePicker::class, [
    'attribute' => 'dateHistory',
    'model' => $model,
    'options' => ['class' => 'form-control'],
    'dateFormat' => 'yyyy-MM-dd',
]); ?>

<?= $form->field($model, 'description')->widget(
        Yii::createObject([
            'class' => \krok\editor\interfaces\EditorInterface::class,
            'model' => $model,
            'attribute' => 'description',
        ])
    ) ?>

<div class="alert alert-info">Максимальная высота изображения 230px, ширина : 550px. Для загрузки доступны файлы: png.</div>

<?= $form->field($model, 'file')->fileInput()->label('Загрузите изображение') ?>

<?= $form->field($model, 'hidden')->dropDownList($model::getHiddenList()) ?>
