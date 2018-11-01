<?php

namespace app\modules\product\models;

/**
 * This is the model class for table "{{%product_section_rel}}".
 *
 * @property integer $id
 * @property integer $productId
 * @property integer $sectionId
 *
 * @property Product $product
 * @property ProductSection $section
 */
class ProductSectionRel extends \yii\db\ActiveRecord
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
        return '{{%product_section_rel}}';
    }

    /**
     * @inheritdoc
     */
    public function rules()
    {
        return [
            [['productId', 'sectionId'], 'integer'],
            [
                ['productId'],
                'exist',
                'skipOnError' => true,
                'targetClass' => Product::class,
                'targetAttribute' => ['productId' => 'id'],
            ],
            [
                ['sectionId'],
                'exist',
                'skipOnError' => true,
                'targetClass' => ProductSection::class,
                'targetAttribute' => ['sectionId' => 'id'],
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
            'sectionId' => 'Section ID',
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
    public function getSection()
    {
        return $this->hasOne(ProductSection::class, ['id' => 'sectionId']);
    }
}
