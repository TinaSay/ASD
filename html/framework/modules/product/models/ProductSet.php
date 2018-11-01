<?php

namespace app\modules\product\models;

use app\behaviors\StorageBehavior\StorageBehavior;
use app\modules\meta\adapters\ProductSetOpenGraphAdapter;
use app\modules\product\behaviors\ProductSetItemBehavior;
use app\modules\product\behaviors\SluggableBehavior;
use app\modules\product\dto\ProductSetItemDto;
use app\modules\product\interfaces\ProductTitleInterface;
use app\modules\product\traits\DropDownTrait;
use krok\extend\behaviors\JsonBehavior;
use krok\extend\behaviors\TagDependencyBehavior;
use krok\extend\behaviors\TimestampBehavior;
use krok\extend\interfaces\HiddenAttributeInterface;
use krok\extend\traits\HiddenAttributeTrait;
use krok\meta\behaviors\MetaBehavior;
use krok\storage\dto\StorageDto;
use krok\storage\interfaces\StorageInterface;
use Yii;
use yii\web\UploadedFile;

/**
 * This is the model class for table "{{%product_set}}".
 *
 * @property integer $id
 * @property string $alias
 * @property integer $usageId
 * @property string $uuid
 * @property string $article
 * @property string $title
 * @property string $category
 * @property string $description
 * @property array $videos
 * @property integer $hidden
 * @property integer $position
 * @property string $createdAt
 * @property string $updatedAt
 *
 * @property ProductSetItemDto[] $productItems
 *
 * @property Product[] $products
 * @property ProductSetRel[] $productSetRel
 * @property ProductUsage $usage
 *
 * @mixin ProductSetItemBehavior
 */
class ProductSet extends \yii\db\ActiveRecord implements HiddenAttributeInterface, StorageInterface, ProductTitleInterface
{
    use HiddenAttributeTrait, DropDownTrait;

    const SCENARIO_IMPORT = 'import';

    /**
     * @var ProductSetItemDto[]|null
     */
    public $productItems;

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
        return '{{%product_set}}';
    }

    /**
     * @return array
     */
    public function behaviors()
    {
        return [
            'TimestampBehavior' => TimestampBehavior::class,
            'TagDependencyBehavior' => TagDependencyBehavior::class,
            'StorageBehaviorDocuments' => [
                'class' => StorageBehavior::class,
                'attribute' => 'documents',
                'multiple' => true,
                'scenarios' => [
                    self::SCENARIO_DEFAULT,
                    self::SCENARIO_IMPORT,
                ],
                'uploadedDirectory' => '/storage',
            ],
            'StorageBehaviorImages' => [
                'class' => StorageBehavior::class,
                'attribute' => 'images',
                'multiple' => true,
                'scenarios' => [
                    self::SCENARIO_DEFAULT,
                    self::SCENARIO_IMPORT,
                ],
                'uploadedDirectory' => '/storage',
            ],
            'VideosJsonBehavior' => [
                'class' => JsonBehavior::class,
                'attribute' => 'videos',
                'value' => 'videos',
            ],
            'ProductSetItemBehavior' => ProductSetItemBehavior::class,
            'SluggableBehavior' => SluggableBehavior::class,
            'MetaBehavior' => [
                'class' => MetaBehavior::class,
                'adapters' => [
                    ProductSetOpenGraphAdapter::class,
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
            [['hidden', 'position'], 'integer'],
            [['title', 'description'], 'required'],
            [['createdAt', 'updatedAt', 'videos'], 'safe'],
            [['uuid'], 'string', 'max' => 36],
            [['alias', 'article'], 'string', 'max' => 127],
            [['title', 'category'], 'string', 'max' => 255],
            [['description'], 'string', 'max' => 512],
            [['uuid'], 'unique', 'on' => [static::SCENARIO_IMPORT]],
            [['uuid'], 'required', 'on' => [static::SCENARIO_IMPORT]],
            [
                ['usageId'],
                'exist',
                'skipOnError' => true,
                'targetClass' => ProductUsage::class,
                'targetAttribute' => ['usageId' => 'id'],
            ],
            [['usageId'], 'integer', 'skipOnEmpty' => true],
            /** virtual properties */
            [['images'], 'each', 'rule' => ['image'], 'skipOnEmpty' => true],
            [['documents'], 'each', 'rule' => ['file'], 'skipOnEmpty' => true],
        ];
    }

    /**
     * @inheritdoc
     */
    public function attributeLabels()
    {
        return [
            'id' => 'ID',
            'usage' => 'Область применения',
            'uuid' => 'UID',
            'article' => 'Артикул',
            'category' => 'Категория',
            'title' => 'Название',
            'description' => 'Описание',
            'hidden' => 'Заблокировано',
            'position' => 'Сортировка',
            'createdAt' => 'Created At',
            'updatedAt' => 'Updated At',
            'videos' => 'Видео',
            'images' => 'Изображения',
            'documents' => 'Документы',
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
     * @return  \yii\db\ActiveQuery
     */
    public function getProducts()
    {
        return $this->hasMany(Product::class, ['id' => 'productId'])
            ->via('productSetRel');
    }

    /**
     * @return \yii\db\ActiveQuery
     */
    public function getProductSetRel()
    {
        return $this->hasMany(ProductSetRel::class, ['setId' => 'id']);
    }

    /**
     * @return \yii\db\ActiveQuery
     */
    public function getUsage()
    {
        return $this->hasOne(ProductUsage::class, ['id' => 'usageId']);
    }

    /**
     * StorageInterface realization
     *
     * @return string Model className
     */
    public function getModel(): string
    {
        return self::class;
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
     * @param string $size
     *
     * @return string
     */
    public function getFirstImageUrl($size = 'preview')
    {
        if (!$this->images || !current($this->images) instanceof StorageDto) {
            return '/static/asd/img/noimg.png';
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
            'preview' => ['w' => 360, 'h' => 235, 'fit' => 'crop'],
            'small' => ['w' => 85, 'h' => 65, 'fit' => 'crop'],
        ];

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
     * @param int|null $id
     * @param null|string $path
     *
     * @return null|string
     */
    public function getMenuTitle(?int $id, ?string $path = null): ?string
    {
        if ($path == '/all') {
            return 'Товары в наборе';
        } elseif ($path == '/order') {
            return 'Заказать';
        }

        return self::find()->select(['title'])->where(['id' => $id])->scalar();
    }
}
