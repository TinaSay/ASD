<?php

use app\modules\advice\assets\AdviceAssets;
use app\modules\advice\models\Advice;

$bundle = AdviceAssets::register($this);

/** @var $this \yii\web\View */
/* @var $list advice[] */
?>
<!-- section-request -->
<section class="section-request section-request--one-mail section-request--no-main cbp-so-section">
    <div class="cbp-so-side-top cbp-so-side">
        <div class="container">
            <div class="row">
                <div class="col-lg-6 col-xs-12">
                    <div class="form-subscription-text">
                        <div class="text">
                            <h3 class="section-title section-title--small">Получите первыми советы от нашей
                                компании.<br> Подпишитесь на рассылку.</h3>
                            <?php /* <div class="section-request__description bold">Уже пописались <?= $subscribersCount ?>
                                человек
                            </div> */ ?>
                        </div>
                    </div>
                </div>
                <div class="col-lg-6 col-xs-12">
                    <form id="formSubscription" method="post" action="" class="form">
                        <div class="loader">
                            <div class="three-bounce">
                                <div class="one"></div>
                                <div class="two"></div>
                                <div class="three"></div>
                            </div>
                        </div>
                        <div class="form-inner">
                            <div class="form-btn">
                                <div class="form-group form-group--field-btn">
                                    <div class="field"><input type="mail" name="mail" placeholder="Укажите ваш email" required class="form-control"></div>
                                    <input type="hidden" name="subscribeType" value="<?= $subscribeType ?>">
                                    <button class="btn btn-primary">Подписаться</button>
                                </div>
                            </div>
                            <div class="form-status">
                                <div class="title fira">Спасибо!</div>
                                <p class="text">Вы подписаны на рассылку компании.</p>
                            </div>
                        </div>
                    </form>
                </div>
            </div>
        </div>
    </div>
</section>
