<?php

use yii\helpers\Html;
use yii\widgets\ActiveForm;

/* @var $this yii\web\View */
/* @var $form yii\widgets\ActiveForm */
/* @var $model app\modules\packet\models\Packet */
/* @var array $categoryList */
/* @var array $byRegionList */
/* @var array $models list of app\modules\packet\models\PacketFile */

$this->title = Yii::t('system', 'Update') . ' : ' . $model->id;
$this->params['breadcrumbs'][] = ['label' => Yii::t('system', 'Packet'), 'url' => ['index']];
$this->params['breadcrumbs'][] = ['label' => $model->id, 'url' => ['view', 'id' => $model->id]];
$this->params['breadcrumbs'][] = Yii::t('system', 'Update');
?>
<div class="card">

    <div class="card-header">
        <h4 class="card-title"><?= Html::encode($this->title) ?></h4>
    </div>

    <div class="card-content">

        <?php $form = ActiveForm::begin([
            'options' => [
                'id' => 'packet-form-id',
                'enctype' => 'multipart/form-data',
            ],
        ]); ?>

        <?=
        $this->render('_form', [
            'form' => $form,
            'model' => $model,
            'models' => $models,
            'categoryList' => $categoryList,
            'byRegionList' => $byRegionList,
            'countryList' => $countryList,
            'cityList' => $cityList,
        ]) ?>

        <div class="form-group">
            <?= Html::submitButton(Yii::t('system', 'Save'),
                ['class' => 'btn btn-primary']) ?>
        </div>

        <?php ActiveForm::end(); ?>

    </div>

</div>
