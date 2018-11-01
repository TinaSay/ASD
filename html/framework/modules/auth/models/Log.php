<?php

namespace app\modules\auth\models;

use krok\extend\behaviors\IpBehavior;
use krok\extend\behaviors\TimestampBehavior;
use yii\helpers\ArrayHelper;

/**
 * This is the model class for table "{{%auth_log}}".
 *
 * @property integer $id
 * @property integer $auth_id
 * @property integer $status
 * @property integer $ip
 * @property string $created_at
 * @property string $updated_at
 *
 * @property Auth $auth
 */
class Log extends \yii\db\ActiveRecord
{
    const STATUS_LOGGED = 1;
    const STATUS_LOGOUT = 2;

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
            'IpBehavior' => IpBehavior::class,
        ];
    }

    /**
     * @inheritdoc
     */
    public static function tableName()
    {
        return '{{%auth_log}}';
    }

    /**
     * @inheritdoc
     */
    public function rules()
    {
        return [
            [['auth_id', 'status', 'ip'], 'integer'],
            [['created_at', 'updated_at'], 'safe'],
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
            'status' => 'Статус',
            'ip' => 'IP',
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

    /**
     * @return array
     */
    public static function getStatusList()
    {
        return [
            self::STATUS_LOGGED => 'Вход',
            self::STATUS_LOGOUT => 'Выход',
        ];
    }

    /**
     * @return mixed
     */
    public function getStatus()
    {
        return ArrayHelper::getValue(self::getStatusList(), $this->status);
    }

    /**
     * @return array
     */
    public static function getAuthList()
    {
        static $list = null;

        if ($list === null) {
            $list = ArrayHelper::map(Auth::find()->asArray()->all(), 'id', 'login');
        }

        return $list;
    }

    /**
     * @inheritdoc
     * @return LogQuery the active query used by this AR class.
     */
    public static function find()
    {
        return new LogQuery(get_called_class());
    }
}
