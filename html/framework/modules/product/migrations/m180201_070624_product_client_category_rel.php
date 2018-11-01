<?php

use yii\db\Migration;

/**
 * Class m180201_070624_product_client_category_rel
 */
class m180201_070624_product_client_category_rel extends Migration
{
    public function safeUp()
    {
        $options = ($this->db->getDriverName() === 'mysql') ? 'ENGINE=InnoDB DEFAULT CHARSET=utf8 COLLATE=utf8_unicode_ci' : null;

        $this->createTable('{{%product_client_category_rel}}', [
            'id' => $this->primaryKey(),
            'productId' => $this->integer()->null(),
            'clientCategoryId' => $this->integer()->null(),
        ], $options);

        $this->addForeignKey(
            'fk-product_cc_rel_productId-product_id',
            '{{%product_client_category_rel}}',
            'productId',
            '{{%product}}',
            'id',
            'SET NULL',
            'CASCADE'
        );

        $this->addForeignKey(
            'fk-product_cc_rel_clientCategoryId-product_cc_id',
            '{{%product_client_category_rel}}',
            'clientCategoryId',
            '{{%product_client_category}}',
            'id',
            'SET NULL',
            'CASCADE'
        );
    }

    public function safeDown()
    {
        $this->dropForeignKey('fk-product_cc_rel_clientCategoryId-product_cc_id', '{{%product_client_category_rel}}');
        $this->dropForeignKey('fk-product_cc_rel_productId-product_id', '{{%product_client_category_rel}}');
        $this->dropTable('{{%product_client_category_rel}}');
    }
}
