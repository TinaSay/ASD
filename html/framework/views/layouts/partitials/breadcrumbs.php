<?php
/**
 * Created by PhpStorm.
 * User: elfuvo
 * Date: 29.12.17
 * Time: 11:48
 */

/** @var $this yii\web\View */

use app\modules\menu\widgets\BreadcrumbsWidget;

$breadcrumbs = BreadcrumbsWidget::widget([
    'homeLink' => false,
    'hideLastLink' => true,
    'skipLastLink' => false,
    'activeItemTemplate' => '<li class="active"><span>{link}</span></li>',
    'options' => [
        'class' => 'breadcrumbs-list',
    ],
]);

?>
<?php if ($breadcrumbs): ?>
    <div class="breadcrumbs">
        <div class="container">
            <div class="row">
                <div class="col-xs-12">
                    <?= $breadcrumbs; ?>
                </div>
            </div>
        </div>
    </div>
<?php endif; ?>
