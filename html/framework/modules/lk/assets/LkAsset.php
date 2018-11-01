<?php
namespace app\modules\lk\assets;

use app\assets\AppAsset;
use yii\web\AssetBundle;

class LkAsset extends AssetBundle
{

    public $sourcePath = '@app/modules/lk/assets/dist/';

    /**
     * @var array
     */
    public $js = [
        'lk.js',
    ];

    /**
     * @var array
     */
    public $depends = [
        AppAsset::class,
    ];
}