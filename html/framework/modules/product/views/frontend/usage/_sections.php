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
/** @var $sections array */
/** @var $model \app\modules\product\models\ProductUsage */

?>
<?php if ($sections): ?>
    <div class="brand-category">
        <ul class="list">
            <?php foreach ($sections as $id => $title):
                $counter++;
                ?>
                <li class="item">
                    <a href="<?= Url::to([
                        '/product/usage/section',
                        'usageId' => $model->id,
                        'partitionId' => $id,
                    ]); ?>">
                        <?= $title; ?>
                    </a>
                </li>
            <?php endforeach; ?>
            <li>
                <a href="<?= Url::to([
                    '/product/usage/items',
                    'usageId' => $model->id,
                ]); ?>">Все товары</a>
            </li>
        </ul>
    </div>
<?php endif; ?>