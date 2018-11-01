<?php

/* @var $this yii\web\View */
/* @var $form yii\widgets\ActiveForm */
/* @var $model app\modules\product\models\ProductPage */

?>

<?= $form->field($model, 'title')->textInput(['readonly' => true]) ?>

<?= $form->field($model, 'name')->textInput(['maxlength' => true]) ?>

<?= $form->field($model, 'description')->textarea(['maxlength' => true]) ?>

<?= $form->field($model, 'text')->widget(\krok\tinymce\TinyMceWidget::class) ?>

<?= $form->field($model, 'hidden')->dropDownList($model::getHiddenList()) ?>
