<?php

use yii\db\Migration;

/**
 * Handles the update of table `cmf2_subscribe`.
 */
class m180704_110000_subscribe_hash_column extends Migration
{
    /**
     * @inheritdoc
     */
    public function up()
    {
        $this->addColumn('{{%subscribe}}', 'hash', $this->string(32)->null()->defaultValue(null));
        $this->truncateTable('{{%subscribe}}');
    }

    /**
     * @inheritdoc
     */
    public function down()
    {
        $this->dropColumn('{{%subscribe}}', 'hash');
    }
}
