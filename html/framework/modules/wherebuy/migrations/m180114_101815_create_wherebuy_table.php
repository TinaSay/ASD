<?php

use yii\db\Migration;

/**
 * Handles the creation of table `wherebuy`.
 */
class m180114_101815_create_wherebuy_table extends Migration
{
    /**
     * @inheritdoc
     */
    public function up()
    {
        $this->createTable('{{%wherebuy}}', [
            'id' => $this->primaryKey(),
            'title' => $this->string(),
            'subtitle' => $this->string(),
            'link' => $this->string(),
            'delivery' => $this->string(),
            'hidden' => $this->smallInteger(),
            'createdAt' => $this->dateTime(),
            'updatedAt' => $this->dateTime(),
            'createdBy' => $this->integer(),
            'language' => $this->string(8),

        ]);

        $this->createIndex('idx-title','{{%wherebuy}}','title');
        $this->createIndex('idx-hidden','{{%wherebuy}}','hidden');
        $this->createIndex('idx-language','{{%wherebuy}}','language');
    }

    /**
     * @inheritdoc
     */
    public function down()
    {
        $this->dropTable('{{%wherebuy}}');
    }
}
