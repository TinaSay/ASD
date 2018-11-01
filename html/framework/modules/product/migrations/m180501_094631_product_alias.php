<?php

use app\modules\product\models\Product;
use app\modules\product\models\ProductBrand;
use app\modules\product\models\ProductPromo;
use app\modules\product\models\ProductSection;
use app\modules\product\models\ProductSet;
use app\modules\product\models\ProductUsage;
use yii\db\Migration;

/**
 * Class m180501_094631_product_alias
 */
class m180501_094631_product_alias extends Migration
{
    /**
     * {@inheritdoc}
     */
    public function safeUp()
    {
        $this->addColumn(Product::tableName(), 'alias',
            $this->string(127)->null()->after('id')
        );
        $this->createIndex('alias', Product::tableName(), ['alias']);

        $this->addColumn(ProductBrand::tableName(), 'alias',
            $this->string(127)->null()->after('id')
        );
        $this->createIndex('alias', ProductBrand::tableName(), ['alias']);

        $this->addColumn(ProductSection::tableName(), 'alias',
            $this->string(127)->null()->after('id')
        );
        $this->createIndex('alias', ProductSection::tableName(), ['alias']);

        $this->addColumn(ProductPromo::tableName(), 'alias',
            $this->string(127)->null()->after('id')
        );
        $this->createIndex('alias', ProductPromo::tableName(), ['alias']);

        $this->addColumn(ProductSet::tableName(), 'alias',
            $this->string(127)->null()->after('id')
        );
        $this->createIndex('alias', ProductSet::tableName(), ['alias']);

        $this->addColumn(ProductUsage::tableName(), 'alias',
            $this->string(127)->null()->after('id')
        );
        $this->createIndex('alias', ProductUsage::tableName(), ['alias']);

        Product::updateAll(['updatedAt' => new \yii\db\Expression('NULL')]);
    }

    /**
     * {@inheritdoc}
     */
    public function safeDown()
    {
        $this->dropColumn(Product::tableName(), 'alias');
        $this->dropColumn(ProductBrand::tableName(), 'alias');
        $this->dropColumn(ProductSection::tableName(), 'alias');
        $this->dropColumn(ProductPromo::tableName(), 'alias');
        $this->dropColumn(ProductSet::tableName(), 'alias');
        $this->dropColumn(ProductUsage::tableName(), 'alias');
    }

}
