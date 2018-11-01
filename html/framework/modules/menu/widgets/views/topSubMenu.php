<?php
/**
 * Created by PhpStorm.
 * User: elfuvo
 * Date: 27.12.17
 * Time: 16:02
 */

/** @var $this yii\web\View */

/** @var $tree [] */

use yii\helpers\Html;
use yii\helpers\Url;

if (!empty($tree)) : ?>
    <?php foreach ($tree as $level1): ?>
        <?php if (isset($level1['selected']) && $level1['selected'] && isset($level1['children'])): ?>
            <div class="tabs-nav-wrap tabs-nav-wrap--border-cover hit-nav desktop-hit-nav">
                <ul class="nav nav-tabs" id="navbar-hit">
                    <?php foreach ($level1['children'] as $model):
                        if ($model['url']):?>
                            <li class="custom-tab-item<?php if (isset($model['selected']) && $model['selected'] == true): ?> active<?php endif; ?>">
                                <a href="<?= Url::to(['/' . $model['url']]); ?>"><?= Html::encode($model['title']) ?></a>
                            </li>
                        <?php endif; ?>
                    <?php endforeach; ?>
                    <li class="tabs-container dropdown">
                        <div class="tabs-container__btn dropdown-toggle" data-toggle="dropdown" aria-haspopup="true"
                             aria-expanded="false"></div>
                        <div class="tabs-container__content dropdown-menu"></div>
                    </li>
                </ul>
            </div>
            <div data-sticky_aside class="mobile-hit-nav hit-nav row">
                <ul>
                    <?php foreach ($level1['children'] as $model):
                        if ($model['url']):?>
                            <li class="custom-tab-item<?php if (isset($model['selected']) && $model['selected'] == true): ?> active<?php endif; ?>">
                                <a href="<?= Url::to(['/' . $model['url']]); ?>"><?= Html::encode($model['title']) ?></a>
                            </li>
                        <?php endif; ?>
                    <?php endforeach; ?>
                </ul>
            </div>
        <?php endif; ?>
    <?php endforeach; ?>
<?php endif; ?>
