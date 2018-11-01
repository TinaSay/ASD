<?php

use yii\bootstrap\Html;
use yii\helpers\Url;
use app\modules\search\widgets\SearchWidget;

/** @var $this yii\web\View */

?>
    <!-- aside -->
    <aside class="pushy aside pushy-left aside--lk" role="navigation">
        <div class="aside__top-layer">
            <div class="aside__head">
                <a href="<?= Url::home(); ?>" class="aside__logo">
                    <?= Html::img('/static/asd/img/logo-text.svg', ['alt' => 'Лого АСД']); ?>
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
                    <a href="#" class="btn btn-info btn-add btn-block"><i class="icon-plus"></i>Создать новый заказ</a>
                </div>
                <ul class="line-list aside__nav">
                    <li><a href="<?= Url::to(['/lk/default/index']) ?>"><i class="aside-item__icon" style="background-image: url(/static/asd/img/lk-1.svg);"></i>Мои заказы <span class="icon-arrow"></span></a></li>
                    <li><a href="#"><i class="aside-item__icon" style="background-image: url(/static/asd/img/lk-2.svg);"></i>Спецпредложения <span class="icon-arrow"></span></a></li>
                    <li><a href="#"><i class="aside-item__icon" style="background-image: url(/static/asd/img/lk-3.svg);"></i>Условия сотрудничества <span class="icon-arrow"></span></a></li>
                    <li><a href="<?= Url::to(['/lk/default/data']) ?>"><i class="aside-item__icon" style="background-image: url(/static/asd/img/lk-4.svg);"></i>Мои данные <span class="icon-arrow"></span></a></li>
                </ul>
                <?php if(isset(Yii::$app->session['user']['manager'])) : ?>
                    <div class="pd-aside">
                        <div class="aside__manager">
                            <div class="manager-info">
                                <?php if(isset(Yii::$app->session['user']['manager']['photo'])) : ?>
                                    <div class="photo"><img src="<?= Yii::$app->session['user']['manager']['photo'] ?>" alt="" width="100" height="100"/></div>
                                <?php endif; ?>
                                <?php if(isset(Yii::$app->session['user']['manager']['name'])) : ?>
                                    <div class="info">
                                        <span class=position>Мой менеджер</span>
                                        <span class="name"><?= Yii::$app->session['user']['manager']['name'] ?></span>
                                    </div>
                                <?php endif; ?>
                            </div>
                            <?php if(isset(Yii::$app->session['user']['manager']['tel'])) : ?>
                                <a href="tel:+79184581212" class="manager-info-contact tel"><i class="icon-tel3"></i> <?= Yii::$app->session['user']['manager']['tel'] ?></a>
                            <?php endif; ?>
                            <?php if(isset(Yii::$app->session['user']['manager']['email'])) : ?>
                                <div class="manager-info-contact mail"><i class="icon-mail3"></i> <?= Yii::$app->session['user']['manager']['email'] ?></div>
                            <?php endif; ?>
                        </div>
                    </div>
                <?php endif; ?>
            </div>
        </div>
        </div>
    </aside>
<?php /*
<!-- aside -->
<aside class="pushy aside pushy-left" role="navigation">
    <div class="aside__top-layer">
        <div class="aside__head">
            <a href="<?= Url::home(); ?>" class="aside__logo">
                <?= Html::img('/static/asd/img/logo-text.svg', ['alt' => 'Лого АСД']); ?>
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
                   class="auth-call-layer-btn btn btn-default btn-block open-page-layer">Кабинет клиента</a>
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
*/ ?>