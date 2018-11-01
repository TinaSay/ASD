<?php

use app\modules\feedback\models\FeedbackSettings;
use yii\db\Migration;

/**
 * Class m180627_203045_feedback_addproperty_settings
 */
class m180627_203045_feedback_addproperty_settings extends Migration
{
    /**
     * {@inheritdoc}
     */
    public function safeUp()
    {
        $this->alterColumn(FeedbackSettings::tableName(), 'value', $this->text());
        $this->batchInsert(FeedbackSettings::tableName(), ['name', 'value', 'label'], [
            [
                FeedbackSettings::PRIVACY_POLICY,
                'http://asdcompany.ru',
                'Ссылка на политику конфиденциальности',
            ],
        ]);
    }

    /**
     * {@inheritdoc}
     */
    public function safeDown()
    {
        $this->delete(FeedbackSettings::tableName(), ['name' => FeedbackSettings::PRIVACY_POLICY]);
    }
}
