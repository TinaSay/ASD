<?php
/**
 * Copyright (c) Rustam
 */

namespace app\modules\contact\models;

use krok\extend\behaviors\TimestampBehavior;
use krok\storage\behaviors\StorageBehavior;
use krok\storage\dto\StorageDto;
use krok\storage\interfaces\StorageInterface;
use yii;
use yii\db\ActiveRecord;


/**
 * This is the model class for table "{{%requisite}}".
 *
 * @property integer $id
 * @property integer $contact_id
 * @property string $name
 * @property string $storage
 */
class Requisite extends ActiveRecord implements StorageInterface
{

    const SCENARIO_CREATE = 'create';
    private $file;

    public function getDivision()
    {
        return $this->hasOne(Division::class, ['id' => 'divisionId']);
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
        ];
    }


    /**
     * @inheritdoc
     */
    public static function tableName()
    {
        return '{{%requisite}}';
    }

    /**
     * @inheritdoc
     */
    public function rules()
    {
        return [

            [['divisionId'], 'integer'],
            [['name'], 'string', 'max' => 255],

            [
                ['file'],
                'file',
                'extensions' => 'doc, docx, pdf, txt, ppt, rtf, jpg, png',
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
            'divisionId' => 'ID отделения',
            'name' => 'Название',

        ];
    }

    public function beforeDelete()
    {
        if ($this->getFile() !== null) {
            $filesystem = Yii::createObject(\League\Flysystem\FilesystemInterface::class);
            if ($filesystem->has($this->getFile()->getSrc())) {
                $filesystem->delete($this->getFile()->getSrc());
            }
        }

        return parent::beforeDelete();
    }

    public function getFilePathUrl()
    {
        if ($this->getFile() !== null) {
            return '/uploads/storage/' . $this->getFile()->getSrc();
        } else {
            return '';
        }
    }

    public function getFilePath()
    {
        if ($this->getFile() !== null) {
            return Yii::getAlias('@root') . '/uploads/storage/' . $this->getFile()->getSrc();
        } else {
            return '';
        }
    }

    public function getFileSize()
    {
        if ($this->getFile() !== null) {
            return file_exists($this->getFilePath()) ?
                Yii::$app->formatter->asShortSize(filesize($this->getFilePath())) : 0;
        } else {
            return '';
        }
    }

    public function getFileExt()
    {
        if ($this->getFile() !== null) {
            return strtoupper(ltrim(stristr($this->getFilePath(), '.'), '.'));
        } else {
            return '';
        }
    }

    public function getUrl()
    {
        $w = "a-z0-9";
        $url_pattern = "#( 
        (?:f|ht)tps?://(?:www.)? 
        (?:[$w\\-.]+/?\\.[a-z]{2,4})/? 
        (?:[$w\\-./\\#]+)? 
        (?:\\?[$w\\-&=;\\#]+)? 
        )#xi";

        return (preg_match($url_pattern, $this->url) == true ? $this->url : 'http://' . $this->url);
    }

    /**
     * @inheritdoc
     * @return RequisiteQuery the active query used by this AR class.
     */
    public static function find()
    {
        return new RequisiteQuery(get_called_class());
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


}
