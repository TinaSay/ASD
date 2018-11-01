<?php
/**
 * Created by PhpStorm.
 * User: elfuvo
 * Date: 15.02.18
 * Time: 15:59
 */

use yii\helpers\Url;

/** @var $model \app\modules\product\models\ProductSet */
$action = Yii::$app->controller->action->getUniqueId();
?>
<div class="tabs-nav-wrap tabs-nav-wrap--border-cover hit-nav desktop-hit-nav">
    <ul class="nav nav-tabs" id="navbar-hit">
        <li class="custom-tab-item<?= $action === 'product/set/view' ? ' active' : ''; ?>">
            <a data-toggle="tab" href="#set-description">Описание</a>
        </li>
        <li class="custom-tab-item<?= $action === 'product/set/items' ? ' active' : ''; ?>">
            <a data-toggle="tab" href="#set-products">Товары в
                наборе <span
                        class="amount"><?= count($model->products); ?></span></a>
        </li>
        <li class="custom-tab-item<?= $action === 'product/set/order' ? ' active' : ''; ?>">
            <a data-toggle="tab" href="#set-order">Заказать</a>
        </li>
        <li class="tabs-container dropdown">
            <div class="tabs-container__btn dropdown-toggle" data-toggle="dropdown"
                 aria-haspopup="true" aria-expanded="false"></div>
        </li>
    </ul>
</div>
<div data-sticky_aside class="mobile-hit-nav hit-nav row">
    <ul>
        <li class="custom-tab-item<?= $action === 'product/set/view' ? ' active' : ''; ?>">
            <a data-toggle="tab" href="#set-description">Описание</a>
        </li>
        <li class="custom-tab-item<?= $action === 'product/set/items' ? ' active' : ''; ?>">
            <a data-toggle="tab" href="#set-products">Товары в наборе
                <span class="amount"><?= count($model->products); ?></span>
            </a>
        </li>
        <li class="custom-tab-item<?= $action === 'product/set/order' ? ' active' : ''; ?>">
            <a data-toggle="tab" href="#set-order">Заказать</a>
        </li>
    </ul>
</div>
