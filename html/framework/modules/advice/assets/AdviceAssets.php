<?php
/**
 * Created by PhpStorm.
 * User: Rustam
 * Date: 03.11.2017
 * Time: 9:53
 */

namespace app\modules\advice\assets;

use yii\web\AssetBundle;

/**
 * Class adviceAssets
 *
 * @package app\modules\advice\assets
 */
class AdviceAssets extends AssetBundle
{
    /**
     * @var string
     */
    public $sourcePath = '@app/modules/advice/assets/dist';

    /**
     * @var array
     */
    public $publishOptions = [
        'forceCopy' => YII_DEBUG,
    ];

    /**
     * @var array
     */
    public $css = [];

    /**
     * @var array
     */
    public $js = [
        'js/subscribe.js',
        'js/window.cookie.js',
    ];

    /**
     * @var array
     */
    public $depends = [
        'yii\web\YiiAsset',
        'yii\bootstrap\BootstrapAsset',
        'yii\web\JqueryAsset',
    ];
}
