<?php
/**
 * Created by PhpStorm.
 * User: Rustam
 * Date: 06.07.2018
 * Time: 20:30
 */

namespace app\modules\news\components;

use app\modules\feedback\models\SettingsMail;
use Yii;
use yii\mail\MailerInterface;
use yii\swiftmailer\Mailer;

class MailSender extends Mailer implements MailerInterface
{
    public $mailerConfigTemplate = [
        'class' => '\yii\swiftmailer\Mailer',
        'transport' => [
            'class' => 'Swift_SmtpTransport',
            'host' => '',
            'username' => '',
            'password' => '',
            'port' => '',
            'encryption' => ''
        ]
    ];

    /** @var Mailer $mailer */
    public $mailer;

    /** @var SettingsMail $settingsMail */
    public $settings;

    public function getMailer()
    {
        $this->settings = new SettingsMail();
        $this->mailerConfigTemplate['transport'] = array_merge(
            $this->mailerConfigTemplate['transport'],
            $this->settings->loadSettings()
        );
        $this->mailer = yii::createObject($this->mailerConfigTemplate);
        return $this->mailer;
    }

    public function getSettings()
    {
        return $this->settings;
    }
}