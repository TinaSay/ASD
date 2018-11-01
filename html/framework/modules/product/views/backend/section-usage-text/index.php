<?php

use app\modules\product\models\ProductSection;
use app\modules\product\models\ProductUsage;
use app\modules\product\models\ProductUsageSectionText;
use yii\grid\GridView;
use yii\helpers\Html;

/* @var $this yii\web\View */
/* @var $searchModel app\modules\product\models\search\ProductUsageSectionTextSearch */
/* @var $dataProvider yii\data\ActiveDataProvider */

$this->title = Yii::t('system', 'Product Usage Section Text');
$this->params['breadcrumbs'][] = $this->title;
?>
<div class="card">

    <div class="card-header">
        <h4 class="card-title"><?= Html::encode($this->title) ?></h4>
    </div>

    <div class="card-header">
        <p>
            <?= Html::a(Yii::t('system', 'Create'), ['create'], [
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
                ['class' => 'yii\grid\ActionColumn'],
                'id',
                [
                    'attribute' => 'usageId',
                    'filter' => ProductUsage::asDropDown(null),
                    'value' => function (ProductUsageSectionText $model) {
                        return $model->usage ? $model->usage->title : null;
                    },
                ],
                [
                    'attribute' => 'sectionId',
                    'filter' => ProductSection::asDropDown(null),
                    'value' => function (ProductUsageSectionText $model) {
                        return $model->section ? $model->section->title : null;
                    },
                ],
                'title',
                [
                    'attribute' => 'hidden',
                    'value' => function (ProductUsageSectionText $model) {
                        return $model->getHidden();
                    },
                    'filter' => ProductUsageSectionText::getHiddenList(),
                ],
                'createdAt:datetime',
                'updatedAt:datetime',
            ],
        ]); ?>

    </div>
</div>
