<?php

/* @var $this yii\web\View */
/* @var $dto \krok\content\dto\frontend\ContentDto */
/* @var  $topAdviceList \app\modules\advice\models\Advice[] */
/* @var  $bottomAdviceList \app\modules\advice\models\Advice[] */
/* @var  $topBigAdvice \app\modules\advice\models\Advice */
/* @var  $bottomBigAdvice \app\modules\advice\models\Advice */
/* @var  $pagination \yii\data\Pagination */
/* @var  $groupList array */

/* @var  $networkList \app\modules\contact\models\Network[] */

use app\modules\advice\widgets\AdviceBigWidget;
use app\modules\advice\widgets\AdvicePager;
use app\modules\advice\widgets\AdviceSubscribeWidget;
use app\modules\advice\widgets\AdviceWidget;
use app\modules\news\models\Subscribe;

$this->title = 'Советы';

?>

<div data-sticky_parent class="block-aside-left-fix">

<!-- section-promo -->
<section class="section-promo <?= $topBigAdvice ? '' : 'mr-bottom-60' ?>">
    <div class="container">
        <div class="row">
            <div class="col-xs-12">
                <div class="section-news__list-title section-news__list-title--top">
                    <h1 class="h2 section-title">Советы</h1>
                    <div class="news-net-link">
                        <div class="news-net-link__title">Будьте в курсе всех событий, подписывайтесь на наши группы
                        </div>
                        <ul>
                            <?php if ($networkList): ?>
                                <?php foreach ($networkList as $network) : ?>
                                    <li><a class="net-link" href="<?= $network->getUrl() ?>" target="_blank"
                                           style="background-image: url(<?= $network->getImage() ?>)"></a></li>
                                <?php endforeach; ?>
                            <?php endif; ?>
                        </ul>
                    </div>
                </div>
                <div class="tabs-nav-wrap hit-nav desktop-hit-nav">
                    <ul class="nav nav-tabs" id="navbar-hit">
                        <li class="custom-tab-item <?= (isset($_GET['group']) ? '' : 'active') ?>">
                            <a href="<?= \yii\helpers\Url::to(['/advice/advice/index']) ?>">Все</a>
                        </li>
                        <?php foreach ($groupList as $id => $group): ?>
                            <li class="custom-tab-item <?= (isset($_GET['group']) && $_GET['group'] == $id) ? 'active' : '' ?>">
                                <a href="<?= \yii\helpers\Url::to([
                                    '/advice/advice/index',
                                    'group' => $id,
                                ]) ?>"><?= $group ?></a>
                            </li>
                        <?php endforeach; ?>

                        <li class="tabs-container dropdown">
                            <div class="tabs-container__btn dropdown-toggle" data-toggle="dropdown" aria-haspopup="true"
                                 aria-expanded="false"></div>
                            <div class="tabs-container__content dropdown-menu"></div>
                        </li>
                    </ul>
                </div>
                <div data-sticky_aside class="mobile-hit-nav hit-nav row">
                    <ul>
                        <li class="custom-tab-item <?= (isset($_GET['group']) ? '' : 'active') ?>">
                            <a href="<?= \yii\helpers\Url::to(['/advice/advice/index']) ?>">Все</a>
                        </li>
                        <?php foreach ($groupList as $id => $group): ?>
                            <li class="custom-tab-item <?= (isset($_GET['group']) && $_GET['group'] == $id) ? 'active' : '' ?>">
                                <a href="<?= \yii\helpers\Url::to([
                                    '/advice/advice/index',
                                    'group' => $id,
                                ]) ?>"><?= $group ?></a>
                            </li>
                        <?php endforeach; ?>

                    </ul>
                </div>
            </div>
        </div>
    </div>
</section>

<?php if ($topBigAdvice): ?>
    <?= AdviceBigWidget::widget([
        'advice' => $topBigAdvice,
        'className' => 'section-disk left yellow',
    ]); ?>
<?php endif; ?>

<?= AdviceWidget::widget([
    'adviceList' => $topAdviceList,
    'className' => 'section section__over-form section-news cbp-so-section ',
]); ?>


<!-- section-request -->
<?= AdviceSubscribeWidget::widget(['subscribeType' => Subscribe::TYPE_SUBSCRIBE_ADVICELIST]); ?>


<?php if ($bottomBigAdvice): ?>
    <?= AdviceBigWidget::widget([
        'advice' => $bottomBigAdvice,
        'className' => 'section-disk right blue',
    ]); ?>
<?php endif; ?>

<?= AdviceWidget::widget([
    'adviceList' => $bottomAdviceList,
    'className' => $bottomBigAdvice ? 'section section-news cbp-so-section' : 'section section-news cbp-so-section section__under-form',
]); ?>


<?= AdvicePager::widget([
    'pagination' => $pagination,
]); ?>


</div>
