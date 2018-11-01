<?php

use yii\db\Migration;

/**
 * Class m180514_113326_update_feedback_table
 */
class m180514_113326_update_feedback_table extends Migration
{

    /**
     * @inheritdoc
     */
    public function up()
    {
        $this->addColumn('{{%feedback}}', 'unsubscribe', $this->smallInteger(1)->defaultValue(0));
    }

    /**
     * @inheritdoc
     */
    public function down()
    {
        $this->dropColumn('{{%feedback}}', 'unsubscribe');
    }

}
