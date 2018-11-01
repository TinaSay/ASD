<?php

/*use yii\grid\GridView;*/
use krok\extend\widgets\sortable\SortableWidget;
use yii\helpers\Html;
use yii\helpers\Url;

/* @var $this yii\web\View */
/* @var $searchModel app\modules\contact\models\DivisionSearch */
/* @var $dataProvider yii\data\ActiveDataProvider */
// sortable
$url = Url::to(['update-position']);


$this->title = Yii::t('system', 'Division');
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

        <?= SortableWidget::widget([
            'attributeContent' => 'title',
            'items' => $list,
            'clientEvents' => [
                'update' => 'function (event, ui) { jQuery(this).sortableWidget({url: \'' . $url . '\'}) }',
            ],
        ]) ?>

    </div>
</div>
