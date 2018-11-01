<?php

use yii\helpers\Html;

/* @var $this yii\web\View */
/* @var $tree \app\modules\product\models\ProductSection[] */

$this->title = Yii::t('system', 'Product Section');
$this->params['breadcrumbs'][] = $this->title;
?>
<div class="card">

    <div class="card-header">
        <h4 class="card-title"><?= Html::encode($this->title) ?></h4>
    </div>

    <div class="card-content">
        <?= \krok\extend\widgets\tree\TreeWidget::widget([
            'attributeContent' => 'title',
            'items' => $tree,
            'clientEvents' => [
                'update' => 'function (event, ui) { jQuery(this).sortableWidget({url: \'' . \yii\helpers\Url::to(['update-all']) . '\'}) }',
            ],
            'updateUrl' => false,
            'deleteUrl' => false,
        ]) ?>
    </div>

</div>
