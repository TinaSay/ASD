<?php

use yii\db\Migration;

/**
 * Class m180615_155615_update_banner
 */
class m180615_155615_update_banner extends Migration
{

    private $_tableName = '{{%banner}}';

    /**
     * {@inheritdoc}
     */
    public function safeUp()
    {
        $this->addColumn($this->_tableName, 'showOnIndex', $this->smallInteger(1)->null()->defaultValue(null));
        $this->addColumn($this->_tableName, 'showOnWherebuy', $this->smallInteger(1)->null()->defaultValue(null));
    }

    /**
     * {@inheritdoc}
     */
    public function safeDown()
    {
        $this->dropColumn($this->_tableName, 'showOnIndex');
        $this->dropColumn($this->_tableName, 'showOnWherebuy');
    }


}
