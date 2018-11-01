<?php

namespace app\modules\auth\models;

use krok\extend\behaviors\TimestampBehavior;

/**
 * This is the model class for table "{{%auth_oauth}}".
 *
 * @property integer $id
 * @property integer $auth_id
 * @property string $source
 * @property string $source_id
 * @property string $created_at
 * @property string $updated_at
 *
 * @property Auth $auth
 */
class OAuth extends \yii\db\ActiveRecord
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
     * @return array
     */
    public function behaviors()
    {
        return [
            'TimestampBehavior' => [
                'class' => TimestampBehavior::class,
                'createdAtAttribute' => 'created_at',
                'updatedAtAttribute' => 'updated_at',
            ],
        ];
    }

    /**
     * @inheritdoc
     */
    public static function tableName()
    {
        return '{{%auth_oauth}}';
    }

    /**
     * @inheritdoc
     */
    public function rules()
    {
        return [
            [['auth_id', 'source', 'source_id'], 'required'],
            [['auth_id'], 'integer'],
            [['created_at', 'updated_at'], 'safe'],
            [['source', 'source_id'], 'string', 'max' => 256],
            [
                ['auth_id'],
                'exist',
                'skipOnError' => true,
                'targetClass' => Auth::class,
                'targetAttribute' => ['auth_id' => 'id'],
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
            'auth_id' => 'Пользователь',
            'source' => 'Социальная сеть',
            'source_id' => 'Пользователь в социальной сети',
            'created_at' => 'Создано',
            'updated_at' => 'Обновлено',
        ];
    }

    /**
     * @return \yii\db\ActiveQuery
     */
    public function getAuth()
    {
        return $this->hasOne(Auth::class, ['id' => 'auth_id']);
    }
}
