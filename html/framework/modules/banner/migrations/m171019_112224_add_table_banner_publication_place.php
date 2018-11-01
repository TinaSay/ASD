<?php

use yii\db\Migration;

class m171019_112224_add_table_banner_publication_place extends Migration
{
    private $_tableName = '{{%banner_publication_place}}';

    public function safeUp()
    {
        $options = ($this->db->getDriverName() === 'mysql') ? 'ENGINE=InnoDB DEFAULT CHARSET=utf8 COLLATE=utf8_unicode_ci' : null;

        $this->createTable($this->_tableName, [
            'bannerId' => $this->integer()->unsigned()->notNull(),
            'placeId' => $this->integer()->unsigned()->notNull(),
        ], $options);

        $this->createIndex('ix-bannerId', $this->_tableName, ['bannerId']);
        $this->createIndex('ix-placeId', $this->_tableName, ['placeId']);
    }

    public function safeDown()
    {
        $this->dropTable($this->_tableName);
    }
}
