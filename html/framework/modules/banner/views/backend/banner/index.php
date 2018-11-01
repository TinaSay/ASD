<?php

use app\modules\banner\models\Banner;
use yii\grid\GridView;
use yii\helpers\Html;

/* @var $this yii\web\View */
/* @var $searchModel app\modules\banner\models\BannerSearch */
/* @var $dataProvider yii\data\ActiveDataProvider */

$this->title = Yii::t('system', 'Banner');
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
                Banner::ATTR_ID,
                Banner::ATTR_TITLE,
                [
                    'class' => \krok\extend\grid\DatePickerColumn::class,
                    'attribute' => Banner::ATTR_CREATED_AT,
                ],
                [
                    'class' => \krok\extend\grid\DatePickerColumn::class,
                    'attribute' => Banner::ATTR_UPDATED_AT,
                ],
                [
                    'class' => \krok\extend\grid\HiddenColumn::class,
                    'attribute' => Banner::ATTR_HIDDEN,
                ],
                ['class' => 'yii\grid\ActionColumn'],
            ],
        ]); ?>
    </div>
</div>
