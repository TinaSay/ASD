<?php

namespace app\modules\metaRegister\models;

use krok\extend\behaviors\TimestampBehavior;

/**
 * This is the model class for table "{{%meta}}".
 *
 * @property integer $id
 * @property string $model
 * @property integer $recordId
 * @property string $type
 * @property string $createdAt
 * @property string $updatedAt
 *
 * @property MetaData[] $metaDatas
 */
class Meta extends \yii\db\ActiveRecord
{
    /**
     * @inheritdoc
     */
    public static function tableName()
    {
        return '{{%meta}}';
    }

    /**
     * @inheritdoc
     * @return MetaQuery the active query used by this AR class.
     */
    public static function find()
    {
        return new MetaQuery(get_called_class());
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
            'TimestampBehavior' => [
                'class' => TimestampBehavior::class,
            ],
        ];
    }

    /**
     * @inheritdoc
     */
    public function rules()
    {
        return [
            [['model', 'recordId'], 'required'],
            [['recordId'], 'integer'],
            [['createdAt', 'updatedAt'], 'safe'],
            [['model'], 'string', 'max' => 128],
            [['type'], 'string', 'max' => 64],
            [['model', 'recordId'], 'unique', 'targetAttribute' => ['model', 'recordId']],
        ];
    }

    /**
     * @inheritdoc
     */
    public function attributeLabels()
    {
        return [
            'id' => 'ID',
            'model' => 'Модель',
            'recordId' => 'ID записи',
            'type' => 'Тип метатегов',
            'createdAt' => 'Создано',
            'updatedAt' => 'Обновлено',
        ];
    }

    /**
     * @return \yii\db\ActiveQuery
     */
    public function getMetaDatas()
    {
        return $this->hasMany(MetaData::className(), ['metaId' => 'id']);
    }
}
