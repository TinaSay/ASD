<?php

use yii\db\Migration;

/**
 * Class m180625_084548_metaData
 */
class m180625_084548_meta_data extends Migration
{
    /**
     * {@inheritdoc}
     */
    public function safeUp()
    {
        $options = ($this->db->getDriverName() === 'mysql') ? 'ENGINE=InnoDB DEFAULT CHARSET=utf8 COLLATE=utf8_unicode_ci' : null;

        $this->createTable('{{%meta_data}}', [
            'id' => $this->primaryKey(),
            'metaId' => $this->integer(11)->notNull(),
            'name' => $this->string(64)->notNull(),
            'value' => $this->text()->null(),
            'createdAt' => $this->dateTime()->null()->defaultValue(null),
            'updatedAt' => $this->dateTime()->null()->defaultValue(null),
        ], $options);

        $this->addForeignKey(
            'metaData_metaId_meta_id',
            '{{%meta_data}}',
            'metaId',
            '{{%meta}}',
            'id',
            'CASCADE',
            'RESTRICT'
        );
    }

    /**
     * {@inheritdoc}
     */
    public function safeDown()
    {
        $this->dropForeignKey('metaData_metaId_meta_id', '{{%meta_data}}');
        $this->dropTable('{{%meta_data}}');
    }
}
