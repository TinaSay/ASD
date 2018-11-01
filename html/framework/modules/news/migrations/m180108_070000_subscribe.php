<?php

use yii\db\Migration;

/**
 * Handles the update of table `cmf2_subscribe`.
 */
class m180108_070000_subscribe extends Migration
{
    /**
     * @inheritdoc
     */
    public function up()
    {
        $this->addColumn('{{%subscribe}}', 'type', $this->smallInteger(1));
    }

    /**
     * @inheritdoc
     */
    public function down()
    {
        $this->dropColumn('{{%subscribe}}', 'type');
    }
}
