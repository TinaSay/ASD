<?php

use yii\db\Migration;

/**
 * Handles the creation of table `metro`.
 */
class m180104_056610_create_contact_setting_table extends Migration
{

    private $_tableName = '{{%contactsetting}}';

    /**
     * @inheritdoc
     */
    public function up()
    {
        $options = ($this->db->getDriverName() === 'mysql') ? 'ENGINE=InnoDB DEFAULT CHARSET=utf8 COLLATE=utf8_unicode_ci' : null;
        $this->createTable($this->_tableName, [
            'id' => $this->primaryKey(),
            'name' => $this->string(50),
            'value' => $this->string(255),
            'label' => $this->string(255),
        ], $options);

        $this->batchInsert($this->_tableName, ['name', 'value', 'label'], [
            ['code', '', 'Код страны и города'],
            ['phone', '', 'Номер телефона'],
            ['title', '', 'Заголовок'],
            ['text', '', 'Текст'],
            ['subtitle', '', 'Заголовок'],
            ['subtext', '', 'Текст'],
            ['rules', '', 'Сообщение о правах'],
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
