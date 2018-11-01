<?php

use yii\helpers\Html;
use yii\grid\GridView;
use yii\widgets\Pjax;

/* @var $this yii\web\View */
/* @var $searchModel app\modules\rating\models\RatingSearch */
/* @var $dataProvider yii\data\ActiveDataProvider */

$this->title = Yii::t('system', 'Quality assessment');
$this->params['breadcrumbs'][] = $this->title;

?>
<div class="card">

    <div class="card-header">
        <h4 class="card-title"><?= Html::encode($this->title) ?></h4>
    </div>

    <div class="card-content">

        <?php Pjax::begin(); ?>
        <?= GridView::widget([
            'tableOptions' => ['class' => 'table'],
            'dataProvider' => $dataProvider,
            'filterModel' => $searchModel,
            'columns' => [
                ['class' => 'yii\grid\SerialColumn'],

                [
                    'attribute' => 'title',
                    'format' => 'raw',
                    'value' => function ($model) {
                        return Html::a($model['title'],
                            ['/rating/manage/view', 'module' => $model['module'], 'record_id' => $model['record_id']]);
                    }
                ],
                [
                    'attribute' => 'avgRating',
                    'value' => function ($model) {
                        return Yii::$app->formatter->asDecimal($model['avgRating'], 2);
                    }
                ],
                'date:datetime',
            ],
        ]); ?>
        <?php Pjax::end(); ?>
    </div>
</div>
