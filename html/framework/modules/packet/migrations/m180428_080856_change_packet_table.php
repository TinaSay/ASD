<?php

use yii\db\Migration;

/**
 * Class m180428_080856_change_packet_table
 */
class m180428_080856_change_packet_table extends Migration
{

    protected $_tableName = '{{%packet}}';

    /**
     * {@inheritdoc}
     */
    public function safeUp()
    {
        $this->update($this->_tableName, ['sent' => 0], 'sent IS NULL');
        $this->alterColumn($this->_tableName, 'sent', $this->smallInteger(1)->notNull()->defaultValue('0'));
    }

    /**
     * {@inheritdoc}
     */
    public function safeDown()
    {
        return true;
    }

}
