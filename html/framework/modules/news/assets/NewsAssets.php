<?php
/**
 * Created by PhpStorm.
 * User: Rustam
 * Date: 03.11.2017
 * Time: 9:53
 */

namespace app\modules\news\assets;

use yii\web\AssetBundle;

/**
 * Class NewsAssets
 *
 * @package app\modules\news\assets
 */
class NewsAssets extends AssetBundle
{
    /**
     * @var string
     */
    public $sourcePath = '@app/modules/news/assets/dist';

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
