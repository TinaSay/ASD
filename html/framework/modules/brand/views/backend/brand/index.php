<?php

use yii\helpers\Html;
use krok\extend\widgets\tree\TreeWidget;
use yii\helpers\Url;

/* @var $this yii\web\View */
/* @var $searchModel app\modules\brand\models\BrandSearch */
/* @var $dataProvider yii\data\ActiveDataProvider */

$this->title = Yii::t('system', 'Our brands');
$this->params['breadcrumbs'][] = $this->title;
$url = Url::to(['update-position']);
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
        <?= TreeWidget::widget([
                'attributeContent' => 'title',
                'items' => $items,
                'clientEvents' => [
                    'update' => 'function (event, ui) { jQuery(this).sortableWidget({url: \'' . $url . '\'}) }',
                ],
        ]) ?>
    </div>
</div>
