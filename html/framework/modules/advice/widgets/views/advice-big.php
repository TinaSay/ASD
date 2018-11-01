<?php

use app\modules\advice\models\Advice;
use yii\helpers\Url;
use app\modules\rating\models\Rating;
/** @var $this \yii\web\View */
/* @var $advice Advice */
/* @var $className string */
?>

<!-- section-product -->
<section class="<?= $className ?>">
    <div class="container">
        <div class="section-disk__wrap">
            <div class="section-disk__text">
                <a href="<?= Url::to(['/advice/advice/view/', 'id' => $advice->id]) ?>">
                    <div class="top-text">
                        <!--<a href="<?= Url::to(['/advice/advice/view/', 'id' => $advice->id]) ?>" class="bottom-text"><?= $advice->getGroups3PlusString() ?></a>-->
                        <p class="h3 title"><?= strip_tags($advice->title) ?>
                            <!--<span class="news-position new" style="background-color:#ddeeff"><?= Rating::getAvgRating($advice::className(), $advice->id); ?>/10</span>--></p>
                        <p><?= strip_tags($advice->text) ?></p>

                    </div>
                    <span class="btn bottom-text">Подробнее</span>
                </a>
            </div>
            <div class="section-disk__img">
                <div class="img" style="background-image: url(<?= ($advice->getBigWidgetImage() != '' ? $advice->getBigWidgetImage() : '/static/asd/img/fish/11.jpg') ?>);">
                </div>
            </div>
        </div>
    </div>
</section>
