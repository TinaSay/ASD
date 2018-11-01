<?php
/**
 * Created by PhpStorm.
 * User: elfuvo
 * Date: 12.02.18
 * Time: 14:34
 */

/** @var $this yii\web\View */
/** @var $model \app\modules\product\models\ProductPromo */
/** @var $list \app\modules\product\models\Product[] */
/** @var $pagination \yii\data\Pagination */
/** @var $brand \app\modules\product\models\ProductBrand */

$this->params['title'] = $this->title = $brand ? $brand->title : $model->title;

$this->params['promoId'] = $model->id;
if ($brand) {
    $this->params['brandId'] = $brand->id;
    $this->params['showMenu'] = true;
} elseif (Yii::$app->request->get('section') == 'top') {
    $this->params['showMenu'] = true;
}

if ($pagination->getPage() > 0) {
    $this->params['hideFilter'] = true;
}

?>
<?php if ($list): ?>
    <?php
    $product = array_shift($list);
    print $this->render('_big_item',
        [
            'product' => $product,
            'brand' => $brand,
            'model' => $model,
            'cssClass' => 'left yellow',
            'btnCssClass' => 'btn-primary',
        ]);
    ?>
    <?php if ($list):
        $partList = array_splice($list, 0, 4);
        ?>
        <?= $this->render('_list', ['list' => $partList, 'brand' => $brand, 'model' => $model]); ?>
        <?php unset($partList); endif; ?>
    <?php if ($list):
        $product = array_shift($list);
        print $this->render('_big_item',
            [
                'product' => $product,
                'brand' => $brand,
                'model' => $model,
                'cssClass' => 'right blue' . (empty($list) ? '' : ' pd-bottom-30'),
                'btnCssClass' => 'btn-info',
            ]);
        ?>
    <?php endif; ?>

    <?php if ($list): ?>
        <?= $this->render('_list', ['list' => $list]); ?>
    <?php endif; ?>


    <?= $this->render('//layouts/partitials/pagination', ['pagination' => $pagination]); ?>
<?php else: ?>
    <section class="section-goods section cbp-so-section pd-bottom-50">
        <div class="cbp-so-side-top cbp-so-side">
            <div class="container">
                <div class="row">
                    <div class="offer-list pd-bottom-120 offer-list--many offer-list--4 clearfix">
                        <p>Нет предложений.</p>
                    </div>
                </div>
            </div>
        </div>
    </section>
<?php endif; ?>
