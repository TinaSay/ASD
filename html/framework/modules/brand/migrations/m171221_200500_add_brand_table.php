<?php

use yii\db\Migration;

class m171221_200500_add_brand_table extends Migration
{
    public $tablename = '{{%brand}}';

    public function safeUp()
    {
        $options = ($this->db->getDriverName() === 'mysql') ? 'ENGINE=InnoDB DEFAULT CHARSET=utf8 COLLATE=utf8_unicode_ci' : null;
        $this->createTable($this->tablename, [
            'id' => $this->primaryKey(),
            'title' => $this->string(255)->notNull()->defaultValue(''),
            'text' => $this->text(),
            'title2' => $this->string(255),
            'text2' => $this->text(),
            'link' => $this->string(255),
            'blocked' => $this->smallInteger(1)->notNull()->defaultValue(0),
            'createdAt' => $this->dateTime()->null()->defaultValue(null),
            'updatedAt' => $this->dateTime()->null()->defaultValue(null),
        ], $options);
    }

    public function safeDown()
    {
        $this->dropTable($this->tablename);
    }
}
