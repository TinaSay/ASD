<?php

namespace app\modules\feedback\controllers\backend;

use app\modules\feedback\models\FeedbackSettings;
use yii;
use yii\base\Model;
use yii\filters\VerbFilter;
use yii\web\Response;
use yii\widgets\ActiveForm;


/**
 * FeedbackController implements the CRUD actions for Feedback model.
 */
class SettingsController extends DefaultController
{
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
     * Lists all Feedback models.
     *
     * @return mixed
     */
    public function actionIndex()
    {


        if (Yii::$app->request->isPost) {

            $models = [];
            $request = Yii::$app->getRequest();
            if ($request->isPost && $request->post('ajax') !== null) {
                $data = Yii::$app->request->post('FeedbackSettings', []);
                foreach (array_keys($data) as $index) {
                    $models[$index] = new FeedbackSettings();
                }
                Model::loadMultiple($models, Yii::$app->request->post());
                Yii::$app->response->format = Response::FORMAT_JSON;
                $result = ActiveForm::validateMultiple($models);

                return $result;
            }

            $settings = FeedbackSettings::find()->indexBy('id')->all();
            if (Model::loadMultiple($settings, Yii::$app->request->post())) {
                foreach ($settings as $setting) {
                    $setting->save(false);
                }
            }
        }

        return $this->render('index', [
            'models' => FeedbackSettings::find()->where([
                'name' => [
                    FeedbackSettings::CALL_SETTINGS,
                    FeedbackSettings::EMAIL_SETTINGS,
                    FeedbackSettings::TITLE_SETTINGS,
                    FeedbackSettings::SUBTITLE_SETTINGS,
                    FeedbackSettings::ORDER_EMAIL_SETTINGS,
                    FeedbackSettings::PRIVACY_POLICY,
                ],
            ])->indexBy('id')->orderBy(['label' => SORT_ASC])
                ->all(),
            'textModel' => FeedbackSettings::find()
                ->where(['name' => FeedbackSettings::TEXT_SETTINGS])
                ->indexBy('id')->all(),
        ]);
    }


}
