<?php

namespace app\modules\packet\models;

/**
 * This is the ActiveQuery class for [[PacketFile]].
 *
 * @see PacketFile
 */
class PacketFileQuery extends \yii\db\ActiveQuery
{
    /**
     * @inheritdoc
     * @return PacketFile[]|array
     */
    public function all($db = null)
    {
        return parent::all($db);
    }

    /**
     * @inheritdoc
     * @return PacketFile|array|null
     */
    public function one($db = null)
    {
        return parent::one($db);
    }
}
