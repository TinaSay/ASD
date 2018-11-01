<?php

use yii\db\Migration;

/**
 * Class m180209_050901_product_params
 */
class m180209_050901_product_params extends Migration
{
    /**
     * @inheritdoc
     */
    public function safeUp()
    {
        \app\modules\product\models\Product::updateAll([
            'advantages' => '',
            'updatedAt' => new \yii\db\Expression('NULL'),
        ]);
        $this->addColumn('{{%product}}', 'additionalParams', $this->text()->after('text'));
        $this->addColumn('{{%product}}', 'videos', $this->text()->after('additionalParams'));
    }

    /**
     * @inheritdoc
     */
    public function safeDown()
    {
        \app\modules\product\models\Product::updateAll([
            'advantages' => '',
            'updatedAt' => new \yii\db\Expression('NULL'),
        ]);
        $this->dropColumn('{{%product}}', 'additionalParams');
        $this->dropColumn('{{%product}}', 'videos');
    }

}
