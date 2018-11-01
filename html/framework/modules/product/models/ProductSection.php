<?php

namespace app\modules\product\models;

use app\modules\product\behaviors\SluggableBehavior;
use app\modules\product\interfaces\ProductTitleInterface;
use app\modules\product\models\query\ProductSectionQuery;
use krok\extend\behaviors\TagDependencyBehavior;
use krok\extend\behaviors\TimestampBehavior;
use krok\extend\interfaces\HiddenAttributeInterface;
use krok\extend\traits\HiddenAttributeTrait;
use voskobovich\behaviors\ManyToManyBehavior;
use yii\db\ActiveRecord;
use yii\helpers\ArrayHelper;

/**
 * This is the model class for table "{{%product_section}}".
 *
 * @property integer $id
 * @property string $alias
 * @property integer $parentId
 * @property integer $brandId
 * @property string $uuid
 * @property string $title
 * @property integer $position
 * @property integer $depth
 * @property integer $hidden
 * @property string $createdAt
 * @property string $updatedAt
 *
 * @property ProductSection $parent
 * @property ProductSection[] $children
 * @property ProductSection[] $activeChildren
 * @property ProductBrand[] $brands
 * @property ProductSectionRel[] $productSectionRel
 */
class ProductSection extends ActiveRecord implements HiddenAttributeInterface, ProductTitleInterface
{
    use HiddenAttributeTrait;

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
        return '{{%product_section}}';
    }

    /**
     * @return array
     */
    public function behaviors()
    {
        return [
            'TimestampBehavior' => TimestampBehavior::class,
            'TagDependencyBehavior' => TagDependencyBehavior::class,
            'SluggableBehavior' => SluggableBehavior::class,
            'ManyToManyBrandIdBehavior' => [
                'class' => ManyToManyBehavior::class,
                'relations' => [
                    'brandId' => 'brands',
                ],
            ],
        ];
    }

    /**
     * @inheritdoc
     */
    public function rules()
    {
        return [
            [['parentId', 'position', 'depth', 'hidden'], 'integer'],
            [['brandId'], 'each', 'rule' => ['integer']],
            [['title'], 'required'],
            [['createdAt', 'updatedAt'], 'safe'],
            [['uuid'], 'string', 'max' => 36],
            [['alias'], 'string', 'max' => 127],
            [['title'], 'string', 'max' => 255],
            [['uuid'], 'unique', 'on' => [static::SCENARIO_IMPORT]],
            [['uuid'], 'required', 'on' => [static::SCENARIO_IMPORT]],
            [
                ['parentId'],
                'exist',
                'skipOnError' => true,
                'targetClass' => ProductSection::class,
                'targetAttribute' => ['parentId' => 'id'],
            ],/*
            [
                ['brandId'],
                'exist',
                'skipOnError' => true,
                'targetClass' => ProductBrand::class,
                'targetAttribute' => ['brandId' => 'id'],
                'allowArray' => true,
            ],*/
        ];
    }

    /**
     * @inheritdoc
     */
    public function attributeLabels()
    {
        return [
            'id' => 'ID',
            'parentId' => 'Родительский каталог',
            'brandId' => 'Бренд',
            'uuid' => 'UID',
            'title' => 'Название',
            'position' => 'Сортирока',
            'depth' => 'Depth',
            'hidden' => 'Заблокировано',
            'createdAt' => 'Created At',
            'updatedAt' => 'Updated At',
        ];
    }

    /**
     * @return \yii\db\ActiveQuery
     */
    public function getParent()
    {
        return $this->hasOne(ProductSection::class, ['id' => 'parentId'])
            ->alias('parent');
    }

    /**
     * @return \yii\db\ActiveQuery
     */
    public function getChildren()
    {
        return $this->hasMany(ProductSection::class, ['parentId' => 'id'])
            ->alias('children');
    }

    /**
     * @return \yii\db\ActiveQuery
     */
    public function getActiveChildren()
    {
        return $this->hasMany(ProductSection::class, ['parentId' => 'id'])
            ->andOnCondition('[[children]].[[hidden]] = ' . self::HIDDEN_NO)
            ->alias('children');
    }

    /**
     * @return \yii\db\ActiveQuery
     */
    public function getProductSectionRel()
    {
        return $this->hasMany(ProductSectionRel::class, ['sectionId' => 'id']);
    }

    /**
     * @return \yii\db\ActiveQuery
     */
    public function getProducts()
    {
        return $this->hasMany(Product::class, ['id' => 'productId'])
            ->via('productSectionRel');
    }

    /**
     * @return \yii\db\ActiveQuery
     */
    public function getBrands()
    {
        return $this->hasMany(ProductBrand::class, ['id' => 'brandId'])
            ->viaTable(ProductBrandSectionRel::tableName(), ['sectionId' => 'id']);
    }

    /**
     * @inheritdoc
     * @return ProductSectionQuery the active query used by this AR class.
     */
    public static function find()
    {
        return new ProductSectionQuery(get_called_class());
    }

    /**
     * @param string|int $exclude
     *
     * @return array
     */
    public static function asDropDown($exclude = '')
    {
        $exclude = $exclude ? ['id' => $exclude] : [];

        return ArrayHelper::map(self::find()
            ->asTreeList($exclude), 'id', function ($row) {
            return str_repeat('  ::  ', $row['depth']) . $row['title'];
        });
    }

    /**
     * @param array $list
     *
     * @return array
     */
    public static function buildTree(array $list)
    {
        ArrayHelper::map($list, 'id', function ($row) {
            return $row;
        });

        foreach ($list as $row) {
            if (ArrayHelper::keyExists($row['parentId'], $list)) {
                $children = ArrayHelper::remove($list, $row['id']);
                $list[$row['parentId']] = ArrayHelper::merge($list[$row['parentId']], ['children' => [$children]]);
            }
        }

        return $list;
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
