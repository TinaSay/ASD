<?php

use yii\db\Migration;

class m170904_103947_menu_item extends Migration
{

    const TYPE_MENU_MAIN = 0;
    const TYPE_MENU_SECONDARY = 1;

    public function safeUp()
    {
        $typeMenu = self::TYPE_MENU_MAIN;
        foreach ($this->getMainMenuItems() as $item) {
            $this->saveMenuItem($item, $typeMenu);
        }
        $typeMenu = self::TYPE_MENU_SECONDARY;
        foreach ($this->getSecondaryMenuItems() as $item) {
            $this->saveMenuItem($item, $typeMenu);
        }
    }

    public function safeDown()
    {
        $this->truncateTable('{{%menu}}');
    }

    private function saveMenuItem($parentItem, $typeMenu)
    {
        if (isset($parentItem['name'])) {

            Yii::$app->db->createCommand()->insert('{{%menu}}', [
                'name' => $parentItem['name'],
                'typeMenu' => $typeMenu,
                'language' => 'ru-RU',
            ])->execute();

            $parent_id = Yii::$app->db->getLastInsertID();


            if (isset($parentItem['items']) && is_array($parentItem['items'])) {
                foreach ($parentItem['items'] as $item) {

                    Yii::$app->db->createCommand()->insert('{{%menu}}', [
                        'name' => $item,
                        'typeMenu' => $typeMenu,
                        'language' => 'ru-RU',
                        'parentId' => $parent_id,
                    ])->execute();

                }
            }
        }
    }

    /**
     * Основное меню
     *
     * @return array
     */
    private function getMainMenuItems()
    {
        return [
            ['name' => 'Каталог'],
            ['name' => 'Советы'],
            ['name' => 'Компания'],
            ['name' => 'Контакты'],
        ];
    }

    /**
     * Вспомогательное меню
     *
     * @return array
     */
    private function getSecondaryMenuItems()
    {
        return [
            [
                'name' => 'Розничным покупателям',
                'items' => [
                    'Наши бренды',
                    'Новинки каталога',
                    'Хиты продаж',
                    'Где купить',
                    'Полезные советы',
                ],
            ],
            [
                'name' => 'Малому бизнесу',
                'items' => [
                    'Пункт №1',
                    'Пункт №2',
                    'Пункт №3',
                    'Пункт №4',
                    'Пункт №5',
                ],
            ],
            [
                'name' => 'Дистрибьютерам',
                'items' => [
                    'Пункт №1',
                    'Пункт №2',
                    'Пункт №3',
                    'Пункт №4',
                    'Пункт №5',
                ],
            ],
            [
                'name' => 'Торговым сетям',
                'items' => [
                    'Пункт №1',
                    'Пункт №2',
                    'Пункт №3',
                    'Пункт №4',
                    'Пункт №5',
                ],
            ],
            [
                'name' => 'Производителям',
                'items' => [
                    'Пункт №1',
                    'Пункт №2',
                    'Пункт №3',
                    'Пункт №4',
                    'Пункт №5',
                ],
            ],
        ];
    }
}
