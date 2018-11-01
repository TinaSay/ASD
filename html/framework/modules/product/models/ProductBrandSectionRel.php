<?php

namespace app\modules\product\models;

/**
 * This is the model class for table "{{%product_brand_section_rel}}".
 *
 * @property integer $id
 * @property integer $brandId
 * @property integer $sectionId
 *
 * @property ProductBrand $brand
 * @property ProductSection $section
 */
class ProductBrandSectionRel extends \yii\db\ActiveRecord
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
        return '{{%product_brand_section_rel}}';
    }

    /**
     * @inheritdoc
     */
    public function rules()
    {
        return [
            [['brandId', 'sectionId'], 'integer'],
            [
                ['brandId'],
                'exist',
                'skipOnError' => true,
                'targetClass' => ProductBrand::class,
                'targetAttribute' => ['brandId' => 'id']
            ],
            [
                ['sectionId'],
                'exist',
                'skipOnError' => true,
                'targetClass' => ProductSection::class,
                'targetAttribute' => ['sectionId' => 'id']
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
            'brandId' => 'Brand ID',
            'sectionId' => 'Section ID',
        ];
    }

    /**
     * @return \yii\db\ActiveQuery
     */
    public function getBrand()
    {
        return $this->hasOne(ProductBrand::class, ['id' => 'brandId']);
    }

    /**
     * @return \yii\db\ActiveQuery
     */
    public function getSection()
    {
        return $this->hasOne(ProductSection::class, ['id' => 'sectionId']);
    }

    /**
     * @inheritdoc
     * @return \app\modules\product\models\query\ProductBrandSectionRelQuery the active query used by this AR class.
     */
    public static function find()
    {
        return new \app\modules\product\models\query\ProductBrandSectionRelQuery(get_called_class());
    }
}
