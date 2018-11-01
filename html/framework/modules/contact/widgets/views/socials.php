<?php
/**
 * Created by PhpStorm.
 * User: elfuvo
 * Date: 01.05.18
 * Time: 12:50
 */

/** @var $this \yii\web\View */
/** @var $list \app\modules\contact\models\Network */
?>
<?php if ($list): ?>
    <div class="footer__net-title">Мы в социальных сетях</div>
    <div class="footer__net">
        <?php foreach ($list as $network) : ?>
            <a class="net-link" href="<?= $network->getUrl() ?>" target="_blank"
               style="background-image: url(<?= $network->getImage() ?>)"></a>
        <?php endforeach; ?>
    </div>
<?php endif; ?>