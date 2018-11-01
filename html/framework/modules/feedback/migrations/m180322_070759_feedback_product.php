<?php

use yii\db\Migration;

/**
 * Class m180322_070759_feedback_product
 */
class m180322_070759_feedback_product extends Migration
{
    /**
     * {@inheritdoc}
     */
    public function safeUp()
    {
        $this->addColumn('{{%feedback}}', 'country',
            $this->string()->null()->defaultValue(null)->after('text')
        );

        $this->addColumn('{{%feedback}}', 'productId',
            $this->integer()->null()->defaultValue(null)->after('route')
        );

        $this->addForeignKey(
            'fk-feedback-productId-product-id',
            '{{%feedback}}',
            'productId',
            '{{%product}}',
            'id',
            'SET NULL',
            'CASCADE'
        );
    }

    /**
     * {@inheritdoc}
     */
    public function safeDown()
    {
        $this->dropForeignKey('fk-feedback-productId-product-id', '{{%feedback}}');

        $this->dropColumn('{{%feedback}}', 'productId');
        $this->dropColumn('{{%feedback}}', 'country');
    }

}
