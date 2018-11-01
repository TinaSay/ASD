<?php

use yii\db\Migration;

/**
 * Handles the creation of table `wherebuy_brand`.
 */
class m180114_111815_wherebuy_brand_table extends Migration
{
    /**
     * @inheritdoc
     */
    public function up()
    {
        $options = ($this->db->getDriverName() === 'mysql') ? 'ENGINE=InnoDB DEFAULT CHARSET=utf8 COLLATE=utf8_unicode_ci' : null;
        $this->createTable('{{%wherebuy_brand}}', [
            'id' => $this->primaryKey(),
            'brandId' => $this->integer(),
            'wherebuyId' => $this->integer(),
        ], $options);
    }

    /**
     * @inheritdoc
     */
    public function down()
    {
        $this->dropTable('{{%wherebuy_brand}}');
    }
}
