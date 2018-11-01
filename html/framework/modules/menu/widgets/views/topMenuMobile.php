<?php
/**
 * Created by PhpStorm.
 * User: elfuvo
 * Date: 27.12.17
 * Time: 16:22
 */

/* @var $this yii\web\View */
/* @var $this yii\web\View */

/* @var $tree [] */

use elfuvo\menu\models\Menu;
use yii\helpers\Html;
use yii\helpers\Url;

if (!empty($tree)) : ?>
    <ul>
        <?php foreach ($tree as $model): ?>
            <li<?php if (isset($model['selected']) && $model['selected'] == true): ?> class="active"<?php endif; ?>>
                <?php if ($model['type'] == Menu::TYPE_VOID): ?>
                    <span class="menu-item">
                            <i class="aside-item__icon" <?php if (!empty($model['icon'])): ?> style="background-image: url('<?= $model['icon']; ?>');"<?php endif; ?>></i>
                            <?= Html::encode($model['title']) ?>
                    </span>
                <?php elseif ($model['type'] == Menu::TYPE_LINK): ?>
                    <a
                            class="menu-item" href="<?= $model['extUrl']; ?>"
                            target="_blank">
                        <i class="aside-item__icon" <?php if (!empty($model['icon'])): ?> style="background-image: url('<?= $model['icon']; ?>');"<?php endif; ?>></i>
                        <?= Html::encode($model['title']) ?>
                    </a>
                <?php else: ?>
                    <a
                            class="menu-item"
                            href="<?= Url::to(['/' . $model['url']]); ?>">
                        <i <?php if (!empty($model['icon'])): ?> style="background-image: url('<?= $model['icon']; ?>');"<?php endif; ?> class="aside-item__icon"></i>
                        <?= Html::encode($model['title']) ?>
                    </a>
                <?php endif; ?>
            </li>
        <?php endforeach; ?>
    </ul>
<?php endif; ?>