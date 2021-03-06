<?php

use yii\db\Migration;

/**
 * Class m180205_103259_product_set
 */
class m180205_103259_product_set extends Migration
{
    public function safeUp()
    {
        $options = ($this->db->getDriverName() === 'mysql') ? 'ENGINE=InnoDB DEFAULT CHARSET=utf8 COLLATE=utf8_unicode_ci' : null;

        $this->createTable('{{%product_set}}', [
            'id' => $this->primaryKey(),
            'uuid' => $this->string(36)->null(),
            'title' => $this->string(255)->notNull(),
            'category' => $this->string(255)->notNull()->defaultValue(''),
            'description' => $this->string(512)->notNull(),
            'hidden' => $this->smallInteger(1)->notNull()->defaultValue(1),
            'createdAt' => $this->dateTime()->null()->defaultValue(null),
            'updatedAt' => $this->dateTime()->null()->defaultValue(null),
        ], $options);

        $this->createIndex('uuid', '{{%product_set}}', ['uuid'], true);
        $this->createIndex('hidden', '{{%product_set}}', ['hidden']);
    }

    public function safeDown()
    {
        $this->dropTable('{{%product_set}}');
    }
}
