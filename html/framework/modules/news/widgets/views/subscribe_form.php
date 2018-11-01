<?php

use app\modules\news\assets\NewsAssets;
use app\modules\news\models\News;

$bundle = NewsAssets::register($this);

/** @var $this \yii\web\View */
/* @var $list News[] */
?>
<!-- section-request -->
<section class="section-request section-request--book section-request--no-main cbp-so-section">
    <div class="cbp-so-side-top cbp-so-side">
        <div class="container">
            <div class="row">
                <div class="col-lg-6 col-xs-12">
                    <div class="form-subscription-text">
                        <div class="text">
                            <h3 class="section-title section-title--small">Вам интересны события из жизни ASD?<br>
                                Подпишитесь на нашу рассылку.</h3>
                            <div class="section-request__description">
                                Наша рассылка — это ненавязчивые письма с информацией о главном, что происходит в нашей
                                компании. Кратко расскажем о наших акциях, новинках ассортимента и неудержимся от
                                поздравления с главными праздниками.
                            </div>
                        </div>
                    </div>
                </div>
                <div class="col-lg-6 col-xs-12">
                    <form id="formSubscription" method="post" action="/" class="form">
                        <div class="loader">
                            <div class="three-bounce">
                                <div class="one"></div>
                                <div class="two"></div>
                                <div class="three"></div>
                            </div>
                        </div>
                        <div class="form-inner">
                            <div class="form-group">
                                <label class="form-group__label">Укажите ваш e-mail</label>
                                <input type="mail" name="mail" id="subscribe-email-field" required="required"
                                       class="form-control">
                                <input type="hidden" name="subscribeType" value="<?= $subscribeType ?>">
                                <div class="help-block"></div>
                            </div>
                            <div class="btn-and-info form-btn btn-and-info--reverse">
                                <button class="btn btn-primary">Подписаться на рассылку</button>
                                <span class="info">и всегда быть в курсе последних событий и акций компании</span>
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
