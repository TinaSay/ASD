<?php

namespace app\modules\product\models;

use app\modules\product\behaviors\SluggableBehavior;
use app\modules\product\interfaces\ProductTitleInterface;
use app\modules\product\traits\DropDownTrait;
use app\modules\product\traits\IconTrait;
use krok\extend\behaviors\TagDependencyBehavior;
use krok\extend\behaviors\TimestampBehavior;
use krok\extend\interfaces\HiddenAttributeInterface;
use krok\extend\traits\HiddenAttributeTrait;
use krok\storage\behaviors\StorageBehavior;
use krok\storage\interfaces\StorageInterface;
use voskobovich\behaviors\ManyToManyBehavior;

/**
 * This is the model class for table "{{%product_promo}}".
 *
 * @property integer $id
 * @property string $alias
 * @property string $uuid
 * @property string $title
 * @property string $color
 * @property integer $hidden
 * @property integer $position
 * @property string $createdAt
 * @property string $updatedAt
 *
 * @property array $productId
 *
 * @property Product[] $products
 * @property ProductPromoRel[] $productPromoRel
 */
class ProductPromo extends \yii\db\ActiveRecord implements HiddenAttributeInterface, StorageInterface, ProductTitleInterface
{
    use HiddenAttributeTrait, DropDownTrait, IconTrait;

    const SCENARIO_IMPORT = 'import';

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
        return '{{%product_promo}}';
    }


    /**
     * @return array
     */
    public function behaviors()
    {
        return [
            'TimestampBehavior' => TimestampBehavior::class,
            'TagDependencyBehavior' => TagDependencyBehavior::class,
            'StorageBehaviorIcon' => [
                'class' => StorageBehavior::class,
                'attribute' => 'icon',
                'scenarios' => [
                    self::SCENARIO_DEFAULT,
                    self::SCENARIO_IMPORT,
                ],
            ],
            'ManyToManyBehavior' => [
                'class' => ManyToManyBehavior::class,
                'relations' => [
                    'productId' => 'products',
                ],
            ],
            'SluggableBehavior' => SluggableBehavior::class,
        ];
    }

    /**
     * @inheritdoc
     */
    public function rules()
    {
        return [
            [['title'], 'required'],
            [['hidden', 'position'], 'integer'],
            [['createdAt', 'updatedAt'], 'safe'],
            [['uuid'], 'string', 'max' => 36],
            [['alias'], 'string', 'max' => 127],
            [['title'], 'string', 'max' => 255],
            [['color'], 'string', 'max' => 8],
            [['color'], 'default', 'value' => '#f72525'],
            [['uuid'], 'unique', 'on' => [static::SCENARIO_IMPORT]],
            [['uuid'], 'required', 'on' => [static::SCENARIO_IMPORT]],
            /** virtual attributes */
            [
                ['icon'],
                'checkMimeType',
                'params' => [
                    'mimeTypes' => [
                        'image/jpeg',
                        'image/png',
                        'image/gif',
                        'image/svg+xml',
                    ],
                    'skipOnEmpty' => true,
                ],
            ],
            [['productId'], 'each', 'rule' => ['integer']],
        ];
    }

    /**
     * @inheritdoc
     */
    public function attributeLabels()
    {
        return [
            'id' => 'ID',
            'uuid' => 'UID',
            'title' => 'Название',
            'color' => 'Цвет',
            'hidden' => 'Заблокировано',
            'createdAt' => 'Created At',
            'updatedAt' => 'Updated At',
            /** Virtual attribute */
            'icon' => 'Иконка',
            'productId' => 'Товары',
        ];
    }

    /**
     * @return  \yii\db\ActiveQuery
     */
    public function getProducts()
    {
        return $this->hasMany(Product::class, ['id' => 'productId'])
            ->via('productPromoRel');
    }

    /**
     * @return \yii\db\ActiveQuery
     */
    public function getProductPromoRel()
    {
        return $this->hasMany(ProductPromoRel::class, ['promoId' => 'id']);
    }

    /**
     * @param int|null $id
     * @param null|string $path
     * @return null|string
     */
    public function getMenuTitle(?int $id, ?string $path = null): ?string
    {
        return self::find()->select(['title'])->where(['id' => $id])->scalar();
    }
}
