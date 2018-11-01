<?php

namespace app\modules\product\models;

use krok\extend\behaviors\TagDependencyBehavior;

/**
 * This is the model class for table "{{%product_property_value}}".
 *
 * @property integer $id
 * @property integer $productId
 * @property integer $propertyId
 * @property string $value
 * @property string $unit
 *
 * @property Product $product
 * @property ProductProperty $property
 */
class ProductPropertyValue extends \yii\db\ActiveRecord
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
        return '{{%product_property_value}}';
    }

    /**
     * @return array
     */
    public function behaviors()
    {
        return [
            'TagDependencyBehavior' => TagDependencyBehavior::class,
        ];
    }

    /**
     * @inheritdoc
     */
    public function rules()
    {
        return [
            [['productId', 'propertyId'], 'integer'],
            [['value'], 'required'],
            [['value'], 'string', 'max' => 255],
            [['unit'], 'string', 'max' => 7],
            [
                ['productId'],
                'exist',
                'skipOnError' => true,
                'targetClass' => Product::class,
                'targetAttribute' => ['productId' => 'id'],
            ],
            [
                ['propertyId'],
                'exist',
                'skipOnError' => true,
                'targetClass' => ProductProperty::class,
                'targetAttribute' => ['propertyId' => 'id'],
            ],
        ];
    }

    /**
     * @inheritdoc
     */
    public function attributeLabels()
    {
        return [
            'id' => 'ID',
            'productId' => 'Product ID',
            'propertyId' => 'Property ID',
            'value' => 'Value',
            'unit' => 'Unit',
        ];
    }

    /**
     * @return \yii\db\ActiveQuery
     */
    public function getProduct()
    {
        return $this->hasOne(Product::class, ['id' => 'productId']);
    }

    /**
     * @return \yii\db\ActiveQuery
     */
    public function getProperty()
    {
        return $this->hasOne(ProductProperty::class, ['id' => 'propertyId']);
    }
}
