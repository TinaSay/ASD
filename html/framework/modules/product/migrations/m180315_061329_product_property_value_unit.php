<?php

use yii\db\Migration;

/**
 * Class m180315_061329_product_property_value_unit
 */
class m180315_061329_product_property_value_unit extends Migration
{
    /**
     * {@inheritdoc}
     */
    public function safeUp()
    {
        $this->addColumn('{{%product_property_value}}', 'unit', $this->string(7)->null()->defaultValue(null));
    }

    /**
     * {@inheritdoc}
     */
    public function safeDown()
    {
        $this->dropColumn('{{%product_property_value}}', 'unit');
    }

}
