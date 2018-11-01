<?php

namespace app\modules\brand\models;

use krok\extend\behaviors\TagDependencyBehavior;
use krok\extend\behaviors\TimestampBehavior;
use krok\extend\interfaces\BlockedAttributeInterface;
use krok\extend\traits\BlockedAttributeTrait;
use krok\storage\behaviors\StorageBehavior;
use krok\storage\dto\StorageDto;
use krok\storage\interfaces\StorageInterface;
use Yii;
use yii\db\ActiveRecord;
use yii\helpers\ArrayHelper;
use yii\web\UploadedFile;

/**
 * This is the model class for table "{{%brand}}".
 *
 * @property integer $id
 * @property string $title
 * @property string $text
 * @property string $title2
 * @property string $text2
 * @property string $link
 * @property integer $blocked
 * @property integer $position
 *
 * @mixin StorageBehavior
 */
class Brand extends ActiveRecord implements BlockedAttributeInterface, StorageInterface
{
    use BlockedAttributeTrait;

    const SCENARIO_IMPORT = 'import';

    /**
     * @var UploadedFile|StorageDto
     */
    private $logo;
    /**
     * @var UploadedFile|StorageDto
     */
    private $illustration;
    /**
     * @var UploadedFile|StorageDto
     */
    private $presentation;

    /**
     * @var integer
     */
    public $productBrandId;

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
            'StorageBehaviorLogo' => [
                'class' => StorageBehavior::class,
                'attribute' => 'logo',
                'scenarios' => [
                    self::SCENARIO_DEFAULT,
                    self::SCENARIO_IMPORT,
                ],
            ],
            'StorageBehaviorIllustration' => [
                'class' => StorageBehavior::class,
                'attribute' => 'illustration',
                'scenarios' => [
                    self::SCENARIO_DEFAULT,
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
            'TagDependencyBehavior' => TagDependencyBehavior::class,
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
        return '{{%brand}}';
    }

    /**
     * @inheritdoc
     */
    public function rules()
    {
        return [
            [['title'], 'required'],
            [['text'], 'string', 'max' => 236],
            ['text', function ($attribute) {
                $count = substr_count($this->$attribute, "\n") + 1;
                if ($count > 17) {
                    $this->addError($attribute, 'Размер текста не должен превышать 17 строк.');
                }
            }],
            [['text2'], 'string', 'max' => 350],
            ['text2', function ($attribute) {
                $count = substr_count($this->$attribute, "\n") + 1;
                if ($count > 6) {
                    $this->addError($attribute, 'Размер текста не должен превышать 6 строк.');
                }
            }],
            [['blocked', 'position'], 'integer'],
            [['title', 'title2', 'link'], 'string', 'max' => 255],
            [['link'], 'url', 'defaultScheme' => 'http'],
            [
                ['logo'],
                'image',
                'extensions' => 'png',
                'skipOnEmpty' => true,
                'maxWidth' => 220,
                'maxHeight' => 65,
            ],
            [
                ['illustration'],
                'image',
                'extensions' => 'png',
                'skipOnEmpty' => true,
                'maxWidth' => 430,
                'maxHeight' => 430,
            ],
            [
                ['presentation'],
                'file',
                'extensions' => 'pdf, ppt, zip, rar',
                'skipOnEmpty' => true,
            ],
            [
                ['presentation'],
                'file',
                'skipOnEmpty' => true,
            ],
            /** virtual properties */
            [['productBrandId'], 'integer'],
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
            'text' => 'Текст к иллюстрации',
            'title2' => 'Заголовок 2',
            'text2' => 'Текст',
            'link' => 'Ссылка',
            'blocked' => 'Заблокировано',
            'logo' => 'Логотип',
            'illustration' => 'Иллюстрация',
            'presentation' => 'Презентация',
            'position' => 'Сортировка',
            'productBrandId' => 'Связь с брендом из 1С',
            'createdAt' => 'Дата создания',
            'updatedAt' => 'Дата изменения',
        ];
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
     * @return StorageDto|UploadedFile
     */
    public function getIllustration()
    {
        return $this->illustration;
    }

    /**
     * @param $illustration
     */
    public function setIllustration($illustration)
    {
        $this->illustration = $illustration;
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
     * @param string $attribute
     * @param string $size
     *
     * @return string
     */
    public function getPreview(string $attribute, $size = 'default')
    {
        $options = [
            'default' => ['w' => 300],
            'home-small' => ['w' => 100, 'h' => 50, 'fit' => 'fill'],
            'home-big' => ['w' => 160, 'h' => 65, 'fit' => 'max'],
            'illustration-home' => ['w' => 430, 'h' => 430, 'fit' => 'max'],
        ];

        $filesystem = Yii::createObject(\League\Flysystem\FilesystemInterface::class);
        if (!$this->{$attribute}) {
            return '';
        }

        return $filesystem->getPublicUrl($this->{$attribute}->getSrc(), $options[$size]);
    }

    /**
     * @param string $attribute
     *
     * @return bool|string
     */
    public function getSrc($attribute)
    {
        if (empty($this->{$attribute})) {
            return false;
        }

        return $this->{$attribute}->getSrc();
    }

    /**
     * @return array
     */
    public static function getList()
    {
        $list = self::find()
            ->where(['blocked' => self::BLOCKED_NO])
            ->orderBy(['position' => SORT_ASC])
            ->asArray()
            ->all();

        return ArrayHelper::map($list, 'id', 'title');
    }

    /**
     * @param null $blocked
     *
     * @return array
     */
    public static function asDropDown($blocked = null)
    {
        return self::find()->select(['title', 'id'])
            ->andFilterWhere(['blocked' => $blocked])
            ->orderBy(['title' => SORT_ASC])
            ->indexBy('id')
            ->column();
    }
}
