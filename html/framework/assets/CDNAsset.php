<?php
/**
 * Created by PhpStorm.
 * User: krok
 * Date: 15.12.16
 * Time: 16:09
 */

namespace app\assets;

use yii\web\AssetBundle;
use yii\web\View;

/**
 * Class CDNAsset
 *
 * @package app\assets
 */
class CDNAsset extends AssetBundle
{
    /**
     * @var array
     */
    public $js = [
        'https://oss.maxcdn.com/html5shiv/3.7.2/html5shiv.min.js',
        'https://oss.maxcdn.com/respond/1.4.2/respond.min.js',
    ];

    /**
     * @var array
     */
    public $jsOptions = [
        'condition' => 'lt IE 9',
        'position' => View::POS_HEAD,
    ];
}
