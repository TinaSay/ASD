<?php
/**
 * Created by PhpStorm.
 * User: Rustam
 * Date: 03.11.2017
 * Time: 9:53
 */

namespace app\modules\contact\assets;

use app\assets\AppAsset;
use krok\extend\widgets\YMap\YMapWidgetAsset;
use yii\web\AssetBundle;

/**
 * Class NewsAssets
 *
 * @package app\modules\news\assets
 */
class ContactAssets extends AssetBundle
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
    public $css = [];

    /**
     * @var array
     */
    public $js = [
        // 'js/jQuery.migrate-3.0.js',
        'js/window.cookie.js',
        'js/snap.svg-min.js',
        'js/contact.js',

    ];

    /**
     * @var array
     */
    public $depends = [
        AppAsset::class,
        YMapWidgetAsset::class,
    ];
}
