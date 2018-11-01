<?php

use yii\db\Migration;

class m171206_220500_about_banner extends Migration
{
    public function safeUp()
    {
        $options = ($this->db->getDriverName() === 'mysql') ? 'ENGINE=InnoDB DEFAULT CHARSET=utf8 COLLATE=utf8_unicode_ci' : null;

        $this->createTable('{{%about_banner}}', [
            'id' => $this->primaryKey(),
            'aboutId' => $this->integer()->notNull(),
            'bannerId' => $this->integer()->notNull(),
        ], $options);

        $this->addForeignKey('fk-client-to-about_banner', '{{%about_banner}}', 'aboutId', '{{%about}}', 'id', 'CASCADE', 'CASCADE');
        $this->addForeignKey('fk-okved-to-about_banner', '{{%about_banner}}', 'bannerId', '{{%banner}}', 'id', 'CASCADE', 'CASCADE');
    }

    public function safeDown()
    {
        $this->dropTable('{{%about_banner}}');
    }
}
