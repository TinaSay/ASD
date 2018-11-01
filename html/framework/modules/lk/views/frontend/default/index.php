<?php

use yii\helpers\Html;
use app\modules\lk\assets\LkAsset;

/* @var $this \yii\web\View */
/* @var $searchModel app\modules\lk\models\OrderSearch */
/* @var $provider yii\data\ArrayDataProvider */
/* @var $data array */

LkAsset::register($this);
$this->title = 'Мои заказы';
?>
<!-- section-promo -->
<section class="section-promo">
    <div class="container">
        <div class="row">
            <div class="col-xs-12">
                <div class="main-title-and-param mr-bottom-40">
                    <h2 class="section-title"><?= Html::encode($this->title) ?></h2>
                    <!-- если баланс минусовой добавляем класс .minus, при плюсовом убираем -->
                    <div class="balance <?= ($data['balance'] < 0) ? 'minus' : '' ?>">
                        <div class="balance__left"><i class="icon-pay"></i></div>
                        <div class="balance__right">
                            <span class="balance__head">Баланс на сегодня <?= Yii::$app->formatter->asTime($data['_expire'], 'php:H:i') ?></span>
                            <span class="balance__amount"><?= ($data['balance'] < 0) ? '-' : '' ?><?= Yii::$app->formatter->asCurrency(abs($data['balance'])) ?></span>
                        </div>
                    </div>
                </div>
            </div>
        </div>
</section>

<!-- список -->
<section class="section section-lk-list cbp-so-section pd-top-25 pd-bottom-120">
    <div class="cbp-so-side-top cbp-so-side">
        <div class="container">
            <div class="row">
                <div class="col-xs-12">
                    <div class="white-block white-block--wide">

                        <!--<div class="lk-list__top-nav">
                          <h5 class="title">Мои заказы</h5>
                          <a href="#" class="btn btn-info btn-add btn-new-order"><i class="icon-plus"></i>Создать новый заказ</a>
                        </div>-->

                        <!-- фильтр -->
                        <div class="lk-list__filter">
                            <?= Html::beginForm(
                                ['/lk/default/filter-orders'],
                                'get',
                                [
                                    'class' => 'form-filter',
                                ]
                            ); ?>
                            <div class="form-filter__row">

                                <!-- статус -->
                                <div class="form-group form-group-status">
                                    <div class="form-filter-title">Статус заказа</div>
                                    <?= Html::activeDropDownList($searchModel, 'status', $searchModel::$orders, [
                                        'data-placeholder' => 'Выберите статус',
                                    ]) ?>
                                </div>

                                <!-- дата -->
                                <div class="form-group form-group-date">
                                    <div class="form-filter-title">Дата оформления заказа</div>
                                    <div class="two-date">
                                        <div class="two-date__elem">
                                            <?= Html::activeInput('text', $searchModel, 'createdAtFrom', ['placeholder' => 'дд/мм/гггг', 'class' => 'form-control input-date date-to', 'id' => 'docDateTo']) ?>
                                        </div>
                                        <span class="separator"></span>
                                        <div class="two-date__elem">
                                            <?= Html::activeInput('text', $searchModel, 'createdAtTo', ['placeholder' => 'дд/мм/гггг', 'class' => 'form-control input-date date-from', 'id' => 'docDateFrom']) ?>
                                        </div>
                                    </div>
                                </div>

                                <!-- диапозон цены -->
                                <div class="form-group form-group-cost">
                                    <div class="form-filter-title">Сумма заказа</div>
                                    <div class="group-cost">
                                        <?= Html::activeInput('number', $searchModel, 'totalSumFrom', ['class' => 'form-control', 'id' => 'minCost', 'value' => is_null($searchModel->totalSumFrom) ? 0 : $searchModel->totalSumFrom]) ?>
                                        <span class="separator"></span>
                                        <?= Html::activeInput('number', $searchModel, 'totalSumTo', ['class' => 'form-control', 'id' => 'maxCost', 'value' => is_null($searchModel->totalSumTo) ? 9999999 : $searchModel->totalSumTo]) ?>
                                    </div>
                                    <div class="slider-cont">
                                        <div id="slider"></div>
                                    </div>
                                </div>

                            </div>
                            <?= Html::endForm(); ?>
                        </div>
                        <div id="order-table">
                            <?= $this->render('_order-table', ['searchModel' => $searchModel, 'provider' => $provider, 'sort' => $sort, 'documents' => []]) ?>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>
</section>
