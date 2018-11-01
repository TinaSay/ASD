<?php

use yii\db\Migration;

/**
 * Class m180207_063610_drop_uid
 */
class m180207_063610_drop_uid extends Migration
{
    /**
     * @inheritdoc
     */
    public function safeUp()
    {
        $this->dropColumn('{{%brand}}', 'uuid');
    }

    /**
     * @inheritdoc
     */
    public function safeDown()
    {
        echo "m180207_063610_drop_uid cannot be reverted.\n";

        return false;
    }


}
