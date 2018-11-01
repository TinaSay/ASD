<?php

use yii\helpers\Html;
use yii\widgets\DetailView;

/* @var $this yii\web\View */
/* @var $model app\modules\brand\models\Brand */

$this->title = $model->title;
$this->params['breadcrumbs'][] = ['label' => Yii::t('system', 'Brand'), 'url' => ['index']];
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

        <?= DetailView::widget([
            'options' => ['class' => 'table'],
            'model' => $model,
            'attributes' => [
                'id',
                'title',
                [
                    'attribute' => 'logo',
                    'value' => ($model->getLogo()) ? $model->getPreview('logo') : '',
                    'format' => ['image'],
                ],
                [
                    'attribute' => 'illustration',
                    'value' => ($model->getIllustration()) ? $model->getPreview('illustration') : '',
                    'format' => ['image'],
                ],
                'text:ntext',
                'title2',
                'text2:ntext',
                'link',
                'createdAt:datetime',
                'updatedAt:datetime',
                [
                    'attribute' => 'presentation',
                    'value' => $model->getSrc('presentation') ? Html::a('Скачать',
                        '/uploads/storage/' . $model->getSrc('presentation'), ['target' => '_blank']) : '',
                    'format' => 'raw',
                ],
                [
                    'attribute' => 'blocked',
                    'value' => $model->getBlocked(),
                ],
            ],
        ]) ?>

    </div>
</div>
