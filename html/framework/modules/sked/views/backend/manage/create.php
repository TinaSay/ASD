<?php

use yii\helpers\Html;
use yii\widgets\ActiveForm;

//use yii\bootstrap\ActiveForm;

/* @var $this yii\web\View */
/* @var $form ActiveForm */
/* @var $model app\modules\sked\models\Sked */

$this->title = Yii::t('system', 'Create');
$this->params['breadcrumbs'][] = ['label' => Yii::t('system', 'Sked'), 'url' => ['index']];
$this->params['breadcrumbs'][] = $this->title;
?>
<div class="card">

    <div class="card-header">
        <h4 class="card-title"><?= Html::encode($this->title) ?></h4>
    </div>

    <div class="card-content">

        <?php $form = ActiveForm::begin([
            'id' => 'tabular-form',
            'enableAjaxValidation' => true,
            'enableClientValidation' => false,
            'validateOnChange' => false,
            'validateOnSubmit' => true,
            'validateOnBlur' => true,
            'options' => [
                'enctype' => 'multipart/form-data'
            ]
        ]) ?>

        <?= $this->render('_form', ['form' => $form, 'model' => $model, 'models' => $models]) ?>

        <div class="form-group">
            <?= Html::submitButton(Yii::t('system', 'Create'),
                ['class' => 'btn btn-success']) ?>
        </div>

        <?php ActiveForm::end(); ?>

    </div>

</div>
