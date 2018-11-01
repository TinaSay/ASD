<?php

use yii\db\Migration;

/**
 * Handles the update of table `cmf2_subscribe`.
 */
class m180112_070000_subscribe_link_column extends Migration
{
    /**
     * @inheritdoc
     */
    public function up()
    {
        $this->addColumn('{{%subscribe}}', 'link', $this->string());
    }

    /**
     * @inheritdoc
     */
    public function down()
    {
        $this->dropColumn('{{%subscribe}}', 'link');
    }
}
