<?php

use yii\db\Migration;

class m180201_210723_set_null_file_in_table_promo_block extends Migration
{
    private $_tableName = '{{%promo_block}}';

    public function up()
    {
        $this->alterColumn($this->_tableName, 'file', $this->string(500)->null());
    }

    public function down()
    {
        $this->alterColumn($this->_tableName, 'file', $this->string(500)->notNull());
    }
}
