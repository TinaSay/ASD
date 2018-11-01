<?php

use yii\db\Migration;

/**
 * Handles the creation of table `sked`.
 */
class m180615_195010_create_sked_table extends Migration
{
    private $_tableName = '{{%sked}}';

    /**
     * @inheritdoc
     */
    public function up()
    {
        $options = ($this->db->getDriverName() === 'mysql') ? 'ENGINE=InnoDB DEFAULT CHARSET=utf8 COLLATE=utf8_unicode_ci' : null;
        $this->createTable($this->_tableName, [
            'id' => $this->primaryKey(),
            'title' => $this->string(255)->null()->defaultValue(null),
            'route' => $this->string(100)->null()->defaultValue(null),
            'createdAt' => $this->datetime()->null()->defaultValue(null),
            'updatedAt' => $this->datetime()->null()->defaultValue(null),
            'createdBy' => $this->integer()->null()->defaultValue(null),
            'hidden' => $this->smallInteger(1)->notNull()->defaultValue(0),
        ], $options);

        $this->createIndex('idx-title', $this->_tableName, ['title']);
        $this->createIndex('idx-hidden', $this->_tableName, ['hidden']);
        $this->addForeignKey(
            'fk-sked-auth',
            $this->_tableName,
            'createdBy',
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
        $this->dropForeignKey('fk-sked-auth', $this->_tableName);
        $this->dropIndex('idx-hidden', $this->_tableName);
        $this->dropIndex('idx-title', $this->_tableName);
        $this->dropTable($this->_tableName);
    }
}
