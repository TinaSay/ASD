<?php
/**
 *
 */


/* @var $this yii\web\View */
/* @var $form yii\widgets\ActiveForm */
/* @var $model elfuvo\menu\forms\MenuForm */
/* @var $menuParentList array */
/* @var $parentUrl string */
/* @var $useSection boolean */
/* @var $useImage boolean */

/* @var $moduleList array */

use elfuvo\menu\assets\MenuAsset;
use yii\helpers\Html;
use yii\helpers\Url;

MenuAsset::register($this);

?>

<?= $form->field($model, 'section')->hiddenInput()->label(false) ?>

<?= $form->field($model, 'parentId')->dropDownList(['' => ''] + $menuParentList) ?>

<?= $form->field($model, 'title')->textInput(['maxlength' => true]) ?>

<?= $form->field($model, 'alias',
    [
        'template' => '{label} <div class="input-group">' .
            '<span class="not-for-menu input-group-addon">/' . Html::encode($parentUrl) . '</span>' .
            '{input}' .
            '</div> {error}',
    ]
)->textInput([
    'maxlength' => true,
    'id' => 'menu-alias',
]); ?>

<?php if ($model->getIcon()): ?>
    <div class="form-group">
        <?= Html::a(Html::img($model->getIcon(), ['width' => 50]),
            Url::to(['delete-image', 'id' => $model->id, 'attribute' => 'image']),
            [
                'data' => [
                    'confirm' => Yii::t('system', 'Are you sure you want to delete this item?'),
                    'method' => 'post',
                ],
            ]
        ); ?>
    </div>
<?php endif; ?>
<?= $form->field($model, 'image')->fileInput(['accept' => 'image/*']) ?>

<?= $form->field($model, 'type')->dropDownList($model::getTypeList(), [
    'id' => 'menu-type',
]); ?>


<div class="module">
    <div class="form-group">
        <?= $form->field($model, 'module')->dropDownList(['' => ''] + $moduleList,
            [
                'class' => 'form-control for-module',
                'id' => 'menu-module',
                'data-url' => Url::to(['module-menu-items']),
            ]); ?>
    </div>
    <div>
        <div class="form-group">
            <?= $form->field($model, 'moduleItem')->dropDownList(['' => ''], [
                'class' => 'form-control for-module',
                'id' => 'menu-module-items',
                'data-live-search' => 'true',
            ]); ?>
        </div>
    </div>

</div>


<div class="row" style="margin-bottom:30px;">
    <div class="col-md-6">
        <input type="checkbox" id="expertMode" class="switch">
        <label for="expertMode">Показать настройки для эксперта</label>
    </div>
</div>
<div class="expert">
    <?= $form->field($model, 'route')->textInput([
        'maxlength' => true,
        'id' => 'menu-route',
    ]) ?>

    <?= $form->field($model, 'queryParams')->textInput([
        'maxlength' => true,
        'id' => 'menu-queryParams',
    ]) ?>
</div>

<div class="link hidden">
    <?= $form->field($model, 'extUrl')->textInput([
        'maxlength' => true,
        'class' => 'form-control for-link',
    ]) ?>
</div>

<?= $form->field($model, 'hidden')->dropDownList($model::getHiddenList())->label('Заблокировано') ?>

