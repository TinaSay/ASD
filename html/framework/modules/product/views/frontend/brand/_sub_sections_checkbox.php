<?php
/**
 * Created by PhpStorm.
 * User: elfuvo
 * Date: 12.02.18
 * Time: 12:10
 */

use yii\helpers\Html;

/** @var $this yii\web\View */
/** @var $section array */
/** @var $searchModel \app\modules\product\models\search\ProductCatalogSearch */
?>
<?php if (isset($section['children'])): ?>
    <ul data-id="<?= $section['id']; ?>">
        <?php foreach ($section['children'] as $child): ?>
            <li>
                <label class="wrap-check">
                    <?= Html::checkbox($searchModel->formName() . '[sectionId][]', false, [
                        'class' => 'section-item',
                        'value' => $child['id'],
                    ]); ?>
                    <span class="placeholder"><?= $child['title']; ?></span>
                </label>
            </li>
        <?php endforeach; ?>
    </ul>
<?php endif; ?>