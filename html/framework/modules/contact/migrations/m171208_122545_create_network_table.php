<?php

use yii\db\Migration;

/**
 * Handles the creation of table `network`.
 */
class m171208_122545_create_network_table extends Migration
{
    private $_tableName = '{{%network}}';

    /**
     * @inheritdoc
     */
    public function up()
    {
        $options = ($this->db->getDriverName() === 'mysql') ? 'ENGINE=InnoDB DEFAULT CHARSET=utf8 COLLATE=utf8_unicode_ci' : null;
        $this->createTable($this->_tableName, [
            'id' => $this->primaryKey(),
            'title' => $this->string(),
            'url' => $this->string(),
            'icon' => $this->string(),
            'hidden' => $this->smallInteger(),
            'createdAt' => $this->dateTime(),
            'updatedAt' => $this->dateTime(),
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
