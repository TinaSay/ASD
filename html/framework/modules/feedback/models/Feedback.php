<?php

namespace app\modules\feedback\models;

use app\modules\product\models\Product;
use krok\extend\behaviors\TimestampBehavior;
use yii\helpers\ArrayHelper;

/**
 * This is the model class for table "feedback".
 *
 * @property integer $id
 * @property string $date_add
 * @property integer $msg_type
 * @property string $fio
 * @property string $phone
 * @property string $email
 * @property string $company
 * @property string $text
 * @property string $country
 * @property string $city
 * @property string $date_sent
 * @property integer $status
 * @property integer $confirm
 * @property string $route
 * @property integer $productId
 * @property string $date_edited
 * @property string $callTime
 * @property integer $unsubscribe
 * @property Product $product
 */
class Feedback extends \yii\db\ActiveRecord
{
    const FSTATUS_NOT_PROCESSED = 1;
    const FSTATUS_IN_PROGRES = 2;
    const FSTATUS_PROCESSED = 3;

    const FTYPE_CALLBACK = 1;
    const FTYPE_MESSAGE = 2;
    const FTYPE_ORDER = 3;

    const FLD_CREATED_AT = 'date_add';
    const FLD_UPDATED_AT = 'date_edited';

    const ROUTE_INDEX_PAGE = 'content/default/index';
    const ROUTE_CONTACT_PAGE = 'contact/division/index';
    const ROUTE_COOPERATION_PAGE = 'cooperation/default/index';
    const ROUTE_ABOUT_PAGE = 'about/default/index';
    const ROUTE_INDEX_LEFT_BLOCK = 'index/left/block';
    const ROUTE_PRODUCT = 'product/catalog/view';

    const UNSUBSCRIBE_NO = 0;
    const UNSUBSCRIBE_YES = 1;

    /**
     * @inheritdoc
     */
    public static function tableName()
    {
        return '{{%feedback}}';
    }

    /**
     * @return array
     */
    public static function getStatusList()
    {
        return [
            self::FSTATUS_NOT_PROCESSED => 'Не обработано',
            self::FSTATUS_IN_PROGRES => 'В обработке',
            self::FSTATUS_PROCESSED => 'Обработано',
        ];
    }

    /**
     * @return array
     */
    public static function getRouteList()
    {
        return [
            self::ROUTE_INDEX_PAGE => 'Главная страница',
            self::ROUTE_CONTACT_PAGE => 'Контакты',
            self::ROUTE_COOPERATION_PAGE => 'Сотрудничество',
            self::ROUTE_ABOUT_PAGE => 'Компания',
            self::ROUTE_INDEX_LEFT_BLOCK => 'Боковой блок',
            self::ROUTE_PRODUCT => 'Карточка товара',
        ];
    }

    /**
     * @return mixed
     */
    public function getRoute()
    {
        return ArrayHelper::getValue(self::getRouteList(), $this->route);
    }


    /**
     * @return array
     */
    public static function getMsgTypeList()
    {
        return [
            self::FTYPE_CALLBACK => 'Обратный звонок',
            self::FTYPE_MESSAGE => 'Сообщение',
            self::FTYPE_ORDER => 'Заказ товара',
        ];
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
     * @return mixed
     */
    public function getStatus()
    {
        return ArrayHelper::getValue(self::getStatusList(), $this->status);
    }

    /**
     * @return mixed
     */
    public function getMsgType()
    {
        return ArrayHelper::getValue(self::getMsgTypeList(), $this->msg_type);
    }

    /**
     * @inheritdoc
     */
    public function behaviors()
    {
        return [
            'TimestampBehavior' => [
                'class' => TimestampBehavior::class,
                'createdAtAttribute' => static::FLD_CREATED_AT,
                'updatedAtAttribute' => static::FLD_UPDATED_AT,
            ],
        ];
    }

    /**
     * @inheritdoc
     */
    public function rules()
    {
        return [
            ['fio', 'required', 'message' => 'Укажите ваше настоящее имя'],
            ['fio', 'string', 'message' => 'Укажите ваше настоящее имя', 'min' => 3],
            ['phone', 'required', 'message' => 'Укажите корректный номер телефона'],
            ['city', 'string', 'message' => 'Укажите Ваш город'],
            ['country', 'string', 'message' => 'Укажите Вашу страну'],
            [['company', 'confirm', 'route'], 'safe'],
            [['status', 'confirm', 'unsubscribe'], 'integer'],
            ['status', 'default', 'value' => '1'],
            ['unsubscribe', 'default', 'value' => '0'],
            ['msg_type', 'default', 'value' => '1'],
            ['email', 'email', 'message' => 'Укажите корректный e-mail'],
            [['email', 'text', 'callTime'], 'default', 'value' => ''],
            [['date_add', 'callTime'], 'string'],
            [
                ['productId'],
                'exist',
                'skipOnError' => true,
                'targetClass' => Product::class,
                'targetAttribute' => ['productId' => 'id'],
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
            'fio' => 'Имя',
            'email' => 'E-mail',
            'status' => 'Статус',
            'phone' => 'Контактный телефон',
            'company' => 'Компания',
            'country' => 'Страна',
            'city' => 'Город',
            'date_add' => 'Дата получения',
            'date_edited' => 'Дата редактирования',
            'date_sent' => 'Дата отправки',
            'msg_type' => 'Тип сообщения',
            'route' => 'Источник',
            'productId' => 'Товар',
            'callTime' => 'Время звонка',
            'unsubscribe' => 'Отписан',
        ];
    }

    /**
     * @return \yii\db\ActiveQuery
     */
    public function getProduct()
    {
        return $this->hasOne(Product::class, ['id' => 'productId']);
    }

    /**
     * @param bool $runValidation
     * @param null $attributeNames
     *
     * @return bool
     */
    public function save($runValidation = true, $attributeNames = null)
    {
        return parent::save($runValidation, $attributeNames);
    }
}
