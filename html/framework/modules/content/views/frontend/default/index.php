<?php
/**
 * Copyright (c) Rustam
 */

use app\modules\banner\models\Banner;
use app\modules\banner\widget\banner\BannerWidget;
use app\modules\brand\widget\brand\BrandWidget;
use app\modules\feedback\widget\feedback\FeedbackWidget;
use app\modules\news\widgets\NewsOnIndexWidget;
use app\modules\product\widgets\ProductMainWidget;
use app\modules\promoBlock\widget\promo\PromoWidget;
use app\modules\record\widget\record\RecordWidget;

/* @var $this yii\web\View */
/* @var $dto \app\modules\content\dto\frontend\ContentDto */

$this->title = $dto->getTitle();
$this->params['hideBreadcrumbs'] = true;

$this->params['bodyCssClass'] = 'main-page';

?>
<?= PromoWidget::widget(['type' => 'slider']) ?>
<?= BrandWidget::widget(['type' => 'homeWidget']) ?>

<?= ProductMainWidget::widget(); ?>

<?= FeedbackWidget::widget(['view' => 'mini']) ?>

<?= NewsOnIndexWidget::widget() ?>

<?= RecordWidget::widget(['type' => 'history']) ?>

<?= BannerWidget::widget([
    'template' => 'main',
    'bannerLimit' => Banner::BANNER_LIMIT_ON_MAIN,
    'pageType' => Banner::PUBLICATION_PLACE_MAIN_PAGE,
]) ?>
