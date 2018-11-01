<?php


/** @var $this yii\web\View */
/** @var $list \app\modules\wherebuy\models\Wherebuy[] */
?>
<!-- section-history -->
<section class="section section-buy cbp-so-section">
    <div class="cbp-so-side-top cbp-so-side">
        <div class="container">
            <div class="row">
                <div class="col-xs-12">
                    <ul class="buy-list pd-bottom-80">
                        <?php foreach ($list as $model): ?>
                            <li>
                                <div class="buy-box">
                                    <div class="buy-box__inner">

                                        <a href="<?= $model->link ?>" class="buy-box__logo">
                                            <img src="<?= ($model->getImage()) ? $model->getImage() : '/static/asd/img/buy-logo.png' ?>" alt=""/>
                                        </a>

                                        <div class="buy-box__info">
                                            <div class="top">
                                                <a href="<?= $model->link ?>" class="company">
                                                    <span class="category"><?= $model->subtitle ?></span>
                                                    <span class="name fira"><?= $model->title ?></span>
                                                </a>
                                                <?php if ($model->delivery): ?>
                                                    <div class="buy-box__delivery">
                                                        <span><i class="icon-car"></i><?= $model->delivery ?></span>
                                                    </div>
                                                <?php endif; ?>
                                            </div>
                                            <?php if ($model->getBrandRelation()->count() > 0): ?>
                                                <div class="buy-box__brand">
                                                    <span class="list-title">Бренды представленные в магазине:</span>
                                                    <ul class="buy-box__brand-list">
                                                        <?php foreach ($model->getBrandRelation()->all() as $brand) : ?>
                                                            <li><a href="<?= $model->link ?>"><?= $brand->title ?></a>
                                                            </li>
                                                        <?php endforeach; ?>
                                                    </ul>
                                                </div>
                                            <?php endif; ?>
                                            <div class="buy-box__btn">
                                                <a class="btn btn-primary btn-block" href="<?= $model->link ?>" target="_blank">Перейти в магазин</a>
                                            </div>
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
