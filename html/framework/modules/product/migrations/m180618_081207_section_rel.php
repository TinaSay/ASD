<?php

use yii\db\Migration;

/**
 * Class m180618_081207_section_rel
 */
class m180618_081207_section_rel extends Migration
{
    /**
     * {@inheritdoc}
     */
    public function safeUp()
    {
        $this->dropForeignKey('fk-product_section_brandId-product_brand_id', '{{%product_section}}');
        $this->dropColumn('{{%product_section}}', 'brandId');

        $options = ($this->db->getDriverName() === 'mysql') ? 'ENGINE=InnoDB DEFAULT CHARSET=utf8 COLLATE=utf8_unicode_ci' : null;

        $this->createTable('{{%product_brand_section_rel}}', [
            'id' => $this->primaryKey(),
            'brandId' => $this->integer()->null(),
            'sectionId' => $this->integer()->null(),
        ], $options);

        $this->addForeignKey(
            'fk-product_brand_sect_rel_sectionId-product_section_id',
            '{{%product_brand_section_rel}}',
            'sectionId',
            '{{%product_section}}',
            'id',
            'SET NULL',
            'CASCADE'
        );


        $this->addForeignKey(
            'fk-product_brand_sect_rel_brandId-product_brand_id',
            '{{%product_brand_section_rel}}',
            'brandId',
            '{{%product_brand}}',
            'id',
            'SET NULL',
            'CASCADE'
        );

    }

    public function safeDown()
    {
        $this->dropForeignKey('fk-product_brand_sect_rel_brandId-product_brand_id', '{{%product_brand_section_rel}}');
        $this->dropForeignKey('fk-product_brand_sect_rel_sectionId-product_section_id',
            '{{%product_brand_section_rel}}');
        $this->dropTable('{{%product_brand_section_rel}}');
    }
}
