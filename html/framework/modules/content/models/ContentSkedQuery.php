<?php

namespace app\modules\content\models;

/**
 * This is the ActiveQuery class for [[ContentSked]].
 *
 * @see ContentSked
 */
class ContentSkedQuery extends \yii\db\ActiveQuery
{
    /**
     * @inheritdoc
     * @return ContentSked[]|array
     */
    public function all($db = null)
    {
        return parent::all($db);
    }

    /**
     * @inheritdoc
     * @return ContentSked|array|null
     */
    public function one($db = null)
    {
        return parent::one($db);
    }
}
