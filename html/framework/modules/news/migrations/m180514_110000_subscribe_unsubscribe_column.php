<?php

use yii\db\Migration;

/**
 * Handles the update of table `cmf2_subscribe`.
 */
class m180514_110000_subscribe_unsubscribe_column extends Migration
{
    /**
     * @inheritdoc
     */
    public function up()
    {
        $this->addColumn('{{%subscribe}}', 'unsubscribe', $this->smallInteger(1)->defaultValue(0));
        $this->addColumn('{{%subscribe}}', 'updatedAt', $this->datetime()->null()->defaultValue(null));
    }

    /**
     * @inheritdoc
     */
    public function down()
    {
        $this->dropColumn('{{%subscribe}}', 'updatedAt');
        $this->dropColumn('{{%subscribe}}', 'unsubscribe');
    }
}
