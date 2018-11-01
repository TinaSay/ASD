<?php

namespace app\modules\product\models\query;

use app\modules\product\models\Product;

/**
 * This is the ActiveQuery class for [[\app\modules\product\models\Product]].
 *
 * @see \app\modules\product\models\Product
 */
class ProductQuery extends \yii\db\ActiveQuery
{
    /**
     * @inheritdoc
     * @return \app\modules\product\models\Product[]|array
     */
    public function all($db = null)
    {
        return parent::all($db);
    }

    /**
     * @inheritdoc
     * @return \app\modules\product\models\Product|array|null
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
        return $this->notDeleted()->andWhere([Product::tableName() . '.[[hidden]]' => Product::HIDDEN_NO]);
    }

    /**
     * @return $this
     */
    public function notDeleted()
    {
        return $this->andWhere(['IS', Product::tableName() . '.[[deletedAt]]', null]);
    }
}
