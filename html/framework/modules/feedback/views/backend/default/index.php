<?php

use app\modules\feedback\assets\FeedbackAssets;
use app\modules\feedback\models\Feedback;
use yii\grid\GridView;
use yii\helpers\Html;

$bundle = FeedbackAssets::register($this);

/* @var $this yii\web\View */
/* @var $searchModel app\modules\feedback\models\FeedbackSearch */
/* @var $dataProvider yii\data\ActiveDataProvider */

$this->title = Yii::t('system', 'Feedback');
$this->params['breadcrumbs'][] = $this->title;
?>
<div class="card">

    <div class="card-header">
        <h4 class="card-title"><?= Html::encode($this->title) ?></h4>
    </div>

    <div class="card-content">

        <?= GridView::widget([
            'tableOptions' => ['class' => 'table'],
            'dataProvider' => $dataProvider,
            'filterModel' => $searchModel,
            'columns' => [
                ['class' => 'yii\grid\SerialColumn'],

                'id',
                [
                    'attribute' => 'fio',
                    'value' => function (Feedback $model) {
                        return Html::a($model->fio, ['/feedback/default/view', 'id' => $model->id]);

                    },
                    'format' => 'raw'
                ],
                'phone',
                'email:email',
                'company',
                'city',
                [
                    'attribute' => 'unsubscribe',
                    'value' => function (Feedback $model) {
                        return $model->getUnsubscribe();
                    },
                    'filter' => Feedback::getUnsubscribeList(),
                ],
                [
                    'attribute' => 'date_add',
                    'value' => function (Feedback $model) {
                        return Yii::$app->getFormatter()->asDatetime($model->date_add);
                    },
                ],
                [
                    'attribute' => 'msg_type',
                    'value' => function (Feedback $model) {
                        return $model->getMsgType();
                    },
                    'filter' => Feedback::getMsgTypeList(),
                ],
                [
                    'attribute' => 'status',
                    'value' => function (Feedback $model) {
                        return $model->getStatus();
                    },
                    'filter' => Feedback::getStatusList(),
                ],
                [
                    'attribute' => 'route',
                    'label' => 'Источник',
                    'value' => function (Feedback $model) {
                        return $model->getRoute();
                    },
                    'filter' => Feedback::getRouteList(),
                ],

                ['class' => 'yii\grid\ActionColumn'],
            ],
        ]); ?>

    </div>
</div>
