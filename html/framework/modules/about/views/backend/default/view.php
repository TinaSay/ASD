<?php

use yii\helpers\Html;
use yii\widgets\DetailView;
use tina\metatag\widgets\backend\MetatagViewWidget;

/* @var $this yii\web\View */
/* @var $model app\modules\about\models\About */

$this->title = $model->title;
$this->params['breadcrumbs'][] = ['label' => 'О компанииы', 'url' => ['index']];
$this->params['breadcrumbs'][] = $this->title;
?>
<div class="card">
    <div class="card-header">
        <h4 class="card-title"><?= Html::encode($this->title) ?></h4>
    </div>
    <div class="card-header">
        <p>
            <?= Html::a('Редактировать', ['update', 'id' => $model->id], [
                'class' => 'btn btn-primary',
            ]) ?>
            <?= Html::a('Удалить', ['delete', 'id' => $model->id], [
                'class' => 'btn btn-danger',
                'data' => [
                    'confirm' => 'Вы уверены, что хотите удалить эту запись?',
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
                'description:html',
                [
                    'attribute' => 'image',
                    'value' => ($model->getPreview('image')),
                    'format' => ['image', ['width' => '200', 'height' => '200']],
                ],
                [
                    'attribute' => 'mainVideo',
                    'value' => $model->getSrc('mainVideo') ? Html::a('Открыть',
                        '/uploads/storage/' . $model->getSrc('mainVideo'), ['target' => '_blank']) : '',
                    'format' => 'raw',
                ],
                'titleForImage',
                'descriptionImage',
                'titleForBanners',
                [
                    'attribute' => 'banners',
                    'value' => $model->bannersList,
                    'format' => 'raw',
                ],
                'titleAdditionalBlock',
                'additionalDescription:html',
                [
                    'attribute' => 'additionalImage',
                    'value' => ($model->getPreview('additionalImage')),
                    'format' => ['image', ['width' => '200', 'height' => '200']],
                ],
                [
                    'attribute' => 'urlYoutubeVideo',
                    'value' => Html::a($model->urlYoutubeVideo, $model->urlYoutubeVideo, ['target' => '_blank']),
                    'format' => 'raw',
                ],
                [
                    'attribute' => 'publicHistory',
                    'value' => $model->publicHistory ? 'Да' : 'Нет',
                ],
                [
                    'attribute' => 'publishAnApplication',
                    'value' => $model->publishAnApplication ? 'Да' : 'Нет',
                ],
                [
                    'attribute' => 'blocked',
                    'value' => $model->getBlocked(),
                ],
                'createdAt:datetime',
                'updatedAt:datetime',
            ],
        ]) ?>
    </div>
    <div class="card-content">
        <?= MetatagViewWidget::widget([
            'model' => $model->meta,
        ]) ?>
    </div>

</div>
