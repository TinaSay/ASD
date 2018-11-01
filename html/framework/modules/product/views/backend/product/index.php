<?php

use app\modules\product\models\Product;
use app\modules\product\models\ProductBrand;
use app\modules\product\models\ProductPromo;
use yii\grid\GridView;
use yii\helpers\Html;

/* @var $this yii\web\View */
/* @var $searchModel app\modules\product\models\search\ProductSearch */
/* @var $dataProvider yii\data\ActiveDataProvider */

$this->title = Yii::t('system', 'Product');
$this->params['breadcrumbs'][] = $this->title;
?>
<div class="card">

    <div class="card-header">
        <h4 class="card-title"><?= Html::encode($this->title) ?></h4>
    </div>

    <?php /*<div class="card-header">
        <p>
            <?= Html::a(Yii::t('system', 'Create'), ['create'], [
                'class' => 'btn btn-success',
            ]) ?>
        </p>
    </div> */ ?>

    <div class="card-content">

        <?= GridView::widget([
            'tableOptions' => ['class' => 'table'],
            'dataProvider' => $dataProvider,
            'filterModel' => $searchModel,
            'columns' => [
                ['class' => 'yii\grid\SerialColumn'],

                'id',
                [
                    'attribute' => 'brandId',
                    'value' => function (Product $model) {
                        return $model->brand ? $model->brand->title : null;
                    },
                    'filter' => ProductBrand::asDropDown(null),
                ],

                'uuid',
                'article',
                'title',
                [
                    'attribute' => 'promoId',
                    'value' => function (Product $model) {
                        $promos = '';
                        if ($model->promos) {
                            foreach ($model->promos as $promo) {
                                $promos .= ($promos ? ', ' : '') . $promo->title;
                            }
                        };

                        return $promos;
                    },
                    'filter' => ProductPromo::asDropDown(null),
                    'format' => 'raw',
                ],
                // 'printableTitle',
                // 'description',
                // 'advantages:ntext',
                // 'text:ntext',

                [
                    'class' => \krok\extend\grid\HiddenColumn::class,
                    'attribute' => 'hidden',
                ],
                [
                    'class' => \krok\extend\grid\DatePickerColumn::class,
                    'attribute' => 'createdAt',
                ],
                [
                    'class' => \krok\extend\grid\DatePickerColumn::class,
                    'attribute' => 'updatedAt',
                ],

                [
                    'class' => 'yii\grid\ActionColumn',
                    'template' => '{view}',
                ],
            ],
        ]); ?>

    </div>
</div>
