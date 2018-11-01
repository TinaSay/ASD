<?php

/** @var $this yii\web\View */
/** @var $list \app\modules\sked\models\Item[] */
$bundle = \app\modules\sked\assets\SkedBackendAssets::register($this);
?>
<!-- section-history -->
<section class="section section-buy cbp-so-section">
    <div class="cbp-so-side-top cbp-so-side">
        <div class="container">
            <div class="row">
                <div class="col-xs-12">
                    <ul class="buy-list pd-bottom-80">
                        <?php /** @var \app\modules\sked\models\Item $model */
                        foreach ($list as $model): ?>
                            <li>
                                <div class="buy-box">
                                    <div class="buy-box__inner">

                                        <?php if ($model->getImage()): ?>
                                            <?php if (!$model->btnText && $model->getUrl()): ?>
                                                <a href="<?= $model->getUrl() ?>" class="buy-box__logo">
                                                    <img src="<?= ($model->getImage()) ? $model->getImage() : '/static/asd/img/buy-logo.png' ?>"
                                                         alt=""/>
                                                </a>
                                            <?php else: ?>
                                                <a class="buy-box__logo">
                                                    <img src="<?= ($model->getImage()) ? $model->getImage() : '/static/asd/img/buy-logo.png' ?>"
                                                         alt=""/>
                                                </a>
                                            <?php endif; ?>
                                        <?php endif; ?>

                                        <div class="buy-box__info
                                        <?= ($model->getImage()) ? '' : 'no-border no-padding' ?>
                                        <?= ($model->btnText && $model->getUrl()) ? '' : 'no-margin' ?> ">
                                            <div class="top">

                                                <?php if (!$model->btnText && $model->getUrl()): ?>
                                                    <a href="<?= $model->getUrl() ?>" class="company">
                                                        <span class="name fira"><?= $model->title ?></span>
                                                    </a>
                                                <?php else: ?>
                                                    <span class="name fira title-uppercase"><?= $model->title ?></span>
                                                <?php endif; ?>

                                            </div>

                                            <div class="buy-box__brand">
                                                <span class="list-title_widget"><?= $model->description ?></span>
                                            </div>

                                            <?php if ($model->btnText && $model->getUrl()): ?>
                                                <div class="buy-box__btn">
                                                    <a class="btn btn-primary btn-block" href="<?= $model->getUrl() ?>"
                                                       target="_blank"><?= $model->btnText ?></a>
                                                </div>
                                            <?php endif ?>
                                        </div>
                                    </div>
                                </div>
                            </li>
                        <?php endforeach; ?>

                    </ul>
                </div>
            </div>
        </div>
    </div>
</section>
