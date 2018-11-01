<?php
/**
 * Created by PhpStorm.
 * User: elfuvo
 * Date: 12.02.18
 * Time: 15:17
 */

use yii\helpers\Html;
use yii\helpers\Url;

/** @var $this yii\web\View */
/** @var $searchModel \app\modules\product\models\search\ProductCatalogSearch */
/** @var $clientCategory \app\modules\product\models\ProductClientCategory[] */
/** @var $brands \app\modules\product\models\ProductBrand[] */
/** @var $usages \app\modules\product\models\ProductUsage[] */
/** @var $total int */
/** @var $count int */
/** @var $opened bool */

?>
<!-- filter -->
<div class="brand-filter white-block white-block--wide<?php if ($opened): ?> active<?php endif; ?>" <?php if ($opened): ?> style="display:block;"<?php endif; ?>>
    <div class="brand-filter__inner">
        <?= Html::beginForm(['/product/catalog/search'], 'get',
            [
                'class' => 'brand-filter__form',
                'id' => 'catalog-filter-form',
                'data' => [
                    'count-url' => Url::to(['/product/catalog/filter-count']),
                ],
            ]); ?>
        <?= Html::hiddenInput('realSearch', '1'); ?>
        <div class="filter-who brand-filter__box">
            <div class="left">
                <div class="form-sub-title">Для кого товар?</div>
                <ul class="check-who-list">
                    <?php foreach ($clientCategory as $model): ?>
                        <li>
                            <label class="wrap-check">
                                <?= Html::checkbox($searchModel->formName() . '[clientCategoryId][]',
                                    in_array($model->id, $searchModel->clientCategoryId), [
                                        'class' => 'client-category-item',
                                        'value' => $model->id,
                                        'data' => [
                                            'id' => $model->id,
                                            'url' => Url::to([
                                                '/product/catalog/brands-for-category',
                                            ]),
                                            'control' => '.check-brands-list',
                                        ],
                                    ]); ?>
                                <?php if ($model->getIcon()): ?><i>
                                    <img height="35" src="<?= $model->getIconUrl(); ?>" alt=""/></i><?php endif; ?>
                                <span class="placeholder"><?= $model->title; ?></span>
                            </label>
                        </li>
                    <?php endforeach; ?>
                </ul>
            </div>
            <div class="right">
                <div class="form-sub-title">Знаете артикул или название товара?</div>
                <div class="field-with-clear name-wrap-field">
                    <?= Html::activeTextInput($searchModel, 'article', [
                        'class' => "form-control",
                        'id' => "fieldName",
                        'placeholder' => "Введите здесь",
                        'label' => false,
                        'data-source' => Url::to(['/product/catalog/product-dictionary']),
                        'value' => $searchModel->article,
                    ]); ?>
                </div>
            </div>
        </div>
        <div class="filter-brands brand-filter__box">
            <div class="title-and-param">
                <div class="form-sub-title">Наши бренды</div>
                <div class="param">
                    <!-- в data-list указываем класс списка с чекбоксами -->
                    <span data-list="check-brands-list"
                          class="param-btn check-all-or-clear check">Выбрать все</span>
                    <span data-list="check-brands-list"
                          class="param-btn check-all-or-clear clear">Очистить выбор</span>
                </div>
            </div>
            <ul class="check-brands-list">
                <?php foreach ($brands as $model): ?>
                    <li>
                        <label class="wrap-check">
                            <?= Html::checkbox($searchModel->formName() . '[brandId][]',
                                in_array($model->id, $searchModel->brandId), [
                                    'class' => 'brand-item',
                                    'value' => $model->id,
                                    'disabled' => true,
                                    'data' => [
                                        'id' => $model->id,
                                        'url' => Url::to([
                                            '/product/brand/get-sections',
                                        ]),
                                        'control' => '.brand-category',
                                    ],
                                ]); ?>
                            <?php if ($model->getLogo()): ?><i>
                                <img height="47" src="<?= $model->getLogoUrl(); ?>" alt="<?= $model->title; ?>"/>
                                </i><?php else: ?><i><span><?= $model->title; ?></span></i><?php endif; ?>
                        </label>
                    </li>
                <?php endforeach; ?>
            </ul>
        </div>
        <!-- критерии -->
        <div class="filter-param brand-filter__box">
            <div class="title-and-param">
                <div class="form-sub-title">Где и как планируете использовать?</div>
                <div class="param">
                    <!-- в data-list указываем класс списка с чекбоксами -->
                    <span data-list="param-check-list.active"
                          class="param-btn check-all-or-clear check">Выбрать все</span>
                    <span data-list="param-check-list.active"
                          class="param-btn check-all-or-clear clear">Очистить выбор</span>
                </div>
            </div>
            <!-- если выбрано более одного бренда, отображаем этот блок -->
            <div class="param-check-list filter-param__one" data-url="<?= Url::to('/product/brand/get-usages'); ?>">
                <ul class="param-one-list">
                    <?php foreach ($usages as $model): ?>
                        <li>
                            <label class="wrap-check">
                                <?= Html::checkbox($searchModel->formName() . '[usageId][]',
                                    in_array($model->id, $searchModel->usageId), [
                                        'class' => 'usage-item',
                                        'value' => $model->id,
                                        'data' => [
                                            'id' => $model->id,
                                        ],
                                    ]); ?>
                                <i><?php if ($model->getIcon()): ?>
                                        <img width="40" src="<?= $model->getIconUrl(); ?>" alt=""/><?php endif; ?>
                                </i>
                                <span class="placeholder"><?= $model->title; ?></span>
                            </label>
                        </li>
                    <?php endforeach; ?>
                </ul>
            </div>
            <!-- если выбран один бренд, отображаем этот блок -->
            <div class="param-check-list filter-param__many"
                 data-url="<?= Url::to('/product/brand/get-sections'); ?>"></div>
        </div>
        <!-- нижняя часть фильтра -->
        <div class="filter-footer brand-filter__box">
            <button type="submit"<?= $searchModel->isEmpty() ? ' disabled' : ''; ?>
                    class="btn btn-info brand-filter-show">
                Показать <span class="amount"></span> <span class="goods">товары</span>
            </button>
            <span class="all-goods">Всего в нашем каталоге <?= Yii::$app->formatter->asDecimal($total, 0); ?>
                товаров</span>
            <div class="hide-filter__wrap"><span class="hide-filter"><i class="icon-arrow"></i><span>Свернуть форму подбора</span></span>
            </div>
        </div>
        <?= Html::endForm(); ?>
    </div>
</div>
<!-- end filter -->
