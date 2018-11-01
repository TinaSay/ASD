<?php

use yii\helpers\Html;
use yii\widgets\ActiveForm;

/* @var $this yii\web\View */
/* @var $model app\modules\auth\models\Auth */
/* @var $roles [] */
/* @var $form yii\widgets\ActiveForm */
?>

<div class="card-content">

    <?php $form = ActiveForm::begin(); ?>

    <?= $form->field($model, 'login')->textInput(['maxlength' => true]) ?>

    <?= $form->field($model, 'password')->passwordInput(['maxlength' => true, 'value' => '']) ?>

    <?= $form->field($model, 'email')->textInput(['maxlength' => true]) ?>

    <?= $form->field($model, 'blocked')->dropDownList($model::getBlockedList()) ?>

    <?= $form->field($model, 'roles')->dropDownList($roles, [
        'multiple' => true,
        'data-live-search' => 'true',
    ]) ?>

    <div class="form-group">
        <?= Html::submitButton($model->isNewRecord ? Yii::t('system', 'Create') : Yii::t('system', 'Update'),
            ['class' => $model->isNewRecord ? 'btn btn-success' : 'btn btn-primary']) ?>
    </div>

    <?php ActiveForm::end(); ?>

</div>
