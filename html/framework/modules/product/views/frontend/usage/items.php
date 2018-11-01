<?php
/**
 * Created by PhpStorm.
 * User: elfuvo
 * Date: 12.02.18
 * Time: 14:34
 */

/** @var $this yii\web\View */
/** @var $model \app\modules\product\models\ProductUsage */
/** @var $list \app\modules\product\models\Product */
/** @var $pagination \yii\data\Pagination */
/** @var $section \app\modules\product\models\ProductSection|null */
$this->params['showMenu'] = $section ? false : true;

$this->params['title'] = $section ? $section->title : ($model->getTitle());
if (!$this->title) {
    $this->title = $this->params['title'];
}

$this->params['usageId'] = $model->id;

if ($section) {
    $this->params['sectionId'] = $section->id;
    $this->params['showUsageSectionText'] = true;
}
?>
<?= $this->render('@app/modules/product/views/frontend/catalog/_list', ['list' => $list]); ?>

<?= $this->render('//layouts/partitials/pagination', ['pagination' => $pagination]); ?>
