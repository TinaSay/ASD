<?php

namespace app\modules\rating\widgets;

use yii\web\AssetBundle;
use app\assets\AppAsset;

/**
 * Class RatingAsset
 * @package app\modules\rating\widgets\assets
 */
class RatingAsset extends AssetBundle
{
    /**
     * @var string
     */
    public $sourcePath = '@app/modules/rating/widgets/assets';

    /**
     * @var array
     */
    public $publishOptions = [
        'forceCopy' => YII_DEBUG,
    ];

    public $css = [
        'star.css',
    ];

    /**
     * @var array
     */
    public $js = [
        'starwarsjs.js',
        'rating.js',
    ];

    /**
     * @var array
     */
    public $depends = [
        AppAsset::class,
    ];
}
