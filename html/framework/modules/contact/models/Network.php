<?php
/**
 * Copyright (c) Rustam
 */

namespace app\modules\contact\models;

use app\modules\contact\validators\SvgPngValidator;
use krok\extend\behaviors\TagDependencyBehavior;
use krok\extend\behaviors\TimestampBehavior;
use krok\extend\interfaces\HiddenAttributeInterface;
use krok\extend\traits\HiddenAttributeTrait;
use krok\storage\behaviors\StorageBehavior;
use krok\storage\dto\StorageDto;
use krok\storage\interfaces\StorageInterface;
use League\Flysystem\FilesystemInterface;
use yii;
use yii\db\ActiveRecord;

/**
 * This is the model class for table "{{%network}}".
 *
 * @property integer $id
 * @property string $title
 * @property string $url
 * @property string $icon
 * @property integer $hidden
 */
class Network extends ActiveRecord implements HiddenAttributeInterface, StorageInterface
{
    use HiddenAttributeTrait;

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
        return '{{%network}}';
    }

    /**
     * @inheritdoc
     */
    public function rules()
    {
        return [
            [['title'], 'required'],
            [['hidden'], 'integer'],
            [['title', 'url'], 'string', 'max' => 255],
            [
                'icon',
                SvgPngValidator::class,
                'maxWidth' => 40,
                'maxHeight' => 40,
                'extensions' => 'svg,png',
                'checkExtensionByMimeType' => false,
            ],
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
                'attribute' => 'icon',
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
    public function attributeLabels()
    {
        return [
            'id' => 'ID',
            'title' => 'Заголовок',
            'url' => 'Ссылка',
            'icon' => 'Иконка',
            'hidden' => 'Заблокировано',
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

    public
    function getHint(): ?string
    {
        return null;
    }

    /**
     * @param $src
     */
    public function setSrc($src)
    {
        $this->icon = $src;
    }

    /**
     * @return string
     */
    public function getSrc()
    {
        return $this->icon;
    }

    /**
     * @return string
     */
    public function getImage()
    {
        $filesystem = Yii::createObject(FilesystemInterface::class);

        if ($this->icon instanceof StorageDto) {
            return $filesystem->getDownloadUrl($this->icon->getSrc());
        }

        return '';
    }

    /**
     * @return string
     */
    public function getUrl()
    {
        $w = "a-z0-9";
        $url_pattern = "#( 
                (?:f|ht)tps?://(?:www.)? 
                (?:[$w\\-.]+/?\\.[a-z]{2,4})/? 
                (?:[$w\\-./\\#]+)? 
                (?:\\?[$w\\-&=;\\#]+)? 
                )#xi";
        if (preg_match($url_pattern, $this->url) == true) {
            return $this->url;
        } elseif (preg_match('/\./', $this->url)) {
            return 'http://' . $this->url;
        } else {
            return Yii::$app->getHomeUrl() . ltrim($this->url, '/');
        }
    }

    /**
     * @return Network[]|array
     */
    public static function getList()
    {
        return self::find()->where(['hidden' => self::HIDDEN_NO])->orderBy(['title' => SORT_ASC])->all();
    }

    /**
     * @inheritdoc
     * @return NetworkQuery the active query used by this AR class.
     */
    public static function find()
    {
        return new NetworkQuery(get_called_class());
    }
}
