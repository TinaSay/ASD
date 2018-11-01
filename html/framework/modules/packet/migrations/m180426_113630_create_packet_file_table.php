<?php

use yii\db\Migration;

/**
 * Handles the creation of table `packetFile`.
 */
class m180426_113630_create_packet_file_table extends Migration
{

    private $_tableName = '{{%packet_file}}';

    /**
     * {@inheritdoc}
     */
    public function safeUp()
    {
        $this->createTable($this->_tableName, [
            'id' => $this->primaryKey(),
            'name' => $this->string(),
            'packetId' => $this->integer(),
            'createdBy' => $this->integer(),
            'createdAt' => $this->datetime()->null()->defaultValue(null),
            'updatedAt' => $this->datetime()->null()->defaultValue(null),

            'file' => $this->string(),
        ]);

        $this->createIndex('idx-name', $this->_tableName, ['name']);

        $this->addForeignKey(
            'fk-packet-file-auth',
            $this->_tableName,
            'createdBy',
            '{{%auth}}',
            'id',
            'SET NULL',
            'RESTRICT'
        );
    }

    /**
     * {@inheritdoc}
     */
    public function safeDown()
    {
        $this->dropForeignKey('fk-packet-file-auth', $this->_tableName);
        $this->dropIndex('idx-name', $this->_tableName);
        $this->dropTable($this->_tableName);
    }
}
