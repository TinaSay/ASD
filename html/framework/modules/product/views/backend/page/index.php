<?php

use yii\helpers\Html;
use yii\widgets\DetailView;

/* @var $this yii\web\View */
/* @var $model app\modules\product\models\ProductPage */

$this->title = 'Описание раздела';
?>
<div class="card">
    <div class="card-header">
        <h4 class="card-title"><?= Html::encode($this->title) ?></h4>
    </div>
    <div class="card-header">
        <p>
            <?= Html::a('Редактировать', ['update', 'id' => $model->id], [
                'class' => 'btn btn-primary',
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
                'description:ntext',
                [
                    'attribute' => 'image',
                    'value' => ($model->getImageUrl()),
                    'format' => ['image', ['width' => '200', 'height' => '200']],
                ],
                'text:html',
                [
                    'attribute' => 'hidden',
                    'value' => $model->getHidden(),
                ],
                'createdAt:datetime',
                'updatedAt:datetime',
            ],
        ]) ?>
    </div>
</div>
