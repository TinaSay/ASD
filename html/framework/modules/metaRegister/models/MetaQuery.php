<?php

namespace app\modules\metaRegister\models;

/**
 * This is the ActiveQuery class for [[Meta]].
 *
 * @see Meta
 */
class MetaQuery extends \yii\db\ActiveQuery
{
    /**
     * @inheritdoc
     * @return Meta[]|array
     */
    public function all($db = null)
    {
        return parent::all($db);
    }

    /**
     * @inheritdoc
     * @return Meta|array|null
     */
    public function one($db = null)
    {
        return parent::one($db);
    }
}
