<?php

use yii\helpers\Html;
use yii\widgets\ActiveForm;

/* @var $this yii\web\View */
/* @var $promoBlockItems array */

$this->title = Yii::t('system', 'Promo Block');
$this->params['breadcrumbs'][] = $this->title;
?>
<div class="card">

    <div class="card-header">
        <h4 class="card-title"><?= Html::encode($this->title) ?></h4>
    </div>

    <div class="card-header">
        <p>
            <?= Html::a(Yii::t('system', 'Create'), ['create'], [
                'class' => 'btn btn-success'
            ]) ?>
        </p>
    </div>
    <?php ActiveForm::begin([
        'action' => 'promo/update-all',
        'id' => 'sort-form',
    ]); ?>
    <div class="card-content">
        <?= \krok\extend\widgets\sortable\SortableWidget::widget([
            'items' => $promoBlockItems,
            'attributeContent' => 'content',
            'clientEvents' => [
                'update' => "function() {
                    form = $('#sort-form');
                    $.ajax({
                            url: form.attr('action'),
                            type: 'post',
                            data: form.serialize(),
                            success: function(data) {}
                    });
                }"
            ]
        ]); ?>
    </div>
    <?php ActiveForm::end(); ?>
</div>
