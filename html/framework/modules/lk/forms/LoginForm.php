<?php
namespace app\modules\lk\forms;

use Yii;
use yii\base\Model;

/**
 * Class LoginForm
 * @package app\modules\lk\forms
 */
class LoginForm extends Model
{
    public $login;
    public $password;

    public function rules()
    {
        return [
            [['login', 'password'], 'required'],
            [['password'], 'string', 'max' => 60, 'min' => 8, 'tooShort' => 'Пароль минимум 8 символов'],
            ['password', 'validatePassword']
        ];
    }

    /**
     * Validates the username and password.
     * This method serves as the inline validation for password.
     */
    public function validatePassword()
    {
        if (!$this->hasErrors()) {
            if(!Yii::$app->session->has('user')) {
                $this->addError('password', Yii::t('system', 'Error, wrong username or password'));
            }
        }
    }

    public function attributeLabels()
    {
        return [
            'login' => 'Логин',
            'password' => 'Пароль',
        ];
    }

    /**
     * @return bool
     */
    public function login()
    {
        if($this->validate()) {
            if (Yii::$app->session->has('user')) {
                return true;
            }
        }
        return false;
    }

}