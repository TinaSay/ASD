<?php
/**
 * Created by PhpStorm.
 * User: Rustam
 * Date: 03.11.2017
 * Time: 9:53
 */

namespace app\modules\contact\assets;

use yii\web\AssetBundle;

/**
 * Class ContactSettingAssets
 *
 * @package app\modules\contact\assets
 */
class ContactSettingAssets extends AssetBundle
{
    /**
     * @var string
     */
    public $sourcePath = '@app/modules/contact/assets/dist';

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

    ];

    /**
     * @var array
     */
    public $js = [
        'js/jQuery.migrate-3.0.js',
        'js/window.cookie.js',
        'js/contact.setting.js',

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
