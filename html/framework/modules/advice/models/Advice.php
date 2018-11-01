<?php

namespace app\modules\advice\models;

use app\interfaces\RatingInterface;
use app\modules\auth\models\Auth;
use app\modules\meta\adapters\AdviceOpenGraphAdapter;
use krok\extend\behaviors\CreatedByBehavior;
use krok\extend\behaviors\LanguageBehavior;
use krok\extend\behaviors\TagDependencyBehavior;
use krok\extend\behaviors\TimestampBehavior;
use krok\extend\interfaces\HiddenAttributeInterface;
use krok\extend\traits\HiddenAttributeTrait;
use krok\logging\interfaces\LoggingInterface;
use krok\meta\behaviors\MetaBehavior;
use krok\storage\behaviors\StorageBehavior;
use krok\storage\dto\StorageDto;
use krok\storage\interfaces\StorageInterface;
use League\Flysystem\FilesystemInterface;
use tina\metatag\behaviors\MetatagBehavior;
use voskobovich\behaviors\ManyToManyBehavior;
use yii;
use yii\helpers\ArrayHelper;

/**
 * This is the model class for table "{{%advice}}".
 *
 * @property integer $id
 * @property integer $group
 * @property string $title
 * @property integer $directionReform
 * @property string $announce
 * @property string $text
 * @property string $date
 * @property integer $hidden
 * @property string $language
 * @property integer $createdBy
 * @property string $createdAt
 * @property string $updatedAt
 *
 * @property Auth $createdByRelation
 * @property AdviceGroup[] $groupRelation
 */
class Advice extends \yii\db\ActiveRecord implements HiddenAttributeInterface, StorageInterface, LoggingInterface, RatingInterface
{
    use HiddenAttributeTrait;

    public $meta;

    /**
     * @var yii\web\UploadedFile|StorageDto
     */
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
        return '{{%advice}}';
    }

    /**
     * @inheritdoc
     */
    public function rules()
    {
        return [
            [['group', 'hidden', 'createdBy'], 'integer'],
            [['title', 'announce', 'text'], 'required'],
            [['announce', 'text'], 'string'],
            [['date', 'createdAt', 'updatedAt', 'group'], 'safe'],
            [['title'], 'string', 'max' => 250],
            [['announce'], 'string', 'max' => 700],
            [['language'], 'string', 'max' => 8],
            [
                ['createdBy'],
                'exist',
                'skipOnError' => true,
                'targetClass' => Auth::class,
                'targetAttribute' => ['createdBy' => 'id'],
            ],

            [['groupIDs'], 'each', 'rule' => ['integer']],


        ];
    }

    /**
     * @inheritdoc
     */
    public function attributeLabels()
    {
        return [
            'id' => 'ID',
            'group' => 'Категория',
            'directionReform' => 'Направление реформ',
            'src' => 'Изображение',
            'title' => 'Заголовок',
            'announce' => 'Анонс',
            'text' => 'Текст',
            'date' => 'Дата',
            'tagsIDs' => 'Теги',
            'groupIDs' => 'Категории',
            'language' => 'Язык',
            'hidden' => 'Заблокировано',
            'createdBy' => 'Создана',
            'createdAt' => 'Создана',
            'updatedAt' => 'Обновлена',
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
                    'groupIDs' => 'groupRelation',
                ],
            ],
            'LanguageBehavior' => LanguageBehavior::class,
            'MetatagBehavior' => [
                'class' => MetatagBehavior::class,
                'metaAttribute' => 'meta',
            ],
            'MetaBehavior' => [
                'class' => MetaBehavior::class,
                'adapters' => [
                    AdviceOpenGraphAdapter::class,
                ],
            ],
        ];
    }

    /**
     * @return \yii\db\ActiveQuery
     */
    public function getCreatedByRelation()
    {
        return $this->hasOne(Auth::class, ['id' => 'createdBy']);
    }


    /**
     * @return \yii\db\ActiveQuery
     */
    public function getGroupRelation()
    {
        return $this->hasMany(AdviceGroup::class, ['id' => 'groupId'])
            ->viaTable(AdviceGroupRel::tableName(),
                ['adviceId' => 'id']);
    }

    /**
     * @return string
     */
    public function getGroupsString()
    {
        $list = ArrayHelper::getColumn($this->groupRelation, 'title');
        if (count($list) > 0) {
            return implode(', ', $list);
        } else {
            return "Ничего не выбрано";
        }

    }

    /**
     * @return array
     */
    public function getGroupsArray()
    {
        return ArrayHelper::map($this->groupRelation, 'id', 'title');
    }

    /**
     * @return string
     */
    public function getGroups1PlusString()
    {
        $plus = '';
        $groups = ArrayHelper::getColumn($this->groupRelation, 'title');

        $groups = self::sortGroups($groups);
        if (!$groups) {
            return '';
        }
        if (count($groups) > 1) {
            $plus = ' +' . (count($groups) - 1);
        }

        return $groups[0] . $plus;
    }

    public function sortGroups($groups)
    {
        $id = (int)Yii::$app->request->get('group');
        if ($id <= 0) {
            return $groups;
        } // вернули не измененный массив

        $group = AdviceGroup::findOne($id);
        if (in_array($group->title, $groups)) {
            ArrayHelper::removeValue($groups, $group->title);
        }

        return ArrayHelper::merge([$group->title], $groups);

    }


    /**
     * @return string
     */
    public function getGroups3PlusString()
    {
        $plus = '';
        $groups = ArrayHelper::getColumn($this->groupRelation, 'title');
        $groups = self::sortGroups($groups);
        if (!$groups) {
            return '';
        }
        if (count($groups) > 3) {
            $plus = ' +' . (count($groups) - 3);
        }
        $threeGroups = array_slice($groups, 0, 3);

        return implode(', ', $threeGroups) . $plus;
    }

    /**
     * @inheritdoc
     * @return AdviceQuery the active query used by this AR class.
     */
    public static function find()
    {
        return new AdviceQuery(get_called_class());
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
     * @return string
     */
    public function getTitle(): string
    {
        return $this->title;
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

    /**
     * @return string
     */
    public function getImage()
    {
        $filesystem = Yii::createObject(FilesystemInterface::class);

        if ($this->src instanceof StorageDto) {
            return $filesystem->getPublicUrl($this->src->getSrc());
        }

        return '';
    }

    public function getMainWidgetImage()
    {
        $filesystem = Yii::createObject(FilesystemInterface::class);
        if ($this->src instanceof StorageDto) {
            return $filesystem->getPublicUrl($this->src->getSrc(), ['w' => 500, 'h' => 250]);
        }

        return '';
    }

    public function getBigWidgetImage()
    {
        $filesystem = Yii::createObject(FilesystemInterface::class);
        if ($this->src instanceof StorageDto) {
            return $filesystem->getPublicUrl($this->src->getSrc(), ['w' => 500, 'h' => 500]);
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
}
