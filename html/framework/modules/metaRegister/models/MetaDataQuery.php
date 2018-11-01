<?php

namespace app\modules\metaRegister\models;

/**
 * This is the ActiveQuery class for [[MetaData]].
 *
 * @see MetaData
 */
class MetaDataQuery extends \yii\db\ActiveQuery
{
    /**
     * @inheritdoc
     * @return MetaData|array|null
     */
    public function one($db = null)
    {
        return parent::one($db);
    }

    /**
     * @param $id
     *
     * @return MetaData[]|array
     */
    public function byId($id)
    {
        return $this->andwhere([MetaData::tableName() . '.[[id]]' => $id])->all();
    }

    /**
     * @inheritdoc
     * @return MetaData[]|array
     */
    public function all($db = null)
    {
        return parent::all($db);
    }
}
