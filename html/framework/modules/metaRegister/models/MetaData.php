<?php

namespace app\modules\metaRegister\models;

use krok\extend\behaviors\TimestampBehavior;

/**
 * This is the model class for table "{{%meta_data}}".
 *
 * @property integer $id
 * @property integer $metaId
 * @property string $name
 * @property string $value
 * @property string $createdAt
 * @property string $updatedAt
 *
 * @property Meta $meta
 */
class MetaData extends \yii\db\ActiveRecord
{
    /**
     * @inheritdoc
     */
    public static function tableName()
    {
        return '{{%meta_data}}';
    }

    /**
     * @param $id
     *
     * @return MetaData[]|array
     */
    public static function pullData($id)
    {
        return MetaData::find()->where(['metaId' => $id])->all();
    }

    /**
     * @inheritdoc
     * @return MetaDataQuery the active query used by this AR class.
     */
    public static function find()
    {
        return new MetaDataQuery(get_called_class());
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
            [['metaId', 'name'], 'required'],
            [['metaId'], 'integer'],
            [['value'], 'string'],
            [['createdAt', 'updatedAt'], 'safe'],
            [['name'], 'string', 'max' => 64],
            [
                ['metaId'],
                'exist',
                'skipOnError' => true,
                'targetClass' => Meta::className(),
                'targetAttribute' => ['metaId' => 'id'],
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
            'metaId' => 'Meta ID',
            'name' => 'Название',
            'value' => 'Значение',
            'createdAt' => 'Создано',
            'updatedAt' => 'Обновлено',
        ];
    }

    /**
     * @return \yii\db\ActiveQuery
     */
    public function getMeta()
    {
        return $this->hasOne(Meta::className(), ['id' => 'metaId']);
    }
}
