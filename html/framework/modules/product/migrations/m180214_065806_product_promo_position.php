<?php

use yii\db\Migration;

/**
 * Class m180214_065806_product_promo_position
 */
class m180214_065806_product_promo_position extends Migration
{
    /**
     * @inheritdoc
     */
    public function safeUp()
    {
        $this->addColumn('{{%product_promo}}', 'position',
            $this->integer()->notNull()->defaultValue(0)->after('hidden')
        );

    }

    /**
     * @inheritdoc
     */
    public function safeDown()
    {
        $this->dropColumn('{{%product_promo}}', 'position');
    }
}
