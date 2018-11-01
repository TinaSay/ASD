<?php

namespace app\modules\about\models;

use app\behaviors\StorageBehavior\StorageBehavior;
use app\modules\meta\adapters\OpenGraphAdapter;
use krok\extend\behaviors\TimestampBehavior;
use krok\extend\interfaces\BlockedAttributeInterface;
use krok\extend\traits\BlockedAttributeTrait;
use krok\meta\behaviors\MetaBehavior;
use krok\storage\dto\StorageDto;
use krok\storage\interfaces\StorageInterface;
use tina\metatag\behaviors\MetatagBehavior;
use Yii;
use yii\db\ActiveRecord;
use yii\db\Expression;
use yii\helpers\ArrayHelper;
use yii\helpers\Html;
use yii\helpers\Url;
use yii\web\UploadedFile;

/**
 * This is the model class for table "{{%about}}".
 *
 * @property integer $id
 * @property string $title
 * @property string $description
 * @property string $titleForImage
 * @property string $descriptionImage
 * @property string $titleForBanners
 * @property string $titleAdditionalBlock
 * @property string $additionalDescription
 * @property string $urlYoutubeVideo
 * @property integer $publicHistory
 * @property integer $publishAnApplication
 * @property integer $blocked
 * @property string $createdAt
 * @property string $updatedAt
 * @property string $meta
 *
 *
 * @property AboutBanner[] $aboutBanners
 * @property AboutBanner[] $aboutBannersRandLimited
 * @property array $aboutListMenu
 * @property string $embed
 * @property StorageDto $additionalImage
 */
class About extends ActiveRecord implements BlockedAttributeInterface, StorageInterface
{
    use BlockedAttributeTrait;

    const BANNER_LIMIT = 3;

    public $meta;

    /**
     * @var array
     */
    private $banners;

    /**
     * @var UploadedFile|StorageDto
     */
    private $image;

    /**
     * @var UploadedFile|StorageDto
     */
    private $additionalImage;

    /**
     * @var UploadedFile|StorageDto
     */
    private $mainVideo;

    /**
     * @inheritdoc
     */
    public function behaviors()
    {
        return [
            'TimestampBehavior' => [
                'class' => TimestampBehavior::class,
                'createdAtAttribute' => 'createdAt',
                'updatedAtAttribute' => 'updatedAt',
            ],
            'StorageBehaviorImage' => [
                'class' => StorageBehavior::class,
                'attribute' => 'image',
                'scenarios' => [
                    self::SCENARIO_DEFAULT,
                ],
                'uploadedDirectory' => '/storage',
            ],
            'StorageBehaviorAdditionalImage' => [
                'class' => StorageBehavior::class,
                'attribute' => 'additionalImage',
                'scenarios' => [
                    self::SCENARIO_DEFAULT,
                ],
                'uploadedDirectory' => '/storage',
            ],
            'StorageBehaviorMainVideo' => [
                'class' => StorageBehavior::class,
                'attribute' => 'mainVideo',
                'scenarios' => [
                    self::SCENARIO_DEFAULT,
                ],
                'uploadedDirectory' => '/storage',
            ],
            'MetatagBehavior' => [
                'class' => MetatagBehavior::class,
                'metaAttribute' => 'meta',
            ],
            'MetaBehavior' => [
                'class' => MetaBehavior::class,
                'adapters' => [
                    OpenGraphAdapter::class,
                ],
            ],
        ];
    }

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
        return '{{%about}}';
    }

    /**
     * @inheritdoc
     */
    public function rules()
    {
        return [
            [['description', 'additionalDescription'], 'string'],
            [['publicHistory', 'publishAnApplication', 'blocked'], 'integer'],
            [['createdAt', 'updatedAt', 'banners'], 'safe'],
            [
                [
                    'title',
                    'titleForImage',
                    'descriptionImage',
                    'titleForBanners',
                    'titleAdditionalBlock',
                    'urlYoutubeVideo',
                ],
                'string',
                'max' => 255,
            ],
            [
                ['image'],
                'image',
                'extensions' => 'jpg, png',
                'skipOnEmpty' => true,
                'minWidth' => 340,
                'minHeight' => 340,
            ],
            [['additionalImage'], 'image', 'extensions' => 'jpg, png', 'skipOnEmpty' => true],
            [['mainVideo'], 'file', 'extensions' => 'mp4, ogv, webm', 'skipOnEmpty' => true],
        ];
    }

    /**
     * @inheritdoc
     */
    public function attributeLabels()
    {
        return [
            'id' => 'ID',
            'title' => 'Заголовок',
            'description' => 'Описание',
            'image' => 'Изображение',
            'mainVideo' => 'Основное видео',
            'titleForImage' => 'Название к изображению',
            'descriptionImage' => 'Подпись к изображению',
            'titleForBanners' => 'Заголовок к баннерам',
            'banners' => 'Баннеры',
            'titleAdditionalBlock' => 'Заголовок дополнительного блока',
            'additionalDescription' => 'Дополнительное описание',
            'additionalImage' => 'Дополнительное изображение',
            'urlYoutubeVideo' => 'Ссылка на youtube-видео',
            'publicHistory' => 'Публикация истории',
            'publishAnApplication' => 'Публикация заявки',
            'blocked' => 'Заблокировано',
            'createdAt' => 'Создано',
            'updatedAt' => 'Обновлено',
        ];
    }

    /**
     * @return \yii\db\ActiveQuery
     */
    public function getAboutBanners()
    {
        return $this->hasMany(AboutBanner::class, ['aboutId' => 'id']);
    }


    public function getAboutBannersRandLimited()
    {
        return $this->hasMany(AboutBanner::class, ['aboutId' => 'id'])->orderBy(new Expression('rand()'))->limit(self::BANNER_LIMIT);
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
     * StorageInterface realization
     *
     * @return string Model id
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
     * @return StorageDto|UploadedFile
     */
    public function getImage()
    {
        return $this->image;
    }

    /**
     * @param StorageDto|UploadedFile $image
     */
    public function setImage($image)
    {
        $this->image = $image;
    }

    /**
     * @return StorageDto|UploadedFile
     */
    public function getAdditionalImage()
    {
        return $this->additionalImage;
    }

    /**
     * StorageBehavior setter realization
     *
     * @return void
     */
    public function setAdditionalImage($additionalImage)
    {
        $this->additionalImage = $additionalImage;
    }

    /**
     * @return StorageDto|UploadedFile
     */
    public function getMainVideo()
    {
        return $this->mainVideo;
    }

    /**
     * StorageBehavior setter realization
     *
     * @return void
     */
    public function setMainVideo($mainVideo)
    {
        $this->mainVideo = $mainVideo;
    }

    /**
     * @return string
     */
    public function getPreview(string $attribute)
    {
        $filesystem = Yii::createObject(\League\Flysystem\FilesystemInterface::class);
        if (!$this->{$attribute}) {
            return '';
        }

        return $filesystem->getPublicUrl($this->{$attribute}->getSrc(), ['w' => 300]);
    }

    public function getSrc($attribute)
    {
        if (empty($this->{$attribute})) {
            return false;
        }

        return $this->{$attribute}->getSrc();
    }

    public function setBanners($banners)
    {
        $this->banners = $banners;
    }

    /**
     * @return mixed
     */
    public function getBanners()
    {
        return ArrayHelper::getColumn($this->aboutBanners, 'bannerId');
    }

    /**
     * Возвращает список ссылок на баннеры, закрепленные за текущей записью
     *
     * @return string
     */
    public function getBannersList()
    {
        $banners = $this->aboutBanners;
        $result = '';
        if (is_array($banners) && !empty($banners)) {
            $result = [];
            foreach ($banners as $banner) {
                $result[] = Html::a($banner->banner->title, ['/banner/banner/view', 'id' => $banner->bannerId],
                    ['target' => '_blank']);
            }
            $result = implode(', ', $result);
        }

        return $result;
    }

    /**
     * Список ссылок на записи из таблицы about
     *
     * @param array $params
     *
     * @return array
     */
    public function getAboutListMenu($params = [])
    {
        $aboutListMenu = self::find()
            ->where(['blocked' => BlockedAttributeInterface::BLOCKED_NO])
            ->orderBy(['position' => SORT_ASC])
            ->all();
        $result = [];
        if (empty($aboutListMenu)) {
            return $result;
        }
        /** @var About[] $aboutListMenu */
        foreach ($aboutListMenu as $aboutItemMenu) {
            $result[] = [
                'label' => $aboutItemMenu->title,
                'url' => ['/about/default/view', 'id' => $aboutItemMenu->id],
                'options' => ['class' => ($params['liClass']) ?? ''],
            ];
        }

        return $result;
    }

    /**
     * File Previews
     *
     * @return string
     */
    public function getImagePreview(string $attribute, string $size = 'initial'): string
    {
        $config = [
            'initial' => [],
            'about-main' => ['w' => 340, 'h' => 340, 'fit' => 'crop'],
        ];

        $filesystem = Yii::createObject(\League\Flysystem\FilesystemInterface::class);

        if ($this->{$attribute} !== null) {
            if (is_array($this->{$attribute})) {
                $result = '';
                /** @var StorageDto $file */
                foreach ($this->{$attribute} as $file) {
                    $result = $filesystem->getPublicUrl($file->getSrc(), $config[$size]);
                    break;
                }

                return $result;
            } else {
                return $filesystem->getPublicUrl($this->{$attribute}->getSrc(), $config[$size]);
            }
        } else {
            return '';
        }
    }

    /**
     * @param string $attribute
     *
     * @return array
     */
    public function getImagePreviewConfig(string $attribute): array
    {
        if ($this->{$attribute} !== null) {
            if (is_array($this->{$attribute})) {
                $result = [];
                foreach ($this->{$attribute} as $file) {
                    if ($file instanceof StorageDto) {
                        $result[] = [
                            'key' => $file->getSrc(),
                            'url' => Url::to([
                                'remove-file',
                                'id' => $this->id,
                                'attribute' => $attribute,
                            ]),
                        ];
                    }
                }

                return $result;
            } else {
                if ($this->{$attribute} instanceof StorageDto) {
                    return [
                        [
                            'key' => $this->{$attribute}->getSrc(),
                            'url' => Url::to([
                                'remove-file',
                                'id' => $this->id,
                                'attribute' => $attribute,
                            ]),
                        ],
                    ];
                } else {
                    return [];
                }
            }
        } else {
            return [];
        }
    }

    /**
     * File links
     *
     * @return string
     */
    public function getImagePreviewLink(string $attribute, string $size = 'initial'): string
    {
        $config = [
            'initial' => [],
            'additionalImage' => ['w' => 754, 'h' => 424, 'fit' => 'crop'],
        ];

        $filesystem = Yii::createObject(\League\Flysystem\FilesystemInterface::class);

        if ($this->{$attribute} !== null) {
            if (is_array($this->{$attribute})) {
                $result = '';
                /** @var StorageDto $file */
                foreach ($this->{$attribute} as $file) {
                    $result = $filesystem->getPublicUrl($file->getSrc(), $config[$size]);
                    break;
                }

                return $result;
            } else {
                return $filesystem->getPublicUrl($this->{$attribute}->getSrc(), $config[$size]);
            }
        } else {
            return '';
        }
    }

    /**
     * @return null|string|string[]
     */
    public function getEmbed()
    {
        return preg_replace("/\s*[a-zA-Z\/\/:\.]*youtube.com\/watch\?v=([a-zA-Z0-9\-_]+)([a-zA-Z0-9\/\*\-\_\?\&\;\%\=\.]*)/i",
            "<iframe frameborder=\"0\" allowfullscreen id=\"Youtube\" src=\"//www.youtube.com/embed/$1?rel=0&enablejsapi=1\"></iframe>",
            $this->urlYoutubeVideo);
    }
}
