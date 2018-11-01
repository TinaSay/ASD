<?php

use app\modules\search\widgets\SearchPager;

/* @var $this yii\web\View */
/* @var $models [] */
/* @var $pagination \yii\data\Pagination */
/* @var $numFirstItem integer */
/* @var $totalCount integer */

?>
<!-- section-request -->
<section class="section-result">
    <div class="container">
        <div class="row">
            <div class="col-xs-12">
                <div class="white-block white-block--wide search-result">
                    <div class="search-result-list">
                        <ul>
                            <?php $n = 1;
                            foreach ($models as $id => $model): ?>
                                <?= $this->render('_itemSearch',
                                    ['model' => $model, 'numModel' => $numFirstItem + $id]) ?>
                            <?php endforeach; ?>
                        </ul>
                    </div>
                </div>
            </div>
        </div>
    </div>
</section>
<?= SearchPager::widget(['pagination' => $pagination]) ?>
