<?php

namespace app\modules\banner\models;

use app\modules\contact\validators\SvgPngValidator;
use krok\extend\behaviors\TagDependencyBehavior;
use krok\extend\behaviors\TimestampBehavior;
use krok\extend\interfaces\HiddenAttributeInterface;
use krok\extend\traits\HiddenAttributeTrait;
use krok\storage\behaviors\StorageBehavior;
use krok\storage\dto\StorageDto;
use krok\storage\interfaces\StorageInterface;
use Yii;
use yii\helpers\ArrayHelper;
use yii\validators\BooleanValidator;
use yii\validators\RequiredValidator;
use yii\validators\SafeValidator;
use yii\validators\StringValidator;
use yii\web\UploadedFile;

//use yii\validators\ImageValidator;

/**
 * This is the model class for table "{{%banner}}".
 *
 * @const BANNER_HIDDEN_NO
 * @const BANNER_HIDDEN_YES
 * @const BANNER_LIMIT_ON_MAIN
 * @const ATTR_ID
 * @const ATTR_TITLE
 * @const ATTR_SIGNATURE
 * @const ATTR_FILE
 * @const ATTR_HIDDEN
 * @const ATTR_PUBLICATION_PLACES
 * @const ATTR_CREATED_AT
 * @const ATTR_UPDATED_AT
 * @const PUBLICATION_PLACE_MAIN_PAGE
 * @const PUBLICATION_PLACE_ABOUT_US
 * @const PUBLICATION_PLACE_CLIENT_SERVICE
 * @const PUBLICATION_PLACE_PRODUCTION
 * @const PUBLICATION_PLACE_LOGISTIC
 * @const PUBLICATION_PLACE_MARKETING
 * @const PUBLICATION_PLACES
 *
 * @property integer $id
 * @property string $title
 * @property string $signature
 * @property string|UploadedFile|StorageDto $file
 * @property integer $hidden
 * @property string $createdAt
 * @property string $updatedAt
 * @property BannerPublicationPlace $bannerPublicationPlace
 * @property integer $showOnIndex
 * @property integer $showOnWherebuy
 */
class Banner extends \yii\db\ActiveRecord implements HiddenAttributeInterface, StorageInterface
{
    use HiddenAttributeTrait;

    const SCENARIO_DEFAULT = 'default';
    const SCENARIO_CREATE = 'create';
    const SCENARIO_UPDATE = 'update';

    const BANNER_HIDDEN_NO = 0;
    const BANNER_HIDDEN_YES = 1;
    const BANNER_LIMIT_ON_MAIN = 12;
    const BANNER_LIMIT_ON_WHEREBUY = 3;
    const BANNER_LIMIT_ON_CONTENT = 24; // нужно уточнить

    const ATTR_ID = 'id';
    const ATTR_TITLE = 'title';
    const ATTR_SIGNATURE = 'signature';
    const ATTR_FILE = 'file';
    const ATTR_HIDDEN = 'hidden';
    const ATTR_PUBLICATION_PLACES = 'publicationPlaces';
    const ATTR_SHOWONINDEX = 'showOnIndex';
    const ATTR_SHOWONWHEREBUY = 'showOnWherebuy';
    const ATTR_CREATED_AT = 'createdAt';
    const ATTR_UPDATED_AT = 'updatedAt';

    const SHOW_ON_INDEX_NO = 0;
    const SHOW_ON_INDEX_YES = 1;
    const SHOW_ON_WHEREBUY_NO = 0;
    const SHOW_ON_WHEREBUY_YES = 1;

    const PUBLICATION_PLACE_MAIN_PAGE = 0;
    const PUBLICATION_PLACE_ABOUT_US = 1;
    const PUBLICATION_PLACE_CLIENT_SERVICE = 2;
    const PUBLICATION_PLACE_PRODUCTION = 3;
    const PUBLICATION_PLACE_LOGISTIC = 4;
    const PUBLICATION_PLACE_MARKETING = 5;
    const PUBLICATION_PLACE_WHEREBUY = 6;
    const PUBLICATION_PLACE_CONTENT = 7;

    const PUBLICATION_PLACES = [
        self::PUBLICATION_PLACE_MAIN_PAGE => 'Главная страница',
        self::PUBLICATION_PLACE_ABOUT_US => 'Кратко о нас',
        self::PUBLICATION_PLACE_CLIENT_SERVICE => 'Клиентский сервис',
        self::PUBLICATION_PLACE_PRODUCTION => 'Производство',
        self::PUBLICATION_PLACE_LOGISTIC => 'Логистика',
        self::PUBLICATION_PLACE_MARKETING => 'Маркетинг',
        self::PUBLICATION_PLACE_WHEREBUY => 'Где купить',
        self::PUBLICATION_PLACE_CONTENT => 'Контент',
    ];

    /** @var array TODO... */
    public $publicationPlaces;


    private $file;

    /**
     * @inheritdoc
     */
    public function behaviors()
    {
        return [
            'TimestampBehavior' => [
                'class' => TimestampBehavior::class,
                'createdAtAttribute' => static::ATTR_CREATED_AT,
                'updatedAtAttribute' => static::ATTR_UPDATED_AT,
            ],
            'StorageBehavior' => [
                'class' => StorageBehavior::class,
                'attribute' => 'file',
                'scenarios' => [
                    self::SCENARIO_CREATE,
                    self::SCENARIO_DEFAULT
                ],
            ],
            'TagDependencyBehavior' => TagDependencyBehavior::class,
        ];
    }

    /**
     * @inheritdoc
     */
    public static function tableName()
    {
        return '{{%banner}}';
    }

    /**
     * @inheritdoc
     */
    public function rules()
    {
        return [
            [static::ATTR_TITLE, RequiredValidator::class],
            [static::ATTR_SIGNATURE, RequiredValidator::class],
            [static::ATTR_HIDDEN, RequiredValidator::class],
            [static::ATTR_PUBLICATION_PLACES, SafeValidator::class],
            [static::ATTR_FILE, 'required', 'message' => 'Поле {attribute} не может быть пустым', 'on' => self::SCENARIO_CREATE],
            [
                static::ATTR_FILE,
                SvgPngValidator::class,
                'maxWidth' => 200,
                'maxHeight' => 200,
                'extensions' => 'svg, png',
                'skipOnEmpty' => false,
                'on' => self::SCENARIO_CREATE
            ],
            [
                static::ATTR_FILE,
                SvgPngValidator::class,
                'maxWidth' => 200,
                'maxHeight' => 200,
                'extensions' => 'svg, png',
                'skipOnEmpty' => true,
                'on' => self::SCENARIO_DEFAULT
            ],
            [[static::ATTR_HIDDEN, static::ATTR_SHOWONWHEREBUY, static::ATTR_SHOWONINDEX], BooleanValidator::class],
            [static::ATTR_TITLE, StringValidator::class, 'max' => 255],
            [static::ATTR_SIGNATURE, StringValidator::class, 'max' => 255],
        ];
    }

    /**
     * @inheritdoc
     */
    public function attributeLabels()
    {
        return [
            static::ATTR_ID => 'ID',
            static::ATTR_TITLE => 'Заголовок',
            static::ATTR_SIGNATURE => 'Подпись',
            static::ATTR_FILE => 'Изображение',
            static::ATTR_HIDDEN => 'Заблокировано',
            static::ATTR_PUBLICATION_PLACES => 'Места публикации',
            static::ATTR_CREATED_AT => 'Создано',
            static::ATTR_UPDATED_AT => 'Обновлено',
            static::ATTR_SHOWONINDEX => 'Показать на главной',
            static::ATTR_SHOWONWHEREBUY => 'Показать на интернет магазинах',
        ];
    }

    public function getShowOnIndexList()
    {
        return [
            self::SHOW_ON_INDEX_NO => 'Нет',
            self::SHOW_ON_INDEX_YES => 'Да',
        ];
    }

    public function getShowOnIndex()
    {
        return ArrayHelper::getValue(self::getShowOnIndexList(), $this->showOnIndex);
    }

    public function getShowOnWherebuyList()
    {
        return [
            self::SHOW_ON_WHEREBUY_NO => 'Нет',
            self::SHOW_ON_WHEREBUY_YES => 'Да',
        ];
    }

    public function getShowOnWherebuy()
    {
        return ArrayHelper::getValue(self::getShowOnWherebuyList(), $this->showOnWherebuy);
    }

    /**
     * @inheritdoc
     */
    public function afterSave($insert, $changedAttributes)
    {
        $this->_savePublicationPlaces();
        parent::afterSave($insert, $changedAttributes);
    }

    /**
     * Save publication banner places
     */
    private function _savePublicationPlaces()
    {
        BannerPublicationPlace::deleteAll([BannerPublicationPlace::ATTR_BANNER_ID => $this->id]);
        $rows = [];

        if (false === is_array($this->publicationPlaces)) {
            return;
        }

        foreach ($this->publicationPlaces as $publicationPlace) {
            $rows[] = [$this->id, $publicationPlace];
        }

        Yii::$app->db->createCommand()
            ->batchInsert(
                BannerPublicationPlace::tableName(),
                [BannerPublicationPlace::ATTR_BANNER_ID, BannerPublicationPlace::ATTR_PLACE_ID],
                $rows
            )
            ->execute();
    }

    /**
     * Get banner publication places
     */
    public function getPublicationPlaces()
    {
        $this->publicationPlaces = BannerPublicationPlace::find()
            ->select(BannerPublicationPlace::ATTR_PLACE_ID)
            ->where([BannerPublicationPlace::ATTR_BANNER_ID => $this->id])
            ->asArray(true)
            ->all();

        $this->publicationPlaces = ArrayHelper::getColumn($this->publicationPlaces,
            BannerPublicationPlace::ATTR_PLACE_ID);
    }

    /**
     * Get banner publication places text string
     */
    public function getPublicationPlacesString()
    {
        if (empty($this->publicationPlaces)) {
            return 'Нет мест публикаций';
        }
        $str = [];
        foreach ($this->publicationPlaces as $publicationPlace) {
            $str[] = static::PUBLICATION_PLACES[$publicationPlace];
        }

        return implode(', ', $str);
    }

    /**
     * getModel()
     */
    public function getModel(): string
    {
        return static::class;
    }

    /**
     * getRecordId()
     */
    public function getRecordId(): int
    {
        return $this->id;
    }

    /**
     * getTitle()
     */
    public function getTitle(): ?string
    {
        return null;
    }

    /**
     * getHint()
     */
    public function getHint(): ?string
    {
        return null;
    }

    /**
     * @return UploadedFile|StorageDto
     */
    public function getFile()
    {
        return $this->file;
    }

    /**
     * @param $src
     */
    public function setFile($src)
    {
        $this->file = $src;
    }

    /**
     * @return string
     * @throws \yii\base\InvalidConfigException
     */
    public function getPreview()
    {
        $filesystem = Yii::createObject(\League\Flysystem\FilesystemInterface::class);
        if (!$this->file) {
            return '';
        }

        return $filesystem->getPublicUrl($this->getFile()->getSrc(), ['w' => 300]);
    }

    /**
     * @return string
     * @throws \yii\base\InvalidConfigException
     */
    public function getRecordImage()
    {
        $filesystem = Yii::createObject(\League\Flysystem\FilesystemInterface::class);
        if (!$this->file) {
            return '';
        }

        return $filesystem->getPublicUrl($this->getFile()->getSrc(), []);
    }

    /**
     * @return string
     * @throws \yii\base\InvalidConfigException
     */
    public function getImage()
    {
        if ($this->file instanceof StorageDto) {
            $filesystem = Yii::createObject(\League\Flysystem\FilesystemInterface::class);

            return $filesystem->getDownloadUrl($this->getFile()->getSrc());
        }

        return '';
    }

    /**
     * @return string
     * @throws \yii\base\InvalidConfigException
     */
    public function getCrop()
    {
        $filesystem = Yii::createObject(\League\Flysystem\FilesystemInterface::class);

        return $filesystem->getPublicUrl($this->getFile()->getSrc(), ['w' => 600, 'h' => 600, 'fit' => 'crop']);
    }

    /**
     * File Previews
     *
     * @param string $attribute
     * @param string $size
     *
     * @return string
     * @throws \yii\base\InvalidConfigException
     */
    public function getImagePreview(string $attribute, string $size = 'initial'): string
    {
        $config = [
            'initial' => [],
            'xs' => ['w' => 164, 'h' => 150, 'fit' => 'max'],
        ];

        $filesystem = Yii::createObject(\League\Flysystem\FilesystemInterface::class);

        if ($this->{$attribute} !== null) {
            if (is_array($this->{$attribute})) {
                $result = '';
                foreach ($this->{$attribute} as $file) {
                    if ($file instanceof StorageDto) {
                        $result = $filesystem->getPublicUrl($file->getSrc(), $config[$size]);
                        break;
                    }
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
     * @return \yii\db\ActiveQuery
     */
    public function getBannerPublicationPlace()
    {
        return $this->hasOne(BannerPublicationPlace::class, ['bannerId' => 'id']);
    }
}
