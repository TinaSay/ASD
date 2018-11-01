<?php
/**
 * Created by PhpStorm.
 * User: krok
 * Date: 04.06.17
 * Time: 18:36
 */

/* @var $this yii\web\View */

/* @var $content string */

use krok\extend\widgets\alert\AlertWidget;
use krok\paperDashboard\assets\PaperDashboardAsset;
use krok\paperDashboard\assets\ThemifyIconsAsset;
use krok\paperDashboard\widgets\menu\MenuWidget;
use yii\helpers\ArrayHelper;
use yii\helpers\Html;
use yii\helpers\Url;
use yii\web\YiiAsset;

PaperDashboardAsset::register($this);
ThemifyIconsAsset::register($this);
YiiAsset::register($this);
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
    <style>@media (max-width: 1600px) {
            .navbar-default .navbar-brand:before {
                content: 'Перейти на сайт';
                display: inline;
            }
        }</style>
</head>
<body>
<?php $this->beginBody() ?>
<div class="wrapper">
    <div class="sidebar" data-background-color="blue" data-active-color="danger">
        <div class="logo">
            <a href="<?= Url::to(['/']) ?>" class="simple-text logo-mini">
                <?= Html::img('/static/asd/img/logo-text.svg', ['alt' => 'Лого', 'height' => 40]) ?>
            </a>
            <a href="<?= Url::to(['/']) ?>" class="simple-text logo-normal"></a>
        </div>
        <div class="sidebar-wrapper">
            <ul class="nav">
                <div class="user">
                    <div class="photo"></div>
                    <div class="info">
                        <li>
                            <a data-toggle="collapse" href="#profile" class="collapsed">
                                <p>
                                    <?= ArrayHelper::getValue(Yii::$app->getUser()->getIdentity(), 'login') ?>
                                    <b class="caret"></b>
                                </p>
                            </a>
                            <div class="clearfix"></div>
                            <div class="collapse" id="profile">
                                <ul class="nav">
                                    <li>
                                        <a href="<?= Url::to(['/auth/profile']) ?>">
                                            <p class="sidebar-normal">
                                                Мой профиль
                                            </p>
                                            <i class="ti-angle-right"></i>
                                        </a>
                                    </li>
                                    <li>
                                        <a href="<?= Url::to(['/auth/default/logout']) ?>">
                                            <p class="sidebar-normal">
                                                Выход
                                            </p>
                                            <i class="ti-angle-right"></i>
                                        </a>
                                    </li>
                                </ul>
                            </div>
                        </li>
                    </div>
                </div>
            </ul>

            <?= MenuWidget::widget([
                'items' => ArrayHelper::getValue(Yii::$app->params, ['menu']),
            ]) ?>

        </div>
    </div>

    <div class="main-panel">
        <nav class="navbar navbar-default">
            <div class="container-fluid">
                <div class="navbar-minimize">
                    <button id="minimizeSidebar" class="btn btn-fill btn-icon"><i class="ti-more-alt"></i></button>
                </div>
                <div class="navbar-header">
                    <button type="button" class="navbar-toggle">
                        <span class="sr-only">Toggle navigation</span>
                        <span class="icon-bar bar1"></span>
                        <span class="icon-bar bar2"></span>
                        <span class="icon-bar bar3"></span>
                    </button>
                    <a class="navbar-brand btn-magnify" target="_blank" href="/">
                        <span class="full-name">Перейти на сайт</span>
                        <i class="ti-new-window"></i>
                    </a>
                </div>
                <div class="collapse navbar-collapse">
                    <!--<form class="navbar-form navbar-left navbar-search-form" role="search">
                        <div class="input-group">
                            <input type="text" value="" class="form-control" placeholder="Поиск...">
                            <span class="input-group-addon btn-magnify"><i class="fa fa-search"></i></span>
                        </div>
                    </form>-->
                    <ul class="nav navbar-nav navbar-right header__navbar-right">
                        <li class="dropdown">
                            <a href="#stats" class="dropdown-toggle btn-magnify" data-toggle="dropdown">
                                <i class="ti-panel"></i>
                                <p class="hidden-text-nav">Администрирование</p>
                                <b class="caret"></b>
                            </a>
                            <ul class="dropdown-menu">
                                <li>
                                    <a href="<?= Url::to(['/auth/auth']) ?>">Учетные записи</a>
                                </li>

                                <li>
                                    <a href="<?= Url::to(['/auth/log']) ?>">Журнал</a>
                                </li>
                            </ul>
                        </li>
                        <li class="dropdown">
                            <a href="#settings" class="btn-magnify dropdown-toggle" data-toggle="dropdown">
                                <i class="ti-settings"></i>
                                <p class="hidden-text-nav">
                                    Системные
                                </p>
                                <b class="caret"></b>
                            </a>
                            <ul class="dropdown-menu">
                                <li>
                                    <a href="<?= Url::to(['/system/default/flush-cache']) ?>">Очистить кэш</a>
                                </li>
                                <li>
                                    <a href="<?= Url::to(['/configure/default']) ?>">Настройки</a>
                                </li>
                            </ul>
                        </li>
                        <li class="header-out">
                            <a class="btn-magnify" href="<?= Url::to(['/auth/default/logout']) ?>">
                                <i class="ti-shift-left"></i>
                                <p class="hidden-text-nav">Выход</p>
                            </a>
                        </li>
                    </ul>
                    <? /* LanguageWidget::widget([
                        'options' => [
                            'class' => 'nav navbar-nav navbar-right header__navbar-right',
                        ],
                    ]) */ ?>
                </div>
            </div>
        </nav>

        <div class="content">
            <div class="container-fluid">
                <div class="row">
                    <div class="col-md-12">
                        <?= AlertWidget::widget() ?>
                        <?= $content ?>
                    </div>
                </div>
            </div>
        </div>

        <footer class="footer">
            <div class="container-fluid">
                <nav class="pull-left">
                    <ul>
                        <li>
                            © 2016–<?= (new DateTime())->format('Y') ?> Поддержка сайта и системы управления – <a
                                    style="margin-left:5px;float: right;" href="//nsign.ru">«<span
                                        style="text-decoration: underline;">Энсайн</span>»</a>
                        </li>
                    </ul>
                </nav>
            </div>
        </footer>
    </div>
</div>
<?php $this->endBody() ?>

<script type="application/javascript">

    jQuery(document).ready(function () {

        /*  **************** Views  - barchart ******************** */
        var dataViews = {
            labels: ['21.07', '22.07', '23.07', '24.07', '25.07', '26.07', '27.07', '28.07', '29.07', '30.07'],
            series: [
                [600, 410, 323, 520, 780, 552, 759, 650, 290, 326]
            ]
        };

        var optionsViews = {
            seriesBarDistance: 10,
            classNames: {
                bar: 'ct-bar'
            },
            axisX: {
                showGrid: false

            },
            height: "250px"

        };

        var responsiveOptionsViews = [
            ['screen and (max-width: 640px)', {
                seriesBarDistance: 5,
                axisX: {
                    labelInterpolationFnc: function (value) {
                        return value[0];
                    }
                }
            }]
        ];

        if (jQuery('#chartViews').length > 0) {
            Chartist.Bar('#chartViews', dataViews, optionsViews, responsiveOptionsViews);
        }

        //  multiple bars chart
        var data = {
            labels: ['02/2017', '03/2017', '04/2017', '05/2017', '06/2017', '07/2017'],
            series: [
                [28, 45, 78, 57, 68, 89],
                [11, 17, 45, 28, 33, 56]
            ]
        };

        var options = {
            seriesBarDistance: 10,
            axisX: {
                showGrid: false
            },
            height: "245px"
        };

        var responsiveOptions = [
            ['screen and (max-width: 640px)', {
                seriesBarDistance: 5,
                axisX: {
                    labelInterpolationFnc: function (value) {
                        return value[0];
                    }
                }
            }]
        ];

        if (jQuery('#chartActivity').length > 0) {
            Chartist.Line('#chartActivity', data, options, responsiveOptions);
        }

        jQuery('#chartDashboard').easyPieChart({
            lineWidth: 6,
            size: 160,
            scaleColor: false,
            trackColor: 'rgba(255,255,255,.25)',
            barColor: '#FFFFFF',
            animate: ({duration: 5000, enabled: true})
        });

        jQuery('.scroll-content').perfectScrollbar();

    });

</script>
</body>
</html>
<?php $this->endPage() ?>
