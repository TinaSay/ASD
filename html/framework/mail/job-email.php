<?php

/** @var \app\modules\packet\models\Packet $model */
?>

<div>
    <p><?= $model->text ?></p>
    <p></p>
    <div style="color: #7F7F7F ">Вы можете в любой момент <a style="color: #8E8E8E" href="<?= $unsubscribeUrl ?>"
                                                             target="_blank">отписаться</a> от нашей рассылки.

        <p>С уважением, <br>команда компании ASD.</p>
        <p><?= Html::a('www.asdcompany.ru', Url::home('http')) ?></p>
    </div>
</div>


