<?php
/**
 * Created by PhpStorm.
 * User: krok
 * Date: 11.07.18
 * Time: 16:12
 */

/** @var $this \yii\web\View */
/** @var $adapter \krok\meta\adapters\AdapterInterface|\yii\base\Model */
?>
<?php foreach ($adapter::attributeTypes() as $attribute => $item) : ?>

    <?php if (is_array($item)) : ?>
        <?= $form->field($adapter, $attribute)->widget($item['class'], $item['config'] ?? []) ?>
    <?php elseif (is_string($item)) : ?>
        <?= $form->field($adapter, $attribute)->input($item) ?>
    <?php endif; ?>

<?php endforeach; ?>
