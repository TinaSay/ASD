<?php

use yii\grid\GridView;
use yii\helpers\Html;

/* @var $this yii\web\View */
/* @var $searchModel \app\modules\product\models\search\ProductBrandSearch */
/* @var $dataProvider yii\data\ActiveDataProvider */

$this->title = Yii::t('system', 'Product Brand');
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
                'uuid',
                'title',
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
                    'template' => '{view}  {update}',
                ],
            ],
        ]); ?>
    </div>
</div>
