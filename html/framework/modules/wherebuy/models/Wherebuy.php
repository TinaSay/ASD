<?php

namespace app\modules\wherebuy\models;

use app\modules\auth\models\Auth;
use app\modules\brand\models\Brand;
use app\modules\contact\validators\SvgPngValidator;
use krok\extend\behaviors\CreatedByBehavior;
use krok\extend\behaviors\LanguageBehavior;
use krok\extend\behaviors\TagDependencyBehavior;
use krok\extend\behaviors\TimestampBehavior;
use krok\extend\interfaces\HiddenAttributeInterface;
use krok\extend\traits\HiddenAttributeTrait;
use krok\storage\behaviors\StorageBehavior;
use krok\storage\dto\StorageDto;
use krok\storage\interfaces\StorageInterface;
use League\Flysystem\FilesystemInterface;
use voskobovich\behaviors\ManyToManyBehavior;
use yii;
use yii\helpers\ArrayHelper;

/**
 * This is the model class for table "{{%wherebuy}}".
 *
 * @property integer $id
 * @property string $title
 * @property string $subtitle
 * @property string $link
 * @property string $delivery
 * @property integer $hidden
 * @property integer $showInProduct
 * @property string $createdAt
 * @property string $updatedAt
 */
class Wherebuy extends \yii\db\ActiveRecord implements HiddenAttributeInterface, StorageInterface
{
    use HiddenAttributeTrait;

    const SHOW_IN_PRODUCT_NO = 0;
    const SHOW_IN_PRODUCT_YES = 1;

    private $src;

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
        return '{{%wherebuy}}';
    }

    /**
     * @inheritdoc
     */
    public function rules()
    {
        return [
            [['hidden', 'showInProduct'], 'integer'],
            [['title'], 'required'],
            [['title', 'subtitle', 'delivery'], 'string', 'max' => 255],
            [
                ['createdBy'],
                'exist',
                'skipOnError' => true,
                'targetClass' => Auth::class,
                'targetAttribute' => ['createdBy' => 'id'],
            ],
            [
                'src',
                SvgPngValidator::class,
                'maxWidth' => 130,
                'maxHeight' => 90,
                'extensions' => 'svg,png',
                'checkExtensionByMimeType' => false,
                'skipOnEmpty' => true,
            ],

            [['link'], 'url', 'defaultScheme' => 'http'],

            [['brandIDs'], 'each', 'rule' => ['integer']],
            [['createdAt', 'updatedAt'], 'safe'],
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
            'subtitle' => 'Подзаголовок',
            'link' => 'Ссылка',
            'delivery' => 'Доставка',
            'hidden' => 'Заблокировано',
            'showInProduct' => 'Вывод в карточку товара',
            'brandIDs' => 'Бренды',
            'src' => 'Логотип',
            'createdAt' => 'Дата создания',
            'updatedAt' => 'Дата редактирования',
        ];
    }


    /**
     * @inheritdoc
     */
    public function attributeHints()
    {
        return [
            'src' => 'Допускается загрузка только файлов формата png и svg, размер загружаемого изображения: не более 130x90 px',
        ];
    }

    /**
     * @return array
     */
    public function behaviors()
    {
        return [
            'CreatedByBehavior' => CreatedByBehavior::class,
            'TimestampBehavior' => TimestampBehavior::class,
            'TagDependencyBehavior' => TagDependencyBehavior::class,
            'StorageBehavior' => [
                'class' => StorageBehavior::class,
                'attribute' => 'src',
                'scenarios' => [
                    self::SCENARIO_DEFAULT,
                ],
            ],
            'ManyToManyBehavior' => [
                'class' => ManyToManyBehavior::class,
                'relations' => [
                    'brandIDs' => 'brandRelation',
                ],
            ],

            'LanguageBehavior' => LanguageBehavior::class,
        ];
    }

    /**
     * @return \yii\db\ActiveQuery
     */
    public function getBrandRelation()
    {
        return $this->hasMany(Brand::class, ['id' => 'brandId'])->viaTable(WherebuyBrand::tableName(),
            ['wherebuyId' => 'id']);
    }

    /**
     * @return string
     */
    public function getBrandsString()
    {
        return implode(', ', ArrayHelper::getColumn($this->brandRelation, 'title'));
    }

    /**
     * @return \yii\db\ActiveQuery
     */
    public function getCreatedByRelation()
    {
        return $this->hasOne(Auth::class, ['id' => 'createdBy']);
    }

    /**
     * @inheritdoc
     * @return WherebuyQuery the active query used by this AR class.
     */
    public static function find()
    {
        return new WherebuyQuery(get_called_class());
    }

    /**
     * @return string
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
     * @return null|string
     */
    public function getTitle(): ?string
    {
        return null;
    }

    /**
     * @return null|string
     */
    public function getHint(): ?string
    {
        return null;
    }

    /**
     * @param $src
     */
    public function setSrc($src)
    {
        $this->src = $src;
    }

    /**
     * @return StorageDto|yii\web\UploadedFile
     */
    public function getSrc()
    {
        return $this->src;
    }

    /**
     * @return string
     */
    public function getLoggingTitle(): string
    {
        return $this->title;
    }


    public function getImage()
    {
        $filesystem = Yii::createObject(FilesystemInterface::class);
        if ($this->src instanceof StorageDto) {
            return $filesystem->getPublicUrl($this->src->getSrc(), ['w' => 130, 'h' => 90]);
        }

        return '';
    }


    /**
     * @param int $hidden
     *
     * @return array
     */
    public static function getList($hidden = self::HIDDEN_NO)
    {
        $list = self::find()->select([
            'id',
            'title',
        ])->where(['hidden' => $hidden])->language()->orderBy('title')->asArray()->all();

        return ArrayHelper::map($list, 'id', 'title');
    }

    /**
     * @return array
     */
    public static function getShowInProductList()
    {
        return [
            self::SHOW_IN_PRODUCT_NO => 'Нет',
            self::SHOW_IN_PRODUCT_YES => 'Да',
        ];
    }

    /**
     * @return string
     */
    public function getShowInProduct()
    {
        return ArrayHelper::getValue(static::getShowInProductList(), $this->showInProduct);
    }
}
