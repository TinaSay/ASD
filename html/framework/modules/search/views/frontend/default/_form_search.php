<?php

use yii\widgets\ActiveForm;
use app\modules\search\models\SearchForm;
use yii\helpers\Url;

/* @var $this yii\web\View */
/* @var $searchModel \app\modules\search\models\SearchForm */
/* @var $count integer */
/* @var $filters array */
/* @var $pagination \yii\data\Pagination */

?>
<div data-sticky_parent class="block-aside-left-fix">
<section class="section">
    <div class="container">
        <div class="row">
            <div class="col-xs-12">
                <h1 class="section-title h2">Результаты поиска</h1>
                <div class="white-block white-block--wide search-block">
                    <?php $form = ActiveForm::begin([
                        'method' => 'get',
                        'enableClientValidation' => false,
                        'action' => ['/search/default/index'],
                        'fieldConfig' => [
                            'template' => '{input}',
                            'options' => [
                                'tag' => false,
                            ],
                        ],
                    ]); ?>
                    <div class="search-block__field">
                        <div class="field-wrap form-groupe">
                            <?= $form->field($searchModel, 'term')->textInput([
                                'class' => 'form-control',
                                'placeholder' => 'Введите поисковой запрос...',
                                'id' => 'searchform-page-term',
                            ])->label(false); ?>
                            <span class="field-clear"><i class="icon-close"></i></span>
                        </div>
                        <button type="text" class="btn-primary btn">Найти</button>
                    </div>
                    <div class="search-block__bottom">
                        <span>По Вашему запросу нашлось: <?= $count ?> результатов</span>
                        <!-- параметры пока просили скрыть, может позже понадобятся -->
                        <div style="display: none;" class="dropdown">
                            <span class="search-param dropdown-toggle" data-toggle="dropdown">Параметры поиска <i
                                        class="icon-arrow"></i></span>
                            <ul class="dropdown-menu">
                                <li><a href="#">По дате</a></li>
                                <li><a href="#">По релевантности</a></li>
                            </ul>
                        </div>
                    </div>
                    <?php ActiveForm::end(); ?>
                </div>
            </div>
            <?php if ($filters[SearchForm::TYPE_ALL]): ?>
                <div class="col-xs-12">
                    <div class="tabs-nav-wrap tabs-nav-wrap--border-cover hit-nav desktop-hit-nav">
                        <ul class="nav nav-tabs nav-tabs--border" id="navbar-hit"
                            data-url="<?= Url::to('index') ?>" data-page="<?= $pagination->page + 1 ?>"
                            data-per-page="<?= $pagination->pageSize ?>">
                            <li class="custom-tab-item<?= $type == SearchForm::TYPE_ALL ? ' active' : '' ?>">
                                <a href="<?= Url::to([
                                    '/search/default/index',
                                    'term' => $searchModel->term,
                                    'type' => SearchForm::TYPE_ALL,
                                    'page' => $pagination->page + 1,
                                    'per-page' => $pagination->pageSize
                                ]) ?>" data-type="<?= SearchForm::TYPE_ALL ?>">Все</a>
                            </li>
                            <?php if ($filters[SearchForm::TYPE_ADVICE]): ?>
                                <li class="custom-tab-item<?= $type == SearchForm::TYPE_ADVICE ? ' active' : '' ?>">
                                    <a href="<?= Url::to([
                                        '/search/default/index',
                                        'term' => $searchModel->term,
                                        'type' => SearchForm::TYPE_ADVICE,
                                        'page' => $pagination->page + 1,
                                        'per-page' => $pagination->pageSize
                                    ]) ?>" data-type="<?= SearchForm::TYPE_ADVICE ?>">Советы</a>
                                </li>
                            <?php endif; ?>
                            <?php if ($filters[SearchForm::TYPE_NEWS]): ?>
                                <li class="custom-tab-item<?= $type == SearchForm::TYPE_NEWS ? ' active' : '' ?>">
                                    <a href="<?= Url::to([
                                        '/search/default/index',
                                        'term' => $searchModel->term,
                                        'type' => SearchForm::TYPE_NEWS,
                                        'page' => $pagination->page + 1,
                                        'per-page' => $pagination->pageSize
                                    ]) ?>" data-type="<?= SearchForm::TYPE_NEWS ?>">Новости</a>
                                </li>
                            <?php endif; ?>
                            <?php if ($filters[SearchForm::TYPE_GENERAL]): ?>
                                <li class="custom-tab-item<?= $type == SearchForm::TYPE_GENERAL ? ' active' : '' ?>">
                                    <a href="<?= Url::to([
                                        '/search/default/index',
                                        'term' => $searchModel->term,
                                        'type' => SearchForm::TYPE_GENERAL,
                                        'page' => $pagination->page + 1,
                                        'per-page' => $pagination->pageSize
                                    ]) ?>" data-type="<?= SearchForm::TYPE_GENERAL ?>">Общая информация</a>
                                </li>
                            <?php endif; ?>
                            <?php if ($filters[SearchForm::TYPE_PRODUCT]): ?>
                                <li class="custom-tab-item<?= $type == SearchForm::TYPE_PRODUCT ? ' active' : '' ?>">
                                    <a href="<?= Url::to([
                                        '/search/default/index',
                                        'term' => $searchModel->term,
                                        'type' => SearchForm::TYPE_PRODUCT,
                                        'page' => $pagination->page + 1,
                                        'per-page' => $pagination->pageSize
                                    ]) ?>" data-type="<?= SearchForm::TYPE_PRODUCT ?>">Продукты</a>
                                </li>
                            <?php endif; ?>
                            <?php if ($filters[SearchForm::TYPE_PRODUCT_SET]): ?>
                                <li class="custom-tab-item<?= $type == SearchForm::TYPE_PRODUCT_SET ? ' active' : '' ?>">
                                    <a href="<?= Url::to([
                                        '/search/default/index',
                                        'term' => $searchModel->term,
                                        'type' => SearchForm::TYPE_PRODUCT_SET,
                                        'page' => $pagination->page + 1,
                                        'per-page' => $pagination->pageSize
                                    ]) ?>" data-type="<?= SearchForm::TYPE_PRODUCT_SET ?>">Наборы</a>
                                </li>
                            <?php endif; ?>
                            <li class="tabs-container dropdown">
                                <div class="tabs-container__btn dropdown-toggle" data-toggle="dropdown"
                                     aria-haspopup="true"
                                     aria-expanded="false"></div>
                                <div class="tabs-container__content dropdown-menu"></div>
                            </li>
                        </ul>
                    </div>
                    <div data-sticky_aside class="mobile-hit-nav hit-nav row">
                        <ul>
                            <li class="custom-tab-item<?= $type == SearchForm::TYPE_ALL ? ' active' : '' ?>">
                                <a href="#" data-type="<?= SearchForm::TYPE_ALL ?>">Все</a>
                            </li>
                            <?php if ($filters[SearchForm::TYPE_ADVICE]): ?>
                                <li class="custom-tab-item<?= $type == SearchForm::TYPE_ADVICE ? ' active' : '' ?>">
                                    <a href="<?= Url::to([
                                        '/search/default/index',
                                        'term' => $searchModel->term,
                                        'type' => SearchForm::TYPE_ADVICE,
                                        'page' => $pagination->page + 1,
                                        'per-page' => $pagination->pageSize
                                    ]) ?>" data-type="<?= SearchForm::TYPE_ADVICE ?>">Советы</a>
                                </li>
                            <?php endif; ?>
                            <?php if ($filters[SearchForm::TYPE_NEWS]): ?>
                                <li class="custom-tab-item<?= $type == SearchForm::TYPE_NEWS ? ' active' : '' ?>">
                                    <a href="<?= Url::to([
                                        '/search/default/index',
                                        'term' => $searchModel->term,
                                        'type' => SearchForm::TYPE_NEWS,
                                        'page' => $pagination->page + 1,
                                        'per-page' => $pagination->pageSize
                                    ]) ?>" data-type="<?= SearchForm::TYPE_NEWS ?>">Новости</a>
                                </li>
                            <?php endif; ?>
                            <?php if ($filters[SearchForm::TYPE_GENERAL]): ?>
                                <li class="custom-tab-item<?= $type == SearchForm::TYPE_GENERAL ? ' active' : '' ?>">
                                    <a href="<?= Url::to([
                                        '/search/default/index',
                                        'term' => $searchModel->term,
                                        'type' => SearchForm::TYPE_GENERAL,
                                        'page' => $pagination->page + 1,
                                        'per-page' => $pagination->pageSize
                                    ]) ?>" data-type="<?= SearchForm::TYPE_GENERAL ?>">Общая информация</a>
                                </li>
                            <?php endif; ?>
                            <?php if ($filters[SearchForm::TYPE_PRODUCT]): ?>
                                <li class="custom-tab-item<?= $type == SearchForm::TYPE_PRODUCT ? ' active' : '' ?>">
                                    <a href="<?= Url::to([
                                        '/search/default/index',
                                        'term' => $searchModel->term,
                                        'type' => SearchForm::TYPE_PRODUCT,
                                        'page' => $pagination->page + 1,
                                        'per-page' => $pagination->pageSize
                                    ]) ?>" data-type="<?= SearchForm::TYPE_PRODUCT ?>">Продукты</a>
                                </li>
                            <?php endif; ?>
                            <?php if ($filters[SearchForm::TYPE_PRODUCT_SET]): ?>
                                <li class="custom-tab-item<?= $type == SearchForm::TYPE_PRODUCT_SET ? ' active' : '' ?>">
                                    <a href="<?= Url::to([
                                        '/search/default/index',
                                        'term' => $searchModel->term,
                                        'type' => SearchForm::TYPE_PRODUCT_SET,
                                        'page' => $pagination->page + 1,
                                        'per-page' => $pagination->pageSize
                                    ]) ?>" data-type="<?= SearchForm::TYPE_PRODUCT_SET ?>">Наборы</a>
                                </li>
                            <?php endif; ?>
                        </ul>
                    </div>
                </div>
            <?php endif; ?>
        </div>
    </div>
</section>
</div>