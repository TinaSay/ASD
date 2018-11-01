<?php

use yii\db\Migration;

/**
 * Handles the creation of table `packet`.
 */
class m180424_154507_create_packet_table extends Migration
{

    private $_tableName = '{{%packet}}';

    /**
     * {@inheritdoc}
     */
    public function safeUp()
    {
        $options = ($this->db->getDriverName() === 'mysql') ? 'ENGINE=InnoDB DEFAULT CHARSET=utf8 COLLATE=utf8_unicode_ci' : null;

        $this->createTable($this->_tableName, [
            'id' => $this->primaryKey(),
            'subject' => $this->string(),
            'category' => $this->integer(),
            'text' => $this->text(),
            'country' => $this->string()->null()->defaultValue(null),
            'city' => $this->string()->null()->defaultValue(null),
            'byRegion' => $this->smallInteger(),
            'sent' => $this->smallInteger(),
            'createdAt' => $this->datetime()->null()->defaultValue(null),
            'updatedAt' => $this->datetime()->null()->defaultValue(null),
            'createdBy' => $this->integer(),
            'sendAt' => $this->datetime()->null()->defaultValue(null),
        ], $options);


        $this->createIndex('idx-subject', $this->_tableName, ['subject']);
        $this->createIndex('idx-sent', $this->_tableName, ['sent']);
        $this->createIndex('idx-category', $this->_tableName, ['category']);

        $this->addForeignKey(
            'fk-packet-auth',
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
        $this->dropForeignKey('fk-packet-auth', $this->_tableName);
        $this->dropIndex('idx-category', $this->_tableName);
        $this->dropIndex('idx-sent', $this->_tableName);
        $this->dropIndex('idx-subject', $this->_tableName);
        $this->dropTable($this->_tableName);
    }
}
