<?php

use yii\db\Migration;

class m170901_104940_menu extends Migration
{
    public function safeUp()
    {
        $options = ($this->db->getDriverName() === 'mysql') ? 'ENGINE=InnoDB DEFAULT CHARSET=utf8 COLLATE=utf8_unicode_ci' : null;
        $this->createTable('{{%menu}}', [
            'id' => $this->primaryKey(),
            'name' => $this->string(256)->notNull()->defaultValue(''),
            'typeMenu' => $this->smallInteger(1)->notNull()->defaultValue(0),
            'parentId' => $this->integer(11)->notNull()->defaultValue(0),
            'position' => $this->integer(11)->notNull()->defaultValue(0),
            'depth' => $this->smallInteger(3)->notNull()->defaultValue(0),
            'url' => $this->string(256)->notNull()->defaultValue(''),
            'link' => $this->string(256)->notNull()->defaultValue(''),
            'language' => $this->string(8)->notNull()->defaultValue(''),
            'hidden' => $this->smallInteger(1)->notNull()->defaultValue(0),
            'createdBy' => $this->integer(11),
            'createdAt' => $this->dateTime()->null()->defaultValue(null),
            'updatedAt' => $this->dateTime()->null()->defaultValue(null),
        ], $options);

        $this->createIndex('parentId', '{{%menu}}', ['parentId']);
        $this->createIndex('position', '{{%menu}}', ['position']);
        $this->createIndex('language', '{{%menu}}', ['language']);
        $this->createIndex('hidden', '{{%menu}}', ['hidden']);

        $this->addForeignKey(
            'fk-menu-auth',
            '{{%menu}}',
            'createdBy',
            '{{%auth}}',
            'id',
            'SET NULL',
            'RESTRICT'
        );
    }

    public function safeDown()
    {
        $this->dropForeignKey('fk-menu-auth', '{{%menu}}');
        $this->dropTable('{{%menu}}');
    }
}
