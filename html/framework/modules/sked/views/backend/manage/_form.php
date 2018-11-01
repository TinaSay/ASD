<?php

use unclead\multipleinput\TabularColumn;
use unclead\multipleinput\TabularInput;
use yii\helpers\Html;

/* @var $this yii\web\View */
/* @var $form yii\widgets\ActiveForm */
/* @var $model app\modules\sked\models\Sked */
$bundle = \app\modules\sked\assets\SkedBackendAssets::register($this);
?>

<?= $form->field($model, 'title')->textInput(['maxlength' => true]) ?>

<?= $form->field($model, 'route')->hiddenInput(['value' => $model->getDefaultRoute()])->label(false); ?>

<h4>Список</h4>

<?= TabularInput::widget([
    'id' => 'tabular',
    'rendererClass' => \unclead\multipleinput\renderers\ListRenderer::class,
    'models' => $models,
    'attributeOptions' => [
        'enableAjaxValidation' => true,
        'enableClientValidation' => false,
        'validateOnChange' => false,
        'validateOnSubmit' => true,
        'validateOnBlur' => true,
    ],
    'form' => $form,
    'addButtonPosition' => TabularInput::POS_FOOTER,
    'min' => 0,
    'columns' => [
        [
            'name' => 'title',
            'type' => TabularColumn::TYPE_TEXT_INPUT,
            'title' => 'Заголовок',
            'enableError' => true,
        ],
        [
            'name' => 'description',
            'type' => 'textarea',
            'title' => 'Описание',
            'enableError' => true,
            'options' => [
                'rows' => 3,
                'style' => 'min-height: 0px;' // нужно сбросить для того чтобы rows сработал
            ],
        ],
        [
            'name' => 'btnLink',
            'type' => TabularColumn::TYPE_TEXT_INPUT,
            'title' => 'Ссылка',
            'enableError' => true,
        ],
        [
            'name' => 'btnText',
            'type' => TabularColumn::TYPE_TEXT_INPUT,
            'title' => 'Текст кнопки',
            'enableError' => true,
        ],
        [
            'name' => 'file',
            'title' => 'Изображение',
            'type' => 'fileInput',
            'attributeOptions' => [
                'enableClientValidation' => true,
                'validateOnChange' => true,
            ],
            'enableError' => true,
            'options' => [

            ],
        ],
        [
            'name' => 'file',
            'type' => TabularColumn::TYPE_STATIC,
            'title' => 'Файл',
            'value' => function (\app\modules\sked\models\Item $item) {
                if ($item->file instanceof StorageDto) {
                    return Html::a($item->title, $item->getFilePathUrl(),
                        ['data-id' => $item->id, 'class' => 'file-id']);
                }

                return '';
            },
        ],


    ],
]) ?>

<?= $form->field($model, 'hidden')->dropDownList($model->getHiddenList()) ?>

