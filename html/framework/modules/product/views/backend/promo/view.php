<?php

use yii\helpers\Html;
use yii\widgets\DetailView;

/* @var $this yii\web\View */
/* @var $model app\modules\product\models\ProductPromo */

$this->title = $model->title;
$this->params['breadcrumbs'][] = ['label' => Yii::t('system', 'Product Promo'), 'url' => ['index']];
$this->params['breadcrumbs'][] = $this->title;
?>
<div class="card">

    <div class="card-header">
        <h4 class="card-title"><?= Html::encode($this->title) ?></h4>
    </div>

    <div class="card-content">
        <?php $products = '';
        if ($model->products):?>
            <?php foreach ($model->products as $product) {
                $products .= ($products ? ', ' : '') . Html::a($product->title,
                        ['/product/product/view', 'id' => $product->id],
                        ['target' => 'product']
                    );
            } ?>
        <?php endif; ?>
        <?= DetailView::widget([
            'options' => ['class' => 'table'],
            'model' => $model,
            'attributes' => [
                'id',
                'uuid',
                'title',
                'color',
                [
                    'attribute' => 'icon',
                    'value' => $model->getIcon() ? Html::img($model->getIconUrl()) : null,
                    'format' => 'raw',
                ],
                [
                    'attribute' => 'productId',
                    'value' => $products,
                    'format' => 'raw',
                ],
                [
                    'attribute' => 'hidden',
                    'value' => $model->getHidden(),
                ],
                'createdAt',
                'updatedAt',
            ],
        ]) ?>

    </div>
</div>
