<?php

use yii\db\Migration;

/**
 * Handles the creation of table `records`.
 */
class m171026_161518_create_record_table extends Migration
{
    /**
     * @var string
     */
    private $tableName = '{{%record}}';

    /**
     * @inheritdoc
     */
    public function up()
    {
        $this->createTable($this->tableName, [
            'id' => $this->primaryKey(),
            'dateHistory' => $this->date(),
            'description' => $this->text(),
            'file' => $this->string(),
            'hidden' => $this->smallInteger(),
            'createdAt' => $this->dateTime(),
            'updatedAt' => $this->dateTime(),
        ]);
    }

    /**
     * @inheritdoc
     */
    public function down()
    {
        $this->dropTable($this->tableName);
    }
}
