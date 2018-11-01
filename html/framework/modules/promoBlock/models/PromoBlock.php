<?php

namespace app\modules\promoBlock\models;

use krok\extend\behaviors\TagDependencyBehavior;
use krok\extend\behaviors\TimestampBehavior;
use krok\extend\interfaces\HiddenAttributeInterface;
use krok\extend\traits\HiddenAttributeTrait;
use krok\storage\behaviors\StorageBehavior;
use krok\storage\dto\StorageDto;
use krok\storage\interfaces\StorageInterface;
use Yii;
use yii\helpers\ArrayHelper;
use yii\helpers\Html;
use yii\validators\ImageValidator;
use yii\web\UploadedFile;

/**
 * This is the model class for table "{{%promo_block}}".
 *
 * @const PROMO_HIDDEN_NO
 * @const PROMO_HIDDEN_YES
 * @const IMAGE_TYPE_ILLUSTRATION
 * @const IMAGE_TYPE_PHOTO
 * @const IMAGE_TYPES
 * @const IMAGE_TYPE_SCENARIO
 * @const SCENARIO_ILLUSTRATION
 * @const SCENARIO_PHOTO
 * @const IMAGE_TYPE_SCENARIO
 *
 * @property integer $id
 * @property string $title
 * @property string $signature
 * @property string|UploadedFile|StorageDto $file
 * @property string $url
 * @property integer $hidden
 * @property integer $imageType
 * @property string $createdAt
 * @property string $updatedAt
 * @property integer $position
 * @property integer $btnShow
 * @property string $btnText
 */
class PromoBlock extends \yii\db\ActiveRecord implements HiddenAttributeInterface, StorageInterface
{
    use HiddenAttributeTrait;

    const PROMO_HIDDEN_NO = 0;
    const PROMO_HIDDEN_YES = 1;
    const IMAGE_TYPE_ILLUSTRATION = 0;
    const IMAGE_TYPE_PHOTO = 1;

    const IMAGE_TYPES = [
        self::IMAGE_TYPE_ILLUSTRATION => 'Иллюстрация',
        self::IMAGE_TYPE_PHOTO => 'Фотография',
    ];

    const SCENARIO_ILLUSTRATION = 'scenario_illustration';
    const SCENARIO_PHOTO = 'scenario_photo';

    const IMAGE_TYPE_SCENARIO = [
        self::IMAGE_TYPE_ILLUSTRATION => self::SCENARIO_ILLUSTRATION,
        self::IMAGE_TYPE_PHOTO => self::SCENARIO_PHOTO,
    ];

    const PROMO_BTN_SHOW_NO = 0;
    const PROMO_BTN_SHOW_YES = 1;

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
        return '{{%promo_block}}';
    }

    /**
     * @inheritdoc
     */
    public function rules()
    {
        return [
            [['title', 'signature', 'imageType'], 'required'],
            [['hidden', 'position', 'imageType', 'btnShow'], 'integer'],
            [['createdAt', 'updatedAt'], 'safe'],
            [['title', 'signature', 'btnText'], 'string', 'max' => 255],
            [
                'file',
                ImageValidator::class,
                'maxWidth' => 550,
                'maxHeight' => 550,
                'extensions' => 'png',
                'on' => static::SCENARIO_ILLUSTRATION,
                'skipOnEmpty' => true,
            ],
            [
                'file',
                ImageValidator::class,
                'minWidth' => 680,
                'minHeight' => 680,
                'extensions' => 'png, jpg, gif',
                'on' => static::SCENARIO_PHOTO,
                'skipOnEmpty' => true,
            ],
            [['url'], 'url', 'enableIDN' => true, 'defaultScheme' => 'http'],
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
            'signature' => 'Подпись',
            'imageType' => 'Тип изображения',
            'file' => 'Изображение',
            'url' => 'Ссылка',
            'hidden' => 'Заблокировано',
            'createdAt' => 'Дата создания',
            'updatedAt' => 'Дата редактирования',
            'position' => 'Позиция',
            'btnShow' => 'Отображать кнопку',
            'btnText' => 'Текст кнопки',
        ];
    }

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
            'StorageBehavior' => [
                'class' => StorageBehavior::class,
                'attribute' => 'file',
                'scenarios' => [
                    self::SCENARIO_DEFAULT,
                    self::SCENARIO_PHOTO,
                    self::SCENARIO_ILLUSTRATION,
                ],
            ],
            'TagDependencyBehavior' => TagDependencyBehavior::class,
        ];
    }

    /**
     * @return array
     */
    public static function getBtnShowList()
    {
        return [
            self::PROMO_BTN_SHOW_NO => 'Нет',
            self::PROMO_BTN_SHOW_YES => 'Да',
        ];
    }

    /**
     * @return string
     */
    public function getBtnShow()
    {
        return ArrayHelper::getValue(static::getBtnShowList(), $this->btnShow);
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
     * @return string
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
     */
    public function getCrop()
    {
        $filesystem = Yii::createObject(\League\Flysystem\FilesystemInterface::class);
        if ($this->getFile() === null) {
            return null;
        }

        return $filesystem->getPublicUrl($this->getFile()->getSrc(), ['w' => 680, 'h' => 680, 'fit' => 'crop']);
    }

    /**
     * @return string
     */
    public function getBannerCrop()
    {
        $filesystem = Yii::createObject(\League\Flysystem\FilesystemInterface::class);
        if ($this->getFile() === null) {
            return '';
        }

        return $filesystem->getPublicUrl($this->getFile()->getSrc(), ['w' => 676, 'h' => 676, 'fit' => 'crop']);
    }

    /**
     * Get item list for widget
     *
     * @return array
     *
     */
    public static function getItemList()
    {
        $itemArray = [];
        $items = static::find()
            ->orderBy(['position' => SORT_ASC])
            ->all();

        foreach ($items as $item) {
            $itemArray[] = [
                'id' => $item->id,
                'content' => $item->title . Html::hiddenInput('items[]', $item->id),
            ];
        }

        return $itemArray;
    }

    /**
     * @inheritdoc
     * @return PromoBlockQuery the active query used by this AR class.
     */
    public static function find()
    {
        return new PromoBlockQuery(get_called_class());
    }
}
