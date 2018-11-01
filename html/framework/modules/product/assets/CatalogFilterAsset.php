<?php
/**
 * Created by PhpStorm.
 * User: elfuvo
 * Date: 12.02.18
 * Time: 14:59
 */

namespace app\modules\product\assets;

use app\assets\AppAsset;
use yii\web\AssetBundle;

class CatalogFilterAsset extends AssetBundle
{

    /**
     * @var string
     */
    public $sourcePath = '@app/modules/product/assets/dist';

    /**
     * @var array
     */
    public $js = [
        'catalog-filter.js',
    ];

    /**
     * @var array
     */
    public $depends = [
        AppAsset::class,
    ];
}