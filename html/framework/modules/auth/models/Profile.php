<?php
/**
 * Created by PhpStorm.
 * User: krok
 * Date: 19.07.17
 * Time: 23:54
 */

namespace app\modules\auth\models;

use krok\extend\behaviors\GenerateRandomStringBehavior;
use krok\extend\behaviors\HashBehavior;
use krok\extend\behaviors\TimestampBehavior;
use Yii;

/**
 * Class Profile
 *
 * @package app\modules\auth\models
 */
class Profile extends Auth
{
    /**
     * @var null
     */
    public $password_new = null;

    /**
     * @var null|Auth
     */
    protected $auth = null;

    /**
     * @return array
     */
    public function behaviors()
    {
        return [
            'HashBehaviorPassword' => [
                'class' => HashBehavior::class,
                'attribute' => 'password',
                'value' => function () {
                    return Yii::$app->getSecurity()->generatePasswordHash($this->password_new);
                },
            ],
            'GenerateRandomStringBehaviorAuthKey' => [
                'class' => GenerateRandomStringBehavior::class,
                'attribute' => 'auth_key',
                'stringLength' => 128,
            ],
            'GenerateRandomStringBehaviorAccessToken' => [
                'class' => GenerateRandomStringBehavior::class,
                'attribute' => 'access_token',
                'stringLength' => 128,
            ],
            'TimestampBehavior' => [
                'class' => TimestampBehavior::class,
                'createdAtAttribute' => 'created_at',
                'updatedAtAttribute' => 'updated_at',
            ],
        ];
    }

    /**
     * @return array
     */
    public function rules()
    {
        return [
            [['password', 'password_new'], 'string', 'max' => 512, 'min' => 8],
            [['password', 'password_new'], 'required'],
            ['password', 'authorization'],
        ];
    }

    /**
     * @return array
     */
    public function attributeLabels()
    {
        return [
            'password' => 'Пароль',
            'password_new' => 'Новый пароль',
        ];
    }

    public function authorization()
    {
        if (!$this->hasErrors()) {
            if (!$this->getAuth() || !Yii::$app->getSecurity()->validatePassword($this->password,
                    $this->getAuth()->password)
            ) {
                $this->addError('password', 'Неправильный пароль');
            }
        }
    }

    /**
     * @return Auth
     */
    public function getAuth()
    {
        if ($this->auth === null) {
            $this->auth = Yii::$app->getUser()->getIdentity();
        }

        return $this->auth;
    }
}
