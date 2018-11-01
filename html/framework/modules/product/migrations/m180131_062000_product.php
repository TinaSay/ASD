<?php

use yii\db\Migration;

/**
 * Class m180131_062000_product
 */
class m180131_062000_product extends Migration
{
    public function safeUp()
    {
        $options = ($this->db->getDriverName() === 'mysql') ? 'ENGINE=InnoDB DEFAULT CHARSET=utf8 COLLATE=utf8_unicode_ci' : null;

        $this->createTable('{{%product}}', [
            'id' => $this->primaryKey(),
            'brandId' => $this->integer()->null(),
            'uuid' => $this->string(36)->null(),
            'article' => $this->string(127)->notNull(),
            'title' => $this->string(255)->notNull(),
            'printableTitle' => $this->string(255)->null(),
            'description' => $this->string(512)->null(),
            'advantages' => $this->text(),
            'text' => $this->text(),
            'hidden' => $this->smallInteger(1)->notNull()->defaultValue(1),
            'createdAt' => $this->dateTime()->null()->defaultValue(null),
            'updatedAt' => $this->dateTime()->null()->defaultValue(null),
        ], $options);

        $this->createIndex('uuid', '{{%product}}', ['uuid'], true);
        $this->createIndex('article', '{{%product}}', ['article']);
        $this->createIndex('hidden', '{{%product}}', ['hidden']);

        $this->addForeignKey(
            'fk-product_brandId-brand_id',
            '{{%product}}',
            'brandId',
            '{{%brand}}',
            'id',
            'SET NULL',
            'CASCADE'
        );
    }

    public function safeDown()
    {
        $this->dropForeignKey('fk-product_brandId-brand_id', '{{%product}}');
        $this->dropTable('{{%product}}');
    }
}
