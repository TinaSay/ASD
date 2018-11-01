<?php

use yii\db\Migration;

class m170601_095037_oauth extends Migration
{
    public function safeUp()
    {
        $options = ($this->db->getDriverName() === 'mysql') ? 'ENGINE=InnoDB DEFAULT CHARSET=utf8 COLLATE=utf8_unicode_ci' : null;

        $this->createTable('{{%auth_oauth}}', [
            'id' => $this->primaryKey(),
            'auth_id' => $this->integer(11)->notNull(),
            'source' => $this->string(256)->notNull(),
            'source_id' => $this->string(256)->notNull(),
            'created_at' => $this->dateTime()->null()->defaultValue(null),
            'updated_at' => $this->dateTime()->null()->defaultValue(null),
        ], $options);

        $this->createIndex('auth_id', '{{%auth_oauth}}', ['auth_id']);
        $this->addForeignKey(
            'auth_oauth_auth_id_auth_id',
            '{{%auth_oauth}}',
            ['auth_id'],
            '{{%auth}}',
            ['id'],
            'CASCADE',
            'RESTRICT'
        );
    }

    public function safeDown()
    {
        $this->dropForeignKey('auth_oauth_auth_id_auth_id', '{{%auth_oauth}}');
        $this->dropTable('{{%auth_oauth}}');
    }
}
