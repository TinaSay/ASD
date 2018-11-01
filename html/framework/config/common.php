<?php
/**
 * Created by PhpStorm.
 * User: krok
 * Date: 08.02.17
 * Time: 23:35
 */

return \yii\helpers\ArrayHelper::merge(is_readable(__DIR__ . DIRECTORY_SEPARATOR . 'local.php') ? require(__DIR__ . DIRECTORY_SEPARATOR . 'local.php') : [],
    [
        'name' => 'Российская торгово-производственная компания',
        'timeZone' => 'UTC',
        'language' => 'ru-RU',
        'basePath' => dirname(__DIR__),
        'bootstrap' => ['log'],
        'aliases' => [
            '@root' => dirname(dirname(__DIR__)) . '/web',
            '@bower' => '@vendor/bower-asset',
            '@npm' => '@vendor/npm-asset',
            '@themes' => '@vendor/yii2-developer/yii2-paperDashboard',
            '@public' => '@root/uploads',
        ],
        'container' => [
            'singletons' => [
                \krok\sentry\Sentry::class => [
                    'class' => \krok\sentry\Sentry::class,
                    'dsn' => getenv('SENTRY_DSN'),
                ],
                \tina\metatag\components\Metatag::class => [
                    'class' => \tina\metatag\components\Metatag::class,
                ],
            ],
            'definitions' => [
                \yii\mail\MailerInterface::class => function () {
                    return Yii::$app->getMailer();
                },
                \krok\storage\behaviors\UploaderBehavior::class => [
                    'class' => \krok\storage\behaviors\UploaderBehavior::class,
                    'uploadedDirectory' => '/storage',
                ],
                \krok\storage\behaviors\StorageBehavior::class => [
                    'class' => \krok\storage\behaviors\StorageBehavior::class,
                    'uploadedDirectory' => '/storage',
                ],
                \krok\tinymce\uploader\actions\UploaderAction::class => function (
                    \yii\di\Container $container,
                    array $configure,
                    array $params
                ) {
                    /** @var \League\Flysystem\Filesystem $filesystem */
                    $filesystem = Yii::createObject(\League\Flysystem\Filesystem::class);
                    $filesystem->addPlugin(new \krok\filesystem\plugins\PublicUrl('/uploads/editor', 'getEditorUrl'));
                    $filesystem->addPlugin(new \krok\filesystem\plugins\HashGrid());

                    [$id, $controller] = $configure;

                    $action = new \krok\tinymce\uploader\actions\UploaderAction($id, $controller, $filesystem);
                    Yii::configure($action, array_merge($params, [
                        'uploadedDirectory' => '/editor',
                    ]));

                    return $action;
                },
                \League\Flysystem\AdapterInterface::class => function () {
                    return Yii::createObject(app\modules\filesystem\adapter\Local::class, [Yii::getAlias('@public')]);
                },
                \League\Flysystem\FilesystemInterface::class => function () {
                    $filesystem = Yii::createObject(\League\Flysystem\Filesystem::class);
                    $filesystem->addPlugin(new \krok\storage\plugins\PublicUrl('/render/storage'));
                    $filesystem->addPlugin(new \krok\storage\plugins\PublicUrl('/uploads/storage', 'getDownloadUrl'));
                    //$filesystem->addPlugin(new \krok\storage\plugins\PublicUrl('/attachment/storage', 'getAttachmentUrl'));
                    $filesystem->addPlugin(new \krok\storage\plugins\HashGrid());

                    return $filesystem;
                },
                \League\Glide\ServerFactory::class => function () {
                    $server = League\Glide\ServerFactory::create([
                        'source' => Yii::createObject(\League\Flysystem\FilesystemInterface::class),
                        'cache' => Yii::createObject(\League\Flysystem\FilesystemInterface::class),
                        'cache_path_prefix' => 'cache',
                        'driver' => 'imagick',
                    ]);
                    $server->setResponseFactory(new \krok\glide\response\Yii2ResponseFactory());

                    return $server;
                },
                \krok\language\LanguageInterface::class => function () {
                    $list = [
                        [
                            'iso' => 'ru-RU',
                            'title' => 'Russian',
                        ],
                        [
                            'iso' => 'en-US',
                            'title' => 'English',
                        ],
                    ];

                    return Yii::createObject(\krok\language\Language::class, [$list]);
                },
                \krok\search\interfaces\ConfigureInterface::class => function () {
                    return Yii::createObject(\krok\search\Configure::class, [
                        require(__DIR__ . '/search.php'),
                        'site',
                    ]);
                },
                \krok\search\interfaces\ConnectorInterface::class => \krok\search\sphinx\Connector::class,
                \krok\search\interfaces\IndexerInterface::class => \krok\search\sphinx\Indexer::class,
                \krok\search\interfaces\FinderInterface::class => \krok\search\sphinx\Finder::class,
                \app\modules\product\components\transport\ImportTransportInterface::class => function () {
                    if (getenv("PRODUCT_IMPORT_SOAP_URL")) {
                        return Yii::createObject([
                            'class' => \app\modules\product\components\transport\SoapTransport::class,
                            'url' => getenv('PRODUCT_IMPORT_SOAP_URL') ?: false,
                            'login' => getenv('PRODUCT_IMPORT_SOAP_LOGIN') ?: false,
                            'password' => getenv('PRODUCT_IMPORT_SOAP_PASSWORD') ?: false,
                            'proxySsh' => getenv('PRODUCT_IMPORT_PROXY_SSH_HOST') ? [
                                'proxy_host' => getenv('PRODUCT_IMPORT_PROXY_SSH_HOST'),
                                'proxy_port' => getenv('PRODUCT_IMPORT_PROXY_SSH_PORT') ?: '1080',
                            ] : null,
                        ]);
                    } else {
                        return Yii::createObject([
                            'class' => \app\modules\product\components\transport\FileTransport::class,
                            'path' => '@public/',
                            'realMode' => true,
                        ]);
                    }
                },
                \app\modules\lk\components\transport\ImportTransportInterfaceLk::class => function () {
                    if (getenv("LK_SOAP_URL")) {
                        return Yii::createObject([
                            'class' => \app\modules\lk\components\transport\SoapTransportLk::class,
                            'url' => getenv('LK_SOAP_URL') ?: false,
                            'login' => getenv('LK_SOAP_LOGIN') ?: false,
                            'password' => getenv('LK_SOAP_PASSWORD') ?: false,
                            'proxySsh' => getenv('LK_PROXY_SSH_HOST') ? [
                                'proxy_host' => getenv('LK_PROXY_SSH_HOST'),
                                'proxy_port' => getenv('LK_PROXY_SSH_PORT') ?: '1080',
                            ] : null,
                        ]);
                    } else {
                        return Yii::createObject(\app\modules\lk\components\transport\FileTransport::class);
                    }
                },

                \krok\content\models\Content::class => \app\modules\content\models\Content::class,
                \krok\content\dto\frontend\ContentDto::class => \app\modules\content\dto\frontend\ContentDto::class,
                \krok\content\services\frontend\ViewService::class => \app\modules\content\services\frontend\ViewService::class,
                \krok\configure\helpers\ConfigureHelperInterface::class => \krok\configure\helpers\ConfigureHelper::class,
                \krok\configure\serializers\SerializerInterface::class => \krok\configure\serializers\JsonSerializer::class,
                \krok\configure\ConfigureInterface::class => function () {
                    $configurable = [
                        //\app\modules\meta\MetaConfigure::class,
                        \app\modules\meta\OpenGraphConfigure::class,
                        \app\modules\product\meta\CatalogConfigure::class,
                        \app\modules\product\meta\BrandConfigure::class,
                        \app\modules\product\meta\BrandSectionConfigure::class,
                        \app\modules\product\meta\ProductConfigure::class,
                        \app\modules\product\meta\UsageMainConfigure::class,
                        \app\modules\product\meta\UsageConfigure::class,
                        \app\modules\product\meta\UsageSectionConfigure::class,
                    ];

                    /** @var \krok\configure\serializers\SerializerInterface $serializer */
                    $serializer = Yii::createObject(\krok\configure\serializers\SerializerInterface::class);

                    return new \krok\configure\Configure($configurable, $serializer);
                },
                \krok\meta\serializers\SerializerInterface::class => \krok\meta\serializers\JsonSerializer::class,
                \krok\meta\MetaInterface::class => \krok\meta\Meta::class,
                \krok\meta\behaviors\MetaBehavior::class => \app\modules\meta\behaviors\MetaBehavior::class,
            ],
        ],
        'modules' => [
            'content' => [
                'class' => \krok\content\Module::class,
                'layouts' => [
                    '//index' => 'Главная',
                    '//common' => 'Типовая',
                ],
                'views' => [
                    'index' => 'Главная',
                    'common' => 'Типовая страница',
                ],
            ],
            'glide' => [
                'class' => \yii\base\Module::class,
                'controllerNamespace' => 'krok\glide\controllers',
            ],
        ],
        'components' => [
            'authManager' => [
                'class' => \yii\rbac\DbManager::class,
                'cache' => 'cache',
            ],
            'urlManager' => [
                'class' => \krok\language\LanguageUrlManager::class,
                'enablePrettyUrl' => true,
                'showScriptName' => false,
                'normalizer' => [
                    'class' => \yii\web\UrlNormalizer::class,
                ],
                'rules' => [],
            ],
            'formatter' => [
                'class' => \yii\i18n\Formatter::class,
                'timeZone' => 'Europe/Moscow',
                'numberFormatterSymbols' => [
                    \NumberFormatter::CURRENCY_SYMBOL => '₽',
                ],
                'numberFormatterOptions' => [
                    \NumberFormatter::MAX_FRACTION_DIGITS => 2,
                ],
            ],
            'security' => [
                'class' => \yii\base\Security::class,
                'passwordHashCost' => 15,
            ],
            'session' => [
                'class' => \yii\web\CacheSession::class,
                'cache' => [
                    'class' => \yii\redis\Cache::class,
                    'defaultDuration' => 0,
                    'keyPrefix' => hash('crc32', __FILE__),
                    'redis' => [
                        'hostname' => getenv('REDIS_HOST'),
                        'port' => getenv('REDIS_PORT'),
                        'database' => 1,
                    ],
                ],
            ],
            'cache' => [
                'class' => \yii\redis\Cache::class,
                'defaultDuration' => 24 * 60 * 60,
                'keyPrefix' => hash('crc32', __FILE__),
                'redis' => [
                    'hostname' => getenv('REDIS_HOST'),
                    'port' => getenv('REDIS_PORT'),
                    'database' => 0,
                ],
            ],
            'mailer' => [
                'class' => \yii\swiftmailer\Mailer::class,
                'transport' => [
                    'class' => 'Swift_SmtpTransport',
                    'host' => getenv('SMTP_HOST'),
                    'username' => getenv('SMTP_USERNAME'),
                    'password' => getenv('SMTP_PASSWORD'),
                    'port' => getenv('SMTP_PORT'),
                    'encryption' => getenv('SMTP_ENCRYPTION'),
                ],
                'useFileTransport' => YII_DEBUG, // @runtime/mail/
            ],
            'queue' => [
                'class' => \yii\queue\redis\Queue::class,
                'redis' => [
                    'hostname' => getenv('REDIS_HOST'),
                    'port' => getenv('REDIS_PORT'),
                    'database' => 2,
                ],
            ],
            'i18n' => [
                'class' => \yii\i18n\I18N::class,
                'translations' => [
                    'app' => [
                        'class' => \yii\i18n\PhpMessageSource::class,
                        'sourceLanguage' => 'en-US',
                    ],
                    'system' => [
                        'class' => \yii\i18n\PhpMessageSource::class,
                        'sourceLanguage' => 'en-US',
                        'basePath' => '@app/messages',
                    ],
                ],
            ],
            'log' => [
                'class' => \yii\log\Dispatcher::class,
                'traceLevel' => YII_DEBUG ? 3 : 0,
                'targets' => [
                    'email' => [
                        'class' => \krok\log\EmailTarget::class,
                        'levels' => [
                            'error',
                            'warning',
                        ],
                        'except' => [
                            'yii\web\HttpException:404',
                            //'yii\web\HttpException:403',
                        ],
                        'message' => [
                            'to' => [
                                'creator@nsign.ru',
                                'elfuvo@gmail.com',
                            ],
                            'from' => [
                                getenv('EMAIL') => 'Logging',
                            ],
                            'subject' => 'ASD',
                        ],
                        'enabled' => YII_ENV_DEV,
                    ],
                    'file' => [
                        'class' => \krok\log\FileTarget::class,
                        'levels' => [
                            'error',
                            'warning',
                        ],
                        'except' => [
                            'yii\web\HttpException:404',
                            //'yii\web\HttpException:403',
                        ],
                        'enabled' => true, //YII_ENV_PROD,
                    ],
                ],
            ],
            'db' => require(__DIR__ . DIRECTORY_SEPARATOR . 'db.php'),
            'sphinx' => [
                'class' => \yii\sphinx\Connection::class,
                'dsn' => 'mysql:host=' . getenv('SPHINX_HOST') . ';port=' . getenv('SPHINX_PORT') . ';',
                'enableQueryCache' => true,
                'queryCacheDuration' => 300, // seconds
                'enableSchemaCache' => YII_ENV_PROD,
                'schemaCacheDuration' => 1 * 60 * 60, // seconds
            ],
        ],
        'params' => require(__DIR__ . DIRECTORY_SEPARATOR . 'params.php'),
    ]);
