<?php

use yii\bootstrap\Html;
use krok\extend\widgets\tree\TreeWidget;
use yii\helpers\Url;

/* @var $this yii\web\View */
/* @var $searchModel app\modules\about\models\AboutSearch */
/* @var $dataProvider yii\data\ActiveDataProvider */

$this->title = 'О компании';
$this->params['breadcrumbs'][] = $this->title;
$url = Url::to(['update-position']);
?>
<div class="card">
    <div class="card-header">
        <h4 class="card-title"><?= Html::encode($this->title) ?></h4>
    </div>
    <div class="card-header">
        <p>
            <?= Html::a('Добавить', ['create'], [
                'class' => 'btn btn-success'
            ]) ?>
        </p>
    </div>
    <div class="card-content">        
        <div class="card-content">
            <?= TreeWidget::widget([
                'attributeContent' => 'title',
                'items' => $items,
                'clientEvents' => [
                    'update' => 'function (event, ui) { jQuery(this).sortableWidget({url: \'' . $url . '\'}) }',
                ],
            ]) ?>
        </div>
    </div>
</div>
