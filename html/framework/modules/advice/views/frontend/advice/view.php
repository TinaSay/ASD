<?php


/* @var $this yii\web\View */

/* @var $model app\modules\advice\models\Advice */

/* @var $groups array */

use app\modules\advice\widgets\AdviceSubscribeWidget;
use app\modules\news\models\Subscribe;
use app\modules\rating\models\Rating;
use app\modules\rating\widgets\RatingWidget;
use yii\helpers\Url;

?>

<section class="section">
    <div class="container">
        <div class="row">
            <div class="col-xs-12">
                <h1 class="section-title h2"><?= $model->title ?></h1>
                <div class="section-date">
                    <span><?= Yii::$app->getFormatter()->asDate($model->createdAt, 'long') ?></span>
                    <?php foreach ($groups as $id => $groupTitle) : ?>
                        <span><?= $groupTitle; ?></span>
                    <?php endforeach; ?>
                    <span><?= Rating::getAvgRating($model::className(), $model->id); ?>/10</span>
                </div>
            </div>
            <div class="col-sm-12 col-xs-12">
                <div class="text-block text-gray txt-18">
                    <?= $model->text ?>
                </div>

                <div class="rate-block text-gray txt-18 ">
                    <?= RatingWidget::widget(['module' => $model::className(), 'recordId' => $model->id]) ?>
                </div>

            </div>

        </div>
    </div>
    <div class="container" style="margin-top: 2rem;">
        <div class="row">
            <div class="col-xs-12">
                <div class="btn-back-and-net" style="padding-top: 6rem;">
                    <div class="btn-back-and-net__left">
                        <?= \app\widgets\back\BackBtnWidget::widget([
                            'defaultUrl' => Url::to([
                                '/advice/advice/index',
                                'section' => 'top',
                            ]),
                        ]); ?>
                    </div>
                    <?= $this->render('//layouts/partitials/bottom-share.php'); ?>
                </div>
            </div>
        </div>
    </div>
</section>

<?= AdviceSubscribeWidget::widget(['subscribeType' => Subscribe::TYPE_SUBSCRIBE_ADVICECARD]); ?>

