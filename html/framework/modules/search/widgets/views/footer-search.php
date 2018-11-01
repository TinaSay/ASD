<?php

use yii\widgets\ActiveForm;
use yii\helpers\Url;

/* @var $this yii\web\View */
/* @var $model \app\modules\search\models\SearchForm */
/* @var $class string */
?>
<?php $form = ActiveForm::begin([
    'method' => 'get',
    'options' => [
        'class' => $class,
    ],
    'enableClientValidation' => false,
    'action' => Url::to(['/search/default/index']),
    'fieldConfig' => [
        'template' => '{input}',
        'options' => [
            'tag' => false,
        ],
    ],
]); ?>
<div class="form-group form-group--search">
    <?= $form->field($model, 'term')->textInput([
        'class' => 'form-control',
        'placeholder' => 'Найдем любой запрос...'
    ])->label(false); ?>
    <button class="search__btn reset-btn-style" type="button"><i class="icon-loupe"></i></button>
</div>
<?php ActiveForm::end(); ?>
