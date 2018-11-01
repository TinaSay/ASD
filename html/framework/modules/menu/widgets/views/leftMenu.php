<?php
/**
 * Created by PhpStorm.
 * User: elfuvo
 * Date: 27.12.17
 * Time: 18:07
 */

/** @var $this yii\web\View */

/** @var $tree [] */

use elfuvo\menu\models\Menu;
use yii\helpers\Html;
use yii\helpers\Url;

if (!empty($tree)) : ?>
    <ul class="line-list aside__nav">
        <?php foreach ($tree as $model): ?>
            <li<?php if (isset($model['selected']) && $model['selected'] == true): ?> class="active"<?php endif; ?>>
                <?php if ($model['type'] == Menu::TYPE_VOID): ?>
                    <a href="#" <?php if (isset($model['children'])): ?>data-nav="aside-item-<?= $model['id']; ?>"<?php endif; ?>>
                        <?php if (!empty($model['icon'])): ?>
                            <i class="aside-item__icon" style="background-image: url('<?= $model['icon']; ?>');"></i>
                        <?php endif; ?>
                        <?= Html::encode($model['title']) ?>
                        <?php if (isset($model['children'])): ?>
                            <span class="icon-arrow"></span>
                        <?php endif; ?>
                    </a>
                <?php elseif ($model['type'] == Menu::TYPE_LINK): ?>
                    <a href="<?= $model['extUrl']; ?>"
                       target="_blank"><?= Html::encode($model['title']) ?></a>
                <?php else: ?>
                    <a <?php if (isset($model['children'])): ?>data-nav="aside-item-<?= $model['id']; ?>"<?php endif; ?>
                       href="<?= Url::to(['/' . $model['url']]); ?>">
                        <?php if (!empty($model['icon'])): ?>
                            <i class="aside-item__icon" style="background-image: url('<?= $model['icon']; ?>');"></i>
                        <?php endif; ?>
                        <?= Html::encode($model['title']) ?>
                        <?php if (isset($model['children'])): ?>
                            <span class="icon-arrow"></span>
                        <?php endif; ?>
                    </a>
                <?php endif; ?>
            </li>
        <?php endforeach; ?>
    </ul>
<?php endif; ?>
