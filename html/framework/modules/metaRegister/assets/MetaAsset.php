<?php
/**
 * Created by PhpStorm.
 * User: elfuvo
 * Date: 30.11.17
 * Time: 15:48
 */

namespace app\modules\metaRegister\assets;

use yii\bootstrap\BootstrapAsset;
use yii\web\AssetBundle;
use yii\web\JqueryAsset;

/**
 * Class MetaAsset
 *
 * @package tina\metatag\assets
 */
class MetaAsset extends AssetBundle
{
    /**
     * @var string
     */
    public $sourcePath = __DIR__ . '/dist';

    /**
     * @var array
     */
    public $js = [
        'metatag.js',
    ];

    /**
     * @var array
     */
    public $depends = [
        JqueryAsset::class,
        BootstrapAsset::class,
    ];
}