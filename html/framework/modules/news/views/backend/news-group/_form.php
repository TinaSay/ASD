<?php

use app\modules\news\models\NewsGroup;

/* @var $this yii\web\View */
/* @var $form yii\widgets\ActiveForm */
/* @var $model app\modules\news\models\NewsGroup */
?>

<?= $form->field($model, 'title')->textInput(['maxlength' => true]) ?>

<?= $form->field($model, 'color')->textInput(['maxlength' => true]) ?>

<?= $form->field($model, 'hidden')->dropDownList(NewsGroup::getHiddenList()) ?>
