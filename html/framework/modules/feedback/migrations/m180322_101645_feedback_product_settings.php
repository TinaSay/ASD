<?php

use app\modules\feedback\models\FeedbackSettings;
use yii\db\Migration;

/**
 * Class m180322_101645_feedback_product_settings
 */
class m180322_101645_feedback_product_settings extends Migration
{
    /**
     * {@inheritdoc}
     */
    public function safeUp()
    {
        $this->alterColumn(FeedbackSettings::tableName(), 'value', $this->text());
        $this->batchInsert(FeedbackSettings::tableName(), ['name', 'value', 'label'], [
            [
                FeedbackSettings::ORDER_EMAIL_SETTINGS,
                'aleks@nsign.ru',
                'Адреса, получающие уведомления о заявках на товар',
            ],
        ]);
    }

    /**
     * {@inheritdoc}
     */
    public function safeDown()
    {
        $this->delete(FeedbackSettings::tableName(), ['name' => FeedbackSettings::ORDER_EMAIL_SETTINGS]);
    }
}
