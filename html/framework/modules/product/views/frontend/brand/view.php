<?php
/**
 * Created by PhpStorm.
 * User: elfuvo
 * Date: 12.02.18
 * Time: 12:24
 */

use yii\helpers\Html;
use yii\helpers\Url;

/** @var $this yii\web\View */
/** @var $model \app\modules\product\models\ProductBrand */
/** @var $sections array */
/** @var $blocks \app\modules\product\models\ProductBrandBlock[] */

$this->params['title'] = $model->getTitle();
if (!$this->title) {
    $this->title = $this->params['title'];
}
$this->params['hideFeedbackForm'] = true;
$this->params['hideSets'] = true;
$this->params['brandId'] = $model->id;
$this->params['showMenu'] = true;
?>
<!-- о бренде -->
<section class="section card-brand cbp-so-section pd-top-50">
    <div class="cbp-so-side-top cbp-so-side">
        <div class="container">
            <div class="row">
                <div class="col-xs-12">
                    <!-- описание -->

                    <div class="section-brand__box section-brand__box--brand">
                        <span class="aside-shadow"></span>
                        <div class="brand-slide">
                            <div class="brand-slide__item active">
                                <div class="section-brand__box-inner">
                                    <div class="brand-slide__goods">
                                        <?php if ($model->getIllustration()): ?>
                                            <?= Html::img($model->getIllustrationUrl(), ['alt' => $model->title]); ?>
                                        <?php endif; ?>
                                    </div>
                                    <div class="brand-slide__text">
                                        <?php if ($model->getLogo()): ?>
                                            <img class="logo" src="<?= $model->getLogoUrl() ?>"
                                                 alt="<?= Html::encode($model->title) ?>"/>
                                        <?php endif; ?>
                                        <h5 class="title fira"><?= $model->description ?: $model->title; ?></h5>
                                        <div class="description text-block"><?= $model->text; ?></div>
                                        <?php if ($model->getPresentation()): ?>
                                            <a class="btn-unload" target="_blank"
                                               href="<?= $model->getPresentationUrl(); ?>">
                                                <i class="icon-unload"></i>Скачать презентацию
                                            </a>
                                        <?php endif; ?>
                                    </div>
                                </div>
                            </div>
                        </div>
                    </div>

                    <!-- категории -->
                    <?php if ($model->sections): ?>
                        <div class="white-block white-block--yellow card-brand__category white-block--wide">
                            <div class="head">
                                <h5 class="pd-bottom-0">Каталог бренда <?= $model->title; ?></h5>
                            </div>
                            <?= $this->render('_sections',
                                [
                                    'sections' => $sections,
                                    'model' => $model
                                ]
                            ); ?>
                        </div>
                    <?php endif; ?>
                </div>
                <?php if ($blocks): ?>
                    <div class="col-xs-12">
                        <div class="banners-list">
                            <?php foreach ($blocks as $block): ?>
                                <div class="banners-box__wrap">
                                    <div class="banners-box">
                                        <div class="banners-box__name"><?= $block->title; ?></div>
                                        <?php if ($block->value): ?>
                                            <div class="banners-box__amount">
                                                <span class="big"><?= $block->value; ?></span>
                                                <?php if ($block->description): ?><span
                                                        class="small"><?= $block->description; ?></span><?php endif; ?>
                                            </div>
                                        <?php endif; ?>
                                    </div>
                                </div>
                            <?php endforeach; ?>
                        </div>
                    </div>
                <?php endif; ?>
            </div>
        </div>

        <div class="container">
            <div class="row">
                <div class="col-xs-12">
                    <div class="btn-back-and-net">
                        <div class="btn-back-and-net__left">
                            <?= \app\widgets\back\BackBtnWidget::widget([
                                'defaultUrl' => Url::to([
                                    '/product/brand/index',
                                    'section' => 'top',
                                ]),
                            ]); ?>
                        </div>
                        <?= $this->render('//layouts/partitials/bottom-share.php'); ?>
                    </div>
                </div>
            </div>
        </div>
    </div>
</section>


