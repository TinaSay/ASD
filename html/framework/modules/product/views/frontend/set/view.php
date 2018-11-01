<?php
/**
 * Created by PhpStorm.
 * User: elfuvo
 * Date: 14.02.18
 * Time: 15:15
 */

use yii\helpers\Html;
use yii\helpers\Url;

/** @var $model \app\modules\product\models\ProductSet */
/** @var $list \app\modules\product\models\Product[] */

$this->params['title'] = $this->title = $model->title;

?>

    <div data-sticky_parent class="block-aside-left-fix">
        <!-- section-promo -->
        <section class="section-promo">
            <div class="container">
                <div class="row">
                    <div class="col-xs-12">
                        <h1 class="h2 section-title"><?= $this->title; ?></h1>
                        <?= $this->render('_menu', ['model' => $model]) ?>
                    </div>
                </div>
        </section>

        <section class="section catalogue-card catalogue-card--no-order pd-bottom-50 mr-top-60">
            <div id="set-description" class="container tab-pane fade in active">
                <div class="row">
                    <div class="col-xs-12">
                        <div class="catalogue-card__wrap-block">
                            <?php if ($model->getImages() || $model->videos): ?>
                                <div class="catalogue-card__photo white-block white-block--wide mr-bottom-20">
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
                            <div class="catalogue-card__text">
                                <div class="text-box">
                                    <?php if ($model->article): ?>
                                        <div class="article-brand article-set">
                                            <p>Артикул: <?= $model->article; ?></p>
                                        </div>
                                    <?php endif; ?>
                                    <?= $model->description; ?>
                                </div>
                                <div class="catalogue-card__btn">
                                    <a data-toggle="tab" href="#set-order" class="btn btn-primary">Заказать</a>
                                    <a data-toggle="tab" href="#set-products" class="btn btn-info">Товары в наборе</a>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
            <div id="set-products" class="container tab-pane fade"
                 data-url="<?= Url::to(['/product/set/items', 'setId' => $model->id]) ?>">
                <?= $this->render('items', ['model' => $model, 'list' => $list]); ?>
            </div>
            <div id="set-order" class="container tab-pane fade"
                 data-url="<?= Url::to(['/product/set/order', 'setId' => $model->id]) ?>">
                <?= $this->render('order', ['model' => $model]); ?>
            </div>
            <div class="container">
                <div class="row">
                    <div class="col-xs-12">
                        <div class="btn-back-and-net">
                            <div class="btn-back-and-net__left">
                                <?= \app\widgets\back\BackBtnWidget::widget([
                                    'defaultUrl' => Url::to([
                                        '/product/set/index',
                                        'section' => 'left',
                                    ]),
                                ]); ?>
                            </div>
                            <?= $this->render('//layouts/partitials/bottom-share.php'); ?>
                        </div>
                    </div>
                </div>
            </div>
        </section>


        <?= \app\modules\product\widgets\ProductSetsWidget::widget([
            'exclude' => $model->id,
        ]); ?>

    </div>

<?= \app\modules\feedback\widget\feedback\FeedbackWidget::widget([
    'view' => 'mini',
    'cssClass' => 'section-request cbp-so-section cbp-so-animate',
]);
