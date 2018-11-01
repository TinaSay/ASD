<?php
/**
 * Copyright (c) Rustam
 */

use app\modules\search\widgets\SearchWidget;
use yii\bootstrap\Html;
use yii\helpers\Url;

?>
<!-- header -->
<div class="header-reserve"></div>
<header class="header">
    <div class="container">
        <div class="row hidden-sm hidden-xs">
            <div class="col-lg-5 col-md-7">
                <?= \elfuvo\menu\widgets\MenuWidget::widget([
                    'section' => 'top',
                    'view' => '@app/modules/menu/widgets/views/topMenu',
                ]) ?>
            </div>
            <div class="col-lg-7 col-md-5">
                <div class="footer-header__btn">
                    <?= SearchWidget::widget() ?>
                    <!--<span class="form-search-btn"><i class="icon-loupe"></i></span>-->
                    <?php if(!Yii::$app->session->get('user')) : ?>
                        <a href="#" data-href="page-auth" class="open-page-layer footer-header__btn-account">
                            <span class="btn-first"><i class="icon-user"></i></span>
                            <span class="btn-second">Кабинет клиента</span>
                        </a>
                    <?php else : ?>
                    <a href="<?= Url::to(['/lk/default/logout']) ?>" class="footer-header__btn-account">
                        <span class="btn-first"><i class="icon-out"></i></span>
                        <span class="btn-second">Выйти из кабинета</span>
                    </a>
                    <?php endif; ?>
                </div>
            </div>
        </div>
        <div class="row visible-sm visible-xs">
            <div class="col-xs-12">
                <div class="header-sm">
                    <a href="/" class="aside__logo">
                        <span class="logo-text">
                            Российская торгово-<br>
                            производственная<br>
                            компания
                        </span>
                        <?= Html::img('/static/asd/img/logo2.svg',
                            ['class' => 'logo', 'alt' => 'Лого АСД']); ?>
                    </a>
                    <div class="header__btn">
                        <a href="#" class="btn btn-info btn-header-cooperation mb-hide open-page-layer"
                           id="open-page-cooperation-header-btn" data-href="page-cooperation">Начать сотрудничество</a>

                        <a class="mb-show header__btn-el aside__tel" href="tel:+74959253311"><i
                                    class="icon-tel"></i><span
                                    class="wrap-text"><big>+7 (495) </big> <span>925 33 11</span></span></a>

                        <?= SearchWidget::widget() ?>

                        <span class="header__btn-el btn btn-nav-t btn-primary btn-aside-push menu-btn hidden-xs"
                              data-page="aside">
                            <div class="btn-gamb">
                                <span></span>
                                <span></span>
                                <span></span>
                                <span></span>
                            </div>
                        </span>
                    </div>
                </div>
            </div>
        </div>
        <hr class="header-hr hr">
    </div>
</header>
<!-- /header -->


<!-- навигация на мобильном снизу -->
<div class="add-nav-xs">
    <div class="add-nav-xs__btn add-nav-xs__btn--left"><a href="#" class="add-nav-xs__btn add-nav-hand">
            <div data-href="page-cooperation" class="btn-hand-wrap open-page-layer"
                 id="open-page-cooperation-mobile-btn"><i class="icon-hand"></i><span>Начать</span>
                сотрудничество
            </div>
        </a></div>
    <div class="add-nav-xs__btn add-nav-xs__btn--right">
        <span class="add-nav-xs__btn-el btn btn-nav-t btn-primary btn-aside-push menu-btn" data-page="aside">
            <div class="btn-gamb">
                <span></span>
                <span></span>
                <span></span>
                <span></span>
            </div>
        </span>
    </div>
</div>
