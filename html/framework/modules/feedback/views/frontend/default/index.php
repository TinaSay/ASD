<?php

/* @var $this yii\web\View */


use yii\helpers\Html;
use app\modules\feedback\assets\FeedbackAssets;
$bundle = FeedbackAssets::register($this);

$this->title = "Форма обратной связи";
?>


<section class="section section-records cbp-so-section cbp-so-init cbp-so-animate">
    <div class="cbp-so-side-top cbp-so-side">
        <div class="container">
            <div class="row">
                <div class="col-xs-12">
                    <h1><?= Html::encode($this->title) ?></h1>


                    <?= $this->render('_form', [
                        'model' => $model,

                    ]) ?>

                </div>
            </div>

        </div>
    </div>
</section>



