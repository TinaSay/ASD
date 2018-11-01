<?php

use app\modules\feedback\helpers\FeedbackSettingsHelper;
use app\modules\feedback\models\FeedbackSettings;
use yii\widgets\ActiveForm;

/** @var $this yii\web\View */
/** @var $model \app\modules\feedback\models\Feedback */
/** @var $cssClass null|string */

?>
<!-- section-request -->
<section class="section-request cbp-so-section <?= $cssClass ?>">
    <div class="cbp-so-side-top cbp-so-side">
        <div class="container">
            <div class="row">
                <div class="col-lg-6 col-md-9 col-sm-12 col-xs-12 feedback-request-message">
                    <h3 class="section-title section-title--small"><?= FeedbackSettingsHelper::getValue('title') ?></h3>
                    <div class="section-request__sub-title">
                        <?= FeedbackSettingsHelper::getValue('subtitle'); ?>
                    </div>
                    <div class="section-request__description"><?= FeedbackSettingsHelper::getValue('text'); ?></div>
                </div>
                <div class="col-lg-5 col-xs-12">

                    <?php $form = ActiveForm::begin([
                        'id' => 'formRequest',
                        'action' => '#',
                        'enableClientValidation' => false,
                        'options' => [
                            'class' => 'form',
                        ],
                    ]); ?>
                    <div class="loader">
                        <div class="three-bounce">
                            <div class="one"></div>
                            <div class="two"></div>
                            <div class="three"></div>
                        </div>
                    </div>
                    <div class="form-inner">
                        <?= $form->field($model, 'fio')->label('Представьтесь, пожалуйста',
                            ['class' => 'form-group__label'])->textInput(['required' => 'required']) ?>
                        <?= $form->field($model, 'phone')->label('Укажите контактный телефон',
                            ['class' => 'form-group__label'])->textInput([
                            'class' => 'form-control',
                            'required' => 'required',
                            'type' => 'tel'
                        ]) ?>
                        <?= $form->field($model, 'msg_type',
                            ['options' => ['style' => 'display:none']])->hiddenInput(['value' => 1])->label(''); ?>
                        <?= $form->field($model,
                            'route',
                            ['options' => ['style' => 'display:none;']])->hiddenInput(['value' => Yii::$app->controller->route])->label(''); ?>
                        <?= $form->field($model, 'city',
                            ['options' => ['style' => 'display:none;']])->hiddenInput(['id' => 'feedback-city-from-menu-mini-index'])->label(''); ?>
                        <div class="btn-and-info form-btn btn-and-info--reverse btn-and-info--column">
                            <button type="submit" class="btn btn-submit btn-primary btn-confirm">Получите лучшую цену
                            </button>
                            <span class="info">
                                 <label class="wrap-check">
                                  <span class="check"><input class="check-confirm" checked="" type="checkbox"
                                                             name="Feedback[confirm]"></span>
                                  <span class="placeholder">Я подтверждаю свое <a target="_blank"
                                                                                  href="<?= FeedbackSettingsHelper::getValue(FeedbackSettings::PRIVACY_POLICY) ?>"
                                                                                  class="link-border">согласие на обработку моих персональных данных</a></span>
                                 </label>
                            </span>
                        </div>
                        <div class="form-status">
                            <div class="title fira">Спасибо! Ваша заявка отправлена.</div>
                            <p class="text">В ближайшее время с вами свяжутся наши специалисты и предоставят вам всю
                                необходимую информацию.</p>
                        </div>
                    </div>

                    <?php ActiveForm::end(); ?>

                </div>
            </div>
        </div>
    </div>
</section>
