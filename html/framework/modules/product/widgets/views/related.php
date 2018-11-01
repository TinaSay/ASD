<?php
/**
 * Created by PhpStorm.
 * User: elfuvo
 * Date: 13.02.18
 * Time: 19:14
 */

use yii\helpers\Url;

/** @var $this yii\web\View */
/** @var $list \app\modules\product\models\Product[] */
/** @var $model \app\modules\product\models\Product */

?>
<?php if ($list): ?>
    <div class="container">
        <div class="row">
            <div class="col-xs-12">
                <h2 class="section-title"><?= $model->title; ?></h2>
                <div class="section-title__description">отлично продаётся вместе со следующими товарами:</div>
            </div>
        </div>
        <div class="row">
            <div class="offer-list--many offer-list flex-list offer-list--4 clearfix related-products" data-per-page="4">
                <?php foreach ($list as $key => $item): ?>
                    <div class="offer-list--many offer-list__item col-lg-3 col-md-4 col-xs-12<?= $key > 3 ? ' hidden' : ''; ?>">
                        <a href="<?= Url::to(['/product/catalog/view', 'alias' => $item->alias]) ?>">
                            <div class="inner">
                                <div class="img">
                                    <div class="bg-width img-bg" style="background-image: url('<?= $item->getFirstImageUrl(); ?>');"></div>
                                    <?php if ($item->promos): ?>
                                        <?php foreach ($item->promos as $promo): ?>
                                            <span style="<?= $promo->getIcon() ? 'background-image: url(' . $promo->getIconUrl() . ');' : ''; ?><?= $promo->color ? 'background-color: #' . $promo->color : ''; ?>;"
                                                  class="offer-status"><?= $promo->getIcon() ? '' : $promo->title; ?></span>
                                        <?php endforeach; ?>
                                    <?php endif; ?></div>
                                <div class="text">
                                    <p class="text-top fira"><?= $item->title; ?></p>
                                    <p class="text-bottom"><?= $item->description; ?></p>
                                </div>
                            </div>
                        </a>
                    </div>
                <?php endforeach; ?>
                <?php if (count($list) > 4): ?>
                    <div class="update-link col-xs-12"><a href="#"></a></div>
                <?php endif; ?>
            </div>
        </div>
    </div>
<?php endif; ?>