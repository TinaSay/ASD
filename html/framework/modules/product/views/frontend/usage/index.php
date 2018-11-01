<?php
/**
 * Created by PhpStorm.
 * User: elfuvo
 * Date: 12.02.18
 * Time: 10:19
 */

use yii\helpers\Html;
use yii\helpers\Url;

/** @var $this yii\web\View */
/** @var $usages \app\modules\product\models\ProductUsage[] */
/** @var $sections array */

$this->params['title'] = 'Каталог товаров';
$this->params['feedbackWidgetCssClass'] = 'section-request cbp-so-section cbp-so-animate';
$this->params['showMenu'] = true;
if (!$this->title) {
    $this->title = $this->params['title'];
}

?>

<?php if ($usages): ?>
    <!-- список со Сферами применения -->
    <section class="section brand-info-section pd-bottom-70 pd-top-40">
        <div class="container">
            <div class="row">
                <div class="col-xs-12">
                    <?php foreach ($usages as $model): ?>
                        <div class="brand-info brand-info--usage white-block white-block--wide mr-bottom-30">
                            <div class="brand-info__head">
                                <?php if ($model->getIcon()): ?>
                                    <a href="<?= Url::to(['/product/usage/view', 'usageId' => $model->id]); ?>"
                                       class="logo">
                                        <img width="165" src="<?= $model->getIconUrl() ?>"
                                             alt="<?= Html::encode($model->getTitle()) ?>"/>
                                    </a>
                                <?php endif; ?>
                                <div class="description">
                                    <a href="<?= Url::to(['/product/usage/view', 'usageId' => $model->id]); ?>">
                                        <h5 class="title fira"><?= $model->getTitle(); ?></h5>
                                    </a>
                                    <?php if ($model->description): ?>
                                        <div class="text-block">
                                            <?= Yii::$app->formatter->asNtext($model->description); ?>
                                        </div>
                                    <?php endif; ?>
                                </div>
                                <div class="info-btn">
                                    <a href="<?= Url::to(['/product/usage/view', 'usageId' => $model->id]); ?>"
                                       class="btn-more-arrow">
                                        <span class="text">Подробнее</span>
                                        <span class="arrow"><i class="icon-arrow"></i></span>
                                    </a>
                                </div>
                            </div>
                            <?php if ($model->sections): ?>
                                <?= $this->render('_sections',
                                    [
                                        'model' => $model,
                                        'sections' => $model->sections,
                                    ]
                                ); ?>
                            <?php endif; ?>
                        </div>
                    <?php endforeach; ?>
                </div>
            </div>
        </div>
    </section>
<?php endif; ?>


