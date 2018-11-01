<?php

namespace app\modules\banner\models;

/**
 * This is the model class for table "{{%banner_publication_place}}".
 *
 * @property integer $id
 * @property integer $bannerId
 * @property integer $placeId
 *
 */
class BannerPublicationPlace extends \yii\db\ActiveRecord
{
    const ATTR_ID = 'id';
    const ATTR_BANNER_ID = 'bannerId';
    const ATTR_PLACE_ID = 'placeId';

    /**
     * @inheritdoc
     */
    public static function tableName()
    {
        return '{{%banner_publication_place}}';
    }
}
