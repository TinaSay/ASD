<?php

namespace app\modules\auth\controllers\backend;

use app\modules\auth\models\Auth;
use app\modules\auth\models\Login;
use app\modules\auth\models\OAuth;
use krok\system\components\backend\Controller;
use Yii;
use yii\authclient\ClientInterface;
use yii\db\Exception;
use yii\helpers\ArrayHelper;

/**
 * Class DefaultController
 *
 * @package app\modules\auth\controllers\backend
 */
class DefaultController extends Controller
{
    /**
     * @var string
     */
    public $layout = '@vendor/yii2-developer/yii2-system/views/backend/layouts/login.php';

    /**
     * @return array
     */
    public function actions()
    {
        return [
            'captcha' => [
                'class' => 'yii\captcha\CaptchaAction',
                'fixedVerifyCode' => YII_ENV_TEST ? 'cmf2' : null,
            ],
            'oauth' => ArrayHelper::merge(
                [
                    'class' => 'yii\authclient\AuthAction',
                    'successCallback' => [$this, 'OAuthCallback'],
                ],
                Yii::$app->getUser()->getIsGuest() ? [] : [
                    'successUrl' => Yii::$app->getUrlManager()->createAbsoluteUrl(['/auth/social']),
                    'cancelUrl' => Yii::$app->getUrlManager()->createAbsoluteUrl(['/auth/social']),
                ]
            ),
        ];
    }

    /**
     * @param ClientInterface $client
     *
     * @throws \yii\db\Exception
     */
    public function OAuthCallback(ClientInterface $client)
    {
        $attributes = $client->getUserAttributes();

        /* @var $OAuth OAuth */
        $OAuth = OAuth::find()->where([
            'source' => $client->getId(),
            'source_id' => $attributes['id'],
        ])->one();

        if (Yii::$app->getUser()->getIsGuest()) {
            if ($OAuth instanceof OAuth) {
                // login
                if ($OAuth->auth->blocked == Auth::BLOCKED_NO) {
                    Yii::$app->getUser()->login($OAuth->auth);
                } else {
                    Yii::$app->getSession()->addFlash('danger', 'Ваш аккаунт заблокирован');
                }
            } else {
                // signUp
                if (isset($attributes['login']) && Auth::find()->where(['login' => $attributes['login']])->exists()) {
                    Yii::$app->getSession()->addFlash('danger',
                        sprintf('Пользователь %s совпадает с учетной записью %s, но не связан с ней',
                            $attributes['login'], $client->getTitle()));
                } else {
                    $password = Yii::$app->getSecurity()->generateRandomString(8);
                    $auth = new Auth([
                        'login' => $attributes['login'],
                        'password' => $password,
                        'email' => ArrayHelper::getValue($attributes, 'email'),
                        'blocked' => Auth::BLOCKED_YES,
                    ]);
                    $transaction = Auth::getDb()->beginTransaction();
                    if ($auth->save()) {
                        $OAuth = new OAuth([
                            'auth_id' => $auth->id,
                            'source' => $client->getId(),
                            'source_id' => (string)$attributes['id'],
                        ]);
                        if ($OAuth->save()) {
                            $transaction->commit();
                            if ($auth->blocked == Auth::BLOCKED_NO) {
                                Yii::$app->getUser()->login($auth);
                            } else {
                                Yii::$app->getSession()->addFlash('success',
                                    'Ваш аккаунт зарегистрирован, дождитесь его активации администратором');
                            }
                        } else {
                            $transaction->rollBack();
                            throw new Exception('', $OAuth->getErrors());
                        }
                    } else {
                        $transaction->rollBack();
                        throw new Exception('', $auth->getErrors());
                    }
                }
            }
        } else {
            // user already logged in
            if (!($OAuth instanceof OAuth)) {
                // add user provider
                $OAuth = new OAuth([
                    'auth_id' => Yii::$app->getUser()->getId(),
                    'source' => $client->getId(),
                    'source_id' => (string)$attributes['id'],
                ]);
                if ($OAuth->save()) {
                    Yii::$app->getSession()->addFlash('success',
                        sprintf('Аккаунт <b>%s</b> привязан к социальной сети <b>%s</b>',
                            ArrayHelper::getValue(Yii::$app->getUser()->getIdentity(), 'login'), $client->getTitle()));
                } else {
                    throw new Exception('', $OAuth->getErrors());
                }
            } elseif ($OAuth->auth_id == Yii::$app->getUser()->getId()) {
                Yii::$app->getSession()->addFlash('info',
                    sprintf('Аккаунт <b>%s</b> уже привязан к социальной сети <b>%s</b>',
                        ArrayHelper::getValue(Yii::$app->getUser()->getIdentity(), 'login'), $client->getTitle()));
            } else {
                Yii::$app->getSession()->addFlash('danger',
                    sprintf('Социальная сеть <b>%s</b> уже привязана к другому аккаунту', $client->getTitle()));
            }
        }
    }

    /**
     * @return string|\yii\web\Response
     */
    public function actionLogin()
    {
        if (!Yii::$app->getUser()->getIsGuest()) {
            return $this->redirect(Yii::$app->getUser()->getReturnUrl());
        }

        $model = new Login();

        if ($model->load(Yii::$app->getRequest()->post()) && $model->login()) {
            return $this->redirect(Yii::$app->getUser()->getReturnUrl());
        }

        return $this->render(
            'login',
            [
                'model' => $model,
            ]
        );
    }

    /**
     * @return \yii\web\Response
     */
    public function actionLogout()
    {
        Yii::$app->getUser()->logout(false);

        return $this->goHome();
    }
}
