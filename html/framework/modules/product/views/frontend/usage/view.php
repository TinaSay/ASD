<?php
/**
 * Created by PhpStorm.
 * User: elfuvo
 * Date: 12.02.18
 * Time: 12:24
 */

use yii\helpers\Html;
use yii\helpers\Url;

/** @var $this yii\web\View */
/** @var $model \app\modules\product\models\ProductUsage */

$this->params['title'] = $model->getTitle();
$this->params['hideFeedbackForm'] = true;
$this->params['hideSets'] = true;
$this->params['usageId'] = $model->id;
$this->params['showMenu'] = true;

if (!$this->title) {
    $this->title = $this->params['title'];
}
?>
<!-- о бренде -->
<section class="section card-brand cbp-so-section pd-top-50">
    <div class="cbp-so-side-top cbp-so-side">
        <div class="container">
            <div class="row">
                <div class="col-xs-12">
                    <!-- описание -->
                    <?php if ($model->text): ?>
                        <div class="brand-info brand-info--usage white-block white-block--wide mr-bottom-30">
                        <div class="brand-info__head no-border">
                            <?php if ($model->getIcon()): ?>
                                <div class="logo">
                                    <img width="165" src="<?= $model->getIconUrl(); ?>"
                                         alt="<?= Html::encode($model->getTitle()); ?>"/>
                                </div>
                            <?php endif; ?>
                            <div class="description">
                                <div class="text-block">
                                    <?= $model->text; ?>
                                </div>
                            </div>
                        </div>
                        </div><?php endif; ?>

                    <!-- категории -->
                    <?php if ($model->sections): ?>
                        <div class="white-block white-block--yellow card-brand__category white-block--wide">
                            <div class="head">
                                <h5 class="pd-bottom-0">Каталог товаров <?= mb_strtolower($model->getTitle()); ?></h5>
                            </div>
                            <?= $this->render('_sections',
                                [
                                    'model' => $model,
                                    'sections' => $model->getSections(),
                                ]
                            ); ?>
                        </div>
                    <?php endif; ?>
                </div>
            </div>
        </div>

        <div class="container">
            <div class="row">
                <div class="col-xs-12">
                    <div class="btn-back-and-net">
                        <div class="btn-back-and-net__left">
                            <?= \app\widgets\back\BackBtnWidget::widget([
                                'defaultUrl' => Url::to([
                                    '/product/usage/index',
                                    'section' => 'top',
                                ]),
                            ]); ?>
                        </div>
                        <?= $this->render('//layouts/partitials/bottom-share.php'); ?>
                    </div>
                </div>
            </div>
        </div>
    </div>
</section>


