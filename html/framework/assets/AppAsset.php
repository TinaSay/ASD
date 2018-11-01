<?php
/**
 * @link http://www.yiiframework.com/
 * @copyright Copyright (c) 2008 Yii Software LLC
 * @license http://www.yiiframework.com/license/
 */

namespace app\assets;

use app\modules\feedback\assets\FeedbackAssets;
use yii\bootstrap\BootstrapAsset;
use yii\bootstrap\BootstrapPluginAsset;
use yii\web\AssetBundle;
use yii\web\JqueryAsset;

/**
 * @author Qiang Xue <qiang.xue@gmail.com>
 * @since 2.0
 */
class AppAsset extends AssetBundle
{
    /**
     * @var string
     */
    public $basePath = '@webroot/static/asd/';

    /**
     * @var string
     */
    public $baseUrl = '@web/static/asd/';

    /**
     * @var array
     */
    public $css = [
        'https://fonts.googleapis.com/css?family=PT+Sans&amp;subset=cyrillic',
        'css/css.css',
        'css/icon.css',
        'css/styles.css',
        'css/site.css',
        'css/jquery.fancybox.min.css',
        'css/animate.css',
    ];

    /**
     * @var array
     */
    public $js = [
        'js/jquery-ui.js',
        'js/scripts.js',
        'js/jquery.touchSwipe.min.js',
        'js/zebra_datepicker.src.js',
        'js/iscroll.js',
        'js/inputmask.js',
        'js/jquery.inputmask.js',
        'js/jquery.validate.js',
        'js/jquery.validate.ru.js',
        'js/jquery.validate.site.js',
        'js/drawer.js',
        'js/jquery.ba-cond.min.js',
        'js/jquery.slitslider.js',
        'js/pushy.js',
        'js/snap.svg-min.js',
        'js/jquery.fancybox.min.js',
        'js/site.js',
    ];

    /**
     * @var array
     */
    public $depends = [
        JqueryAsset::class,
        BootstrapAsset::class,
        BootstrapPluginAsset::class,
        CDNAsset::class,
        FeedbackAssets::class,
    ];
}
