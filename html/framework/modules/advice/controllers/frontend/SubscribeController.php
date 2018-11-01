<?php

namespace app\modules\advice\controllers\frontend;

use app\modules\news\models\Subscribe;
use krok\system\components\frontend\Controller;
use yii;
use yii\web\Response;

/**
 * Class SubscribeController
 *
 * @package app\modules\news\controllers\frontend
 */
class SubscribeController extends Controller
{
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
        $subscribe->setIp($_SERVER['REMOTE_ADDR']);


        if ($subscribe->save()) {
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
}
