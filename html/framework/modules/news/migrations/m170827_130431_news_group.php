<?php

use yii\db\Migration;

class m170827_130431_news_group extends Migration
{
    public function safeUp()
    {
        $options = ($this->db->getDriverName() === 'mysql') ? 'ENGINE=InnoDB DEFAULT CHARSET=utf8 COLLATE=utf8_unicode_ci' : null;

        $this->createTable('{{%news_group}}', [
            'id' => $this->primaryKey(),
            'title' => $this->string(256)->notNull()->defaultValue(''),
            'hidden' => $this->smallInteger(1)->notNull()->defaultValue('0'),
            'createdBy' => $this->integer(11),
            'createdAt' => $this->dateTime()->null()->defaultValue(null),
            'updatedAt' => $this->dateTime()->null()->defaultValue(null),
        ], $options);

        $this->createIndex('title', '{{%news_group}}', ['title']);
        $this->createIndex('hidden', '{{%news_group}}', ['hidden']);
        $this->addForeignKey(
            'news_group_createdBy_auth_id',
            '{{%news_group}}',
            'createdBy',
            '{{%auth}}',
            'id',
            'SET NULL',
            'RESTRICT'
        );

        for ($i = 1; $i < 12; $i++) {
            $str = 'Группа новостей ' . $i;
            Yii::$app->db->createCommand()->insert('{{%news_group}}', [
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
        $this->dropForeignKey('news_group_createdBy_auth_id', '{{%news_group}}');
        $this->dropTable('{{%news_group}}');
    }
}
