<?php

use app\modules\promoBlock\models\PromoBlock;
use yii\bootstrap\Html;

/** @var $this yii\web\View */
/** @var $promos \app\modules\promoBlock\models\PromoBlock[] */
?>
<?php if ($promos): ?>
    <!-- section-promo -->
    <section class="section-promo cbp-so-section">
        <div class="cbp-so-side-top cbp-so-side">
            <div class="container">
                <div class="row">
                    <div class="promo-slide__wrap clearfix">
                        <div class="col-sm-6 col-xs-12 promo-slide__text">
                            <div class="promo-slide__dots"></div>
                            <div class="promo-slide">

                                <?php foreach ($promos as $promo): ?>

                                    <div class="promo-slide__item">
                                        <?php if (!empty($promo->url)): ?>
                                            <a href="<?= $promo->url ?>" target="_blank">
                                                <h1 class="h3 title"><?= $promo->title ?></h1>
                                                <div class="text text-gray"><?= $promo->signature ?></div>
                                                <?php if ($promo->btnShow): ?><?= Html::tag('span',
                                                    ($promo->btnText != '') ? $promo->btnText : 'Узнать больше',
                                                    ['class' => 'btn btn-primary']) ?><?php endif; ?>
                                            </a>
                                        <?php else: ?>
                                            <h1 class="h3 title"><?= $promo->title ?></h1>
                                            <div class="text text-gray"><?= $promo->signature ?></div>
                                        <?php endif; ?>
                                    </div>

                                <?php endforeach; ?>

                            </div>
                        </div>
                        <div class="col-sm-6 col-xs-12 promo-slide__image">
                            <div class="circle-promo">
                                <div class="promo-slide-picture">
                                    <?php foreach ($promos as $promo): ?>
                                        <?php if (!empty($promo->url)): ?>
                                            <a class="picture<?= $promo->imageType == PromoBlock::IMAGE_TYPE_ILLUSTRATION ? ' picture--type-2' : '' ?>"
                                               href="<?= $promo->url ?>" target="_blank">
                                                <?= Html::img($promo->getBannerCrop()) ?>
                                            </a>
                                        <?php else: ?>
                                            <div class="picture<?= $promo->imageType == PromoBlock::IMAGE_TYPE_ILLUSTRATION ? ' picture--type-2' : '' ?>">
                                                <?= Html::img($promo->getBannerCrop()) ?>
                                            </div>
                                        <?php endif; ?>
                                    <?php endforeach; ?>
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
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </section>
<?php endif; ?>