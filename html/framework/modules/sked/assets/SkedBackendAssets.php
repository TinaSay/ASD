<?php
/**
 * Created by PhpStorm.
 * User: Rustam
 * Date: 03.11.2017
 * Time: 9:53
 */

namespace app\modules\sked\assets;

use yii\web\AssetBundle;

/**
 * Class SkedBackendAssets
 *
 * @package app\modules\sked\assets
 */
class SkedBackendAssets extends AssetBundle
{
    /**
     * @var string
     */
    public $sourcePath = '@app/modules/sked/assets/dist';

    /**
     * @var array
     */
    public $publishOptions = [
        'forceCopy' => YII_ENV_DEV,
    ];

    /**
     * @var array
     */
    public $css = [
        'css/sked.backend.css',
    ];

    /**
     * @var array
     */
    public $js = [
        'js/sked.backend.js',
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
