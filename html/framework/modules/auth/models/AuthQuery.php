<?php

namespace app\modules\auth\models;

/**
 * This is the ActiveQuery class for [[Auth]].
 *
 * @see Auth
 */
class AuthQuery extends \yii\db\ActiveQuery
{
    /**
     * @inheritdoc
     * @return Auth[]|array
     */
    public function all($db = null)
    {
        return parent::all($db);
    }

    /**
     * @inheritdoc
     * @return Auth|array|null
     */
    public function one($db = null)
    {
        return parent::one($db);
    }
}
