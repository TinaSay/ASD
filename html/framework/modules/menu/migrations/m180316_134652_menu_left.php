<?php

use elfuvo\menu\models\Menu;
use yii\db\Expression;
use yii\db\Migration;
use yii\web\UploadedFile;

/**
 * Class m180316_134652_menu_left
 */
class m180316_134652_menu_left extends Migration
{
    /**
     * {@inheritdoc}
     */
    public function safeUp()
    {
        Menu::deleteAll(['section' => 'left']);

        $list = [
            [
                'title' => 'Розничным покупателям',
                'alias' => 'buyer',
                'image' => '1.svg',
                'type' => Menu::TYPE_MODULE,
                'route' => 'product/brand/index',
                'queryParams' => 'section=left',
                'children' => [
                    [
                        'title' => 'Наши бренды',
                        'alias' => 'brands',
                        'type' => Menu::TYPE_MODULE,
                        'route' => 'product/brand/index',
                        'queryParams' => 'section=left',
                    ],
                    [
                        'title' => 'Новинки каталога',
                        'alias' => 'promo/6',
                        'type' => Menu::TYPE_MODULE,
                        'route' => 'product/promo/index',
                        'queryParams' => 'section=left&promoId=6',
                    ],
                    [
                        'title' => 'Хиты продаж',
                        'alias' => 'promo/7',
                        'type' => Menu::TYPE_MODULE,
                        'route' => 'product/promo/index',
                        'queryParams' => 'section=left&promoId=7',
                    ],
                    [
                        'title' => 'Каталог товаров',
                        'alias' => 'catalog',
                        'type' => Menu::TYPE_BREADCRUMB,
                        'route' => 'product/catalog/search',
                        'queryParams' => 'section=left',
                    ],
                    [
                        'title' => 'Полезные советы',
                        'alias' => 'advice',
                        'type' => Menu::TYPE_MODULE,
                        'route' => 'advice/advice/index',
                        'queryParams' => 'section=left',
                        'children' => [
                            [
                                'title' => 'Карточка совета',
                                'alias' => '<id:\d+>',
                                'type' => Menu::TYPE_BREADCRUMB,
                                'route' => 'advice/advice/view',
                                'queryParams' => 'section=left',
                            ],
                        ],
                    ],
                    [
                        'title' => 'Где купить',
                        'alias' => 'wherebuy',
                        'type' => Menu::TYPE_MODULE,
                        'route' => 'wherebuy/default/index',
                        'queryParams' => 'section=left',
                    ],
                ],
            ],
            [
                'title' => 'Оптовым покупателям',
                'alias' => 'wholesale',
                'image' => '2.svg',
                'type' => Menu::TYPE_MODULE,
                'route' => 'product/set/index',
                'queryParams' => 'section=left',
                'children' => [
                    [
                        'title' => 'Готовые торговые решения',
                        'alias' => 'sets',
                        'type' => Menu::TYPE_MODULE,
                        'route' => 'product/set/index',
                        'queryParams' => 'section=left',
                    ],
                    [
                        'title' => 'Каталог товаров',
                        'alias' => 'catalog',
                        'type' => Menu::TYPE_MODULE,
                        'route' => 'product/catalog/search',
                        'queryParams' => 'section=left&ProductCatalogSearch[clientCategoryId][]=9&ProductCatalogSearch[clientCategoryId][]=10',
                        /* 'children' => [
                             [
                                 'title' => 'Ваш подбор',
                                 'alias' => 'search',
                                 'type' => Menu::TYPE_BREADCRUMB,
                                 'route' => 'product/catalog/search',
                                 'queryParams' => 'section=left',
                             ],
                         ],*/
                    ],
                    [
                        'title' => 'Преимущества',
                        'alias' => 'advantages',
                        'type' => Menu::TYPE_MODULE,
                        'route' => 'content/default/index',
                        'queryParams' => 'section=left&alias=advantages',
                    ],
                    [
                        'title' => 'Условия партнерства',
                        'alias' => 'terms-of-partnership',
                        'type' => Menu::TYPE_MODULE,
                        'route' => 'content/default/index',
                        'queryParams' => 'section=left&alias=TermsOfPartnership',
                    ],
                    [
                        'title' => 'Логистика',
                        'alias' => 'logistika',
                        'type' => Menu::TYPE_MODULE,
                        'route' => 'about/default/view',
                        'queryParams' => 'section=left&id=2',
                    ],
                ],
            ],
            [
                'title' => 'Торговым сетям',
                'alias' => 'retail',
                'image' => '3.svg',
                'type' => Menu::TYPE_MODULE,
                'route' => 'product/set/index',
                'queryParams' => 'section=left',
                'children' => [
                    [
                        'title' => 'Готовые торговые решения',
                        'alias' => 'sets',
                        'type' => Menu::TYPE_MODULE,
                        'route' => 'product/set/index',
                        'queryParams' => 'section=left',
                    ],
                    [
                        'title' => 'Производство',
                        'alias' => 'production',
                        'type' => Menu::TYPE_MODULE,
                        'route' => 'about/default/view',
                        'queryParams' => 'section=left&id=3',
                    ],
                    [
                        'title' => 'Каталог товаров',
                        'alias' => 'catalog',
                        'type' => Menu::TYPE_MODULE,
                        'route' => 'product/catalog/search',
                        'queryParams' => 'section=left&ProductCatalogSearch[clientCategoryId][]=10',
                        /* 'children' => [
                             [
                                 'title' => 'Ваш подбор',
                                 'alias' => 'search',
                                 'type' => Menu::TYPE_BREADCRUMB,
                                 'route' => 'product/catalog/search',
                                 'queryParams' => 'section=left',
                             ],
                         ],*/
                    ],
                    [
                        'title' => 'Преимущества',
                        'alias' => 'advantages',
                        'type' => Menu::TYPE_MODULE,
                        'route' => 'content/default/index',
                        'queryParams' => 'section=left&alias=advantages',
                    ],
                    [
                        'title' => 'Условия партнерства',
                        'alias' => 'terms-of-partnership',
                        'type' => Menu::TYPE_MODULE,
                        'route' => 'content/default/index',
                        'queryParams' => 'section=left&alias=TermsOfPartnership',
                    ],
                ],
            ],
            [
                'title' => 'Производителям',
                'alias' => 'manufacturer',
                'image' => '4.svg',
                'type' => Menu::TYPE_VOID,
                'route' => '',
                'queryParams' => 'section=left',
                'children' => [
                    [
                        'title' => 'Примеры сотрудничества',
                        'alias' => 'cooperation',
                        'type' => Menu::TYPE_MODULE,
                        'route' => 'content/default/index',
                        'queryParams' => 'section=left&alias=cooperation',
                    ],
                    [
                        'title' => 'Каталог товаров',
                        'alias' => 'catalog',
                        'type' => Menu::TYPE_MODULE,
                        'route' => 'product/catalog/search',
                        'queryParams' => 'section=left&ProductCatalogSearch[clientCategoryId][]=10',
                        /* 'children' => [
                            [
                                'title' => 'Ваш подбор',
                                'alias' => 'search',
                                'type' => Menu::TYPE_BREADCRUMB,
                                'route' => 'product/catalog/search',
                                'queryParams' => 'section=left',
                            ],
                        ],*/
                    ],
                    [
                        'title' => 'Гарантия и качество',
                        'alias' => 'warranty-and-quality',
                        'type' => Menu::TYPE_MODULE,
                        'route' => 'content/default/index',
                        'queryParams' => 'section=left&alias=WarrantyAndQuality',
                    ],
                    [
                        'title' => 'Производство',
                        'alias' => 'production',
                        'type' => Menu::TYPE_MODULE,
                        'route' => 'about/default/view',
                        'queryParams' => 'section=left&id=3',
                    ],
                    [
                        'title' => 'Условия партнерства',
                        'alias' => 'terms-of-partnership',
                        'type' => Menu::TYPE_MODULE,
                        'route' => 'content/default/index',
                        'queryParams' => 'section=left&alias=TermsOfPartnership',
                    ],
                ],
            ],
        ];

        $pos = 0;
        foreach ($list as $item) {
            $item['pos'] = ++$pos;
            $item['depth'] = 0;
            $item['url'] = $item['alias'];
            if (($item['id'] = $this->insertMenu($item, null, ($item['image'] ?? null))) && isset($item['children'])) {
                foreach ($item['children'] as $child) {
                    $child['pos'] = ++$pos;
                    $child['depth'] = 1;
                    $child['url'] = $item['alias'] . '/' . $child['alias'];
                    if (($child['id'] = $this->insertMenu($child, $item)) && isset($child['children'])) {
                        foreach ($child['children'] as $child2) {
                            $child2['pos'] = ++$pos;
                            $child2['depth'] = 2;
                            $child2['url'] = $item['alias'] . '/' . $child['alias'] . '/' . $child2['alias'];
                            if (($child2['id'] = $this->insertMenu($child2, $child)) && isset($child2['children'])) {
                                foreach ($child2['children'] as $child3) {
                                    $child3['pos'] = ++$pos;
                                    $child3['depth'] = 3;
                                    $child3['url'] = $item['alias'] . '/' . $child['alias'] . '/' . $child2['alias'] . '/' . $child3['alias'];
                                    $this->insertMenu($child3, $child2);
                                }
                            }
                        }
                    }
                }
            }
        }

    }

    /**
     * @param array $menu
     * @param array|null $parent
     * @param null|string $image
     *
     * @return int|bool
     */
    protected function insertMenu(array $menu, ?array $parent, ?string $image = null)
    {
        $this->insert('{{%menu}}', [
            'parentId' => $parent ? $parent['id'] : null,
            'title' => $menu['title'],
            'alias' => $menu['alias'],
            'route' => $menu['route'],
            'depth' => $menu['depth'],
            'queryParams' => $menu['queryParams'] ?? '',
            'url' => $menu['url'],
            'type' => $menu['type'],
            'section' => 'left',
            'language' => Yii::$app->language,
            'hidden' => Menu::HIDDEN_NO,
            'position' => $menu['pos'],
            'createdAt' => new Expression('NOW()'),
            'updatedAt' => new Expression('NOW()'),
        ]);
        $id = $this->db->getLastInsertID();

        if ($image) {
            $model = Menu::findOne($id);
            $filePath = realpath(__DIR__ . '/image/' . $image);
            /** @var \yii\web\UploadedFile $imageModel */
            $imageModel = Yii::createObject([
                'class' => UploadedFile::class,
                'name' => $image,
                'tempName' => $filePath,
                'type' => 'image/svg+xml',
                'size' => filesize($filePath),
                'error' => UPLOAD_ERR_OK,
            ]);
            $model->setImage($imageModel);
            $model->save();
        }

        return $id;
    }

    /**
     * {@inheritdoc}
     */
    public function safeDown()
    {
        Menu::deleteAll(['section' => 'left']);
    }
}
