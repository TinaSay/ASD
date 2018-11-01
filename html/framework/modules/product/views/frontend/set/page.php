<?php
/**
 * Created by PhpStorm.
 * User: elfuvo
 * Date: 14.02.18
 * Time: 15:41
 */

use yii\helpers\Url;

/** @var $this yii\web\View */
/** @var $usages array */
/** @var $model \app\modules\product\models\ProductPage */

$this->params['title'] = $this->title = $model->title;

?>

<div data-sticky_parent class="block-aside-left-fix">
    <!-- section-promo -->
    <section class="section-promo">
        <div class="container">
            <div class="row">
                <div class="col-xs-12">
                    <div class="section-news__list-title section-news__list-title--top">
                        <h1 class="h2 section-title"><?= $this->title; ?></h1>
                    </div>
                    <div class="tabs-nav-wrap hit-nav desktop-hit-nav">
                        <ul class="nav nav-tabs" id="navbar-hit">
                            <li class="custom-tab-item">
                                <a href="<?= Url::to(['/product/set/index', 'categoryId' => null]) ?>">Все решения</a>
                            </li>
                            <?php foreach ($usages as $id => $usage): ?>
                                <li class="custom-tab-item">
                                    <a href="<?= Url::to([
                                        '/product/set/index',
                                        'categoryId' => $id,
                                    ]) ?>"><?= $usage ?></a>
                                </li>
                            <?php endforeach; ?>
                            <li class="tabs-container dropdown">
                                <div class="tabs-container__btn dropdown-toggle" data-toggle="dropdown"
                                     aria-haspopup="true" aria-expanded="false"></div>
                                <div class="tabs-container__content dropdown-menu"></div>
                            </li>
                        </ul>
                    </div>
                    <div data-sticky_aside class="mobile-hit-nav hit-nav row">
                        <ul>
                            <li class="custom-tab-item">
                                <a href="<?= Url::to(['/product/set/index']) ?>">Все решения</a>
                            </li>
                            <?php foreach ($usages as $id => $usage): ?>
                                <li class="custom-tab-item">
                                    <a href="<?= Url::to([
                                        '/product/set/index',
                                        'categoryId' => $id,
                                    ]) ?>"><?= $usage ?></a>
                                </li>
                            <?php endforeach; ?>
                        </ul>
                    </div>
                </div>
            </div>
        </div>
    </section>

    <section class="section">
        <div class="container pd-top-60">
            <div class="row">
                <?php if ($model->getImage()): ?>
                    <div class="col-sm-6 col-xs-12">
                        <div class="text-block text-gray txt-18">
                            <?= $model->text; ?>
                        </div>
                    </div>
                    <div class="col-sm-6 col-xs-12">
                        <div class="new-card-img">
                            <div class="new-card-img__img"><img src="<?= $model->getImageUrl(); ?>"/></div>
                        </div>
                    </div>
                <?php else : ?>
                    <div class="col-xs-12">
                        <div class="text-block text-gray txt-18">
                            <?= $model->text; ?>
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
</div>

<?= \app\modules\feedback\widget\feedback\FeedbackWidget::widget([
    'view' => 'mini',
    'cssClass' => 'section-request cbp-so-section cbp-so-animate section-request--no-main',
]);
