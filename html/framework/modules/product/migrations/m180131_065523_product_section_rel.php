<?php

use yii\db\Migration;

/**
 * Class m180131_065523_product_section_rel
 */
class m180131_065523_product_section_rel extends Migration
{
    public function safeUp()
    {
        $options = ($this->db->getDriverName() === 'mysql') ? 'ENGINE=InnoDB DEFAULT CHARSET=utf8 COLLATE=utf8_unicode_ci' : null;

        $this->createTable('{{%product_section_rel}}', [
            'id' => $this->primaryKey(),
            'productId' => $this->integer()->null(),
            'sectionId' => $this->integer()->null(),
        ], $options);

        $this->addForeignKey(
            'fk-product_section_rel_productId-product_id',
            '{{%product_section_rel}}',
            'productId',
            '{{%product}}',
            'id',
            'SET NULL',
            'CASCADE'
        );

        $this->addForeignKey(
            'fk-product_section_rel_sectionId-product_section_id',
            '{{%product_section_rel}}',
            'sectionId',
            '{{%product_section}}',
            'id',
            'SET NULL',
            'CASCADE'
        );
    }

    public function safeDown()
    {
        $this->dropForeignKey('fk-product_section_rel_productId-product_id', '{{%product_section_rel}}');
        $this->dropForeignKey('fk-product_section_rel_sectionId-product_section_id', '{{%product_section_rel}}');
        $this->dropTable('{{%product_section_rel}}');
    }
}
