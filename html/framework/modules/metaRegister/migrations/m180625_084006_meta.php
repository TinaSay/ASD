<?php

use yii\db\Migration;

/**
 * Class m180625_084006_meta
 */
class m180625_084006_meta extends Migration
{
    /**
     * {@inheritdoc}
     */
    public function safeUp()
    {
        $options = ($this->db->getDriverName() === 'mysql') ? 'ENGINE=InnoDB DEFAULT CHARSET=utf8 COLLATE=utf8_unicode_ci' : null;
        $this->createTable('{{%meta}}', [
            'id' => $this->primaryKey(),
            'model' => $this->string(128)->notNull(),
            'recordId' => $this->integer(11)->notNull(),
            'type' => $this->string(64),
            'createdAt' => $this->dateTime()->null()->defaultValue(null),
            'updatedAt' => $this->dateTime()->null()->defaultValue(null),
        ], $options);

        $this->createIndex('model-recordId-type', '{{%meta}}', ['model', 'recordId', 'type'], true);
    }

    /**
     * {@inheritdoc}
     */
    public function safeDown()
    {
        $this->dropTable('{{%meta}}');
    }
}
