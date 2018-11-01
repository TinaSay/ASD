<?php
/**
 * Created by PhpStorm.
 * User: Rustam
 * Date: 25.10.2017
 * Time: 16:05
 */

namespace app\modules\feedback\controllers\frontend;

use app\modules\feedback\models\Feedback;
use app\modules\feedback\models\FeedbackSettings;
use app\modules\feedback\models\SettingsMail;
use krok\system\components\frontend\Controller;
use Yii;
use yii\filters\VerbFilter;
use yii\swiftmailer\Mailer;
use yii\web\NotFoundHttpException;
use yii\web\Response;

/**
 * Class SiteController
 *
 * @package app\controllers
 */
class DefaultController extends Controller
{
    /**
     * @var string
     */
    public $layout = '//index';

    public $mailerConfig = [
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
    protected $mailer;

    /** @var SettingsMail $settingsMail */
    protected $settingsMail;
    /**
     * @inheritdoc
     */
    public function behaviors()
    {
        return [
            'verbs' => [
                'class' => VerbFilter::class,
                'actions' => [
                    'delete' => ['POST'],
                ],
            ],
        ];
    }

    /**
     * @inheritdoc
     */
    public function actions()
    {
        return [
            'error' => [
                'class' => \yii\web\ErrorAction::class,
            ],
        ];
    }

    /**
     * Displays homepage.
     *
     * @return string
     */
    public function actionIndex()
    {
        // mini feedback form action...
        if (Yii::$app->request->post()) {
            $model = new Feedback();
            $model->load(Yii::$app->request->post());
            if ($model->save() && $this->sendEmail(
                    FeedbackSettings::find()->select(['value'])
                        ->where(['name' => FeedbackSettings::CALL_SETTINGS])
                        ->scalar(),
                    'Новая заявка с сайта ASD на обратный звонок',
                    'call-email',
                    $model
                )) {
                return $this->render('succes-saved', [
                    'model' => $model,
                ]);
            } else {
                return $this->render('index', [
                    'model' => $model, // форма с данными
                ]);
            }
        }

        return $this->render('index', [
            'model' => new Feedback(), // пустая форма для ввода
        ]);
    }

    /**
     * @return Response
     */
    public function actionAjax()
    {
        $sent = $updated = false;

        $model = new Feedback();
        // mini ajax feedback form action...
        if ($model->load(Yii::$app->request->post())) {

               $saved = $model->save();

                switch ($model->msg_type) {
                    case Feedback::FTYPE_CALLBACK:
                        $sent = $this->sendEmail(
                            FeedbackSettings::find()->select(['value'])
                                ->where(['name' => FeedbackSettings::CALL_SETTINGS])
                                ->scalar(),
                            'Новая заявка с сайта ASD на обратный звонок',
                            'call-email',
                            $model
                        );
                        break;
                    case Feedback::FTYPE_MESSAGE:
                        $sent = $this->sendEmail(
                            FeedbackSettings::find()->select(['value'])
                                ->where(['name' => FeedbackSettings::EMAIL_SETTINGS])
                                ->scalar(),
                            'Новое сообщение с сайта ASD',
                            'message-email',
                            $model
                        );
                        break;
                    case Feedback::FTYPE_ORDER:
                        $sent = $this->sendEmail(
                            FeedbackSettings::find()->select(['value'])
                                ->where(['name' => FeedbackSettings::ORDER_EMAIL_SETTINGS])
                                ->scalar(),
                            'Новая заявка на товар с сайта ASD',
                            'order-email',
                            $model
                        );
                        break;
                }


            return $this->asJson($saved && $sent ? ['success' => true] : [
                'success' => false,
                'errors' => $model->getErrors(),
                'sent' => $sent,
            ]);
        }

        return $this->asJson(['success' => false]);
    }

    /**
     * @return string
     */
    public function actionFull()
    {
        if (Yii::$app->request->post()) {

            $model = new Feedback();
            $model->load(Yii::$app->request->post());

            if ($model->save() && $this->sendEmail(
                    FeedbackSettings::find()->select(['value'])
                        ->where(['name' => FeedbackSettings::EMAIL_SETTINGS])
                        ->scalar(),
                    'Новое сообщение с сайта ASD',
                    'message-email',
                    $model
                )) {
                return $this->render('succes-saved', [
                    'model' => $model,
                ]);
            } else {
                return $this->render('index-full', [
                    'model' => $model, // форма с данными
                ]);
            }
        }

        return $this->render('index-full', [
            'model' => new Feedback(), // пустая форма для ввода
        ]);
    }

    /**
     * Deletes an existing model.
     * If deletion is successful, the browser will be redirected to the 'index' page.
     *
     * @param integer $id
     *
     * @return mixed
     * @throws NotFoundHttpException
     * @throws \Exception
     * @throws \Throwable
     * @throws \yii\db\StaleObjectException
     */
    public function actionDelete($id)
    {
        $this->findModel($id)->delete();

        return $this->redirect(['index']);
    }

    /**
     * @param $emails
     * @param string $subject
     * @param string $template
     * @param Feedback $model
     *
     * @return bool
     */
    protected function sendEmail($emails, string $subject, string $template, Feedback $model)
    {


        $countSent = 0;
        if ($emails) {
            $validator = new yii\validators\EmailValidator();

            $emails = preg_replace('/\s/', '', $emails);
            $emails = explode(',', $emails);
            if (is_array($emails) && count($emails) > 0) {
                foreach ($emails as $email) {
                    if ($validator->validate($email, $error)) {
                        $mail = $this->getMailer()->compose($template, ['model' => $model])
                            ->setFrom([$this->settingsMail->username => $this->settingsMail->sender_name])
                            ->setTo($email)
                            ->setSubject($subject);
                        if ($mail->send()) {
                            $countSent++;
                        }

                    } else {
                        return false;
                    }
                }
                if ($countSent > 0) {
                    return true;
                }
            } else {
                return false;
            }
        }

        return false;
    }

    public function getMailer()
    {
        $this->settingsMail = new SettingsMail();
        $this->mailerConfig['transport'] = array_merge(
            $this->mailerConfig['transport'],
            $this->settingsMail->loadSettings()
        );
        $this->mailer = Yii::createObject($this->mailerConfig);
        return $this->mailer;
    }

    /**
     * Finds the Dish model based on its primary key value.
     * If the model is not found, a 404 HTTP exception will be thrown.
     *
     * @param integer $id
     *
     * @return Feedback the loaded model
     * @throws NotFoundHttpException if the model cannot be found
     */
    protected function findModel($id)
    {
        if (($model = Feedback::findOne($id)) !== null) {
            return $model;
        } else {
            throw new NotFoundHttpException('The requested page does not exist.');
        }
    }
}
