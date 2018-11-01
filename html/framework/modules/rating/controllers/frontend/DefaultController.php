<?php

namespace app\modules\rating\controllers\frontend;

use app\interfaces\RatingInterface;
use app\modules\rating\models\Rating;
use krok\system\components\frontend\Controller;
use Yii;
use yii\db\ActiveRecord;
use yii\web\BadRequestHttpException;
use yii\web\Response;

/**
 * Default controller for the `rating` module
 */
class DefaultController extends Controller
{
    public $enableCsrfValidation = false;

    /**
     * @return array|string
     * @throws \yii\web\BadRequestHttpException
     * @throws \yii\base\InvalidConfigException
     */
    public function actionRating()
    {
        if (Yii::$app->request->isAjax) {
            Yii::$app->response->format = Response::FORMAT_JSON;

            $module = Yii::$app->request->post('module');
            $record_id = Yii::$app->request->post('record_id');
            $rating = Yii::$app->request->post('rating');


            if ($rating === null) {
                return '';
            }
            if (empty($rating)) {
                $rating = 0;
            }

            $user_id = null;
            $user_ip = null;
            $user_ip = Yii::$app->request->userIP;

            $model = Yii::createObject($module);
            if ($model instanceof ActiveRecord) {
                $record = $model::findOne($record_id);
            } else {
                throw new BadRequestHttpException('Bad module');
            }
            if ($record instanceof RatingInterface) {
                $title = $record->getTitle();
            } else {
                throw new BadRequestHttpException('Bad record');
            }

            $session = Yii::$app->session;

            if (!$session->isActive) {
                $session->open();
            }
            $sessionId = md5(Yii::$app->session->Id);
            $model = Rating::findOne(['sessionId' => $sessionId, 'record_id' => $record_id]);
            if ($model) {
                $model->rating = $rating;
            } else {
                $model = new Rating([
                    'title' => $title,
                    'module' => $module,
                    'record_id' => $record_id,
                    'user_ip' => $user_ip,
                    'user_id' => $user_id,
                    'rating' => $rating,
                    'sessionId' => $sessionId,
                ]);
            }
            if ($model->save()) {
                $rating = Rating::getAvgRating($module, $record_id);
                return [
                    'status' => 'ok',
                    'rating' => $rating,
                ];
            } else {
                return [
                    'status' => 'error',
                ];
            }
        }
        return '';
    }
}
