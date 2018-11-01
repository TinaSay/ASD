<?php

use yii\db\Migration;

/**
 * Handles the creation of table `content_sked`.
 */
class m180616_065715_create_content_sked_table extends Migration
{

    private $table = '{{%content_sked}}';

    /**
     * {@inheritdoc}
     */
    public function safeUp()
    {
        $this->createTable($this->table, [
            'id' => $this->primaryKey(),
            'contentId' => $this->integer()->null()->defaultValue(null),
            'skedId' => $this->integer()->null()->defaultValue(null),
        ]);

        $this->createIndex('idx-contentId', $this->table, 'contentId');
        $this->createIndex('idx-skedId', $this->table, 'skedId');
        $this->addForeignKey(
            'fk-content-sked',
            $this->table,
            'contentId',
            '{{%content}}',
            'id',
            'CASCADE',
            'CASCADE'
        );
    }

    /**
     * {@inheritdoc}
     */
    public function safeDown()
    {
        $this->dropForeignKey('fk-content-sked', $this->table);
        $this->dropIndex('idx-skedId', $this->table);
        $this->dropIndex('idx-contentId', $this->table);
        $this->dropTable($this->table);
    }
}
