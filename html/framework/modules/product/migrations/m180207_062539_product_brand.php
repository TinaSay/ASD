<?php

use yii\db\Migration;

/**
 * Class m180207_062539_product_brand
 */
class m180207_062539_product_brand extends Migration
{
    /**
     * @inheritdoc
     */
    public function safeUp()
    {

        $options = ($this->db->getDriverName() === 'mysql') ? 'ENGINE=InnoDB DEFAULT CHARSET=utf8 COLLATE=utf8_unicode_ci' : null;

        $this->createTable('{{%product_brand}}', [
            'id' => $this->primaryKey(),
            'uuid' => $this->string(36)->null(),
            'title' => $this->string(255)->notNull(),
            'description' => $this->string(512)->notNull()->defaultValue(''),
            'text' => $this->text()->null(),
            'position' => $this->integer()->notNull()->defaultValue(0),
            'hidden' => $this->smallInteger(1)->notNull()->defaultValue(1),
            'createdAt' => $this->dateTime()->null()->defaultValue(null),
            'updatedAt' => $this->dateTime()->null()->defaultValue(null),
        ], $options);

        $this->createIndex('uuid', '{{%product_brand}}', ['uuid'], true);
        $this->createIndex('hidden', '{{%product_brand}}', ['hidden']);

        $this->dropForeignKey('fk-product_brandId-brand_id', '{{%product}}');

        \app\modules\product\models\Product::updateAll([
            'brandId' => null,
        ]);

        $this->addForeignKey(
            'fk-product_brandId-product_brand_id',
            '{{%product}}',
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
        $this->dropForeignKey('fk-product_brandId-product_brand_id', '{{%product}}');

        $this->addForeignKey(
            'fk-product_brandId-brand_id',
            '{{%product}}',
            'brandId',
            '{{%brand}}',
            'id',
            'SET NULL',
            'CASCADE'
        );

        $this->dropTable('{{%product_brand}}');
    }

}
