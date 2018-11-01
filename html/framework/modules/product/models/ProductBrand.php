<?php

namespace app\modules\product\models;

use app\modules\brand\models\Brand;
use app\modules\product\behaviors\SluggableBehavior;
use app\modules\product\interfaces\ProductTitleInterface;
use app\modules\product\models\query\ProductBrandQuery;
use app\modules\product\traits\DropDownTrait;
use krok\extend\behaviors\TagDependencyBehavior;
use krok\extend\behaviors\TimestampBehavior;
use krok\extend\interfaces\HiddenAttributeInterface;
use krok\extend\traits\HiddenAttributeTrait;
use krok\storage\behaviors\StorageBehavior;
use krok\storage\dto\StorageDto;
use krok\storage\interfaces\StorageInterface;
use krok\storage\models\Storage;
use League\Flysystem\FilesystemInterface;
use Yii;
use yii\web\UploadedFile;

/**
 * This is the model class for table "{{%product_brand}}".
 *
 * @property integer $id
 * @property string $alias
 * @property string $uuid
 * @property integer $brandId
 * @property string $title
 * @property string $description
 * @property string $text
 * @property integer $position
 * @property integer $hidden
 * @property string $createdAt
 * @property string $updatedAt
 * @property string $illustration
 *
 * @property Product[] $products
 * @property ProductSection[] $sections
 * @property ProductBrandBlock[] $blocks
 * @property Brand[] $brand
 */
class ProductBrand extends \yii\db\ActiveRecord implements HiddenAttributeInterface, StorageInterface, ProductTitleInterface
{
    use HiddenAttributeTrait, DropDownTrait;

    const SCENARIO_IMPORT = 'import';
    const SCENARIO_SET_BRAND = 'setbrand';
    /**
     * @var array
     */
    public $sectionTree = [];

    /**
     * @var UploadedFile|StorageDto
     */
    private $logo;

    /**
     * @var string
     */
    private $illustration;

    /**
     * @var UploadedFile|StorageDto
     */
    private $presentation;

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
        return '{{%product_brand}}';
    }

    /**
     * @return array
     */
    public function behaviors()
    {
        return [
            'TimestampBehavior' => TimestampBehavior::class,
            'TagDependencyBehavior' => TagDependencyBehavior::class,
            'StorageBehaviorLogo' => [
                'class' => StorageBehavior::class,
                'attribute' => 'logo',
                'scenarios' => [
                    self::SCENARIO_DEFAULT,
                    self::SCENARIO_IMPORT,
                ],
            ],
            'StorageBehaviorPresentation' => [
                'class' => StorageBehavior::class,
                'attribute' => 'presentation',
                'scenarios' => [
                    self::SCENARIO_DEFAULT,
                    self::SCENARIO_IMPORT,
                ],
            ],
            'SluggableBehavior' => SluggableBehavior::class,
            /* 'MetaBehavior' => [
                 'class' => MetaBehavior::class,
                 'adapters' => [
                     BrandTemplateAdapter::class,
                 ],
             ],*/
        ];
    }

    /**
     * @inheritdoc
     */
    public function rules()
    {
        return [
            [['title'], 'required'],
            [['text'], 'string'],
            [['position', 'hidden', 'brandId'], 'integer'],
            [['createdAt', 'updatedAt'], 'safe'],
            [['uuid'], 'string', 'max' => 36],
            [['alias'], 'string', 'max' => 127],
            [['title'], 'string', 'max' => 255],
            [['description'], 'string', 'max' => 512],
            [['uuid'], 'unique', 'on' => [static::SCENARIO_IMPORT]],
            [['uuid'], 'required', 'on' => [static::SCENARIO_IMPORT]],
            [
                ['logo'],
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
            [
                ['presentation'],
                'file',
                'skipOnEmpty' => true,
            ],
            [['brandId'], 'required', 'on' => [static::SCENARIO_SET_BRAND]],
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
            'description' => 'Краткое описание',
            'text' => 'Полное описание',
            'position' => 'Сортировка',
            'hidden' => 'Заблокировано',
            'createdAt' => 'Дата создания',
            'updatedAt' => 'Дата изменения',
            'logo' => 'Логотип',
            'presentation' => 'Презентация',
            'illustration' => 'Илюстрация',
        ];
    }

    /**
     * check image mime
     *
     * @param $attribute
     * @param $params
     */
    public function checkMimeType($attribute, $params)
    {
        $mimeTypes = $params['mimeTypes'] ?? ['image/png', 'image/jpeg', 'image/svg+xml'];

        if ($file = $this->getLogo()) {
            $mime = '';
            if ($file instanceof UploadedFile) {
                $mime = $file->type;
            } elseif ($file instanceof StorageDto) {
                $mime = $file->getMime();
            }

            if (!in_array($mime, $mimeTypes)) {
                $this->addError($attribute,
                    Yii::t('yii', 'Only files with these MIME types are allowed: {mimeTypes}.',
                        ['mimeTypes' => implode(', ', $mimeTypes)])
                );
            }
        } elseif (!isset($params['skipOnEmpty']) || $params['skipOnEmpty'] !== true) {
            $this->addError($attribute, Yii::t('yii', 'Please upload a file.'));
        }
    }

    /**
     * @return \yii\db\ActiveQuery
     */
    public function getProducts()
    {
        return $this->hasMany(Product::class, ['brandId' => 'id']);
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
        return $this->title;
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
     * @return StorageDto|UploadedFile
     */
    public function getLogo()
    {
        return $this->logo;
    }

    /**
     * @param $logo
     */
    public function setLogo($logo)
    {
        $this->logo = $logo;
    }

    /**
     * @return string|null
     */
    public function getIllustrationUrl()
    {
        if (is_string($this->illustration)) {
            /** @var  FilesystemInterface $filesystem */
            $filesystem = Yii::createObject(FilesystemInterface::class);
            $file = new StorageDto(new Storage([
                'src' => $this->illustration
            ]), $filesystem
            );
            return $file->getPublicUrl();
        }

        return null;
    }

    /**
     * @param string $illustration
     */
    public function setIllustration($illustration)
    {
        $this->illustration = $illustration;
    }

    /**
     * @return string $illustration
     */
    public function getIllustration()
    {
        return $this->illustration;
    }

    /**
     * @return StorageDto|UploadedFile
     */
    public function getPresentation()
    {
        return $this->presentation;
    }

    /**
     * @param $presentation
     */
    public function setPresentation($presentation)
    {
        $this->presentation = $presentation;
    }

    /**
     * @return string
     */
    public function getLogoUrl()
    {
        if (!$this->logo) {
            return '';
        }
        $filesystem = Yii::createObject(\League\Flysystem\FilesystemInterface::class);

        return $filesystem->getDownloadUrl($this->logo->getSrc());
    }

    /**
     * @return string|null
     */
    public function getPresentationUrl()
    {
        if (!$this->presentation instanceof StorageDto) {
            return null;
        }
        $filesystem = Yii::createObject(\League\Flysystem\FilesystemInterface::class);

        return $filesystem->getDownloadUrl($this->presentation->getSrc());
    }

    /**
     * @return \yii\db\ActiveQuery
     */
    public function getSections()
    {
        return $this->hasMany(ProductSection::class, ['id' => 'sectionId'])
            ->viaTable(ProductBrandSectionRel::tableName(), ['brandId' => 'id']);
    }

    /**
     * @return \yii\db\ActiveQuery
     */
    public function getBlocks()
    {
        return $this->hasMany(ProductBrandBlock::class, ['brandId' => 'id']);
    }

    /**
     * @return \yii\db\ActiveQuery
     */
    public function getBrand()
    {
        return $this->hasMany(Brand::class, ['id' => 'brandId']);
    }

    /**
     * @inheritdoc
     * @return ProductBrandQuery the active query used by this AR class.
     */
    public static function find()
    {
        return new ProductBrandQuery(get_called_class());
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
        return self::find()->select(['title'])->where(['id' => $id])->scalar();
    }
}
