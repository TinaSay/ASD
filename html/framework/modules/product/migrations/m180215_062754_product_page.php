<?php

use yii\db\Migration;

/**
 * Class m180215_062754_product_page
 */
class m180215_062754_product_page extends Migration
{
    public function safeUp()
    {
        $options = ($this->db->getDriverName() === 'mysql') ? 'ENGINE=InnoDB DEFAULT CHARSET=utf8 COLLATE=utf8_unicode_ci' : null;

        $this->createTable('{{%product_page}}', [
            'id' => $this->primaryKey(),
            'title' => $this->string(255)->notNull(),
            'description' => $this->string(512)->notNull(),
            'text' => $this->text(),
            'hidden' => $this->smallInteger(1)->notNull()->defaultValue(1),
            'createdAt' => $this->dateTime()->null()->defaultValue(null),
            'updatedAt' => $this->dateTime()->null()->defaultValue(null),
        ], $options);

        $this->createIndex('hidden', '{{%product_page}}', ['hidden']);

        $this->insert('{{%product_page}}', [
            'title' => 'Готовые решения ASD',
            'description' => 'Одна из областей в домашнем быту, где химические препараты используются наиболее часто, это кухня. Пора уже самим позаботиться о здоровье близких и сохранности среды, которая нас окружает — свести к минимуму использование химических моющих веществ для мытья и чистки посуды.',
            'text' => '<p>Одна из областей в домашнем быту, где химические препараты используются наиболее часто, это кухня. Пора уже самим позаботиться о здоровье близких и сохранности среды, которая нас окружает — свести к минимуму использование химических моющих веществ для мытья и чистки посуды.</p>',
            'hidden' => 0,
            'createdAt' => new \yii\db\Expression('NOW()'),
            'updatedAt' => new \yii\db\Expression('NOW()'),
        ]);
    }

    public function safeDown()
    {
        $this->dropTable('{{%product_page}}');
    }
}
