<?php

namespace app\modules\sked\models;

use app\modules\auth\models\Auth;
use krok\extend\behaviors\CreatedByBehavior;
use krok\extend\behaviors\TagDependencyBehavior;
use krok\extend\behaviors\TimestampBehavior;
use krok\storage\behaviors\StorageBehavior;
use krok\storage\dto\StorageDto;
use krok\storage\interfaces\StorageInterface;
use League\Flysystem\FilesystemInterface;
use yii;
use yii\db\ActiveRecord;

/**
 * This is the model class for table "{{%item}}".
 *
 * @property integer $id
 * @property integer $skedId
 * @property string $title
 * @property string $description
 * @property string $btnLink
 * @property string $btnText
 * @property string $createdAt
 * @property string $updatedAt
 * @property integer $createdBy
 * @property integer $hidden
 * @property Sked $sked
 * @property StorageDto $file
 */
class Item extends ActiveRecord implements StorageInterface
{

    const SCENARIO_CREATE = 'create';

    private $file;

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
        return '{{%item}}';
    }

    /**
     * @return array
     */
    public function behaviors()
    {
        return [
            'TimestampBehavior' => TimestampBehavior::class,
            'CreatedByBehavior' => CreatedByBehavior::class,
            'TagDependencyBehavior' => TagDependencyBehavior::class,
            'StorageBehavior' => [
                'class' => StorageBehavior::class,
                'attribute' => 'file',
                'scenarios' => [
                    self::SCENARIO_DEFAULT,
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
            [['title', 'description'], 'required'],
            [['skedId', 'createdBy', 'hidden'], 'integer'],
            [['createdAt', 'updatedAt'], 'safe'],
            [['title'], 'string', 'max' => 255],
            [
                ['btnLink'],
                yii\validators\UrlValidator::class,
                'skipOnEmpty' => true,
                'enableIDN' => true,
                'defaultScheme' => 'http',
            ],
            [['description'], 'string', 'max' => 500],
            [['btnText'], 'string', 'max' => 100],
            [['createdBy'], 'exist', 'skipOnError' => true, 'targetClass' => Auth::class, 'targetAttribute' => ['createdBy' => 'id']],
            [['skedId'], 'exist', 'skipOnError' => true, 'targetClass' => Sked::class, 'targetAttribute' => ['skedId' => 'id']],
            [
                ['file'],
                yii\validators\ImageValidator::class,
                'extensions' => 'jpg, png',
                'skipOnEmpty' => true,
                'skipOnError' => true,
                'maxFiles' => 1,
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
            'title' => Yii::t('system', 'Title'),
            'description' => Yii::t('system', 'Description'),
            'btnLink' => Yii::t('system', 'Btn Link'),
            'btnText' => Yii::t('system', 'Btn Text'),
            'createdAt' => \Yii::t('system', 'Created At'),
            'updatedAt' => \Yii::t('system', 'Updated At'),
            'createdBy' => \Yii::t('system', 'Created By'),
            'hidden' => \Yii::t('system', 'Hidden'),
        ];
    }

    public function attributeHints()
    {
        return [
            'file' => 'Минимальный размер 130px x 90px'
        ];
    }

    /**
     * @return \yii\db\ActiveQuery
     */
    public function getCreatedBy()
    {
        return $this->hasOne(Auth::class, ['id' => 'createdBy']);
    }

    /**
     * @return \yii\db\ActiveQuery
     */
    public function getSked()
    {
        return $this->hasOne(Sked::class, ['id' => 'skedId']);
    }

    /**
     * @inheritdoc
     * @return ItemQuery the active query used by this AR class.
     */
    public static function find()
    {
        return new ItemQuery(get_called_class());
    }

    public function getFilePathUrl()
    {
        $filesystem = Yii::createObject(FilesystemInterface::class);

        if ($this->file instanceof StorageDto) {
            return $filesystem->getDownloadUrl($this->file->getSrc());
        }
        return '';
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

    public function setFile($src)
    {
        $this->file = $src;
    }

    /**
     * @return yii\web\UploadedFile|StorageDto
     */
    public function getFile()
    {
        return $this->file;
    }

    public function getUrl()
    {
        return $this->btnLink;
    }

    public function getImage()
    {
        $filesystem = Yii::createObject(FilesystemInterface::class);
        if ($this->file instanceof StorageDto) {
            return $filesystem->getPublicUrl($this->file->getSrc(), ['w' => 130, 'h' => 90]);
        }

        return '';
    }


}
