<?php
/** @var $this yii\web\View */
/** @var $list \app\modules\banner\models\Banner[] */

?>
<?php if ($list): ?>
    <section class="section section-records pd-top-0 cbp-so-section pd-bottom-60">
        <div class="cbp-so-side-top cbp-so-side">
            <div class="container">
                <div class="row">
                    <div class="records-list__wrap">
                        <div class="records-list">
                            <div class="slide-mobile">
                                <?php
                                /** @var \app\modules\banner\models\Banner $banner */
    foreach ($list as $k => $banner): ?>
        <div class="records-list__item <?= $bannerColor ?> col-lg-4 col-sm-6 col-xs-12">
            <div class="inner">
                                            <?php if ($banner->getImage()): ?>
                                                <div class="img"><img src="<?= $banner->getImage() ?>" alt=""/></div>
                                            <?php endif; ?>
                                            <div class="title fira"><?= $banner->title ?></div>
                                            <div class="description"><?= $banner->signature ?></div>
                                        </div>
                                    </div>
        <?php if (($k + 1) % 3 == 0 && isset($list[$k + 1])): ?>
            </div>
            </div>
            </div>
            </div>
            </div>
            </div>
            </section>
            <section class="section section-records pd-top-0 cbp-so-section pd-bottom-60">
            <div class="cbp-so-side-top cbp-so-side">
            <div class="container">
            <div class="row">
            <div class="records-list__wrap">
            <div class="records-list">
            <div class="slide-mobile">
        <?php endif; ?>
                                <?php endforeach; ?>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </section>
<?php endif; ?>