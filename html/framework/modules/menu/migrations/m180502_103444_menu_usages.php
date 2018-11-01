<?php

use elfuvo\menu\models\Menu;
use yii\db\Migration;

/**
 * Class m180502_103444_menu_usages
 */
class m180502_103444_menu_usages extends Migration
{
    /**
     * {@inheritdoc}
     */
    public function safeUp()
    {
        $parent = Menu::findOne(['alias' => 'catalog', 'section' => 'top']);
        $this->insert(Menu::tableName(), [
            'parentId' => $parent ? $parent['id'] : null,
            'title' => 'Сферы применения',
            'alias' => 'usages',
            'route' => 'product/usage/index',
            'depth' => $parent['depth'] + 1,
            'queryParams' => 'section=top',
            'url' => 'catalog/usages',
            'type' => Menu::TYPE_MODULE,
            'section' => 'top',
            'language' => Yii::$app->language,
            'hidden' => Menu::HIDDEN_NO,
            'position' => $parent->position + 1,
            'createdAt' => new \yii\db\Expression('NOW()'),
            'updatedAt' => new \yii\db\Expression('NOW()'),
        ]);
    }

    /**
     * {@inheritdoc}
     */
    public function safeDown()
    {
        Menu::deleteAll([
            'alias' => 'usages',
            'section' => 'top',
        ]);
    }

}
