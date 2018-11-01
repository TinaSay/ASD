<?php

namespace app\modules\news\models;

/**
 * This is the ActiveQuery class for [[Subscribe]].
 *
 * @see Subscribe
 */
class SubscribeQuery extends \yii\db\ActiveQuery
{
    /**
     * @inheritdoc
     * @return Subscribe[]|array
     */
    public function all($db = null)
    {
        return parent::all($db);
    }

    /**
     * @inheritdoc
     * @return Subscribe|array|null
     */
    public function one($db = null)
    {
        return parent::one($db);
    }
}
