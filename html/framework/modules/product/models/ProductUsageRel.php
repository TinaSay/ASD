<?php

namespace app\modules\product\models;

/**
 * This is the model class for table "{{%product_usage_rel}}".
 *
 * @property integer $id
 * @property integer $productId
 * @property integer $usageId
 *
 * @property Product $product
 * @property ProductUsage $usage
 */
class ProductUsageRel extends \yii\db\ActiveRecord
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
        return '{{%product_usage_rel}}';
    }

    /**
     * @inheritdoc
     */
    public function rules()
    {
        return [
            [['productId', 'usageId'], 'integer'],
            [
                ['productId'],
                'exist',
                'skipOnError' => true,
                'targetClass' => Product::class,
                'targetAttribute' => ['productId' => 'id'],
            ],
            [
                ['usageId'],
                'exist',
                'skipOnError' => true,
                'targetClass' => ProductUsage::class,
                'targetAttribute' => ['usageId' => 'id'],
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
            'usageId' => 'Usage ID',
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
    public function getUsage()
    {
        return $this->hasOne(ProductUsage::class, ['id' => 'usageId']);
    }
}
