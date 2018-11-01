<?php

use yii\db\Migration;

/**
 * Class m180205_063925_product_promo
 */
class m180205_063925_product_promo extends Migration
{
    public function safeUp()
    {
        $options = ($this->db->getDriverName() === 'mysql') ? 'ENGINE=InnoDB DEFAULT CHARSET=utf8 COLLATE=utf8_unicode_ci' : null;

        $this->createTable('{{%product_promo}}', [
            'id' => $this->primaryKey(),
            'uuid' => $this->string(36)->null(),
            'title' => $this->string(255)->notNull(),
            'color' => $this->string(8)->notNull(),
            'hidden' => $this->smallInteger(1)->notNull()->defaultValue(1),
            'createdAt' => $this->dateTime()->null()->defaultValue(null),
            'updatedAt' => $this->dateTime()->null()->defaultValue(null),
        ], $options);

        $this->createIndex('uuid', '{{%product_promo}}', ['uuid'], true);
        $this->createIndex('hidden', '{{%product_promo}}', ['hidden']);
    }

    public function safeDown()
    {
        $this->dropTable('{{%product_promo}}');
    }

}
