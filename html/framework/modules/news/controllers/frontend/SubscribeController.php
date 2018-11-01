<?php

namespace app\modules\news\controllers\frontend;

use app\modules\feedback\models\Feedback;
use app\modules\news\components\MailSender;
use app\modules\news\models\Subscribe;
use app\modules\news\Module;
use app\modules\packet\models\Packet;
use krok\system\components\frontend\Controller;
use yii;
use yii\helpers\Url;
use yii\web\NotFoundHttpException;
use yii\web\Response;

/**
 * Class SubscribeController
 *
 * @property MailSender mailer
 * @property \app\modules\feedback\models\SettingsMail sender
 * @package app\modules\news\controllers\frontend
 */
class SubscribeController extends Controller
{
    /**
     * SubscribeController constructor.
     * @param $id
     * @param Module $module
     * @param MailSender $mailer
     * @param array $config
     */

    private $mailer;

    private $sender;

    public function __construct($id, Module $module, MailSender $mailer, array $config = [])
    {
        $this->mailer = $mailer->getMailer();
        $this->sender = $mailer->getSettings();
        parent::__construct($id, $module, $config);
    }

    /**
     * Сборщик подписчиков
     *
     * @return array
     */
    public function actionAjax()
    {
        Yii::$app->response->format = Response::FORMAT_JSON;
        $subscribe = new Subscribe();
        $subscribe->load(Yii::$app->request->post());
        $subscribe->setAttribute('ip', Yii::$app->request->getUserIP());

        if ($subscribe->save()) {

            $message = $this->mailer->compose('mail-to-sender', [
                'now' => new \DateTime(),
                'unsubscribeUrl' => Url::to('/news/subscribe/unsubscribe-email?email=' . $subscribe->email . '&hash=' . $subscribe->hash, true),
            ]);
            $message->setSubject('Вы успешно подписались на рассылку!')
                ->setFrom([$this->sender->username => $this->sender->sender_name])
                ->setTo($subscribe->email)
                ->send();

            $response = [
                'response' => ['success' => 1],
            ];

            return $response;
        } else {
            $response = [
                'response' => ['success' => 0, 'errors' => $subscribe->getErrors()],
            ];

            return $response;
        }
    }

    /**
     * @param $email
     * @param $packet
     * @return string
     * @throws NotFoundHttpException
     */
    public function actionUnsubscribe($email, $packet)
    {
        $model = null;

        $packet = Packet::findOne($packet);
        if ($packet) {
            $model = $packet->getRecipientQuery()->andWhere(['email' => $email])->one();
            if ($model) {
                return $this->render('unsubscribe', ['model' => $model, 'packet' => $packet]);
            } else {
                throw new NotFoundHttpException('The requested page does not exist.');
            }
        } else {
            throw new NotFoundHttpException('The requested page does not exist.');
        }


    }

    /**
     * @param $email
     * @param $hash
     * @return string
     * @throws NotFoundHttpException
     */
    public function actionUnsubscribeEmail($email, $hash)
    {
        $model = null;

        $model = Subscribe::find()->where(['email' => $email, 'hash' => $hash])->one();
        if ($model) {
            return $this->render('unsubscribe-email', ['model' => $model]);
        } else {
            throw new NotFoundHttpException('The requested page does not exist.');
        }

    }

    /**
     * @param $email
     * @param $packet
     * @return string
     * @throws NotFoundHttpException
     */
    public function actionUnsubscribeUser($email, $packet)
    {
        $model = null;
        $packet = Packet::findOne($packet);
        if ($packet) {

            switch ($packet->category) {
                case Packet::CATEGORY_NEWS:
                    Subscribe::updateAll(['unsubscribe' => 1], [
                        'email' => $email,
                        'type' => [Subscribe::TYPE_SUBSCRIBE_NEWSCARD, Subscribe::TYPE_SUBSCRIBE_NEWSLIST]
                    ]);
                    break;
                case Packet::CATEGORY_ADVICE:
                    Subscribe::updateAll(['unsubscribe' => 1], [
                        'email' => $email,
                        'type' => [Subscribe::TYPE_SUBSCRIBE_ADVICECARD, Subscribe::TYPE_SUBSCRIBE_ADVICELIST]
                    ]);
                    break;
                case Packet::CATEGORY_FEEDBACK:
                    Feedback::updateAll(['unsubscribe' => 1], [
                        'email' => $email,
                        ['msg_type' => Feedback::FTYPE_MESSAGE]
                    ]);
                    break;
                case Packet::CATEGORY_PRODUCT:
                    Feedback::updateAll(['unsubscribe' => 1], [
                        'email' => $email,
                        ['msg_type' => Feedback::FTYPE_ORDER]
                    ]);
                    break;
            }


        } else {
            throw new NotFoundHttpException('The requested page does not exist.');
        }

        return $this->render('unsubscribe-user', ['packet' => $packet]);

    }

    /**
     * @param $email
     * @param $hash
     * @return string
     */
    public function actionUnsubscribeUserEmail($email, $hash)
    {
        Subscribe::updateAll(['unsubscribe' => 1], [
            'email' => $email,
            'hash' => $hash
        ]);
        return $this->render('unsubscribe-user');
    }

}
