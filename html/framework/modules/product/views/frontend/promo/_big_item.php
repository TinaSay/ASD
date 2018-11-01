<?php
/**
 * Created by PhpStorm.
 * User: elfuvo
 * Date: 14.02.18
 * Time: 11:40
 */

use yii\helpers\Url;

/** @var $this yii\web\View */
/** @var $product \app\modules\product\models\Product */
/** @var $cssClass string */
/** @var $btnCssClass string */

?>
<section class="section-disk section-disk--goods <?= $cssClass; ?>">
    <div class="container">
        <div class="section-disk__wrap">
            <div class="section-disk__text">
                <a href="<?= Url::to(['/product/catalog/view', 'alias' => $product->alias]) ?>">
                  <div class="top-text">
                      <?php if ($product->brand): ?><p class="art"><?= $product->brand->title; ?></p><?php endif; ?>
                      <p class="h3 title"><?= $product->title; ?></p>
                      <p><?= $product->description; ?></p>
                  </div>
                  <span class="btn bottom-text">Подробнее о товаре</span>
                </a>
            </div>
            <div class="section-disk__img">
                <div class="img<?= $product->getImages() ? '' : ' noimg' ?>"
                     style="background-image: url(<?= $product->getFirstImageUrl('big') ?>);"></div>
            </div>
        </div>
    </div>
</section>