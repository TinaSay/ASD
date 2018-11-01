<?php
/**
 * Created by PhpStorm.
 * User: elfuvo
 * Date: 14.02.18
 * Time: 15:41
 */

use yii\helpers\Html;
use yii\helpers\Url;

/** @var $this yii\web\View */
/** @var $list \app\modules\product\models\ProductSet[] */
/** @var $usages array */
/** @var $usageId int|null */
/** @var $page \app\modules\product\models\ProductPage */

$this->params['title'] = $this->title = 'Готовые решения ASD';

?>

    <div data-sticky_parent class="block-aside-left-fix">

        <!-- section-promo -->
        <section class="section-promo">
            <div class="container">
                <div class="row">
                    <div class="col-xs-12">
                        <div class="section-news__list-title section-news__list-title--top">
                            <h1 class="section-title h2"><?= $this->title; ?></h1>
                        </div>
                        <div class="tabs-nav-wrap hit-nav desktop-hit-nav">
                            <ul class="nav nav-tabs" id="navbar-hit">
                                <li class="custom-tab-item<?= $usageId ? '' : ' active'; ?>">
                                    <a href="<?= Url::to(['/product/set/index', 'categoryId' => null]) ?>">Все
                                        решения</a>
                                </li>
                                <?php foreach ($usages as $id => $usage): ?>
                                    <li class="custom-tab-item<?= $usageId == $id ? ' active' : ''; ?>">
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
                                <li class="custom-tab-item<?= $usageId ? '' : ' active'; ?>">
                                    <a href="<?= Url::to(['/product/set/index', 'categoryId' => null]) ?>">Все
                                        решения</a>
                                </li>
                                <?php foreach ($usages as $id => $usage): ?>
                                    <li class="custom-tab-item<?= $usageId == $id ? ' active' : ''; ?>">
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

        <?php /*

        <?php if ($list):
            $partList = array_splice($list, 0, 3);
            ?>
            <?= $this->render('_list', ['list' => $partList]); ?>
        <?php endif; ?>
        <?php if ($page): ?>
            <section class="section-disk right blue mr-bottom-0">
                <div class="container">
                    <div class="section-disk__wrap">
                        <div class="section-disk__text">
                            <a href="<?= Url::to(['/product/set/page']); ?>">
                                <div class="top-text">
                                    <p class="title h3"><?= $page->title; ?></p>
                                    <p><?= $page->description; ?></p>
                                </div>
                                <span class="btn bottom-text">Узнайте больше</span>
                            </a>
                        </div>
                        <div class="section-disk__img">
                            <div class="img">
                                <img src="<?= $page->getImageUrl() ?>" alt="<?= Html::encode($page->title); ?>"/>
                            </div>
                        </div>
                    </div>
                </div>
            </section>
        <?php endif; ?>
        */ ?>
        
        <?php if ($list): ?>
            <?= $this->render('_list', ['list' => $list]); ?>
        <?php endif; ?>

    </div>

<?= \app\modules\feedback\widget\feedback\FeedbackWidget::widget([
    'view' => 'mini',
    'cssClass' => 'section-request cbp-so-section cbp-so-animate' . ($list ? '' : ' section-request--no-top'),
]);
