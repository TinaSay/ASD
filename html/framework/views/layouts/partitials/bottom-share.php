<?php
/**
 * Created by PhpStorm.
 * User: elfuvo
 * Date: 12.02.18
 * Time: 14:27
 */

use yii\helpers\ArrayHelper;
use yii\helpers\Html;

/* @var $this \yii\web\View */
?>
<div class="btn-back-and-net__right">
    <div class="share-block">
        <script src="//yastatic.net/es5-shims/0.0.2/es5-shims.min.js"></script>
        <script src="//yastatic.net/share2/share.js"></script>
        <div class="share-block__title">Поделиться</div>
        <div class="ya-share2" data-services="vkontakte,facebook,twitter,odnoklassniki"
             data-title="<?= Html::encode(ArrayHelper::getValue(Yii::$app->params, 'title', '')) ?>"></div>
    </div>
</div>
