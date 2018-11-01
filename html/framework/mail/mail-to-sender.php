<?php

use yii\helpers\Html;
use yii\helpers\Url;

/* @var $this \yii\web\View view component instance */

?>
<h2>Здравствуйте!</h2>

<p>Ваш адрес был указан на нашем сайте <?= Html::a('www.asdcompany.ru', Url::home('http')) ?> для получения
    информационных рассылок.</p>
<p>Благодарим вас за проявленный интерес и доверие к нашей компании!</p>
<p>Если вы не подписывались на рассылку или передумали получать наши письма, то просто нажмите <a style="color: #8E8E8E"
                                                                                                  href="<?= $unsubscribeUrl ?>"
                                                                                                  target="_blank">здесь</a>.
</p>
<p>С уважением, <br>команда компании ASD.</p>
<p><?= Html::a('www.asdcompany.ru', Url::home('http')) ?></p>

