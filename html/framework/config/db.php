<?php

return [
    'class' => \yii\db\Connection::class,
    'dsn' => 'mysql:host=' . getenv('MYSQL_HOST') . ';dbname=' . getenv('MYSQL_DATABASE'), // MySQL, MariaDB
    'username' => getenv('MYSQL_USER'),
    'password' => getenv('MYSQL_PASSWORD'),
    'charset' => 'utf8',
    'tablePrefix' => 'cmf2_',
    'enableQueryCache' => true,
    'queryCacheDuration' => 1 * 60 * 60, // seconds
    'enableSchemaCache' => YII_ENV_PROD,
    'schemaCacheDuration' => 1 * 60 * 60, // seconds
];
