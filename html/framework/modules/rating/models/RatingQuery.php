<?php

namespace app\modules\rating\models;

/**
 * This is the ActiveQuery class for [[Rating]].
 *
 * @see Rating
 */
class RatingQuery extends \yii\db\ActiveQuery
{
    /**
     * @inheritdoc
     * @return Rating[]|array
     */
    public function all($db = null)
    {
        return parent::all($db);
    }

    /**
     * @inheritdoc
     * @return Rating|array|null
     */
    public function one($db = null)
    {
        return parent::one($db);
    }
}
