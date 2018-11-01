<?php

use yii\db\Migration;

/**
 * Class m171218_173353_update_feedback_table
 */
class m180126_173326_update_feedback_table extends Migration
{
    /**
     * @inheritdoc
     */
    public function safeUp()
    {
        $this->addColumn('{{%feedback}}', 'callTime', $this->string(5)->null()->defaultValue(null));
    }

    /**
     * @inheritdoc
     */
    public function safeDown()
    {
        $this->dropColumn('{{%feedback}}', 'callTime');
    }

}
