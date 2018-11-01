<?php

use yii\db\Migration;

/**
 * Class m171218_173353_update_feedback_table
 */
class m171218_173353_update_feedback_table extends Migration
{
    /**
     * @inheritdoc
     */
    public function safeUp()
    {
        $this->addColumn('{{%feedback}}', 'confirm', $this->smallInteger()->null()->defaultValue(null));
    }

    /**
     * @inheritdoc
     */
    public function safeDown()
    {
        return true;
    }

    /*
    // Use up()/down() to run migration code without a transaction.
    public function up()
    {

    }

    public function down()
    {
        echo "m171218_173353_update_feedback_table cannot be reverted.\n";

        return false;
    }
    */
}
