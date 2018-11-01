<?php

use app\modules\contact\models\Contactsetting;
use yii\bootstrap\Html;
use yii\helpers\Url;
use app\modules\search\widgets\SearchWidget;

/** @var $this yii\web\View */

?>
<!-- aside -->
<aside class="pushy aside pushy-left" role="navigation">
    <div class="aside__top-layer">
        <div class="aside__head">
            <a href="<?= Url::home(); ?>" class="aside__logo">
                <span class="logo-text">
                    Российская торгово-<br>
                    производственная<br>
                    компания
                </span>
                <?= Html::img('/static/asd/img/logo.svg', ['alt' => 'Лого АСД']); ?>
            </a>
        </div>
        <div class="aside__inner scroll">
            <?= SearchWidget::widget(['view' => 'footer-search', 'formClass' => 'aside-form-search-bottom']) ?>
            <div class="aside__nav-mobile line-list top-nav clearfix">
                <?= \elfuvo\menu\widgets\MenuWidget::widget([
                    'section' => 'top',
                    'view' => '@app/modules/menu/widgets/views/topMenuMobile',
                ]) ?>
            </div>

            <div class="pd-aside aside__desktop">
                <a id="open-page-cooperation-btn" data-href="page-cooperation" href="#"
                   class="btn btn-info btn-block open-page-layer">
                    Начать сотрудничество
                </a>
            </div>
            <?= \elfuvo\menu\widgets\MenuWidget::widget([
                'section' => 'left',
                'view' => '@app/modules/menu/widgets/views/leftMenu',
            ]) ?>
            <div class="pd-aside">
                <a class="aside__tel"
                   href="tel:<?= Contactsetting::getCallablePhone(); ?>"><i
                            class="icon-tel2"></i><big><?= Contactsetting::getValue('code') ?> </big>
                    <span><?= Contactsetting::getValue('phone') ?></span></a>
                <a id="feedback-call-layer-btn" href="#" data-href="page-tel"
                   class="btn btn-default btn-block open-page-layer">Заказать обратный
                    звонок</a>
                <a href="#" data-href="page-auth"
                   class="btn btn-info btn-add btn-block auth-call-layer-btn open-page-layer"><i class="icon-user"></i>Кабинет клиента</a>
            </div>
        </div>
    </div>
    <div class="aside__sub-layer">
        <span class="aside__sub-layer-close close"><i class="icon-arrow"></i></span>
        <?= \elfuvo\menu\widgets\MenuWidget::widget([
            'section' => 'left',
            'view' => '@app/modules/menu/widgets/views/leftMenuSublayer',
        ]) ?>
    </div>
</aside>
