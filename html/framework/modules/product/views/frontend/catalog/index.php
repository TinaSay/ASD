<?php
/**
 * Created by PhpStorm.
 * User: elfuvo
 * Date: 12.02.18
 * Time: 14:34
 */

/** @var $this yii\web\View */
/** @var $list \app\modules\product\models\Product[] */
/** @var $pagination \yii\data\Pagination */
/** @var $brand \app\modules\product\models\ProductBrand */
/** @var $section \app\modules\product\models\ProductSection */

$this->params['title'] = $this->title = 'Каталог товаров';
$this->params['hideSets'] = true;
$this->params['feedbackWidgetCssClass'] = 'section-request cbp-so-section cbp-so-animate';
$this->params['showMenu'] = true;

?>
<?= $this->render('_list', ['list' => $list]); ?>

<?= $this->render('//layouts/partitials/pagination', ['pagination' => $pagination]); ?>
