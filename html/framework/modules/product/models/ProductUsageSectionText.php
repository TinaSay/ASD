<?php

namespace app\modules\product\models;

use app\modules\meta\adapters\OpenGraphAdapter;
use app\modules\product\meta\adapters\UsageSectionTemplateAdapter;
use krok\extend\behaviors\LanguageBehavior;
use krok\extend\behaviors\TagDependencyBehavior;
use krok\extend\behaviors\TimestampBehavior;
use krok\extend\interfaces\HiddenAttributeInterface;
use krok\extend\traits\HiddenAttributeTrait;
use krok\meta\behaviors\MetaBehavior;
use tina\metatag\behaviors\MetatagBehavior;
use tina\metatag\models\Metatag;

/**
 * This is the model class for table "{{%product_usage_section_text}}".
 *
 * @property integer $id
 * @property integer $usageId
 * @property integer $sectionId
 * @property string $title
 * @property string $text
 * @property integer $hidden
 * @property string $language
 * @property string $createdAt
 * @property string $updatedAt
 *
 * @property ProductSection $section
 * @property ProductUsage $usage
 */
class ProductUsageSectionText extends \yii\db\ActiveRecord implements HiddenAttributeInterface
{
    use HiddenAttributeTrait;

    /**
     * @var Metatag|null
     */
    public $meta;

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
        return '{{%product_usage_section_text}}';
    }

    /**
     * @return array
     */
    public function behaviors()
    {
        return [
            'TimestampBehavior' => TimestampBehavior::class,
            'TagDependencyBehavior' => TagDependencyBehavior::class,
            'LanguageBehavior' => LanguageBehavior::class,
            'MetatagBehavior' => [
                'class' => MetatagBehavior::class,
                'metaAttribute' => 'meta',
            ],
            'MetaBehavior' => [
                'class' => MetaBehavior::class,
                'adapters' => [
                    OpenGraphAdapter::class,
                    UsageSectionTemplateAdapter::class,
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
            [['usageId', 'sectionId', 'hidden'], 'integer'],
            [['title', 'text', 'usageId', 'sectionId'], 'required'],
            [['text'], 'string'],
            [['createdAt', 'updatedAt'], 'safe'],
            [['title'], 'string', 'max' => 255],
            [['language'], 'string', 'max' => 8],
            [
                ['sectionId'],
                'exist',
                'skipOnError' => true,
                'targetClass' => ProductSection::class,
                'targetAttribute' => ['sectionId' => 'id'],
            ],
            [
                ['usageId'],
                'exist',
                'skipOnError' => true,
                'targetClass' => ProductUsage::class,
                'targetAttribute' => ['usageId' => 'id'],
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
            'usageId' => 'Сфера применения',
            'sectionId' => 'Раздел каталога',
            'title' => 'Заголовок',
            'text' => 'Текст',
            'hidden' => 'Заблокировано',
            'createdAt' => 'Создано',
            'updatedAt' => 'Обновлено',
        ];
    }

    /**
     * @return \yii\db\ActiveQuery
     */
    public function getSection()
    {
        return $this->hasOne(ProductSection::class, ['id' => 'sectionId']);
    }

    /**
     * @return \yii\db\ActiveQuery
     */
    public function getUsage()
    {
        return $this->hasOne(ProductUsage::class, ['id' => 'usageId']);
    }

}
