<?php
/**
 * Created by PhpStorm.
 * User: elfuvo
 * Date: 12.02.18
 * Time: 12:10
 */

use yii\helpers\Url;

/** @var $this yii\web\View */
/** @var $section array */
?>
<?php if (isset($section['children'])): ?>
    <ul data-id="<?= $section['id']; ?>">
        <?php foreach ($section['children'] as $child): ?>
            <li>
                <a href="<?= Url::to([
                    '/product/brand/section',
                    'brandId' => $section['brandId'],
                    'sectionId' => $child['id'],
                ]) ?>">
                    <?= $child['title']; ?>
                </a>
            </li>
        <?php endforeach; ?>
    </ul>
<?php endif; ?>