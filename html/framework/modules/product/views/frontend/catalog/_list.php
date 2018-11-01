<?php
/**
 * Created by PhpStorm.
 * User: elfuvo
 * Date: 13.02.18
 * Time: 12:40
 */

use yii\helpers\Html;
use yii\helpers\Url;

/** @var $this yii\web\View */
/** @var $list \app\modules\product\models\Product[] */

?>

<!-- section-goods -->
<section class="section-goods section cbp-so-section pd-bottom-50">
    <div class="cbp-so-side-top cbp-so-side">
        <div class="container">
            <div class="row">
                <?php if ($list): ?>
                    <div class="offer-list flex-list offer-list--many clearfix">
                        <?php foreach ($list as $key => $model): ?>
                            <div class="offer-list__item col-lg-3 col-md-6 col-xs-12">
                                <a href="<?= Url::to(['/product/catalog/view', 'alias' => $model->alias]); ?>">
                                    <div class="inner">
                                        <div class="img<?= $model->getImages() ? '' : ' noimg' ?>"
                                             style="background-image: url(<?= $model->getFirstImageUrl() ?>);">
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
                    </div>
                <?php else: ?>
                    <div class="offer-list pd-bottom-120 offer-list--many offer-list--4 clearfix">
                        <div class="card-brand__main white-block white-block--wide">
                            <div class="text-block">
                                <p>К сожалению, в данном разделе каталога в настоящий момент отсутствую товары.</p>
                                <p>Для уточнения информации свяжитесь с нашими менеджерами.</p>
                            </div>
                        </div>
                    </div>
                <?php endif; ?>
            </div>
        </div>
    </div>
</section>
<!-- /section-goods -->