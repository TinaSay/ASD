<?php

use app\modules\record\models\Record;
use yii\helpers\Html;
use yii\widgets\DetailView;

/* @var $this yii\web\View */
/* @var $model app\modules\record\models\Record */

$this->title = $model->id;
$this->params['breadcrumbs'][] = ['label' => 'Record', 'url' => ['index']];
$this->params['breadcrumbs'][] = $this->title;
?>
<div class="card">

    <div class="card-header">
        <p>
            <?=
            Html::a('Редактировать', ['update', 'id' => $model->id], [
                'class' => 'btn btn-primary'])
            ?>
            <?=
            Html::a('Удалить', ['delete', 'id' => $model->id], [
                'class' => 'btn btn-danger',
                'data' => [
                    'confirm' => 'Вы уверены, что хотите удалить эту запись?',
                    'method' => 'post',
                ],
            ])
            ?>
        </p>
    </div>

    <div class="card-content">

        <?=
        DetailView::widget([
            'options' => ['class' => 'table'],
            'model' => $model,
            'attributes' => [
                'id',
                'dateHistory:date',
                [
                    'attribute' => 'description',
                    'format' => 'html',
                ],
                [
                    'attribute' => 'file',
                    'value' => ($model->file) ? $model->getPreview() : '',
                    'format' => ['image', ['width' => '550', 'height' => '190']],
                ],
                [
                    'attribute' => 'createdAt',
                ],
                [
                    'attribute' => 'updatedAt',
                ],
                [
                    'attribute' => 'hidden',
                    'value' => $model->getHidden(),
                ],
            ],
        ])
        ?>

    </div>
</div>
