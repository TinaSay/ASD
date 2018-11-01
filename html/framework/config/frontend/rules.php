<?php
/**
 * Created by PhpStorm.
 * User: krok
 * Date: 09.02.17
 * Time: 16:31
 */

return [
    /**
     * Glide
     */
    'render/<path:[\w\/\.]+>' => 'glide/default/render',
    /**
     * Content
     */
    '<language:\w+\-\w+>/content/<alias:[\w\-]+>' => 'content/default/index',
    /**
     * Правила из Каталога
     */
    [
        'class' => 'yii\web\UrlRule',
        'pattern' => '<language:\w+\-\w+>/product/<alias:([\w\d\-\_]+)>',
        'route' => 'product/catalog/view',
    ],
    [
        'class' => 'app\modules\product\rules\ProductUrlRule',
        'pattern' => '<language:\w+\-\w+>/<basePath:(catalog|buyer/catalog|buyer' .
            '|retail/catalog|retail|wholesale/catalog|wholesale' .
            '|manufacturer/catalog|manufacturer+)>/?<path:(.+)?>',
        'route' => '',
    ],
    /**
     * Правила из Menu
     */
    [
        'class' => 'app\modules\menu\rules\MenuUrlRule',
        'pattern' => '<language:\w+\-\w+>/<path:(?!cp\/).+>',
        'route' => '',
    ],
    /**
     * Search
     */
    '<language:\w+\-\w+>/search/<p:\d+>/<per:\d+>' => '/search/default/index',
    '<language:\w+\-\w+>/search/<p:\d+>' => '/search/default/index',

    /**
     * System
     */
    '<language:\w+\-\w+>' => '/',
    '<language:\w+\-\w+>/<module:[\w\-]+>' => '<module>',
    '<language:\w+\-\w+>/<module:[\w\-]+>/<controller:[\w\-]+>' => '<module>/<controller>',
    '<language:\w+\-\w+>/<module:[\w\-]+>/<controller:[\w\-]+>/<action:[\w\-]+>/<p:\d+>/<per:\d+>' => '<module>/<controller>/<action>',
    '<language:\w+\-\w+>/<module:[\w\-]+>/<controller:[\w\-]+>/<action:[\w\-]+>/<id:\d+>' => '<module>/<controller>/<action>',
    '<language:\w+\-\w+>/<module:[\w\-]+>/<controller:[\w\-]+>/<action:[\w\-]+>' => '<module>/<controller>/<action>',
];
