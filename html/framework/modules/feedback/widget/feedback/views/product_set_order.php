<?php
/**
 * Created by PhpStorm.
 * User: elfuvo
 * Date: 19.02.18
 * Time: 15:09
 */

use app\modules\feedback\helpers\FeedbackSettingsHelper;
use app\modules\feedback\models\Feedback;
use app\modules\feedback\models\FeedbackSettings;
use yii\bootstrap\ActiveForm;

/* @var $this yii\web\View */
/* @var $model \app\modules\feedback\models\Feedback */
?>
<?php $form = ActiveForm::begin([
    'id' => 'formFeedback',
    'action' => '/feedback/default/ajax',

    'enableClientValidation' => false,
    'options' => [
        'data-ajax' => 1,
        'class' => 'form-white-block form',
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
        <div class="row">
            <div class="form-box form-box--50">
                <?= $form->field($model, 'fio', ['options' => ['class' => 'form-group form-box__el']])
                    ->label('Представьтесь, пожалуйста', ['class' => 'form-group__label'])
                    ->textInput(['required' => true]); ?>
                <?= $form->field($model, 'city', ['options' => ['class' => 'form-group form-box__el']])
                    ->label('Укажите ваш город', ['class' => 'form-group__label'])
                    ->textInput(['class' => 'form-control autocompleter', 'autocomplete' => 'off']) ?>

            </div>
        </div>
        <div class="row">
            <div class="form-box form-box--50">
                <?= $form->field($model, 'phone', ['options' => ['class' => 'form-group form-box__el']])
                    ->label('Укажите контактный телефон', ['class' => 'form-group__label'])
                    ->textInput(['required' => true, 'type' => 'tel']); ?>
                <?= $form->field($model, 'email', ['options' => ['class' => 'form-group form-box__el']])
                    ->label('Укажите ваш e-mail', ['class' => 'form-group__label'])
                    ->textInput(['required' => true]); ?>
            </div>
        </div>
        <div class="form-group">
            <?= $form->field($model, 'company', ['options' => ['class' => 'form-group']])
                ->label('Укажите название вашей компании', ['class' => 'form-group__label'])
                ->textInput() ?>
        </div>
        <div class="btn-and-info form-btn btn-and-info--reverse">
            <button class="btn btn-primary btn-confirm">Отправить</button>
            <span class="info">
                        <label class="wrap-check">
                          <span class="check"><input class="check-confirm" checked="" type="checkbox" name=""></span>
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
<?= $form->field($model, 'msg_type')->hiddenInput(['value' => Feedback::FTYPE_MESSAGE])->label(false); ?>

<?php ActiveForm::end(); ?>