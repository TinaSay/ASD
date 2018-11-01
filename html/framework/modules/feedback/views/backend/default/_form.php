<?php

/* @var $this yii\web\View */
/* @var $form yii\widgets\ActiveForm */
/* @var $model app\modules\feedback\models\Feedback */
?>
<?= $form->field($model, 'fio')->textInput(['readonly' => true]) ?>

<?= $form->field($model, 'phone')->textInput(['readonly' => true]) ?>

<?= $form->field($model, 'status')->dropDownList($model->getStatusList()); ?>
