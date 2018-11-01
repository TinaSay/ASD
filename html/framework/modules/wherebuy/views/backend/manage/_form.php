<?php


/* @var $this yii\web\View */
/* @var $form yii\widgets\ActiveForm */
/* @var $model app\modules\wherebuy\models\Wherebuy */
/* @var $brandList array */
?>

<?= $form->field($model, 'title')->textInput(['maxlength' => true]) ?>

<?= $form->field($model, 'subtitle')->textInput(['maxlength' => true]) ?>

<?= $form->field($model, 'brandIDs')->dropDownList($brandList, [
    'multiple' => true,
]) ?>


<div class="alert alert-info">Допускается загрузка только файлов формата png и svg, размер загружаемого изображения: не более 130x90px</div>
<?= $form->field($model, 'src')->fileInput(['accept' => 'image/*'])->hint(false); ?>

<?= $form->field($model, 'link')->textInput(['maxlength' => true]) ?>

<?= $form->field($model, 'delivery')->textInput(['maxlength' => true]) ?>

<?= $form->field($model, 'showInProduct')->dropDownList($model::getShowInProductList()) ?>

<?= $form->field($model, 'hidden')->dropDownList($model::getHiddenList()) ?>