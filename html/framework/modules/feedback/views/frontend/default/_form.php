<?php

use yii\helpers\Html;
use yii\widgets\ActiveForm;

/* @var $this yii\web\View */
/* @var $model app\modules\feedback\models\Feedback */
/* @var $form yii\widgets\ActiveForm */
?>

<div class="feedback-form col-md-4">

    <?php if ($model->errors) foreach ($model->errors as $er) echo $er[0] . '<br>'; ?>
    <?php $form = ActiveForm::begin([
        'id' => $model->formName(),
        'enableClientValidation' => false]); ?>

    <?= $form->field($model, 'fio')->label('Представьтесь, пожалуйста')->textInput() ?>
    <?= $form->field($model, 'phone')->label('Укажите контактный телефон')->textInput(['type' => 'tel']) ?>

    <?= $form->field($model, 'msg_type')->hiddenInput(['value' => 1])->label(''); ?>

    <div class="form-group">
        <?= Html::submitButton($model->isNewRecord ? 'Отправить' : 'Отправить', ['class' => $model->isNewRecord ? 'btn btn-submit btn-success' : 'btn btn-submit btn-primary']) ?>
    </div>

    <?php ActiveForm::end(); ?>

</div>

