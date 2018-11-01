<?php

use yii\db\Migration;

/**
 * Handles the creation of table `records`.
 */
class m171206_214300_create_about_table extends Migration
{
    /**
     * @var string
     */
    private $tableName = '{{%about}}';

    /**
     * @inheritdoc
     */
    public function up()
    {
        $this->createTable($this->tableName, [
            'id' => $this->primaryKey(),
            'title' => $this->string(255)->notNull(),
            'description' => $this->text(),
            'titleForImage' => $this->string(255),
            'descriptionImage' => $this->string(255),
            'titleForBanners' => $this->string(255),
            'titleAdditionalBlock' => $this->string(255),
            'additionalDescription' => $this->text(),
            'urlYoutubeVideo' => $this->string(255),
            'publicHistory' => $this->smallInteger(1),
            'publishAnApplication' => $this->smallInteger(1),
            'blocked' => $this->smallInteger(1)->notNull()->defaultValue(0),
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
