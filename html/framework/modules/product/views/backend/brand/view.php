<?php

use yii\helpers\Html;
use yii\widgets\DetailView;

/* @var $this yii\web\View */
/* @var $model \app\modules\product\models\ProductBrand */

$this->title = $model->title;
$this->params['breadcrumbs'][] = ['label' => Yii::t('system', 'Brand'), 'url' => ['index']];
$this->params['breadcrumbs'][] = $this->title;
?>
<div class="card">

    <div class="card-header">
        <h4 class="card-title"><?= Html::encode($this->title) ?></h4>
    </div>

    <div class="card-header">
        <p>
            <?= Html::a(Yii::t('system', 'Update'), ['update', 'id' => $model->id], [
                'class' => 'btn btn-primary',
            ]) ?>
        </p>
    </div>

    <div class="card-content">

        <?= DetailView::widget([
            'options' => ['class' => 'table'],
            'model' => $model,
            'attributes' => [
                'id',
                'title',
                [
                    'attribute' => 'logo',
                    'value' => ($model->getLogo()) ? $model->getLogoUrl() : '',
                    'format' => ['image'],
                ],
                [
                    'attribute' => 'presentation',
                    'value' => $model->getPresentation() ? Html::a('Скачать',
                        $model->getPresentationUrl(), ['target' => '_blank']) : '',
                    'format' => 'raw',
                ],
                'description:ntext',
                'text:html',
                'createdAt',
                'updatedAt',

                [
                    'attribute' => 'hidden',
                    'value' => $model->getHidden(),
                ],
            ],
        ]) ?>

    </div>
</div>
