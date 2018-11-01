<?php

use yii\db\Migration;

/**
 * Handles the creation of table `feedback`.
 */
class m171104_063941_create_feedback_table extends Migration
{

    private $_tableName = '{{%feedback}}';

    /**
     * @inheritdoc
     */
    public function up()
    {
        $this->createTable($this->_tableName, [
            'id' => $this->primaryKey(),
            'date_add' => $this->datetime(),
            'msg_type' => $this->integer(1),
            'fio' => $this->string(255),
            'phone' => $this->string(100),
            'email' => $this->string(100),
            'company' => $this->string(100),
            'text' => $this->text(),
            'city' => $this->string(50),
            'date_sent' => $this->datetime(),
            'status' => $this->integer(1),
            'date_edited' => $this->datetime(),
        ]);
    }

    /**
     * @inheritdoc
     */
    public function down()
    {
        $this->dropTable($this->_tableName);
    }
}
