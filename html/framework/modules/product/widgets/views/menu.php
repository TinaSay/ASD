<?php
/**
 * Created by PhpStorm.
 * User: elfuvo
 * Date: 13.02.18
 * Time: 12:48
 */

use yii\helpers\Url;

/** @var $this yii\web\View */
/** @var $hasSelection bool */
/** @var $promos \app\modules\product\models\ProductPromo[] */
/** @var $promoId int */
/** @var $brandId int */
/** @var $usageId int */
/** @var $countProducts int */

$action = Yii::$app->controller->action->getUniqueId();
$controller = Yii::$app->controller->getUniqueId();

?>
<div class="tabs-nav-wrap tabs-nav-wrap--border-cover hit-nav desktop-hit-nav">
    <ul class="nav nav-tabs" id="navbar-hit">
        <?php if ($brandId): ?>
            <li class="custom-tab-item<?= $action == 'product/brand/view' ? ' active' : '' ?>">
                <a href="<?= $action == 'product/brand/view' ? 'javascript:void();' :
                    Url::to(['/product/brand/view', 'brandId' => $brandId]); ?>">
                    О бренде
                </a>
            </li>
        <?php elseif ($usageId): ?>
            <li class="custom-tab-item<?= $action == 'product/usage/view' ? ' active' : '' ?>">
                <a href="<?= $action == 'product/usage/view' ? 'javascript:void();' :
                    Url::to(['/product/usage/view', 'usageId' => $usageId]); ?>">
                    О сфере применения
                </a>
            </li>
        <?php else: ?>
            <li class="custom-tab-item<?= $action === 'product/brand/index' ? ' active' : ''; ?>">
                <a href="<?= Url::to(['/product/brand/index']) ?>">Наши бренды</a>
            </li>
            <li class="custom-tab-item<?= in_array($action,
                ['product/usage/index', 'product/usage/section']) ? ' active' : ''; ?>">
                <a href="<?= Url::to(['/product/usage/index']) ?>">Сферы применения</a>
            </li>
        <?php endif; ?>
        <?php if (!$usageId): ?>
            <?php foreach ($promos as $model):
                $promoUrl = ['/product/promo/index', 'promoId' => $model->id];
                if ($brandId) {
                    $promoUrl['brandId'] = $brandId;
                } ?>
                <li class="custom-tab-item<?= $action === 'product/promo/index' && $model->id == $promoId ? ' active' : ''; ?>">
                    <a href="<?= Url::to($promoUrl) ?>"><?= $model->title; ?></a>
                </li>
            <?php endforeach; ?>
        <?php endif; ?>
        <?php if ($brandId): ?>
            <li class="custom-tab-item<?= in_array($action,
                ['product/brand/items', 'product/brand/section']) ? ' active' : '' ?>">
                <a href="<?= Url::to(['/product/brand/items', 'brandId' => $brandId]); ?>">
                    Все товары <span class="amount"><?= $countProducts; ?></span>
                </a>
            </li>
        <?php elseif ($usageId): ?>
            <li class="custom-tab-item<?= in_array($action, [
                'product/usage/section',
                'product/usage/items'
            ]) ? ' active' : '' ?>">
                <a href="<?= Url::to(['/product/usage/items', 'usageId' => $usageId]); ?>">
                    Все товары <span class="amount"><?= $countProducts; ?></span>
                </a>
            </li>
        <?php else: ?>
            <li class="custom-tab-item<?= $action === 'product/catalog/search' ? ' active' : ''; ?>">
                <a href="<?= Url::to(['/product/catalog/search']); ?>">Ваш подбор
                    <span class="amount"><?= Yii::$app->session->get('catalog.results', 0); ?></span>
                </a>
            </li>
        <?php endif; ?>
        <li class="tabs-container dropdown">
            <div class="tabs-container__btn dropdown-toggle" data-toggle="dropdown" aria-haspopup="true"
                 aria-expanded="false"></div>
            <div class="tabs-container__content dropdown-menu"></div>
        </li>
    </ul>
</div>
<div data-sticky_aside class="mobile-hit-nav hit-nav row">
    <ul>
        <?php if ($brandId): ?>
            <li class="custom-tab-item<?= $action == 'product/brand/view' ? ' active' : '' ?>">
                <a href="<?= $action == 'product/brand/view' ? 'javascript:void();' :
                    Url::to(['/product/brand/view', 'brandId' => $brandId]); ?>">
                    О бренде
                </a>
            </li>
        <?php elseif ($usageId): ?>
            <li class="custom-tab-item<?= $action == 'product/usage/view' ? ' active' : '' ?>">
                <a href="<?= $action == 'product/usage/view' ? 'javascript:void();' :
                    Url::to(['/product/usage/view', 'usageId' => $usageId]); ?>">
                    О сфере применения
                </a>
            </li>
        <?php else: ?>
            <li class="custom-tab-item<?= $action === 'product/brand/index' ? ' active' : ''; ?>">
                <a href="<?= Url::to(['/product/brand/index']) ?>">Наши бренды</a>
            </li>
            <li class="custom-tab-item<?= in_array($action,
                ['product/usage/index', 'product/usage/section']) ? ' active' : ''; ?>">
                <a href="<?= Url::to(['/product/usage/index']) ?>">Сферы применения</a>
            </li>
        <?php endif; ?>
        <?php if (!$usageId): ?>
            <?php foreach ($promos as $model):
                $promoUrl = ['/product/promo/index', 'promoId' => $model->id];
                if ($brandId) {
                    $promoUrl['brandId'] = $brandId;
                } ?>
                <li class="custom-tab-item<?= $action === 'product/promo/index' && $model->id == $promoId ? ' active' : ''; ?>">
                    <a href="<?= Url::to($promoUrl) ?>"><?= $model->title; ?></a>
                </li>
            <?php endforeach; ?>
        <?php endif; ?>
        <?php if ($brandId): ?>
            <li class="custom-tab-item<?= $action == 'product/brand/items' ? ' active' : '' ?>">
                <a href="<?= Url::to(['/product/brand/items', 'brandId' => $brandId]); ?>">
                    Все товары <span class="amount"><?= $countProducts; ?></span>
                </a>
            </li>
        <?php elseif ($usageId): ?>
            <li class="custom-tab-item<?= in_array($action, [
                'product/usage/section',
                'product/usage/items',
            ]) ? ' active' : '' ?>">
                <a href="<?= Url::to(['/product/usage/items', 'usageId' => $brandId]); ?>">
                    Все товары <span class="amount"><?= $countProducts; ?></span>
                </a>
            </li>
        <?php else: ?>
            <li class="custom-tab-item<?= $action === 'product/catalog/search' ? ' active' : ''; ?>">
                <a href="<?= Url::to(['/product/catalog/search']); ?>">Ваш подбор<?php if ($hasSelection): ?><span
                            class="amount"><?= Yii::$app->session->get('catalog.results', 0); ?></span><?php endif; ?>
                </a>
            </li>
        <?php endif; ?>
    </ul>
</div>
