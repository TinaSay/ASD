<?php

use yii\db\Migration;

/**
 * Class m180131_072935_product_property_value
 */
class m180131_072935_product_property_value extends Migration
{
    public function safeUp()
    {
        $options = ($this->db->getDriverName() === 'mysql') ? 'ENGINE=InnoDB DEFAULT CHARSET=utf8 COLLATE=utf8_unicode_ci' : null;

        $this->createTable('{{%product_property_value}}', [
            'id' => $this->primaryKey(),
            'productId' => $this->integer()->null(),
            'propertyId' => $this->integer()->null(),
            'value' => $this->string(255)->notNull(),
        ], $options);

        $this->addForeignKey(
            'fk-product_property_value_productId-product_id',
            '{{%product_property_value}}',
            'productId',
            '{{%product}}',
            'id',
            'SET NULL',
            'CASCADE'
        );

        $this->addForeignKey(
            'fk-product_property_value_propertyId-product_property_id',
            '{{%product_property_value}}',
            'propertyId',
            '{{%product_property}}',
            'id',
            'SET NULL',
            'CASCADE'
        );
    }

    public function safeDown()
    {
        $this->dropForeignKey('fk-product_property_value_productId-product_id', '{{%product_property_value}}');
        $this->dropForeignKey('fk-product_property_value_propertyId-product_property_id',
            '{{%product_property_value}}');
        $this->dropTable('{{%product_property_value}}');
    }
}
