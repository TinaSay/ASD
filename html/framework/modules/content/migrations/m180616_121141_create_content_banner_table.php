<?php

use yii\db\Migration;

/**
 * Handles the creation of table `content_banner`.
 */
class m180616_121141_create_content_banner_table extends Migration
{

    private $table = '{{%content_banner}}';

    /**
     * {@inheritdoc}
     */
    public function safeUp()
    {
        $this->createTable($this->table, [
            'id' => $this->primaryKey(),
            'contentId' => $this->integer()->null()->defaultValue(null),
            'bannerId' => $this->integer()->null()->defaultValue(null),
        ]);

        $this->createIndex('idx-contentId', $this->table, 'contentId');
        $this->createIndex('idx-bannerId', $this->table, 'bannerId');
        $this->addForeignKey(
            'fk-content-banner',
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
        $this->dropForeignKey('fk-content-banner', $this->table);
        $this->dropIndex('idx-bannerId', $this->table);
        $this->dropIndex('idx-contentId', $this->table);
        $this->dropTable($this->table);
    }
}
