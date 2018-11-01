<?php

use yii\db\Migration;

/**
 * Class m180214_110208_product_set_usage
 */
class m180214_110208_product_set_usage extends Migration
{
    /**
     * @inheritdoc
     */
    public function safeUp()
    {
        $this->addColumn('{{%product_set}}', 'usageId',
            $this->integer()->null()->after('id')
        );

        $this->addForeignKey(
            'fk-product_set_usageId-product_usage_id',
            '{{%product_set}}',
            'usageId',
            '{{%product_usage}}',
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
        $this->dropForeignKey('fk-product_set_usageId-product_usage_id', '{{%product_set}}');

        $this->dropColumn('{{%product_set}}', 'usageId');
    }

}
