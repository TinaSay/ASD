<?php

use yii\grid\GridView;
use yii\helpers\Html;

/* @var $this yii\web\View */
/* @var $searchModel app\modules\packet\models\PacketSearch */
/* @var $dataProvider yii\data\ActiveDataProvider */

$this->title = Yii::t('system', 'Packet');
$this->params['breadcrumbs'][] = $this->title;
?>
<div class="card">

    <div class="card-header">
        <h4 class="card-title"><?= Html::encode($this->title) ?></h4>
    </div>

    <div class="card-header">
        <p>
            <?= Html::a(Yii::t('system', 'Create'), ['create'], [
                'class' => 'btn btn-success',
            ]) ?>
        </p>
    </div>

    <div class="card-content">

        <?= GridView::widget([
            'tableOptions' => ['class' => 'table'],
            'dataProvider' => $dataProvider,
            'filterModel' => $searchModel,
            'columns' => [
                ['class' => 'yii\grid\SerialColumn'],

                'id',
                'subject',
                [
                    'attribute' => 'category',
                    'value' => function ($model) {
                        return $model->getCategory();
                    },
                ],
                [
                    'attribute' => 'sent',
                    'value' => function ($model) {
                        return $model->getStatusSent();
                    },
                ],


                [
                    'class' => \krok\extend\grid\DatePickerColumn::class,
                    'attribute' => 'createdAt',
                ],

                [
                    'class' => \krok\extend\grid\DatePickerColumn::class,
                    'attribute' => 'sendAt',
                ],


                ['class' => 'yii\grid\ActionColumn'],
            ],
        ]); ?>

    </div>
</div>
