<?php
/**
 * Copyright (c) Rustam
 */

use app\modules\contact\widgets\MetroWidget;
use app\modules\meta\widgets\MetaWidget;
use unclead\multipleinput\TabularColumn;
use unclead\multipleinput\TabularInput;
use yii\helpers\Html;

/* @var $this yii\web\View */
/* @var $form yii\widgets\ActiveForm */
/* @var $model app\modules\contact\models\Division */
/* @var $hiddenList array */
/* @var $models \app\modules\contact\models\Requisite[] */
/* @var $hiddenList array */

?>

<?= $form->field($model, 'title')->textInput(['maxlength' => true]) ?>

<?= $form->field($model, 'subtitle')->textInput(['maxlength' => true]) ?>

<?= $form->field($model, 'phone')->textInput(['maxlength' => true]) ?>

<?= $form->field($model, 'address')->textInput([
    'maxlength' => true,
    'id' => "division-adres-metrocomplete",
    'autocomplete' => 'off',
]) ?>

<?= $form->field($model, 'lat')->hiddenInput()->label(false); ?>

<?= $form->field($model, 'long')->hiddenInput()->label(false); ?>

<?= MetroWidget::widget(['model' => $model, 'form' => $form]); ?>

<?= $form->field($model, 'email')->textInput(['maxlength' => true]) ?>

<?= $form->field($model, 'working')->textInput(['maxlength' => true]) ?>

<?php /* RequisiteWidget::widget(['model' => $model, 'form' => $form]); */ ?>

<h4>Реквизиты</h4>

<?= TabularInput::widget([
    'id' => 'tabular',
    'rendererClass' => \unclead\multipleinput\renderers\ListRenderer::class,
    'models' => $models,
    'attributeOptions' => [
        'enableAjaxValidation' => true,
        'enableClientValidation' => false,
        'validateOnChange' => false,
        'validateOnSubmit' => true,
        'validateOnBlur' => false,
    ],
    'form' => $form,
    'addButtonPosition' => TabularInput::POS_FOOTER,
    'min' => 0,
    'columns' => [
        [
            'name' => 'name',
            'type' => TabularColumn::TYPE_TEXT_INPUT,
            'title' => 'Название',
            'enableError' => true,
        ],
        [
            'name' => 'file',
            'title' => 'Выберите файл',
            'type' => 'fileInput',
            'enableError' => true,
        ],
        [
            'name' => 'file',
            'type' => TabularColumn::TYPE_STATIC,
            'title' => 'Файл',
            'value' => function (\app\modules\contact\models\Requisite $requisite) {
                if ($requisite->id !== null) {
                    return Html::a($requisite->name, $requisite->getFilePathUrl(),
                        ['data-id' => $requisite->id, 'class' => 'requisite-file-id']);
                }

                return '';
            },
        ],


    ],
]) ?>

<?= MetaWidget::widget([
    'metatag' => $model->meta,
    'model' => $model,
    'form' => $form,
]) ?>

<?= $form->field($model, 'hidden')->dropDownList($hiddenList) ?>



