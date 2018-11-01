<?php
/**
 * Created by PhpStorm.
 * User: elfuvo
 * Date: 14.02.18
 * Time: 16:40
 */

use yii\helpers\Url;

/** @var $this yii\web\View */
/** @var $list \app\modules\product\models\ProductSet[] */
?>
<?php if ($list): ?>
    <!-- section-product -->
    <section class="section section-news cbp-so-section section--list-i">
        <div class="cbp-so-side-top cbp-so-side">
            <div class="container">
                <div class="row">
                    <div class="news-list flex-list news-list--item-i news-list--product clearfix">
                        <?php foreach ($list as $model): ?>
                            <div class="news-list__item col-lg-4 col-md-4 col-xs-12">
                                <a href="<?= Url::to([
                                    '/product/set/view',
                                    'setId' => $model->id,
                                ]) ?>">
                                    <div class="inner">
                                        <div class="img<?= $model->getImages() ? '' : ' noimg' ?>"
                                             style="background-image: url(<?= $model->getFirstImageUrl() ?>);">
                                        </div>
                                        <div class="text">
                                            <div class="text-clip">
                                                <p class="text-top fira"><?= $model->title; ?></p>
                                                <p class="text-middle"><?= strlen($model->description) > 100 ?
                                                        mb_substr($model->description, 0, 100) . '...' :
                                                        $model->description; ?></p>
                                            </div>
                                            <?php if ($model->category): ?>
                                                <p class="text-bottom text-bottom--tag"><?= $model->category; ?></p>
                                            <?php endif; ?>
                                        </div>
                                    </div>
                                </a>
                            </div>
                        <?php endforeach; ?>
                    </div>
                </div>
            </div>
        </div>
    </section>
<?php endif; ?>
