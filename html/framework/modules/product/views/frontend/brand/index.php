<?php
/**
 * Created by PhpStorm.
 * User: elfuvo
 * Date: 12.02.18
 * Time: 10:19
 */

use yii\helpers\ArrayHelper;
use yii\helpers\Html;
use yii\helpers\Url;

/** @var $this yii\web\View */
/** @var $brands \app\modules\product\models\ProductBrand[] */
/** @var $sections array */

$this->params['title'] = Yii::$app->request->get('section') == 'top' ? 'Каталог товаров' : 'Наши бренды';
if (!$this->title) {
    $this->title = $this->params['title'];
}
$this->params['feedbackWidgetCssClass'] = 'section-request cbp-so-section cbp-so-animate';
if (Yii::$app->request->get('section') == 'top') {
    $this->params['showMenu'] = true;
}

?>

<?php if ($brands): ?>
    <!-- список с брендами -->
    <section class="section brand-info-section pd-bottom-70 pd-top-40">
        <div class="container">
            <div class="row">
                <div class="col-xs-12">
                    <?php foreach ($brands as $model): ?>
                        <div class="brand-info white-block white-block--wide mr-bottom-30">
                            <a href="<?= Url::to(['/product/brand/view', 'brandId' => $model->id]); ?>"
                               class="brand-info__head">
                                <?php if ($model->getLogo()): ?>
                                    <div class="logo">
                                        <img width="165" src="<?= $model->getLogoUrl() ?>"
                                             alt="<?= Html::encode($model->title) ?>"/>
                                    </div>
                                <?php endif; ?>
                                <div class="description fira">
                                    <?= $model->description ?: $model->title; ?>
                                </div>
                                <div class="info-btn">
                                    <span class="btn-more-arrow">
                                      <span class="text">Подробнее о бренде</span>
                                      <span class="arrow"><i class="icon-arrow"></i></span>
                                    </span>
                                </div>
                            </a>
                            <?php $filteredSections = ArrayHelper::map($sections, 'id',
                                function ($section) use ($model) {
                                    $brandId = ArrayHelper::getColumn($section['brands'], 'id', []);
                                    return in_array($model->id, $brandId) ? $section : null;
                                }); ?>
                            <?= $this->render('_sections',
                                [
                                    'sections' => $filteredSections,
                                    'model' => $model,
                                ]
                            ); ?>
                        </div>
                    <?php endforeach; ?>
                </div>
            </div>
        </div>
    </section>
<?php endif; ?>


