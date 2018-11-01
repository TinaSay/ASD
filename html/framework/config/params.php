<?php

return [
    'email' => getenv('EMAIL'),
    'smtpConfigDir' => '@runtime/smtp/',
    'HTMLPurifier' => [
        'Attr.AllowedFrameTargets' => [
            '_blank',
            '_self',
            '_parent',
            '_top',
        ],
        'HTML.Trusted' => true,
        'Filter.YouTube' => true,
    ],
    'menu' => [
        [
            'label' => 'Home page',
            'icon' => 'ti-home',
            'items' => [
                [
                    'label' => 'Promo Block',
                    'url' => ['/promoBlock/promo'],
                ],
                [
                    'label' => 'Banner',
                    'url' => ['/banner/banner'],
                ],
                [
                    'label' => 'History of the company',
                    'url' => ['/record/record'],
                ],
                [
                    'label' => 'Our brands',
                    'url' => ['/brand/brand'],
                ],
                [
                    'label' => 'Metatag',
                    'url' => ['/metatag/default'],
                ],
            ],
        ],
        [
            'label' => 'News',
            'icon' => 'ti-world',
            'items' => [
                [
                    'label' => 'Группы',
                    'url' => ['/news/news-group'],
                ],
                [
                    'label' => 'Новости',
                    'url' => ['/news/manage'],
                ],
            ],
        ],
        [
            'label' => 'Советы',
            'icon' => 'ti-check-box',
            'items' => [
                [
                    'label' => 'Категории советов',
                    'url' => ['/advice/advice-group'],
                ],
                [
                    'label' => 'Советы',
                    'url' => ['/advice/manage'],
                ],
                [
                    'label' => 'Рейтинг',
                    'url' => ['/rating/manage'],
                ],

            ],
        ],
        [
            'label' => 'Где купить',
            'icon' => 'ti-map-alt',
            'items' => [
                [
                    'label' => 'Интернет-магазины',
                    'url' => ['/wherebuy/manage'],
                ],
            ],
        ],
        [
            'label' => 'Feedback',
            'icon' => 'ti-email',
            'items' => [

                [
                    'label' => 'Inbox',
                    'url' => ['/feedback/default'],
                ],
                [
                    'label' => 'Уведомления',
                    'url' => ['/feedback/settings'],
                ],
                [
                    'label' => 'Настройка почты',
                    'url' => ['/feedback/settings-mail'],
                ],
            ],
        ],
        [
            'label' => 'Общий контент',
            'icon' => 'ti-server',
            'items' => [

                [
                    'label' => 'Типовые страницы',
                    'url' => ['/content/default'],
                ],
                [
                    'label' => 'Списки',
                    'url' => ['/sked/manage'],
                ],
                [
                    'label' => 'About company',
                    'url' => ['/about/default'],

                ],
                [
                    'label' => 'Контакты',

                    'items' => [
                        [
                            'label' => 'Подразделения',
                            'url' => ['/contact/division'],
                        ],
                        [
                            'label' => 'Социальные сети',
                            'url' => ['/contact/network'],
                        ],
                        [
                            'label' => 'Настройки',
                            'url' => ['/contact/setting'],
                        ],
                    ],
                ],
            ],
        ],
        [
            'label' => 'Menu',
            'icon' => 'ti-menu',
            'items' => [
                [
                    'label' => 'Верхнее меню',
                    'url' => ['/menu/default', 'section' => 'top'],
                ],
                [
                    'label' => 'Боковое меню',
                    'url' => ['/menu/default', 'section' => 'left'],
                ],
            ],
        ],
        [
            'label' => 'Рассылки',
            'icon' => 'ti-share',
            'items' => [
                [
                    'label' => 'Подписчики',
                    'url' => ['/news/subscribe'],
                ],
                [
                    'label' => 'Рассылка',
                    'url' => ['/packet/manage'],
                ],
            ],
        ],
        [
            'label' => 'Каталог товаров',
            'icon' => 'ti-shopping-cart-full',
            'items' => [
                [
                    'label' => 'Товары',
                    'url' => ['/product/product'],
                ],
                [
                    'label' => 'Справочники',
                    'items' => [
                        [
                            'label' => 'Разделы каталога',
                            'url' => ['/product/section'],
                        ],
                        [
                            'label' => 'Сферы применения',
                            'items' => [
                                [
                                    'label' => 'Список сфер',
                                    'url' => ['/product/usage'],
                                ],
                                [
                                    'label' => 'Описание для разделов',
                                    'url' => ['/product/section-usage-text'],
                                ],
                            ],
                        ],
                        [
                            'label' => 'Категории потребителей',
                            'url' => ['/product/client-category'],
                        ],
                    ],
                ],
                [
                    'label' => 'Product Promo',
                    'url' => ['/product/promo'],
                ],
                [
                    'label' => 'Наборы',
                    'items' => [
                        [
                            'label' => 'Список наборов',
                            'url' => ['/product/product-set'],
                        ],
                        [
                            'label' => 'Описание раздела',
                            'url' => ['/product/page'],
                        ],
                    ],
                ],
                [
                    'label' => 'Product Brand',
                    'url' => ['/product/brand'],
                ],
                /*[
                    'label' => 'Шаблоны для формирования метатегов',
                    'url' => ['/product/meta'],
                ],*/
                [
                    'label' => 'Импортировать товары',
                    'url' => ['/product/import'],
                ],
            ],
        ],
    ],
];
