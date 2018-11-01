<?php
/**
 * Copyright (c) Rustam
 */

use app\modules\contact\models\Contactsetting;
use app\modules\search\widgets\SearchWidget;

?>
<!-- footer -->
<footer class="footer">
    <div class="container">


        <div class="row footer__top">
            <div class="col-lg-4 col-md-5">
                <a class="footer__tel"
                   href="tel:<?= Contactsetting::getValue('code') . Contactsetting::getValue('phone') ?>"><big><?= Contactsetting::getValue('code') ?></big> <?= Contactsetting::getValue('phone') ?>
                </a>
            </div>
            <div class="col-lg-5 col-md-7">
                <?= \elfuvo\menu\widgets\MenuWidget::widget([
                    'section' => 'top',
                    'view' => '@app/modules/menu/widgets/views/topMenu',
                ]) ?>
            </div>
            <div class="col-lg-3 col-md-12">
                <a href="#" data-href="page-cooperation" id="open-page-cooperation-footer-btn" class="open-page-layer footer-header__btn-account">
                    <span class="btn-first"><i class="icon-dialog2"></i></span>
                    <span class="btn-second">Получить консультацию</span>
                </a>
            </div>
        </div>
        <div class="row footer__middle">
            <div class="col-lg-4 col-md-5">
                <div class="footer__box">
                    <div class="title"><?= Contactsetting::getValue('title') ?></div>
                    <div class="text"><?= Contactsetting::getValue('text') ?></div>
                </div>
                <div class="footer__box">
                    <div class="title"><?= Contactsetting::getValue('subtitle') ?></div>
                    <div class="text"><?= Contactsetting::getValue('subtext') ?>
                    </div>
                </div>
            </div>
            <div class="col-lg-5 col-md-7">
                <?= SearchWidget::widget(['view' => 'footer-search', 'formClass' => 'footer-header__search']) ?>
                <div class="footer__info">
                    <?= Contactsetting::getValue('rules') ?>
                </div>
            </div>
            <div class="col-lg-3 col-md-7">
                <?= \app\modules\contact\widgets\FooterSocialsWidget::widget(); ?>
            </div>
        </div>
        <div class="row footer__bottom">
            <div class="col-lg-4 col-md-5 col-xs-12">1997 — <?= date('Y'); ?> «Компания ASD»</div>
            <div class="col-lg-3 col-lg-offset-5 col-md-7 col-md-offset-5 col-xs-12"><a class="footer__nsign-link"
                                                                                        target="_blank" href="http://nsign.ru/">Создание
                    сайта <span>«Nsign»</span></a></div>
        </div>
    </div>
</footer>
<!-- /footer -->
