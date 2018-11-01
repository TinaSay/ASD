<?php
/**
 * Created by PhpStorm.
 * User: elfuvo
 * Date: 14.02.18
 * Time: 10:11
 */

namespace app\modules\product\assets;


use app\assets\AppAsset;
use yii\web\AssetBundle;

class ProductRelatedAsset extends AssetBundle
{

    /**
     * @var string
     */
    public $sourcePath = '@app/modules/product/assets/dist';

    /**
     * @var array
     */
    public $js = [
        'related.js',
    ];

    /**
     * @var array
     */
    public $depends = [
        AppAsset::class,
    ];
}