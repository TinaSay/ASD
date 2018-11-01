<?php
/**
 * Created by PhpStorm.
 * User: elfuvo
 * Date: 13.02.18
 * Time: 16:19
 */

use yii\helpers\Html;
use yii\helpers\Url;

/** @var $this yii\web\View */
/** @var $model \app\modules\product\models\Product */
/** @var $set \app\modules\product\models\ProductSet|null */

$this->params['title'] = $model->title;
$this->params['hideFilter'] = true;

if (!$this->title) {
    $this->title = $this->params['title'];
}
if (Yii::$app->request->get('brandId') &&
    !Yii::$app->request->get('sectionId') &&
    !Yii::$app->request->get('promoId')) {
    $this->params['breadcrumbs'][] = [
        'url' => Url::to(['/product/brand/items', 'brandId' => $model->brandId]),
        'label' => 'Все товары',
    ];
}

$this->params['feedbackWidgetCssClass'] = 'section-request cbp-so-section cbp-so-animate';

?>
<section class="section catalogue-card pd-bottom-50">
    <div class="container">
        <div class="row">
            <div class="col-xs-12">
                <div class="catalogue-card__wrap-block">
                    <div class="catalogue-card-left">
                        <?php if ($model->getDocuments() || $model->getImages() || $model->videos): ?>
                            <div class="catalogue-card__photo catalogue-card__photo--desctop white-block white-block--wide mr-bottom-20">
                                <?php if ($model->getImages() || $model->videos): ?>
                                    <div class="slick-slider slider-catalogue-big">
                                        <?php if ($model->getImages()): ?>
                                            <?php foreach ($model->getImages() as $image): ?>
                                                <div class="item">
                                                    <a data-fancybox="gallery"
                                                       title="<?= Html::encode($image->getHint() ?: $model->title); ?>"
                                                       href="<?= $model->getPreviewUrl($image); ?>">
                                                <span class="img"
                                                      style="background-image: url('<?= $model->getImageUrl($image); ?>')"></span>
                                                    </a>
                                                </div>
                                            <?php endforeach; ?>
                                        <?php endif; ?>
                                        <?php if ($model->videos): ?>
                                            <?php foreach ($model->videos as $url): ?>
                                                <div class="item video">
                                                    <a data-fancybox="" href="<?= $url . '?controls=1&rel=0'; ?>"
                                                       class="img">
                                                        <span class="img"
                                                              style="background-image: url('<?= $model->getVideoPreviewUrl($url,
                                                                  'sddefault'); ?>')"></span>
                                                    </a>
                                                </div>
                                            <?php endforeach; ?>
                                        <?php endif; ?>
                                    </div>
                                    <?php if (count($model->getImages()) + count($model->videos) > 1): ?>
                                        <div class="slider-catalogue-nav__wrap">
                                            <div class="slick-slider slider-catalogue-nav">
                                                <?php foreach ($model->getImages() as $image): ?>
                                                    <div class="item">
                                                <span class="img"
                                                      style="background-image: url('<?= $model->getPreviewUrl($image,
                                                          'small'); ?>')"></span>
                                                    </div>
                                                <?php endforeach; ?>
                                                <?php foreach ($model->videos as $url): ?>
                                                    <div class="item video">
                                                        <a data-fancybox="" href="<?= $url . '?controls=1&rel=0'; ?>"
                                                           class="img"
                                                           style="background-image: url('<?= $model->getVideoPreviewUrl($url); ?>')"></a>
                                                    </div>
                                                <?php endforeach; ?>
                                            </div>
                                            <span class="slider-catalogue-nav__next"><i class="icon-arrow"></i></span>
                                            <span class="slider-catalogue-nav__prev"><i class="icon-arrow"></i></span>
                                        </div>
                                    <?php endif; ?>
                                <?php endif; ?>
                                <?php if ($model->getDocuments()): ?>
                                    <ul class="doc-list">
                                        <?php foreach ($model->getDocuments() as $document): ?>
                                            <li>
                                                <a target="_blank" href="<?= $model->getDocumentUrl($document); ?>">
                                                    <p><?= $document->getHint() ?: $model->title; ?>
                                                        <span>.<?= pathinfo($document->getSrc(),
                                                                PATHINFO_EXTENSION) ?></span></p>
                                                    <i class="icon-unload"></i>
                                                </a>
                                            </li>
                                        <?php endforeach; ?>
                                    </ul>
                                <?php endif; ?>
                            </div>
                        <?php endif; ?>
                        <div class="catalogue-form-desctop">
                            <?= \app\modules\feedback\widget\feedback\FeedbackWidget::widget([
                                'view' => 'order-form',
                                'productId' => $model->id,
                            ]); ?>
                        </div>
                    </div>
                    <div class="catalogue-card__text">
                        <div class="text-box">

                            <div class="article-brand">
                                <p>Артикул <?= $model->article; ?></p>
                                <?php if ($model->brand): ?>
                                    <?php if ($model->brand->getLogo()): ?>
                                        <a href="<?= Url::to(['/product/brand/view', 'brandId' => $model->brandId]) ?>"
                                           class="logo">
                                            <img width="165" alt="<?= $model->brand->title; ?>"
                                                 src="<?= $model->brand->getLogoUrl(); ?>"/>
                                        </a>
                                    <?php endif; ?>
                                <?php endif; ?>
                            </div>

                            <?php if ($model->getDocuments() || $model->getImages() || $model->videos): ?>
                                <div class="catalogue-card__photo catalogue-card__photo--mobile catalogue-card__photo--desctop white-block white-block--wide mr-bottom-20">
                                    <?php if ($model->getImages() || $model->videos): ?>
                                        <div class="slick-slider slider-catalogue-big">
                                            <?php if ($model->getImages()): ?>
                                                <?php foreach ($model->getImages() as $image): ?>
                                                    <div class="item">
                                                        <a data-fancybox="gallery"
                                                           title="<?= Html::encode($image->getHint() ?: $model->title); ?>"
                                                           href="<?= $model->getPreviewUrl($image); ?>">
                                                    <span class="img"
                                                          style="background-image: url('<?= $model->getImageUrl($image); ?>')"></span>
                                                        </a>
                                                    </div>
                                                <?php endforeach; ?>
                                            <?php endif; ?>
                                            <?php if ($model->videos): ?>
                                                <?php foreach ($model->videos as $url): ?>
                                                    <div class="item video">
                                                        <a data-fancybox="" href="<?= $url . '?controls=1&rel=0'; ?>"
                                                           class="img">
                                                            <span class="img"
                                                                  style="background-image: url('<?= $model->getVideoPreviewUrl($url,
                                                                      'sddefault'); ?>')"></span>
                                                        </a>
                                                    </div>
                                                <?php endforeach; ?>
                                            <?php endif; ?>
                                        </div>
                                        <?php if (count($model->getImages()) + count($model->videos) > 1): ?>
                                            <div class="slider-catalogue-nav__wrap">
                                                <div class="slick-slider slider-catalogue-nav">
                                                    <?php foreach ($model->getImages() as $image): ?>
                                                        <div class="item">
                                                    <span class="img"
                                                          style="background-image: url('<?= $model->getPreviewUrl($image,
                                                              'small'); ?>')"></span>
                                                        </div>
                                                    <?php endforeach; ?>
                                                    <?php foreach ($model->videos as $url): ?>
                                                        <div class="item video">
                                                            <a data-fancybox=""
                                                               href="<?= $url . '?controls=1&rel=0'; ?>"
                                                               class="img"
                                                               style="background-image: url('<?= $model->getVideoPreviewUrl($url); ?>')"></a>
                                                        </div>
                                                    <?php endforeach; ?>
                                                </div>
                                                <span class="slider-catalogue-nav__next"><i
                                                            class="icon-arrow"></i></span>
                                                <span class="slider-catalogue-nav__prev"><i
                                                            class="icon-arrow"></i></span>
                                            </div>
                                        <?php endif; ?>
                                    <?php endif; ?>
                                    <?php if ($model->getDocuments()): ?>
                                        <ul class="doc-list">
                                            <?php foreach ($model->getDocuments() as $document): ?>
                                                <li>
                                                    <a target="_blank" href="<?= $model->getDocumentUrl($document); ?>">
                                                        <p><?= $document->getHint() ?: $model->title; ?>
                                                            <span>.<?= pathinfo($document->getSrc(),
                                                                    PATHINFO_EXTENSION) ?></span></p>
                                                        <i class="icon-unload"></i>
                                                    </a>
                                                </li>
                                            <?php endforeach; ?>
                                        </ul>
                                    <?php endif; ?>
                                </div>
                            <?php endif; ?>


                            <p><?= $model->text; ?></p>
                        </div>
                        <?php if ($model->usages): ?>
                            <div class="text-box">
                                <h5>Где использовать?</h5>
                                <ul class="list-pluses">
                                    <?php foreach ($model->usages as $usage): ?>
                                        <li>
                                            <a href="<?= Url::to([
                                                '/product/usage/view',
                                                'usageId' => $usage->id,
                                            ]); ?>">
                                                <?php if ($usage->getIcon()): ?>
                                                    <span class="icon"><img src="<?= $usage->getIconUrl(); ?>"/>
                                                    </span><?php endif; ?>
                                                <?= $usage->getTitle(); ?>
                                            </a>
                                        </li>
                                    <?php endforeach; ?>
                                </ul>
                            </div>
                        <?php endif; ?>
                        <?php if ($model->advantages): ?>
                            <div class="text-box">
                                <h5>Оцените преимущества</h5>
                                <ul class="list">
                                    <?php foreach ($model->advantages as $advantage): ?>
                                        <li><?= $advantage; ?></li>
                                    <?php endforeach; ?>
                                </ul>
                            </div>
                        <?php endif; ?>
                        <?php if ($model->getPropertyValues() || $model->additionalParams): ?>
                            <div class="text-box">
                                <h5>Параметры товара</h5>
                                <ul class="list list-small-mr">
                                    <?php if ($model->getPropertyValues()) {
                                        foreach ($model->getPropertyValues() as $propertyDto): ?>
                                            <li>
                                                <?= $propertyDto->getTitle() ?>:
                                                <?= $propertyDto->getValue(); ?><?= $propertyDto->getUnit() ?
                                                    ' ' . $propertyDto->getUnit() : ''; ?>
                                            </li>
                                        <?php endforeach;
                                    } ?>
                                    <?php if ($model->additionalParams): ?>
                                        <?php foreach ($model->additionalParams as $param): ?>
                                            <li><?= $param['title'] ?>: <?= $param['value']; ?></li>
                                        <?php endforeach; ?>
                                    <?php endif; ?>
                                </ul>
                            </div>
                        <?php endif ?>
                    </div>
                </div>
            </div>
        </div>
    </div>
</section>

<!-- section-recommendation -->
<section class="section section-recommendation cbp-so-section pd-top-0">
    <div class="cbp-so-side-top cbp-so-side">
        <?= \app\modules\product\widgets\RelatedProductsWidget::widget([
            'model' => $model,
        ]); ?>
        <div class="container">
            <div class="row">
                <div class="col-xs-12">
                    <div class="btn-back-and-net">
                        <div class="btn-back-and-net__left">
                            <?= \app\widgets\back\BackBtnWidget::widget([
                                'defaultUrl' => Url::to([
                                    '/product/brand/items',
                                    'section' => 'top',
                                    'brandId' => $model->brandId,
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
<!-- /section-recommendation -->


