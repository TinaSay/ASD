<?php
/**
 * Created by PhpStorm.
 * User: Rustam
 * Date: 03.11.2017
 * Time: 9:53
 */

namespace app\modules\packet\assets;

use yii\web\AssetBundle;

/**
 * Class NewsAssets
 *
 * @package app\modules\news\assets
 */
class PacketAssets extends AssetBundle
{
    /**
     * @var string
     */
    public $sourcePath = '@app/modules/packet/assets/dist';

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
        'js/jQuery.migrate-3.0.js',
        'js/window.cookie.js',
        'js/packet.backend.js',

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
