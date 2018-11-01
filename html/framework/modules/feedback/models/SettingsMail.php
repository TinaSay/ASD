<?php
/**
 * Created by PhpStorm.
 * User: alfred
 * Date: 13.02.18
 * Time: 17:50
 */

namespace app\modules\feedback\models;

use app\modules\feedback\components\PostcardConfig;
use Yii;
use yii\base\Model;

/**
 * Class SettingsMail
 *
 * @property string $host
 * @property string $username
 * @property string $password
 * @property string $port
 * @property string $encryption
 * @property string $hidden_password
 * @property string $sender_name
 * @package app\modules\reception\models
 */
class SettingsMail extends Model
{
    const HIDDEN_PASSWORD = '********';
    const CONFIG_FILE = 'mail.cfg';

    /**
     * @var string
     */
    public $host = '';

    /**
     * @var string
     */
    public $username = '';

    /**
     * @var string
     */
    public $password = '';

    /**
     * @var integer
     */
    public $port = '';

    /**
     * @var string
     */
    public $encryption = '';

    /**
     * @var string
     */
    public $hidden_password = '';

    /** @var string */
    public $sender_name = '';

    /**
     * @var string
     */
    private $_encryptKey = 'super_key';

    /**
     * @inheritdoc
     */
    public function rules()
    {
        return [
            [
                [
                    'sender_name',
                    'host',
                    'username',
                    'hidden_password',
                    'port'
                ],
                'required'
            ],
            [
                [
                    'sender_name',
                    'host',
                    'username',
                    'password',
                    'encryption',
                    'hidden_password',
                ],
                'string'
            ],
            ['port', 'integer'],
            ['username', 'email'],
        ];
    }

    /**
     * @return bool|string
     */
    private function decryptPassword()
    {
        return Yii::$app->security->decryptByPassword($this->password, $this->_encryptKey);
    }

    /**
     * @param string $password
     *
     * @return string
     */
    private function encryptPassword($password)
    {
        return Yii::$app->security->encryptByPassword($password, $this->_encryptKey);
    }

    /**
     * @inheritdoc
     */
    public function attributeLabels()
    {
        return [
            'sender_name' => Yii::t('system', 'Sender name'),
            'host' => Yii::t('system', 'Host'),
            'username' => Yii::t('system', 'Login'),
            'password' => Yii::t('system', 'Password'),
            'hidden_password' => Yii::t('system', 'Password'),
            'port' => Yii::t('system', 'Port'),
            'encryption' => Yii::t('system', 'Encryption'),
        ];
    }

    /**
     * Загрузка настроек из файла
     *
     * @return array
     */
    public function loadSettings()
    {
        $this->attributes = PostcardConfig::load(self::CONFIG_FILE, [
            'host' => '',
            'username' => '',
            'password' => '',
            'port' => '',
            'encryption' => ''
        ]);

        $this->password = $this->decryptPassword();
        $this->hidden_password = self::HIDDEN_PASSWORD;

        return $this->getAttributes([
            'host',
            'username',
            'password',
            'port',
            'encryption'
        ]);
    }

    /**
     * Сохранение настроек в файл
     *
     * @return boolean
     */
    public function saveSettings()
    {
        if (strcmp($this->hidden_password, self::HIDDEN_PASSWORD)) {
            $this->password = $this->encryptPassword($this->hidden_password);
        } else {
            $this->password = $this->encryptPassword($this->password);
        }
        $this->hidden_password = self::HIDDEN_PASSWORD;

        return PostcardConfig::save(self::CONFIG_FILE, $this->toArray());
    }
}
