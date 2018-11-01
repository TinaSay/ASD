<?php

use app\modules\advice\models\AdviceGroup;

/* @var $this yii\web\View */
/* @var $form yii\widgets\ActiveForm */
/* @var $model app\modules\advice\models\AdviceGroup */
?>

<?= $form->field($model, 'title')->textInput(['maxlength' => true]) ?>

<?= $form->field($model, 'hidden')->dropDownList(AdviceGroup::getHiddenList()) ?>
