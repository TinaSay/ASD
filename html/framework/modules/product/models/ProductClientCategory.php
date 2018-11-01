<?php

namespace app\modules\product\models;

use app\modules\product\traits\DropDownTrait;
use app\modules\product\traits\IconTrait;
use krok\extend\behaviors\TagDependencyBehavior;
use krok\extend\behaviors\TimestampBehavior;
use krok\extend\interfaces\HiddenAttributeInterface;
use krok\extend\traits\HiddenAttributeTrait;
use krok\storage\behaviors\StorageBehavior;
use krok\storage\interfaces\StorageInterface;
use yii\db\ActiveRecord;

/**
 * This is the model class for table "{{%product_client_categorys}}".
 *
 * @property integer $id
 * @property string $uuid
 * @property string $title
 * @property integer $hidden
 * @property string $createdAt
 * @property string $updatedAt
 */
class ProductClientCategory extends ActiveRecord implements HiddenAttributeInterface, StorageInterface
{
    use HiddenAttributeTrait, DropDownTrait, IconTrait;

    const SCENARIO_IMPORT = 'import';

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
        return '{{%product_client_category}}';
    }

    /**
     * @return array
     */
    public function behaviors()
    {
        return [
            'TimestampBehavior' => TimestampBehavior::class,
            'TagDependencyBehavior' => TagDependencyBehavior::class,
            'StorageBehaviorIcon' => [
                'class' => StorageBehavior::class,
                'attribute' => 'icon',
                'scenarios' => [
                    self::SCENARIO_DEFAULT,
                    self::SCENARIO_IMPORT,
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
            [['title'], 'required'],
            [['hidden'], 'integer'],
            [['createdAt', 'updatedAt'], 'safe'],
            [['uuid'], 'string', 'max' => 36],
            [['title'], 'string', 'max' => 255],
            [['uuid'], 'unique', 'on' => [static::SCENARIO_IMPORT]],
            [['uuid'], 'required', 'on' => [static::SCENARIO_IMPORT]],
            [
                ['icon'],
                'checkMimeType',
                'params' => [
                    'mimeTypes' => [
                        'image/jpeg',
                        'image/png',
                        'image/gif',
                        'image/svg+xml',
                    ],
                    'skipOnEmpty' => true,
                ],
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
            'uuid' => 'UID',
            'title' => 'Название',
            'hidden' => 'Заблокировано',
            'createdAt' => 'Created At',
            'updatedAt' => 'Updated At',
            'icon' => 'Иконка',
        ];
    }

}
