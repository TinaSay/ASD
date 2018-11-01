<?php

use yii\helpers\Html;
use yii\grid\GridView;
use krok\extend\grid\HiddenColumn;
use krok\extend\grid\DatePickerColumn;

/* @var $this yii\web\View */
/* @var $searchModel app\modules\advice\models\adviceGroupSearch */
/* @var $dataProvider yii\data\ActiveDataProvider */

$this->title = Yii::t('system', 'advice Group');
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

    <div class="card-content">

        <?= GridView::widget([
            'tableOptions' => ['class' => 'table'],
            'dataProvider' => $dataProvider,
            'filterModel' => $searchModel,
            'columns' => [
                ['class' => 'yii\grid\SerialColumn'],

                'id',
                'title',
                [
                    'class' => HiddenColumn::class,
                    'attribute' => 'hidden',
                ],
                [
                    'class' => DatePickerColumn::class,
                    'attribute' => 'createdAt',
                ],
                [
                    'class' => DatePickerColumn::class,
                    'attribute' => 'updatedAt',
                ],

                ['class' => 'yii\grid\ActionColumn'],
            ],
        ]); ?>

    </div>
</div>
