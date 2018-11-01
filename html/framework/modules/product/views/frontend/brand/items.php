<?php
/**
 * Created by PhpStorm.
 * User: elfuvo
 * Date: 12.02.18
 * Time: 14:34
 */

/** @var $this yii\web\View */
/** @var $model \app\modules\brand\models\Brand */
/** @var $list \app\modules\product\models\Product */
/** @var $pagination \yii\data\Pagination */
/** @var $section \app\modules\product\models\ProductSection */

if ($section) {
    $this->params['title'] = $section->title . ' ' . $model->title;
} else {
    $this->params['title'] = $model->title;
    $this->params['showMenu'] = true;
}

if (!$this->title) {
    $this->title = $this->params['title'];
}

$this->params['brandId'] = $model->id;
$this->params['feedbackWidgetCssClass'] = 'section-request mr-bottom-0 cbp-so-section cbp-so-animate';

?>
<?= $this->render('@app/modules/product/views/frontend/catalog/_list', ['list' => $list]); ?>

<?= $this->render('//layouts/partitials/pagination', ['pagination' => $pagination]); ?>