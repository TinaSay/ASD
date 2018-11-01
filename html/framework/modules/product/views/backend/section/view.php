<?php

use yii\helpers\Html;
use yii\widgets\DetailView;

/* @var $this yii\web\View */
/* @var $model app\modules\product\models\ProductSection */

$this->title = $model->title;
$this->params['breadcrumbs'][] = ['label' => Yii::t('system', 'Product Section'), 'url' => ['index']];
$this->params['breadcrumbs'][] = $this->title;
?>
<div class="card">

    <div class="card-header">
        <h4 class="card-title"><?= Html::encode($this->title) ?></h4>
    </div>

    <div class="card-content">

        <?= DetailView::widget([
            'options' => ['class' => 'table'],
            'model' => $model,
            'attributes' => [
                'id',
                [
                    'attribute' => 'parentId',
                    'value' => ($model->parent ? $model->parent->title : null),
                ],
                'uuid',
                'title',
                'position',
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
