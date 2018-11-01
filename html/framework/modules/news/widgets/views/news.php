<?php

use app\modules\news\models\News;
use yii\helpers\Url;

/** @var $this \yii\web\View */
/* @var $newslist News[] */
/* @var $className string */
?>
<section class="<?= $className ?>">
    <div class="cbp-so-side-top cbp-so-side">
        <div class="container">
            <div class="row">
                <div class="news-list flex-list clearfix">
                    <?php foreach ($newslist as $model) : ?>
                        <div class="news-list__item col-md-4 col-xs-12">
                            <a href="<?= Url::to(['/news/news/view/', 'id' => $model->id]) ?>">
                                <div class="inner">
                                    <div class="img" style="background-image: url(<?= ($model->getMainWidgetImage() != '' ? $model->getMainWidgetImage() : '/static/asd/img/fish/11.jpg') ?>);">
                                        <span class="news-position new" style="background-color: <?= '#'.$model->groupRelation->color ?>"><?= $model->groupRelation->title ?></span>
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
</section>
