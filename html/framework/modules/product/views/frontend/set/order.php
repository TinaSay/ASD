<?php
/**
 * Created by PhpStorm.
 * User: elfuvo
 * Date: 19.02.18
 * Time: 14:56
 */

/** @var $this yii\web\View */
/** @var $model \app\modules\product\models\ProductSet */
$this->params['title'] = $this->title = $model->title;// 'Заказать';

?>
<div class="row reverse-block-xs">
    <div class="col-xs-12">
        <div class="catalogue-card__form white-block white-block--wide">
            <div class="h5">
                Хотите получать больше прибыли?
                <span class="h-description">Заполните заявку и наши специалисты подберут для вас готовое решение</span>
            </div>
            <?= \app\modules\feedback\widget\feedback\FeedbackWidget::widget([
                'view' => 'product_set_order',
            ]); ?>
        </div>
    </div>
    <div class="col-lg-5 col-xs-12 reverse-block-xs__block top">
    </div>
</div>