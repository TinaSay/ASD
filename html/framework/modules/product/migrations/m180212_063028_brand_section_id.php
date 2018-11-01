<?php

use yii\db\Migration;

/**
 * Class m180212_063028_brand_section_id
 */
class m180212_063028_brand_section_id extends Migration
{
    /**
     * @inheritdoc
     */
    public function safeUp()
    {
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

    /**
     * @inheritdoc
     */
    public function safeDown()
    {
        $this->dropForeignKey('fk-product_brand_sectionId-product_section_id', '{{%product_brand}}');
        $this->dropColumn('{{%product_brand}}', 'sectionId');
    }

}
