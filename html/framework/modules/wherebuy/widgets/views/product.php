<?php

use yii\helpers\Html;

/** @var $this yii\web\View */
/** @var $list \app\modules\wherebuy\models\Wherebuy[] */
?>
<?php if ($list): ?>
    <ul class="store-list">
        <?php foreach ($list as $model): ?>
            <li>
                <a class="store-list__box" href="<?= $model->link ?>" target="_blank">
                <span class="logo">
                    <img src="<?= ($model->getImage()) ? $model->getImage() : '/static/asd/img/buy-logo.png' ?>"
                         alt="<?= Html::encode($model->title); ?>"/>
                </span>
                    <span class="name"><?= $model->title ?></span>
                    <span class="arrow"><i class="icon-arrow"></i></span>
                </a>
            </li>
        <?php endforeach; ?>
    </ul>
<?php endif; ?>