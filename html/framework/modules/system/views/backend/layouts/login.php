<?php
/**
 * Created by PhpStorm.
 * User: krok
 * Date: 04.06.17
 * Time: 18:35
 */

/* @var $this yii\web\View */

/* @var $content string */

use krok\paperDashboard\assets\PaperDashboardAsset;
use krok\paperDashboard\assets\ThemifyIconsAsset;
use yii\helpers\Html;

PaperDashboardAsset::register($this);
ThemifyIconsAsset::register($this);
?>
<?php $this->beginPage() ?>
<!DOCTYPE html>
<html lang="<?= Yii::$app->language ?>">
<head>
    <meta charset="<?= Yii::$app->charset ?>"/>
    <meta http-equiv="X-UA-Compatible" content="IE=edge,chrome=1"/>
    <title><?= Html::encode($this->title) ?></title>
    <meta content="width=device-width, initial-scale=1.0, maximum-scale=1.0, user-scalable=0" name="viewport"/>
    <meta name="viewport" content="width=device-width"/>
    <?= Html::csrfMetaTags() ?>
    <?php $this->head() ?>
</head>
<body>
<?php $this->beginBody() ?>

<div class="wrapper wrapper-full-page">
    <div class="full-page login-page" data-color="blue" data-image="">
        <!--   you can change the color of the filter page using: data-color="blue | azure | green | orange | red | purple" -->
        <div class="content">
            <?= $content ?>
        </div>

        <footer class="footer footer-transparent">
            <div class="container">
                <div class="copyright">
                    © 2016–<?= (new DateTime())->format('Y') ?> Поддержка сайта и системы управления – <a href="//nsign.ru">«<span style="text-decoration: underline;">Энсайн</span>»</a>
                </div>
            </div>
        </footer>

    </div>
</div>
<?php $this->endBody() ?>
</body>
</html>
<?php $this->endPage() ?>
