<?php

use yii\db\Migration;

/**
 * Class m180625_085000_rm
 */
class m180625_085000_rm extends Migration
{
    /**
     * {@inheritdoc}
     */
    public function safeUp()
    {
        $this->dropForeignKey('metaData_metaId_meta_id', '{{%meta_data}}');
        $this->dropTable('{{%meta_data}}');
        $this->dropTable('{{%meta}}');
    }

    /**
     * {@inheritdoc}
     */
    public function safeDown()
    {
        return false;
    }
}
