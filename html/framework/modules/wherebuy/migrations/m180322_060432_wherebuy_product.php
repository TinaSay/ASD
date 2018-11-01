<?php

use yii\db\Migration;

/**
 * Class m180322_060432_wherebuy_product
 */
class m180322_060432_wherebuy_product extends Migration
{
    /**
     * {@inheritdoc}
     */
    public function safeUp()
    {
        $this->addColumn('{{%wherebuy}}', 'showInProduct',
            $this->smallInteger(1)->notNull()->defaultValue(0)->after('hidden')
        );
        $this->createIndex('showInProduct', '{{%wherebuy}}', ['showInProduct']);
    }

    /**
     * {@inheritdoc}
     */
    public function safeDown()
    {
        $this->dropColumn('{{%wherebuy}}', 'showInProduct');
    }

}
