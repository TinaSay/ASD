<?php

use yii\db\Migration;

/**
 * Handles the creation of table `metro`.
 */
class m171209_053310_create_metro_table extends Migration
{

    private $_tableName = '{{%metro}}';

    /**
     * @inheritdoc
     */
    public function up()
    {
        $options = ($this->db->getDriverName() === 'mysql') ? 'ENGINE=InnoDB DEFAULT CHARSET=utf8 COLLATE=utf8_unicode_ci' : null;
        $this->createTable($this->_tableName, [
            'id' => $this->primaryKey(),
            'divisionId' => $this->integer(),
            'name' => $this->string(),
            'distance' => $this->string(),
            'color' => $this->string(),
        ], $options);

        $this->createIndex('idx-division_id', $this->_tableName, ['divisionId']);
    }

    /**
     * @inheritdoc
     */
    public function down()
    {
        $this->dropTable($this->_tableName);
    }
}
