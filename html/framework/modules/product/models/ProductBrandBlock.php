<?php

namespace app\modules\product\models;

use krok\extend\behaviors\TagDependencyBehavior;
use krok\extend\behaviors\TimestampBehavior;
use krok\extend\interfaces\HiddenAttributeInterface;
use krok\extend\traits\HiddenAttributeTrait;

/**
 * This is the model class for table "{{%product_brand_block}}".
 *
 * @property integer $id
 * @property integer $brandId
 * @property string $title
 * @property string $value
 * @property string $description
 * @property integer $hidden
 * @property string $createdAt
 * @property string $updatedAt
 *
 * @property ProductBrand $brand
 */
class ProductBrandBlock extends \yii\db\ActiveRecord implements HiddenAttributeInterface
{
    use HiddenAttributeTrait;

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
        return '{{%product_brand_block}}';
    }

    /**
     * @return array
     */
    public function behaviors()
    {
        return [
            'TimestampBehavior' => TimestampBehavior::class,
            'TagDependencyBehavior' => TagDependencyBehavior::class,
        ];
    }

    /**
     * @inheritdoc
     */
    public function rules()
    {
        return [
            [['brandId', 'hidden'], 'integer'],
            [['title'], 'required'],
            [['createdAt', 'updatedAt'], 'safe'],
            [['title', 'value', 'description'], 'string', 'max' => 255],
            [
                ['brandId'],
                'exist',
                'skipOnError' => true,
                'targetClass' => ProductBrand::className(),
                'targetAttribute' => ['brandId' => 'id'],
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
            'title' => 'Название',
            'value' => 'Значение',
            'description' => 'Подпись',
            'hidden' => 'Заблокировано',
            'createdAt' => 'Created At',
            'updatedAt' => 'Updated At',
        ];
    }

    /**
     * @return \yii\db\ActiveQuery
     */
    public function getBrand()
    {
        return $this->hasOne(ProductBrand::className(), ['id' => 'brandId']);
    }
}
