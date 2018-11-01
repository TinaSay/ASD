<?php

use app\modules\banner\models\Banner;
use app\modules\banner\widget\banner\BannerWidget;
use app\modules\content\models\Content;
use app\modules\feedback\widget\feedback\FeedbackWidget;
use app\modules\news\widgets\NewsSubscribeWidget;
use app\modules\product\widgets\ProductSetsWidget;
use app\modules\sked\widgets\SkedListWidget;

/* @var $this yii\web\View */
/* @var $dto \app\modules\content\dto\frontend\ContentDto */

$this->title = $dto->getTitle();

?>



<section class="section <?php
if (count($dto->getBannerIds()) <= 0 && count($dto->getSkedIds()) <= 0 && !$dto->getRenderForm() && !$dto->getProductSet()) {
    echo "padded-banner-list-6rem";
} elseif ($dto->getBannerPosition() == Content::BANNER_POSITION_TOP && count($dto->getBannerIds()) > 0) {
    echo "padded-banner-list";
}

?> ">
    <div class="container">
    <div class="row">
    <div class="col-xs-12">
        <h1 class="section-title h2"><?= $this->title ?></h1>
        <div class="section-date"></div>
    </div>

<?php if ($dto->getBannerPosition() == Content::BANNER_POSITION_TOP): ?>
    <?php if ($dto->getBannerIds()): ?>
        </div>
        </div>
        </section>
        <?= BannerWidget::widget([
            'template' => 'content',
            'pageType' => Banner::PUBLICATION_PLACE_CONTENT,
            'bannerLimit' => Banner::BANNER_LIMIT_ON_CONTENT,
            'bannerIds' => $dto->getBannerIds(),
            'bannerColor' => $dto->getBannerColor()
        ]) ?>

        <section class="section">
        <div class="container">
        <div class="row">
    <?php endif; ?>
<?php endif; ?>


    <div class="col-xs-12">
        <div class="text-block text-gray txt-18">
            <?= $dto->getText() ?>
        </div>
    </div>
    </div>
    </div>
    </section>

<?php if ($dto->getBannerPosition() == Content::BANNER_POSITION_AFTER_TEXT): ?>
    <?php if ($dto->getBannerIds()): ?>
        <?= BannerWidget::widget([
            'template' => 'content',
            'pageType' => Banner::PUBLICATION_PLACE_CONTENT,
            'bannerLimit' => Banner::BANNER_LIMIT_ON_CONTENT,
            'bannerIds' => $dto->getBannerIds(),
            'bannerColor' => $dto->getBannerColor()
        ]) ?>
    <?php endif; ?>
<?php endif; ?>


<?php if ($dto->getSkedIds()): ?>
    <?= SkedListWidget::widget([
        'skedIds' => $dto->getSkedIds()
    ]) ?>
<?php endif; ?>


<?php if ($dto->getBannerPosition() == Content::BANNER_POSITION_AFTER_SKED): ?>
    <?php if ($dto->getBannerIds()): ?>
        <div style="margin-top: -10rem">
            <?= BannerWidget::widget([
                'template' => 'content',
                'pageType' => Banner::PUBLICATION_PLACE_CONTENT,
                'bannerLimit' => Banner::BANNER_LIMIT_ON_CONTENT,
                'bannerIds' => $dto->getBannerIds(),
                'bannerColor' => $dto->getBannerColor()
            ]) ?>
        </div>
    <?php endif; ?>
<?php endif; ?>


<?php if ($dto->getProductSet()): ?>
    <?= ProductSetsWidget::widget() ?>
<?php endif ?>


<?php if ($dto->getRenderForm() == Content::RENDER_FORM_SUBSCRIBE): ?>
    <?= NewsSubscribeWidget::widget(); ?>
<?php elseif ($dto->getRenderForm() == Content::RENDER_FORM_FEEDBACK): ?>
    <?= FeedbackWidget::widget(); ?>
<?php endif; ?>