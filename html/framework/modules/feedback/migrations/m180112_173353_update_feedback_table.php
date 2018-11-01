<?php

use yii\db\Migration;

/**
 * Class m171218_173353_update_feedback_table
 */
class m180112_173353_update_feedback_table extends Migration
{
    /**
     * @inheritdoc
     */
    public function safeUp()
    {
        $this->addColumn('{{%feedback}}', 'route', $this->string()->null()->defaultValue(null));
    }

    /**
     * @inheritdoc
     */
    public function safeDown()
    {
        $this->dropColumn('{{%feedback}}', 'route');
    }

}
