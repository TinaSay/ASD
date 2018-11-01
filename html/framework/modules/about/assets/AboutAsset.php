<?php

namespace app\modules\about\assets;

use yii\web\AssetBundle;

class AboutAsset extends AssetBundle
{
    /**
     * @var string
     */
    public $sourcePath = '@app/modules/about/assets/dist';

    /**
     * @var array
     */
    public $js = [
        '//www.youtube.com/player_api',
        'js/about.js',
    ];

    /**
     * @var array
     */
    public $css = [];
    
    public $publishOptions = [
        'forceCopy' => YII_ENV_DEV,
    ];

    /**
     * @var array
     */
    public $depends = [
        'app\assets\AppAsset',
    ];
}
