<?php

use yii\helpers\Html;
use yii\widgets\DetailView;

$bundle = \app\modules\packet\assets\PacketAssets::register($this);

/* @var $this yii\web\View */
/* @var $model app\modules\packet\models\Packet */

$this->title = $model->id;
$this->params['breadcrumbs'][] = ['label' => Yii::t('system', 'Packet'), 'url' => ['index']];
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

            <?= Html::a(Yii::t('system', 'Send'), null, [
                'class' => 'btn btn-success action-send-emails',
                'data-send-url' => \yii\helpers\Url::to(['send', 'id' => $model->id]),
                'data-status-url' => \yii\helpers\Url::to(['status', 'id' => $model->id]),
            ]) ?>

        </p>
    </div>

    <div class="card-content">

        <?= DetailView::widget([
            'options' => ['class' => 'table'],
            'model' => $model,
            'attributes' => [
                'id',
                'subject',
                [
                    'attribute' => 'category',
                    'value' => $model->getCategory(),
                ],
                'text:ntext',

                [
                    'attribute' => 'files',
                    'value' => $model->getPacketFilesAnchorListStr(),
                    'format' => 'html',
                ],

                [
                    'attribute' => 'recipients',
                    'value' => $model->getRecipients(),
                    'format' => 'html',
                ],
                [
                    'attribute' => 'byRegion',
                    'value' => $model->getbyRegion(),
                ],
                [
                    'attribute' => 'country',
                    'value' => function ($model) {
                        return ($model->byRegion) ? $model->country : 'Не учитывается';
                    },
                ],
                [
                    'attribute' => 'city',
                    'value' => function ($model) {
                        return ($model->byRegion) ? $model->city : 'Не учитывается';
                    },
                ],
                'sent:boolean',
                'createdAt:datetime',
                'updatedAt:datetime',
                'sendAt:datetime',

            ],
        ]) ?>

    </div>
</div>
