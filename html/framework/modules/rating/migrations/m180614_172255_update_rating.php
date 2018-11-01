<?php

use yii\db\Migration;

/**
 * Class m180614_172255_update_rating
 */
class m180614_172255_update_rating extends Migration
{
    /**
     * {@inheritdoc}
     */
    public function safeUp()
    {
        $this->addColumn('{{%rating}}', 'sessionId', $this->string(32)->null()->defaultValue(null));
    }

    /**
     * {@inheritdoc}
     */
    public function safeDown()
    {
        $this->dropColumn('{{%rating}}', 'sessionId');
    }


}
