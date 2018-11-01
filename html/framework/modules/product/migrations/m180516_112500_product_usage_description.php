<?php

use yii\db\Migration;

/**
 * Class m180516_112500_product_usage_description
 */
class m180516_112500_product_usage_description extends Migration
{
    /**
     * {@inheritdoc}
     */
    public function safeUp()
    {
        $this->addColumn('{{%product_usage}}', 'description',
            $this->string(512)->null()->after('name')
        );
    }

    /**
     * {@inheritdoc}
     */
    public function safeDown()
    {
        $this->dropColumn('{{%product_usage}}', 'description');
    }
}
