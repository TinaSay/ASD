<?php

use yii\helpers\Html;
use yii\grid\GridView;
use yii\widgets\Pjax;
use app\modules\rating\models\Rating;
use yii\helpers\ArrayHelper;

/* @var $this yii\web\View */
/* @var $searchModel app\modules\rating\models\RatingSearch */
/* @var $dataProvider yii\data\ActiveDataProvider */

$this->title = Yii::t('system', 'Rating');
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
                'id',
                'module',
                'record_id',
                [

                    'attribute' => 'user_id',
                    'format' => 'raw',
                    'value' => function ($model) {
                        /** @var $model Rating */
                        if ($model->user_id) {
                            return Html::a(ArrayHelper::getValue($model, 'user.email', ''),
                                ['cabinet/client/view', 'id' => ArrayHelper::getValue($model, 'user_id', '')]);
                        } else {
                            return '';
                        }
                    }
                ],
                'user_ip',
                'rating',
                'created_at:datetime',
            ],
        ]); ?>
        <?php Pjax::end(); ?>
    </div>
</div>
