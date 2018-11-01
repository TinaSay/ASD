<?php

use yii\db\Migration;

/**
 * Class m180620_055258_product_section_useage_description
 */
class m180620_055258_product_section_useage_description extends Migration
{
    /**
     * {@inheritdoc}
     */
    public function safeUp()
    {
        $options = ($this->db->getDriverName() === 'mysql') ? 'ENGINE=InnoDB DEFAULT CHARSET=utf8 COLLATE=utf8_unicode_ci' : null;

        $this->createTable('{{%product_usage_section_text}}', [
            'id' => $this->primaryKey(),
            'usageId' => $this->integer()->null(),
            'sectionId' => $this->integer()->null(),
            'title' => $this->string()->notNull(),
            'text' => $this->text(),
            'hidden' => $this->smallInteger(1)->notNull()->defaultValue(1),
            'language' => $this->string(8)->notNull()->defaultValue('ru-RU'),
            'createdAt' => $this->dateTime()->null()->defaultValue(null),
            'updatedAt' => $this->dateTime()->null()->defaultValue(null),
        ], $options);

        $this->createIndex('language', '{{%product_usage_section_text}}', ['language']);

        $this->addForeignKey(
            'fk-product_usage_sect_text_sectionId-product_section_id',
            '{{%product_usage_section_text}}',
            'sectionId',
            '{{%product_section}}',
            'id',
            'SET NULL',
            'CASCADE'
        );


        $this->addForeignKey(
            'fk-product_usage_sect_text_usageId-product_usage_id',
            '{{%product_usage_section_text}}',
            'usageId',
            '{{%product_usage}}',
            'id',
            'SET NULL',
            'CASCADE'
        );

    }

    public function safeDown()
    {
        $this->dropForeignKey('fk-product_usage_sect_text_usageId-product_usage_id', '{{%product_usage_section_text}}');
        $this->dropForeignKey('fk-product_usage_sect_text_sectionId-product_section_id',
            '{{%product_usage_section_text}}');
        $this->dropTable('{{%product_usage_section_text}}');
    }

}
