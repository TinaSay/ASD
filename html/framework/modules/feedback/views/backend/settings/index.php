<?php

use unclead\multipleinput\TabularColumn;
use unclead\multipleinput\TabularInput;
use yii\helpers\Html;
use yii\widgets\ActiveForm;

/* @var $this yii\web\View */
/* @var $models \app\modules\feedback\models\FeedbackSettings[] */
/* @var $textModel \app\modules\feedback\models\FeedbackSettings */

$this->title = 'Настройка обратной связи';
$this->params['breadcrumbs'][] = ['label' => Yii::t('system', 'Feedback'), 'url' => ['index']];
$this->params['breadcrumbs'][] = $this->title;
?>
<style>
    .js-input-remove {
        display: none;
    }

    .list-cell__label {
        width: 30%;
    }

    .list-cell__label p {
        text-align: left;
        font-weight: bold;
        font-size: 14px;
    }
</style>
<div class="card">

    <div class="card-header">
        <h4 class="card-title"><?= Html::encode($this->title) ?></h4>
    </div>

    <div class="card-content">
        <?php $form = ActiveForm::begin([
            'enableAjaxValidation' => true,
            'enableClientValidation' => false,
            'validateOnChange' => false,
            'validateOnSubmit' => true,
            'validateOnBlur' => false,
        ]); ?>



        <?= TabularInput::widget([
            'id' => 'tabular-settings',
            //'rendererClass' => \unclead\multipleinput\renderers\ListRenderer::class,
            'models' => $models,
            'form' => $form,
            'attributeOptions' => [
                'enableAjaxValidation' => true,
                'enableClientValidation' => false,
                'validateOnChange' => false,
                'validateOnSubmit' => true,
                'validateOnBlur' => false,
            ],
            'addButtonPosition' => false,
            'removeButtonOptions' => ['style' => 'display:none;'],
            'min' => 0,
            'max' => count($models),
            'allowEmptyList' => true,
            'columns' => [
                [
                    'name' => 'label',
                    'type' => TabularColumn::TYPE_STATIC,
                    'title' => false,
                    'enableError' => true,
                    'options' => ['readonly' => true],
                ],
                [
                    'name' => 'id',
                    'type' => TabularColumn::TYPE_HIDDEN_INPUT,
                    'enableError' => false,
                ],
                [
                    'name' => 'value',
                    'type' => TabularColumn::TYPE_TEXT_INPUT,
                    'title' => false,
                    'enableError' => true,
                ],
            ],
        ]) ?>



        <?= TabularInput::widget([
            'id' => 'tabular-settings-redactor',
            //'rendererClass' => \unclead\multipleinput\renderers\ListRenderer::class,
            'models' => $textModel,
            'attributeOptions' => [
                'enableAjaxValidation' => true,
                'enableClientValidation' => false,
                'validateOnChange' => false,
                'validateOnSubmit' => true,
                'validateOnBlur' => false,
            ],
            'form' => $form,
            'addButtonPosition' => false,
            'removeButtonOptions' => ['style' => 'display:none;'],
            'min' => 1,
            'max' => 1,
            'columns' => [

                [
                    'name' => 'label',
                    'type' => TabularColumn::TYPE_STATIC,
                    'title' => false,
                    'enableError' => true,
                    'options' => ['readonly' => true],
                ],
                [
                    'name' => 'id',
                    'type' => TabularColumn::TYPE_HIDDEN_INPUT,
                    'enableError' => false,
                ],
                [
                    'name' => 'value',
                    'type' => 'textarea',//\krok\imperavi\widgets\ImperaviWidget::className(),
                    'enableError' => true,
                ],
            ],
        ]) ?>

        <div class="form-group">
            <?= Html::submitButton(Yii::t('system', 'Сохранить'),
                ['class' => 'btn btn-primary']) ?>
        </div>

        <?php ActiveForm::end(); ?>

    </div>
</div>
