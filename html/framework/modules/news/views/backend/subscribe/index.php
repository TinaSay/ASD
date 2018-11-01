<?php

use yii\grid\GridView;
use yii\helpers\Html;
use yii\helpers\ArrayHelper;
use app\modules\news\models\Subscribe;

/* @var $this yii\web\View */
/* @var $searchModel app\modules\news\models\SubscribeSearch */
/* @var $dataProvider yii\data\ActiveDataProvider */

$this->title = Yii::t('system', 'Subscribe');
$this->params['breadcrumbs'][] = $this->title;
?>
<div class="card">

    <div class="card-header">
        <h4 class="card-title"><?= Html::encode($this->title) ?></h4>
        <p>
            <?= Html::a(Yii::t('system', 'Download Excel'), ArrayHelper::merge([
                'download',
                'format' => 'xlsx',
            ], Yii::$app->request->getQueryParams()), [
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
                'email:email',
                'country',
                'city',
                [
                    'attribute' => 'unsubscribe',
                    'value' => function (Subscribe $model) {
                        return $model->getUnsubscribe();
                    },
                    'filter' => Subscribe::getUnsubscribeList(),
                ],

                [
                    'attribute' => 'type',
                    'label' => 'Источник',
                    'filter' => Subscribe::getTypeSubscribeList(),
                    'value' => function (Subscribe $model) {
                        return $model->getTypeSubscribe();
                    },
                ],
                'createdAt',
                [
                    'class' => \yii\grid\ActionColumn::class,
                    'template' => '{view} {update} {delete}',
                ],
            ],
        ]); ?>

    </div>
</div>
