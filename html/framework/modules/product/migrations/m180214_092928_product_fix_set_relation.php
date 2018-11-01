<?php

use yii\db\Migration;

/**
 * Class m180214_092928_product_fix_set_relation
 */
class m180214_092928_product_fix_set_relation extends Migration
{
    /**
     * @inheritdoc
     */
    public function safeUp()
    {
        $this->dropForeignKey('fk-product_set_rel_setId-product_section_id', '{{%product_set_rel}}');

        $this->addColumn('{{%product_set}}', 'position',
            $this->integer()->notNull()->defaultValue(0)->after('hidden')
        );

        $this->addForeignKey(
            'fk-product_set_rel_setId-product_set_id',
            '{{%product_set_rel}}',
            'setId',
            '{{%product_set}}',
            'id',
            'SET NULL',
            'CASCADE'
        );
    }

    /**
     * @inheritdoc
     */
    public function safeDown()
    {
        $this->dropForeignKey('fk-product_set_rel_setId-product_set_id', '{{%product_set_rel}}');

        $this->dropColumn('{{%product_set}}', 'position');

        $this->addForeignKey(
            'fk-product_set_rel_setId-product_section_id',
            '{{%product_set_rel}}',
            'setId',
            '{{%product_section}}',
            'id',
            'SET NULL',
            'CASCADE'
        );
    }

}
