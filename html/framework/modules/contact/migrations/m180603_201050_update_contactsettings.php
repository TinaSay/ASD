<?php

use yii\db\Migration;

/**
 * Class m180603_201050_update_contactsettings
 */
class m180603_201050_update_contactsettings extends Migration
{
    /**
     * {@inheritdoc}
     */
    public function safeUp()
    {
        $this->alterColumn('{{%contactsetting}}','value', $this->text());
    }

    /**
     * {@inheritdoc}
     */
    public function safeDown()
    {
        $this->alterColumn('{{%contactsetting}}','value', $this->string(255));
    }


}
