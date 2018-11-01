<?php

use yii\db\Migration;

/**
 * Class m180315_053949_product_soft_delete
 */
class m180315_053949_product_soft_delete extends Migration
{
    /**
     * {@inheritdoc}
     */
    public function safeUp()
    {
        $this->addColumn('{{%product}}', 'deletedAt', $this->dateTime()->null()->defaultValue(null));
    }

    /**
     * {@inheritdoc}
     */
    public function safeDown()
    {
        $this->dropColumn('{{%product}}', 'deletedAt');
    }

}
