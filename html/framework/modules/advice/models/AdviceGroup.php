<?php

namespace app\modules\advice\models;

use app\modules\auth\models\Auth;
use krok\extend\behaviors\CreatedByBehavior;
use krok\extend\behaviors\LanguageBehavior;
use krok\extend\behaviors\TagDependencyBehavior;
use krok\extend\behaviors\TimestampBehavior;
use krok\extend\interfaces\HiddenAttributeInterface;
use krok\extend\traits\HiddenAttributeTrait;
use krok\logging\interfaces\LoggingInterface;
use yii\helpers\ArrayHelper;

/**
 * This is the model class for table "{{%advice_group}}".
 *
 * @property integer $id
 * @property string $title
 * @property integer $hidden
 * @property string $language
 * @property integer $createdBy
 * @property string $createdAt
 * @property string $updatedAt
 *
 * @property advice[] $advices
 * @property Auth $createdByRelation
 */
class AdviceGroup extends \yii\db\ActiveRecord implements HiddenAttributeInterface, LoggingInterface
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
        return '{{%advice_group}}';
    }

    /**
     * @inheritdoc
     */
    public function rules()
    {
        return [
            [['title'], 'required'],
            [['hidden', 'createdBy'], 'integer'],
            [['createdAt', 'updatedAt'], 'safe'],
            [['title'], 'string', 'max' => 256],
            [
                ['createdBy'],
                'exist',
                'skipOnError' => true,
                'targetClass' => Auth::class,
                'targetAttribute' => ['createdBy' => 'id'],
            ],
            [['language'], 'string', 'max' => 8],
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
            'hidden' => 'Заблокировано',
            'createdBy' => 'Создана',
            'createdAt' => 'Создана',
            'updatedAt' => 'Обновлена',
            'language' => 'Язык',
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
            'LanguageBehavior' => LanguageBehavior::class,
        ];
    }

    /**
     * @return \yii\db\ActiveQuery
     */
    public function getAdvice()
    {
        return $this->hasMany(Advice::class, ['group' => 'id']);
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
    public function getAdvices()
    {
        return $this->hasMany(Advice::class, ['id' => 'adviceId'])
            ->viaTable(AdviceGroupRel::tableName(), ['groupId' => 'id'])->andWhere([Advice::tableName() . '.[[hidden]]' => self::HIDDEN_NO]);
    }

    /**
     * @param int $hidden
     *
     * @return int
     */
    public static function getFirstId($hidden = self::HIDDEN_NO)
    {
        return self::find()->where('id>0')->andWhere(['hidden' => $hidden])->language()->one()->id;
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

    /**
     * @return array
     */
    public static function getActualList()
    {
        return self::find()->select([
            self::tableName() . '.[[title]]',
            self::tableName() . '.[[id]]',
        ])->andFilterWhere([
            self::tableName() . '.[[hidden]]' => self::HIDDEN_NO,
        ])->joinWith('advices', false, 'INNER JOIN')
            ->indexBy('id')
            ->orderBy([self::tableName() . '.[[title]]' => SORT_ASC])
            ->column();
    }

    /**
     * @return string
     */
    public function getLoggingTitle(): string
    {
        return $this->title;
    }

    /**
     * @inheritdoc
     * @return AdviceGroupQuery the active query used by this AR class.
     */
    public static function find()
    {
        return new AdviceGroupQuery(get_called_class());
    }
}
