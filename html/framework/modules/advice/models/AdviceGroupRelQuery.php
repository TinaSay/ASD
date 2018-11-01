<?php

namespace app\modules\advice\models;

/**
 * This is the ActiveQuery class for [[AdviceGroupRel]].
 *
 * @see AdviceGroupRel
 */
class AdviceGroupRelQuery extends \yii\db\ActiveQuery
{
    /**
     * @inheritdoc
     * @return AdviceGroupRel[]|array
     */
    public function all($db = null)
    {
        return parent::all($db);
    }

    /**
     * @inheritdoc
     * @return AdviceGroupRel|array|null
     */
    public function one($db = null)
    {
        return parent::one($db);
    }
}
