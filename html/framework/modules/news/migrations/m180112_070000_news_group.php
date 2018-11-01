<?php

use yii\db\Migration;

/**
 * Handles the update of table `cmf2_subscribe`.
 */
class m180112_070000_news_group extends Migration
{
    /**
     * @inheritdoc
     */
    public function up()
    {
        $this->addColumn('{{%news_group}}', 'color', $this->string(6)->defaultValue('00509f'));
    }

    /**
     * @inheritdoc
     */
    public function down()
    {
        $this->dropColumn('{{%news_group}}', 'color');
    }
}
