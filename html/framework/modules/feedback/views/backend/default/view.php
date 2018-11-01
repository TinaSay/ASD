<?php

use app\modules\feedback\models\Feedback;
use yii\helpers\ArrayHelper;
use yii\helpers\Html;
use yii\helpers\Url;
use yii\widgets\DetailView;

/* @var $this yii\web\View */
/* @var $model app\modules\feedback\models\Feedback */

$this->title = $model->id;
$this->params['breadcrumbs'][] = ['label' => Yii::t('system', 'Feedback'), 'url' => ['index']];
$this->params['breadcrumbs'][] = $this->title;
?>
<div class="card">

    <div class="card-header">
        <h4 class="card-title"><?= Html::encode($this->title) ?></h4>
    </div>

    <div class="card-header">
        <p>
            <?= Html::a(Yii::t('system', 'Update'), ['update', 'id' => $model->id], [
                'class' => 'btn btn-primary',
            ]) ?>
            <?= Html::a(Yii::t('system', 'Delete'), ['delete', 'id' => $model->id], [
                'class' => 'btn btn-danger',
                'data' => [
                    'confirm' => Yii::t('system', 'Are you sure you want to delete this item?'),
                    'method' => 'post',
                ],
            ]) ?>
        </p>
    </div>

    <div class="card-content">
        <?php $attributes = [
            'id',
            'date_add:datetime',
            'date_edited:datetime',
            [
                'attribute' => 'msg_type',
                'value' => function (Feedback $model) {
                    return $model->getMsgType();

                },
            ],
            'fio',
            'phone',
        ];

        if ($model->msg_type == Feedback::FTYPE_CALLBACK) {
            $attributes = ArrayHelper::merge($attributes, [
                [
                    'attribute' => 'callTime',
                    'value' => function (Feedback $model) {
                        return ($model->callTime != '') ? $model->callTime : 'Не задано';

                    },
                ],
            ]);
        } elseif ($model->msg_type == Feedback::FTYPE_MESSAGE) {
            $attributes = ArrayHelper::merge($attributes, [
                'email:email',
                'company',
                'city',
                'text:ntext',
            ]);
        } elseif ($model->msg_type == Feedback::FTYPE_ORDER) {
            $attributes = ArrayHelper::merge($attributes, [
                'email:email',
                [
                    'attribute' => 'productId',
                    'value' => function (Feedback $model) {
                        return ($model->product) ? Html::a($model->product->title, Url::to([
                            '/product/product/view',
                            'id' => $model->productId,
                        ])) : 'Не задано';

                    },
                    'format' => 'raw',
                ],
            ]);
        }

        $attributes += [
            [
                'attribute' => 'status',
                'value' => function (Feedback $model) {
                    return $model->getStatus();

                },
            ],
            'date_edited',
            [
                'attribute' => 'route',
                'label' => 'Источник',
                'value' => function (Feedback $model) {
                    return $model->getRoute();

                },
            ],
        ];
        ?>

        <?= DetailView::widget([
            'options' => ['class' => 'table'],
            'model' => $model,
            'attributes' => $attributes,
        ]) ?>
    </div>
</div>
