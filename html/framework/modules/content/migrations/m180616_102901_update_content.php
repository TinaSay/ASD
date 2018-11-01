<?php

use yii\db\Migration;

/**
 * Class m180616_102901_update_content
 */
class m180616_102901_update_content extends Migration
{

    private $table = '{{%content}}';

    /**
     * {@inheritdoc}
     */
    public function safeUp()
    {
        $this->addColumn($this->table, 'bannerPosition', $this->smallInteger(1)->null()->defaultValue(null));
        $this->addColumn($this->table, 'bannerColor', $this->string(7)->null()->defaultValue(null));
        $this->addColumn($this->table, 'productSet', $this->smallInteger(1)->null()->defaultValue(null));
        $this->addColumn($this->table, 'renderForm', $this->smallInteger(1)->null()->defaultValue(null));
    }

    /**
     * {@inheritdoc}
     */
    public function safeDown()
    {
        $this->dropColumn($this->table, 'renderForm');
        $this->dropColumn($this->table, 'productSet');
        $this->dropColumn($this->table, 'bannerColor');
        $this->dropColumn($this->table, 'bannerPosition');
    }


}
