<?php


/**
 * Created by PhpStorm.
 * User: nsign
 * Date: 26.06.18
 * Time: 14:34
 */

/** @var $metaData \app\modules\metaRegister\models\MetaData */
/** @var $metaTags \app\modules\metaRegister\interfaces\ConfigurableInterface | \app\modules\metaRegister\ConfigureOpenGraph */
?>
<?php if (!$metaData): ?>

    <?php foreach ($metaTags->metaTags() as $tag => $item) : ?>
        <?= $form->field($metaTags, $tag)->input($item) ?>
    <?php endforeach; ?>

<?php else: ?>

    <?php foreach ($metaData as $index => $setting) : ?>
        <?= $form->field($setting, "[$setting->id]value")->label($setting->name) ?>
    <?php endforeach; ?>

<?php endif; ?>
