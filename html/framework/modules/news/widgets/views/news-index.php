<?php
/**
 * Copyright (c) Rustam
 */

use app\modules\news\models\News;
use yii\helpers\Url;

/** @var $this \yii\web\View */
/* @var $newslist News[] */
/* @var $className string */
?>
<section class="<?= $className ?> section section-news section-news--main cbp-so-section">
    <div class="cbp-so-side-top cbp-so-side">
        <div class="container">
            <div class="row">
                <div class="col-xs-12">
                    <div class="section-news__list-title">
                        <h2 class="section-title">Последние события</h2>
                        <div class="news-net-link">
                            <div class="news-net-link__title">Будьте в курсе всех событий, подписывайтесь на наши группы</div>
                            <?php /** @var array $networkList */
                            if ($networkList):?>
                            <ul>
                                <?php /** @var \app\modules\contact\models\Network $network */
                                foreach ($networkList as $network) : ?>
                                    <li><a class="net-link" href="<?= $network->getUrl() ?>" target="_blank" style="background-image: url(<?=$network->getImage()?>)"></a></li>
                                <?php endforeach; ?>
                            </ul>
                            <?php endif; ?>
                        </div>
                    </div>
                </div>
            </div>
            <div class="row">
                <div class="news-list clearfix">
                    <div class="slide-mobile">
                        <?php foreach ($newslist as $model) : ?>
                            <div class="news-list__item col-md-4 col-xs-12">
                                <a href="<?= Url::to(['/news/news/view/', 'id' => $model->id]) ?>">
                                    <div class="inner">
                                        <div class="img"
                                             style="background-image: url(<?= ($model->getMainWidgetImage() != '' ? $model->getMainWidgetImage() : '/static/asd/img/fish/11.jpg') ?>);">
                                            <span class="news-position new"
                                                  style="background-color: <?= '#' . $model->groupRelation->color ?>"><?= $model->groupRelation->title ?></span>
                                        </div>
                                        <div class="text">
                                            <p class="text-top text-clip fira"><?= $model->title ?></p>
                                            <p class="text-bottom"><?= Yii::$app->getFormatter()->asDate($model->date,
                                                    'short'); ?></p>
                                        </div>
                                    </div>
                                </a>
                            </div>
                        <?php endforeach; ?>
                    </div>
                </div>
            </div>
        </div>
    </div>
</section>
