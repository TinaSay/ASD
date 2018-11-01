<?php

use yii\db\Migration;

/**
 * Class m180205_103301_product_set_rel
 */
class m180205_103301_product_set_rel extends Migration
{
    public function safeUp()
    {
        $options = ($this->db->getDriverName() === 'mysql') ? 'ENGINE=InnoDB DEFAULT CHARSET=utf8 COLLATE=utf8_unicode_ci' : null;

        $this->createTable('{{%product_set_rel}}', [
            'id' => $this->primaryKey(),
            'productId' => $this->integer()->null(),
            'setId' => $this->integer()->null(),
            'quantity' => $this->integer()->notNull()->defaultValue(0),
        ], $options);

        $this->addForeignKey(
            'fk-product_set_rel_productId-product_id',
            '{{%product_set_rel}}',
            'productId',
            '{{%product}}',
            'id',
            'SET NULL',
            'CASCADE'
        );

        $this->addForeignKey(
            'fk-product_set_rel_setId-product_section_id',
            '{{%product_set_rel}}',
            'setId',
            '{{%product_section}}',
            'id',
            'SET NULL',
            'CASCADE'
        );
    }

    public function safeDown()
    {
        $this->dropForeignKey('fk-product_set_rel_productId-product_id', '{{%product_set_rel}}');
        $this->dropForeignKey('fk-product_set_rel_setId-product_section_id', '{{%product_set_rel}}');
        $this->dropTable('{{%product_set_rel}}');
    }
}
