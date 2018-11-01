<?php

use yii\helpers\Html;
use yii\widgets\DetailView;

/* @var $this yii\web\View */
/* @var $model elfuvo\menu\models\Menu */
/* @var $useSection boolean */
/* @var $useImage boolean */

$this->title = $model->title;
if ($useSection) {
    $this->params['breadcrumbs'][] = [
        'label' => Yii::t('system', 'Menu'),
        'url' => ['index', 'section' => $model->section],
    ];
} else {
    $this->params['breadcrumbs'][] = ['label' => Yii::t('system', 'Menu'), 'url' => ['index']];
}
$this->params['breadcrumbs'][] = $this->title;
?>
<div class="card">

    <div class="card-header">
        <h4 class="card-title"><?= Html::encode($this->title) ?></h4>
    </div>

    <div class="card-header">
        <p>
            <?php if ($useSection): ?>
                <?= Html::a(Yii::t('system', 'Update'), ['update', 'section' => $model->section, 'id' => $model->id], [
                    'class' => 'btn btn-primary',
                ]) ?>
            <?php else: ?>
                <?= Html::a(Yii::t('system', 'Update'), ['update', 'id' => $model->id], [
                    'class' => 'btn btn-primary',
                ]) ?>
            <?php endif; ?>
            <?= Html::a(Yii::t('system', 'Delete'), ['delete', 'id' => $model->id], [
                'class' => 'btn btn-danger',
                'data' => [
                    'confirm' => Yii::t('system', 'Are you sure you want to delete this item?'),
                    'method' => 'post',
                ],
            ]) ?>
        </p>
    </div>


    <div class="card-content">
        <?php $attributes = [
            'id',
            'title',
            [
                'attribute' => 'parentId',
                'value' => ($model->parent ? $model->parent->title : null),
            ],
            [
                'attribute' => 'url',
                'value' => Html::a(Html::encode('/' . Yii::$app->language . '/' . $model->url),
                    '/' . Yii::$app->language . '/' . $model->url,
                    ['target' => '_site']
                ),
                'format' => 'raw',
            ],
            'extUrl',
            [
                'attribute' => 'hidden',
                'value' => $model->getHidden(),
                'label' => Yii::t('system', 'Hidden'),
            ],

        ];

        if ($useSection) {
            $attributes = array_merge($attributes, ['section']);
        }
        if ($useImage) {
            $attributes = array_merge($attributes, [
                [
                    'attribute' => 'image',
                    'value' => $model->getImage() ? Html::img($model->getIcon(), ['width' => 50]) : null,
                    'format' => 'raw',
                ],
                [
                    'attribute' => 'imageHover',
                    'value' => $model->getImageHover() ? Html::img($model->getIconHover(), ['width' => 50]) : null,
                    'format' => 'raw',
                ],
            ]);
        }
        $attributes = array_merge($attributes, [
            'createdAt:datetime',
            'updatedAt:datetime',
        ]);
        ?>
        <?= DetailView::widget([
            'options' => ['class' => 'table'],
            'model' => $model,
            'attributes' => $attributes,
        ]) ?>

    </div>
</div>
