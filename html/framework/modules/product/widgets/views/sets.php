<?php
/**
 * Created by PhpStorm.
 * User: elfuvo
 * Date: 14.02.18
 * Time: 9:28
 */

use yii\helpers\Url;

/** @var $this yii\web\View */
/** @var $list \app\modules\product\models\ProductSet[] */
/** @var $exclude int|null */

?>
<?php if ($list): ?>
    <!-- section-hit -->
    <section class="section section-hit cbp-so-section">
        <div class="cbp-so-side-top cbp-so-side">
            <div class="container">
                <div class="row">
                    <div class="col-xs-12">
                        <h2 class="section-title">Хотите зарабатывать больше?</h2>
                        <div class="section-title__description">
                            <?php if ($exclude): ?>Посмотрите наши другие готовые решения
                            <?php else: ?>Мы вам поможем!<?php endif; ?></div>
                    </div>
                </div>
                <div class="row">
                    <div class="offer-list flex-list offer-list--4 clearfix">
                        <?php foreach ($list as $model): ?>
                            <div class="offer-list__item col-lg-3 col-md-4 col-xs-12">
                                <a href="<?= Url::to(['/product/set/view', 'setId' => $model->id]); ?>">
                                    <div class="inner">
                                        <div class="img">
                                            <div class="bg-width img-bg" style="background-image: url(<?= $model->getFirstImageUrl(); ?>);"></div>
                                        </div>
                                        <div class="text">
                                            <p class="text-top fira"><?= $model->title; ?></p>
                                            <p class="text-bottom"><?= $model->description; ?></p>
                                        </div>
                                    </div>
                                </a>
                            </div>
                        <?php endforeach; ?>
                    </div>
                </div>
            </div>
    </section>
<?php endif; ?>