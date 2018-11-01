<?php

use yii\db\Migration;

/**
 * Class m180205_063928_product_promo_rel
 */
class m180205_063928_product_promo_rel extends Migration
{
    public function safeUp()
    {
        $options = ($this->db->getDriverName() === 'mysql') ? 'ENGINE=InnoDB DEFAULT CHARSET=utf8 COLLATE=utf8_unicode_ci' : null;

        $this->createTable('{{%product_promo_rel}}', [
            'id' => $this->primaryKey(),
            'productId' => $this->integer()->null(),
            'promoId' => $this->integer()->null(),
        ], $options);

        $this->addForeignKey(
            'fk-product_promo_rel_productId-product_id',
            '{{%product_promo_rel}}',
            'productId',
            '{{%product}}',
            'id',
            'SET NULL',
            'CASCADE'
        );

        $this->addForeignKey(
            'fk-product_promo_rel_promoId-product_promo_id',
            '{{%product_promo_rel}}',
            'promoId',
            '{{%product_promo}}',
            'id',
            'SET NULL',
            'CASCADE'
        );
    }

    public function safeDown()
    {
        $this->dropForeignKey('fk-product_promo_rel_productId-product_id', '{{%product_promo_rel}}');
        $this->dropForeignKey('fk-product_promo_rel_promoId-product_promo_id', '{{%product_promo_rel}}');
        $this->dropTable('{{%product_promo_rel}}');
    }
}
