<?php

/* @var $this yii\web\View */
/* @var $form yii\widgets\ActiveForm */
/* @var $model app\modules\contact\models\Network */
?>

<?= $form->field($model, 'title')->textInput(['maxlength' => true]) ?>

<?= $form->field($model, 'url')->textInput(['maxlength' => true]) ?>

<div class="alert alert-info">Максимальная высота и ширина изображения: 40px. Для загрузки доступны файлы: png и svg.</div>
<?= $form->field($model, 'icon')->fileInput(['maxlength' => true]) ?>

<?= $form->field($model, 'hidden')->dropDownList($hiddenList) ?>

