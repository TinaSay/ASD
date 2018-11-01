<?php

/* @var $this yii\web\View */
/* @var $form yii\widgets\ActiveForm */

/* @var $model app\modules\brand\models\Brand */

use app\modules\product\models\ProductBrand;
use yii\bootstrap\Html;

?>

<?= $form->field($model, 'title')->textInput(['maxlength' => true]) ?>

<?= $form->field($model, 'productBrandId')->dropDownList(ProductBrand::asDropDown(null), [
    'prompt' => 'Выберите',
]) ?>

<?php if (!$model->isNewRecord) : ?>
    <?= Html::img($model->getPreview('logo')); ?>
<?php endif; ?>
<div class="alert alert-info">Для загрузки доступны файлы: png. Максимальный допустимый размер - 220x65 px</div>
<?= $form->field($model, 'logo')->fileInput(['accept' => 'image/png']) ?>

<?php if (!$model->isNewRecord) : ?>
    <?= Html::img($model->getPreview('illustration')); ?>
<?php endif; ?>
<div class="alert alert-info">Для загрузки доступны файлы: png. Максимальный допустимый размер - 430x430 px</div>
<?= $form->field($model, 'illustration')->fileInput(['accept' => 'image/png']) ?>

<?= $form->field($model, 'text')->textarea(['rows' => 3, 'style' => 'min-height:60px;']) ?>

<?= $form->field($model, 'title2')->textInput(['maxlength' => true]) ?>

<?= $form->field($model, 'text2')->textarea(['rows' => 3, 'style' => 'min-height:60px;']) ?>

<?= $form->field($model, 'link')->textInput(['maxlength' => true]) ?>

<?php if (!$model->isNewRecord && $model->getSrc('presentation')) : ?>
    <div class="form-group">
        <?= Html::a('Скачать',
            '/uploads/storage/' . $model->getSrc('presentation'), ['target' => '_blank']) ?>
    </div>
<?php endif; ?>
<div class="alert alert-info">Для загрузки доступны файлы: pdf, ppt, zip, rar.</div>
<?= $form->field($model,
    'presentation')->fileInput(['accept' => 'application/pdf,application/x-zip-compressed,application/zip,.rar,.ppt']) ?>

<?= $form->field($model, 'blocked')->dropDownList($model::getBlockedList()) ?>
