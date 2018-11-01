<?php

use yii\db\Migration;

/**
 * Class m171218_133344_update_division_table
 */
class m171218_133344_update_division_table extends Migration
{
    /**
     * @inheritdoc
     */
    public function safeUp()
    {
        $this->addColumn('{{%division}}', 'long', $this->float()->null()->defaultValue(null));
        $this->addColumn('{{%division}}', 'lat', $this->float()->null()->defaultValue(null));
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
        echo "m171218_133344_update_division_table cannot be reverted.\n";

        return false;
    }
    */
}
