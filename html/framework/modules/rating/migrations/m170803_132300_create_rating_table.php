<?php

use yii\db\Migration;

/**
 * Handles the creation of table `rating`.
 */
class m170803_132300_create_rating_table extends Migration
{
    /**
     * @inheritdoc
     */
    public function up()
    {
        $this->createTable('{{%rating}}', [
            'id' => $this->primaryKey(),
            'title' => $this->string(256),
            'module' => $this->string(64)->notNull()->defaultValue(''),
            'record_id' => $this->integer(11)->notNull()->defaultValue(0),
            'user_id' => $this->integer(11)->defaultValue(null),
            'user_ip' => $this->string(39)->defaultValue(null),
            'rating' => $this->integer(1)->defaultValue(0),
            'created_at' => $this->dateTime()->null()->defaultValue(null),
        ]);
        $this->createIndex('title', '{{%rating}}', ['title']);
        $this->createIndex('rating_module_record_id', '{{%rating}}', ['module', 'record_id']);
        $this->createIndex('created_at', '{{%rating}}', ['created_at']);
        $this->createIndex('user_id', '{{%rating}}', ['user_id']);
        $this->createIndex('user_ip', '{{%rating}}', ['user_ip']);
        $this->addForeignKey(
            'fk-rating_user_id-auth_id',
            '{{%rating}}',
            'user_id',
            '{{%auth}}',
            'id',
            'SET NULL',
            'RESTRICT'
        );
    }

    /**
     * @inheritdoc
     */
    public function down()
    {
        $this->dropForeignKey('fk-rating_user_id-auth_id', '{{%rating}}');
        $this->dropTable('{{%rating}}');
    }
}
