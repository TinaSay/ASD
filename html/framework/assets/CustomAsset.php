<?php
/**
 * @link http://www.yiiframework.com/
 * @copyright Copyright (c) 2008 Yii Software LLC
 * @license http://www.yiiframework.com/license/
 */

namespace app\assets;

use yii\web\{
    AssetBundle
};

/**
 * @author Qiang Xue <qiang.xue@gmail.com>
 * @since 2.0
 */
class CustomAsset extends AssetBundle
{
    /**
     * @var string
     */
    public $basePath = '@webroot/static/default';

    /**
     * @var string
     */
    public $baseUrl = '@web';

    /**
     * @var array
     */
    public $css = [
        'css/custom.css',
    ];

    /**
     * @var array
     */
    public $js = [];

    /**
     * @var array
     */
    public $depends = [
        'krok\paperDashboard\assets\ThemifyIconsAsset'
    ];
}
