<?php

use yii\grid\GridView;
use yii\helpers\ArrayHelper;
use yii\helpers\Html;

/* @var $this yii\web\View */
/* @var $searchModel app\modules\auth\models\LogSearch */
/* @var $dataProvider yii\data\ActiveDataProvider */

$this->title = Yii::t('system', 'Log');
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

                'id',
                [
                    'attribute' => 'auth_id',
                    'filter' => $searchModel::getAuthList(),
                    'value' => function ($model) {
                        /** @var app\modules\auth\models\Log $model */
                        $value = ArrayHelper::getValue($model::getAuthList(), $model->auth_id);

                        return $value === null ? null : Html::a($value, ['auth/update', 'id' => $model->auth_id]);
                    },
                    'format' => 'html',
                ],
                [
                    'attribute' => 'status',
                    'filter' => $searchModel::getStatusList(),
                    'value' => function ($model) {
                        /** @var app\modules\auth\models\Log $model */
                        return $model->getStatus();
                    },
                ],
                [
                    'attribute' => 'ip',
                    'value' => function ($model) {
                        /** @var app\modules\auth\models\Log $model */
                        return long2ip($model->ip);
                    },
                ],
                [
                    'class' => \krok\extend\grid\DatePickerColumn::class,
                    'attribute' => 'created_at',
                ],

            ],
        ]); ?>

    </div>
</div>
