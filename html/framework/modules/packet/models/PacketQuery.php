<?php

namespace app\modules\packet\models;

/**
 * This is the ActiveQuery class for [[Packet]].
 *
 * @see Packet
 */
class PacketQuery extends \yii\db\ActiveQuery
{
    /**
     * @inheritdoc
     * @return Packet[]|array
     */
    public function all($db = null)
    {
        return parent::all($db);
    }

    /**
     * @inheritdoc
     * @return Packet|array|null
     */
    public function one($db = null)
    {
        return parent::one($db);
    }
}
