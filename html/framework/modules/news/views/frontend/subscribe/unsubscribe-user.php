<?php
/**
 * Created by PhpStorm.
 * User: Rustam
 * Date: 13.05.2018
 * Time: 22:56
 */

use app\modules\news\assets\NewsAssets;
use yii\helpers\Url;

$bundle = NewsAssets::register($this);

/** @var \app\modules\news\models\Subscribe|\app\modules\feedback\models\Feedback $model */
/** @var \app\modules\packet\models\Packet $packet */

$this->title = "Вы отписаны от наших рассылок";

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
                    <p>Искренне жаль, что наши рассылки не оказались вам полезны. </p>
                    <p>Будем рады, если увидем вас снова среди наших подписчиков.</p>
                    <p><a href="<?= Url::home(); ?>">Перейти на главную страницу</a></p>
                </div>
            </div>
        </div>
    </div>

</section>