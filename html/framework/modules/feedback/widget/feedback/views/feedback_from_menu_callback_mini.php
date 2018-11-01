<?php

use app\modules\feedback\assets\FeedbackAssets;
use app\modules\feedback\helpers\FeedbackSettingsHelper;
use app\modules\feedback\models\FeedbackSettings;
use yii\widgets\ActiveForm;

$bundle = FeedbackAssets::register($this);

?>
<!-- section-request -->
<?php $form = ActiveForm::begin([
    'id' => 'formTel',
    'action' => '/feedback/default/ajax',
    'enableClientValidation' => false,
    'options' => [
        'data-ajax' => 1,
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

<div class="form-inner <?= $cssClass ?>">
        <?= $form->field($model, 'fio', ['options' => ['class' => 'form-group']])->label('Представьтесь, пожалуйста', ['class' => 'form-group__label','for'=>'feedback-fio-from-menu'])->textInput(['id'=>'feedback-fio-from-menu','required'=>'required']) ?>
    <?= $form->field($model, 'phone', ['options' => ['class' => 'form-group']])->label('Укажите контактный телефон', ['class' => 'form-group__label','for'=>'feedback-phone-from-menu'])->textInput(['id' => 'feedback-phone-from-menu', 'type' => 'tel', 'class' => 'form-control', 'required' => 'required']) ?>

        <div class="form-group">
            <label class="form-group__label">Когда вам будет удобнее ответить?</label>
            <label class="wrap-check">
                <input type="radio" class="time-check" checked name="time">
                <span class="placeholder">Перезвонить сейчас</span>
            </label>
            <label class="wrap-check">
                <input type="radio" class="time-check accurate-time" name="time">
                <span class="placeholder">Указать точное время</span>
            </label>
        </div>
        <div class="form-group accurate-time-box">
            <div class="accurate-time-box__wrap">
                <input class="form-control" placeholder="00" autocomplete="off" id="input-date-hour" name="timeHour"
                       maxlength="2">
                <span>:</span>
                <input class="form-control" placeholder="00" autocomplete="off" id="input-date-minutes"
                       name="timeMinute" maxlength="2">
                <span>по московскому времени</span>
            </div>
        </div>

        <div class="btn-and-info form-btn btn-and-info--reverse btn-and-info--column">
            <button class="btn btn-primary btn-confirm ">Заказать звонок</button>

            <span class="info">
		         <label class="wrap-check">
		          <span class="check"><input class="check-confirm" checked="" type="checkbox" name="Feedback[confirm]"></span>
		          <span class="placeholder">Я подтверждаю свое <a target="_blank"
                                                                  href="<?= FeedbackSettingsHelper::getValue(FeedbackSettings::PRIVACY_POLICY) ?>"
                                                                  class="link-border">согласие на обработку моих персональных данных</a></span>
                 </label>
            </span>
            <?= $form->field($model, 'msg_type')->hiddenInput(['value' => 1, 'id' => $form->id . '-msg_type'])->label(''); ?>
            <?= $form->field($model, 'route')->hiddenInput(['value' => 'index/left/block', 'id' => $form->id . '-route'])->label(''); ?>
        </div>
        <div class="form-status">
            <div class="title fira">Спасибо! Ваша заявка отправлена.</div>
            <p class="text">В ближайшее время с вами свяжутся наши специалисты и предоставят вам всю необходимую информацию.</p>
        </div>

    </div>
<?php ActiveForm::end(); ?>
