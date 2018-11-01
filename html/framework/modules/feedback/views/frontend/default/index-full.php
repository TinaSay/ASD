<?php

/* @var $this yii\web\View */


use yii\helpers\Html;
use app\modules\feedback\assets\FeedbackAssets;
$bundle = FeedbackAssets::register($this);

$this->title = "Форма обратной связи";
?>


<div class="feedback-create">

    <h1><?= Html::encode($this->title) ?></h1>


    <?= $this->render('_form-full', [
        'model' => $model,

    ]) ?>

</div>
