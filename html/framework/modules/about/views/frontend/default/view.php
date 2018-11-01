<?php

use app\modules\about\assets\AboutAsset;
use app\modules\feedback\widget\feedback\FeedbackWidget;
use app\modules\record\widget\record\RecordWidget;
use yii\bootstrap\Html;
use yii\helpers\Url;

/** @var $model \app\modules\about\models\About */
/** @var $this yii\web\View */

AboutAsset::register($this);
$menu = $model->aboutListMenu;
$banners = $model->aboutBannersRandLimited;

$this->params['bodyCssClass'] = 'bg-as-main';

$this->title = 'Компания';
if (Yii::$app->request->get('section') === 'left' && $model) {
    $this->title = $model->title;
}
?>
<div data-sticky_parent class="block-aside-left-fix">
    <!-- section-promo -->
    <section class="section-promo cbp-so-section">
        <div class="container">
            <div class="row">
                <div class="col-xs-12">
                    <h1 class="section-title h2"><?= $this->title; ?></h1>
                    <?= \elfuvo\menu\widgets\MenuWidget::widget([
                        'section' => 'top',
                        'view' => '@app/modules/menu/widgets/views/topSubMenu',
                    ]) ?>
                </div>
            </div>
        </div>
        <div class="container">
            <div class="row">
                <div class="promo-page__wrap clearfix">
                    <div class="col-lg-6 col-xs-12 promo-slide__text mr-bottom-0">
                        <?php if (!empty($model->titleForImage) || !empty($model->descriptionImage)): ?>
                            <div class="video-promo-block__name mobile">
                                <?php if (!empty($model->titleForImage)) : ?>
                                    <span class="name fira"><?= $model->titleForImage ?></span>
                                <?php endif; ?>
                                <?php if (!empty($model->descriptionImage)) : ?>
                                    <span class="position"><?= $model->descriptionImage ?></span>
                                <?php endif; ?>
                            </div>
                        <?php endif; ?>
                        <div class="text text-gray">
                            <?= $model->description; ?>
                        </div>
                    </div>
                    <div class="col-lg-6 col-xs-12 promo-slide__image">
                        <div class="circle-promo">
                            <div class="promo-picture">
                                <?php if ($model->getMainVideo()) : ?>
                                    <a data-href="layer-video" data-video="aboutVideo" href="#"
                                       class="video-play open-page-layer promo-picture__link">
                                        <div class="picture picture--type-3"><span><?= Html::img($model->getImagePreview('image',
                                                    'about-main')); ?></span>
                                        </div>
                                        <span class="video-play-btn video-btn"></span>
                                    </a>
                                <?php else: ?>
                                    <div class="picture picture--type-3"><span><?= Html::img($model->getImagePreview('image',
                                                'about-main')); ?></span>
                                    </div>
                                <?php endif; ?>
                            </div>
                            <div class="circle-promo__anim-circle-1"></div>
                            <div class="circle-promo__anim-circle-2"></div>
                            <div class="circle-promo__anim-circle-3"></div>
                            <div class="circle-promo__anim-circle-4"></div>
                            <div class="circle-promo__dot dot-1">
                                <div></div>
                            </div>
                            <div class="circle-promo__dot dot-2">
                                <div></div>
                            </div>
                            <?php if (!empty($model->titleForImage) || !empty($model->descriptionImage)): ?>
                                <div class="video-promo-block__name desctop">
                                    <?php if (!empty($model->titleForImage)) : ?>
                                        <span class="name fira"><?= $model->titleForImage ?></span>
                                    <?php endif; ?>
                                    <?php if (!empty($model->descriptionImage)) : ?>
                                        <span class="position"><?= $model->descriptionImage ?></span>
                                    <?php endif; ?>
                                </div>
                            <?php endif; ?>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </section>

    <?php if (!empty($banners)) : ?>
        <!-- section-records -->
        <section class="section section-records pd-top-0 cbp-so-section pd-bottom-140">
            <div class="cbp-so-side-top cbp-so-side">
                <div class="container">
                    <?php if (!empty($model->titleForBanners)) : ?>
                        <div class="row">
                            <div class="col-xs-12">
                                <h2 class="section-title section-title--sm"><?= $model->titleForBanners ?></h2>
                            </div>
                        </div>
                    <?php endif; ?>
                    <div class="row">
                        <div class="records-list__wrap">
                            <div class="records-list">
                                <div class="slide-mobile">
                                    <?php foreach ($banners as $banner) : ?>
                                        <div class="records-list__item yellow col-lg-4 col-sm-6 col-xs-12">
                                            <div class="inner">
                                                <?php if ($banner->banner->getImage()): ?>
                                                    <div class="img">
                                                        <?= Html::img($banner->banner->getImage()) ?>
                                                    </div>
                                                <?php endif; ?>
                                                <div class="title fira"><?= $banner->banner->title ?></div>
                                                <div class="description"><?= $banner->banner->signature ?></div>
                                            </div>
                                        </div>
                                    <?php endforeach; ?>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </section>
    <?php endif; ?>

    <?php if (!empty($model->urlYoutubeVideo)) : ?>
        <section class="section-video">
            <div class="cbp-so-side-top cbp-so-side">
                <div class="container">
                    <div class="row">
                        <div class="<?= !empty($model->urlYoutubeVideo) || !empty($model->getAdditionalImage()) ? 'col-lg-4 col-md-5 col-xs-12' : 'col-lg-12 col-md-12 col-xs-12' ?>">
                            <h2 class="section-title section-title--sm"><?= $model->titleAdditionalBlock; ?></h2>
                            <div class="text text-gray">
                                <?= $model->additionalDescription; ?>
                            </div>
                        </div>
                        <?php if (!empty($model->urlYoutubeVideo) || !empty($model->getAdditionalImage())) : ?>
                            <div class="col-lg-8 col-md-7 col-xs-12">
                                <div class="wrap-media-video">
                                    <?php if (!empty($model->getAdditionalImage())) : ?>
                                        <div class="video-box__bg"
                                             style="background-image: url(<?= preg_replace('/\\\\/i', '/',
                                                 Url::to([
                                                     $model->getImagePreviewLink('additionalImage', 'additionalImage')
                                                 ]),
                                                 -1) ?>)"></div>
                                    <?php endif; ?>
                                    <?php if (!empty($model->urlYoutubeVideo)) : ?>
                                        <?= $model->embed; ?>
                                        <?php if (!empty($model->getAdditionalImage())) : ?>
                                            <div id="video-play" class="video-play-btn video-btn"></div>
                                        <?php endif; ?>
                                    <?php endif; ?>
                                </div>
                            </div>
                        <?php endif; ?>
                    </div>
                </div>
            </div>
        </section>
    <?php endif; ?>

    <?php if ($model->publicHistory) : ?>
        <?= RecordWidget::widget(['type' => 'history']) ?>
    <?php endif; ?>

</div>

<?php if ($model->publishAnApplication) : ?>
    <?=
    FeedbackWidget::widget([
        'view' => 'mini',
        'cssClass' => 'section-request section-request--no-main mr-top-110 mr-bottom-0',
    ]);
    ?>
<?php endif; ?>

<?php if ($model->getMainVideo()) :
    $this->beginBlock('aboutMainVideo');
    ?>
    <section class="page-layer layer-video" id="layer-video">
        <span class="close-page-layer"></span>
        <div class="video-bg">
            <video id="aboutVideo" width="100%" height="auto" preload="metadata" controls="true">
                <source type="video/mp4" src="<?= Url::to(['/uploads/storage/' . $model->getSrc('mainVideo')]); ?>">
            </video>
        </div>
    </section>
    <?php
    $this->endBlock();
endif; ?>
