<?php

use app\modules\product\models\Product;
use yii\db\Migration;

/**
 * Class m180501_111059_product_alias_set
 */
class m180501_111059_product_alias_set extends Migration
{

    // Use up()/down() to run migration code without a transaction.
    public function up()
    {
        $list = Product::find()->where(['IS', 'alias', null])->all();
        if ($list) {
            foreach ($list as $model) {
                if (!$model->save()) {
                    print_r($model->getErrors());
                    exit;
                }
            }
        }
    }

    public function down()
    {
        echo "m180501_111059_product_alias_set cannot be reverted.\n";

        return true;
    }
}
