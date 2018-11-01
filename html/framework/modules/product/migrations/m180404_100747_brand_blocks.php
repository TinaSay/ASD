<?php

use yii\db\Migration;

/**
 * Class m180404_100747_brand_blocks
 */
class m180404_100747_brand_blocks extends Migration
{
    /**
     * @inheritdoc
     */
    public function safeUp()
    {

        $options = ($this->db->getDriverName() === 'mysql') ? 'ENGINE=InnoDB DEFAULT CHARSET=utf8 COLLATE=utf8_unicode_ci' : null;

        $this->createTable('{{%product_brand_block}}', [
            'id' => $this->primaryKey(),
            'brandId' => $this->integer()->null(),
            'title' => $this->string(255)->notNull(),
            'value' => $this->string(255)->notNull()->defaultValue(''),
            'description' => $this->string(255)->notNull()->defaultValue(''),
            'hidden' => $this->smallInteger(1)->notNull()->defaultValue(1),
            'createdAt' => $this->dateTime()->null()->defaultValue(null),
            'updatedAt' => $this->dateTime()->null()->defaultValue(null),
        ], $options);

        $this->createIndex('hidden', '{{%product_brand_block}}', ['hidden']);

        $this->addForeignKey(
            'fk-product_brand_block_brandId-product_brand_id',
            '{{%product_brand_block}}',
            'brandId',
            '{{%product_brand}}',
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
        $this->dropForeignKey('fk-product_brand_block_brandId-product_brand_id', '{{%product}}');

        $this->dropTable('{{%product_brand_block}}');
    }
}
