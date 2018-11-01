<?php

use krok\storage\dto\StorageDto;
use unclead\multipleinput\TabularColumn;
use unclead\multipleinput\TabularInput;
use yii\helpers\Html;

$bundle = \app\modules\packet\assets\PacketAssets::register($this);
/* @var $this yii\web\View */
/* @var $form yii\widgets\ActiveForm */
/* @var $model app\modules\packet\models\Packet */
/* @var $categoryList array */
/* @var $byRegionList array */
?>

<?= $form->field($model, 'subject')->textInput(['maxlength' => true]) ?>

<?= $form->field($model, 'category')->dropDownList($categoryList) ?>

<?= $form->field($model, 'text')->widget(
    Yii::createObject([
        'class' => \krok\editor\interfaces\EditorInterface::class,
        'model' => $model,
        'attribute' => 'text',
    ])
) ?>

<?= $form->field($model, 'byRegion')->dropDownList($byRegionList) ?>

<?= $form->field($model, 'country')->dropDownList($countryList, [
    'class' => 'form-control packet-country-list by-region-list',
]) ?>

<?= $form->field($model, 'city')->dropDownList($cityList, [
    'multiple' => true,
    'class' => 'form-control packet-city-list by-region-list',
    'data-multiple-separator' => '; ', // look at https://github.com/lordfriend/nya-bootstrap-select/issues/5 & http://silviomoreto.github.io/bootstrap-select/options/
]) ?>

<h4>Файлы</h4>

<div class="alert alert-info">Для загрузки доступны файлы: doc, docx, pdf, txt, ppt, rtf, jpg, png.</div>
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
            'value' => function (\app\modules\packet\models\PacketFile $PacketFile) {
                if ($PacketFile->file instanceof StorageDto) {
                    return Html::a($PacketFile->name, '/uploads/storage/' . $PacketFile->file->getSrc(),
                        ['data-id' => $PacketFile->id, 'class' => 'packetFile-file-id']);
                } else {
                    return '';
                }
            },
        ],


    ],
]) ?>


