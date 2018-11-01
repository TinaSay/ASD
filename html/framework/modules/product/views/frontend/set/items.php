<?php
/**
 * Created by PhpStorm.
 * User: elfuvo
 * Date: 19.02.18
 * Time: 13:23
 */

use yii\helpers\Html;
use yii\helpers\Url;

/** @var $this yii\web\View */
/** @var $model \app\modules\product\models\ProductSet */
/** @var $list \app\modules\product\models\Product[] */

$this->params['title'] = $this->title = $model->title;// 'Товары в наборе';

?>
<?php if ($list): ?>
    <!-- section-goods -->
    <section class="section-goods section cbp-so-section pd-bottom-0 cbp-so-init cbp-so-animate">
        <div class="cbp-so-side-top cbp-so-side">
            <div class="row">
                <?php
                /** @var \app\modules\product\models\Product[] $partList */
                $partList = array_splice($list, 0, 3); ?>

                <div class="offer-list offer-list--many offer-list--4 clearfix mr-top-0">
                    <?php foreach ($partList as $item):
                        /** @var \app\modules\product\models\ProductSetRel $setRel */
                        $setRel = $item->productSetRel ? current($item->productSetRel) : null; ?>
                        <div class="offer-list__item col-lg-3 col-md-6 col-xs-12">
                            <a href="<?= Url::to([
                                '/product/catalog/view',
                                'alias' => $item->alias,
                            ]); ?>">
                                <div class="inner">
                                    <div class="img<?= $item->getImages() ? '' : ' noimg' ?>"
                                         style="background-image: url(<?= $item->getFirstImageUrl() ?>);">
                                        <?php if ($setRel): ?>
                                            <span style="background-color: #00509f;"
                                                  class="offer-status"><?= $setRel->quantity; ?> <span
                                                        class="name">шт</span></span>
                                        <?php endif; ?>
                                        <?php if ($item->brand->getLogo()): ?>
                                            <span class="logo">
                                                <img src="<?= $item->brand->getLogoUrl(); ?>"
                                                     alt="<?= Html::encode($item->brand->title); ?>"/>
                                            </span>
                                        <?php else: ?>
                                            <span class="logo"><?= $item->brand->title; ?></span>
                                        <?php endif; ?>
                                    </div>

                                    <div class="text">
                                        <p class="text-top fira"><?= $item->title; ?></p>
                                        <p class="text-bottom"><?= $item->description; ?></p>
                                    </div>
                                </div>
                            </a>
                        </div>
                    <?php endforeach; ?>
                    <div class="offer-list__item-info amount offer-list__item col-lg-3 col-md-6 col-xs-12">
                        <div class="a">
                            <div class="inner">
                                <div class="img text">
                                    <span class="title fira">Обратите внимание</span>
                                    <span style="background-color: #ffffff;" class="offer-status">
                                      <div class="offer-amount-slider">
                                          <?php foreach (($partList + $list) as $item):
                                              if ($item->productSetRel):
                                                  $setRel = current($item->productSetRel); ?>
                                                  <div class="item"><?= $setRel->quantity ?> <span
                                                              class="name">шт</span></div>
                                              <?php endif;
                                          endforeach; ?>
                                      </div>
                                    </span>
                                </div>
                                <div class="text-amount">
                                    Здесь мы указываем рекомендуемое количество товара для данного решения
                                </div>
                            </div>
                        </div>
                    </div>
                    <?php if ($list): ?>
                        <?php foreach ($list as $item):
                            /** @var \app\modules\product\models\ProductSetRel $setRel */
                            $setRel = $item->productSetRel ? current($item->productSetRel) : null;
                            ?>
                            <div class="offer-list__item col-lg-3 col-md-6 col-xs-12">
                                <a href="<?= Url::to([
                                    '/product/catalog/view',
                                    'alias' => $item->alias,
                                ]); ?>">
                                    <div class="inner">
                                        <div class="img<?= $item->getImages() ? '' : ' noimg' ?>"
                                             style="background-image: url(<?= $item->getFirstImageUrl() ?>);">
                                            <?php if ($setRel): ?>
                                                <span style="background-color: #00509f;"
                                                      class="offer-status"><?= $setRel->quantity; ?> <span
                                                            class="name">шт</span></span>
                                            <?php endif; ?>
                                            <?php if ($item->brand): ?>
                                                <?php if ($item->brand->getLogo()): ?>
                                                    <span class="logo">
                                                <img src="<?= $item->brand->getLogoUrl(); ?>"
                                                     alt="<?= Html::encode($item->brand->title); ?>"/>
                                            </span>
                                                <?php else: ?>
                                                    <span class="logo"><?= $item->brand->title; ?></span>
                                                <?php endif; ?>
                                            <?php endif; ?>
                                        </div>

                                        <div class="text">
                                            <p class="text-top fira"><?= $item->title; ?></p>
                                            <p class="text-bottom"><?= $item->description; ?></p>
                                        </div>
                                    </div>
                                </a>
                            </div>
                        <?php endforeach; ?>
                    <?php endif; ?>
                </div>
            </div>
        </div>
    </section>
<?php endif; ?>


