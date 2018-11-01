<?php
/**
 * Created by PhpStorm.
 * User: elfuvo
 * Date: 12.07.18
 * Time: 10:44
 */

/** @var $this yii\web\View */
/** @var $attributes array */
?>
<?php if ($attributes): ?>
    <div class="row">
        <div class="col-md-12 col-xs-12">
            <?php foreach ($attributes as $attribute => $label): ?>
                <button class="tag attribute" data-attribute="<?= $attribute ?>"><?= $label; ?></button>
            <?php endforeach; ?>
        </div>
    </div>
<?php endif; ?>
