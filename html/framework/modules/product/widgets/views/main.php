<?php
/**
 * Created by PhpStorm.
 * User: elfuvo
 * Date: 20.02.18
 * Time: 18:28
 */

use yii\helpers\Html;
use yii\helpers\Url;

/** @var $this yii\web\View */
/** @var $list array */
/** @var $usages array */

?>
<?php if ($list): ?>
<div data-sticky_parent class="block-aside-left-fix">
    <!-- section-hit -->
    <section class="section section-hit">
        <div class="">
            <div class="container">
                <div class="row">
                    <div class="col-xs-12">
                        <h2 class="section-title">Новинки и хиты продаж</h2>
                        <div class="tabs-nav-wrap hit-nav desktop-hit-nav">
                            <ul class="nav nav-tabs" id="navbar-hit">
                                <?php $expanded = true;
                                foreach ($usages as $usage): ?>
                                    <li class="<?php if ($expanded): ?>active <?php endif; ?>custom-tab-item">
                                        <a href="#tab_hit_<?= $usage['id']; ?>" role="tab" data-toggle="tab"
                                           aria-controls="home" <?php if ($expanded):
                                           $expanded = false; ?>aria-expanded="true"<?php endif; ?>>
                                            <?= $usage['title']; ?>
                                        </a>
                                    </li>
                                <?php endforeach; ?>
                                <li class="tabs-container dropdown">
                                    <div class="tabs-container__btn dropdown-toggle" data-toggle="dropdown"
                                         aria-haspopup="true" aria-expanded="false"></div>
                                    <div class="tabs-container__content dropdown-menu"></div>
                                </li>
                            </ul>
                        </div>
                    </div>
                </div>
                <div data-sticky_parent class="block-aside-left-fix">
                    <div data-sticky_aside class="mobile-hit-nav hit-nav row">
                        <ul>
                            <?php $expanded = true;
                            foreach ($usages as $usage): ?>
                                <li class="<?php if ($expanded): ?>active <?php endif; ?>custom-tab-item">
                                    <a href="#tab_hit_<?= $usage['id']; ?>" role="tab" data-toggle="tab"
                                       aria-controls="home" <?php if ($expanded):
                                       $expanded = false; ?>aria-expanded="true"<?php endif; ?>>
                                        <?= $usage['title']; ?>
                                    </a>
                                </li>
                            <?php endforeach; ?>
                        </ul>
                    </div>
                    <div class="row">
                        <div class="tab-content">
                            <?php
                            $expanded = true;
                            foreach ($usages as $usage): ?>
                                <div class="tab-pane fade<?php if ($expanded): $expanded = false; ?> active in<?php endif; ?>"
                                     role="tabpanel" id="tab_hit_<?= $usage['id']; ?>"
                                     aria-labelledby="home-tab">
                                    <div class="offer-list offer-list--main clearfix">
                                        <?php
                                        /** @var \app\modules\product\models\Product $model */
                                        foreach ($list[$usage['id']] as $model): ?>
                                            <div class="offer-list__item col-lg-3 col-md-4 col-xs-12">
                                                <a href="<?= Url::to([
                                                    '/product/catalog/view',
                                                    'alias' => $model->alias,
                                                ]); ?>">
                                                    <div class="inner">
                                                        <div class="img">
                                                            <div class="bg-width img-bg" style="background-image: url(<?= $model->getFirstImageUrl() ?>);"></div>
                                                            <?php if ($model->promos): ?>
                                                                <?php foreach ($model->promos as $promo): ?>
                                                                    <span style="<?= $promo->getIcon() ? 'background-image: url(' . $promo->getIconUrl() . ');' : ''; ?><?= $promo->color ? 'background-color: #' . $promo->color : ''; ?>;"
                                                                          class="offer-status"><?= $promo->getIcon() ? '' : $promo->title; ?></span>
                                                                <?php endforeach; ?>
                                                            <?php endif; ?>
                                                            <?php if ($model->brand): ?>
                                                                <?php if ($model->brand->getLogo()): ?>
                                                                    <span class="logo">
                                                                    <img src="<?= $model->brand->getLogoUrl(); ?>"
                                                                         alt="<?= Html::encode($model->brand->title); ?>"/>
                                                                </span>
                                                                <?php else: ?>
                                                                    <span class="logo"><?= $model->brand->title; ?></span>
                                                                <?php endif; ?>
                                                            <?php endif; ?>
                                                        </div>

                                                        <div class="text">
                                                            <p class="text-top fira"><?= $model->title; ?></p>
                                                            <p class="text-bottom"><?= $model->description; ?></p>
                                                        </div>
                                                    </div>
                                                </a>
                                            </div>
                                        <?php endforeach; ?>

                                        <div class="offer-list__item blue offer-list__item-info col-lg-3 col-md-4 col-xs-12">
                                            <a href="<?= Url::to(['/product/promo/index', 'promoId' => 6]); ?>">
                                                <span class="border"></span>
                                                <div class="inner">
                                                    <div class="text">
                                                        <div class="text-top fira">
                                                            Больше отличных товаров для вас и
                                                            ваших покупателей
                                                        </div>
                                                        <span class="btn btn-info">Перейти в каталог</span>
                                                    </div>
                                                </div>
                                            </a>
                                        </div>

                                    </div>
                                </div>

                            <?php endforeach; ?>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </section>
</div>
<?php endif; ?>
