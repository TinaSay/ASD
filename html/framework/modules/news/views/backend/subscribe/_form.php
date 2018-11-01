<?php

use app\modules\news\models\News;
use app\modules\news\models\NewsGroup;
use yii\jui\DatePicker;
use tina\metatag\widgets\backend\MetatagWidget;

/* @var $this yii\web\View */
/* @var $form yii\widgets\ActiveForm */
/* @var $model app\modules\news\models\News */
?>

<?= $form->field($model, 'email')->textInput(['maxlength' => true, 'readonly' => true]) ?>

<?= $form->field($model, 'unsubscribe')->dropDownList(\app\modules\news\models\Subscribe::getUnsubscribeList()) ?>

