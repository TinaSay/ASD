<?php

namespace app\modules\product\models;

use app\behaviors\StorageBehavior\StorageBehavior as StorageMultiBehavior;
use app\modules\meta\adapters\ProductOpenGraphAdapter;
use app\modules\product\behaviors\ProductPropertyBehavior;
use app\modules\product\behaviors\SluggableBehavior;
use app\modules\product\dto\PropertyDto;
use app\modules\product\interfaces\ProductTitleInterface;
use app\modules\product\models\query\ProductQuery;
use app\modules\product\traits\DropDownTrait;
use cornernote\softdelete\SoftDeleteBehavior;
use krok\extend\behaviors\JsonBehavior;
use krok\extend\behaviors\TagDependencyBehavior;
use krok\extend\interfaces\HiddenAttributeInterface;
use krok\extend\traits\HiddenAttributeTrait;
use krok\meta\behaviors\MetaBehavior;
use krok\storage\dto\StorageDto;
use krok\storage\interfaces\StorageInterface;
use voskobovich\behaviors\ManyToManyBehavior;
use Yii;
use yii\db\ActiveRecord;
use yii\db\Expression;
use yii\helpers\ArrayHelper;
use yii\web\UploadedFile;

/**
 * This is the model class for table "{{%product}}".
 *
 * @property integer $id
 * @property string $alias
 * @property integer $brandId
 * @property string $uuid
 * @property string $article
 * @property string $title
 * @property string $printableTitle
 * @property string $description
 * @property array $advantages
 * @property string $text
 * @property array $videos
 * @property array $additionalParams
 * @property integer $hidden
 * @property string $createdAt
 * @property string $updatedAt
 *
 * @property array $sectionId
 * @property array $usageId
 * @property array $clientCategoryId
 * @property array $relatedProductId
 * @property PropertyDto[] $propertyValues
 *
 * @property ProductBrand $brand
 * @property ProductSection[] $sections
 * @property ProductSectionRel[] $productSectionRel
 * @property ProductProperty[] $properties
 * @property ProductPropertyValue[] $productPropertyValues
 * @property ProductUsage[] $usages
 * @property ProductUsageRel[] $productUsageRel
 * @property ProductClientCategory[] $clientCategories
 * @property ProductClientCategoryRel[] $productClientCategoryRel
 * @property ProductPromo[] $promos
 * @property ProductPromoRel[] $productPromoRel
 * @property ProductSet[] $sets
 * @property ProductSetRel[] $productSetRel
 * @property Product[] $relatedProducts
 * @property ProductRel[] $productRel
 *
 * @mixin \app\modules\product\behaviors\ProductPropertyBehavior
 * @mixin SoftDeleteBehavior
 */
class Product extends ActiveRecord implements HiddenAttributeInterface, StorageInterface, ProductTitleInterface
{
    use HiddenAttributeTrait, DropDownTrait;

    const SCENARIO_IMPORT = 'import';

    /**
     * @var PropertyDto[]|null
     */
    public $propertyValues;

    /**
     * @var UploadedFile[]|StorageDto[]
     */
    protected $documents;

    /**
     * @var UploadedFile[]|StorageDto[]
     */
    protected $images;

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
        return '{{%product}}';
    }

    /**
     * @return array
     */
    public function behaviors()
    {
        return [
            // 'TimestampBehavior' => TimestampBehavior::class,
            'TagDependencyBehavior' => TagDependencyBehavior::class,
            'ManyToManyBehavior' => [
                'class' => ManyToManyBehavior::class,
                'relations' => [
                    'sectionId' => 'sections',
                    'usageId' => 'usages',
                    'clientCategoryId' => 'clientCategories',
                    'relatedProductId' => 'relatedProducts',
                ],
            ],
            'ProductPropertyBehavior' => ProductPropertyBehavior::class,
            'StorageBehaviorDocuments' => [
                'class' => StorageMultiBehavior::class,
                'attribute' => 'documents',
                'multiple' => true,
                'scenarios' => [
                    self::SCENARIO_DEFAULT,
                    self::SCENARIO_IMPORT,
                ],
                'uploadedDirectory' => '/storage',
            ],
            'StorageBehaviorImages' => [
                'class' => StorageMultiBehavior::class,
                'attribute' => 'images',
                'multiple' => true,
                'scenarios' => [
                    self::SCENARIO_DEFAULT,
                    self::SCENARIO_IMPORT,
                ],
                'uploadedDirectory' => '/storage',
            ],
            'AdvantagesJsonBehavior' => [
                'class' => JsonBehavior::class,
                'attribute' => 'advantages',
                'value' => 'advantages',
            ],
            'ParamsJsonBehavior' => [
                'class' => JsonBehavior::class,
                'attribute' => 'additionalParams',
                'value' => 'additionalParams',
            ],
            'VideosJsonBehavior' => [
                'class' => JsonBehavior::class,
                'attribute' => 'videos',
                'value' => 'videos',
            ],
            [
                'class' => SoftDeleteBehavior::class,
                'attribute' => 'deletedAt',
                'value' => new Expression('NOW()'),
            ],
            'SluggableBehavior' => SluggableBehavior::class,
            'MetaBehavior' => [
                'class' => MetaBehavior::class,
                'adapters' => [
                    ProductOpenGraphAdapter::class,
                    // ProductTemplateAdapter::class,
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
            [['brandId', 'hidden'], 'integer'],
            [['article', 'title'], 'required'],
            [['text'], 'string'],
            [['createdAt', 'updatedAt', 'advantages', 'additionalParams', 'videos'], 'safe'],
            [['uuid'], 'string', 'max' => 36],
            [['article', 'alias'], 'string', 'max' => 127],
            [['title', 'printableTitle'], 'string', 'max' => 255],
            [['description'], 'string', 'max' => 512],
            [['uuid'], 'unique', 'on' => [static::SCENARIO_IMPORT]],
            [['uuid'], 'required', 'on' => [static::SCENARIO_IMPORT]],
            [
                ['brandId'],
                'exist',
                'skipOnError' => true,
                'targetClass' => ProductBrand::class,
                'targetAttribute' => ['brandId' => 'id'],
            ],
            /** virtual attributes */
            [['sectionId', 'usageId', 'clientCategoryId', 'relatedProductId'], 'each', 'rule' => ['integer']],
            [['propertyValues'], 'safe'],
            [['images'], 'each', 'rule' => ['image', 'skipOnEmpty' => true, 'skipOnError' => true]],
            [['documents'], 'each', 'rule' => ['file', 'skipOnEmpty' => true]],
        ];
    }

    /**
     * @inheritdoc
     */
    public function attributeLabels()
    {
        return [
            'id' => 'ID',
            'brandId' => 'Бренд',
            'uuid' => 'UID',
            'article' => 'Артикул',
            'title' => 'Наименование',
            'printableTitle' => 'Наименование для документов',
            'description' => 'Аннотация',
            'advantages' => 'Преимущества',
            'text' => 'Подробное описание',
            'additionalParams' => 'Дополнительные параметры',
            'videos' => 'Видео',
            'hidden' => 'Заблокировано',
            'createdAt' => 'Создано',
            'updatedAt' => 'Обновлено',
            /** virtual properties */
            'sectionId' => 'Раздел каталога',
            'usageId' => 'Область применения',
            'clientCategoryId' => 'Категории потребителей',
            'promoId' => 'Специальный товар',
            'documents' => 'Документы',
            'relatedProducts' => 'Связанные товары',
        ];
    }

    /**
     * @return StorageDto[]|UploadedFile
     */
    public function getDocuments()
    {
        return $this->documents;
    }

    /**
     * @param $documents
     */
    public function setDocuments($documents)
    {
        $this->documents = $documents;
    }

    /**
     * @return StorageDto[]
     */
    public function getImages()
    {
        return $this->images;
    }

    /**
     * @param array $images
     */
    public function setImages($images): void
    {
        $this->images = $images;
    }

    /**
     * StorageInterface realization
     *
     * @return string Model className
     */
    public function getModel(): string
    {
        return static::class;
    }

    /**
     * @return int
     */
    public function getRecordId(): int
    {
        return $this->id;
    }

    /**
     * StorageInterface realization
     *
     * @return string File title
     */
    public function getTitle(): string
    {
        return '';
    }

    /**
     * StorageInterface realization
     *
     * @return string File hint
     */
    public function getHint(): string
    {
        return '';
    }

    /**
     * @return \yii\db\ActiveQuery
     */
    public function getBrand()
    {
        return $this->hasOne(ProductBrand::class, ['id' => 'brandId']);
    }

    /**
     * @inheritdoc
     * @return ProductQuery the active query used by this AR class.
     */
    public static function find()
    {
        return new ProductQuery(get_called_class());
    }

    /**
     * @return  \yii\db\ActiveQuery
     */
    public function getSections()
    {
        return $this->hasMany(ProductSection::class, ['id' => 'sectionId'])
            ->via('productSectionRel');
    }

    /**
     * @return \yii\db\ActiveQuery
     */
    public function getProductSectionRel()
    {
        return $this->hasMany(ProductSectionRel::class, ['productId' => 'id']);
    }

    /**
     * @return  \yii\db\ActiveQuery
     */
    public function getProperties()
    {
        return $this->hasMany(ProductProperty::class, ['id' => 'propertyId'])
            ->via('productPropertyValues');
    }

    /**
     * @return \yii\db\ActiveQuery
     */
    public function getProductPropertyValues()
    {
        return $this->hasMany(ProductPropertyValue::class, ['productId' => 'id']);
    }

    /**
     * @return  \yii\db\ActiveQuery
     */
    public function getUsages()
    {
        return $this->hasMany(ProductUsage::class, ['id' => 'usageId'])
            ->via('productUsageRel');
    }

    /**
     * @return \yii\db\ActiveQuery
     */
    public function getProductUsageRel()
    {
        return $this->hasMany(ProductUsageRel::class, ['productId' => 'id']);
    }

    /**
     * @return  \yii\db\ActiveQuery
     */
    public function getClientCategories()
    {
        return $this->hasMany(ProductClientCategory::class, ['id' => 'clientCategoryId'])
            ->via('productClientCategoryRel');
    }

    /**
     * @return \yii\db\ActiveQuery
     */
    public function getProductClientCategoryRel()
    {
        return $this->hasMany(ProductClientCategoryRel::class, ['productId' => 'id']);
    }

    /**
     * @return string
     */
    public function getSectionsAsString()
    {
        return implode(', ', ArrayHelper::getColumn($this->sections, 'title'));
    }

    /**
     * @return string
     */
    public function getUsagesAsString()
    {
        return implode(', ', ArrayHelper::getColumn($this->usages, 'title'));
    }

    /**
     * @return string
     */
    public function getClientCategoriesAsString()
    {
        return implode(', ', ArrayHelper::getColumn($this->clientCategories, 'title'));
    }

    /**
     * @return  \yii\db\ActiveQuery
     */
    public function getPromos()
    {
        return $this->hasMany(ProductPromo::class, ['id' => 'promoId'])
            ->via('productPromoRel');
    }

    /**
     * @return \yii\db\ActiveQuery
     */
    public function getProductPromoRel()
    {
        return $this->hasMany(ProductPromoRel::class, ['productId' => 'id']);
    }

    /**
     * @return  \yii\db\ActiveQuery
     */
    public function getSets()
    {
        return $this->hasMany(ProductSet::class, ['id' => 'setId'])
            ->via('productSetRel');
    }

    /**
     * @return \yii\db\ActiveQuery
     */
    public function getProductSetRel()
    {
        return $this->hasMany(ProductSetRel::class, ['productId' => 'id']);
    }

    /**
     * @param string $size
     *
     * @return string
     */
    public function getFirstImageUrl($size = 'default')
    {
        if (!$this->images || !current($this->images) instanceof StorageDto) {
            return '/static/asd/img/noimg' . ($size == 'big' ? '_' . $size : '') . '.png';
        }

        $firstImage = current($this->images);

        return $this->getPreviewUrl($firstImage, $size);
    }

    /**
     * @param StorageDto $image
     *
     * @return string
     */
    public function getImageUrl(StorageDto $image)
    {
        $filesystem = Yii::createObject(\League\Flysystem\FilesystemInterface::class);

        return $filesystem->getDownloadUrl($image->getSrc());
    }

    /**
     * @param StorageDto $image
     * @param string $size
     *
     * @return string
     */
    public function getPreviewUrl(StorageDto $image, $size = 'default')
    {
        $options = [
            'default' => ['w' => 800],
            'small' => ['w' => 85, 'h' => 65, 'fit' => 'crop'],
            'big' => ['w' => 560, 'h' => 560, 'fit' => 'crop'],
        ];

        if (!array_key_exists($size, $options)) {
            $size = 'default';
        }
        $filesystem = Yii::createObject(\League\Flysystem\FilesystemInterface::class);

        return $filesystem->getPublicUrl($image->getSrc(), $options[$size]);
    }

    /**
     * @param string $url
     * @param string $type - possible values: default (120x90px), hqdefault (480x360px), mqdefault (320x180px)
     *
     * @return string
     */
    public function getVideoPreviewUrl(string $url, string $type = 'default')
    {
        if (preg_match('#youtube\.com(.*)embed\/([\w\d\-]+)#', $url, $matches)) {
            return 'https://img.youtube.com/vi/' . $matches[2] . '/' . $type . '.jpg';
        }

        return '/static/asd/img/noimg.png';
    }

    /**
     * @param StorageDto $document
     *
     * @return string
     */
    public function getDocumentUrl(StorageDto $document)
    {
        $filesystem = Yii::createObject(\League\Flysystem\FilesystemInterface::class);

        return $filesystem->getDownloadUrl($document->getSrc());
    }

    /**
     * @return \yii\db\ActiveQuery
     */
    public function getRelatedProducts()
    {
        return $this->hasMany(Product::class, ['id' => 'relatedId'])
            ->via('productRel')
            ->from(['p2' => Product::tableName()])
            ->andOnCondition('[[p2]].[[hidden]] = :hidden AND [[p2]].deletedAt IS NULL',
                [':hidden' => self::HIDDEN_NO]);
    }

    /**
     * @return \yii\db\ActiveQuery
     */
    public function getProductRel()
    {
        return $this->hasMany(ProductRel::class, ['productId' => 'id']);
    }

    /**
     * @param int|null $id
     * @param null|string $path
     *
     * @return null|string
     */
    public function getMenuTitle(?int $id, ?string $path = null): ?string
    {
        return self::find()->select(['title'])->where(['id' => $id])->scalar();
    }
}
