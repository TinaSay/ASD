<?php

use yii\helpers\Html;
use yii\widgets\DetailView;
use app\modules\sked\assets\SkedBackendAssets;

/* @var $this yii\web\View */
/* @var $model app\modules\sked\models\Sked */
$bundle = SkedBackendAssets::register($this);
$this->title = $model->title;
$this->params['breadcrumbs'][] = ['label' => Yii::t('system', 'Sked'), 'url' => ['index']];
$this->params['breadcrumbs'][] = $this->title;
?>
<div class="card">

    <div class="card-header">
        <h4 class="card-title"><?= Html::encode($this->title) ?></h4>
    </div>

    <div class="card-header">
        <p>
            <?= Html::a(Yii::t('system', 'Update'), ['update', 'id' => $model->id], [
                'class' => 'btn btn-primary']) ?>
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

        <?= /** @var \app\modules\sked\models\Sked $model */
        DetailView::widget([
            'options' => ['class' => 'table'],
            'model' => $model,
            'attributes' => [
                'id',
                'title',
                [
                    'attribute' => 'route',
                    'value' => $model->getRoute(),
                    'format' => 'html',
                ],
                [
                    'attribute' => 'Списки',
                    'value' => $model->getItemAsComma(),
                    'format' => 'html',
                ],
                [
                    'attribute' => 'Изображения',
                    'format' => 'html',
                    'value' => function ($model) {
                        if (is_array($model->items)) {
                            $img = [];
                            foreach ($model->items as $item) {
                                $img[] = Html::img($item->getImage(), ['title' => $item->title, 'class' => 'sked-item-image']);
                            }
                            return (count($img) > 0) ? implode('', $img) : null;
                        }
                    }
                ],

                [
                    'attribute' => 'hidden',
                    'value' => $model->getHidden(),
                ],
                'createdAt:datetime',
                'updatedAt:datetime',
            ],
        ]) ?>

    </div>
</div>
