<?php

use app\modules\feedback\assets\FeedbackAssets;
use yii\helpers\Html;
use yii\widgets\ActiveForm;

FeedbackAssets::register($this);

/* @var $this yii\web\View */
/* @var $form yii\widgets\ActiveForm */
/* @var $model app\modules\feedback\models\Feedback */

$this->title = Yii::t('system', 'Update') . ' : ' . $model->id;
$this->params['breadcrumbs'][] = ['label' => Yii::t('system', 'Feedback'), 'url' => ['index']];
$this->params['breadcrumbs'][] = ['label' => $model->id, 'url' => ['view', 'id' => $model->id]];
$this->params['breadcrumbs'][] = Yii::t('system', 'Update');
?>
<div class="card">

    <div class="card-header">
        <h4 class="card-title"><?= Html::encode($this->title) ?></h4>
    </div>

    <div class="card-content">

        <p>
            <?= Html::errorSummary($model, ['class' => 'errors']) ?>
        </p>

        <?php $form = ActiveForm::begin([
            'id' => $model->formName(),
            'enableClientValidation' => false,
        ]); ?>

        <?= $this->render('_form', ['form' => $form, 'model' => $model]) ?>

        <div class="form-group">
            <?= Html::submitButton(Yii::t('system', 'Save'),
                ['class' => 'btn btn-primary']) ?>
        </div>

        <?php ActiveForm::end(); ?>

    </div>

</div>
