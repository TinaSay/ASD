<?php

use yii\db\Migration;

/**
 * Handles the creation of table `feedback_settings`.
 */
class m171104_065511_create_feedbacksettings_table extends Migration
{

    private $_tableName = '{{%feedbacksettings}}';

    /**
     * @inheritdoc
     */
    public function up()
    {
        $this->createTable($this->_tableName, [
            'id' => $this->primaryKey(),
            'name' => $this->string(50),
            'value' => $this->string(255),
            'label' => $this->string(255),
        ]);

        $this->batchInsert($this->_tableName, ['name', 'value', 'label'], [
            ['callsettings', '', 'Адреса, получающие уведомления об обратных звонках'],
            ['emailsettings', '', 'Адреса, получающие уведомления о сообщениях с сайта'],
        ]);
    }

    /**
     * @inheritdoc
     */
    public function down()
    {
        $this->dropTable($this->_tableName);
    }
}
