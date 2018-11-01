<?php

use yii\bootstrap\Html;

/** @var $this yii\web\View */
/** @var $list \app\modules\banner\models\Banner[] */
?>
<?php if ($list): ?>
    <!-- section-records -->
    <section class="section section-records cbp-so-section">
        <div class="cbp-so-side-top cbp-so-side">
            <div class="container">
                <div class="row">
                    <div class="col-xs-12">
                        <h2 class="section-title">Наши рекорды</h2>
                        <div class="section-title__description">Мы поставили их для вас!</div>
                    </div>
                </div>
                <div class="row">
                    <?php foreach ($list as $key => $banner): ?>
                        <?php if ($key % 3 == 0): ?>
                            <div class="records-list__wrap<?php if ($key > 0): ?> anim-hidden hidden<?php endif; ?>">
                            <div class="records-list">
                            <div class="slide-mobile">
                        <?php endif; ?>
                        <div class="records-list__item col-lg-4 col-sm-6 col-xs-12">
                            <div class="inner">
                                <?php if ($banner->getImage()): ?>
                                    <div class="img"><?= Html::img($banner->getImage()) ?></div>
                                <?php endif; ?>
                                <div class="title fira"><?= $banner->title ?></div>
                                <div class="description"><?= $banner->signature ?></div>
                            </div>
                        </div>
                        <?php if ((($key - 2) % 3 === 0) || (count($list) <= ($key + 1))): ?>
                            </div>
                            </div>
                            </div>
                        <?php endif;; ?>
                    <?php endforeach; ?>
                </div>
                <?php if (count($list) > 3): ?>
                    <div class="row">
                        <div class="update-link col-xs-12"><a class="more-banners" href="#"></a></div>
                    </div>
                <?php endif; ?>
            </div>
        </div>
    </section>
<?php endif; ?>
