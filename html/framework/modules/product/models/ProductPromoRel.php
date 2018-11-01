<?php

namespace app\modules\product\models;

/**
 * This is the model class for table "{{%product_promo_rel}}".
 *
 * @property integer $id
 * @property integer $productId
 * @property integer $promoId
 *
 * @property Product $product
 * @property ProductPromo $promo
 */
class ProductPromoRel extends \yii\db\ActiveRecord
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
        return '{{%product_promo_rel}}';
    }

    /**
     * @inheritdoc
     */
    public function rules()
    {
        return [
            [['productId', 'promoId'], 'integer'],
            [
                ['productId'],
                'exist',
                'skipOnError' => true,
                'targetClass' => Product::class,
                'targetAttribute' => ['productId' => 'id'],
            ],
            [
                ['promoId'],
                'exist',
                'skipOnError' => true,
                'targetClass' => ProductPromo::class,
                'targetAttribute' => ['promoId' => 'id'],
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
            'promoId' => 'Promo ID',
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
    public function getPromo()
    {
        return $this->hasOne(ProductPromo::class, ['id' => 'promoId']);
    }
}
