<?php

use app\modules\lk\assets\LkAsset;

/* @var $this \yii\web\View */
/* @var $order array */
/* @var $data array */

LkAsset::register($this);
$this->title = 'Карточка заказа';
?>
<div class="breadcrumbs">
    <div class="container">
        <div class="row">
            <div class="col-xs-12">
                <ul>
                    <li><a href="#"><span>Главная</span></a></li>
                </ul>
            </div>
        </div>
    </div>
</div>

<!-- section-promo -->
<section class="section-promo">
    <div class="container">
        <div class="row">
            <div class="col-xs-12">
                <div class="main-title-and-param mr-bottom-40">
                    <h2 class="section-title">Мои заказы</h2>

                    <!-- если баланс минусовой добавляем класс .minus, при плюсовом убираем -->
                    <div class="balance <?= ($data['balance'] < 0) ? 'minus' : '' ?>">
                        <div class="balance__left"><i class="icon-pay"></i></div>
                        <div class="balance__right">
                            <span class="balance__head">Баланс на сегодня <?= Yii::$app->formatter->asTime($data['_expire'],
                                    'php:H:i') ?></span>
                            <span class="balance__amount"><?= ($data['balance'] < 0) ? '-' : '' ?><?= Yii::$app->formatter->asCurrency(abs($data['balance'])) ?></span>
                            </span>
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
                    <div class="white-block white-block--wide pd-top-55 pd-bottom-50 mr-bottom-20">
                        <ul class="create-steps">
                            <li><i class="icon-create"></i> Оформление</li>
                            <li class="active"><i class="icon-ok"></i> Создан</li>
                            <li><i class="icon-reserve"></i> Зарезервирован</li>
                            <li><i class="icon-assembly"></i> Собирается</li>
                            <li><i class="icon-ready"></i> Готов к отгрузке</li>
                            <li><i class="icon-car"></i> Отгружен</li>
                        </ul>
                        <div class="create-steps__head">
                            <div class="title-update">
                                <h4 class="title">
                                    Заказ № <?= $order['orderNumber'] ?>
                                </h4>
                                <a class="link-repeat" href="#"><i class="icon-update"></i>Повторить заказ</a>
                            </div>
                            <div class="date">
                                <span>Дата создания заказа:</span> <?= Yii::$app->formatter->asDate($order['createdAtDate'],
                                    'short') ?></div>
                        </div>

                        <div class="ok-steps__info">
                            Ваш заказ создан и отправлен на обработку.<br>
                            В ближайшее время с Вами свяжется наш менеджер для подтверждения.
                        </div>

                        <ul class="create-steps__order-info border-bottom">
                            <li>
                                <div class="left">Контрагент</div>
                                <div class="right"><?= $order['contractorName'] ?></div>
                            </li>
                            <li>
                                <div class="left">Сумма заказа</div>
                                <div class="right"><?= Yii::$app->formatter->asCurrency($order['totalSum']) ?></div>
                            </li>
                            <li>
                                <div class="left">Общее количество позиций</div>
                                <div class="right"><?= $order['totalUnit'] ?></div>
                            </li>
                            <li>
                                <div class="left">Юридическое лицо</div>
                                <div class="right"><?= $order['partnerName'] ?></div>
                            </li>
                            <li>
                                <div class="left">Адрес доставки</div>
                                <div class="right"><?= $order['gruzAddress'] ?></div>
                            </li>
                        </ul>

                        <div class="li">
                            <div class="ok-steps__info-bottom">
                                <div class="left">
                                    <span class="status-order ok"><i class="icon-ok"></i> Создан</span>
                                    <span class="date-update">Обновленно: <?= Yii::$app->formatter->asDatetime($order['updatedAtDateTime'],'short')?></span>
                                </div>
                                <!-- если документов нет, добавляем к кнопке ниже класс .no-active и .disabled-->
                                <span class="show-lk-doc btn btn-primary order-btn-one-size no-active disabled"><i
                                            class="icon-doc"></i>Документы заказа</span>
                            </div>
                            <!-- раскрывашка с доками -->
                            <div class="lk-doc">
                                <ul class="lk-doc__list">
                                    <li>
                                        <a href="#">
                                            <div class="lk-doc__inner">
                                                <div class="left">
                                                    <span class="type pdf">pdf</span>
                                                    <span class="name">Товарная накладная</span>
                                                </div>
                                                <div class="right">
                                                    <span class="size">56кб</span>
                                                    <span class="download icon-download"></span>
                                                </div>
                                            </div>
                                        </a>
                                    </li>
                                    <li>
                                        <a href="#">
                                            <div class="lk-doc__inner">
                                                <div class="left">
                                                    <span class="type jpg">jpg</span>
                                                    <span class="name">Товарная накладная</span>
                                                </div>
                                                <div class="right">
                                                    <span class="size">569кб</span>
                                                    <span class="download icon-download"></span>
                                                </div>
                                            </div>
                                        </a>
                                    </li>
                                    <li>
                                        <a href="#">
                                            <div class="lk-doc__inner">
                                                <div class="left">
                                                    <span class="type hml">hml</span>
                                                    <span class="name">Товарная накладная</span>
                                                </div>
                                                <div class="right">
                                                    <span class="size">56кб</span>
                                                    <span class="download icon-download"></span>
                                                </div>
                                            </div>
                                        </a>
                                    </li>
                                    <li>
                                        <a href="#">
                                            <div class="lk-doc__inner">
                                                <div class="left">
                                                    <span class="type doc">doc</span>
                                                    <span class="name">Товарная накладная</span>
                                                </div>
                                                <div class="right">
                                                    <span class="size">56кб</span>
                                                    <span class="download icon-download"></span>
                                                </div>
                                            </div>
                                        </a>
                                    </li>
                                </ul>
                            </div>
                        </div>
                    </div>

                    <!-- спислк с товарами -->
                    <div class="white-block white-block--wide pd-top-55 pd-bottom-50">
                        <div class="create-steps__head mr-top-0">
                            <h4 class="title">Список товаров</h4>
                            <a data-href="page-goods" href="#"
                               class="open-page-layer btn btn-info btn-add btn-add-goods order-btn-one-size"><i
                                        class="icon-plus2"></i>Добавить товары</a>
                        </div>
                        <div class="lk-list__wrap">
                            <div class="lk-list lk-list--goods">
                                <div class="lk-list__table">
                                    <li class="lk-list__head">
                                        <div class="li-inner">
                                            <div class="art active">
                                                Артикул
                                                <div class="sort"><span class="up active"></span><span
                                                            class="down"></span></div>
                                            </div>
                                            <div class="brand active">
                                                Бренд
                                                <div class="sort"><span class="up"></span><span
                                                            class="down active"></span></div>
                                            </div>
                                            <div class="name">
                                                Наименование товара
                                                <div class="sort"><span class="up"></span><span class="down"></span>
                                                </div>
                                            </div>
                                            <div class="price">
                                                Цена
                                                <div class="tolltip-link" data-delay="500" data-toggle="tooltip"
                                                     data-placement="top" title="Текст подсказки">
                                                    <i class="icon-tooltip"></i>
                                                </div>
                                                <div class="sort"><span class="up"></span><span class="down"></span>
                                                </div>
                                            </div>
                                            <div class="amount">
                                                Количество
                                                <div class="tolltip-link" data-delay="500" data-toggle="tooltip"
                                                     data-placement="top" title="Текст подсказки">
                                                    <i class="icon-tooltip"></i>
                                                </div>
                                                <div class="sort"><span class="up"></span><span class="down"></span>
                                                </div>
                                            </div>
                                            <div class="price-all">
                                                Сумма
                                                <div class="sort"><span class="up"></span><span class="down"></span>
                                                </div>
                                            </div>
                                            <div class="delete"></div>
                                        </div>
                                    </li>

                                    <li>
                                        <div class="li-inner">
                                            <div class="art">666-666</div>
                                            <div class="brand">Pattera</div>
                                            <div class="name">
                                                <a href="#" class="name-tooltip">
                                                    <span><i class="icon-open"></i> Бумага для выпекания с двусторонней силиконизацией, 8 м</span>
                                                </a>
                                                <div class="info-mobile">
                                                    <span class="info-mobile__box"><span>Бренд:</span> Pattera</span>
                                                    <span class="info-mobile__box"><span>Артикул:</span> 666-666</span>
                                                    <span class="info-mobile__box"><span>Цена:</span> 100 ₽</span>
                                                </div>
                                            </div>
                                            <div class="price">100 ₽</div>
                                            <div class="amount">
                                                <div class="js-spinner">
                                                    <button class="js-spinner__left-btn" type="button"
                                                            spinner-button="down">-
                                                    </button>
                                                    <div class="input-wrap">
                                                        <input type="number" value="155" step="1" max="999999" min="0"
                                                               data-stepper-debounce="400"
                                                               class="js-stepper form-control select-val">
                                                        <span></span>
                                                    </div>
                                                    <button class="js-spinner__right-btn" type="button"
                                                            spinner-button="up">+
                                                    </button>
                                                </div>
                                            </div>
                                            <div class="price-all">10000 ₽</div>
                                            <div class="delete"><span
                                                        data-text="Подтвердите, пожалуйста, удаление позиции."
                                                        class="delete-confirm btn-delete icon-delete"></span></div>
                                        </div>
                                    </li>

                                    <li>
                                        <div class="li-inner">
                                            <div class="art">666-666</div>
                                            <div class="brand">Pattera</div>
                                            <div class="name">
                                                <a href="#" class="name-tooltip">
                                                    <span><i class="icon-open"></i> Бумага для выпекания с двусторонней силиконизацией, 8 м</span>
                                                </a>
                                                <div class="info-mobile">
                                                    <span class="info-mobile__box"><span>Бренд:</span> Pattera</span>
                                                    <span class="info-mobile__box"><span>Артикул:</span> 666-666</span>
                                                    <span class="info-mobile__box"><span>Цена:</span> 100 ₽</span>
                                                </div>
                                            </div>
                                            <div class="price">100 ₽</div>
                                            <div class="amount">
                                                <div class="js-spinner">
                                                    <button class="js-spinner__left-btn" type="button"
                                                            spinner-button="down">-
                                                    </button>
                                                    <div class="input-wrap">
                                                        <input type="number" value="155" step="1" max="999999" min="0"
                                                               data-stepper-debounce="400"
                                                               class="js-stepper form-control select-val">
                                                        <span></span>
                                                    </div>
                                                    <button class="js-spinner__right-btn" type="button"
                                                            spinner-button="up">+
                                                    </button>
                                                </div>
                                            </div>
                                            <div class="price-all">10000 ₽</div>
                                            <div class="delete"><span
                                                        data-text="Подтвердите, пожалуйста, удаление позиции."
                                                        class="delete-confirm btn-delete icon-delete"></span></div>
                                        </div>
                                    </li>

                                    <li>
                                        <div class="li-inner">
                                            <div class="art">666-666</div>
                                            <div class="brand">Pattera</div>
                                            <div class="name">
                                                <a href="#" class="name-tooltip">
                                                    <span><i class="icon-open"></i> Бумага для выпекания с двусторонней силиконизацией, 8 м</span>
                                                </a>
                                                <div class="info-mobile">
                                                    <span class="info-mobile__box"><span>Бренд:</span> Pattera</span>
                                                    <span class="info-mobile__box"><span>Артикул:</span> 666-666</span>
                                                    <span class="info-mobile__box"><span>Цена:</span> 100 ₽</span>
                                                </div>
                                            </div>
                                            <div class="price">100 ₽</div>
                                            <div class="amount">
                                                <div class="js-spinner">
                                                    <button class="js-spinner__left-btn" type="button"
                                                            spinner-button="down">-
                                                    </button>
                                                    <div class="input-wrap">
                                                        <input type="number" value="155" step="1" max="999999" min="0"
                                                               data-stepper-debounce="400"
                                                               class="js-stepper form-control select-val">
                                                        <span></span>
                                                    </div>
                                                    <button class="js-spinner__right-btn" type="button"
                                                            spinner-button="up">+
                                                    </button>
                                                </div>
                                            </div>
                                            <div class="price-all">10000 ₽</div>
                                            <div class="delete"><span
                                                        data-text="Подтвердите, пожалуйста, удаление позиции."
                                                        class="delete-confirm btn-delete icon-delete"></span></div>
                                        </div>
                                    </li>

                                    <li>
                                        <div class="li-inner">
                                            <div class="art">666-666</div>
                                            <div class="brand">Pattera</div>
                                            <div class="name">
                                                <a href="#" class="name-tooltip">
                                                    <span><i class="icon-open"></i> Бумага для выпекания с двусторонней силиконизацией, 8 м</span>
                                                </a>
                                                <div class="info-mobile">
                                                    <span class="info-mobile__box"><span>Бренд:</span> Pattera</span>
                                                    <span class="info-mobile__box"><span>Артикул:</span> 666-666</span>
                                                    <span class="info-mobile__box"><span>Цена:</span> 100 ₽</span>
                                                </div>
                                            </div>
                                            <div class="price">100 ₽</div>
                                            <div class="amount">
                                                <div class="js-spinner">
                                                    <button class="js-spinner__left-btn" type="button"
                                                            spinner-button="down">-
                                                    </button>
                                                    <div class="input-wrap">
                                                        <input type="number" value="155" step="1" max="999999" min="0"
                                                               data-stepper-debounce="400"
                                                               class="js-stepper form-control select-val">
                                                        <span></span>
                                                    </div>
                                                    <button class="js-spinner__right-btn" type="button"
                                                            spinner-button="up">+
                                                    </button>
                                                </div>
                                            </div>
                                            <div class="price-all">10000 ₽</div>
                                            <div class="delete"><span
                                                        data-text="Подтвердите, пожалуйста, удаление позиции."
                                                        class="delete-confirm btn-delete icon-delete"></span></div>
                                        </div>
                                    </li>

                                    <li>
                                        <div class="li-inner">
                                            <div class="art">666-666</div>
                                            <div class="brand">Pattera</div>
                                            <div class="name">
                                                <a href="#" class="name-tooltip">
                                                    <span><i class="icon-open"></i> Бумага для выпекания с двусторонней силиконизацией, 8 м</span>
                                                </a>
                                                <div class="info-mobile">
                                                    <span class="info-mobile__box"><span>Бренд:</span> Pattera</span>
                                                    <span class="info-mobile__box"><span>Артикул:</span> 666-666</span>
                                                    <span class="info-mobile__box"><span>Цена:</span> 100 ₽</span>
                                                </div>
                                            </div>
                                            <div class="price">100 ₽</div>
                                            <div class="amount">
                                                <div class="js-spinner">
                                                    <button class="js-spinner__left-btn" type="button"
                                                            spinner-button="down">-
                                                    </button>
                                                    <div class="input-wrap">
                                                        <input type="number" value="155" step="1" max="999999" min="0"
                                                               data-stepper-debounce="400"
                                                               class="js-stepper form-control select-val">
                                                        <span></span>
                                                    </div>
                                                    <button class="js-spinner__right-btn" type="button"
                                                            spinner-button="up">+
                                                    </button>
                                                </div>
                                            </div>
                                            <div class="price-all">10000 ₽</div>
                                            <div class="delete"><span
                                                        data-text="Подтвердите, пожалуйста, удаление позиции."
                                                        class="delete-confirm btn-delete icon-delete"></span></div>
                                        </div>
                                    </li>

                                    <li>
                                        <div class="li-inner">
                                            <div class="art">666-666</div>
                                            <div class="brand">Pattera</div>
                                            <div class="name">
                                                <a href="#" class="name-tooltip">
                                                    <span><i class="icon-open"></i> Бумага для выпекания с двусторонней силиконизацией, 8 м</span>
                                                </a>
                                                <div class="info-mobile">
                                                    <span class="info-mobile__box"><span>Бренд:</span> Pattera</span>
                                                    <span class="info-mobile__box"><span>Артикул:</span> 666-666</span>
                                                    <span class="info-mobile__box"><span>Цена:</span> 100 ₽</span>
                                                </div>
                                            </div>
                                            <div class="price">100 ₽</div>
                                            <div class="amount">
                                                <div class="js-spinner">
                                                    <button class="js-spinner__left-btn" type="button"
                                                            spinner-button="down">-
                                                    </button>
                                                    <div class="input-wrap">
                                                        <input type="number" value="155" step="1" max="999999" min="0"
                                                               data-stepper-debounce="400"
                                                               class="js-stepper form-control select-val">
                                                        <span></span>
                                                    </div>
                                                    <button class="js-spinner__right-btn" type="button"
                                                            spinner-button="up">+
                                                    </button>
                                                </div>
                                            </div>
                                            <div class="price-all">10000 ₽</div>
                                            <div class="delete"><span
                                                        data-text="Подтвердите, пожалуйста, удаление позиции."
                                                        class="delete-confirm btn-delete icon-delete"></span></div>
                                        </div>
                                    </li>

                                    <li>
                                        <div class="li-inner">
                                            <div class="art">666-666</div>
                                            <div class="brand">Pattera</div>
                                            <div class="name">
                                                <a href="#" class="name-tooltip">
                                                    <span><i class="icon-open"></i> Бумага для выпекания с двусторонней силиконизацией, 8 м</span>
                                                </a>
                                                <div class="info-mobile">
                                                    <span class="info-mobile__box"><span>Бренд:</span> Pattera</span>
                                                    <span class="info-mobile__box"><span>Артикул:</span> 666-666</span>
                                                    <span class="info-mobile__box"><span>Цена:</span> 100 ₽</span>
                                                </div>
                                            </div>
                                            <div class="price">100 ₽</div>
                                            <div class="amount">
                                                <div class="js-spinner">
                                                    <button class="js-spinner__left-btn" type="button"
                                                            spinner-button="down">-
                                                    </button>
                                                    <div class="input-wrap">
                                                        <input type="number" value="155" step="1" max="999999" min="0"
                                                               data-stepper-debounce="400"
                                                               class="js-stepper form-control select-val">
                                                        <span></span>
                                                    </div>
                                                    <button class="js-spinner__right-btn" type="button"
                                                            spinner-button="up">+
                                                    </button>
                                                </div>
                                            </div>
                                            <div class="price-all">10000 ₽</div>
                                            <div class="delete"><span
                                                        data-text="Подтвердите, пожалуйста, удаление позиции."
                                                        class="delete-confirm btn-delete icon-delete"></span></div>
                                        </div>
                                    </li>

                                    <li>
                                        <div class="li-inner">
                                            <div class="art">666-666</div>
                                            <div class="brand">Pattera</div>
                                            <div class="name">
                                                <a href="#" class="name-tooltip">
                                                    <span><i class="icon-open"></i> Бумага для выпекания с двусторонней силиконизацией, 8 м</span>
                                                </a>
                                                <div class="info-mobile">
                                                    <span class="info-mobile__box"><span>Бренд:</span> Pattera</span>
                                                    <span class="info-mobile__box"><span>Артикул:</span> 666-666</span>
                                                    <span class="info-mobile__box"><span>Цена:</span> 100 ₽</span>
                                                </div>
                                            </div>
                                            <div class="price">100 ₽</div>
                                            <div class="amount">
                                                <div class="js-spinner">
                                                    <button class="js-spinner__left-btn" type="button"
                                                            spinner-button="down">-
                                                    </button>
                                                    <div class="input-wrap">
                                                        <input type="number" value="155" step="1" max="999999" min="0"
                                                               data-stepper-debounce="400"
                                                               class="js-stepper form-control select-val">
                                                        <span></span>
                                                    </div>
                                                    <button class="js-spinner__right-btn" type="button"
                                                            spinner-button="up">+
                                                    </button>
                                                </div>
                                            </div>
                                            <div class="price-all">10000 ₽</div>
                                            <div class="delete"><span
                                                        data-text="Подтвердите, пожалуйста, удаление позиции."
                                                        class="delete-confirm btn-delete icon-delete"></span></div>
                                        </div>
                                    </li>

                                    <li>
                                        <div class="li-inner">
                                            <div class="art">666-666</div>
                                            <div class="brand">Pattera</div>
                                            <div class="name">
                                                <a href="#" class="name-tooltip">
                                                    <span><i class="icon-open"></i> Бумага для выпекания с двусторонней силиконизацией, 8 м</span>
                                                </a>
                                                <div class="info-mobile">
                                                    <span class="info-mobile__box"><span>Бренд:</span> Pattera</span>
                                                    <span class="info-mobile__box"><span>Артикул:</span> 666-666</span>
                                                    <span class="info-mobile__box"><span>Цена:</span> 100 ₽</span>
                                                </div>
                                            </div>
                                            <div class="price">100 ₽</div>
                                            <div class="amount">
                                                <div class="js-spinner">
                                                    <button class="js-spinner__left-btn" type="button"
                                                            spinner-button="down">-
                                                    </button>
                                                    <div class="input-wrap">
                                                        <input type="number" value="155" step="1" max="999999" min="0"
                                                               data-stepper-debounce="400"
                                                               class="js-stepper form-control select-val">
                                                        <span></span>
                                                    </div>
                                                    <button class="js-spinner__right-btn" type="button"
                                                            spinner-button="up">+
                                                    </button>
                                                </div>
                                            </div>
                                            <div class="price-all">10000 ₽</div>
                                            <div class="delete"><span
                                                        data-text="Подтвердите, пожалуйста, удаление позиции."
                                                        class="delete-confirm btn-delete icon-delete"></span></div>
                                        </div>
                                    </li>

                                    <li>
                                        <div class="li-inner">
                                            <div class="art">666-666</div>
                                            <div class="brand">Pattera</div>
                                            <div class="name">
                                                <a href="#" class="name-tooltip">
                                                    <span><i class="icon-open"></i> Бумага для выпекания с двусторонней силиконизацией, 8 м</span>
                                                </a>
                                                <div class="info-mobile">
                                                    <span class="info-mobile__box"><span>Бренд:</span> Pattera</span>
                                                    <span class="info-mobile__box"><span>Артикул:</span> 666-666</span>
                                                    <span class="info-mobile__box"><span>Цена:</span> 100 ₽</span>
                                                </div>
                                            </div>
                                            <div class="price">100 ₽</div>
                                            <div class="amount">
                                                <div class="js-spinner">
                                                    <button class="js-spinner__left-btn" type="button"
                                                            spinner-button="down">-
                                                    </button>
                                                    <div class="input-wrap">
                                                        <input type="number" value="155" step="1" max="999999" min="0"
                                                               data-stepper-debounce="400"
                                                               class="js-stepper form-control select-val">
                                                        <span></span>
                                                    </div>
                                                    <button class="js-spinner__right-btn" type="button"
                                                            spinner-button="up">+
                                                    </button>
                                                </div>
                                            </div>
                                            <div class="price-all">10000 ₽</div>
                                            <div class="delete"><span
                                                        data-text="Подтвердите, пожалуйста, удаление позиции."
                                                        class="delete-confirm btn-delete icon-delete"></span></div>
                                        </div>
                                    </li>
                                </div>
                            </div>
                        </div>
                        <div class="goods-sum-order">
                            <span class="name">Итого:</span> <span class="big"><?= Yii::$app->formatter->asCurrency($order['totalSum']) ?></span>
                        </div>
                        <div class="lk-list__bottom-nav">
                            <div class="wrap-pagination">
                                <div class="pagination pull-left">
                                    <a href="#" class="prev">«</a>
                                    <span class="active">1</span>
                                    <a href="#">2</a>
                                    <a href="#">3</a>
                                    <a href="#">4</a>
                                    <a href="#" class="next">»</a>
                                </div>
                            </div>
                            <a data-href="page-goods" href="#"
                               class="open-page-layer btn btn-info btn-add btn-add-goods order-btn-one-size"><i
                                        class="icon-plus2"></i>Добавить товары</a>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>
</section>
