<?php

use yii\db\Migration;

class m171024_112223_add_table_promo_block extends Migration
{
    private $_tableName = '{{%promo_block}}';

    public function safeUp()
    {
        $options = ($this->db->getDriverName() === 'mysql') ? 'ENGINE=InnoDB DEFAULT CHARSET=utf8 COLLATE=utf8_unicode_ci' : null;

        $this->createTable($this->_tableName, [
            'id' => $this->primaryKey(),
            'title' => $this->string(255)->notNull(),
            'signature' => $this->string(255)->notNull(),
            'file' => $this->string(500)->notNull(),
            'imageType' => $this->smallInteger()->notNull()->defaultValue(0),
            'url' => $this->string(1000)->notNull(),
            'hidden' => $this->smallInteger(1)->notNull()->defaultValue(0),
            'createdAt' => $this->dateTime()->null()->defaultValue(null),
            'updatedAt' => $this->dateTime()->null()->defaultValue(null),
            'position' => $this->integer()->notNull()->defaultValue(0),
        ], $options);

        $this->createIndex('ix-title', $this->_tableName, ['title']);
        $this->createIndex('ix-hidden', $this->_tableName, ['hidden']);
    }

    public function safeDown()
    {
        $this->dropTable($this->_tableName);
    }
}
