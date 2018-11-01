<?php
/**
 * Created by PhpStorm.
 * User: elfuvo
 * Date: 12.02.18
 * Time: 14:06
 */

use yii\helpers\Url;

$subSections = '';
$counter = 0;

/** @var $this yii\web\View */
/** @var $sections \app\modules\product\models\ProductSection[] */
/** @var $model \app\modules\product\models\ProductBrand */

?>
<?php if ($sections): ?>
    <div class="brand-category">
        <ul class="list">
            <?php foreach ($sections as $section):
                if (!$section) {
                    continue;
                }
                $counter++;
                ?>
                <?php if (isset($section['children']) && !empty($section['children'])):
                $subSections .= $this->render('_sub_sections', ['section' => $section]);
                ?>
                <li data-id="<?= $section['id']; ?>"
                    class="item has-sub-list">
                    <span><?= $section['title']; ?></span>
                </li>
            <?php else: ?>
                <li data-id="<?= $section['id']; ?>" class="item">
                    <a href="<?= Url::to([
                        '/product/brand/section',
                        'brandId' => $model->id,
                        'sectionId' => $section['id'],
                    ]); ?>">
                        <?= $section['title']; ?>
                    </a>
                </li>
            <?php endif; ?>
                <?php if (($counter % 4) == 0 || $counter >= count($sections)
                && !empty($subSections)): ?>
                <div class="sub-list">
                    <?= $subSections ?>
                </div>
                <?php
                $subSections = '';
            endif; ?>
            <?php endforeach; ?>
            <li>
                <a href="<?= Url::to([
                    '/product/brand/items',
                    'brandId' => $model->id,
                ]); ?>">Все товары</a>
            </li>
        </ul>
    </div>
<?php endif; ?>