<?php

use yii\db\Migration;

/**
 * Class m171226_064610_menu_new
 */
class m171026_064610_menu_new extends Migration
{
    /**
     * @inheritdoc
     */
    public function safeUp()
    {
        $this->renameTable('{{%menu}}', '{{%menu_old}}');

    }

    /**
     * @inheritdoc
     */
    public function safeDown()
    {
        $this->renameTable('{{%menu_old}}', '{{%menu}}');
    }

}
