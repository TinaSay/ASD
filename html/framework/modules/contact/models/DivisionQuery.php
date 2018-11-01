<?php

namespace app\modules\contact\models;

/**
 * This is the ActiveQuery class for [[division]].
 * @see division
 */
class DivisionQuery extends \yii\db\ActiveQuery
{
    /**
     * @inheritdoc
     * @return division[]|array
     */
    public function all($db = null)
    {
        return parent::all($db);
    }

    /**
     * @inheritdoc
     * @return division|array|null
     */
    public function one($db = null)
    {
        return parent::one($db);
    }
}
