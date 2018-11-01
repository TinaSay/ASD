<?php

namespace app\modules\contact\models;

/**
 * This is the ActiveQuery class for [[Metro]].
 *
 * @see Metro
 */
class MetroQuery extends \yii\db\ActiveQuery
{
    /**
     * @inheritdoc
     * @return Metro[]|array
     */
    public function all($db = null)
    {
        return parent::all($db);
    }

    /**
     * @inheritdoc
     * @return Metro|array|null
     */
    public function one($db = null)
    {
        return parent::one($db);
    }
}
