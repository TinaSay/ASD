<?php

namespace app\modules\packet\models;


use krok\extend\behaviors\CreatedByBehavior;
use krok\extend\behaviors\TimestampBehavior;
use krok\storage\behaviors\StorageBehavior;
use krok\storage\dto\StorageDto;
use krok\storage\interfaces\StorageInterface;
use yii;
use yii\db\ActiveRecord;

/**
 * This is the model class for table "{{%packet_file}}".
 *
 * @property integer $id
 * @property string $name
 * @property integer $createdBy
 * @property string $createdAt
 * @property string $updatedAt
 * @property yii\web\UploadedFile|StorageDto $file
 */
class PacketFile extends ActiveRecord implements StorageInterface
{

    const SCENARIO_CREATE = 'create';

    /**
     * @var yii\web\UploadedFile|StorageDto
     */
    private $file;

    public function getPacket()
    {
        return $this->hasOne(Packet::class, ['id' => 'packetId']);
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
        return '{{%packet_file}}';
    }


    /**
     * @return array
     */
    public function behaviors()
    {
        return [
            'TimestampBehavior' => TimestampBehavior::class,
            'StorageBehavior' => [
                'class' => StorageBehavior::class,
                'attribute' => 'file',
                'scenarios' => [
                    self::SCENARIO_DEFAULT,
                ],
            ],
            'CreatedByBehavior' => CreatedByBehavior::class,
        ];
    }

    /**
     * @inheritdoc
     */
    public function rules()
    {
        return [
            [['createdAt', 'updatedAt', 'createdBy'], 'safe'],
            [['name'], 'string', 'max' => 255],
            [
                ['file'],
                'file',
                'extensions' => 'doc, docx, pdf, txt, ppt, rtf, jpg, png',
                'skipOnEmpty' => true,
                'skipOnError' => true,
                'maxFiles' => 1,
            ],
            [
                ['packetId'],
                'exist',
                'skipOnError' => true,
                'targetClass' => Packet::class,
                'targetAttribute' => ['packetId' => 'id'],
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
            'name' => 'Название файла',
            'createdBy' => 'Создано',
            'createdAt' => 'Создано',
            'updatedAt' => 'Редактировано',
            'file' => 'Файл',
        ];
    }

    /**
     * @inheritdoc
     * @return PacketFileQuery the active query used by this AR class.
     */
    public static function find()
    {
        return new PacketFileQuery(get_called_class());
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
    public function setFile($src)
    {
        $this->file = $src;
    }

    /**
     * @return StorageDto|yii\web\UploadedFile
     */
    public function getFile()
    {
        return $this->file;
    }


}
