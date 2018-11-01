<?php

use yii\db\Migration;

/**
 * Class m180130_053057_product_client_category
 */
class m180130_053057_product_client_category extends Migration
{
    public function safeUp()
    {
        $options = ($this->db->getDriverName() === 'mysql') ? 'ENGINE=InnoDB DEFAULT CHARSET=utf8 COLLATE=utf8_unicode_ci' : null;

        $this->createTable('{{%product_client_category}}', [
            'id' => $this->primaryKey(),
            'uuid' => $this->string(36)->null(),
            'title' => $this->string(255)->notNull(),
            'hidden' => $this->smallInteger(1)->notNull()->defaultValue(1),
            'createdAt' => $this->dateTime()->null()->defaultValue(null),
            'updatedAt' => $this->dateTime()->null()->defaultValue(null),
        ], $options);

        $this->createIndex('uuid', '{{%product_client_category}}', ['uuid'], true);
        $this->createIndex('hidden', '{{%product_client_category}}', ['hidden']);
    }

    public function safeDown()
    {
        $this->dropTable('{{%product_client_category}}');
    }
}
