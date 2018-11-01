<?php

use yii\bootstrap\Html;
use yii\helpers\Url;

/** @var $this yii\web\View */
/** @var $brands \app\modules\brand\models\Brand[] */
?>
<!-- section-brand -->
<section class="section section-brand cbp-so-section">
    <div class="container">
        <div class="row">
            <div class="col-xs-12">
                <div class="section-brand__list-title">
                    <h2 class="section-title">Наши бренды</h2>
                    <ul class="brand-list">
                        <?php foreach ($brands as $key => $brand) : ?>
                            <li class="<?= ($key == 0) ? 'active' : '' ?>">
                                <span>
                                    <?= Html::img($brand->getPreview('logo', 'home-small'), ['alt' => $brand->title]); ?>
                                </span>
                            </li>
                        <?php endforeach; ?>
                    </ul>
                </div>
            </div>
            <div class="cbp-so-side-top cbp-so-side">
                <div class="col-xs-12">

                    <div class="brand-xs-list">
                        <?php foreach ($brands as $brand) : ?>
                        <div class="brand-xs__box">
                            <div class="inner">
                                <div class="brand-xs-top">
                                    <div class="img"><a href="<?= Url::to($brand->link) ?>"><?= Html::img($brand->getPreview('logo', 'home-big'), ['class' => 'logo', 'alt' => $brand->title]); ?></a></div>
                                    <div class="text fira"><a href="<?= Url::to($brand->link) ?>"><?= $brand->title2 ?></a></div>
                                </div>
                                <div class="brand-xs-toggle">
                                    <div class="text">
                                        <?= nl2br($brand->text2) ?>
                                    </div>
                                    <div class="brand-xs-btn">
                                        <?php if ($brand->link) : ?>
                                            <?= Html::a('Перейти в каталог', $brand->link, ['class' => 'btn btn-primary']) ?>
                                        <?php endif; ?>
                                        <?php if ($brand->getPresentation()) : ?>
                                            <?= Html::a('<i class="icon-unload"></i> Скачать презентацию', '/uploads/storage/' . $brand->getSrc('presentation'), ['class' => 'btn btn-unload']) ?>
                                        <?php endif; ?>
                                    </div>
                                </div>
                                <div class="brand-xs-more link-more"><i class="icon-arrow"></i></div>
                            </div>
                        </div>
                        <?php endforeach; ?>
                    </div>

                    <div class="section-brand__box hidden-xs">
                        <span class="aside-shadow"></span>
                        <div class="brand-slide">
                            <?php foreach ($brands as $key => $brand) : ?>
                                <div class="brand-slide__item <?= ($key == 0) ? 'active' : '' ?>">
                                    <div class="section-brand__box-inner">
                                        <div class="fira brand-slide__goods-date"><?= nl2br($brand->text) ?></div>
                                        <div class="brand-slide__goods">
                                            <?= Html::img($brand->getPreview('illustration', 'illustration-home'), ['alt' => $brand->title]); ?>
                                        </div>
                                        <div class="brand-slide__text">
                                            <?= Html::img($brand->getPreview('logo', 'home-big'), ['class' => 'logo', 'alt' => $brand->title]); ?>
                                            <div class="title fira"><?= $brand->title2 ?></div>
                                            <div class="description"><?= nl2br($brand->text2) ?></div>
                                            <?php if ($brand->link) : ?>
                                                <?= Html::a('Перейти в каталог', $brand->link, ['class' => 'btn btn-primary']) ?>
                                            <?php endif; ?>
                                            <?php if ($brand->getPresentation()) : ?>
                                                <?= Html::a('<i class="icon-unload"></i> Скачать презентацию', '/uploads/storage/' . $brand->getSrc('presentation'), ['class' => 'btn btn-unload']) ?>
                                            <?php endif; ?>
                                        </div>
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
