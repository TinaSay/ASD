<?php
/**
 * Created by PhpStorm.
 * User: elfuvo
 * Date: 27.12.17
 * Time: 16:02
 */

/** @var $this yii\web\View */
/** @var $tree [] */

use elfuvo\menu\models\Menu;
use yii\helpers\Html;
use yii\helpers\Url;

if (!empty($tree)) : ?>
    <ul class="footer-header__nav">
        <?php foreach ($tree as $model): ?>
            <li<?php if (isset($model['selected']) && $model['selected'] == true): ?> class="active"<?php endif; ?>>
                <?php if ($model['type'] == Menu::TYPE_VOID): ?>
                    <span class="menu-item"><?= Html::encode($model['title']) ?></span>
                <?php elseif ($model['type'] == Menu::TYPE_LINK): ?>
                    <a class="menu-item" href="<?= $model['extUrl']; ?>"
                       target="_blank"><?= Html::encode($model['title']) ?></a>
                <?php else: ?>
                    <a class="menu-item"
                       href="<?= Url::to(['/' . $model['url']]); ?>"><?= Html::encode($model['title']) ?></a>
                <?php endif; ?>
            </li>
        <?php endforeach; ?>
    </ul>
<?php endif; ?>
