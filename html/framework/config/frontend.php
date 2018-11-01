<?php

$config = [
    'id' => 'web',
    'defaultRoute' => 'content/default/index',
    'on afterRequest' => function () {
        /**
         * see. https://content-security-policy.com/
         */
        Yii::$app->getResponse()->getHeaders()->add('Content-Security-Policy',
            'default-src \'self\';' .
            ' script-src \'self\' s.ytimg.com yastatic.net mc.yandex.ru api-maps.yandex.ru www.youtube.com ' .
            's.ytimg.com/yts/jsbin/www-widgetapi-vfluxKqfs/www-widgetapi.js ' .
            'https://*.maps.yandex.net ' .
            '\'unsafe-inline\' \'unsafe-eval\' https://geocode-maps.yandex.ru;' .
            ' connect-src \'self\' https://geocode-maps.yandex.ru https://translate.yandex.net/ http://freegeoip.net yastatic.net mc.yandex.ru;' .
            ' img-src \'self\' img.youtube.com api-maps.yandex.ru *.maps.yandex.net data:;' .
            ' style-src \'self\' \'unsafe-inline\' https://fonts.googleapis.com;' .
            ' font-src \'self\' https://fonts.googleapis.com https://fonts.gstatic.com; child-src \'self\' api-maps.yandex.ru www.youtube.com;'
        );
    },
    'modules' => [
        'content' => [
            'viewPath' => '@app/modules/content/views/frontend',
            'controllerNamespace' => 'krok\content\controllers\frontend',
        ],
        'feedback' => [
            'viewPath' => '@app/modules/feedback/views/frontend',
            'class' => 'app\modules\feedback\Module',
            'controllerNamespace' => 'app\modules\feedback\controllers\frontend',
        ],
        'menu' => [
            'viewPath' => '@app/modules/menu/views/frontend',
            'controllerNamespace' => 'app\modules\menu\controllers\frontend',
        ],
        'news' => [
            'viewPath' => '@app/modules/news/views/frontend',
            'class' => 'app\modules\news\Module',
            'controllerNamespace' => 'app\modules\news\controllers\frontend',
        ],
        'advice' => [
            'viewPath' => '@app/modules/advice/views/frontend',
            'class' => 'app\modules\advice\Module',
            'controllerNamespace' => 'app\modules\advice\controllers\frontend',
        ],
        'about' => [
            'viewPath' => '@app/modules/about/views/frontend',
            'class' => 'app\modules\about\Module',
            'controllerNamespace' => 'app\modules\about\controllers\frontend',
        ],
        'contact' => [
            'viewPath' => '@app/modules/contact/views/frontend',
            'class' => 'app\modules\contact\Module',
            'controllerNamespace' => 'app\modules\contact\controllers\frontend',
        ],
        'search' => [
            'viewPath' => '@app/modules/search/views/frontend',
            'class' => \krok\search\Module::class,
            'controllerNamespace' => 'app\modules\search\controllers\frontend',
        ],
        'wherebuy' => [
            'viewPath' => '@app/modules/wherebuy/views/frontend',
            'class' => 'app\modules\wherebuy\Module',
            'controllerNamespace' => 'app\modules\wherebuy\controllers\frontend',
        ],
        'product' => [
            'viewPath' => '@app/modules/product/views/frontend',
            'class' => 'app\modules\product\Module',
            'controllerNamespace' => 'app\modules\product\controllers\frontend',
        ],
        'lk' => [
            'viewPath' => '@app/modules/lk/views/frontend',
            'class' => 'app\modules\lk\Module',
            'controllerNamespace' => 'app\modules\lk\controllers\frontend',
        ],
        'rating' => [
            'class' => \app\modules\rating\Module::class,
            'viewPath' => '@app/modules/rating/views/frontend',
            'controllerNamespace' => 'app\modules\rating\controllers\frontend',
        ],
        'sked' => [
            'class' => \app\modules\sked\Module::class,
            'viewPath' => '@app/modules/sked/views/frontend',
            'controllerNamespace' => 'app\modules\sked\controllers\frontend',
        ],
    ],
    'components' => [
        'urlManager' => [
            'rules' => require(__DIR__ . DIRECTORY_SEPARATOR . 'frontend' . DIRECTORY_SEPARATOR . 'rules.php'),
        ],
        'assetManager' => [
            'class' => \yii\web\AssetManager::class,
            'appendTimestamp' => true,
            'dirMode' => 0755,
            'fileMode' => 0644,
            'bundles' => [
                \yii\web\JqueryAsset::class => [
                    'js' => [
                        YII_ENV_DEV ? 'jquery.js' : 'jquery.min.js',
                    ],
                ],
                \yii\bootstrap\BootstrapAsset::class => [
                    'sourcePath' => null,
                    'css' => [
                        YII_ENV_DEV ? '/static/asd/css/bootstrap.css' : '/static/asd/css/bootstrap.min.css',
                    ],
                ],
                \yii\bootstrap\BootstrapPluginAsset::class => [
                    'js' => [
                        YII_ENV_DEV ? 'js/bootstrap.js' : 'js/bootstrap.min.js',
                    ],
                ],
            ],
        ],
        'request' => [
            'class' => \krok\language\LanguageRequest::class,
            'cookieValidationKey' => hash('sha512', __FILE__ . __LINE__),
        ],
        'errorHandler' => [
            'class' => \krok\sentry\web\SentryErrorHandler::class,
            'errorAction' => 'content/default/error',
            'sentry' => \krok\sentry\Sentry::class,
        ],
    ],
];

if (YII_ENV_DEV) {
    // configuration adjustments for 'dev' environment
    $config['bootstrap'][] = 'debug';
    $config['modules']['debug'] = [
        'class' => \yii\debug\Module::class,
        'panels' => [
            'config' => false,
            'request' => [
                'class' => \yii\debug\panels\RequestPanel::class,
                'displayVars' => ['_GET', '_POST', '_COOKIE', '_SESSION', '_FILES'],
            ],
            'log' => [
                'class' => \yii\debug\panels\LogPanel::class,
            ],
            'profiling' => [
                'class' => \yii\debug\panels\ProfilingPanel::class,
            ],
            'db' => [
                'class' => \yii\debug\panels\DbPanel::class,
            ],
            'assets' => [
                'class' => \yii\debug\panels\AssetPanel::class,
            ],
            'mail' => [
                'class' => \yii\debug\panels\MailPanel::class,
            ],
            'timeline' => [
                'class' => \yii\debug\panels\TimelinePanel::class,
            ],
            'user' => [
                'class' => \yii\debug\panels\UserPanel::class,
                'ruleUserSwitch' => [
                    'allow' => true,
                    'roles' => ['@'],
                ],
            ],
            'router' => [
                'class' => \yii\debug\panels\RouterPanel::class,
            ],
        ],
        'allowedIPs' => [
            '*',
        ],
    ];
}

return \yii\helpers\ArrayHelper::merge(require(__DIR__ . DIRECTORY_SEPARATOR . 'common.php'), $config);
