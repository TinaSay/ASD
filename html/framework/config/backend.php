<?php

$config = [
    'id' => 'web',
    'defaultRoute' => 'system',
    'as beforeRequest' => [
        'class' => \krok\system\components\backend\AccessControl::class,
        'except' => [
            'gii/*',
            'debug/*',
            'auth/default/oauth',
            'auth/default/login',
            'auth/default/logout',
            'auth/default/captcha',
        ],
    ],
    'on afterRequest' => function () {
        /**
         * see. https://content-security-policy.com/
         */
        Yii::$app->getResponse()->getHeaders()->add('Content-Security-Policy',
            'default-src \'none\'; media-src \'self\' blob:;  script-src \'self\' \'unsafe-inline\' \'unsafe-eval\'; connect-src \'self\' geocode-maps.yandex.ru; img-src \'self\' data: blob:; style-src \'self\' \'unsafe-inline\' fonts.googleapis.com maxcdn.bootstrapcdn.com; font-src \'self\' fonts.gstatic.com maxcdn.bootstrapcdn.com data:; child-src \'self\' ;frame-src \'self\' youtube.com *.youtube.com;');
    },
    'container' => [
        'definitions' => [
            \yii\captcha\CaptchaAction::class => [
                'backColor' => 0xf3f3f5,
            ],
            \krok\editor\interfaces\EditorInterface::class => \krok\tinymce\TinyMceWidget::class,
            \krok\tinymce\TinyMceWidget::class => [
                'clientOptions' => [
                    'branding' => false,
                    'menubar' => false,
                    'language' => 'ru',
                    'height' => 600,
                    'plugins' => [
                        'advlist',
                        'anchor',
                        'charmap',
                        'code',
                        'textcolor',
                        'colorpicker',
                        'media',
                        'image',
                        'hr',
                        'insertdatetime',
                        'link',
                        'lists',
                        'nonbreaking',
                        'paste',
                        'print',
                        'searchreplace',
                        'spellchecker',
                        'table',
                        'template',
                        'visualblocks',
                        'visualchars',
                        // passive
                        'autolink',
                        'contextmenu',
                        'imagetools',
                        'wordcount',
                    ],
                    'external_plugins' => [
                        'easyfileupload' => 'easyfileupload',
                    ],
                    'toolbar1' => implode(' | ', [
                        'formatselect',
                        'bold italic underline',
                        'alignleft aligncenter alignright alignjustify',
                        'outdent indent',
                        'table',
                        'link unlink',
                        'easyfileupload image media',
                        'code',
                        'undo redo',
                    ]),

                    'insertdatetime_formats' => [
                        '%H:%M',
                        '%d.%m.%Y',
                    ],
                    'templates' => [
                        [
                            'title' => 'NSign',
                            'description' => 'NSign',
                            'content' => '<a href="http://www.nsign.ru" target="_blank">NSign</a>',
                        ],
                    ],
                    'spellchecker_languages' => 'Russian=ru,English=en',
                    'spellchecker_language' => 'ru',
                    'spellchecker_rpc_url' => '//speller.yandex.net/services/tinyspell',
                    'images_upload_url' => '/cp/tinymce/uploader/default/image',
                    'easyfileupload_url' => '/cp/tinymce/uploader/default/file',
                    'relative_urls' => false,
                ],
            ],
        ],
    ],
    'bootstrap' => [
        'logging' => [
            'class' => \krok\logging\Bootstrap::class,
        ],
    ],
    'modules' => [
        'system' => [
            'class' => \krok\system\Module::class,
            'viewPath' => '@vendor/yii2-developer/yii2-system/views/backend',
            'controllerNamespace' => 'krok\system\controllers\backend',
        ],
        'logging' => [
            'class' => \krok\logging\Module::class,
            'viewPath' => '@vendor/yii2-developer/yii2-logging/views/backend',
            'controllerNamespace' => 'krok\logging\controllers\backend',
        ],
        'auth' => [
            'class' => \app\modules\auth\Module::class, // todo
            'viewPath' => '@app/modules/auth/views/backend',
            'controllerNamespace' => 'app\modules\auth\controllers\backend',
        ],
        'content' => [
            'viewPath' => '@app/modules/content/views/backend',
            'controllerNamespace' => 'krok\content\controllers\backend',//'app\modules\content\controllers\backend',
        ],
        'banner' => [
            'class' => \app\modules\banner\Module::class,
            'viewPath' => '@app/modules/banner/views/backend',
            'controllerNamespace' => 'app\modules\banner\controllers\backend',
        ],
        'record' => [
            'class' => \app\modules\record\Module::class,
            'viewPath' => '@app/modules/record/views/backend',
            'controllerNamespace' => 'app\modules\record\controllers\backend',
        ],
        'promoBlock' => [
            'class' => \app\modules\promoBlock\Module::class,
            'viewPath' => '@app/modules/promoBlock/views/backend',
            'controllerNamespace' => 'app\modules\promoBlock\controllers\backend',
        ],
        'example' => [
            'class' => \krok\example\Module::class,
            'viewPath' => '@vendor/yii2-developer/yii2-example/views/backend',
            'controllerNamespace' => 'krok\example\controllers\backend',
        ],
        'feedback' => [
            'viewPath' => '@app/modules/feedback/views/backend',
            'class' => 'app\modules\feedback\Module',
            'controllerNamespace' => 'app\modules\feedback\controllers\backend',
        ],
        'menu' => [
            'viewPath' => '@app/modules/menu/views/backend',
            //'viewPath' => '@vendor/yii2-developer/yii2-menu/views/backend',
            'class' => \elfuvo\menu\Module::class,
            'controllerNamespace' => 'elfuvo\menu\controllers\backend',
            'useSection' => true,
            'useImage' => true,
            // list of modules with rules for menu building
            // there is just helpers for selecting menu routes
            // see examples in @elfuvo/menu/common/
            'menuItems' => [
                elfuvo\menu\common\ContentMenu::class,
                app\modules\about\models\AboutMenu::class,
                app\modules\news\models\NewsMenu::class,
            ],
        ],
        'news' => [
            'class' => \app\modules\news\Module::class,
            'viewPath' => '@app/modules/news/views/backend',
            'controllerNamespace' => 'app\modules\news\controllers\backend',
        ],
        'about' => [
            'class' => \app\modules\about\Module::class,
            'viewPath' => '@app/modules/about/views/backend',
            'controllerNamespace' => 'app\modules\about\controllers\backend',
        ],
        'contact' => [
            'class' => \app\modules\contact\Module::class,
            'viewPath' => '@app/modules/contact/views/backend',
            'controllerNamespace' => 'app\modules\contact\controllers\backend',
        ],
        'brand' => [
            'class' => \app\modules\brand\Module::class,
            'viewPath' => '@app/modules/brand/views/backend',
            'controllerNamespace' => 'app\modules\brand\controllers\backend',
        ],
        'advice' => [
            'class' => \app\modules\advice\Module::class,
            'viewPath' => '@app/modules/advice/views/backend',
            'controllerNamespace' => 'app\modules\advice\controllers\backend',
        ],
        'wherebuy' => [
            'class' => \app\modules\wherebuy\Module::class,
            'viewPath' => '@app/modules/wherebuy/views/backend',
            'controllerNamespace' => 'app\modules\wherebuy\controllers\backend',
        ],
        'product' => [
            'class' => \app\modules\product\Module::class,
            'viewPath' => '@app/modules/product/views/backend',
            'controllerNamespace' => 'app\modules\product\controllers\backend',
        ],
        'metatag' => [
            'class' => \tina\metatag\Module::class,
            'viewPath' => '@vendor/contrib/yii2-metatag/views/backend',
            'controllerNamespace' => 'tina\metatag\controllers\backend',
        ],
        'packet' => [
            'class' => app\modules\packet\Module::class,
            'viewPath' => '@app/modules/packet/views/backend',
            'controllerNamespace' => 'app\modules\packet\controllers\backend',
        ],
        'tinymce' => [
            'class' => \yii\base\Module::class,
            'modules' => [
                'uploader' => [
                    'class' => \krok\tinymce\uploader\Module::class,
                    'controllerNamespace' => 'krok\tinymce\uploader\controllers\backend',
                ],
            ],
        ],
        'rating' => [
            'class' => app\modules\rating\Module::class,
            'viewPath' => '@app/modules/rating/views/backend',
            'controllerNamespace' => 'app\modules\rating\controllers\backend',
        ],
        'sked' => [
            'class' => app\modules\sked\Module::class,
            'viewPath' => '@app/modules/sked/views/backend',
            'controllerNamespace' => 'app\modules\sked\controllers\backend',
        ],
        'configure' => [
            'class' => \krok\configure\Module::class,
            'viewPath' => '@krok/configure/views/backend',
            'controllerNamespace' => 'krok\configure\controllers\backend',
        ],
    ],
    'components' => [
        'view' => [
            'class' => \yii\web\View::class,
            'theme' => [
                'class' => \yii\base\Theme::class,
                'basePath' => '@themes',
                'baseUrl' => '@themes',
                'pathMap' => [
                    '@vendor/yii2-developer/yii2-system/views/backend' => '@app/modules/system/views/backend',
                    '@vendor/yii2-developer/yii2-system/views/backend/layouts' => '@themes/views/layouts',
                ],
            ],
        ],
        'urlManager' => [
            'rules' => require(__DIR__ . DIRECTORY_SEPARATOR . 'backend' . DIRECTORY_SEPARATOR . 'rules.php'),
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
                    'css' => [
                        YII_ENV_DEV ? 'css/bootstrap.css' : 'css/bootstrap.min.css',
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
            'csrfParam' => '_backendCSRF',
            'cookieValidationKey' => hash('sha512', __FILE__ . __LINE__),
        ],
        'user' => [
            'class' => \yii\web\User::class,
            'identityClass' => \app\modules\auth\models\Auth::class,
            'idParam' => '__idBackend',
            'authTimeoutParam' => '__expireBackend',
            'absoluteAuthTimeoutParam' => '__absoluteExpireBackend',
            'returnUrlParam' => '__returnUrlBackend',
            'loginUrl' => ['/auth/default/login'],
            // http://www.yiiframework.com/doc-2.0/yii-web-user.html#loginRequired()-detail
            'returnUrl' => ['/'],
            // Whether to enable cookie-based login: Yii::$app->user->login($this->getUser(), 24 * 60 * 60)
            'enableAutoLogin' => false,
            // http://www.yiiframework.com/doc-2.0/yii-web-user.html#$authTimeout-detail
            'authTimeout' => 1 * 60 * 60,
            'on afterLogin' => [
                \app\modules\auth\components\UserEventHandler::class,
                'handleAfterLogin',
            ],
            'on afterLogout' => [
                \app\modules\auth\components\UserEventHandler::class,
                'handleAfterLogout',
            ],
        ],
        'authClientCollection' => [
            'class' => \yii\authclient\Collection::class,
            'clients' => [
                'yandex' => [
                    'class' => \krok\oauth\YandexOAuth::class,
                    'clientId' => '',
                    'clientSecret' => '',
                    'normalizeUserAttributeMap' => [
                        'email' => 'default_email',
                    ],
                ],
                'google' => [
                    'class' => \krok\oauth\GoogleOAuth::class,
                    'clientId' => '',
                    'clientSecret' => '',
                    'normalizeUserAttributeMap' => [
                        'login' => ['emails', 0, 'value'],
                        'email' => ['emails', 0, 'value'],
                    ],
                ],
                'vkontakte' => [
                    'class' => \krok\oauth\VKontakte::class,
                    'clientId' => '',
                    'clientSecret' => '',
                    'normalizeUserAttributeMap' => [
                        'id' => 'user_id',
                        'login' => 'screen_name',
                    ],
                ],
                'facebook' => [
                    'class' => \krok\oauth\Facebook::class,
                    'clientId' => '',
                    'clientSecret' => '',
                    'normalizeUserAttributeMap' => [
                        'login' => 'id',
                    ],
                ],
                'twitter' => [
                    'class' => \krok\oauth\Twitter::class,
                    'consumerKey' => '',
                    'consumerSecret' => '',
                    'normalizeUserAttributeMap' => [
                        'login' => 'screen_name',
                    ],
                ],

                'ok' => [
                    'class' => \krok\oauth\Ok::class,
                    'clientId' => '',
                    'clientSecret' => '',
                    'applicationKey' => '',
                    'normalizeUserAttributeMap' => [
                        'login' => 'uid',
                    ],
                    'scope' => 'VALUABLE_ACCESS,GET_EMAIL',
                ],
            ],
        ],
        'errorHandler' => [
            'class' => \krok\sentry\web\SentryErrorHandler::class,
            'errorAction' => 'system/default/error',
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
            ],
            'router' => [
                'class' => \yii\debug\panels\RouterPanel::class,
            ],
        ],
        'allowedIPs' => [
            '*',
        ],
    ];

    $config['bootstrap'][] = 'gii';
    $config['modules']['gii'] = [
        'class' => \yii\gii\Module::class,
        'generators' => [
            'module' => [
                'class' => \yii\gii\generators\module\Generator::class,
                'messageCategory' => 'system',
                'templates' => [
                    'paperDashboard' => '@themes/gii/module',
                ],
                'template' => 'paperDashboard',
            ],
            'model' => [
                'class' => \yii\gii\generators\model\Generator::class,
                'generateQuery' => true,
                'useTablePrefix' => true,
                'messageCategory' => 'system',
                'templates' => [
                    'paperDashboard' => '@themes/gii/model',
                ],
                'template' => 'paperDashboard',
            ],
            'crud' => [
                'class' => \yii\gii\generators\crud\Generator::class,
                'enableI18N' => true,
                'baseControllerClass' => \krok\system\components\backend\Controller::class,
                'messageCategory' => 'system',
                'templates' => [
                    'paperDashboard' => '@themes/gii/crud',
                ],
                'template' => 'paperDashboard',
            ],
        ],
        'allowedIPs' => [
            '127.0.0.1',
            '::1',
            '172.72.*.*',
            '10.0.*.*',
        ],
    ];
}

return \yii\helpers\ArrayHelper::merge(require(__DIR__ . DIRECTORY_SEPARATOR . 'common.php'), $config);
