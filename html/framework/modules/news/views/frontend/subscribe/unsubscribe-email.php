<?php
/**
 * Created by PhpStorm.
 * User: Rustam
 * Date: 13.05.2018
 * Time: 22:56
 */

$this->title = "Отказ от рассылки";

use app\modules\news\assets\NewsAssets;
use yii\helpers\Html;

$bundle = NewsAssets::register($this);

/** @var \app\modules\news\models\Subscribe|\app\modules\feedback\models\Feedback $model */
/** @var \app\modules\packet\models\Packet $packet */
?>

<section class="section">
    <div class="container">
        <div class="row">
            <div class="col-xs-12">
                <h1 class="section-title h2"><?= $this->title ?></h1>
                <div class="section-date"></div>
            </div>
            <div class="col-sm-6 col-xs-12">
                <div class="text-block text-gray txt-18">
                    <p>Вы собираетесь оформить отказ от наших рассылок с полезной информацией, акциями и
                        спецпредложениями для адреса электронной почты</p>
                    <p>Email: <?= $model->email ?></p>
                    <p>Пожалуйста, подтвердите ваше намерение.</p>

                    <?= Html::button(Yii::t('system', 'Agree'),
                        ['class' => 'btn btn-info unsubscribe-btn', 'rel' => \yii\helpers\Url::to(['/news/subscribe/unsubscribe-user-email', 'email' => $model->email, 'hash' => $model->hash])]) ?>

                    <?= Html::button(Yii::t('system', 'Cancel'),
                        ['class' => 'btn btn-danger unsubscribe-btn', 'rel' => \yii\helpers\Url::to(['/'])]) ?>
                </div>
            </div>
        </div>
    </div>

</section>