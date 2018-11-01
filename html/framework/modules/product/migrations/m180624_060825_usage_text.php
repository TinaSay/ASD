<?php

use yii\db\Migration;

/**
 * Class m180624_060825_usage_text
 */
class m180624_060825_usage_text extends Migration
{
    /**
     * {@inheritdoc}
     */
    public function safeUp()
    {
        $this->addColumn('{{%product_usage}}', 'text',
            $this->text()->after('description')
        );
        $this->addColumn('{{%product_usage}}', 'position',
            $this->integer()->notNull()->defaultValue('0')->after('text')
        );
    }

    /**
     * {@inheritdoc}
     */
    public function safeDown()
    {
        $this->dropColumn('{{%product_usage}}', 'text');
        $this->dropColumn('{{%product_usage}}', 'position');
    }
}
