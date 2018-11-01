<?php

use yii\helpers\Html;
use yii\helpers\Url;


/* @var $this \yii\web\View view component instance */
/* @var $message \yii\mail\BaseMessage instance of newly created mail message */
/* @var $model \app\modules\feedback\models\Feedback */

?>
<h2>Здравствуйте!</h2>

<p>На сайте www.asdcompany.ru в <?= Yii::$app->getFormatter()->asDatetime($model->date_add); ?> оставили заявку на
    товар.</p>

<p>Данные отправителя заявки:</p>

<p>Имя: <?= $model->fio ?></p>
<p>Телефон: <?= $model->phone ?></p>
<p>Страна: <?= $model->country; ?></p>
<p>Город: <?= $model->city; ?></p>
<?php if ($model->product): ?>
    <p>
        <a href="<?= Url::to([
            '/product/catalog/view',
            'alias' => $model->product->alias,
        ], true) ?>"><?= Url::to([
                '/product/catalog/view',
                'alias' => $model->product->alias,
            ], true); ?></a>
    </p>
<?php endif; ?>

<p>С уважением, <br>команда компании ASD.</p>
<p><?= Html::a('www.asdcompany.ru', Url::home('http')) ?></p>

