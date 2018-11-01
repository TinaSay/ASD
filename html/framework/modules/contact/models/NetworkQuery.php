<?php

namespace app\modules\contact\models;

/**
 * This is the ActiveQuery class for [[Network]].
 *
 * @see Network
 */
class NetworkQuery extends \yii\db\ActiveQuery
{
    /**
     * @inheritdoc
     * @return Network[]|array
     */
    public function all($db = null)
    {
        return parent::all($db);
    }

    /**
     * @inheritdoc
     * @return Network|array|null
     */
    public function one($db = null)
    {
        return parent::one($db);
    }
}
