<?php

use app\modules\search\models\SearchForm;

return [
    /**
     * Content
     */
    [
        'dataProvider' => function () {
            return \krok\content\models\Content::find()->select([
                \krok\content\models\Content::tableName() . '.[[id]]',
                \krok\content\models\Content::tableName() . '.[[alias]]',
                \krok\content\models\Content::tableName() . '.[[title]]',
                \krok\content\models\Content::tableName() . '.[[text]]',
                \krok\content\models\Content::tableName() . '.[[language]]',
                \krok\content\models\Content::tableName() . '.[[createdAt]]',
            ])->where([
                \krok\content\models\Content::tableName() . '.[[hidden]]' => \krok\content\models\Content::HIDDEN_NO,
            ]);
        },
        'fields' => [
            'module' => function () {
                return 'Общая информация';
            },
            'recordId' => function ($model) {
                return $model['id'];
            },
            'type' => function () {
                return SearchForm::TYPE_GENERAL;
            },
            'language' => function ($model) {
                return $model['language'];
            },
            'title' => function ($model) {
                return $model['title'];
            },
            'description' => function ($model) {
                return $model['text'];
            },
            'data' => function ($model) {
                return implode(' ', [
                    $model['title'],
                    $model['text'],
                ]);
            },
            'url' => function ($model) {
                return \yii\helpers\Url::to(['/content/default/index', 'alias' => $model['alias']]);
            },
            'date' => function ($model) {
                return $model['createdAt'];
            },
        ],
    ],
    /**
     * News
     */
    [
        'dataProvider' => function () {
            return \app\modules\news\models\News::find()->select([
                \app\modules\news\models\News::tableName() . '.[[id]]',
                \app\modules\news\models\News::tableName() . '.[[title]]',
                \app\modules\news\models\News::tableName() . '.[[announce]]',
                \app\modules\news\models\News::tableName() . '.[[text]]',
                \app\modules\news\models\News::tableName() . '.[[language]]',
                \app\modules\news\models\News::tableName() . '.[[date]]',
            ])->where([
                \app\modules\news\models\News::tableName() . '.[[hidden]]' => \app\modules\news\models\News::HIDDEN_NO,
            ]);
        },
        'fields' => [
            'module' => function () {
                return 'Новости';
            },
            'recordId' => function ($model) {
                return $model['id'];
            },
            'type' => function () {
                return SearchForm::TYPE_NEWS;
            },
            'language' => function ($model) {
                return $model['language'];
            },
            'title' => function ($model) {
                return $model['title'];
            },
            'description' => function ($model) {
                return implode(' ', [
                    $model['announce'],
                    $model['text'],
                ]);
            },
            'data' => function ($model) {
                return implode(' ', [
                    $model['title'],
                    $model['announce'],
                    $model['text'],
                ]);
            },
            'url' => function ($model) {
                return \yii\helpers\Url::to(['/news/news/view', 'id' => $model['id']]);
            },
            'date' => function ($model) {
                return isset($model['date']) ? $model['date'] : '';
            },
        ],
    ],
    /**
     * Advice
     */
    [
        'dataProvider' => function () {
            return app\modules\advice\models\Advice::find()->select([
                app\modules\advice\models\Advice::tableName() . '.[[id]]',
                app\modules\advice\models\Advice::tableName() . '.[[title]]',
                app\modules\advice\models\Advice::tableName() . '.[[announce]]',
                app\modules\advice\models\Advice::tableName() . '.[[text]]',
                app\modules\advice\models\Advice::tableName() . '.[[language]]',
                app\modules\advice\models\Advice::tableName() . '.[[createdAt]]',
            ])->where([
                app\modules\advice\models\Advice::tableName() . '.[[hidden]]' => app\modules\advice\models\Advice::HIDDEN_NO,
            ]);
        },
        'fields' => [
            'module' => function () {
                return 'Советы';
            },
            'recordId' => function ($model) {
                return $model['id'];
            },
            'type' => function () {
                return SearchForm::TYPE_ADVICE;
            },
            'language' => function ($model) {
                return $model['language'];
            },
            'title' => function ($model) {
                return $model['title'];
            },
            'description' => function ($model) {
                return implode(' ', [
                    $model['announce'],
                    $model['text'],
                ]);
            },
            'data' => function ($model) {
                return implode(' ', [
                    $model['title'],
                    $model['announce'],
                    $model['text'],
                ]);
            },
            'url' => function ($model) {
                return \yii\helpers\Url::to(['/advice/advice/view', 'id' => $model['id']]);
            },
            'date' => function ($model) {
                return $model['createdAt'];
            },
        ],
    ],

    /**
     * About
     */
    [
        'dataProvider' => function () {
            return \app\modules\about\models\About::find()->select([
                \app\modules\about\models\About::tableName() . '.[[id]]',
                \app\modules\about\models\About::tableName() . '.[[title]]',
                \app\modules\about\models\About::tableName() . '.[[description]]',
                \app\modules\about\models\About::tableName() . '.[[additionalDescription]]',
                \app\modules\about\models\About::tableName() . '.[[createdAt]]',
            ])->where([
                \app\modules\about\models\About::tableName() . '.[[blocked]]' => \app\modules\about\models\About::BLOCKED_NO,
            ]);
        },
        'fields' => [
            'module' => function () {
                return 'О компании';
            },
            'recordId' => function ($model) {
                return $model['id'];
            },
            'type' => function () {
                return SearchForm::TYPE_GENERAL;
            },
            'language' => function () {
                return 'ru-RU';
            },
            'title' => function ($model) {
                return $model['title'];
            },
            'description' => function ($model) {
                return implode(' ', [
                    $model['description'],
                    $model['additionalDescription'],
                ]);
            },
            'data' => function ($model) {
                return implode(' ', [
                    $model['title'],
                    $model['description'],
                    $model['additionalDescription'],
                ]);
            },
            'url' => function ($model) {
                return \yii\helpers\Url::to(['/about/default/view', 'id' => $model['id']]);
            },
            'date' => function ($model) {
                return $model['createdAt'];
            },
        ],
    ],

    /**
     * Contact
     */
    [
        'dataProvider' => function () {
            return app\modules\contact\models\Division::find()->select([
                app\modules\contact\models\Division::tableName() . '.[[id]]',
                app\modules\contact\models\Division::tableName() . '.[[title]]',
                app\modules\contact\models\Division::tableName() . '.[[subtitle]]',
                app\modules\contact\models\Division::tableName() . '.[[createdAt]]',
            ])->where([
                app\modules\contact\models\Division::tableName() . '.[[hidden]]' => app\modules\contact\models\Division::HIDDEN_NO,
            ]);
        },
        'fields' => [
            'module' => function () {
                return 'Контакты';
            },
            'recordId' => function ($model) {
                return $model['id'];
            },
            'type' => function () {
                return SearchForm::TYPE_GENERAL;
            },
            'language' => function () {
                return 'ru-RU';
            },
            'title' => function ($model) {
                return $model['title'];
            },
            'description' => function ($model) {
                return $model['subtitle'];
            },
            'data' => function ($model) {
                return implode(' ', [
                    $model['title'],
                    $model['subtitle'],
                ]);
            },
            'url' => function ($model) {
                return \yii\helpers\Url::to(['/contact/division/view', 'id' => $model['id']]);
            },
            'date' => function ($model) {
                return $model['createdAt'];
            },
        ],
    ],

    /**
     * Product
     */
    [
        'dataProvider' => function () {
            return app\modules\product\models\Product::find()->select([
                app\modules\product\models\Product::tableName() . '.[[id]]',
                app\modules\product\models\Product::tableName() . '.[[title]]',
                app\modules\product\models\Product::tableName() . '.[[alias]]',
                app\modules\product\models\Product::tableName() . '.[[printableTitle]]',
                app\modules\product\models\Product::tableName() . '.[[article]]',
                app\modules\product\models\Product::tableName() . '.[[description]]',
                app\modules\product\models\Product::tableName() . '.[[createdAt]]',
            ])->where([
                app\modules\product\models\Product::tableName() . '.[[hidden]]' => app\modules\product\models\Product::HIDDEN_NO,
            ]);
        },
        'fields' => [
            'module' => function () {
                return 'Товары';
            },
            'recordId' => function ($model) {
                return $model['id'];
            },
            'type' => function () {
                return SearchForm::TYPE_PRODUCT;
            },
            'language' => function () {
                return 'ru-RU';
            },
            'title' => function ($model) {
                return $model['title'];
            },
            'description' => function ($model) {
                return $model['description'];
            },
            'data' => function ($model) {
                return implode(' ', [
                    $model['title'],
                    $model['printableTitle'],
                    $model['article'],
                    $model['description'],
                ]);
            },
            'url' => function ($model) {
                return \yii\helpers\Url::to(['/product/catalog/view', 'alias' => $model['alias']]);
            },
            'date' => function ($model) {
                return $model['createdAt'];
            },
        ],
    ],

    /**
     * ProductSet
     */
    [
        'dataProvider' => function () {
            return app\modules\product\models\ProductSet::find()->select([
                app\modules\product\models\ProductSet::tableName() . '.[[id]]',
                app\modules\product\models\ProductSet::tableName() . '.[[article]]',
                app\modules\product\models\ProductSet::tableName() . '.[[title]]',
                app\modules\product\models\ProductSet::tableName() . '.[[category]]',
                app\modules\product\models\ProductSet::tableName() . '.[[description]]',
                app\modules\product\models\ProductSet::tableName() . '.[[createdAt]]',
            ])->where([
                app\modules\product\models\ProductSet::tableName() . '.[[hidden]]' => app\modules\product\models\ProductSet::HIDDEN_NO,
            ]);
        },
        'fields' => [
            'module' => function () {
                return 'Наборы';
            },
            'recordId' => function ($model) {
                return $model['id'];
            },
            'type' => function () {
                return SearchForm::TYPE_PRODUCT_SET;
            },
            'language' => function () {
                return 'ru-RU';
            },
            'title' => function ($model) {
                return $model['title'];
            },
            'description' => function ($model) {
                return $model['description'];
            },
            'data' => function ($model) {
                return implode(' ', [
                    $model['article'],
                    $model['title'],
                    $model['category'],
                    $model['description'],
                ]);
            },
            'url' => function ($model) {
                return \yii\helpers\Url::to(['/product/set/index', 'usageId' => $model['id']]);
            },
            'date' => function ($model) {
                return $model['createdAt'];
            },
        ],
    ],
];
