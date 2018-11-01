<?php
/**
 * Created by PhpStorm.
 * User: elfuvo
 * Date: 14.02.18
 * Time: 8:55
 */

use app\modules\feedback\helpers\FeedbackSettingsHelper;
use app\modules\feedback\models\Feedback;
use app\modules\feedback\models\FeedbackSettings;
use app\modules\wherebuy\widgets\WhereBuyProductWidget;
use yii\helpers\Url;
use yii\widgets\ActiveForm;

/* @var $this yii\web\View */
/* @var $model \app\modules\feedback\models\Feedback */
/* @var $cssClass string */
/* @var $productId int|null */

$whereBuyWidget = WhereBuyProductWidget::widget();
?>
<div class="catalogue-card__form white-block white-block--wide">
    <div class="catalogue-card__head">
        <h5 class="title">Хотите приобрести этот товар?</h5>
        <ul class="catalogue-card__tab">
            <li class="active custom-tab-item">
                <a data-toggle="tab" href="#panel1" title="Оптовая закупка">
                    <img src="/static/asd/img/wholesale.svg" alt="">
                </a>
            </li>
            <?php if ($whereBuyWidget): ?>
            <li class="custom-tab-item">
                <a data-toggle="tab" href="#panel2" title="Розничная закупка">
                    <img src="/static/asd/img/retail.svg" alt="">
                </a>
            </li>
            <?php endif; ?>
        </ul>
    </div>

    <div class="tab-content catalogue-card__tab-content">
        <div id="panel1" class="tab-pane fade in active">
            <?php $form = ActiveForm::begin([
                'id' => 'formBuy',
                'action' => '/feedback/default/ajax',
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
                <div class="row">
                    <div class="form-box form-box--50">
                        <?= $form->field($model, 'phone', ['options' => ['class' => 'form-group form-box__el']])
                            ->label('Укажите контактный телефон', ['class' => 'form-group__label'])
                            ->textInput([
                                'id' => 'buy-phone',
                                'class' => 'form-control',
                                'required' => 'required',
                                'type' => 'tel',
                            ]); ?>
                        <?= $form->field($model, 'email', ['options' => ['class' => 'form-group form-box__el']])
                            ->label('Укажите ваш e-mail', ['class' => 'form-group__label'])
                            ->textInput([
                                'id' => 'buy-email',
                                'required' => 'required',
                            ]) ?>
                    </div>
                </div>
                <?= $form->field($model, 'fio', ['options' => ['class' => 'form-group hide-form-group']])
                ->label('Представьтесь, пожалуйста', ['class' => 'form-group__label'])
                ->textInput(['id' => 'buy-fio', 'required' => 'required']) ?>
                <div class="form-group-confirm">
                    <span class="info hide-form-group">
                         <label class="wrap-check">
                          <span class="check"><input class="check-confirm" checked="" type="checkbox"
                                                     name="Feedback[confirm]"></span>
                          <span class="placeholder">Я подтверждаю свое
                              <a target="_blank"
                                 href="<?= FeedbackSettingsHelper::getValue(FeedbackSettings::PRIVACY_POLICY) ?>"
                                 class="link-border">согласие на обработку моих персональных данных</a></span>
                         </label>
                    </span>
                    <div class="form-box align-bottom pd-top-10">
                        <div class="form-group form-group-confirm">
                            <div class="btn-and-info btn-and-info--50 form-btn">
                                <button class="btn btn-primary btn-confirm">Получить прайс-лист</button>
                                <span class="info xs-font">
                                    Обратите внимание: в нашей компании минимальный объём закупки — от 50&nbsp;000 рублей.
                                </span>
                            </div>
                            <div class="form-status">
                                <div class="title fira">Спасибо! Ваша заявка отправлена.</div>
                                <p class="text">В ближайшее время с вами свяжутся наши специалисты и
                                    предоставят вам всю необходимую информацию.</p>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
            <?= $form->field($model, 'msg_type',
                ['options' => ['class' => 'hidden']])->hiddenInput(['value' => Feedback::FTYPE_ORDER])->label(''); ?>
            <?= $form->field($model, 'route',
                ['options' => ['class' => 'hidden']])->hiddenInput(['value' => 'product/catalog/view'])->label(''); ?>
            <?= $form->field($model, 'productId',
                ['options' => ['class' => 'hidden']])->hiddenInput(['value' => $productId])->label(''); ?>
            <?= $form->field($model, 'city', ['options' => ['class' => 'hidden']])->hiddenInput()->label(''); ?>
            <?= $form->field($model, 'country', ['options' => ['class' => 'hidden']])->hiddenInput()->label(''); ?>
            <?php ActiveForm::end(); ?>
        </div>
        <?php if ($whereBuyWidget): ?>
            <div id="panel2" class="tab-pane fade">
                <?= $whereBuyWidget; ?>
                <a href="<?= Url::to(['/wherebuy/default/index']) ?>" class="btn btn-primary all-store-btn">
                    Все магазины
                </a>
            </div>
        <?php endif; ?>
    </div>
</div>
