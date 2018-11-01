<?php

use yii\db\Migration;

/**
 * Class m180314_144027_update_feedbackSettings
 */
class m180314_144027_update_feedbackSettings extends Migration
{
    private $_tableName = '{{%feedbacksettings}}';

    /**
     * {@inheritdoc}
     */
    public function safeUp()
    {
        $this->alterColumn($this->_tableName,'value',$this->text());
        $this->batchInsert($this->_tableName, ['name', 'value', 'label'], [
            ['title', '', 'Заголовок'],
            ['subtitle', '', 'Подзаголовок'],
            ['text', '', 'Текст'],
        ]);
    }

    /**
     * {@inheritdoc}
     */
    public function safeDown()
    {
        $this->delete($this->_tableName,['name'=>['title','subtitle','text']]);
    }


}
