<?php

use yii\helpers\Html;

/** @var $data array */
$this->title = 'Мои данные';
?>
<!-- section-promo -->
<section class="section-promo">
    <div class="container">
        <div class="row">
            <div class="col-xs-12">
                <div class="main-title-and-param mr-bottom-40">
                    <h2 class="section-title"><?= Html::encode($this->title) ?></h2>

                    <!-- если баланс минусовой добавляем класс .minus, при плюсовом убираем -->
                    <div class="balance <?= substr_count($data['balance'], "-") ? 'minus' : '' ?>">
                        <div class="balance__left"><i class="icon-pay"></i></div>
                        <div class="balance__right">
                            <span class="balance__head">Баланс на сегодня <?= Yii::$app->formatter->asTime($data['_expire'], 'php:H:i') ?></span>
                            <span class="balance__amount"><?= $data['balance'] ?> ₽</span>
                        </div>
                    </div>
                </div>
            </div>
        </div>
</section>

<section class="section section-lk-list cbp-so-section pd-top-25 pd-bottom-120">
    <div class="cbp-so-side-top cbp-so-side">
        <div class="container">
            <div class="row">
                <div class="col-xs-12">
                    <div class="white-block white-block--wide pd-top-55 pd-bottom-30 pd-top-40 mr-bottom-20">
                        <div class="create-steps__head mr-top-0">
                            <h4 class="title">
                                Персональные данные
                            </h4>
                        </div>
                        <ul class="create-steps__order-info last-child-no-border border-top">
                            <?php if (isset($data['fio'])) : ?>
                                <li>
                                    <div class="left">Пользователь</div>
                                    <div class="right"><?= $data['fio'] ?></div>
                                </li>
                            <?php endif; ?>
                            <?php if (isset($data['partner']['name'])) : ?>
                                <li>
                                    <div class="left">Партнер</div>
                                    <div class="right"><?= $data['partner']['name'] ?></div>
                                </li>
                            <?php endif; ?>
                            <?php if (isset($data['agent'])) : ?>
                                <?php foreach ($data['agent'] as $key => $val) : ?>
                                    <li>
                                        <div class="left">Контрагент - <?= $key + 1 ?></div>
                                        <div class="right"><?= $val['name'] ?></div>
                                    </li>
                                <?php endforeach; ?>
                            <?php endif; ?>
                            <?php /*
                            <li>
                                <div class="left">Контактное лицо</div>
                                <div class="right">Фролов Петр Сергеевич</div>
                            </li>*/ ?>
                            <?php if (isset($data['partner']['tel'])) : ?>
                                <li>
                                    <div class="left">Телефон</div>
                                    <div class="right"><?= $data['partner']['tel'] ?></div>
                                </li>
                            <?php endif; ?>
                            <?php if (isset($data['partner']['mobile'])) : ?>
                                <li>
                                    <div class="left">Мобильный телефон</div>
                                    <div class="right"><?= $data['partner']['mobile'] ?></div>
                                </li>
                            <?php endif; ?>
                            <?php if (isset($data['partner']['email'])) : ?>
                                <li>
                                    <div class="left">E-mail</div>
                                    <div class="right"><?= $data['partner']['email'] ?></div>
                                </li>
                            <?php endif; ?>
                        </ul>
                    </div>

                    <?php if (isset($data['manager'])) : ?>
                        <div class="white-block white-block--wide pd-top-55 pd-bottom-30 pd-top-40">
                            <div class="create-steps__head mr-top-0">
                                <h4 class="title">
                                    Мой менеджер
                                </h4>
                            </div>
                            <?php if (isset($data['manager']['photo'])) : ?>
                                <div class="big-manager-info">
                                    <div class="photo"><?= \yii\helpers\Html::img($data['manager']['photo']) ?></div>
                                    <div class="name"><?= $data['manager']['name'] ?></div>
                                </div>
                            <?php endif; ?>
                            <ul class="create-steps__order-info last-child-no-border">
                                <?php if (isset($data['manager']['tel'])) : ?>
                                    <li>
                                        <div class="left">Телефон</div>
                                        <div class="right"><?= $data['manager']['tel'] ?></div>
                                    </li>
                                <?php endif; ?>
                                <?php if (isset($data['manager']['email'])) : ?>
                                    <li>
                                        <div class="left">E-mail</div>
                                        <div class="right"><?= $data['manager']['email'] ?></div>
                                    </li>
                                <?php endif; ?>
                            </ul>
                        </div>
                    <?php endif; ?>

                </div>
            </div>
        </div>
    </div>
</section>