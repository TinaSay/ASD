<?php
/**
 * Copyright (c) Rustam
 */

/* @var $this yii\web\View */

use app\modules\contact\assets\ContactAssets;
use app\modules\feedback\widget\feedback\FeedbackWidget;

$bundle = ContactAssets::register($this);

?>
    <style> .is_close {
            display: none;
        }</style>

<div data-sticky_parent class="block-aside-left-fix">

    <!-- section-promo -->
    <section class="section-promo">
        <div class="container">
            <div class="row">
                <div class="col-xs-12">
                    <h1 class="section-title h2">Контакты</h1>
                    <div class="tabs-nav-wrap tabs-nav-wrap--border-cover hit-nav desktop-hit-nav">
                        <ul class="nav nav-tabs" id="navbar-hit">

                            <?php /** @var array $divisionList */
                            foreach ($divisionList as $key1 => $division): ?>
                                <li class="custom-tab-item <?= ($key1 == 0 ? 'active' : '') ?>"
                                    data-lat="<?= (isset($division->lat) ? $division->lat : 55.757982) ?>"
                                    data-long="<?= (isset($division->long) ? $division->long : 37.621319) ?>">
                                    <a href="#" data-tab="tab-panel-<?= $division->id ?>"><?= $division->title ?></a>
                                </li>
                            <?php endforeach; ?>

                            <li class="tabs-container dropdown">
                                <div class="tabs-container__btn dropdown-toggle" data-toggle="dropdown"
                                     aria-haspopup="true"
                                     aria-expanded="false"></div>
                                <div class="tabs-container__content dropdown-menu"></div>
                            </li>
                        </ul>
                        <div class="net nav-net-right news-net-link">
                            <div class="news-net-link__title">Будьте в курсе всех событий, подписывайтесь на наши группы</div>
                            <?php /** @var array $networkList */
                            if ($networkList):?>
                                <ul>
                                    <?php /** @var \app\modules\contact\models\Network $network */
                                    foreach ($networkList as $network) : ?>
                                        <li><a class="net-link" href="<?= $network->getUrl() ?>" target="_blank"
                                               style="background-image: url(<?= $network->getImage() ?>)"></a></li>
                                    <?php endforeach; ?>
                                </ul>
                            <?php endif; ?>
                        </div>
                    </div>
                    <div data-sticky_aside class="mobile-hit-nav hit-nav row">
                        <ul>
                            <?php /** @var array $divisionList */
                            foreach ($divisionList as $key0 => $division): ?>
                                <li class="custom-tab-item <?= ($key0 == 0 ? 'active' : '') ?>"
                                    data-lat="<?= (isset($division->lat) ? $division->lat : 55.757982) ?>"
                                    data-long="<?= (isset($division->long) ? $division->long : 37.621319) ?>">
                                    <a href="#" data-tab="tab-panel-<?= $division->id ?>"><?= $division->title ?></a>
                                </li>
                            <?php endforeach; ?>

                        </ul>
                    </div>
                </div>
            </div>
        </div>
    </section>
<?php /** @var array $divisionList */
/** @var \app\modules\contact\models\Division $division */
foreach ($divisionList as $key => $division): ?>
    <section class="section-contact tab-panel-<?= $division->id ?> <?php if ($key > 0) {
        echo "is_close";
    } ?>">
        <div class="container">
            <div class="row">
                <div class="col-xs-12">
                    <div class="white-block white-block--wide">
                        <div class="col-xs-12"><h5 class="title-border"><?= $division->subtitle ?></h5></div>
                        <div class="col-md-6 col-xs-12">
                            <?php if ($division->phone): ?>
                                <div class="contact-box">
                                    <i class="contact-icon icon-tel"></i>
                                    <div class="contact-box__title">Телефон/факс:</div>
                                    <div class="contact-box__text last-i-hide">
                                        <?= $division->phone ?>
                                    </div>
                                </div>
                            <?php endif; ?>
                            <?php if ($division->address): ?>
                                <div class="contact-box">
                                    <i class="contact-icon icon-map"></i>
                                    <div class="contact-box__title">Адрес:</div>
                                    <div class="contact-box__text">
                                        <?= $division->address ?>
                                    </div>
                                </div>
                            <?php endif; ?>


                            <?php
                            $metros = $division->metros;
                            if (count($metros) > 0):?>
                                <div class="contact-box">
                                    <i class="contact-icon icon-subway"></i>
                                    <div class="contact-box__title">Ближайшие станции метро:</div>
                                    <div class="contact-box__text">
                                        <ul class="subway-list">
                                            <?php /** @var \app\modules\contact\models\Metro $metro */
                                            foreach ($metros as $metro): ?>
                                                <style>.subway-list li.line-<?=$metro->id?>:after {
                                                        background: #<?=$metro->color?>;
                                                    }</style>
                                                <li class="line-<?= $metro->id ?>">
                                                    <span><?= $metro->name ?></span>
                                                    <i></i>
                                                    <span><?= $metro->distance ?></span>
                                                </li>
                                            <?php endforeach; ?>
                                        </ul>
                                    </div>
                                </div>
                            <?php endif; ?>


                        </div>
                        <?php if ($division->email): ?>
                            <div class="col-md-6 col-xs-12">
                                <div class="contact-box">
                                    <i class="contact-icon icon-mail2"></i>
                                    <div class="contact-box__title">Адрес электронной почты:</div>
                                    <div class="contact-box__text">
                                        <a href="mailto:<?= $division->email ?>"><?= $division->email ?></a>
                                    </div>
                                </div>
                            </div>
                        <?php endif; ?>
                        <?php if ($division->working): ?>
                            <div class="col-md-6 col-xs-12">
                                <div class="contact-box">
                                    <i class="contact-icon icon-clock"></i>
                                    <div class="contact-box__title">Режим работы:</div>
                                    <div class="contact-box__text">
                                        <?= $division->working ?>
                                    </div>
                                </div>
                            </div>
                        <?php endif; ?>
                        <div class="col-md-6 col-xs-12">
                            <?php
                            $requisites = $division->requisites;
                            if (count($requisites) > 0):?>
                                <?php /** @var \app\modules\contact\models\Requisite $requisites
                                 * @var integer $reqkey
                                 */
                                foreach ($requisites as $reqkey => $requisite): ?>
                                    <?php if (!empty($requisite->name)): ?>
                                        <div class="contact-box">
                                            <i class="contact-icon icon-page"></i>
                                            <div class="contact-box__title"><?= $requisite->name ?>:</div>
                                            <div class="contact-box__text">
                                                <a class="link-border" target="_blank"
                                                   href="<?= $requisite->getFilePathUrl() ?>">Скачать <?= $requisite->getFileExt() ?>
                                                    (<?= $requisite->getFileSize() ?>)</a>
                                            </div>
                                        </div>
                                    <?php endif; ?>
                                <?php endforeach; ?>
                            <?php endif; ?>

                        </div>
                    </div>
                </div>
            </div>
        </div>
    </section>
<?php endforeach; ?>

    <div class="map" id="map"></div>

<?= FeedbackWidget::widget(['view' => 'full']) ?>

</div>

