<?php
/**
 * Created by PhpStorm.
 * User: elfuvo
 * Date: 12.02.18
 * Time: 14:06
 */

use yii\helpers\Html;

$subSections = '';
$counter = 0;

/** @var $this yii\web\View */
/** @var $sections array */
/** @var $searchModel \app\modules\product\models\search\ProductCatalogSearch */

?>
<?php if ($sections): ?>
    <div class="brand-category">
        <ul class="list">
            <?php foreach ($sections as $section):
                $counter++;
                ?>
                <?php if (isset($section['children'])):
                $subSections .= $this->render('_sub_sections_checkbox', [
                    'section' => $section,
                    'searchModel' => $searchModel,
                ]);
                ?>
                <li data-id="<?= $section['id']; ?>" class="item has-sub-list">
                  <span>
                    <label class="wrap-check">
                        <?= Html::checkbox($searchModel->formName() . '[sectionId][]', false, [
                            'class' => 'section-item',
                            'value' => $section['id'],
                        ]); ?>
                    </label>
                      <?= $section['title']; ?>
                  </span>
                </li>
            <?php else: ?>
                <li data-id="<?= $section['id']; ?>" class="item">
                  <span>
                    <label class="wrap-check">
                        <?= Html::checkbox($searchModel->formName() . '[sectionId][]', false, [
                            'class' => 'section-item',
                            'value' => $section['id'],
                        ]); ?>
                        <span class="placeholder"><?= $section['title']; ?></span>
                    </label>
                  </span>
                </li>
            <?php endif; ?>
                <?php if (($counter % 4 == 0) || $counter >= count($sections)
                && !empty($subSections)): ?>
                <div class="sub-list">
                    <?= $subSections ?>
                </div>
                <?php
                $subSections = '';
            endif; ?>
            <?php endforeach; ?>
        </ul>
    </div>
<?php endif; ?>