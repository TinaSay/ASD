<?php

use yii\db\Migration;

class m180107_130431_advice_group extends Migration
{
    public function safeUp()
    {
        $options = ($this->db->getDriverName() === 'mysql') ? 'ENGINE=InnoDB DEFAULT CHARSET=utf8 COLLATE=utf8_unicode_ci' : null;

        $this->createTable('{{%advice_group}}', [
            'id' => $this->primaryKey(),
            'title' => $this->string(256)->notNull()->defaultValue(''),
            'hidden' => $this->smallInteger(1)->notNull()->defaultValue('0'),
            'createdBy' => $this->integer(11),
            'createdAt' => $this->dateTime()->null()->defaultValue(null),
            'updatedAt' => $this->dateTime()->null()->defaultValue(null),
        ], $options);

        $this->createIndex('title', '{{%advice_group}}', ['title']);
        $this->createIndex('hidden', '{{%advice_group}}', ['hidden']);
        $this->addForeignKey(
            'advice_group_createdBy_auth_id',
            '{{%advice_group}}',
            'createdBy',
            '{{%auth}}',
            'id',
            'SET NULL',
            'RESTRICT'
        );

        for ($i = 1; $i < 6; $i++) {
            $str = 'Категория советов ' . $i;
            Yii::$app->db->createCommand()->insert('{{%advice_group}}', [
                'title' => $str,
                'createdAt' => new \yii\db\Expression('NOW()'),
                'updatedAt' => new \yii\db\Expression('NOW()'),
                'createdBy' => 1,
                'hidden' => 0,
            ])->execute();
        }
    }

    public function safeDown()
    {
        $this->dropForeignKey('advice_group_createdBy_auth_id', '{{%advice_group}}');
        $this->dropTable('{{%advice_group}}');
    }
}
