<?php

use yii\db\Migration;

/**
 * Class m180209_062926_product_rel
 */
class m180209_062926_product_rel extends Migration
{
    public function safeUp()
    {
        $options = ($this->db->getDriverName() === 'mysql') ? 'ENGINE=InnoDB DEFAULT CHARSET=utf8 COLLATE=utf8_unicode_ci' : null;

        $this->createTable('{{%product_rel}}', [
            'id' => $this->primaryKey(),
            'productId' => $this->integer()->null(),
            'relatedId' => $this->integer()->null(),
        ], $options);

        $this->addForeignKey(
            'fk-product_rel_productId-product_id',
            '{{%product_rel}}',
            'productId',
            '{{%product}}',
            'id',
            'SET NULL',
            'CASCADE'
        );

        $this->addForeignKey(
            'fk-product_rel_relatedId-product_id',
            '{{%product_rel}}',
            'relatedId',
            '{{%product}}',
            'id',
            'SET NULL',
            'CASCADE'
        );
    }

    public function safeDown()
    {
        $this->dropForeignKey('fk-product_rel_productId-product_id', '{{%product_rel}}');
        $this->dropForeignKey('fk-product_rel_relatedId-product_id', '{{%product_rel}}');
        $this->dropTable('{{%product_rel}}');
    }
}
