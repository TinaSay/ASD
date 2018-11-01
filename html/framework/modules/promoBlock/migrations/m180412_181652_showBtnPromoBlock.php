<?php

use yii\db\Migration;

/**
 * Class m180412_181652_showBtnPromoBlock
 */
class m180412_181652_showBtnPromoBlock extends Migration
{
    /**
     * {@inheritdoc}
     */
    public function safeUp()
    {
        $this->addColumn('{{%promo_block}}', 'btnShow', $this->smallInteger(1));
        $this->addColumn('{{%promo_block}}', 'btnText', $this->string(255));
    }

    /**
     * {@inheritdoc}
     */
    public function safeDown()
    {
        $this->dropColumn('{{%promo_block}}','btnShow');
        $this->dropColumn('{{%promo_block}}','btnText');
    }

    /*
    // Use up()/down() to run migration code without a transaction.
    public function up()
    {

    }

    public function down()
    {
        echo "m180412_181652_showBtnPromoBlock cannot be reverted.\n";

        return false;
    }
    */
}
