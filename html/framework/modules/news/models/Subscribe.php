<?php

namespace app\modules\news\models;

use krok\extend\behaviors\TimestampBehavior;
use yii\helpers\ArrayHelper;

/**
 * This is the model class for table "subscribe".
 *
 * @property integer $id
 * @property string $email
 * @property string $country
 * @property string $city
 * @property string $ip
 * @property integer $unsubscribe
 * @property string $hash
 */
class Subscribe extends \yii\db\ActiveRecord
{


    const TYPE_SUBSCRIBE_NEWSLIST = 1;
    const TYPE_SUBSCRIBE_NEWSCARD = 2;
    const TYPE_SUBSCRIBE_ADVICELIST = 3;
    const TYPE_SUBSCRIBE_ADVICECARD = 4;

    const UNSUBSCRIBE_NO = 0;
    const UNSUBSCRIBE_YES = 1;


    public static function getTypeSubscribeList()
    {
        return [
            self::TYPE_SUBSCRIBE_NEWSLIST => 'Список новостей',
            self::TYPE_SUBSCRIBE_NEWSCARD => 'Карточка новости',
            self::TYPE_SUBSCRIBE_ADVICELIST => 'Список советов',
            self::TYPE_SUBSCRIBE_ADVICECARD => 'Карточка совета',
        ];
    }

    /**
     * @return string
     */
    public function getTypeSubscribe()
    {
        return ArrayHelper::getValue(static::getTypeSubscribeList(), $this->type);
    }

    public static function getUnsubscribeList()
    {
        return [
            self::UNSUBSCRIBE_NO => 'Нет',
            self::UNSUBSCRIBE_YES => 'Да',
        ];
    }

    /**
     * @return mixed
     */
    public function getUnsubscribe()
    {
        return ArrayHelper::getValue(self::getUnsubscribeList(), $this->unsubscribe);
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

    public function behaviors()
    {
        return [
            'TimestampBehavior' => [
                'class' => TimestampBehavior::class,
                'createdAtAttribute' => 'createdAt',
                'updatedAtAttribute' => 'updatedAt',
            ],
        ];
    }

    /**
     * @inheritdoc
     */
    public static function tableName()
    {
        return '{{%subscribe}}';
    }

    /**
     * @inheritdoc
     */
    public function rules()
    {
        return [
            [['email'], 'required'],
            [['createdAt', 'type', 'link', 'country', 'city'], 'safe'],
            [['unsubscribe'], 'integer'],
            ['unsubscribe', 'default', 'value' => '0'],
            ['hash', 'filter', 'filter' => function ($value) {
                return $value ?: md5($this->email . time());
            }],
        ];
    }

    /**
     * @return string
     */
    public function getIp()
    {
        return $this->ip;
    }

    /**
     * @inheritdoc
     */
    public function attributeLabels()
    {
        return [
            'id' => 'ID',
            'email' => 'Email',
            'country' => 'Страна',
            'city' => 'Город',
            'type' => 'Источник',
            'createdAt' => 'Добавлен',
            'unsubscribe' => 'Отписан',
        ];
    }

    /**
     * @inheritdoc
     * @return SubscribeQuery the active query used by this AR class.
     */
    public static function find()
    {
        return new SubscribeQuery(get_called_class());
    }
}
