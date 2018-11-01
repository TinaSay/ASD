<?php

namespace app\modules\content\models;

/**
 * This is the model class for table "{{%content_banner}}".
 *
 * @property integer $id
 * @property integer $contentId
 * @property integer $bannerId
 *
 * @property Content $content
 */
class ContentBanner extends \yii\db\ActiveRecord
{
    /**
     * @return array
     */
    public function transactions()
    {
        return [
            self::SCENARIO_DEFAULT => self::OP_ALL,
        ];
    }

    /**
     * @inheritdoc
     */
    public static function tableName()
    {
        return '{{%content_banner}}';
    }

    /**
     * @inheritdoc
     */
    public function rules()
    {
        return [
            [['contentId', 'bannerId'], 'integer'],
            [['contentId'], 'exist', 'skipOnError' => true, 'targetClass' => Content::className(), 'targetAttribute' => ['contentId' => 'id']],
        ];
    }

    /**
     * @inheritdoc
     */
    public function attributeLabels()
    {
        return [
            'id' => 'ID',
            'contentId' => 'Content ID',
            'bannerId' => 'Banner ID',
        ];
    }

    /**
     * @return \yii\db\ActiveQuery
     */
    public function getContent()
    {
        return $this->hasOne(Content::className(), ['id' => 'contentId']);
    }

    /**
     * @inheritdoc
     * @return ContentBannerQuery the active query used by this AR class.
     */
    public static function find()
    {
        return new ContentBannerQuery(get_called_class());
    }
}
