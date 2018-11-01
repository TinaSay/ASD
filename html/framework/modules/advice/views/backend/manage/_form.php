<?php

use app\modules\advice\models\Advice;
use app\modules\advice\models\AdviceGroup;
use app\modules\meta\widgets\MetaWidget;

/* @var $this yii\web\View */
/* @var $form yii\widgets\ActiveForm */
/* @var $model app\modules\advice\models\Advice */
?>

<?= $form->field($model, 'title')->textInput(['maxlength' => true]) ?>

<?= $form->field($model, 'groupIDs')->dropDownList(AdviceGroup::getList(), [
    'multiple' => true,
    'value' => (!$model->groupIDs) ? [AdviceGroup::getFirstId()] : $model->groupIDs,
]) ?>

<?= $form->field($model, 'src')->fileInput(['accept' => 'image/*']) ?>

<?= $form->field($model, 'announce')->textarea(['rows' => 3]) ?>

<?= $form->field($model, 'text')->widget(
    Yii::createObject([
        'class' => \krok\editor\interfaces\EditorInterface::class,
        'model' => $model,
        'attribute' => 'text',
    ])
) ?>

<?= MetaWidget::widget([
    'metatag' => $model->meta,
    'model' => $model,
    'form' => $form,
]) ?>

<?= $form->field($model, 'hidden')->dropDownList(Advice::getHiddenList()) ?>
