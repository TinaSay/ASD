<?php

use app\modules\meta\widgets\MetaWidget;
use app\modules\product\models\ProductSection;
use app\modules\product\models\ProductUsage;
use yii\helpers\Url;

/* @var $this yii\web\View */
/* @var $form yii\widgets\ActiveForm */
/* @var $model app\modules\product\models\ProductUsageSectionText */

$this->registerJs('
    $(".usages").on("change", function(){
        var usageId = $(this).find("option:selected").val();
        $.getJSON("' . Url::to(['sections']) . '",
            {usageId: usageId},
            function(data){
                var $sections = $("select.sections");
                if(data.success){
                    $sections.empty();
                    for(var i in data.list){
                        if(data.list.hasOwnProperty(i)){
                            $sections.append("<option value=\"" + i +"\">"+data.list[i]+"</option>");
                        }
                    }
                    $sections.selectpicker("refresh");
                }
            }
        );     
    });
');
?>

<?= $form->field($model, 'usageId')->dropDownList(ProductUsage::asDropDown(null), [
    'class' => 'form-control usages',
]) ?>

<?= $form->field($model, 'sectionId')->dropDownList(ProductSection::asDropDown(null), [
    'class' => 'form-control sections',
]); ?>

<?= $form->field($model, 'title')->textInput(['maxlength' => true]) ?>

<?= $form->field($model, 'text')->widget(\krok\tinymce\TinyMceWidget::class) ?>

<?= MetaWidget::widget([
    'metatag' => $model->meta,
    'model' => $model,
    'form' => $form,
]) ?>

<?= $form->field($model, 'hidden')->dropDownList($model::getHiddenList()) ?>
