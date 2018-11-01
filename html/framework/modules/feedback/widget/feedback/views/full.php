<?php

use app\modules\feedback\helpers\FeedbackSettingsHelper;
use app\modules\feedback\models\FeedbackSettings;
use yii\widgets\ActiveForm;

?>
<!-- section-request -->
<section class="section-request section-request--mail section-request--no-main cbp-so-section <?= $cssClass ?>">
    <div class="cbp-so-side-top cbp-so-side">
        <div class="container">
            <div class="row">
                <div class="col-xs-12">
                    <?php $form = ActiveForm::begin([
                        'id' => 'formFeedback',
                        'action' => '/feedback/default/ajax',

                        'enableClientValidation' => false,
                        'options' => [
                            'class' => 'form-white-block white-block--wide form',
                            'data-ajax' => false,
                        ],

                    ]); ?>

                    <div class="loader">
                        <div class="three-bounce">
                            <div class="one"></div>
                            <div class="two"></div>
                            <div class="three"></div>
                        </div>
                    </div>

                    <div class="form-inner clearfix">
                        <div class="form-title col-xs-12">Обратная связь</div>
                        <div class="clearfix"></div>
                        <div class="form-box">
                            <?= $form->field($model, 'fio', ['options' => ['class' => 'form-group form-box__el']])->label('Представьтесь, пожалуйста', ['class' => 'form-group__label'])->textInput(['required' => 'required']) ?>
                            <?= $form->field($model, 'company', ['options' => ['class' => 'form-group form-box__el']])->label('Укажите название вашей компании', ['class' => 'form-group__label'])->textInput() ?>
                        </div>
                        <div class="form-box">
                            <div class="form-box__el">
                                <?= $form->field($model, 'phone')->label('Укажите контактный телефон', ['class' => 'form-group__label'])->textInput(['class' => 'form-control', 'required' => 'required', 'type' => 'tel']) ?>
                                <?= $form->field($model, 'email')->label('Укажите ваш e-mail', ['class' => 'form-group__label'])->textInput(['required' => 'required']) ?>
                            </div>
                            <?= $form->field($model, 'text', ['options' => ['class' => 'form-group form-box__el']])->label('Ваше сообщение', ['class' => 'form-group__label'])->textarea(['required' => 'required']); ?>
                        </div>
                        <div class="form-box align-bottom">
                            <?= $form->field($model, 'city', ['options' => ['class' => 'form-group form-box__el']])->label('Укажите ваш город', ['class' => 'form-group__label'])->textInput(['class' => 'form-control autocompleter', 'autocomplete' => 'off']) ?>
                            <div class="form-group form-box__el form-group-confirm">

                                <div class="btn-and-info form-btn btn-and-info--reverse">
                                    <button type="submit" class="btn btn-primary btn-confirm">Отправить</button>
                                    <span class="info">
                                            <label class="wrap-check">
                                              <span class="check"><input class="check-confirm" checked=""
                                                                         type="checkbox"
                                                                         name="Feedback[confirm]" value="1"></span>
                                              <span class="placeholder">Я подтверждаю свое <a target="_blank"
                                                                                              href="<?= FeedbackSettingsHelper::getValue(FeedbackSettings::PRIVACY_POLICY) ?>"
                                                                                              class="link-border">согласие на обработку моих персональных данных</a></span>
                                            </label>
                                        </span>
                                </div>
                                <div class="form-status">
                                    <div class="title fira">Спасибо! Ваша заявка отправлена.</div>
                                    <p class="text">В ближайшее время с вами свяжутся наши специалисты и предоставят вам
                                        всю необходимую информацию.</p>
                                </div>
                                <div class="hide">
                                    <?= $form->field($model, 'msg_type')->hiddenInput(['value' => 2])->label(''); ?>
                                    <?= $form->field($model, 'route')->hiddenInput(['value' => Yii::$app->controller->route])->label(''); ?>
                                </div>
                            </div>
                        </div>
                    </div>
                    <?php ActiveForm::end(); ?>
                </div>
            </div>
        </div>
    </div>
</section>
