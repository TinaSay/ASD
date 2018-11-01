<?php

namespace app\modules\wherebuy\models;

/**
 * This is the model class for table "{{%wherebuy_brand}}".
 *
 * @property integer $id
 * @property integer $brandId
 * @property integer $wherebuyId
 */
class WherebuyBrand extends \yii\db\ActiveRecord
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
        return '{{%wherebuy_brand}}';
    }

    /**
     * @inheritdoc
     */
    public function rules()
    {
        return [
            [['brandId', 'wherebuyId'], 'integer'],
        ];
    }

    /**
     * @inheritdoc
     */
    public function attributeLabels()
    {
        return [
            'id' => 'ID',
            'brandId' => 'Brand ID',
            'wherebuyId' => 'Wherebuy ID',
        ];
    }
}
