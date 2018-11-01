<?php

namespace app\modules\advice\models;

/**
 * This is the model class for table "{{%advice_group_rel}}".
 *
 * @property integer $adviceId
 * @property integer $groupId
 *
 * @property Advice $advice
 * @property Advice $group
 */
class AdviceGroupRel extends \yii\db\ActiveRecord
{
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
        return '{{%advice_group_rel}}';
    }

    /**
     * @inheritdoc
     */
    public function rules()
    {
        return [
            [['adviceId', 'groupId'], 'integer'],
            [
                ['adviceId'],
                'exist',
                'skipOnError' => true,
                'targetClass' => Advice::class,
                'targetAttribute' => ['adviceId' => 'id'],
            ],
            [
                ['groupId'],
                'exist',
                'skipOnError' => true,
                'targetClass' => Advice::class,
                'targetAttribute' => ['groupId' => 'id'],
            ],
        ];
    }

    /**
     * @inheritdoc
     */
    public function attributeLabels()
    {
        return [
            'adviceId' => 'Advice ID',
            'groupId' => 'Group ID',
        ];
    }

    /**
     * @return \yii\db\ActiveQuery
     */
    public function getAdvice()
    {
        return $this->hasOne(Advice::class, ['id' => 'adviceId']);
    }

    /**
     * @return \yii\db\ActiveQuery
     */
    public function getGroup()
    {
        return $this->hasOne(Advice::class, ['id' => 'groupId']);
    }

    /**
     * @inheritdoc
     * @return AdviceGroupRelQuery the active query used by this AR class.
     */
    public static function find()
    {
        return new AdviceGroupRelQuery(get_called_class());
    }
}
