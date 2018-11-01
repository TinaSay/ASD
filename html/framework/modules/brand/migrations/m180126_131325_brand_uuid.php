<?php

use yii\db\Migration;

/**
 * Class m180126_131325_brand_uuid
 */
class m180126_131325_brand_uuid extends Migration
{
    /**
     * @inheritdoc
     */
    public function safeUp()
    {
        $this->addColumn('{{%brand}}', 'uuid', $this->string(36)->null()->after('id'));

        $this->createIndex('uuid', '{{%brand}}', ['uuid'], true);
    }

    /**
     * @inheritdoc
     */
    public function safeDown()
    {
        $this->dropColumn('{{%brand}}', 'uuid');
    }

}
