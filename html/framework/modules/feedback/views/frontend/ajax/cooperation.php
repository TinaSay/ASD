<?php
/**
 * Created by PhpStorm.
 * User: Rustam
 * Date: 07.05.2018
 * Time: 21:06
 */

use app\modules\contact\models\Contactsetting;
use app\modules\feedback\widget\feedback\FeedbackWidget;

?>


<div class="page-cooperation__wrap">
    <div class="container">
        <div class="col-xs-12">
            <h2 class="section-title">Начать сотрудничество</h2>
            <div class="section-title__description">3 простых шага на пути к взаимовыгодному сотрудничеству
            </div>
            <div class="stage-cooperation clearfix">
                <div class="stage-1 stage-cooperation__box-wrap">
                    <div class="stage-cooperation__box">
                        <span class="num">1</span>
                        <div class="text">Свяжитесь с нами любым удобным для вас способом</div>
                        <i class="i" style="background-image: url(/static/asd/img/stage_1.svg);"></i>
                    </div>
                </div>
                <div class="stage-2 stage-cooperation__box-wrap">
                    <div class="stage-cooperation__box">
                        <span class="num">2</span>
                        <div class="text">Наши специалисты зададут вам несколько вопросов</div>
                        <i class="i" style="background-image: url(/static/asd/img/stage_2.svg);"></i>
                    </div>
                </div>
                <div class="stage-3 stage-cooperation__box-wrap">
                    <div class="stage-cooperation__box">
                        <span class="num">3</span>
                        <div class="text">Вы получите наше комплексное предложение с лучшей ценой</div>
                        <i class="i" style="background-image: url(/static/asd/img/stage_3.svg);"></i>
                    </div>
                </div>
            </div>
            <div class="white-block white-block--wide cooperation-form-block">
                <div class="row">
                    <div class="col-lg-5 col-xs-12 pull-right">
                        <div class="cooperation__tel-box">
                            <span class="top-text">Связаться с нами по телефону</span>
                            <a class="tel" href="tel:<?= Contactsetting::getCallablePhone(); ?>">
                                <span><?= Contactsetting::getValue('code'); ?> </span>
                                <big><?= Contactsetting::getValue('phone'); ?></big>
                            </a>
                            <a id="feedback-layer-two-open-btn" href="#" data-href="page-tel"
                               class="footer-header__btn-tel open-page-layer">
                                <span class="btn-first"><i class="icon-tel2"></i></span>
                                <span class="btn-second">Заказать обратный звонок</span>
                            </a>
                        </div>
                    </div>
                    <div class="col-lg-7 col-xs-12">
                        <?= FeedbackWidget::widget([
                            'view' => 'from_menu_full',
                            'cssClass' => '',
                        ]) ?>
                    </div>
                </div>
            </div>
        </div>
    </div>
</div>