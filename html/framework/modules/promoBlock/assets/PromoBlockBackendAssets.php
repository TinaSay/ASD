<?php
/**
 * Created by PhpStorm.
 * User: Rustam
 * Date: 03.11.2017
 * Time: 9:53
 */

namespace app\modules\promoBlock\assets;

use yii\web\AssetBundle;

/**
 * Class PromoBlockBackendAssets
 *
 * @package app\modules\promoBlock\assets
 */
class PromoBlockBackendAssets extends AssetBundle
{
    /**
     * @var string
     */
    public $sourcePath = '@app/modules/promoBlock/assets/dist';

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
        'js/promoBlock.js',
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
