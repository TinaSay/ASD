<?php

namespace app\modules\product\models;

/**
 * This is the model class for table "{{%product_client_category_rel}}".
 *
 * @property integer $id
 * @property integer $productId
 * @property integer $clientCategoryId
 *
 * @property ProductClientCategory $clientCategory
 * @property Product $product
 */
class ProductClientCategoryRel extends \yii\db\ActiveRecord
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
        return '{{%product_client_category_rel}}';
    }

    /**
     * @inheritdoc
     */
    public function rules()
    {
        return [
            [['productId', 'clientCategoryId'], 'integer'],
            [
                ['clientCategoryId'],
                'exist',
                'skipOnError' => true,
                'targetClass' => ProductClientCategory::class,
                'targetAttribute' => ['clientCategoryId' => 'id'],
            ],
            [
                ['productId'],
                'exist',
                'skipOnError' => true,
                'targetClass' => Product::class,
                'targetAttribute' => ['productId' => 'id'],
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
            'clientCategoryId' => 'Client Category ID',
        ];
    }

    /**
     * @return \yii\db\ActiveQuery
     */
    public function getClientCategory()
    {
        return $this->hasOne(ProductClientCategory::class, ['id' => 'clientCategoryId']);
    }

    /**
     * @return \yii\db\ActiveQuery
     */
    public function getProduct()
    {
        return $this->hasOne(Product::class, ['id' => 'productId']);
    }
}
