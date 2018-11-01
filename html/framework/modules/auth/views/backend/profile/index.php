<?php
/**
 * Created by PhpStorm.
 * User: krok
 * Date: 19.07.17
 * Time: 18:36
 */

use yii\helpers\Html;
use yii\widgets\ActiveForm;

/* @var $this yii\web\View */
/* @var $model app\modules\auth\models\Profile */
/* @var $form yii\widgets\ActiveForm */

$this->title = 'Мой профиль';
?>
<div class="card">

    <div class="card-header">
        <h4 class="card-title"><?= Html::encode($this->title) ?></h4>
    </div>

    <div class="card-content">

        <?php $form = ActiveForm::begin(); ?>

        <?= $form->field($model, 'password')->passwordInput(['maxlength' => true, 'value' => '']) ?>

        <?= $form->field($model, 'password_new')->passwordInput(['maxlength' => true, 'value' => '']) ?>

        <div class="form-group">
            <?= Html::submitButton(Yii::t('system', 'Save'), ['class' => 'btn btn-primary']) ?>
        </div>

        <?php ActiveForm::end(); ?>

    </div>

</div>
