<?php

use app\modules\brand\models\Brand;
use app\modules\product\models\ProductBrand;
use yii\db\Migration;

/**
 * Class m180521_044829_product_brand_link_brand
 */
class m180521_044829_product_brand_link_brand extends Migration
{
    /**
     * {@inheritdoc}
     */
    public function safeUp()
    {
        $this->addColumn('{{%product_brand}}', 'brandId',
            $this->integer()->null()->after('uuid')
        );

        $this->addForeignKey(
            'fk-brand_id-product_brand_brandId',
            '{{%product_brand}}',
            'brandId',
            '{{%brand}}',
            'id',
            'SET NULL',
            'CASCADE'
        );
        /** @var Brand[] $brands */
        $brands = Brand::find()->all();
        if ($brands) {
            foreach ($brands as $brand) {
                ProductBrand::updateAll(['brandId' => $brand->id], ['title' => $brand->title]);
            }
        }
    }

    /**
     * {@inheritdoc}
     */
    public function safeDown()
    {
        $this->dropForeignKey('fk-brand_id-product_brand_brandId', '{{%product_brand}}');

        $this->dropColumn('{{%product_brand}}', 'brandId');
    }
}
