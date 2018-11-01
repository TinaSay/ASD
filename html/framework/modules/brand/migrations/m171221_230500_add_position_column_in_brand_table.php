<?php

use yii\db\Migration;

class m171221_230500_add_position_column_in_brand_table extends Migration
{
    /**
     * @var string
     */
    private $tableName = '{{%brand}}';
    
    public function safeUp()
    {
        $this->addColumn($this->tableName, 'position', 'TINYINT(1) DEFAULT 0');
    }

    public function safeDown()
    {
        $this->dropColumn($this->tableName, 'position');
    }
}
