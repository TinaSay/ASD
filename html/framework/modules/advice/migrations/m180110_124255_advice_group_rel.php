<?php

use yii\db\Migration;

class m180110_124255_advice_group_rel extends Migration
{
    public function safeUp()
    {
        $options = ($this->db->getDriverName() === 'mysql') ? 'ENGINE=InnoDB DEFAULT CHARSET=utf8 COLLATE=utf8_unicode_ci' : null;

        $this->createTable(
            '{{%advice_group_rel}}',
            [
                'adviceId' => $this->integer(11)->defaultValue(0),
                'groupId' => $this->integer(11)->defaultValue(0),
            ],
            $options
        );

        $this->createIndex('adviceId', '{{%advice_group_rel}}', ['adviceId']);
        $this->createIndex('groupId', '{{%advice_group_rel}}', ['groupId']);

        $this->addForeignKey(
            'fk-advice_group_rel-advice',
            '{{%advice_group_rel}}',
            'adviceId',
            '{{%advice}}',
            'id',
            'SET NULL',
            'RESTRICT'
        );

        $this->addForeignKey(
            'fk-advice_group_rel-group',
            '{{%advice_group_rel}}',
            'groupId',
            '{{%advice_group}}',
            'id',
            'SET NULL',
            'RESTRICT'
        );
    }

    public function safeDown()
    {
        $this->dropForeignKey('fk-advice_group_rel-advice', '{{%advice_group_rel}}');
        $this->dropForeignKey('fk-advice_group_rel-group', '{{%advice_group_rel}}');
        $this->dropTable('{{%advice_group_rel}}');
    }
}
