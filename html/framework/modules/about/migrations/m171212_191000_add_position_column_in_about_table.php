<?php

use yii\db\Migration;

class m171212_191000_add_position_column_in_about_table extends Migration
{
    /**
     * @var string
     */
    private $tableName = '{{%about}}';
    
    public function safeUp()
    {
        $this->addColumn($this->tableName, 'position', 'TINYINT(1) DEFAULT 0');
    }

    public function safeDown()
    {
        $this->dropColumn($this->tableName, 'position');
    }
}
