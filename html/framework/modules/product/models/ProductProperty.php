<?php

namespace app\modules\product\models;

use krok\extend\behaviors\TimestampBehavior;

/**
 * This is the model class for table "{{%product_property}}".
 *
 * @property integer $id
 * @property string $code
 * @property string $title
 * @property string $createdAt
 * @property string $updatedAt
 *
 * @property ProductPropertyValue[] $productPropertyValues
 */
class ProductProperty extends \yii\db\ActiveRecord
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
        return '{{%product_property}}';
    }

    /**
     * @return array
     */
    public function behaviors()
    {
        return [
            'TimestampBehavior' => TimestampBehavior::class,
        ];
    }

    /**
     * @inheritdoc
     */
    public function rules()
    {
        return [
            [['code', 'title'], 'required'],
            [['createdAt', 'updatedAt'], 'safe'],
            [['code'], 'string', 'max' => 127],
            [['title'], 'string', 'max' => 255],
        ];
    }

    /**
     * @inheritdoc
     */
    public function attributeLabels()
    {
        return [
            'id' => 'ID',
            'code' => 'Code',
            'title' => 'Title',
            'createdAt' => 'Created At',
            'updatedAt' => 'Updated At',
        ];
    }

    /**
     * @return \yii\db\ActiveQuery
     */
    public function getProductPropertyValues()
    {
        return $this->hasMany(ProductPropertyValue::class, ['propertyId' => 'id']);
    }
}
