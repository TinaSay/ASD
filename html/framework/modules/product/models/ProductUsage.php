<?php

namespace app\modules\product\models;

use app\modules\meta\adapters\OpenGraphAdapter;
use app\modules\product\behaviors\SluggableBehavior;
use app\modules\product\interfaces\ProductTitleInterface;
use app\modules\product\models\query\ProductUsageQuery;
use app\modules\product\traits\DropDownTrait;
use app\modules\product\traits\IconTrait;
use krok\extend\behaviors\TagDependencyBehavior;
use krok\extend\behaviors\TimestampBehavior;
use krok\extend\interfaces\HiddenAttributeInterface;
use krok\extend\traits\HiddenAttributeTrait;
use krok\meta\behaviors\MetaBehavior;
use krok\storage\behaviors\StorageBehavior;
use krok\storage\interfaces\StorageInterface;
use yii\db\ActiveRecord;
use yii\db\Expression;

/**
 * This is the model class for table "{{%product_usages}}".
 *
 * @property integer $id
 * @property string $alias
 * @property string $uuid
 * @property string $title
 * @property string $name
 * @property string $description
 * @property string $text
 * @property integer $position
 * @property integer $hidden
 * @property string $createdAt
 * @property string $updatedAt
 *
 * @property Product[] $products
 * @property ProductUsageRel[] $productUsageRel
 * @property ProductSection[] $productSections
 * @property array $sections
 */
class ProductUsage extends ActiveRecord implements HiddenAttributeInterface, StorageInterface, ProductTitleInterface
{
    use HiddenAttributeTrait, DropDownTrait, IconTrait;

    const SCENARIO_IMPORT = 'import';

    /**
     * @var array|null
     */
    private $sections;

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
        return '{{%product_usage}}';
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
            'SluggableBehavior' => SluggableBehavior::class,
            'MetaBehavior' => [
                'class' => MetaBehavior::class,
                'adapters' => [
                    OpenGraphAdapter::class,
                    //  UsageTemplateAdapter::class,
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
            [['title'], 'required'],
            [['hidden', 'position'], 'integer'],
            [['createdAt', 'updatedAt'], 'safe'],
            [['uuid'], 'string', 'max' => 36],
            [['alias'], 'string', 'max' => 127],
            [['title', 'name'], 'string', 'max' => 255],
            [['description'], 'string', 'max' => 512],
            [['text'], 'string'],
            [['uuid'], 'unique', 'on' => [static::SCENARIO_IMPORT]],
            [['uuid'], 'required', 'on' => [static::SCENARIO_IMPORT]],
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
            'name' => 'Альтернативное название',
            'description' => 'Описание',
            'text' => 'Полное описание',
            'position' => 'Сортировка',
            'hidden' => 'Заблокировано',
            'createdAt' => 'Создано',
            'updatedAt' => 'Обновлено',
            'icon' => 'Иконка',
        ];
    }

    /**
     * @return  \yii\db\ActiveQuery
     */
    public function getProducts()
    {
        return $this->hasMany(Product::class, ['id' => 'productId'])
            ->via('productUsageRel');
    }

    /**
     * @return \yii\db\ActiveQuery
     */
    public function getProductUsageRel()
    {
        return $this->hasMany(ProductUsageRel::class, ['usageId' => 'id']);
    }

    /**
     * @param array|null $sections
     */
    public function setSections(?array $sections)
    {
        $this->sections = $sections;
    }

    /**
     * @return array|null
     */
    public function getSections(): ?array
    {
        return $this->sections;
    }

    /**
     * @param int|null $id
     * @param null|string $path
     * @return null|string
     */
    public function getMenuTitle(?int $id, ?string $path = null): ?string
    {
        if ($path == '/all') {
            return 'Все товары';
        }
        return self::find()->select([
            new Expression('IF([[name]] > "", [[name]], [[title]])')
        ])->where(['id' => $id])->scalar();
    }

    /**
     * @param int $id
     * @param int|null $hidden
     * @return array
     */
    public static function sectionsAsDropDown($id, $hidden = null)
    {
        return ProductSection::find()->select([
            ProductSection::tableName() . '.[[title]]',
            ProductSection::tableName() . '.[[id]]',
            ProductSection::tableName() . '.[[position]]',
        ])->innerJoin(ProductSectionRel::tableName(),
            new Expression(ProductSection::tableName() . '.[[id]] = ' .
                ProductSectionRel::tableName() . '.[[sectionId]]'))
            ->innerJoin(ProductUsageRel::tableName(),
                new Expression(ProductUsageRel::tableName() . '.[[productId]] = ' .
                    ProductSectionRel::tableName() . '.[[productId]]')
            )
            ->innerJoin(Product::tableName(),
                new Expression(Product::tableName() . '.[[id]] = ' .
                    ProductUsageRel::tableName() . '.[[productId]]')
            )
            ->where([
                ProductUsageRel::tableName() . '.[[usageId]]' => $id
            ])
            ->andFilterWhere([ProductSection::tableName() . '.[[hidden]]' => $hidden])
            ->andFilterWhere([Product::tableName() . '.[[hidden]]' => $hidden])
            ->distinct()
            ->indexBy('id')
            ->orderBy([
                ProductSection::tableName() . '.[[position]]' => SORT_ASC,
            ])->column();
    }

    /**
     * StorageInterface realization
     *
     * @return string File title
     */
    public function getTitle(): ?string
    {
        return $this->name ?: $this->title;
    }

    /**
     * @inheritdoc
     * @return ProductUsageQuery the active query used by this AR class.
     */
    public static function find()
    {
        return new ProductUsageQuery(get_called_class());
    }
}
