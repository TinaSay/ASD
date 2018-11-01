<?php
/**
 * Created by PhpStorm.
 * User: elfuvo
 * Date: 27.12.17
 * Time: 17:51
 */

/** @var $this yii\web\View */

/** @var $tree [] */

use elfuvo\menu\models\Menu;
use yii\helpers\Html;
use yii\helpers\Url;

if (!empty($tree)) : ?>
    <div class="aside__sub-nav-list">
        <?php foreach ($tree as $level1): ?>
            <div id="aside-item-<?= $level1['id']; ?>" class="aside__sub-nav-item">
                <?php if (!empty($level1['icon'])): ?>
                    <i class="bg-sub-nav" style="background-image: url('<?= $level1['icon']; ?>');"></i>
                <?php endif; ?>
                <div class="aside__inner scroll">
                    <h3 class="aside__sub-layer-title"><?= $level1['title']; ?></h3>
                    <?php if (isset($level1['children']) && !empty($level1['children'])): ?>
                        <ul class="line-list aside__sub-nav">
                            <?php foreach ($level1['children'] as $level2): ?>
                                <li<?php if (isset($level2['selected']) && $level2['selected'] = true): ?> class="active"<?php endif; ?>>
                                    <?php if ($level2['type'] == Menu::TYPE_VOID): ?>
                                        <span class="menu-item"><?= Html::encode($level2['title']) ?></span>
                                    <?php elseif ($level2['type'] == Menu::TYPE_LINK): ?>
                                        <a class="menu-item" href="<?= $level2['extUrl']; ?>"
                                           target="_blank"><?= Html::encode($level2['title']) ?> <span
                                                    class="icon-arrow"></span></a>
                                    <?php else: ?>
                                        <a class="menu-item"
                                           href="<?= Url::to(['/' . $level2['url']]); ?>"><?= Html::encode($level2['title']) ?>
                                            <span class="icon-arrow"></span></a>
                                    <?php endif; ?>
                                </li>
                            <?php endforeach; ?>
                        </ul>
                    <?php endif; ?>
                </div>
            </div>
        <?php endforeach; ?>
    </div>
<?php endif; ?>