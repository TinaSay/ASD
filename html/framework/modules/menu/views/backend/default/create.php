<?php

use yii\helpers\Html;
use yii\widgets\ActiveForm;

/* @var $this yii\web\View */
/* @var $form yii\widgets\ActiveForm */
/* @var $model elfuvo\menu\forms\MenuForm */
/* @var $menuParentList array */
/* @var $parentUrl string */
/* @var $moduleList array */
/* @var $useSection boolean */
/* @var $useImage boolean */

$this->title = Yii::t('system', 'Create');
if ($useSection) {
    $this->params['breadcrumbs'][] = [
        'label' => Yii::t('system', 'Menu'),
        'url' => ['index', 'section' => $model->section],
    ];
} else {
    $this->params['breadcrumbs'][] = ['label' => Yii::t('system', 'Menu'), 'url' => ['index']];
}
$this->params['breadcrumbs'][] = $this->title;
?>
<div class="card">

    <div class="card-header">
        <h4 class="card-title"><?= Html::encode($this->title) ?></h4>
    </div>

    <div class="card-content">

        <?php $form = ActiveForm::begin(['options' => ['enctype' => 'multipart/form-data']]); ?>

        <?= $this->render('_form', [
            'form' => $form,
            'model' => $model,
            'menuParentList' => $menuParentList,
            'parentUrl' => $parentUrl,
            'moduleList' => $moduleList,
            'useSection' => $useSection,
            'useImage' => $useImage,
        ]) ?>

        <div class="form-group">
            <?= Html::submitButton(Yii::t('system', 'Save'),
                ['class' => 'btn btn-success']) ?>
        </div>

        <?php ActiveForm::end(); ?>

    </div>

</div>
