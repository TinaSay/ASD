<?php

use yii\db\Migration;

/**
 * Class m180131_071653_product_property
 */
class m180131_071653_product_property extends Migration
{
    public function safeUp()
    {
        $options = ($this->db->getDriverName() === 'mysql') ? 'ENGINE=InnoDB DEFAULT CHARSET=utf8 COLLATE=utf8_unicode_ci' : null;

        $this->createTable('{{%product_property}}', [
            'id' => $this->primaryKey(),
            'code' => $this->string(127)->notNull(),
            'title' => $this->string(255)->notNull(),
            'createdAt' => $this->dateTime()->null()->defaultValue(null),
            'updatedAt' => $this->dateTime()->null()->defaultValue(null),
        ], $options);

        $this->createIndex('code', '{{%product_property}}', ['code']);
    }

    public function safeDown()
    {
        $this->dropTable('{{%product_property}}');
    }
}
