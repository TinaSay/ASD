<?php

namespace app\modules\content\models;

/**
 * This is the ActiveQuery class for [[ContentBanner]].
 *
 * @see ContentBanner
 */
class ContentBannerQuery extends \yii\db\ActiveQuery
{
    /**
     * @inheritdoc
     * @return ContentBanner[]|array
     */
    public function all($db = null)
    {
        return parent::all($db);
    }

    /**
     * @inheritdoc
     * @return ContentBanner|array|null
     */
    public function one($db = null)
    {
        return parent::one($db);
    }
}
