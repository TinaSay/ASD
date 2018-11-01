<?php
/**
 * Created by PhpStorm.
 * User: elfuvo
 * Date: 20.02.18
 * Time: 18:28
 */

/** @var $this yii\web\View */
/** @var $model \app\modules\product\models\ProductUsageSectionText */

?>
<?php if ($model): ?>
    <section class="section-goods section cbp-so-section pd-top-70 pd-bottom-120 cbp-so-animate">
        <div class="cbp-so-side-top cbp-so-side">
            <div class="container">
                <div class="row">
                    <div class="col-xs-12">
                        <h1 class="section-title h2"><?= $model->title; ?></h1>
                        <div class="section-date"></div>
                    </div>
                    <div class="col-xs-12">
                        <div class="text-block text-gray txt-18">
                            <?= $model->text; ?>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </section>
<?php endif; ?>
