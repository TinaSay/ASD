<?php

use yii\db\Migration;

/**
 * Class m171227_110013_menu_cleanup
 */
class m171227_110013_menu_cleanup extends Migration
{
    /**
     * @inheritdoc
     */
    public function safeUp()
    {
        $this->dropForeignKey('fk-menu-auth', '{{%menu_old}}');
        $this->dropTable('{{%menu_old}}');
    }

    /**
     * @inheritdoc
     */
    public function safeDown()
    {
        echo "m171227_110013_menu_cleanup cannot be reverted.\n";

        return false;
    }

}
