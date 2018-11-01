<?php
/** @var $this yii\web\View */
/** @var $list \app\modules\banner\models\Banner[] */

?>
<?php if ($list): ?>
    <section class="section section-records pd-top-0 cbp-so-section pd-bottom-60">
        <div class="cbp-so-side-top cbp-so-side">
            <div class="container">
                <div class="row">
                    <div class="records-list__wrap records-list__wrap--wherebuy">
                        <div class="records-list">
                            <div class="slide-mobile">
                                <?php
                                /** @var \app\modules\banner\models\Banner $banner */
                                foreach ($list as $banner): ?>
                                    <div class="records-list__item yellow col-lg-4 col-sm-6 col-xs-12">
                                        <div class="inner">
                                            <?php if ($banner->getImage()): ?>
                                                <div class="img"><img src="<?= $banner->getImage() ?>" alt=""/></div>
                                            <?php endif; ?>
                                            <div class="title fira"><?= $banner->title ?></div>
                                            <div class="description"><?= $banner->signature ?></div>
                                        </div>
                                    </div>
                                <?php endforeach; ?>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </section>
<?php endif; ?>