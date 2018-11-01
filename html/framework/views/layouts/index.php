<?php
/**
 * Copyright (c) Rustam
 */

/* @var $this \yii\web\View */

/* @var $content string */

use app\assets\AppAsset;
use yii\helpers\Html;
use yii\helpers\Url;

AppAsset::register($this);
?>
<?php $this->beginPage() ?>
<!DOCTYPE html>
<html lang="<?= Yii::$app->language ?>">
<head>
    <meta charset="<?= Yii::$app->charset ?>">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">

    <?= Html::csrfMetaTags() ?>
    <title><?= Html::encode($this->title) ?></title>

    <link rel="icon" type="image/png" href="<?= Url::to(['/static/asd/favicon/favicon-16x16.png']) ?>" sizes="16x16">
    <link rel="icon" type="image/png" href="<?= Url::to(['/static/asd/favicon/favicon-32x32.png']) ?>" sizes="32x32">
    <link rel="icon" type="image/png" href="<?= Url::to(['/static/asd/favicon/favicon-36x36.png']) ?>" sizes="36x36">
    <link rel="icon" type="image/png" href="<?= Url::to(['/static/asd/favicon/favicon-48x48.png']) ?>" sizes="48x48">
    <link rel="icon" type="image/png" href="<?= Url::to(['/static/asd/favicon/favicon-96x96.png']) ?>" sizes="96x96">
    <link rel="icon" type="image/png" href="<?= Url::to(['/static/asd/favicon/favicon-192x192.png']) ?>" sizes="192x192">
    <link rel="apple-touch-icon" sizes="57x57" href="<?= Url::to(['/static/asd/favicon/apple-icon-57x57.png']) ?>">
    <link rel="apple-touch-icon" sizes="114x114" href="<?= Url::to(['/static/asd/favicon/apple-icon-114x114.png']) ?>">
    <link rel="apple-touch-icon" sizes="72x72" href="<?= Url::to(['/static/asd/favicon/apple-icon-72x72.png']) ?>">
    <link rel="apple-touch-icon" sizes="144x144" href="<?= Url::to(['/static/asd/favicon/apple-icon-144x144.png']) ?>">
    <link rel="apple-touch-icon" sizes="60x60" href="<?= Url::to(['/static/asd/favicon/apple-icon-60x60.png']) ?>">
    <link rel="apple-touch-icon" sizes="120x120" href="<?= Url::to(['/static/asd/favicon/apple-icon-120x120.png']) ?>">
    <link rel="apple-touch-icon" sizes="76x76" href="<?= Url::to(['/static/asd/favicon/apple-icon-76x76.png']) ?>">
    <link rel="apple-touch-icon" sizes="152x152" href="<?= Url::to(['/static/asd/favicon/apple-icon-152x152.png']) ?>">
    <link rel="apple-touch-icon" sizes="180x180" href="<?= Url::to(['/static/asd/favicon/apple-icon-180x180.png']) ?>">
    <meta name="msapplication-TileImage" content="<?= Url::to(['/static/asd/favicon/ms-icon-130x130.png']) ?>">

    <?php $this->head() ?>
</head>
<body id="cbp-so-scroller" class="main-page anim-load">
<?php $this->beginBody() ?>

<div class="load">
    <div class="three-bounce">
        <div class="one"></div>
        <div class="two"></div>
        <div class="three"></div>
    </div>
</div>

<?= $this->render('@app/views/layouts/partitials/header.php'); ?>
<?= $this->render('@app/views/layouts/partitials/fix-nav.php'); ?>

<!-- page -->
<div class="page">

    <?= $content ?>
    <?= $this->render('@app/views/layouts/partitials/footer.php'); ?>

</div><!-- /.page -->

<div class="site-overlay"></div>

<!-- modal -->
<div id="modal-ctrl-enter" class="modal fade blue-bg" role="dialog">
    <div class="modal-dialog">
        <div class="modal-content">
            <div class="modal-header">
                <button type="button" class="close" data-dismiss="modal">&times;</button>
                <div class="modal-title">Отправка сообщения об ошибке на странице.</div>
            </div>
            <div class="modal-body">
                <form method="post">
                    <div class="error-message"></div>
                    <div class="form-group form-group--row">
                        <div class="name-left">URL страницы</div>
                        <input id="ctrlEnterUrl" type="text" class="form-control gray" value="" disabled>
                    </div>
                    <div class="form-group form-group--row">
                        <div class="name-left">Ошибка</div>
                        <textarea id="ctrlEnterText" class="form-control" disabled></textarea>
                    </div>
                    <div class="form-group form-group--row">
                        <div class="name-left"></div>
                        <div>
                            <button type="submit" class="btn btn-primary">Отправить</button>
                            <span class="cancel" data-dismiss="modal">Отменить</span>
                        </div>
                    </div>
                </form>
            </div>
        </div>
    </div>
</div>
<!-- end modal -->

<?= $this->render('@app/views/layouts/partitials/layers.php'); ?>

<?php $this->endBody() ?>
</body>
</html>
<?php $this->endPage() ?>
