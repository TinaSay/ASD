<?php

use yii\db\Migration;

/**
 * Class m180130_053959_product_section
 */
class m180130_053959_product_section extends Migration
{
    public function safeUp()
    {
        $options = ($this->db->getDriverName() === 'mysql') ? 'ENGINE=InnoDB DEFAULT CHARSET=utf8 COLLATE=utf8_unicode_ci' : null;

        $this->createTable('{{%product_section}}', [
            'id' => $this->primaryKey(),
            'parentId' => $this->integer()->null(),
            'uuid' => $this->string(36)->null(),
            'title' => $this->string(255)->notNull(),
            'position' => $this->integer()->notNull()->defaultValue('0'),
            'depth' => $this->integer()->notNull()->defaultValue('0'),
            'hidden' => $this->smallInteger(1)->notNull()->defaultValue(1),
            'createdAt' => $this->dateTime()->null()->defaultValue(null),
            'updatedAt' => $this->dateTime()->null()->defaultValue(null),
        ], $options);

        $this->createIndex('uuid', '{{%product_section}}', ['uuid'], true);
        $this->createIndex('hidden', '{{%product_section}}', ['hidden']);

        $this->addForeignKey(
            'fk-product_section_parentId-product_section_id',
            '{{%product_section}}',
            'parentId',
            '{{%product_section}}',
            'id',
            'SET NULL',
            'CASCADE'
        );
    }

    public function safeDown()
    {
        $this->dropForeignKey('fk-product_section_parentId-product_section_id', '{{%product_section}}');
        $this->dropTable('{{%product_section}}');
    }
}
