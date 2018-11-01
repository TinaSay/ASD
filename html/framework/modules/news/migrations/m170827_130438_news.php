<?php

use yii\db\Migration;

class m170827_130438_news extends Migration
{
    public function safeUp()
    {
        $options = ($this->db->getDriverName() === 'mysql') ? 'ENGINE=InnoDB DEFAULT CHARSET=utf8 COLLATE=utf8_unicode_ci' : null;
        $this->createTable('{{%news}}', [
            'id' => $this->primaryKey(),
            'group' => $this->Integer(11),
            'title' => $this->string(256)->notNull()->defaultValue(''),
            'announce' => $this->text()->notNull(),
            'text' => $this->text()->notNull(),
            'date' => $this->dateTime()->null()->defaultValue(null),
            'hidden' => $this->smallInteger(1)->notNull()->defaultValue('0'),
            'createdBy' => $this->integer(11),
            'createdAt' => $this->dateTime()->null()->defaultValue(null),
            'updatedAt' => $this->dateTime()->null()->defaultValue(null),
        ], $options);

        $this->createIndex('title', '{{%news}}', ['title']);
        $this->createIndex('date', '{{%news}}', ['date']);
        $this->createIndex('hidden', '{{%news}}', ['hidden']);

        $this->addForeignKey(
            'fk-news-group',
            '{{%news}}',
            'group',
            '{{%news_group}}',
            'id',
            'SET NULL',
            'RESTRICT'
        );

        $this->addForeignKey(
            'fk-news-auth',
            '{{%news}}',
            'createdBy',
            '{{%auth}}',
            'id',
            'SET NULL',
            'RESTRICT'
        );

        for ($i = 1; $i < 12; $i++) {
            $str = 'Новости ' . $i;
            Yii::$app->db->createCommand()->insert('{{%news}}', [
                'title' => $str,
                'text' => $str,
                'announce' => $str,
                'date' => new \yii\db\Expression('NOW()'),
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
        $this->dropForeignKey('fk-news-auth', '{{%news}}');
        $this->dropForeignKey('fk-news-group', '{{%news}}');
        $this->dropTable('{{%news}}');
    }
}
