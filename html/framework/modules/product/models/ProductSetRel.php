<?php

namespace app\modules\product\models;

/**
 * This is the model class for table "{{%product_set_rel}}".
 *
 * @property integer $id
 * @property integer $productId
 * @property integer $setId
 * @property integer $quantity
 *
 * @property Product $product
 * @property ProductSet $set
 */
class ProductSetRel extends \yii\db\ActiveRecord
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
        return '{{%product_set_rel}}';
    }

    /**
     * @inheritdoc
     */
    public function rules()
    {
        return [
            [['productId', 'setId', 'quantity'], 'integer'],
            [
                ['productId'],
                'exist',
                'skipOnError' => true,
                'targetClass' => Product::class,
                'targetAttribute' => ['productId' => 'id'],
            ],
            [
                ['setId'],
                'exist',
                'skipOnError' => true,
                'targetClass' => ProductSet::class,
                'targetAttribute' => ['setId' => 'id'],
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
            'setId' => 'Set ID',
            'quantity' => 'Количество',
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
    public function getSet()
    {
        return $this->hasOne(ProductSet::class, ['id' => 'setId']);
    }
}
