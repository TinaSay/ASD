<?php

use yii\helpers\Html;
use yii\grid\GridView;
use app\modules\news\models\News;
use app\modules\news\models\NewsGroup;
use yii\helpers\ArrayHelper;
use krok\extend\grid\DatePickerColumn;
use krok\extend\grid\HiddenColumn;

/* @var $this yii\web\View */
/* @var $searchModel app\modules\news\models\NewsSearch */
/* @var $dataProvider yii\data\ActiveDataProvider */

$this->title = Yii::t('system', 'News');
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

                'title',
                [
                    'attribute' => 'group',
                    'filter' => NewsGroup::getList(),
                    'value' => function (News $model) {
                        return ArrayHelper::getValue($model, 'groupRelation.title');
                    }
                ],
                [
                    'class' => DatePickerColumn::class,
                    'attribute' => 'createdAt',
                ],
                [
                    'class' => DatePickerColumn::class,
                    'attribute' => 'updatedAt',
                ],
                [
                    'class' => HiddenColumn::class,
                    'attribute' => 'hidden',
                ],

                ['class' => 'yii\grid\ActionColumn'],
            ],
        ]); ?>

    </div>
</div>
