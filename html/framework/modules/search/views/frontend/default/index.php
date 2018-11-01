<?php

use app\modules\search\assets\SearchAsset;

/* @var $this yii\web\View */
/* @var $searchModel \app\modules\search\models\SearchForm */
/* @var $models [] */
/* @var $pagination \yii\data\Pagination */
/* @var $numFirstItem integer */
/* @var $totalCount integer */
/* @var $filters array */
/* @var $type integer */

$this->title = 'Поиск по сайту';
SearchAsset::register($this);
?>

<?= $this->render('_form_search', [
    'searchModel' => $searchModel,
    'count' => $totalCount,
    'filters' => $filters,
    'pagination' => $pagination,
    'type' => $type
]) ?>

<?php if (count($models) > 0): ?>
    <div class="search_result">
        <?= $this->render('_search_result', [
            'models' => $models,
            'pagination' => $pagination,
            'numFirstItem' => $numFirstItem,
            'totalCount' => $totalCount
        ]) ?>
    </div>
<?php else: ?>
    <!-- section-request -->
    <section class="section-result">
        <div class="container">
            <div class="row">
                <div class="col-xs-12">
                    <div class="white-block white-block--wide search-result">
                        <div class="search-result-list">
                            По вашему запросу ничего не найдено
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </section>

<?php endif; ?>

