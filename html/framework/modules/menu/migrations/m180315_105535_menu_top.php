<?php

use elfuvo\menu\models\Menu;
use yii\db\Expression;
use yii\db\Migration;

/**
 * Class m180315_105535_menu_top
 */
class m180315_105535_menu_top extends Migration
{
    /**
     * {@inheritdoc}
     */
    public function safeUp()
    {
        Menu::deleteAll(['section' => 'top']);

        $list = [
            [
                'title' => 'Каталог',
                'alias' => 'catalog',
                'type' => Menu::TYPE_MODULE,
                'route' => 'product/brand/index',
                'queryParams' => 'section=top',
                'children' => [
                    [
                        'title' => 'Ваш подбор',
                        'alias' => 'search',
                        'type' => Menu::TYPE_MODULE,
                        'route' => 'product/catalog/search',
                        'queryParams' => 'section=top',
                    ],

                ],
            ],
            [
                'title' => 'Компания',
                'alias' => 'about',
                'type' => Menu::TYPE_MODULE,
                'route' => 'about/default/index',
                'queryParams' => 'section=top',
                'children' => [
                    [
                        'title' => 'Кратко о нас',
                        'alias' => 'kratko-o-nas',
                        'type' => Menu::TYPE_MODULE,
                        'route' => 'about/default/view',
                        'queryParams' => 'section=top&id=1',
                    ],
                    [
                        'title' => 'Новости',
                        'alias' => 'news',
                        'type' => Menu::TYPE_MODULE,
                        'route' => 'news/news/index',
                        'queryParams' => 'section=top',
                        'children' => [
                            [
                                'title' => 'Карточка новости',
                                'alias' => '<id:\d+>',
                                'type' => Menu::TYPE_BREADCRUMB,
                                'route' => 'news/news/view',
                                'queryParams' => 'section=top',
                            ],
                        ],
                    ],
                ],
            ],
            [
                'title' => 'Советы',
                'alias' => 'advice',
                'type' => Menu::TYPE_MODULE,
                'route' => 'advice/advice/index',
                'queryParams' => 'section=top',
                'children' => [
                    [
                        'title' => 'Карточка совета',
                        'alias' => '<id:\d+>',
                        'type' => Menu::TYPE_BREADCRUMB,
                        'route' => 'advice/advice/view',
                        'queryParams' => 'section=top',
                    ],
                ],
            ],
            [
                'title' => 'Контакты',
                'alias' => 'contacts',
                'type' => Menu::TYPE_MODULE,
                'route' => 'contact/division/index',
                'queryParams' => 'section=top',
            ],
        ];
        $pos = 0;
        foreach ($list as $item) {
            $item['pos'] = ++$pos;
            $item['depth'] = 0;
            $item['url'] = $item['alias'];
            if (($item['id'] = $this->insertMenu($item, null)) && isset($item['children'])) {
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
     *
     * @return int|bool
     */
    protected function insertMenu(array $menu, ?array $parent)
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
            'section' => 'top',
            'language' => Yii::$app->language,
            'hidden' => Menu::HIDDEN_NO,
            'position' => $menu['pos'],
            'createdAt' => new Expression('NOW()'),
            'updatedAt' => new Expression('NOW()'),
        ]);
        $id = $this->db->getLastInsertID();

        return $id;
    }

    /**
     * {@inheritdoc}
     */
    public function safeDown()
    {
        Menu::deleteAll(['section' => 'top']);
    }
}
