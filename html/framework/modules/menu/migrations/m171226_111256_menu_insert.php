<?php

use elfuvo\menu\models\Menu;
use yii\db\Expression;
use yii\db\Migration;
use yii\helpers\Inflector;

/**
 * Class m171226_111256_menu_insert
 */
class m171226_111256_menu_insert extends Migration
{
    public $pos = 0;

    /**
     * @inheritdoc
     */
    public function safeUp()
    {
        foreach ($this->getMainMenuItems() as $item) {
            $this->saveMenuItem($item, 'top');
        }
        foreach ($this->getSecondaryMenuItems() as $item) {
            $this->saveMenuItem($item, 'left');
        }
    }

    /**
     * @inheritdoc
     */
    public function safeDown()
    {
        Menu::deleteAll();
    }

    /**
     * @param $item
     * @param $section
     * @param null|array $parent
     */
    private function saveMenuItem($item, $section, $parent = null)
    {
        $this->pos++;
        if (isset($item['name'])) {
            $item['alias'] = isset($item['alias']) ? $item['alias'] : Inflector::slug($item['name']);
            $item['depth'] = $parent ? $parent['depth'] + 1 : 0;
            $this->insert(Menu::tableName(), [
                'parentId' => ($parent ? $parent['id'] : null),
                'title' => $item['name'],
                'alias' => $item['alias'],
                'section' => $section,
                'type' => Menu::TYPE_LINK,
                'extUrl' => '#',
                'position' => $this->pos,
                'depth' => $item['depth'],
                'language' => Yii::$app->language,
                'hidden' => Menu::HIDDEN_NO,
                'createdAt' => new Expression('NOW()'),
                'updatedAt' => new Expression('NOW()'),
            ]);
            $item['id'] = $this->db->getLastInsertID();
            if (isset($item['items'])) {
                foreach ($item['items'] as $title) {
                    $this->saveMenuItem(['name' => $title], $section, $item);
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
            [
                'name' => 'Каталог',
                'alias' => 'catalog',
            ],
            [
                'name' => 'Советы',
                'alias' => 'tips',
            ],
            [
                'name' => 'Компания',
                'alias' => 'about',
            ],
            [
                'name' => 'Контакты',
                'alias' => 'contacts',
            ],
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
                'alias' => 'buyer',
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
                'alias' => 'small-business',
            ],
            [
                'name' => 'Дистрибьютерам',
                'alias' => 'distributor',
            ],
            [
                'name' => 'Торговым сетям',
                'alias' => 'trading-networks',
            ],
            [
                'name' => 'Производителям',
                'alias' => 'manufacturer',
            ],
        ];
    }
}
