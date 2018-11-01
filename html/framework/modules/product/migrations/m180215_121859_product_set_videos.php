<?php

use yii\db\Migration;

/**
 * Class m180215_121859_product_set_videos
 */
class m180215_121859_product_set_videos extends Migration
{
    /**
     * @inheritdoc
     */
    public function safeUp()
    {
        $this->addColumn('{{%product_set}}', 'videos', $this->text()->after('description'));
    }

    /**
     * @inheritdoc
     */
    public function safeDown()
    {
        $this->dropColumn('{{%product_set}}', 'videos');
    }
}
