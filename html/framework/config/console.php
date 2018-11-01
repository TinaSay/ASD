<?php

$config = [
    'id' => 'console',
    'bootstrap' => [
        'queue',
    ],
    'controllerMap' => [
        // Migrations for the specific project's module
        'migrate' => [
            'class' => \yii\console\controllers\MigrateController::class,
            'migrationTable' => '{{%migration}}',
            'interactive' => false,
            'migrationPath' => [
                '@app/migrations',
                '@yii/rbac/migrations',
                '@app/modules/auth/migrations',
                '@app/modules/banner/migrations',
                '@app/modules/record/migrations',
                '@app/modules/promoBlock/migrations',
                '@app/modules/feedback/migrations',
                '@vendor/yii2-developer/yii2-logging/migrations',
                '@vendor/yii2-developer/yii2-storage/migrations',
                '@vendor/yii2-developer/yii2-content/migrations',
                '@vendor/yii2-developer/yii2-example/migrations',
                '@vendor/yii2-developer/yii2-configure/migrations',
                '@vendor/yii2-developer/yii2-meta/migrations',
                '@app/modules/menu/migrations',
                '@app/modules/news/migrations',
                '@app/modules/about/migrations',
                '@app/modules/contact/migrations',
                '@app/modules/modelSolution/migrations',
                '@app/modules/brand/migrations',
                '@vendor/yii2-developer/yii2-menu/migrations',
                '@app/modules/advice/migrations',
                '@app/modules/wherebuy/migrations',
                '@app/modules/product/migrations',
                '@vendor/contrib/yii2-metatag/migrations',
                '@app/modules/packet/migrations',
                '@app/modules/rating/migrations',
                '@app/modules/sked/migrations',
                '@app/modules/content/migrations',
                '@app/modules/metaRegister/migrations',
            ],
        ],
        'access' => [
            'class' => \app\commands\AccessController::class,
            'login' => [
                'webmaster',
            ],
            'rules' => [
                \app\modules\auth\rbac\AuthorRule::class,
            ],
            'user' => \app\modules\auth\models\Auth::class,
            'modules' => [
                [
                    'name' => 'system',
                    'controllers' => [
                        'default' => [
                            'index',
                            'flush-cache',
                        ],
                    ],
                ],
                [
                    'name' => 'logging',
                    'controllers' => [
                        'default' => [
                            'index',
                            'view',
                        ],
                    ],
                ],
                [
                    'name' => 'imperavi',
                    'controllers' => [
                        'default' => [
                            'file-upload',
                            'file-list',
                            'image-upload',
                            'image-list',
                        ],
                    ],
                ],
                [
                    'name' => 'auth',
                    'controllers' => [
                        'auth' => [
                            'index',
                            'create',
                            'update',
                            'delete',
                            'view',
                            'refresh-token',
                        ],
                        'log' => ['index'],
                        'profile' => ['index'],
                    ],
                ],
                [
                    'name' => 'content',
                    'controllers' => [
                        'default' => [],
                    ],
                ],
                [
                    'name' => 'banner',
                    'controllers' => [
                        'banner' => [
                            'index',
                            'create',
                            'update',
                            'delete',
                            'view',
                        ],
                    ],
                ],
                [
                    'name' => 'record',
                    'controllers' => [
                        'record' => [
                            'index',
                            'create',
                            'update',
                            'delete',
                            'view',
                        ],
                    ],
                ],
                [
                    'name' => 'feedback',
                    'controllers' => [
                        'default' => [
                            'index',
                            'update',
                            'delete',
                            'view',
                        ],
                        'settings' => [
                            'index',
                        ],
                        'settings-mail' => [
                            'index',
                            'update',
                        ],

                    ],
                ],
                [
                    'name' => 'menu',
                    'controllers' => [
                        'default' => [
                            'index',
                            'view',
                            'create',
                            'update',
                            'delete',
                            'update-all',
                            'module-menu-items',
                            'delete-image',
                        ],
                    ],
                ],
                [
                    'name' => 'news',
                    'controllers' => [
                        'manage' => [
                            'index',
                            'create',
                            'update',
                            'delete',
                            'view',
                        ],

                        'news-group' => [
                            'index',
                            'create',
                            'update',
                            'delete',
                            'view',
                        ],
                        'subscribe' => [
                            'index',
                            'delete',
                            'view',
                            'update',
                            'download',
                        ],
                    ],
                ],
                [
                    'name' => 'advice',
                    'controllers' => [
                        'manage' => [
                            'index',
                            'create',
                            'update',
                            'delete',
                            'view',
                        ],

                        'advice-group' => [
                            'index',
                            'create',
                            'update',
                            'delete',
                            'view',
                        ],

                    ],
                ],
                [
                    'name' => 'promoBlock',
                    'controllers' => [
                        'promo' => [
                            'index',
                            'create',
                            'update',
                            'delete',
                            'view',
                            'update-all',
                        ],
                    ],
                ],
                [
                    'name' => 'contact',
                    'controllers' => [
                        'division' => [
                            'index',
                            'create',
                            'update',
                            'delete',
                            'view',
                            'get-metro-list',
                            'metro-delete',
                            'requisite-delete',
                            'update-position',
                        ],
                        'network' => [
                            'index',
                            'create',
                            'update',
                            'delete',
                            'view',
                        ],
                        'setting' => [
                            'index',
                        ],
                    ],
                ],
                [
                    'name' => 'example',
                    'controllers' => [
                        'default' => [],
                    ],
                ],
                [
                    'name' => 'brand',
                    'controllers' => [
                        'brand' => [
                            'index',
                            'create',
                            'update',
                            'delete',
                            'view',
                            'update-position',
                        ],
                    ],
                ],
                [
                    'name' => 'about',
                    'controllers' => [
                        'default' => [
                            'index',
                            'create',
                            'update',
                            'delete',
                            'view',
                            'update-position',
                            'remove-file',
                        ],
                    ],
                ],
                [
                    'name' => 'wherebuy',
                    'controllers' => [
                        'manage' => [
                            'index',
                            'create',
                            'update',
                            'delete',
                            'view',
                        ],
                    ],
                ],
                [
                    'name' => 'product',
                    'controllers' => [
                        'section' => [
                            'index',
                            'view',
                            'update-all',
                        ],
                        'usage' => [
                            'index',
                            'view',
                            'update',
                            'update-all',
                        ],
                        'client-category' => [
                            'index',
                            'view',
                        ],
                        'product' => [
                            'index',
                            'view',
                        ],
                        'promo' => [
                            'index',
                            'view',
                        ],
                        'product-set' => [
                            'index',
                            'view',
                        ],
                        'brand' => [
                            'index',
                            'view',
                            'update',
                        ],
                        'page' => [
                            'index',
                            'update',
                        ],
                        'section-usage-text' => [
                            'index',
                            'view',
                            'create',
                            'update',
                            'delete',
                            'sections',
                        ],
                        /*'meta-settings' => [
                            'list',
                            'save',
                        ],*/
                        'import' => [
                            'index',
                        ]
                    ],
                ],
                [
                    'name' => 'metatag',
                    'controllers' => [
                        'default' => [
                            'update',
                        ],
                    ],
                ],
                [
                    'name' => 'packet',
                    'controllers' => [
                        'manage' => [
                            'index',
                            'create',
                            'view',
                            'update',
                            'delete',
                            'send',
                            'file-delete',
                            'city-list',
                            'country-list',
                            'status',
                        ],
                    ],
                ],
                [
                    'name' => 'tinymce/uploader',
                    'controllers' => [
                        'default' => [
                            'image',
                            'file',
                        ],
                    ],
                ],
                [
                    'name' => 'rating',
                    'controllers' => [
                        'manage' => [
                            'index',
                            'view',
                        ],
                    ],
                ],
                [
                    'name' => 'sked',
                    'controllers' => [
                        'manage' => [
                            'index',
                            'create',
                            'view',
                            'update',
                            'delete',
                            'item-delete',
                        ],
                    ],
                ],
                [
                    'name' => 'configure',
                    'controllers' => [
                        'default' => [
                            'list',
                            'save',
                        ],
                    ],
                ],
            ],
        ],
    ],
    'modules' => [
        'search' => [
            'class' => \krok\search\Module::class,
            'controllerNamespace' => 'krok\search\controllers\console',
        ],
        'product' => [
            'class' => \app\modules\product\Module::class,
            'controllerNamespace' => 'app\modules\product\controllers\console',
        ],
    ],
    'components' => [
        'urlManager' => [
            'baseUrl' => '/',
            'hostInfo' => '/',
            'rules' => require(__DIR__ . DIRECTORY_SEPARATOR . 'frontend' . DIRECTORY_SEPARATOR . 'rules.php'),
        ],
        'user' => [
            'class' => \yii\web\User::class,
            'enableSession' => false,
            'enableAutoLogin' => false,
            'identityClass' => \app\modules\auth\models\Auth::class,
        ],
        'request' => [
            'class' => \app\components\console\Request::class,
        ],
        'errorHandler' => [
            'class' => \krok\sentry\console\SentryErrorHandler::class,
            'sentry' => \krok\sentry\Sentry::class,
        ],
    ],
];

return \yii\helpers\ArrayHelper::merge(require(__DIR__ . DIRECTORY_SEPARATOR . 'common.php'), $config);
