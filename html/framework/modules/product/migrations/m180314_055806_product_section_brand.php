<?php

use yii\db\Migration;

/**
 * Class m180314_055806_product_section_brand
 */
class m180314_055806_product_section_brand extends Migration
{
    /**
     * {@inheritdoc}
     */
    public function safeUp()
    {

        $this->dropForeignKey('fk-product_brand_sectionId-product_section_id', '{{%product_brand}}');
        $this->dropColumn('{{%product_brand}}', 'sectionId');

        $this->addColumn('{{%product_section}}', 'brandId',
            $this->integer()->null()->after('parentId')
        );

        $this->addForeignKey(
            'fk-product_section_brandId-product_brand_id',
            '{{%product_section}}',
            'brandId',
            '{{%product_brand}}',
            'id',
            'SET NULL',
            'CASCADE'
        );
    }

    /**
     * {@inheritdoc}
     */
    public function safeDown()
    {
        $this->dropForeignKey('fk-product_section_brandId-product_brand_id', '{{%product_section}}');
        $this->dropColumn('{{%product_section}}', 'brandId');

        $this->addColumn('{{%product_brand}}', 'sectionId',
            $this->integer()->null()->after('id')
        );

        $this->addForeignKey(
            'fk-product_brand_sectionId-product_section_id',
            '{{%product_brand}}',
            'sectionId',
            '{{%product_section}}',
            'id',
            'SET NULL',
            'CASCADE'
        );
    }

}
