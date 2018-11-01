<?php

use yii\helpers\Html;
use yii\helpers\Url;


/* @var $this \yii\web\View view component instance */
/* @var $message \yii\mail\BaseMessage instance of newly created mail message */
/* @var $model \app\modules\feedback\models\Feedback */

?>
<h2>Здравствуйте!</h2>

<p>На сайте www.asdcompany.ru <?=Yii::$app->getFormatter()->asDatetime($model->date_add);?> заполнили форму обратной связи.</p>

<p>Данные отправителя заявки:</p>

<p>Имя: <?=$model->fio?></p>
<p>Телефон: <?=$model->phone?></p>
<p>E-mail: <?=$model->email?></p>
<p>Компания: <?=$model->company?></p>
<p>Город: <?=$model->city?></p>
<p>Текст сообщения:</p>
<p><?=$model->text?></p>

<p>С уважением, <br>команда компании ASD.</p>
<p><?= Html::a('www.asdcompany.ru', Url::home('http')) ?></p>

