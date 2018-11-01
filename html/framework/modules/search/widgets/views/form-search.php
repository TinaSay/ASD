<?php

use yii\widgets\ActiveForm;
use yii\helpers\Url;

/* @var $this yii\web\View */
/* @var $model \app\modules\search\models\SearchForm */

$js = <<<JS
$('.search__btn').on('click',function(){
        var term=jQuery(this).closest('form').find('input').val();
        if( !/^\s*$/.test(term)){
           jQuery(this).closest('form').submit();
        }else{
            jQuery('#searchform-term').attr('placeholder','Введите текст запроса...')
        }    
});
JS;
$this->registerJs($js);

?>
<?php $form = ActiveForm::begin([
    'method' => 'get',
    'options' => [
        'class' => 'footer-header__search mobile-search-header',
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
    <button class="search__btn reset-btn-style show-search-field" type="button"><i
                class="icon-loupe"></i></button>
    <span class="hide-search-field"><i class="icon-close"></i></span>
</div>
<?php ActiveForm::end(); ?>
