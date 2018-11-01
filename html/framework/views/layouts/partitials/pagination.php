<?php
/**
 * Created by PhpStorm.
 * User: elfuvo
 * Date: 13.02.18
 * Time: 13:03
 */

/** @var $this yii\web\View */
/* @var $pagination yii\data\Pagination */
?>
<?php if ($pagination->getPageCount() > 1) : ?>
    <div class="container pd-bottom-90">
        <div class="row">
            <div class="col-xs-12">
                <div class="wrap-pagination">
                    <?= \app\widgets\pagination\LinkPager::widget([
                        'pagination' => $pagination,
                        'maxButtonCount' => 5,
                        'options' => ['class' => 'pagination pull-left', 'tag' => 'div'],
                    ]); ?>
                </div>
            </div>
        </div>
    </div>
<?php endif; ?>
