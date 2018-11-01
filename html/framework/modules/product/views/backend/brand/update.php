<?php

use yii\helpers\Html;
use yii\widgets\ActiveForm;

/* @var $this yii\web\View */
/* @var $form yii\widgets\ActiveForm */
/* @var $model \app\modules\product\models\ProductBrand */
/* @var $blockList \app\modules\product\models\ProductBrandBlock[] */

$this->title = 'Редактировать' . ' : ' . $model->title;
$this->params['breadcrumbs'][] = ['label' => 'Список брендов', 'url' => ['index']];
?>
<div class="card">

    <div class="card-header">
        <h4 class="card-title"><?= Html::encode($this->title) ?></h4>
    </div>

    <div class="card-content">

        <?php $form = ActiveForm::begin(['options' => ['enctype' => 'multipart/form-data']]); ?>

        <?php foreach ($blockList as $key => $block): ?>
            <div class="row">
                <div class="row-md-12">
                    <div class="card-header">
                        <h4>Блок <?= ($key + 1); ?></h4>
                    </div>
                    <?= $form->field($block, '[' . $key . ']id')->hiddenInput()->label(false); ?>

                    <?= $form->field($block, '[' . $key . ']title')->textInput(['maxlength' => true]) ?>

                    <?= $form->field($block, '[' . $key . ']value')->input('number', ['maxlength' => true]) ?>

                    <?= $form->field($block, '[' . $key . ']description')->textInput(['maxlength' => true]) ?>

                    <?= $form->field($block, '[' . $key . ']hidden')->dropDownList($block::getHiddenList()) ?>
                </div>
            </div>
        <?php endforeach; ?>
        <div class="form-group">
            <?= Html::submitButton('Сохранить',
                ['class' => 'btn btn-primary']) ?>
        </div>

        <?php ActiveForm::end(); ?>

    </div>

</div>
