<?php

namespace app\modules\content\models;

use app\modules\sked\models\Sked;

/**
 * This is the model class for table "{{%content_sked}}".
 *
 * @property integer $id
 * @property integer $contentId
 * @property integer $skedId
 *
 * @property Content $content
 */
class ContentSked extends \yii\db\ActiveRecord
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
        return '{{%content_sked}}';
    }

    /**
     * @inheritdoc
     */
    public function rules()
    {
        return [
            [['contentId', 'skedId'], 'integer'],
            [['contentId'], 'exist', 'skipOnError' => true, 'targetClass' => Content::class, 'targetAttribute' => ['contentId' => 'id']],
            [['skedId'], 'exist', 'skipOnError' => true, 'targetClass' => Sked::class, 'targetAttribute' => ['skedId' => 'id']],
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
            'skedId' => 'Sked ID',
        ];
    }

    /**
     * @inheritdoc
     * @return ContentSkedQuery the active query used by this AR class.
     */
    public static function find()
    {
        return new ContentSkedQuery(get_called_class());
    }
}
