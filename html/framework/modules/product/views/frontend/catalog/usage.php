<?php
/**
 * Created by PhpStorm.
 * User: elfuvo
 * Date: 12.02.18
 * Time: 14:34
 */

/** @var $this yii\web\View */
/** @var $dataProvider \yii\data\ActiveDataProvider */
/** @var $searchModel \app\modules\product\models\search\ProductCatalogSearch */
/** @var $usage \app\modules\product\models\ProductUsage */

$this->params['title'] = $this->title = $usage->title;
$this->params['feedbackWidgetCssClass'] = 'section-request cbp-so-section cbp-so-animate';

?>
<?php if ($searchModel->isEmpty()): ?>
    <section class="section-empty-choice section pd-top-50">
        <div class="container">
            <div class="row">
                <div class="col-xs-12">
                    <div class="empty-choice white-block white-block--wide">
                        <div class="empty-choice__top">Пока этот список товаров пуст, но всё можно поправить</div>
                        <div class="empty-choice__param"><i class="icon-param"></i></div>
                        <div class="empty-choice__bottom">
                            <span class="big fira">Подберите нужные вам товары,</span>
                            <span class="small fira">используя наш удобный фильтр.</span>
                            <a href="#" class="filter-open footer-header__btn-param yellow">
                                <span class="btn-first"><i class="icon-param"></i></span>
                                <span class="btn-second">Подберите товары</span>
                            </a>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </section>
<?php else: ?>
    <?= $this->render('_list', ['list' => $dataProvider->getModels()]); ?>

    <?= $this->render('//layouts/partitials/pagination', ['pagination' => $dataProvider->getPagination()]); ?>
<?php endif; ?>