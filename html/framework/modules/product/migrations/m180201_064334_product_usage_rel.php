<?php

use yii\db\Migration;

/**
 * Class m180201_064334_product_usage_rel
 */
class m180201_064334_product_usage_rel extends Migration
{
    public function safeUp()
    {
        $options = ($this->db->getDriverName() === 'mysql') ? 'ENGINE=InnoDB DEFAULT CHARSET=utf8 COLLATE=utf8_unicode_ci' : null;

        $this->createTable('{{%product_usage_rel}}', [
            'id' => $this->primaryKey(),
            'productId' => $this->integer()->null(),
            'usageId' => $this->integer()->null(),
        ], $options);

        $this->addForeignKey(
            'fk-product_usage_rel_productId-product_id',
            '{{%product_usage_rel}}',
            'productId',
            '{{%product}}',
            'id',
            'SET NULL',
            'CASCADE'
        );

        $this->addForeignKey(
            'fk-product_usage_rel_usageId-product_usage_id',
            '{{%product_usage_rel}}',
            'usageId',
            '{{%product_usage}}',
            'id',
            'SET NULL',
            'CASCADE'
        );
    }

    public function safeDown()
    {
        $this->dropForeignKey('fk-product_usage_rel_productId-product_id', '{{%product_usage_rel}}');
        $this->dropForeignKey('fk-product_usage_rel_usageId-product_usage_id', '{{%product_usage_rel}}');
        $this->dropTable('{{%product_usage_rel}}');
    }
}
