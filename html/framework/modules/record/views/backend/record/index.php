<?php

use yii\helpers\Html;
use yii\grid\GridView;
use yii\widgets\Pjax;
use app\modules\record\models\Record;

/* @var $this yii\web\View */
/* @var $searchModel app\modules\record\models\RecordSearch */
/* @var $dataProvider yii\data\ActiveDataProvider */

$this->title = 'Записи';
$this->params['breadcrumbs'][] = $this->title;
?>
<div class="card">

    <div class="card-header">
        <h4 class="card-title"><?= Html::encode($this->title) ?></h4>
    </div>

    <div class="card-header">
        <p>
            <?=
            Html::a('Добавить', ['create'], [
                'class' => 'btn btn-success'
            ])
            ?>
        </p>
    </div>

    <div class="card-content">

        <?php Pjax::begin(); ?>                    
        <?=
        GridView::widget([
            'tableOptions' => ['class' => 'table'],
            'dataProvider' => $dataProvider,
            'filterModel' => $searchModel,
            'columns' => [
                ['class' => 'yii\grid\SerialColumn'],
                'id',
                [
                    'class' => \krok\extend\grid\DatePickerColumn::class,
                    'attribute' => 'dateHistory',
                    'format' => 'date'
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
                    'class' => \krok\extend\grid\HiddenColumn::class,
                    'attribute' => 'hidden',
                ],
                ['class' => 'yii\grid\ActionColumn'],
            ],
        ]);
        ?>
        <?php Pjax::end(); ?>
    </div>
</div>
