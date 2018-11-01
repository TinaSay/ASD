<?php

use yii\db\Migration;

/**
 * Class m180614_145734_update_banner
 */
class m180614_145734_update_banner extends Migration
{

    private $_tableName = '{{%banner}}';

    /**
     * {@inheritdoc}
     */
    public function safeUp()
    {
        $this->dropColumn($this->_tableName, 'file');
    }

    /**
     * {@inheritdoc}
     */
    public function safeDown()
    {
        $this->addColumn($this->_tableName, 'file', $this->string(500)->null()->defaultValue(null));
    }

}
