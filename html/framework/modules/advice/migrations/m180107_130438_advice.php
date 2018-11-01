<?php

use yii\db\Migration;

class m180107_130438_advice extends Migration
{
    public function safeUp()
    {
        $options = ($this->db->getDriverName() === 'mysql') ? 'ENGINE=InnoDB DEFAULT CHARSET=utf8 COLLATE=utf8_unicode_ci' : null;
        $this->createTable('{{%advice}}', [
            'id' => $this->primaryKey(),
            'group' => $this->Integer(11),
            'title' => $this->string(256)->notNull()->defaultValue(''),
            'announce' => $this->text()->notNull(),
            'text' => $this->text()->notNull(),
            'hidden' => $this->smallInteger(1)->notNull()->defaultValue('0'),
            'createdBy' => $this->integer(11),
            'createdAt' => $this->dateTime()->null()->defaultValue(null),
            'updatedAt' => $this->dateTime()->null()->defaultValue(null),
        ], $options);

        $this->createIndex('title', '{{%advice}}', ['title']);
        $this->createIndex('hidden', '{{%advice}}', ['hidden']);

        $this->addForeignKey(
            'fk-advice-group',
            '{{%advice}}',
            'group',
            '{{%advice_group}}',
            'id',
            'SET NULL',
            'RESTRICT'
        );

        $this->addForeignKey(
            'fk-advice-auth',
            '{{%advice}}',
            'createdBy',
            '{{%auth}}',
            'id',
            'SET NULL',
            'RESTRICT'
        );

        for ($i = 1; $i < 6; $i++) {
            $str = 'Совет №' . $i;
            Yii::$app->db->createCommand()->insert('{{%advice}}', [
                'title' => $str,
                'text' => $str,
                'announce' => $str,
                'createdAt' => new \yii\db\Expression('NOW()'),
                'updatedAt' => new \yii\db\Expression('NOW()'),
                'hidden' => 0,
                'group' => 1,
                'createdBy' => 1,
            ])->execute();
        }
    }

    public function safeDown()
    {
        $this->dropForeignKey('fk-advice-auth', '{{%advice}}');
        $this->dropForeignKey('fk-advice-group', '{{%advice}}');
        $this->dropTable('{{%advice}}');
    }
}
