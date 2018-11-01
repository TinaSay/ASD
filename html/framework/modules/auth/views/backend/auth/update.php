<?php

use yii\helpers\Html;

/* @var $this yii\web\View */
/* @var $model app\modules\auth\models\Auth */
/* @var $roles [] */

$this->title = Yii::t('system', 'Update') . ' : ' . $model->login;
$this->params['breadcrumbs'][] = ['label' => Yii::t('system', 'Auth'), 'url' => ['index']];
$this->params['breadcrumbs'][] = ['label' => $model->login, 'url' => ['view', 'id' => $model->id]];
$this->params['breadcrumbs'][] = Yii::t('system', 'Update');
?>
<div class="card">

    <div class="card-header">
        <h4 class="card-title"><?= Html::encode($this->title) ?></h4>
    </div>

    <?= $this->render('_form', [
        'model' => $model,
        'roles' => $roles,
        'countryList' => $countryList,
        'cityList' => $cityList,
    ]) ?>

</div>
