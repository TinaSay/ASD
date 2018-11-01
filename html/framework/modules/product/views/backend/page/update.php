<?php

use yii\helpers\Html;
use yii\widgets\ActiveForm;

/* @var $this yii\web\View */
/* @var $form yii\widgets\ActiveForm */
/* @var $model app\modules\product\models\ProductPage */

$this->title = 'Редактировать' . ' : ' . $model->title;
$this->params['breadcrumbs'][] = ['label' => 'Описание раздела', 'url' => ['index']];
?>
<div class="card">

    <div class="card-header">
        <h4 class="card-title"><?= Html::encode($this->title) ?></h4>
    </div>

    <div class="card-content">

        <?php $form = ActiveForm::begin(['options' => ['enctype' => 'multipart/form-data']]); ?>

        <?= $this->render('_form', ['form' => $form, 'model' => $model]) ?>

        <div class="form-group">
            <?= Html::submitButton('Сохранить',
                ['class' => 'btn btn-primary']) ?>
        </div>

        <?php ActiveForm::end(); ?>

    </div>

</div>
