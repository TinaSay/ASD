<?php

namespace app\modules\product\models\query;

use app\modules\brand\models\Brand;
use app\modules\product\models\ProductBrand;
use krok\storage\models\Storage;

/**
 * This is the ActiveQuery class for [[\app\modules\product\models\Product]].
 *
 * @see \app\modules\product\models\Product
 */
class ProductBrandQuery extends \yii\db\ActiveQuery
{
    /**
     * @inheritdoc
     * @return \app\modules\product\models\ProductBrand[]|array
     */
    public function all($db = null)
    {
        return parent::all($db);
    }

    /**
     * @inheritdoc
     * @return \app\modules\product\models\ProductBrand|array|null
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
        return $this->andWhere([ProductBrand::tableName() . '.[[hidden]]' => ProductBrand::HIDDEN_NO]);
    }

    /**
     * @return $this
     */
    public function illustration()
    {
        return $this->select([
            ProductBrand::tableName() . '.*',
            Storage::tableName() . '.[[src]] as [[illustration]]',
        ])->leftJoin(Storage::tableName(), Storage::tableName() . '.[[model]] = :model AND ' .
            Storage::tableName() . '.[[recordId]] = ' . ProductBrand::tableName() . '.[[brandId]] AND ' .
            Storage::tableName() . '.[[attribute]] = :attribute',
            [
                ':model' => Brand::class,
                ':attribute' => 'illustration'
            ]
        );
    }
}
