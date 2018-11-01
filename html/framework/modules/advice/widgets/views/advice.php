<?php

use app\modules\advice\models\Advice;
use yii\helpers\Url;
use app\modules\rating\models\Rating;

/** @var $this \yii\web\View */
/* @var $adviceList Advice[] */
/* @var $className string */
?>
<!-- section-product -->
<section class="<?= $className ?>">
    <div class="cbp-so-side-top cbp-so-side">
        <div class="container">
            <div class="row">
                <div class="news-list flex-list news-list--item-i news-list--product clearfix">
                    <?php foreach ($adviceList as $model) : ?>
                        <div class="news-list__item col-lg-4 col-md-4 col-xs-12">
                            <a href="<?= Url::to(['/advice/advice/view', 'id' => $model->id]) ?>">
                                <div class="inner">
                                    <div class="img"
                                         style="background-image: url(<?= ($model->getMainWidgetImage() != '' ? $model->getMainWidgetImage() : '/static/asd/img/noimg.png') ?>);">
                                        <span class="news-position rate"
                                              style="background-color: #f5ca3a">
                                              <i class="icon-star"></i>
                                              <?= Rating::getAvgRating($model::className(), $model->id); ?>
                                            /10</span>
                                    </div>
                                    <div class="text">
                                        <div class="text-clip">
                                            <p class="text-top fira"><?= strip_tags($model->title) ?></p>
                                            <p class="text-middle"><?= strip_tags($model->announce) ?></p>
                                        </div>
                                        <p class="text-bottom text-bottom--tag"><?= $model->getGroups1PlusString() ?></p>
                                    </div>
                                </div>
                            </a>
                        </div>
                    <?php endforeach; ?>

                </div>
            </div>
        </div>
    </div>
</section>
