<?php

use app\modules\content\models\Content;
use tina\metatag\widgets\backend\MetatagViewWidget;
use yii\helpers\Html;
use yii\helpers\Url;
use yii\widgets\DetailView;

/* @var $this yii\web\View */
/* @var $model \app\modules\content\models\Content */

$this->title = $model->title;
$this->params['breadcrumbs'][] = ['label' => Yii::t('system', 'Content'), 'url' => ['index']];
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
            <?= Html::a(Yii::t('system', 'Open Page'), '/' . Yii::$app->language . '/content/' . $model->alias, [
                'class' => 'btn btn-warning',
                'target' => '_blank',
            ]) ?>
        </p>
    </div>

    <div class="card-content">

        <?= DetailView::widget([
            'options' => ['class' => 'table'],
            'model' => $model,
            'attributes' => [
                'id',
                'alias',
                'title',
                'text:html',
                'layout',
                'view',
                [
                    'attribute' => 'Баннеры',
                    'value' => function (Content $model) {
                        $link = [];
                        foreach ($model->banners as $banner) {
                            $link[] = Html::a($banner->title, Url::to(['/banner/banner/view', 'id' => $banner->id]));
                        }
                        return (count($link) > 0) ? implode(', ', $link) : null;
                    },
                    'format' => 'html',
                ],
                [
                    'attribute' => 'Списки',
                    'value' => function (Content $model) {
                        $link = [];
                        foreach ($model->skeds as $sked) {
                            $link[] = Html::a($sked->title, Url::to(['/sked/manage/view', 'id' => $sked->id]));
                        }
                        return (count($link) > 0) ? implode(', ', $link) : null;
                    },
                    'format' => 'html',
                ],

                [
                    'attribute' => 'bannerPosition',
                    'value' => $model->getBannerPosition()
                ],
                [
                    'attribute' => 'bannerColor',
                    'value' => $model->getBannerColor()
                ],
                [
                    'attribute' => 'productSet',
                    'value' => $model->getProductSet()
                ],
                [
                    'attribute' => 'renderForm',
                    'value' => $model->getRenderForm()
                ],
                'hidden:boolean',
                'createdAt:datetime',
                'updatedAt:datetime',
            ],
        ]) ?>

        <?= MetatagViewWidget::widget([
            'model' => $model->meta,
        ]) ?>

    </div>
</div>
