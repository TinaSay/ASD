<?php

namespace app\modules\product\models;

use krok\extend\behaviors\TagDependencyBehavior;
use krok\extend\behaviors\TimestampBehavior;
use krok\extend\interfaces\HiddenAttributeInterface;
use krok\extend\traits\HiddenAttributeTrait;
use krok\storage\behaviors\StorageBehavior;
use krok\storage\dto\StorageDto;
use krok\storage\interfaces\StorageInterface;
use Yii;
use yii\web\UploadedFile;

/**
 * This is the model class for table "{{%product_page}}".
 *
 * @property integer $id
 * @property string $title
 * @property string $description
 * @property string $text
 * @property integer $hidden
 * @property string $createdAt
 * @property string $updatedAt
 *
 */
class ProductPage extends \yii\db\ActiveRecord implements HiddenAttributeInterface, StorageInterface
{
    use HiddenAttributeTrait;

    /**
     * @var UploadedFile|StorageDto
     */
    private $image;

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
    public function behaviors()
    {
        return [
            'TimestampBehavior' => TimestampBehavior::class,
            'StorageBehaviorImage' => [
                'class' => StorageBehavior::class,
                'attribute' => 'image',
                'scenarios' => [
                    self::SCENARIO_DEFAULT,
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
        return '{{%product_page}}';
    }

    /**
     * @inheritdoc
     */
    public function rules()
    {
        return [
            [['title', 'description'], 'required'],
            [['text'], 'string'],
            [['hidden'], 'integer'],
            [['createdAt', 'updatedAt'], 'safe'],
            [['title'], 'string', 'max' => 255],
            [['description'], 'string', 'max' => 512],
            [
                ['image'],
                'image',
                'extensions' => 'jpg, png',
                'skipOnEmpty' => true,
                'minWidth' => 400,
                'minHeight' => 400,
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
            'title' => 'Заголовок',
            'description' => 'Описание',
            'text' => 'Полное описание',
            'image' => 'Изображение',
            'hidden' => 'Заблокировано',
            'createdAt' => 'Создано',
            'updatedAt' => 'Обновлено',
        ];
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
     * @return int Model id
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
     * @return string
     */
    public function getImageUrl()
    {
        if (!$this->image) {
            return '/static/asd/img/fish/advice.jpg';
        }
        $filesystem = Yii::createObject(\League\Flysystem\FilesystemInterface::class);

        return $filesystem->getPublicUrl($this->image->getSrc(), ['w' => 400, 'h' => 400, 'fit' => 'crop']);
    }

}
