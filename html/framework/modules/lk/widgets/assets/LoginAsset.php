<?php

namespace app\modules\lk\widgets\assets;

use yii\web\AssetBundle;
use yii\web\JqueryAsset;

/**
 * Class LoginAsset
 * @package app\modules\lk\widgets\assets
 */
class LoginAsset extends AssetBundle
{
    /**
     * @var string
     */
    public $sourcePath = '@app/modules/lk/widgets/assets/dist';


    /**
     * @var array
     */
    public $publishOptions = [
        'forceCopy' => YII_DEBUG
    ];

    public $css = [
        'login.css'
    ];

    /**
     * @var array
     */
    public $js = [
        'login.js'
    ];

    /**
     * @var array
     */
    public $depends = [
        JqueryAsset::class,
    ];
}
