<?php

use app\modules\banner\models\Banner;
use app\modules\banner\widget\banner\BannerWidget;
use app\modules\wherebuy\widgets\WhereBuyListWidget;

/* @var $this yii\web\View */
$this->title = 'Где купить';

?>

<!-- section-promo -->
<section class="section-promo">
    <div class="container">
        <div class="row">
            <div class="col-xs-12">
                <h1 class="section-title h2">Купить онлайн</h1>
            </div>
        </div>
    </div>
</section>

<?= BannerWidget::widget([
    'template' => 'wherebuy',
    'pageType' => Banner::PUBLICATION_PLACE_WHEREBUY,
    'bannerLimit' => Banner::BANNER_LIMIT_ON_WHEREBUY,
]) ?>

<!-- section-records -->
<?= WhereBuyListWidget::widget() ?>

      