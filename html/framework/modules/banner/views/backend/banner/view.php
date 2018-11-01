<?php

use app\modules\banner\models\Banner;
use yii\helpers\Html;
use yii\widgets\DetailView;

/* @var $this yii\web\View */
/* @var $model app\modules\banner\models\Banner */

$this->title = $model->title;
$this->params['breadcrumbs'][] = ['label' => Yii::t('system', 'Banner'), 'url' => ['index']];
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
        <?= DetailView::widget([
            'options' => ['class' => 'table'],
            'model' => $model,
            'attributes' => [
                Banner::ATTR_ID,
                Banner::ATTR_TITLE,
                Banner::ATTR_SIGNATURE,
                [
                    'attribute' => Banner::ATTR_FILE,
                    'value' => ($model->getImage()),
                    'format' => ['image', ['width' => '200', 'height' => '200']],
                ],
                [
                    'attribute' => Banner::ATTR_PUBLICATION_PLACES,
                    'value' => $model->getPublicationPlacesString(),
                ],
                Banner::ATTR_SHOWONINDEX . ':boolean',
                Banner::ATTR_SHOWONWHEREBUY . ':boolean',
                Banner::ATTR_CREATED_AT . ':datetime',
                Banner::ATTR_UPDATED_AT . ':datetime',
                Banner::ATTR_HIDDEN . ':boolean',
            ],
        ]) ?>
    </div>
</div>
