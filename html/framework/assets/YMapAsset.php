<?php
/**
 * Created by PhpStorm.
 * User: elfuvo
 * Date: 01.05.18
 * Time: 11:46
 */

namespace app\assets;

use yii\web\AssetBundle;
use yii\web\JqueryAsset;

/**
 * Class YMapAsset
 *
 * @package app\assets
 */
class YMapAsset extends AssetBundle
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
    public $js = [
        'js/map.js',
    ];

    /**
     * @var array
     */
    public $depends = [
        JqueryAsset::class,
    ];
}