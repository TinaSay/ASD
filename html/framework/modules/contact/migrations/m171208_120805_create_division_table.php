<?php

use yii\db\Migration;

/**
 * Handles the creation of table `division`.
 */
class m171208_120805_create_division_table extends Migration
{

    private $_tableName = '{{%division}}';

    /**
     * @inheritdoc
     */
    public function up()
    {
        $options = ($this->db->getDriverName() === 'mysql') ? 'ENGINE=InnoDB DEFAULT CHARSET=utf8 COLLATE=utf8_unicode_ci' : null;
        $this->createTable($this->_tableName, [
            'id' => $this->primaryKey(),
            'title' => $this->string(255),
            'subtitle' => $this->string(255),
            'phone' => $this->string(255),
            'address' => $this->string(255),
            'metro' => $this->string(1000),
            'email' => $this->string(100),
            'working' => $this->string(255),
            'requisite' => $this->string(255),
            'position' => $this->smallInteger(2),
            'createdAt' => $this->dateTime(),
            'updatedAt' => $this->dateTime(),
            'hidden' => $this->smallInteger(1),
        ], $options);

        $this->createIndex('idx-title', $this->_tableName, ['title']);
        $this->createIndex('idx-hidden', $this->_tableName, ['hidden']);
    }

    /**
     * @inheritdoc
     */
    public function down()
    {
        $this->dropTable($this->_tableName);
    }
}
