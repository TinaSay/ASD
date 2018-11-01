<?php
/**
 * Created by PhpStorm.
 * User: Rustam
 * Date: 03.11.2017
 * Time: 9:53
 */

namespace app\modules\feedback\assets;

use krok\extend\widgets\YMap\YMapWidgetAsset;
use yii\web\AssetBundle;

/**
 * Class FeedbackAssets
 *
 * @package app\modules\feedback\assets
 */
class FeedbackAssets extends AssetBundle
{
    /**
     * @var string
     */
    public $sourcePath = '@app/modules/feedback/assets/dist';

    /**
     * @var array
     */
    public $publishOptions = [
        'forceCopy' => YII_ENV_DEV,
    ];

    /**
     * @var array
     */
    public $css = [];

    /**
     * @var array
     */
    public $js = [
        'js/feedback.js',
        'js/window.cookie.js',
    ];

    /**
     * @var array
     */
    public $depends = [
        'yii\web\YiiAsset',
        'yii\bootstrap\BootstrapAsset',
        'yii\web\JqueryAsset',
        YMapWidgetAsset::class,
    ];
}
