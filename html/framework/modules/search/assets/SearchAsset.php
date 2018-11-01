<?php

namespace app\modules\search\assets;

use yii\web\AssetBundle;

/**
 * Class NewsAssets
 *
 * @package app\modules\news\assets
 */
class SearchAsset extends AssetBundle
{
    /**
     * @var string
     */
    public $sourcePath = '@app/modules/search/assets/dist';

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
        'js/search.js',
    ];

    /**
     * @var array
     */
    public $depends = [
        'yii\web\JqueryAsset',
    ];
}
