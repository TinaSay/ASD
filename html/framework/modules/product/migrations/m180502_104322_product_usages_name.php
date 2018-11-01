<?php

use yii\db\Migration;

/**
 * Class m180502_104322_product_usages_name
 */
class m180502_104322_product_usages_name extends Migration
{
    /**
     * {@inheritdoc}
     */
    public function safeUp()
    {
        $this->addColumn('{{%product_usage}}', 'name',
            $this->string()->null()->after('title')
        );
    }

    /**
     * {@inheritdoc}
     */
    public function safeDown()
    {
        $this->dropColumn('{{%product_usage}}', 'name');
    }

}
