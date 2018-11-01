<?php

use app\modules\contact\assets\ContactSettingAssets;
use yii\helpers\Html;
use yii\widgets\ActiveForm;

$bundle = ContactSettingAssets::register($this);
$bundle->jsOptions;

/* @var $this yii\web\View */
/* @var $list [] */

$this->title = 'Настройка контента в нижней части сайта';
$this->params['breadcrumbs'][] = ['label' => Yii::t('system', 'Feedback'), 'url' => ['index']];
$this->params['breadcrumbs'][] = $this->title;
?>
<div class="card">

    <div class="card-header">
        <h4 class="card-title"><?= Html::encode($this->title) ?></h4>
    </div>

    <div class="card-content">
        <?php $form = ActiveForm::begin([
            'enableClientValidation' => false,
            'id' => 'contact-setting-form'
        ]); ?>

        <?php if ($list) : foreach ($list as $model) : ?>

            <div class="form-group field-callsettings required">
                <label class="control-label" for="<?= $model->name ?>"><?= $model->label ?></label>
                <input type="hidden" name="Contactsetting[<?= $model->id ?>][name]" value="<?= $model->name ?>">
                <?php if($model->name=='rules'):?>
                    <textarea rows="3" id="contact-setting-<?= $model->name ?>" class="form-control" name="Contactsetting[<?= $model->id ?>][value]"><?= $model->value ?></textarea>
                <?php else:?>
                    <input type="text" id="contact-setting-<?= $model->name ?>" class="form-control" name="Contactsetting[<?= $model->id ?>][value]" value="<?= $model->value ?>" aria-required="true">
                <?php endif;?>
                <div class="help-block"></div>
            </div>

        <?php endforeach; endif; ?>

        <div class="form-group">
            <?= Html::submitButton(Yii::t('system', 'Сохранить'),
                ['class' => 'btn btn-primary contact-setting-btn-save']) ?>
        </div>

        <?php ActiveForm::end(); ?>

    </div>
</div>
