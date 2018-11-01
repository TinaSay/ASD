<?php

namespace app\modules\promoBlock\models;

/**
 * This is the ActiveQuery class for [[PromoBlock]].
 *
 * @see PromoBlock
 */
class PromoBlockQuery extends \yii\db\ActiveQuery
{
    /**
     * @inheritdoc
     * @return PromoBlock[]|array
     */
    public function all($db = null)
    {
        return parent::all($db);
    }

    /**
     * @inheritdoc
     * @return PromoBlock|array|null
     */
    public function one($db = null)
    {
        return parent::one($db);
    }
}
