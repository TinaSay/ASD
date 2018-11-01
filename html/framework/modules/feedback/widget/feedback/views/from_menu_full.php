<?php

use app\modules\feedback\helpers\FeedbackSettingsHelper;
use yii\widgets\ActiveForm;
use app\modules\feedback\models\FeedbackSettings;


?>
<!-- section-request -->
<?php $form = ActiveForm::begin([
    'id' => 'formCooperation',
    'action' => '/feedback/default/ajax',
    'enableClientValidation' => false,
]); ?>

<div class="form-inner clearfix <?= $cssClass ?>">
    <div class="form-title col-xs-12">Заполните форму</div>
    <div class="clearfix"></div>
    <div class="form-box">
        <?= $form->field($model, 'fio', ['options' => ['class' => 'form-group form-box__el']])->label('Представьтесь, пожалуйста', ['class' => 'form-group__label'])->textInput(['id'=>'feedback-fio-from-menu', 'required'=>'required']) ?>
        <?= $form->field($model, 'city', ['options' => ['class' => 'form-group form-box__el']])->label('Укажите ваш город', ['class' => 'form-group__label'])->textInput(['id'=>'feedback-city-from-menu','class' => 'form-control autocompleter', 'autocomplete' => 'off']) ?>
    </div>
    <div class="form-box">
        <?= $form->field($model, 'company', ['options' => ['class' => 'form-group form-box__el']])->label('Укажите название вашей компании', ['class' => 'form-group__label'])->textInput(['id'=>'feedback-company-from-menu']) ?>
    </div>
    <div class="form-box">
        <?= $form->field($model, 'phone', ['options' => ['class' => 'form-group form-box__el']])->label('Укажите контактный телефон', ['class' => 'form-group__label'])->textInput(['class' => 'form-control', 'id' => 'feedback-phone-from-menu', 'required' => 'required', 'type' => 'tel']) ?>
        <?= $form->field($model, 'email',['options' => ['class' => 'form-group form-box__el']])->label('Укажите ваш e-mail', ['class' => 'form-group__label'])->textInput(['id'=>'feedback-email-from-menu','required'=>'required']) ?>
    </div>
    <div class="form-box">
        <?= $form->field($model, 'text', ['options' => ['class' => 'form-group form-box__el']])->label('Введите текст сообщения', ['class' => 'form-group__label'])->textarea(['id'=>'feedback-text-from-menu','required'=>'required']); ?>
    </div>
    <div class="form-box align-bottom">
        <div class="form-group form-box__el form-group-confirm">
            <div class="btn-and-info form-btn btn-and-info--reverse">
                <button type="submit" class="btn btn-primary btn-confirm">Получить предложение</button>
                <span class="info">
                    <label class="wrap-check">
                        <span class="check"><input class="check-confirm" checked="" value="1" type="checkbox"
                                                   name="Feedback[confirm]"></span>
                        <span class="placeholder">Я подтверждаю свое <a target="_blank"
                                                                        href="<?= FeedbackSettingsHelper::getValue(FeedbackSettings::PRIVACY_POLICY) ?>"
                                                                        class="link-border">согласие на обработку моих персональных данных</a></span>
                    </label>
				</span>
                <div class="hide">
                <?= $form->field($model, 'msg_type')->hiddenInput(['value' => 2, 'id' => $form->id . '-msg_type'])->label(''); ?>
                <?= $form->field($model, 'route')->hiddenInput(['value' => 'index/left/block', 'id' => $form->id . '-route'])->label(''); ?>
                </div>
            </div>
            <div class="form-status" style="display: none;">
                <div class="title fira">Спасибо! Ваша заявка отправлена.</div>
                <p class="text">В ближайшее время с вами свяжутся наши специалисты и предоставят вам всю необходимую информацию.</p>
            </div>
        </div>
    </div>
</div>

<?php ActiveForm::end(); ?>

