<?php

/* @var $this yii\web\View */

/* @var $topNewslist \app\modules\news\models\News[] */
/* @var $bottomNewslist \app\modules\news\models\News[] */

/* @var $pagination \yii\data\Pagination */

use app\modules\news\models\Subscribe;
use app\modules\news\widgets\NewsPager;
use app\modules\news\widgets\NewsSubscribeWidget;
use app\modules\news\widgets\NewsWidget;

$this->title = 'Компания ASD';

?>
<div data-sticky_parent class="block-aside-left-fix">
<!-- section-promo -->
<section class="section-promo">
    <div class="container">
        <div class="row">
            <div class="col-xs-12">
                <h1 class="section-title h2"><?= $this->title; ?></h1>
                <?= \elfuvo\menu\widgets\MenuWidget::widget([
                    'section' => 'top',
                    'view' => '@app/modules/menu/widgets/views/topSubMenu',
                ]) ?>
            </div>
        </div>
    </div>
</section>

<?= NewsWidget::widget([
    'newslist' => $topNewslist,
    'className' => 'section section__over-form section-news cbp-so-section section--list-i',
]); ?>


<?= NewsSubscribeWidget::widget(['subscribeType' => Subscribe::TYPE_SUBSCRIBE_NEWSLIST]); ?>

<?= NewsWidget::widget([
    'newslist' => $bottomNewslist,
    'className' => 'section section__under-form section-news cbp-so-section',
]); ?>

</div>

<?= NewsPager::widget([
    'pagination' => $pagination,
]); ?>



