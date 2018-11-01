<?php


/* @var $this yii\web\View */

/* @var $model app\modules\news\models\News */

use app\modules\news\models\Subscribe;
use app\modules\news\widgets\NewsSubscribeWidget;
use yii\helpers\Url;

/** @var \app\modules\news\models\News $model */
$this->params['breadcrumbs'][] = ['label' => 'Новости', 'url' => Url::to(['/about/news'])];
?>

<section class="section">
    <div class="container">
        <div class="row">
            <div class="col-xs-12">
                <h1 class="section-title h2"><?= $model->title ?></h1>
                <div class="section-date"><span><?= Yii::$app->getFormatter()->asDate($model->date, 'long'); ?></span>&nbsp;<span><?= $model->groupRelation->title; ?></span>
                </div>

            </div>
            <div class="col-sm-12 col-xs-12">
                <div class="text-block text-gray txt-18">
                    <?= $model->text ?>
                </div>
            </div>

        </div>
    </div>
    <div class="container">
        <div class="row">
            <div class="col-xs-12">
                <div class="btn-back-and-net">
                    <div class="btn-back-and-net__left">
                        <?= \app\widgets\back\BackBtnWidget::widget([
                            'defaultUrl' => Url::to(['/news/news/index']),
                        ]); ?>
                    </div>
                    <?= $this->render('//layouts/partitials/bottom-share.php'); ?>
                </div>
            </div>
        </div>
    </div>
</section>

<?= NewsSubscribeWidget::widget(['subscribeType' => Subscribe::TYPE_SUBSCRIBE_NEWSCARD]); ?>

