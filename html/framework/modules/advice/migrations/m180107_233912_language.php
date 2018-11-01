<?php

use yii\db\Migration;

class m180107_233912_language extends Migration
{
    public function safeUp()
    {
        $this->addColumn('{{%advice}}', 'language', $this->string(8)->notNull()->defaultValue('ru-RU'));
        $this->createIndex('language', '{{%advice}}', ['language']);

        $this->addColumn('{{%advice_group}}', 'language', $this->string(8)->notNull()->defaultValue('ru-RU'));
        $this->createIndex('language', '{{%advice_group}}', ['language']);
    }

    public function safeDown()
    {
        $this->dropIndex('language', '{{%advice}}');
        $this->dropColumn('{{%advice}}', 'language');

        $this->dropIndex('language', '{{%advice_group}}');
        $this->dropColumn('{{%advice_group}}', 'language');
    }
}
