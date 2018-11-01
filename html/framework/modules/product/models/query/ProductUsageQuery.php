<?php

namespace app\modules\product\models\query;

use app\modules\product\models\Product;
use app\modules\product\models\ProductUsage;
use yii\db\ActiveQuery;

/**
 * This is the ActiveQuery class for [[\app\modules\product\models\ProductUsage]].
 *
 * @see \app\modules\product\models\ProductUsage
 */
class ProductUsageQuery extends ActiveQuery
{
    /**
     * @inheritdoc
     * @return \app\modules\product\models\ProductUsage[]|array
     */
    public function all($db = null)
    {
        return parent::all($db);
    }

    /**
     * @inheritdoc
     * @return \app\modules\product\models\ProductUsage|array|null
     */
    public function one($db = null)
    {
        return parent::one($db);
    }

    /**
     * @return $this
     */
    public function active()
    {
        return $this->andWhere([
            ProductUsage::tableName() . '.[[hidden]]' => ProductUsage::HIDDEN_NO,
        ]);
    }

    /**
     * @return $this
     */
    public function hasProducts()
    {
        return $this->joinWith('products', false, 'INNER JOIN')
            ->andWhere([Product::tableName() . '.[[hidden]]' => Product::HIDDEN_NO]);
    }


}
