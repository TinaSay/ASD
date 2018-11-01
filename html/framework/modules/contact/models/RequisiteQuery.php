<?php

namespace app\modules\contact\models;

/**
 * This is the ActiveQuery class for [[Requisite]].
 *
 * @see Requisite
 */
class RequisiteQuery extends \yii\db\ActiveQuery
{
    /**
     * @inheritdoc
     * @return Requisite[]|array
     */
    public function all($db = null)
    {
        return parent::all($db);
    }

    /**
     * @inheritdoc
     * @return Requisite|array|null
     */
    public function one($db = null)
    {
        return parent::one($db);
    }
}
