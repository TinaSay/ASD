<?php

namespace app\modules\sked\models;

/**
 * This is the ActiveQuery class for [[Sked]].
 *
 * @see Sked
 */
class SkedQuery extends \yii\db\ActiveQuery
{
    /**
     * @inheritdoc
     * @return Sked[]|array
     */
    public function all($db = null)
    {
        return parent::all($db);
    }

    /**
     * @inheritdoc
     * @return Sked|array|null
     */
    public function one($db = null)
    {
        return parent::one($db);
    }
}
