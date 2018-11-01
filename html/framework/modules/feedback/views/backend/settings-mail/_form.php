<?php

/* @var $this yii\web\View */
/* @var $form yii\widgets\ActiveForm */
/* @var $model app\modules\reception\form\SettingsMailForm */
?>

<?= $form->field($model, 'sender_name')->textInput(['maxlength' => true]) ?>

<?= $form->field($model, 'host')->textInput(['maxlength' => true]) ?>

<?= $form->field($model, 'username')->textInput(['maxlength' => true]) ?>

<?= $form->field($model, 'hidden_password')->textInput(['maxlength' => true]) ?>

<?= $form->field($model, 'port')->textInput(['maxlength' => true]) ?>

<?= $form->field($model, 'encryption')->textInput(['maxlength' => true]) ?>
