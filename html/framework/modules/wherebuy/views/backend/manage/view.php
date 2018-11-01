<?php

use app\modules\wherebuy\models\Wherebuy;
use yii\helpers\Html;
use yii\widgets\DetailView;

/* @var $this yii\web\View */
/* @var $model app\modules\wherebuy\models\Wherebuy */

$this->title = $model->title;
$this->params['breadcrumbs'][] = ['label' => Yii::t('system', 'Wherebuy'), 'url' => ['index']];
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

        <?= DetailView::widget([
            'options' => ['class' => 'table'],
            'model' => $model,
            'attributes' => [
                'id',
                'title',
                'subtitle',
                [
                    'attribute' => 'src',
                    'value' => function (Wherebuy $model) {
                        return Html::img($model->getImage());
                    },
                    'format' => 'html',
                ],
                [
                    'attribute' => 'brandIDs',
                    'value' => function (Wherebuy $model) {
                        return $model->getBrandsString();
                    },
                    'format' => 'html',
                ],

                'link',
                'delivery',
                'hidden:boolean',
                'showInProduct:boolean',
                'createdAt:datetime',
                'updatedAt:datetime',
            ],
        ]) ?>

    </div>
</div>
