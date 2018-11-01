<?php

use yii\db\Migration;

class m170911_063912_language extends Migration
{
    public function safeUp()
    {
        $this->addColumn('{{%news}}', 'language', $this->string(8)->notNull()->defaultValue('ru-RU'));
        $this->createIndex('language', '{{%news}}', ['language']);

        $this->addColumn('{{%news_group}}', 'language', $this->string(8)->notNull()->defaultValue('ru-RU'));
        $this->createIndex('language', '{{%news_group}}', ['language']);
    }

    public function safeDown()
    {
        $this->dropIndex('language', '{{%news}}');
        $this->dropColumn('{{%news}}', 'language');

        $this->dropIndex('language', '{{%news_group}}');
        $this->dropColumn('{{%news_group}}', 'language');
    }
}
