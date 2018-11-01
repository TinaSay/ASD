<?php

use yii\db\Migration;

class m170531_112237_log extends Migration
{
    public function safeUp()
    {
        $options = ($this->db->getDriverName() === 'mysql') ? 'ENGINE=InnoDB DEFAULT CHARSET=utf8 COLLATE=utf8_unicode_ci' : null;

        $this->createTable('{{%auth_log}}', [
            'id' => $this->primaryKey(),
            'auth_id' => $this->integer(11)->null()->defaultValue(null),
            'status' => $this->smallInteger(1)->null()->defaultValue(null),
            'ip' => $this->bigInteger(20)->null()->defaultValue(null),
            'created_at' => $this->dateTime()->null()->defaultValue(null),
            'updated_at' => $this->dateTime()->null()->defaultValue(null),
        ], $options);

        $this->createIndex('auth_id', '{{%auth_log}}', ['auth_id']);
        $this->addForeignKey(
            'auth_log_auth_id_auth_id',
            '{{%auth_log}}',
            ['auth_id'],
            '{{%auth}}',
            ['id'],
            'SET NULL',
            'RESTRICT'
        );
    }

    public function safeDown()
    {
        $this->dropForeignKey('auth_log_auth_id_auth_id', '{{%auth_log}}');
        $this->dropTable('{{%auth_log}}');
    }
}
