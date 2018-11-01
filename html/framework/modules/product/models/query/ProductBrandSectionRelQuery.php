<?php

namespace app\modules\product\models\query;

/**
 * This is the ActiveQuery class for [[\app\modules\product\models\ProductBrandSectionRel]].
 *
 * @see \app\modules\product\models\ProductBrandSectionRel
 */
class ProductBrandSectionRelQuery extends \yii\db\ActiveQuery
{
    /**
     * @inheritdoc
     * @return \app\modules\product\models\ProductBrandSectionRel[]|array
     */
    public function all($db = null)
    {
        return parent::all($db);
    }

    /**
     * @inheritdoc
     * @return \app\modules\product\models\ProductBrandSectionRel|array|null
     */
    public function one($db = null)
    {
        return parent::one($db);
    }
}
