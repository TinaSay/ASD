<?php

namespace app\modules\record\models;

use krok\extend\behaviors\TimestampBehavior;
use krok\extend\interfaces\HiddenAttributeInterface;
use krok\extend\traits\HiddenAttributeTrait;
use krok\storage\behaviors\StorageBehavior;
use krok\storage\dto\StorageDto;
use krok\storage\interfaces\StorageInterface;
use Yii;
use yii\db\ActiveRecord;
use yii\validators\ImageValidator;
use yii\validators\RequiredValidator;
use yii\validators\StringValidator;
use yii\web\UploadedFile;
use yii\bootstrap\Html;
use League\Flysystem\FilesystemInterface;

/**
 * This is the model class for table "{{%record}}".
 *
 * @const ATTR_ID
 * @const ATTR_DATE_HISTORY
 * @const ATTR_DESCRIPTION
 * @const ATTR_FILE
 * @const ATTR_HIDDEN
 * @const ATTR_CREATED_AT
 * @const ATTR_UPDATED_AT
 * @const RECORD_HIDDEN_NO
 * @const RECORD_HIDDEN_YES
 *
 * @property integer $id
 * @property string $dateHistory
 * @property string $description
 * @property string $photo
 * @property integer $status
 * @property integer $createdAt
 * @property integer $updatedAt
 * @property string $photoFile
 * @property integer $year
 */
class Record extends ActiveRecord implements HiddenAttributeInterface, StorageInterface
{
    use HiddenAttributeTrait;

    const ATTR_ID = 'id';
    const ATTR_DATE_HISTORY = 'dateHistory';
    const ATTR_DESCRIPTION = 'description';
    const ATTR_FILE = 'file';
    const ATTR_HIDDEN = 'hidden';
    const ATTR_CREATED_AT = 'createdAt';
    const ATTR_UPDATED_AT = 'updatedAt';
    const RECORD_HIDDEN_NO = 0;
    const RECORD_HIDDEN_YES = 1;

    public $year;

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
        return '{{%record}}';
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
            [['dateHistory', 'hidden'], 'required'],
            [['dateHistory'], 'checkYear'],
            [['description'], 'string'],
            [['hidden'], 'integer'],
            [['file'], 'image', 'maxWidth' => 550, 'maxHeight' => 230, 'extensions' => 'png'],
        ];
    }

    /**
     * Валидация. Проверяет есть ли запись за такой год.
     *
     * @param $attribute
     * @param $params
     * @param $validator
     */
    public function checkYear($attribute, $params, $validator)
    {
        $year = date("Y", strtotime($this->dateHistory));
        $recordsQuery = $this->find()
            ->where('year(dateHistory) = ' . $year);
        if (!$this->isNewRecord) {
            $recordsQuery = $recordsQuery->andWhere(['!=', 'id', $this->id]);
        }
        if ($recordsQuery->count() > 0) {
            $this->addError($attribute, 'Запись для этого года уже есть в базе.');
        }
    }

    /**
     * @inheritdoc
     */
    public function attributeLabels()
    {
        return [
            'id' => 'ID',
            'dateHistory' => 'Дата истории',
            'description' => 'Описание',
            'file' => 'Изображение',
            'hidden' => 'Заблокировано',
            'createdAt' => 'Дата создания',
            'updatedAt' => 'Дата редактирования',
        ];
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
    
    public function setFile($file)
    {
        $this->file = $file;
    }

    /**
     * @return StorageDto|UploadedFile
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
        $filesystem = Yii::createObject(FilesystemInterface::class);
        if (!$this->file) {
            return '';
        }
        return $filesystem->getPublicUrl($this->getFile()->getSrc(), []);
    }
}
