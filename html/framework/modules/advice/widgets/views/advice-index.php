<?php

use app\modules\advice\models\Advice;
use yii\helpers\Url;

/** @var $this \yii\web\View */
/* @var $advicelist Advice[] */
/* @var $className string */
?>
<section class="<?= $className ?> section section-advice section-advice--main cbp-so-section">
    <div class="cbp-so-side-top cbp-so-side">
        <div class="container">
            <div class="row">
                <div class="col-xs-12">
                    <div class="section-advice__list-title">
                        <h2 class="section-title">Последние события</h2>
                        <div class="advice-net-link">
                            <div class="advice-net-link__title">Будьте в курсе всех событий, подписывайтесь на наши
                                группы
                            </div>
                            <ul>
                                <?php /** @var array $networkList */
                                if ($networkList):?>
                                    <?php /** @var \app\modules\contact\models\Network $network */
                                    foreach ($networkList as $network) : ?>
                                        <li><a class="net-link" href="<?= $network->getUrl() ?>" target="_blank"
                                               style="background-image: url(<?= $network->getImage() ?>)"></a></li>
                                    <?php endforeach; ?>
                                <?php endif; ?>
                            </ul>

                        </div>
                    </div>
                </div>
                <div class="advice-list clearfix">
                    <?php foreach ($advicelist as $model) : ?>
                        <div class="advice-list__item col-sm-4 col-xs-12">
                            <a href="<?= Url::to(['/advice/advice/view/', 'id' => $model->id]) ?>">
                                <div class="inner">
                                    <div class="img"
                                         style="background-image: url(<?= ($model->getMainWidgetImage() != '' ? $model->getMainWidgetImage() : '/static/asd/img/noimg.png') ?>);">
                                        <span
                                                class="advice-position new"><?= strip_tags($model->groupRelation->title) ?></span>
                                    </div>
                                    <div class="text">
                                        <p class="text-top fira"><?= strip_tags($model->title) ?></p>
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
</section>
